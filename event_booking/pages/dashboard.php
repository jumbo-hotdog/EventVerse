<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Event Booking</title>
    <link rel="stylesheet" href="/event_booking/css/style.css">
</head>
<body>

    <div class="sidebar">
    <img src="/event_booking/images/logo.png" alt="Event Booking Logo" class="logo">
    <h2 class="admin-title">Dashboard</h2><hr>
        <ul>
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="view_events.php">View Events</a></li>
            <li><a href="logout.php" class="logout-btn">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
    <img src="/event_booking/images/event.gif" alt="Event Planet" class="event-logo">

        <h1>Welcome to EventVerse!</h1>
        <p>Explore upcoming events and book your tickets now.</p>
        <a href="view_events.php" class="btn">View Events</a>
    </div>

</body>
</html>
