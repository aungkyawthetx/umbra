<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Core/Database.php';

class AuthController extends Controller
{
  public function registerForm()
  {
    require_guest();
    $this->view('auth/register');
  }

  public function register()
  {
    require_guest();
    verify_csrf();
    $db = Database::connect();

    $name = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'];

    if (!$name || !$username || !$email || !$password) {
      die('All fields are required');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      die('Invalid email');
    }

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
      die('Username may contain letters, numbers, and underscores only');
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)");

    try {
      $stmt->execute([$name, $username, $email, $hashedPassword]);
      header('Location: /login');
    } catch (PDOException $e) {
      die('Username or email already exists');
    }
  }

  public function loginForm()
  {
    require_guest();
    $this->view('auth/login');
  }

  public function login()
  {
    require_guest();
    verify_csrf();
    $db = Database::connect();

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (!$email || !$password) {
      die('All fields are required');
    }
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password'])) {
      die('Invalid credentials');
    }

    session_regenerate_id(true);
    $_SESSION['user'] = [
      'id' => $user['id'],
      'username' => $user['username'],
      'fullname' => $user['name']
    ];

    header('Location: /');
  }

  public function logout()
  {
    require_auth();
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
    header('Location: /');
  }
}
