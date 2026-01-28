<?php

  function auth()
  {
    return $_SESSION['user'] ?? null;
  }

  function is_logged_in(): bool
  {
    return isset($_SESSION['user']);
  }

  function require_auth()
  {
    if (!is_logged_in()) {
      header('Location: /login');
      exit;
    }
  }

  function require_guest()
  {
    if (is_logged_in()) {
      header('Location: /');
      exit;
    }
  }
