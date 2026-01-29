<?php
session_start();

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Base path inside htdocs
define('BASE_PATH', __DIR__);

// Load core files
require_once BASE_PATH . '/app/Core/App.php';
require_once BASE_PATH . '/app/Core/Router.php';
require_once BASE_PATH . '/app/Core/Controller.php';
require_once BASE_PATH . '/app/Core/Database.php';

// Helper functions
require_once BASE_PATH . '/app/Helpers/auth.php';

// Run application
$app = new App();
$app->run();
