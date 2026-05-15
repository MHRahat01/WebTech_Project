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
     * Fetch all orders for a given user id, joined with cars table for display.
     * Returns an array of orders with car information.
     */
    public function getByUserId(int $userId)
    {
        $sql = 'SELECT o.id, o.user_id, o.car_id, o.start_date, o.end_date, o.total_cost, o.status, o.order_date, c.name as car_name, c.model as car_model'
             . ' FROM orders o'
             . ' LEFT JOIN cars c ON c.id = o.car_id'
             . ' WHERE o.user_id = :uid'
             . ' ORDER BY o.order_date DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll();
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
