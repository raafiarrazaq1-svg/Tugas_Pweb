<?php

session_start();
require_once "database.php";

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $admin = mysqli_fetch_assoc($result);

        if ($password === $admin['password']) {

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_nama'] = $admin['nama'];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Password salah.";
        }

    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Warranty Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

<div class="login-box">

    <div class="login-logo">
        <div class="logo-mark">W</div>
        <div>
            <h1>Warranty</h1>
            <span>Management System</span>
        </div>
    </div>

    <div class="login-title">
        <h2>Login Administrator</h2>
        <p>Masuk untuk mengelola data garansi.</p>
    </div>

    <?php if ($error != ""): ?>
        <div class="alert error">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
        </div>

        <button type="submit" name="login" class="btn-primary full">
            Masuk
        </button>

    </form>

</div>

</body>
</html>