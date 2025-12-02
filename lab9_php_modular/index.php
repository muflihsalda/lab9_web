<?php
session_start();

// Load database
require_once __DIR__ . '/config/database.php';

// Ambil parameter page, default ke dashboard
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// === PROTEKSI HALAMAN MODULE ===
// halaman yang harus login dulu
$protected_pages = [
    'user/list',
    'user/add'
];

// jika page termasuk protected & belum login → redirect
if (in_array($page, $protected_pages) && !isset($_SESSION['logged_in'])) {
    header("Location: index.php?page=auth/login");
    exit;
}

// === ROUTING DASHBOARD ===
if ($page === 'dashboard') {
    require_once __DIR__ . '/views/header.php';
    require_once __DIR__ . '/views/dashboard.php';
    require_once __DIR__ . '/views/footer.php';
    exit;
}

// === ROUTING MODULE ===
$pagePath = explode('/', $page);

$module = $pagePath[0];
$file = $pagePath[1] ?? 'index';

$target = __DIR__ . "/modules/$module/$file.php";

if (file_exists($target)) {
    require_once __DIR__ . '/views/header.php';
    require_once $target;
    require_once __DIR__ . '/views/footer.php';
} else {
    require_once __DIR__ . '/views/header.php';
    echo "<h2>404 - Halaman tidak ditemukan</h2>";
    require_once __DIR__ . '/views/footer.php';
}
?>
