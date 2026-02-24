<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.html");
    exit();
}
require 'db_connection.php';

$query = $pdo->query("SELECT * FROM contact_messages ORDER BY submission_time DESC LIMIT 10");
$notifications = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Contact Notifications - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .table-responsive {
            margin-top: 30px;
        }
        .notification-table th, .notification-table td {
            vertical-align: middle;
            text-align: left;
        }
        .notification-table th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h3 class="mb-4">Contact Notifications</h3>
        <?php if (count($notifications) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered notification-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Submitted On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notifications as $note): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($note['name']); ?></td>
                            <td><?php echo htmlspecialchars($note['email']); ?></td>
                            <td><?php echo htmlspecialchars($note['subject']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($note['message'])); ?></td>
                            <td><?php echo date('F j, Y, g:i A', strtotime($note['submission_time'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No new contact messages.</p>
        <?php endif; ?>
        <a href="admin_dashboard.php" class="btn btn-primary mt-3">Back to Dashboard</a>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

