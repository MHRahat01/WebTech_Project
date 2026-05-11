<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['role'] = 'member';
}

spl_autoload_register(function ($class) {
    $paths = [__DIR__ . '/controller/' . $class . '.php', __DIR__ . '/model/' . $class . '.php'];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'car_details':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $controller = new CarController();
        $controller->details($id);
        break;

    case 'order_placement':
        echo '<h2>Order placement (placeholder) - Day 1</h2>';
        break;

    case 'invoice':
        echo '<h2>Invoice (placeholder) - Day 1</h2>';
        break;

    case 'rental_history':
        echo '<h2>Rental history (placeholder) - Day 1</h2>';
        break;

    case 'home':
    default:
        echo '<h1>Welcome to Online Car Rent - Day 1</h1>';
        echo '<p>Use ?action=car_details&id=1 to view car details (if a car with id=1 exists).</p>';
        break;
}

?>
<?php
session_start();

if (isset($_GET['login']) && $_GET['login'] === 'member') {
    $_SESSION['user_id'] = 1;
    $_SESSION['role'] = 'member';
    header('Location: /');
    exit;
}
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: /');
    exit;
}

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/controller/' . $class . '.php',
        __DIR__ . '/model/' . $class . '.php',
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

    $action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch ($action) {
    case 'car_details':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $controller = new CarController();
        $controller->details($id);
        break;

    case 'order_placement':
        echo '<h2>Order Placement Coming</h2>';
        break;

    case 'invoice':
        echo '<h2>Invoice Coming </h2>';
        break;

    case 'rental_history':
         echo '<h2>Rental History Coming</h2>';
        break;

    default:
    require_once __DIR__ . '/model/db.php';
    $db = getPDO();
    $stmt = $db->query('SELECT id, name, model, price_per_day, image_path FROM cars');
        $cars = $stmt->fetchAll();

        echo '<!doctype html><html><head><meta charset="utf-8"><title>Car Listing</title>';
        echo '<link rel="stylesheet" href="/asset/css/style.css">';
        echo '</head><body><div class="container">';
        echo '<header><h1>Car Rental</h1>';
        if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'member') {
            echo '<div class="user-info">Logged in as member | <a href="?logout=1">Logout</a></div>';
        } else {
            echo '<div class="user-info">Not logged in | <a href="?login=member">Login as demo member</a></div>';
        }
        echo '</header>';

        echo '<div class="grid">';
        foreach ($cars as $car) {
            $name = htmlspecialchars($car['name']);
            $model = htmlspecialchars($car['model']);
            $price = htmlspecialchars($car['price_per_day']);
            $img = $car['image_path'] ? htmlspecialchars($car['image_path']) : '/asset/img/placeholder.png';
            echo '<div class="card">';
            echo '<img src="' . $img . '" alt="' . $name . '">';
            echo '<div class="card-body">';
            echo '<h3>' . $name . '</h3>';
            echo '<p>' . $model . '</p>';
            echo '<p class="price">Price/day: ' . $price . '</p>';
            echo '<a class="btn" href="?action=car_details&id=' . $car['id'] . '">View Details</a>';
            echo '</div></div>';
        }
        echo '</div></div></body></html>';
        break;
}

?>
