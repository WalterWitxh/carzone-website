<?php
session_start();

// Ensure only an admin can access this page.
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.html");
    exit();
}

include('db_connection.php');

// Check if booking_id and car_id are provided in the URL.
if (!isset($_GET['booking_id']) || !isset($_GET['car_id'])) {
    echo "Booking ID or Car ID not provided.";
    exit();
}

$booking_id = (int) $_GET['booking_id'];
$car_id     = (int) $_GET['car_id'];

// Delete the booking record.
$stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
$stmt->execute([$booking_id]);

// Update the car's status back to 'available'.
$stmt2 = $pdo->prepare("UPDATE cars SET status = 'available' WHERE id = ?");
$stmt2->execute([$car_id]);

// Redirect back to the admin orders page.
header("Location: admin_orders.php");
exit();
?>

