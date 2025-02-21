<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch event statistics
$total_events = $conn->query("SELECT COUNT(*) FROM events")->fetch_row()[0];
$total_tickets = $conn->query("SELECT COUNT(*) FROM tickets")->fetch_row()[0];
$total_sales = $conn->query("
    SELECT SUM(price) FROM tickets
")->fetch_row()[0] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/event_booking/css/style.css">
</head>
<body class="admin-layout">

    <div class="sidebar">
    <img src="/event_booking/images/logo.png" alt="Event Booking Logo" class="logo">
    <h2 class="admin-title">Admin Dashboard</h2><hr>
    <ul>
            <li><a href="admin_dashboard.php">Overview</a></li>
            <li><a href="manage_events.php">Manage Events</a></li>
            <li><a href="sales_report.php">Sales Report</a></li>
            <li><a href="logout.php" class="logout-btn">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
    <h1>Welcome, Admin!</h1>
    <p>Here is the overview of the statistic and value of EventVerse.</p><br>
    
    <div class="dashboard-table-container">
        <table class="dashboard-table">
            <tr>
                <th>Statistic</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Total Events</td>
                <td><?php echo $total_events; ?></td>
            </tr>
            <tr>
                <td>Total Tickets Sold</td>
                <td><?php echo $total_tickets; ?></td>
            </tr>
            <tr>
                <td>Total Sales</td>
                <td>₱<?php echo number_format($total_sales, 2); ?></td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>
