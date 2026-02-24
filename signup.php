<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and trim form data
    $username         = trim($_POST['username']);
    $email            = trim($_POST['email']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match (you can add more validations as needed)
    if ($password !== $confirm_password) {
        echo "<script>
                alert('Passwords do not match.');
                window.location.href = 'signup.html';
              </script>";
        exit();
    }

    // Check if a user with the same email or username already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        echo "<script>
                alert('User already exists with this email or username.');
                window.location.href = 'login.html';
              </script>";
        exit();
    }

    // If no user exists, insert the new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    // For production, make sure to hash the password before inserting!
    $stmt->execute([$username, $email, $password]);
    
    echo "<script>
            alert('Signup successful. Please log in.');
            window.location.href = 'login.html';
          </script>";
}
?>

