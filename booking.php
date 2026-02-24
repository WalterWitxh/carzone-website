<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $car_id          = $_POST['car_id'];
    $first_name      = trim($_POST['first_name']);
    $last_name       = trim($_POST['last_name']);
    $email           = trim($_POST['email']);
    $mobile          = trim($_POST['mobile']);
    $pickup_location = trim($_POST['pickup_location']);
    $drop_location   = trim($_POST['drop_location']);
    $pickup_date     = $_POST['pickup_date']; // Should be in YYYY-MM-DD format
    $pickup_time     = $_POST['pickup_time']; // Should be in HH:MM:SS or HH:MM format
    $special_request = trim($_POST['special_request']);
    $payment         = $_POST['payment'];
    
    // Check if the car is still available
    $stmt = $pdo->prepare("SELECT status FROM cars WHERE id = ?");
    $stmt->execute([$car_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$car || $car['status'] !== 'available') {
        // If the car is not available, alert the user and redirect to the car listing page
        echo "<script>alert('Sorry, this car is already sold or booked.'); window.location.href='car.html';</script>";
        exit();
    }
    
    // If the car is available, insert the booking record
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $stmt = $pdo->prepare("INSERT INTO bookings (car_id, user_id, first_name, last_name, email, mobile, pickup_location, drop_location, pickup_date, pickup_time, special_request, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$car_id, $user_id, $first_name, $last_name, $email, $mobile, $pickup_location, $drop_location, $pickup_date, $pickup_time, $special_request, $payment])) {
        // Update the car's status to 'booked'
        $stmt2 = $pdo->prepare("UPDATE cars SET status = 'booked' WHERE id = ?");
        $stmt2->execute([$car_id]);
        
        // Redirect to confirmation page
        header("Location: confirmation.html");
        exit();
    } else {
        echo "Error processing your booking. Please try again.";
        print_r($stmt->errorInfo());
    }
}
?>

