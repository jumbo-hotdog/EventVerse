<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$event_id = $_GET['event_id'] ?? null;

// Validate event ID
if (!$event_id) {
    die("Invalid event ID.");
}

// Fetch event details
$stmt = $conn->prepare("SELECT name FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$stmt->bind_result($event_name);
$stmt->fetch();
$stmt->close();

// Fetch booked seats for this event
$booked_seats = [];
$result = $conn->query("SELECT seat_number FROM tickets WHERE event_id = $event_id");
while ($row = $result->fetch_assoc()) {
    $booked_seats[] = $row['seat_number'];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticket_category = $_POST['category'] ?? null;
    $seat_number = $_POST['seat_number'] ?? null;
    $user_id = $_SESSION['user_id'];

    // Validate inputs
    if (!$ticket_category || !$seat_number) {
        echo "<script>alert('Please select a category and seat number.'); window.location.href='book_ticket.php?event_id=$event_id';</script>";
        exit();
    }

    // Check if seat is already booked
    if (in_array($seat_number, $booked_seats)) {
        echo "<script>alert('Seat already taken. Choose another.'); window.location.href='book_ticket.php?event_id=$event_id';</script>";
        exit();
    }

    // Set price based on category
    $ticket_price = ($ticket_category == 'VIP') ? 500.00 : 250.00;

    // Insert ticket into database
    $stmt = $conn->prepare("INSERT INTO tickets (event_id, user_id, category, seat_number, price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iissi", $event_id, $user_id, $ticket_category, $seat_number, $ticket_price);

    if ($stmt->execute()) {
        echo "<script>alert('Ticket booked successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Ticket</title>
    <link rel="stylesheet" href="/event_booking/css/style.css">
    <script>
        function updatePrice() {
            let category = document.getElementById("ticket_category").value;
            let priceDisplay = document.getElementById("ticket_price");
            if (category === "VIP") {
                priceDisplay.textContent = "₱500.00";
            } else {
                priceDisplay.textContent = "₱250.00";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Book Ticket for <?php echo htmlspecialchars($event_name); ?></h2>
        <form method="POST">
            <label>Category:</label>
            <select name="category" id="ticket_category" onchange="updatePrice()" required>
                <option value="VIP">VIP - ₱500.00</option>
                <option value="Regular">Regular - ₱250.00</option>
            </select><br>

            <label>Seat Number:</label>
            <select name="seat_number" required>
                <?php for ($i = 1; $i <= 50; $i++): ?>
                    <?php if (!in_array($i, $booked_seats)): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endif; ?>
                <?php endfor; ?>
            </select><br>

            <label>Price:</label>
            <span id="ticket_price">₱500.00</span><br> <!-- Default price is VIP -->

            <button type="submit">Book Now</button>
        </form>
    </div>
</body>
</html>
