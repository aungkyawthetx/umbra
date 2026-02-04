<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Core/Database.php';

class ProfileController extends Controller
{
    public function show()
    {
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

        $stmt = $db->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user['id']]);
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('profile/show', compact('user', 'posts', 'authUser'));
    }

    public function store()
    {
        require_auth();
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
}