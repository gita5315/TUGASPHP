<?php
session_start();
include 'config.php';

$error = "";

if (isset($_POST['login'])) {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed);
        $stmt->fetch();

        if (password_verify($pass, $hashed)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $user;
            header("Location: todo.php");
            exit();
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan. Silakan daftar dulu.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <form method="POST">
        <h2>Masuk</h2>
        <?php if ($error): ?>
            <p style="color: red"><?= $error ?></p>
        <?php endif; ?>
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <input type="submit" name="login" value="Login">

        <p class="register">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </form>
</div>
</body>
</html>
