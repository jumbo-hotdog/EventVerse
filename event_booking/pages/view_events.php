<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
include 'config.php';

// Fetch events
$result = $conn->query("SELECT * FROM events");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | Event Booking</title>
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
        <h1>Available Events</h1><br>
        <div class="event-container">
        <?php 
while ($row = $result->fetch_assoc()): 
    $imagePath = "/event_booking/images/event" . $row['id'] . ".jpg"; 

    // Convert URL-like path to a real server file path
    $realPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;

    // Use a placeholder if the file is missing
    if (!file_exists($realPath)) {
        $imagePath = "/event_booking/images/default.jpg"; 
    }
?>
    <div class="event-card">
        <img src="<?php echo $imagePath; ?>" alt="Event Image" class="event-img">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p><?php echo htmlspecialchars($row['description']); ?></p>
        <p><strong>Date:</strong> <?php echo $row['date']; ?></p>
        <a href="book_ticket.php?event_id=<?php echo $row['id']; ?>" class="btn">Book Now</a>
    </div>
<?php endwhile; ?>

        </div>
    </div>

</body>
</html>
