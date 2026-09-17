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


/* ==== APP LAYOUT ===== */

if ($page === 'login') {
    require_once BASE_PATH . '/includes/login.php';
} else {
    require_once BASE_PATH . '/includes/main.php';
}

