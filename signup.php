<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect data from the form
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Hash the password securely
    $plainPassword = $password;
    
    // Insert the new user into the users table
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $plainPassword])) {
        // Set the session variable for the new user
        $_SESSION['user_id'] = $pdo->lastInsertId();
        // Redirect to the dashboard (or homepage)
        header("Location: login.html");
        exit();
    } else {
        echo "Error creating your account. Please try again.";
    }
}
?>

