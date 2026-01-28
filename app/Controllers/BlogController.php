<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Core/Database.php';

class BlogController extends Controller
{
    public function index()
    {
        $db = Database::connect();
        $posts = $db->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

        $this->view('blog/index', compact('posts'));
    }

    public function posts()
    {
        $db = Database::connect();
        $sql = "
            SELECT
                posts.*,
                users.id AS author_id,
                users.username,
                users.name
            FROM posts
            JOIN users ON users.id = posts.user_id
            ORDER BY posts.created_at DESC
        ";
        $posts = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        $this->view('posts/index', compact('posts'));
    }

    public function show()
    {
        $slug = $_GET['slug'];

        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM posts WHERE slug = ?");
        $stmt->execute([$slug]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->view('blog/show', compact('post'));
    }

    public function create()
    {
        require_auth();
        $this->view('blog/create');
    }

    public function store()
    {
        require_auth();
        $title   = $_POST['title'];
        $content = $_POST['content'];
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        // Image upload
        $imageName = null;
        if (!empty($_FILES['image']['name'])) {
            $imageName = time() . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../public/uploads/' . $imageName);
        }

        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO posts (user_id, title, slug, content, cover_image) VALUES (?, ?, ?, ?, ?)");

        // TEMP: user_id = 1 (until auth)
        $stmt->execute([1, $title, $slug, $content, $imageName]);

        header("Location: /");
    }

}
