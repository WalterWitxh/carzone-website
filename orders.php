<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
include('db_connection.php');

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT b.*, c.model FROM bookings b LEFT JOIN cars c ON b.car_id = c.id WHERE b.user_id = ?");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders - Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
      table { border-collapse: collapse; width: 100%; }
      th, td { border: 1px solid #ddd; padding: 8px; }
      th { background-color: #f2f2f2; text-align: left; }
    </style>
</head>
<body>
    <h1>My Orders</h1>
    <?php if(count($orders) > 0): ?>
    <table>
       <thead>
           <tr>
               <th>Order ID</th>
               <th>Car Model</th>
               <th>First Name</th>
               <th>Last Name</th>
               <th>Email</th>
               <th>Mobile</th>
               <th>Pickup Location</th>
               <th>Drop Location</th>
               <th>Pickup Date</th>
               <th>Pickup Time</th>
               <th>Payment Method</th>
               <th>Booking Time</th>
           </tr>
       </thead>
       <tbody>
         <?php foreach ($orders as $order): ?>
         <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo htmlspecialchars($order['model']); ?></td>
            <td><?php echo htmlspecialchars($order['first_name']); ?></td>
            <td><?php echo htmlspecialchars($order['last_name']); ?></td>
            <td><?php echo htmlspecialchars($order['email']); ?></td>
            <td><?php echo htmlspecialchars($order['mobile']); ?></td>
            <td><?php echo htmlspecialchars($order['pickup_location']); ?></td>
            <td><?php echo htmlspecialchars($order['drop_location']); ?></td>
            <td><?php echo htmlspecialchars($order['pickup_date']); ?></td>
            <td><?php echo htmlspecialchars($order['pickup_time']); ?></td>
            <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
            <td><?php echo htmlspecialchars($order['booking_time']); ?></td>
         </tr>
         <?php endforeach; ?>
       </tbody>
    </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
    <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
</body>
</html>

