<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Check for admin login using email and password
    if ($email === 'admin@gmail.com' && $password === 'admin@123') {
        $_SESSION['admin'] = true;
        // Optionally, set an admin user id
        $_SESSION['user_id'] = 1;
        header("Location: admin_dashboard.php");
        exit();
    }
    
    // Regular user login: retrieve user record based on email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // For demonstration, assuming passwords are stored as plain text
    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>
                alert('Invalid email or password');
                window.location.href = 'login.html';
              </script>";
        exit();
    }
}
?>





