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
