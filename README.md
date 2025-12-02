# lab9_web
Nama : Muflih Salda Maulana

Nim  :312410527

Kelas: TI.24.A5

# Langkah Langkah Tugas Prkatikum

**struktur Folder**
```
  project/
│── index.php
│
├── config/
│     └── database.php
│
├── views/
│     ├── header.php
│     ├── footer.php
│     └── dashboard.php
│
├── modules/
│     ├── user/
│     │     ├── list.php
│     │     └── add.php
│     │
│     └── auth/
│           ├── login.php
│           └── logout.php
│
└── assets/
      ├── css/
      └── js/
```
---

#  LANGKAH 1 – Membuat File Database (koneksi MySQL)

Buat file:

 `config/database.php`

```<?php
// config/database.php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "latihan1";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
```

File ini akan dipanggil dari file lain menggunakan `include` atau `require`.

---

# LANGKAH 2 – Membuat Template (Header dan Footer)

Template digunakan agar halaman memiliki tampilan yang seragam.

### **views/header.php**

```<?php
// config/database.php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "latihan1";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

```

### **views/footer.php**

```php
<footer>
    <p>&copy; 2025 – Informatika, Universitas Pelita Bangsa</p>
</footer>

</div>
</body>
</html>
```

---

# LANGKAH 3 – Membuat Sistem Routing

Routing berarti halaman dipanggil menggunakan URL:

```
index.php?page=user/dashboard
index.php?page=user/list
index.php?page=user/add
index.php?page=auth/login
```

Buat file utama:

**index.php**

```<?php
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

```

Routing ini membuat aplikasi menjadi modular dan mudah diperluas.

---

# LANGKAH 4 – Membuat Dashboard

**views/dashboard.php**

```<h2>Dashboard</h2>
<p>Selamat datang di halaman dashboard.</p>

```

---

# LANGKAH 5 – Modul User: Menampilkan Data 

**modules/user/list.php**

```php
 <?php
$query = mysqli_query($conn, "SELECT * FROM users");
?>

<h2>Daftar User</h2>

<a href="index.php?page=user/add">+ Tambah User</a>

<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($query)) : ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>
```

---

# LANGKAH 6 – Modul User: Menambah Data*

 **modules/user/add.php**

```php
<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    mysqli_query($conn, "INSERT INTO users (name, email) VALUES ('$name', '$email')");

    header("Location: index.php?page=user/list");
}
?>

<h2>Tambah User</h2>

<form method="post">
    <label>Nama:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <button type="submit" name="submit">Simpan</button>
</form>

```

---

# LANGKAH 7 – Modul Login 

 **modules/auth/login.php**

```php
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

```
# LANGKAH 8 – Modul Logout
```php
<?php
session_start();
session_destroy();

header("Location: index.php?page=auth/login");
exit;
```
---
# Hasil Project
untuk masuk ke bagian User List, Add User, itu perlu login 

<img width="1059" height="321" alt="image" src="https://github.com/user-attachments/assets/abc40201-d7b1-4a2c-8087-82be650b701d" />

**Tampilan Login**

<img width="659" height="582" alt="image" src="https://github.com/user-attachments/assets/a9385068-259b-4261-bdc4-707194128885" />

**Tampilan Setelah login**

<img width="1005" height="339" alt="image" src="https://github.com/user-attachments/assets/612ef187-0ffe-488c-8124-bd3d6b484e14" />

**Tampilan User List**

<img width="923" height="406" alt="image" src="https://github.com/user-attachments/assets/98a1e0bf-bccf-4697-9f85-9ca9bb1d756b" />

**Tampilan ADD USER**

<img width="1036" height="471" alt="image" src="https://github.com/user-attachments/assets/c9962c6c-476b-4bcc-a307-9c323005d6cc" />
