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
}

?>
