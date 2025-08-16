<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        

        if($user['role'] === 'admin'){
            header("Location: admin/dashboard.php");
        } else {
            header("Location: home.php");
        }
        exit;
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
<div class="container">
    <h2>Welcome Back</h2>
    <?php if(isset($error)) echo "<p>$error</p>"; ?>
    <form method="post">
        <div class="input-box">
            <input type="text" name="username" placeholder=" " required>
            <label>Username</label>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder=" " required>
            <label>Password</label>
        </div>
        <button type="submit">Login</button>
    </form>
    <a href="register.php">Don’t have an account? Register</a>
</div>

</body>
</html>
