<?php
session_start();

// Ensure only admin users can access this page.
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.html");
    exit();
}

include('db_connection.php');

// Query to fetch all bookings along with associated car and user details.
// Adjust the query if your database structure differs.
$query = "SELECT b.*, c.model, c.daily_rate, u.username, u.email 
          FROM bookings b 
          LEFT JOIN cars c ON b.car_id = c.id 
          LEFT JOIN users u ON b.user_id = u.id 
          ORDER BY b.booking_time DESC";
$stmt = $pdo->query($query);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Page - Car Zone</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Custom CSS (if needed) -->
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background-color: #f7f7f7;
    }
    .container {
      margin-top: 50px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="mb-4">All Bookings</h1>
    <?php if (count($orders) > 0): ?>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Booking ID</th>
            <th>Car Model</th>
            <th>User Name</th>
            <th>User Email</th>
            <th>Pickup Location</th>
            <th>Drop Location</th>
            <th>Pickup Date</th>
            <th>Pickup Time</th>
            <th>Special Request</th>
            <th>Payment Method</th>
            <th>Booking Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $order): ?>
            <tr>
              <td><?php echo $order['id']; ?></td>
              <td><?php echo htmlspecialchars($order['model']); ?></td>
              <td><?php echo htmlspecialchars($order['username']); ?></td>
              <td><?php echo htmlspecialchars($order['email']); ?></td>
              <td><?php echo htmlspecialchars($order['pickup_location']); ?></td>
              <td><?php echo htmlspecialchars($order['drop_location']); ?></td>
              <td><?php echo htmlspecialchars($order['pickup_date']); ?></td>
              <td><?php echo htmlspecialchars($order['pickup_time']); ?></td>
              <td><?php echo htmlspecialchars($order['special_request']); ?></td>
              <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
              <td><?php echo htmlspecialchars($order['booking_time']); ?></td>
              <td>
                <a href="remove_booking.php?booking_id=<?php echo $order['id']; ?>&car_id=<?php echo $order['car_id']; ?>" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Are you Sure ?');">
                   Mark as Completed
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No bookings found.</p>
    <?php endif; ?>
    <a href="admin_dashboard.php" class="btn btn-primary mt-3">Back to Dashboard</a>
  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

