<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/event_booking/css/style.css">
</head>
<body>
    <div class="container">
    <img src="/event_booking/images/logo.png" alt="Event Booking Logo" class="logo">
        <h2>Login</h2>
        <form action="process_login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up instead</a></p>
    </div>
</body>
</html>
