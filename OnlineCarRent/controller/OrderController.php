<?php
// controller/OrderController.php
require_once __DIR__ . '/../model/CarModel.php';
require_once __DIR__ . '/../model/OrderModel.php';
require_once __DIR__ . '/../model/PaymentModel.php';

class OrderController
{
    private $carModel;
    private $orderModel;

    public function __construct()
    {
        $this->carModel = new CarModel();
        $this->orderModel = new OrderModel();
    }

    private function jsonResponse(array $data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function validateDates($startDate, $endDate)
    {
        $errors = [];
        if (empty($startDate) || empty($endDate)) {
            $errors[] = 'Start date and end date are required.';
            return $errors;
        }

        $today = new DateTimeImmutable('today');
        try {
            $s = new DateTimeImmutable($startDate);
            $e = new DateTimeImmutable($endDate);
        } catch (Exception $ex) {
            $errors[] = 'Invalid date format.';
            return $errors;
        }

        if ($s < $today) {
            $errors[] = 'Start date cannot be in the past.';
        }
        if ($e <= $s) {
            $errors[] = 'End date must be after start date.';
        }

        return $errors;
    }

    public function calculateTotal()
    {
        $payload = json_decode(file_get_contents('php://input'), true);
        $carId = isset($payload['car_id']) ? (int)$payload['car_id'] : 0;
        $startDate = $payload['start_date'] ?? '';
        $endDate = $payload['end_date'] ?? '';

        $errors = $this->validateDates($startDate, $endDate);
        if ($carId <= 0) {
            $errors[] = 'Invalid car id.';
        }

        if (!empty($errors)) {
            $this->jsonResponse(['success' => false, 'error' => implode(' ', $errors)]);
        }

        $car = $this->carModel->getById($carId);
        if (!$car) {
            $this->jsonResponse(['success' => false, 'error' => 'Car not found.']);
        }

        $s = new DateTimeImmutable($startDate);
        $e = new DateTimeImmutable($endDate);
        $days = (int)$s->diff($e)->format('%a');
        if ($days <= 0) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid date range.']);
        }

        $price = (float)$car['price_per_day'];
        $total = round($price * $days, 2);

        $this->jsonResponse(['success' => true, 'total' => number_format($total, 2, '.', '')]);
    }

    public function placeOrder()
    {
        // CSRF & auth checks
        $headers = getallheaders();
        $csrf = $headers['X-CSRF-Token'] ?? $headers['x-csrf-token'] ?? '';
        if (empty($_SESSION['csrf_token']) || !$csrf || !hash_equals($_SESSION['csrf_token'], $csrf)) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request']);
        }
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'member') {
            $this->jsonResponse(['success' => false, 'error' => 'Unauthorized.']);
        }

        $payload = json_decode(file_get_contents('php://input'), true);
        $carId = isset($payload['car_id']) ? (int)$payload['car_id'] : 0;
        $startDate = $payload['start_date'] ?? '';
        $endDate = $payload['end_date'] ?? '';

        $errors = $this->validateDates($startDate, $endDate);
        if ($carId <= 0) {
            $errors[] = 'Invalid car id.';
        }

        if (!empty($errors)) {
            $this->jsonResponse(['success' => false, 'error' => implode(' ', $errors)]);
        }

        $car = $this->carModel->getById($carId);
        if (!$car) {
            $this->jsonResponse(['success' => false, 'error' => 'Car not found.']);
        }

        // Check availability
        $available = $this->carModel->isAvailable($carId, $startDate, $endDate);
        if (!$available) {
            $this->jsonResponse(['success' => false, 'error' => 'Car is not available for the selected dates.']);
        }

        $s = new DateTimeImmutable($startDate);
        $e = new DateTimeImmutable($endDate);
        $days = (int)$s->diff($e)->format('%a');
        if ($days <= 0) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid date range.']);
        }

        $price = (float)$car['price_per_day'];
        $total = round($price * $days, 2);

        $data = [
            'user_id' => $_SESSION['user_id'],
            'car_id' => $carId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_cost' => $total,
            'status' => 'pending'
        ];

        $orderId = $this->orderModel->create($data);
        if ($orderId === false) {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to create order.']);
        }

        $this->jsonResponse(['success' => true, 'order_id' => $orderId]);
    }

    /**
     * Render invoice page for given order id.
     */
    public function invoice(int $orderId)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'member') {
            header('Location: /');
            exit;
        }

        $order = $this->orderModel->getById($orderId);
        if (!$order) {
            echo '<p>Order not found.</p>';
            return;
        }

        if ((int)$order['user_id'] !== (int)$_SESSION['user_id'] || $order['status'] !== 'pending') {
            echo '<p>Unauthorized or order not pending.</p>';
            return;
        }

        $car = $this->carModel->getById((int)$order['car_id']);
        require __DIR__ . '/../view/order_invoice.php';
    }

    /**
     * JSON endpoint to cancel an order.
     */
    public function cancelOrder()
    {
        // CSRF & auth checks
        $headers = getallheaders();
        $csrf = $headers['X-CSRF-Token'] ?? $headers['x-csrf-token'] ?? '';
        if (empty($_SESSION['csrf_token']) || !$csrf || !hash_equals($_SESSION['csrf_token'], $csrf)) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request']);
        }
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'member') {
            $this->jsonResponse(['success' => false, 'error' => 'Unauthorized']);
        }

        $payload = json_decode(file_get_contents('php://input'), true);
        $orderId = isset($payload['order_id']) ? (int)$payload['order_id'] : 0;
        if ($orderId <= 0) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid order id']);
        }

        $order = $this->orderModel->getById($orderId);
        if (!$order) {
            $this->jsonResponse(['success' => false, 'error' => 'Order not found']);
        }

        if ((int)$order['user_id'] !== (int)$_SESSION['user_id']) {
            $this->jsonResponse(['success' => false, 'error' => 'Unauthorized']);
        }

        if ($order['status'] !== 'pending') {
            $this->jsonResponse(['success' => false, 'error' => 'Only pending orders can be cancelled']);
        }

        $ok = $this->orderModel->updateStatus($orderId, 'cancelled');
        if (!$ok) {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to cancel order']);
        }

        $this->jsonResponse(['success' => true]);
    }

    /**
     * JSON endpoint to finalize an order (confirm payment).
     */
    public function finalizeOrder()
    {
        // CSRF & auth checks
        $headers = getallheaders();
        $csrf = $headers['X-CSRF-Token'] ?? $headers['x-csrf-token'] ?? '';
        if (empty($_SESSION['csrf_token']) || !$csrf || !hash_equals($_SESSION['csrf_token'], $csrf)) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request']);
        }
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'member') {
            $this->jsonResponse(['success' => false, 'error' => 'Unauthorized']);
        }

        $payload = json_decode(file_get_contents('php://input'), true);
        $orderId = isset($payload['order_id']) ? (int)$payload['order_id'] : 0;
        $paymentMethod = $payload['payment_method'] ?? '';

        $allowed = ['card','bKash','Nagad','bank','cod'];
        if ($orderId <= 0 || empty($paymentMethod)) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid input']);
        }
        if (!in_array($paymentMethod, $allowed, true)) {
            $this->jsonResponse(['success' => false, 'error' => 'Unsupported payment method']);
        }

        $order = $this->orderModel->getById($orderId);
        if (!$order) {
            $this->jsonResponse(['success' => false, 'error' => 'Order not found']);
        }
        if ((int)$order['user_id'] !== (int)$_SESSION['user_id']) {
            $this->jsonResponse(['success' => false, 'error' => 'Unauthorized']);
        }
        if ($order['status'] !== 'pending') {
            $this->jsonResponse(['success' => false, 'error' => 'Order is not pending']);
        }

        // Optional: could re-check availability here

        $db = getPDO();
        try {
            $db->beginTransaction();

            $ok = $this->orderModel->updateStatus($orderId, 'confirmed');
            if (!$ok) {
                $db->rollBack();
                $this->jsonResponse(['success' => false, 'error' => 'Failed to update order status']);
            }

            $paymentModel = new PaymentModel();
            $transactionId = bin2hex(random_bytes(8));
            $paymentData = [
                'order_id' => $orderId,
                'amount' => $order['total_cost'],
                'payment_method' => $paymentMethod,
                'transaction_id' => $transactionId,
            ];
            $paymentId = $paymentModel->create($paymentData);
            if ($paymentId === false) {
                $db->rollBack();
                $this->jsonResponse(['success' => false, 'error' => 'Failed to create payment record']);
            }

            $db->commit();
            $this->jsonResponse(['success' => true]);
        } catch (Exception $ex) {
            if ($db->inTransaction()) $db->rollBack();
            // Log the exception message to server error log but return a generic message to client
            error_log('FinalizeOrder error: ' . $ex->getMessage());
            $this->jsonResponse(['success' => false, 'error' => 'Payment processing failed. Please try again later.']);
        }
    }

    /**
     * Render rental history for logged-in member
     */
    public function rentalHistory()
    {
        // session is started in index.php router
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'member') {
            header('Location: /');
            exit;
        }

        $userId = (int)$_SESSION['user_id'];
        $orders = $this->orderModel->getByUserId($userId);

        require __DIR__ . '/../view/rental_history.php';
    }
}

?>
