<?php
// controllers/CarController.php
require_once __DIR__ . '/../models/CarModel.php';

class CarController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CarModel();
    }

    /**
     * Show details for a car
     * If user is logged in and role == 'member', show order form.
     * Otherwise, show public view with login prompt.
     */
    public function details($id)
    {
        if (!$id) {
            header('HTTP/1.1 400 Bad Request');
            echo 'Invalid car id.';
            return;
        }

        $car = $this->model->getById($id);
        if (!$car) {
            header('HTTP/1.1 404 Not Found');
            echo 'Car not found.';
            return;
        }

        // Determine if current session is a member
        $isMember = isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'member';

        // Render view
        require_once __DIR__ . '/../views/car_details.php';
    }
}

?>
