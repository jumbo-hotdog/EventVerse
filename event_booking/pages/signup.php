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
    <title>Sign Up</title>
    <link rel="stylesheet" href="/event_booking/css/style.css">
</head>
<body>
    <div class="container">
    <img src="/event_booking/images/logo.png" alt="Event Booking Logo" class="logo">
        <h2>Sign Up</h2>
        <form action="process_signup.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Log in instead</a></p>
    </div>
</body>
</html>
