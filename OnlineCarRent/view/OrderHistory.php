<?php

session_start();

if(!isset($_SESSION['role'])){
    header("Location: adminlogin.php");
    exit;
}

require_once "../model/db.php";
require_once "../model/OrderModel.php";

$orders = getAllOrders($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
</head>
<body>
    <h2>Order History</h2>

    <a href="AdminDashboard.php">Back to Dashboard</a>
    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>Order ID</th>
            <th>Member Name</th>
            <th>Car Name/Model</th>
            <th>Rental Dates</th>
            <th>Total Cost</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>Order Date</th>
        </tr>

        <?php if(!empty($orders) && is_array($orders)): ?>
            <?php foreach($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($order['member_name']) ?></td>
                    <td><?= htmlspecialchars($order['car_name_model']) ?></td>
                    <td>
                        <?= htmlspecialchars($order['start_date']) ?> to <?= htmlspecialchars($order['end_date']) ?>
                    </td>
                    <td>$<?= htmlspecialchars(number_format($order['total_cost'], 2)) ?></td>
                    <td><?= htmlspecialchars($order['status']) ?></td>
                    <td><?= htmlspecialchars($order['payment_method']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align:center;">No orders found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html></content>
