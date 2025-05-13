<?php
session_start();
include 'config.php';
$pesan = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $pesan = "Username sudah dipakai.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $insert->bind_param("ss", $username, $hash);
        if ($insert->execute()) {
            header("Location: index.php?daftar=berhasil");
            exit();
        } else {
            $pesan = "Gagal mendaftar.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <form method="POST">
        <h2>Daftar Akun Baru</h2>
        <?php if ($pesan): ?>
            <p style="color: red"><?= $pesan ?></p>
        <?php endif; ?>
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <input type="submit" name="register" value="Daftar">
        <p class="login">Sudah punya akun? <a href="index.php">Login di sini</a></p>
    </form>
</div>
</body>
</html>
