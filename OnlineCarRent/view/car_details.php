<?php
// view/car_details.php
// Expects $car (array) and $isMember (bool) to be defined by the controller.
if (!isset($car)) {
    echo '<p>No car data provided.</p>';
    return;
}

// Helper to escape output
function e($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

$image = !empty($car['image_path']) ? $car['image_path'] : '/asset/img/placeholder.png';

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo e($car['name'] ?? 'Car Details'); ?></title>
    <link rel="stylesheet" href="/asset/css/style.css">
    <style>
        /* small inline fallback */
        body { font-family: Arial, sans-serif; padding: 16px; }
    </style>
</head>
<body>
    <a href="/">&larr; Back to listing</a>
    <div class="car-card">
        <div class="car-image">
            <img src="<?php echo e($image); ?>" alt="<?php echo e($car['name']); ?>">
        </div>
        <div class="car-info">
            <h2><?php echo e($car['name']); ?> (<?php echo e($car['model'] ?? 'N/A'); ?>)</h2>
            <p>Price per day: <strong>$<?php echo number_format((float)($car['price_per_day'] ?? 0), 2); ?></strong></p>

            <?php if ($isMember): ?>
                <form id="order-form" action="?action=place_order" method="post" novalidate>
                    <input type="hidden" name="car_id" id="car_id" value="<?php echo e($car['id']); ?>">

                    <div class="field">
                        <label for="start_date">Start date</label>
                        <input type="date" name="start_date" id="start_date" required>
                    </div>

                    <div class="field">
                        <label for="end_date">End date</label>
                        <input type="date" name="end_date" id="end_date" required>
                    </div>

                    <div class="total">Total: $<span id="total_cost">0.00</span></div>

                    <div id="order_errors" style="color:crimson; margin:8px 0;"></div>

                    <button type="submit" class="btn">Proceed to Invoice</button>
                </form>
            <?php else: ?>
                <p>Please <a href="?login=member">log in</a> as a member to place an order.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="/asset/js/order.js"></script>
</body>
</html>
