<?php
// model/OrderModel.php
require_once __DIR__ . '/db.php';

class OrderModel
{
    /** @var PDO */
    private $db;

    public function __construct()
    {
        $this->db = getPDO();
    }

    /**
     * Create a new order.
     * $data must contain: user_id, car_id, start_date, end_date, total_cost
     * Returns inserted order id on success, false on failure.
     */
    public function create(array $data)
    {
        $sql = "INSERT INTO orders (user_id, car_id, start_date, end_date, total_cost, status, order_date) VALUES (:user_id, :car_id, :start_date, :end_date, :total_cost, :status, NOW())";
        $stmt = $this->db->prepare($sql);
        $params = [
            ':user_id' => $data['user_id'],
            ':car_id' => $data['car_id'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':total_cost' => $data['total_cost'],
            ':status' => $data['status'] ?? 'pending',
        ];

        if ($stmt->execute($params)) {
            return (int)$this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Fetch an order by id.
     */
    public function getById(int $orderId)
    {
        $sql = 'SELECT * FROM orders WHERE id = :id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $orderId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Update order status.
     */
    public function updateStatus(int $orderId, string $status)
    {
        $sql = 'UPDATE orders SET status = :status WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':status' => $status, ':id' => $orderId]);
    }
}

?>
