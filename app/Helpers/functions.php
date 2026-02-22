<?php

  function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    if ($time < 60) return 'just now';
    if ($time < 3600) return floor($time / 60) . ' minutes ago';
    if ($time < 86400) return floor($time / 3600) . ' hours ago';
    return floor($time / 86400) . ' days ago';
  }

  function e($value): string
  {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
  }

  function base_url(): string
  {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    return $scheme . '://' . $host;
  }

  function current_url(bool $withQuery = true): string
  {
    $path = $_SERVER['REQUEST_URI'] ?? '/';
    if (!$withQuery) {
      $path = parse_url($path, PHP_URL_PATH) ?: '/';
    }
    return base_url() . $path;
  }

  function csrf_token(): string
  {
    if (empty($_SESSION['_csrf'])) {
      $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
  }

  function csrf_field(): string
  {
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
  }

  function verify_csrf(): void
  {
    $token = $_POST['_csrf'] ?? '';
    if (!$token || !hash_equals($_SESSION['_csrf'] ?? '', $token)) {
      http_response_code(419);
      echo 'Invalid CSRF token';
      exit;
    }
  }

  function flash(string $message, string $type = 'success'): void
  {
    $_SESSION['_flash'] = [
      'message' => $message,
      'type' => $type
    ];
  }

  function pull_flash(): ?array
  {
    if (!isset($_SESSION['_flash'])) {
      return null;
    }

    $flash = $_SESSION['_flash'];
    unset($_SESSION['_flash']);

    return $flash;
  }

?>
