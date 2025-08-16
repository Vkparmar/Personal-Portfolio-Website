<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (!$username || !$password) {
        $error = "Please fill all fields.";
    } else {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $error = "Username already exists!";
        } else {
            $hashed = md5($password); // simple hash
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
            $stmt->execute([$username, $hashed]);
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
<div class="container">
    <h2>Create Account</h2>
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
        <button type="submit">Register</button>
    </form>
    <a href="login.php">Already have an account? Login</a>
</div>

</body>
</html>
