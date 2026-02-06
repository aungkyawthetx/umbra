<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Core/Database.php';

class BlogController extends Controller
{
    public function index()
    {
        $db = Database::connect();
        $sql = "
            SELECT posts.*, users.name AS author_name,
                   GROUP_CONCAT(DISTINCT tags.name ORDER BY tags.name SEPARATOR ',') AS tags
            FROM posts
            LEFT JOIN users ON users.id = posts.user_id
            LEFT JOIN post_tags ON post_tags.post_id = posts.id
            LEFT JOIN tags ON tags.id = post_tags.tag_id
            WHERE (posts.status = 'published' OR (posts.status = 'scheduled' AND posts.scheduled_at <= NOW()))
            GROUP BY posts.id
            ORDER BY posts.created_at DESC
            LIMIT 3
        ";
        $posts = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        $this->view('blog/index', compact('posts'));
    }

    public function posts()
    {
        $db = Database::connect();
        $q = trim($_GET['q'] ?? '');
        $tag = trim($_GET['tag'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 6;
        $offset = ($page - 1) * $limit;

        $where = "WHERE (posts.status = 'published' OR (posts.status = 'scheduled' AND posts.scheduled_at <= NOW()))";
        $params = [];

        if ($q !== '') {
            $where .= " AND (posts.title LIKE :q OR posts.content LIKE :q)";
            $params[':q'] = '%' . $q . '%';
        }

        if ($tag !== '') {
            $where .= " AND EXISTS (
                SELECT 1 FROM post_tags pt
                JOIN tags t ON t.id = pt.tag_id
                WHERE pt.post_id = posts.id AND t.name = :tag
            )";
            $params[':tag'] = $tag;
        }

        $countSql = "SELECT COUNT(*) FROM posts $where";
        $countStmt = $db->prepare($countSql);
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();

        $sql = "
            SELECT posts.*,
                   users.id AS author_id,
                   users.username,
                   users.name
            FROM posts
            LEFT JOIN users ON users.id = posts.user_id
            $where
            ORDER BY posts.created_at DESC
            LIMIT :limit OFFSET :offset
        ";
        $stmt = $db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalPages = (int)ceil($total / $limit);

        $this->view('posts/index', compact('posts', 'total', 'page', 'totalPages', 'q', 'tag'));
    }

    public function show()
    {
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) {
            http_response_code(404);
            require __DIR__ . '/../../views/errors/404.php';
            return;
        }

        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT posts.*, users.name AS author_name,
                   GROUP_CONCAT(DISTINCT tags.name ORDER BY tags.name SEPARATOR ',') AS tags
            FROM posts
            LEFT JOIN users ON posts.user_id = users.id
            LEFT JOIN post_tags ON post_tags.post_id = posts.id
            LEFT JOIN tags ON tags.id = post_tags.tag_id
            WHERE posts.id = ?
            GROUP BY posts.id
        ");
        $stmt->execute([$id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            http_response_code(404);
            require __DIR__ . '/../../views/errors/404.php';
            return;
        }

        $isOwner = is_logged_in() && (int)$_SESSION['user']['id'] === (int)$post['user_id'];
        $isPublished = $post['status'] === 'published' || ($post['status'] === 'scheduled' && $post['scheduled_at'] && strtotime($post['scheduled_at']) <= time());

        if (!$isOwner && !$isPublished) {
            http_response_code(404);
            require __DIR__ . '/../../views/errors/404.php';
            return;
        }

        $commentsStmt = $db->prepare("
            SELECT comments.*, users.name AS author_name
            FROM comments
            LEFT JOIN users ON users.id = comments.user_id
            WHERE comments.post_id = ?
            ORDER BY comments.created_at DESC
        ");
        $commentsStmt->execute([$post['id']]);
        $comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);

        $likesStmt = $db->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
        $likesStmt->execute([$post['id']]);
        $likesCount = (int)$likesStmt->fetchColumn();

        $likedByUser = false;
        if (is_logged_in()) {
            $likeCheck = $db->prepare("SELECT 1 FROM likes WHERE post_id = ? AND user_id = ? LIMIT 1");
            $likeCheck->execute([$post['id'], $_SESSION['user']['id']]);
            $likedByUser = (bool)$likeCheck->fetchColumn();
        }
        
        $this->view('blog/show', compact('post', 'comments', 'likesCount', 'likedByUser'));
    }

    public function create()
    {
        require_auth();
        $this->view('blog/create');
    }

    public function store()
    {
        require_auth();
        verify_csrf();

        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $status = $_POST['status'] ?? 'published';
        $allowedStatuses = ['published', 'draft', 'scheduled'];
        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'draft';
        }
        $scheduledAt = $_POST['scheduled_at'] ?? null;
        $tags = $_POST['tags'] ?? '';

        if (!$title || !$content) {
            http_response_code(400);
            echo 'Title and content are required';
            return;
        }

        $slug = $this->uniqueSlug($title);
        $imageName = $this->handleImageUpload($_FILES['image'] ?? null);

        $db = Database::connect();
        $now = date('Y-m-d H:i:s');

        if ($status === 'scheduled' && !$scheduledAt) {
            $status = 'draft';
        }

        $publishedAt = null;
        if ($status === 'published') {
            $publishedAt = $now;
        } elseif ($status === 'scheduled' && $scheduledAt) {
            $publishedAt = $scheduledAt;
        }

        $stmt = $db->prepare("INSERT INTO posts (user_id, title, slug, content, cover_image, status, scheduled_at, published_at, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user']['id'],
            $title,
            $slug,
            $content,
            $imageName,
            $status,
            $scheduledAt ?: null,
            $publishedAt,
            $now,
            $now
        ]);

        $postId = (int)$db->lastInsertId();
        $this->syncTags($postId, $tags);

        header("Location: /posts");
    }

    public function edit()
    {
        require_auth();
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) {
            http_response_code(404);
            require __DIR__ . '/../../views/errors/404.php';
            return;
        }

        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ? LIMIT 1");
        $stmt->execute([$id, $_SESSION['user']['id']]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            http_response_code(404);
            require __DIR__ . '/../../views/errors/404.php';
            return;
        }

        $tagsStmt = $db->prepare("
            SELECT GROUP_CONCAT(t.name ORDER BY t.name SEPARATOR ',') AS tags
            FROM tags t
            JOIN post_tags pt ON pt.tag_id = t.id
            WHERE pt.post_id = ?
        ");
        $tagsStmt->execute([$id]);
        $tags = $tagsStmt->fetchColumn() ?: '';

        $this->view('blog/edit', compact('post', 'tags'));
    }

    public function update()
    {
        require_auth();
        verify_csrf();

        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $status = $_POST['status'] ?? 'published';
        $allowedStatuses = ['published', 'draft', 'scheduled'];
        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'draft';
        }
        $scheduledAt = $_POST['scheduled_at'] ?? null;
        $tags = $_POST['tags'] ?? '';

        if (!$id || !$title || !$content) {
            http_response_code(400);
            echo 'Invalid input';
            return;
        }

        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ? LIMIT 1");
        $stmt->execute([$id, $_SESSION['user']['id']]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            http_response_code(404);
            require __DIR__ . '/../../views/errors/404.php';
            return;
        }

        if ($status === 'scheduled' && !$scheduledAt) {
            $status = 'draft';
        }

        $imageName = $post['cover_image'];
        $newImage = $this->handleImageUpload($_FILES['image'] ?? null);
        if ($newImage) {
            $imageName = $newImage;
        }

        $now = date('Y-m-d H:i:s');
        $publishedAt = $post['published_at'];
        if ($status === 'published' && !$publishedAt) {
            $publishedAt = $now;
        } elseif ($status === 'scheduled' && $scheduledAt) {
            $publishedAt = $scheduledAt;
        }

        $update = $db->prepare("
            UPDATE posts
            SET title = ?, content = ?, cover_image = ?, status = ?, scheduled_at = ?, published_at = ?, updated_at = ?
            WHERE id = ? AND user_id = ?
        ");
        $update->execute([
            $title,
            $content,
            $imageName,
            $status,
            $scheduledAt ?: null,
            $publishedAt,
            $now,
            $id,
            $_SESSION['user']['id']
        ]);

        $this->syncTags($id, $tags);

        header("Location: /profile?username=" . urlencode($_SESSION['user']['username']));
    }

    public function delete()
    {
        require_auth();
        verify_csrf();

        $id = (int)($_POST['id'] ?? 0);
        if (!$id) {
            http_response_code(400);
            echo 'Invalid request';
            return;
        }

        $db = Database::connect();
        $stmt = $db->prepare("SELECT id FROM posts WHERE id = ? AND user_id = ? LIMIT 1");
        $stmt->execute([$id, $_SESSION['user']['id']]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            http_response_code(404);
            require __DIR__ . '/../../views/errors/404.php';
            return;
        }

        $db->prepare("DELETE FROM post_tags WHERE post_id = ?")->execute([$id]);
        $db->prepare("DELETE FROM comments WHERE post_id = ?")->execute([$id]);
        $db->prepare("DELETE FROM likes WHERE post_id = ?")->execute([$id]);
        $db->prepare("DELETE FROM posts WHERE id = ?")->execute([$id]);

        header("Location: /profile?username=" . urlencode($_SESSION['user']['username']));
    }

    public function comment()
    {
        require_auth();
        verify_csrf();

        $postId = (int)($_POST['post_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');

        if (!$postId || $content === '') {
            http_response_code(400);
            echo 'Invalid comment';
            return;
        }

        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$postId, $_SESSION['user']['id'], $content]);

        $isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);

        if ($isAjax) {
            $commentId = (int)$db->lastInsertId();
            $c = $db->prepare("
                SELECT comments.*, users.name AS author_name
                FROM comments
                LEFT JOIN users ON users.id = comments.user_id
                WHERE comments.id = ?
                LIMIT 1
            ");
            $c->execute([$commentId]);
            $comment = $c->fetch(PDO::FETCH_ASSOC);

            header('Content-Type: application/json');
            echo json_encode([
                'ok' => true,
                'comment' => [
                    'id' => (int)$comment['id'],
                    'author_name' => $comment['author_name'],
                    'content' => $comment['content'],
                    'created_at' => $comment['created_at']
                ]
            ]);
            return;
        }

        $postId = (int)($_POST['post_id'] ?? 0);
        header("Location: /blog/" . $postId);
    }

    public function like()
    {
        require_auth();
        verify_csrf();

        $postId = (int)($_POST['post_id'] ?? 0);
        if (!$postId) {
            http_response_code(400);
            echo 'Invalid request';
            return;
        }

        $db = Database::connect();
        $check = $db->prepare("SELECT 1 FROM likes WHERE post_id = ? AND user_id = ? LIMIT 1");
        $check->execute([$postId, $_SESSION['user']['id']]);
        $exists = (bool)$check->fetchColumn();

        if ($exists) {
            $db->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?")->execute([$postId, $_SESSION['user']['id']]);
        } else {
            $db->prepare("INSERT IGNORE INTO likes (post_id, user_id, created_at) VALUES (?, ?, NOW())")->execute([$postId, $_SESSION['user']['id']]);
        }

        $isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);

        if ($isAjax) {
            $likesStmt = $db->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
            $likesStmt->execute([$postId]);
            $likesCount = (int)$likesStmt->fetchColumn();

            header('Content-Type: application/json');
            echo json_encode([
                'ok' => true,
                'liked' => !$exists,
                'count' => $likesCount
            ]);
            return;
        }

        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/posts'));
    }

    private function uniqueSlug(string $title): string
    {
        $slug = trim(preg_replace('/[^\p{L}\p{N}]+/u', '-', $title));
        $slug = mb_strtolower($slug, 'UTF-8');

        $db = Database::connect();
        $base = $slug ?: 'post';
        $final = $base;
        $i = 1;
        $stmt = $db->prepare("SELECT 1 FROM posts WHERE slug = ? LIMIT 1");
        while (true) {
            $stmt->execute([$final]);
            if (!$stmt->fetch()) {
                break;
            }
            $i++;
            $final = $base . '-' . $i;
        }

        return $final;
    }

    private function handleImageUpload(?array $file): ?string
    {
        if (!$file || empty($file['name'])) {
            return null;
        }

        if (!empty($file['error']) && $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            return null;
        }

        $info = @getimagesize($file['tmp_name']);
        if (!$info) {
            return null;
        }

        $mime = $info['mime'] ?? '';
        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp'
        ];

        if (!isset($allowed[$mime])) {
            return null;
        }

        $ext = $allowed[$mime];
        $name = bin2hex(random_bytes(12)) . '.' . $ext;
        $target = __DIR__ . '/../../public/uploads/' . $name;

        if (!move_uploaded_file($file['tmp_name'], $target)) {
            return null;
        }

        return $name;
    }

    private function syncTags(int $postId, string $tags): void
    {
        $db = Database::connect();
        $db->prepare("DELETE FROM post_tags WHERE post_id = ?")->execute([$postId]);

        $tagList = array_filter(array_map(function ($t) {
            return trim(mb_strtolower($t, 'UTF-8'));
        }, explode(',', $tags)));

        foreach ($tagList as $tagName) {
            if ($tagName === '') {
                continue;
            }
            $stmt = $db->prepare("SELECT id FROM tags WHERE name = ? LIMIT 1");
            $stmt->execute([$tagName]);
            $tagId = $stmt->fetchColumn();
            if (!$tagId) {
                $insert = $db->prepare("INSERT INTO tags (name) VALUES (?)");
                $insert->execute([$tagName]);
                $tagId = $db->lastInsertId();
            }
            $db->prepare("INSERT IGNORE INTO post_tags (post_id, tag_id) VALUES (?, ?)")->execute([$postId, $tagId]);
        }
    }
}
