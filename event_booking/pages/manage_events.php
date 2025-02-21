<?php
session_start();
include 'config.php';

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

include 'config.php';

// Handle event creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
    $name = trim($_POST['name']);
    $date = $_POST['date'];

    $stmt = $conn->prepare("INSERT INTO events (name, date) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $date);
    if ($stmt->execute()) {
        echo "<script>alert('Event added successfully!'); window.location='manage_events.php';</script>";
    } else {
        echo "<script>alert('Error adding event.');</script>";
    }
}

// Handle event update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_event'])) {
    $id = $_POST['event_id'];
    $name = trim($_POST['name']);
    $date = $_POST['date'];

    $stmt = $conn->prepare("UPDATE events SET name=?, date=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $date, $id);
    if ($stmt->execute()) {
        echo "<script>alert('Event updated successfully!'); window.location='manage_events.php';</script>";
    } else {
        echo "<script>alert('Error updating event.');</script>";
    }
}

// Fetch all events
$events = $conn->query("SELECT id, name, date FROM events");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
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
        <h1>Manage Events</h1>

        <!-- Add Event Form -->
        <div class="form-container">
            <h3>Add Event</h3>
            <form method="post">
                <table>
                    <tr>
                        <td><label>Event Name:</label></td>
                        <td><input type="text" name="name" placeholder="Event Name" required></td>
                    </tr>
                    <tr>
                        <td><label>Event Date:</label></td>
                        <td><input type="date" name="date" required></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" name="add_event">Add Event</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <br>
        <h3>Existing Events</h3><br>
        <table class="event-table">
            <tr>
                <th>Event Name</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $events->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td>
                        <button class="edit-btn"
                            onclick="openEditModal(<?php echo $row['id']; ?>, 
                            `<?php echo htmlspecialchars(addslashes($row['name'])); ?>`, 
                            `<?php echo htmlspecialchars($row['date']); ?>`)">
                            Edit
                        </button>
                        <a href="delete_event.php?id=<?php echo $row['id']; ?>" class="delete-btn">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Edit Event Modal (Hidden by Default) -->
    <div id="editModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3>Edit Event</h3>
            <form method="post">
                <table>
                    <tr>
                        <td><label>Event Name:</label></td>
                        <td><input type="text" name="name" id="edit_name" required></td>
                    </tr>
                    <tr>
                        <td><label>Event Date:</label></td>
                        <td><input type="date" name="date" id="edit_date" required></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="event_id" id="edit_event_id">
                            <button type="submit" name="update_event">Update Event</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, date) {
            document.getElementById('edit_event_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_date').value = date;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target === document.getElementById('editModal')) {
                closeEditModal();
            }
        }
    </script>

</body>
</html>
