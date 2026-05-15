<?php
session_start();

// Quick demo login for convenience
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

// Keep demo member logged-in by default (unless explicitly logged out)
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

$action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch ($action) {
    case 'car_details':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $controller = new CarController();
        $controller->details($id);
        break;

    case 'calculate_total':
        $oc = new OrderController();
        $oc->calculateTotal();
        break;

    case 'place_order':
        $oc = new OrderController();
        $oc->placeOrder();
        break;

    case 'cancel_order':
        $oc = new OrderController();
        $oc->cancelOrder();
        break;

    case 'finalize_order':
        $oc = new OrderController();
        $oc->finalizeOrder();
        break;

    case 'invoice':
        $orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
        $oc = new OrderController();
        if ($orderId > 0) {
            $oc->invoice($orderId);
        } else {
            echo '<p>Invalid order id.</p>';
        }
        break;

    case 'finalize_order':
        echo '<h2>Finalize order (placeholder)</h2>';
        break;

    case 'order_placement':
        echo '<h2>Order placement (placeholder)</h2>';
        break;

    case 'invoice':
        echo '<h2>Invoice (placeholder)</h2>';
        break;

    case 'rental_history':
        $oc = new OrderController();
        $oc->rentalHistory();
        break;

    case 'home':
    default:
        require_once __DIR__ . '/model/db.php';
        $db = getPDO();
        $stmt = $db->query('SELECT id, name, model, price_per_day, image_path FROM cars');
        $cars = $stmt->fetchAll();

        echo '<!doctype html><html><head><meta charset="utf-8"><title>Car Listing</title>';
    echo '<link rel="stylesheet" href="asset/css/style.css">';
        echo '</head><body>';
        // show member menu if available
        if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'member') {
            if (file_exists(__DIR__ . '/view/member_menu.php')) {
                require __DIR__ . '/view/member_menu.php';
            }
        }
        echo '<div class="container">';
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
            $rawPath = trim((string)($car['image_path'] ?? ''));
            if ($rawPath === '') {
                $img = 'asset/img/placeholder.svg';
            } elseif ($rawPath === 'car1.avif' || stripos($rawPath, 'car1') !== false) {
                // map common demo filename to existing AVIF in repo
                $img = 'asset/img/photo-1614200179396-2bdb77ebf81b.avif';
            } elseif (preg_match('#^(https?://|/)#', $rawPath)) {
                $img = htmlspecialchars($rawPath);
            } elseif (strpos($rawPath, '/') !== false) {
                $img = htmlspecialchars($rawPath);
            } else {
                // try asset/img first
                $candidate = __DIR__ . '/asset/img/' . $rawPath;
                if (file_exists($candidate)) {
                    $img = 'asset/img/' . rawurlencode($rawPath);
                } else {
                    // only use uploads/cars if file exists; otherwise fallback to AVIF placeholder
                    $upCandidate = __DIR__ . '/uploads/cars/' . $rawPath;
                    if (file_exists($upCandidate)) {
                        $img = 'uploads/cars/' . rawurlencode($rawPath);
                    } else {
                        $img = 'asset/img/photo-1614200179396-2bdb77ebf81b.avif';
                    }
                }
            }
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
