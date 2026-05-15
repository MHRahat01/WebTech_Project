<?php
// view/order_invoice.php
// Expects $order and $car to be defined by controller
if (!isset($order) || !isset($car)) {
    echo '<p>Missing order or car data.</p>';
    return;
}

function e($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Invoice - Order #<?php echo e($order['id']); ?></title>
    <meta name="csrf-token" content="<?php echo isset($_SESSION['csrf_token']) ? htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    <link rel="stylesheet" href="/WebTech_Project/OnlineCarRent/asset/css/style.css">
    <style>.payment-placeholder{display:none;border:1px solid #ddd;padding:12px;margin-top:12px}</style>
</head>
<body>
    <a href="/">&larr; Back</a>
    <h2>Invoice - Order #<?php echo e($order['id']); ?></h2>
    <div class="invoice">
        <p><strong>Car:</strong> <?php echo e($car['name']); ?> (<?php echo e($car['model']); ?>)</p>
        <p><strong>Start Date:</strong> <?php echo e($order['start_date']); ?></p>
        <p><strong>End Date:</strong> <?php echo e($order['end_date']); ?></p>
        <p><strong>Total:</strong> $<?php echo number_format((float)$order['total_cost'],2); ?></p>
        <p><strong>Status:</strong> <?php echo e($order['status']); ?></p>

        <div style="margin-top:12px">
            <button id="cancelBtn" class="btn">Cancel Order</button>
            <button id="finalizeBtn" class="btn">Finalize &amp; Pay</button>
        </div>

        <div id="paymentSection" class="payment-placeholder">
            <p>Select payment method</p>
            <select id="paymentMethod">
                <option value="">-- Select method --</option>
                <option value="card">Credit Card</option>
                <option value="bKash">bKash</option>
                <option value="Nagad">Nagad</option>
                <option value="bank">Bank Transfer</option>
                <option value="cod">Cash on Delivery</option>
            </select>
            <div style="margin-top:8px">
                <button id="confirmPaymentBtn" class="btn">Confirm Payment</button>
            </div>
            <div id="payment_errors" style="color:crimson;margin-top:8px"></div>
        </div>
    </div>

    <div id="invoice_errors" style="color:crimson;margin-top:8px"></div>

    <script src="asset/js/order.js"></script>
    <script>
        // expose order id to order.js
        window.__ORDER_ID = <?php echo json_encode((int)$order['id']); ?>;
    </script>
</body>
</html>
