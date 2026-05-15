<?php
// model/CarModel.php
// Provides car-related DB operations using PDO (getPDO helper in model/db.php)
require_once __DIR__ . '/db.php';

class CarModel
{
    /** @var PDO */
    private $db;

    public function __construct()
    {
        $this->db = getPDO();
    }

    /**
     * Get a car row by its id.
     * Returns associative array or null.
     */
    public function getById(int $id)
    {
        $sql = 'SELECT * FROM cars WHERE id = :id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Check if a car is available for the given date range.
     * Returns true if no overlapping orders exist with status pending or confirmed.
     */
    public function isAvailable(int $carId, string $startDate, string $endDate): bool
    {
        $sql = "SELECT COUNT(*) as cnt FROM orders WHERE car_id = :car_id AND status IN ('pending','confirmed') AND NOT (end_date <= :start_date OR start_date >= :end_date)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':car_id' => $carId, ':start_date' => $startDate, ':end_date' => $endDate]);
        $row = $stmt->fetch();
        return isset($row['cnt']) && (int)$row['cnt'] === 0;
    }
}

?>
