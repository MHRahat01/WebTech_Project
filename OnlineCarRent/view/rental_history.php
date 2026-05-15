<?php
// view/rental_history.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'member') {
    echo '<p>Unauthorized. Please log in as member.</p>';
    return;
}

function e($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

$successMsg = '';
if (isset($_GET['payment_success']) && $_GET['payment_success'] == '1') {
    $successMsg = 'Payment successful. Your order is confirmed.';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>My Rentals</title>
    <link rel="stylesheet" href="/WebTech_Project/OnlineCarRent/asset/css/style.css">
</head>
<body>
<div class="container">
    <h2>My Rentals</h2>

    <?php if ($successMsg): ?>
        <div class="alert alert-success"><?php echo e($successMsg); ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="history-table">
            <thead>
                <tr>
                    <th>Car</th>
                    <th>Rental Dates</th>
                    <th>Total Cost</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr><td colspan="4">You have no rentals yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td><?php echo e($o['car_name'] ?? 'Unknown'); ?> <div class="muted small"><?php echo e($o['car_model'] ?? ''); ?></div></td>
                            <td><?php echo e($o['start_date']); ?> &mdash; <?php echo e($o['end_date']); ?></td>
                            <td>$<?php echo number_format((float)$o['total_cost'], 2); ?></td>
                            <td>
                                <?php if ($o['status'] === 'confirmed'): ?>
                                    <span class="status-badge status-confirmed">Confirmed</span>
                                <?php elseif ($o['status'] === 'cancelled'): ?>
                                    <span class="status-badge status-cancelled">Cancelled</span>
                                <?php else: ?>
                                    <span class="status-badge status-pending"><?php echo e(ucfirst($o['status'])); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <p style="margin-top:12px"><a href="/">Back to listing</a></p>
</div>
</body>
</html>
