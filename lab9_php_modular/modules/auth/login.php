<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika sudah login, jangan tampilkan form lagi
if (isset($_SESSION['logged_in'])) {
    header("Location: index.php?page=dashboard");
    exit;
}

// proses login ketika submit
if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // LOGIN SEDERHANA (default)
    if ($username === "muflih" && $password === "050107") {

        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;

        header("Location: index.php?page=dashboard");
        exit;

    } else {
        $error = "Username atau password salah!";
    }
}
?>
<div class="login-card">
    <h2>Login</h2>

    <?php if (!empty($error)) : ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>
</div>
