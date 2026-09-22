<?php

$routes = [
    'home' => [
        'file' => BASE_PATH . '/views/home.php',
        'public' => false,
        'role' => null,
    ],
    'login' => [
        'file' => BASE_PATH . '/includes/login.php',
        'public' => true,
        'role' => null,
    ],
    'logout' => [
        'file' => BASE_PATH . '/views/logout.php',
        'public' => false,
        'role' => null,
    ],
    'view-product' => [
        'file' => BASE_PATH . '/views/product_details.php',
        'public' => false,
        'role' => null,
    ],
    'add-item' => [
        'file' => BASE_PATH . '/views/add_item.php',
        'public' => false,
        'role' => null,
    ],
    'update-item' => [
        'file' => BASE_PATH . '/views/edit_item.php',
        'public' => false,
        'role' => 'admin',
    ],
    'delete-item' => [
        'file' => BASE_PATH . '/views/delete_item.php',
        'public' => false,
        'role' => 'admin',
    ],
];