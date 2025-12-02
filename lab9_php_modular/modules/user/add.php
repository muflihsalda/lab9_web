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
