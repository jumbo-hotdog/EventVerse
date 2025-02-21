<?php
session_start();
include 'config.php';

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Check if event ID is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convert ID to integer for safety

    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Event deleted successfully!'); window.location='manage_events.php';</script>";
    } else {
        echo "<script>alert('Error deleting event.'); window.location='manage_events.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location='manage_events.php';</script>";
}
?>
