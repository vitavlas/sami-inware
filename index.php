<?php

session_start();

/* ==== CONFIG ===== */

define('BASE_PATH', __DIR__);

$page = $_GET['page'] ?? 'home';

// routes
require_once BASE_PATH . '/config/routes.php';

// helpers
require_once BASE_PATH . '/config/helpers.php';

// db connection
require_once BASE_PATH . '/config/database.php';

/* ==== RUOTE CHECK ===== */

if (!isset($routes[$page])) {
    http_response_code(404);
    // FIXME:
    echo 'Page not found 404';
    exit;
}

/* ==== AUTHENTICATION ===== */

if (!$routes[$page]['public'] && empty($_SESSION['user_name'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: index.php?page=login');
    exit;
}

/* ==== AUTHORIZATION ===== */

if ($routes[$page]['role'] !== null && ($_SESSION['user_role'] ?? '') !== $routes[$page]['role']) {
    http_response_code(403);
    // FIXME:
    echo 'Authorization denied';
    exit;
}

/* ==== APP LAYOUT ===== */

if ($page === 'login') {
    require_once BASE_PATH . '/includes/login.php';
} else {
    require_once BASE_PATH . '/includes/main.php';
}

