<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modular Project</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js" defer></script>
</head>
<body>

<div class="container">
    <header>
        <h1>Modular PHP Project</h1>
    </header>

 <nav>
    <a href="index.php?page=dashboard">Dashboard</a>
    <a href="index.php?page=user/list">User List</a>
    <a href="index.php?page=user/add">Add User</a>

    <?php if (isset($_SESSION['logged_in'])) : ?>
        <a href="index.php?page=auth/logout" style="color:red;">Logout</a>
    <?php else : ?>
        <a href="index.php?page=auth/login">Login</a>
    <?php endif; ?>
</nav>

    <main>
