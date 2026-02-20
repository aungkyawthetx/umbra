<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Core/Database.php';

class ProfileController extends Controller
{
    public function update()
    {
        require_auth();
        verify_csrf();

        $db = Database::connect();
        $bio = trim($_POST['bio'] ?? '');
        $bio = $bio === '' ? null : $bio;

        if ($bio !== null && strlen($bio) > 101) {
            http_response_code(422);
            echo "Bio must be 101 characters or fewer";
            return;
        }

        $stmt = $db->prepare("UPDATE users SET bio = ? WHERE id = ?");
        $stmt->execute([$bio, $_SESSION['user']['id']]);

        header("Location: /profile?username=" . urlencode($_SESSION['user']['username']) . "&updated=1");
    }

    public function show()
    {
        require_auth();

        $username = $_GET['username'] ?? null;
        $authUser = auth();
        if (!$username) {
            http_response_code(400);
            echo "Username is required";
            return;
        }
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            http_response_code(404);
            echo "User not found";
            return;
        }

        if ($authUser && (int)$authUser['id'] === (int)$user['id']) {
            $stmt = $db->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
            $stmt->execute([$user['id']]);
        } else {
            $stmt = $db->prepare("
                SELECT * FROM posts 
                WHERE user_id = ?
                  AND (status = 'published' OR (status = 'scheduled' AND scheduled_at <= NOW()))
                ORDER BY created_at DESC
            ");
            $stmt->execute([$user['id']]);
        }
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $followersStmt = $db->prepare("SELECT COUNT(*) FROM reading_lists WHERE author_id = ?");
        $followersStmt->execute([$user['id']]);
        $followersCount = (int)$followersStmt->fetchColumn();

        $this->view('profile/show', compact('user', 'posts', 'authUser', 'followersCount'));
    }

    public function store()
    {
        require_auth();
        verify_csrf();
        $username = $_POST['username'] ?? null;
        if(!$username) {
            http_response_code(400);
            echo "Author username required";
            return;
        }
        $db = Database::connect();

        // Get author
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$author) {
            http_response_code(404);
            echo "Author not found";
            return;
        }

        $readerId = $_SESSION['user']['id'];
        // Prevent following yourself
        if ($readerId == $author['id']) {
            header("Location: /profile?username=$username");
            return;
        }

        $stmt = $db->prepare("INSERT IGNORE INTO reading_lists (reader_id, author_id) VALUES (?, ?)");
        $stmt->execute([$readerId, $author['id']]);
        
        header("Location: /profile?username=$username");
    }

    public function unfollow()
    {
        require_auth();
        verify_csrf();

        $username = $_POST['username'] ?? null;
        if (!$username) {
            http_response_code(400);
            echo "Author username required";
            return;
        }

        $db = Database::connect();
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$author) {
            http_response_code(404);
            echo "Author not found";
            return;
        }

        $readerId = $_SESSION['user']['id'];
        $stmt = $db->prepare("DELETE FROM reading_lists WHERE reader_id = ? AND author_id = ?");
        $stmt->execute([$readerId, $author['id']]);

        header("Location: /profile?username=$username");
    }

    public function readingList()
    {
        require_auth();
        $db = Database::connect();
        $readerId = $_SESSION['user']['id'];

        $authorsStmt = $db->prepare("
            SELECT users.id, users.name, users.username, users.bio
            FROM reading_lists rl
            JOIN users ON users.id = rl.author_id
            WHERE rl.reader_id = ?
            ORDER BY users.name ASC
        ");
        $authorsStmt->execute([$readerId]);
        $authors = $authorsStmt->fetchAll(PDO::FETCH_ASSOC);

        $postsStmt = $db->prepare("
            SELECT posts.*, users.name AS author_name, users.username
            FROM posts
            JOIN users ON users.id = posts.user_id
            WHERE posts.user_id IN (
                SELECT author_id FROM reading_lists WHERE reader_id = ?
            )
            AND (posts.status = 'published' OR (posts.status = 'scheduled' AND posts.scheduled_at <= NOW()))
            ORDER BY posts.created_at DESC
            LIMIT 20
        ");
        $postsStmt->execute([$readerId]);
        $posts = $postsStmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('reading-list/index', compact('authors', 'posts'));
    }
}
