<?php
// views/car_details.php
// Expects $car (array) and $isMember (bool) to be available
if (!isset($car)) {
    echo 'No car data provided to view.';
    return;
}

// Helper to escape output
function e($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

// Prepare image path - assume images are stored in public/uploads/
$imagePath = 'public/uploads/' . ($car['image'] ?? 'no-image.png');

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Car Details - <?php echo e($car['name']); ?></title>
    <link rel="stylesheet" href="asset/assets/css/style.css">
</head>
<body>
    <div class="container">
        <header class="site-header">
            <h1>Car Details</h1>
            <a href="index.php">&larr; Back to Home</a>
        </header>

        <main>
            <div class="card car-card">
                <div class="car-image">
                    <img src="<?php echo e($imagePath); ?>" alt="<?php echo e($car['name']); ?>">
                </div>
                <div class="car-info">
                    <h2><?php echo e($car['name']); ?></h2>
                    <p><strong>Model:</strong> <?php echo e($car['model']); ?></p>
                    <p><strong>Price per day:</strong> BDT <?php echo number_format($car['price_per_day'], 2); ?></p>

                    <?php if ($isMember): ?>
                        <form id="orderForm" action="index.php?action=order_placement&id=<?php echo (int)$car['id']; ?>" method="post">
                            <div class="form-row">
                                <label for="start_date">Start Date</label>
                                <input type="date" id="start_date" name="start_date" required>
                            </div>
                            <div class="form-row">
                                <label for="end_date">End Date</label>
                                <input type="date" id="end_date" name="end_date" required>
                            </div>

                            <div class="form-row">
                                <label>Total Cost</label>
                                <div id="totalCost">BDT 0.00</div>
                            </div>

                            <div class="form-row">
                                <button type="submit" class="btn">Proceed to Invoice</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <p class="login-prompt">Please <a href="index.php?login_as_member=1">login as member</a> to place an order.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <footer>
            <p>&copy; Online Car Rent</p>
        </footer>
    </div>
</body>
</html>
