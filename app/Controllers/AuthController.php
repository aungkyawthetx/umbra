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
    $db = Database::connect();

    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$name || !$username || !$email || !$password) {
      die('All fields are required');
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
    $db = Database::connect();

    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!$email || !$password) {
      die('All fields are required');
    }
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password'])) {
      die('Invalid credentials');
    }

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
    session_destroy();
    header('Location: /');
  }
}
