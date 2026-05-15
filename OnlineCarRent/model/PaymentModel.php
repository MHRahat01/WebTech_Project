<?php
// model/PaymentModel.php
require_once __DIR__ . '/db.php';

class PaymentModel
{
    /** @var PDO */
    private $db;

    public function __construct()
    {
        $this->db = getPDO();
    }

    /**
     * Create a payment record.
     * $data must contain: order_id, amount, payment_method, transaction_id
     */
    public function create(array $data)
    {
        $sql = 'INSERT INTO payments (order_id, amount, payment_method, transaction_id, payment_date) VALUES (:order_id, :amount, :payment_method, :transaction_id, NOW())';
        $stmt = $this->db->prepare($sql);
        $params = [
            ':order_id' => $data['order_id'],
            ':amount' => $data['amount'],
            ':payment_method' => $data['payment_method'],
            ':transaction_id' => $data['transaction_id'],
        ];
        if ($stmt->execute($params)) {
            return (int)$this->db->lastInsertId();
        }
        return false;
    }
}

?>
