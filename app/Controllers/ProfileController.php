<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Core/Database.php';

class UserController extends Controller
{
    public function show()
    {
        $username = $_GET['username'] ?? null;
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

        $this->view('profile/show', compact('user', 'posts'));
    }
}