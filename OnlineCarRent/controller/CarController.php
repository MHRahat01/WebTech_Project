<?php
require_once __DIR__ . '/../model/CarModel.php';

class CarController
{
    private $model;

    public function __construct()
    {
        $this->model = new CarModel();
    }

    public function details(int $id)
    {
        if ($id <= 0) {
            echo '<p>Invalid car id</p>';
            return;
        }

        $car = $this->model->getById($id);
        if (!$car) {
            echo '<p>Car not found</p>';
            return;
        }

        $isMember = (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'member');

        require __DIR__ . '/../view/car_details.php';
    }
}

?>
