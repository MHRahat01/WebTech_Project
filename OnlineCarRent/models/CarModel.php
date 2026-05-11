<?php
// models/CarModel.php
// Simple Car model with method to fetch a car by id using PDO

class CarModel
{
    protected $pdo;

    public function __construct()
    {
        // Use the config Database PDO singleton
        $this->pdo = Database::getInstance();
    }

    /**
     * Get a car row by its ID
     * @param int $id
     * @return array|null
     */
    public function getById($id)
    {
        $sql = 'SELECT id, name, model, price_per_day, image FROM cars WHERE id = :id LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        if ($row === false) {
            return null;
        }
        return $row;
    }
}

?>
