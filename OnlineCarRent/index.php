<?php
session_start();

if (isset($_GET['login_as_member'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['role'] = 'member';
    header('Location: index.php');
    exit;
}
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/controllers/' . $class . '.php',
        __DIR__ . '/models/' . $class . '.php',
        __DIR__ . '/config/' . $class . '.php',
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$action = isset($_GET['action']) ? $_GET['action'] : 'home';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

switch ($action) {
    case 'car_details':
        $controller = new CarController();
        $controller->details($id);
        break;
    case 'order_placement':
        echo "<h1>Order Placement coming</h1>";
        break;
    case 'invoice':
        // Placeholder for Day1
        echo "<h1>Invoice coming</h1>";
        break;
    case 'rental_history':
        // Placeholder for Day1
        echo "<h1>Rental History coming in</h1>";
        break;
    case 'home':
    default:
        // Minimal homepage for testing
        ?>
        <!doctype html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width,initial-scale=1">
            <title>Online Car Rent - Home (Day1)</title>
            <link rel="stylesheet" href="asset/assets/css/style.css">
        </head>
        <body>
            <div class="container">
                <header class="site-header">
                    <h1>Online Car Rent (Day 1)</h1>
                    <nav>
                        <a href="index.php?action=home">Home</a>
                        <a href="index.php?action=car_details&id=1">View Sample Car</a>
                        <a href="index.php?action=rental_history">Rental History</a>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'member'): ?>
                            <span>Logged in as member</span>
                            <a href="index.php?logout=1">Logout</a>
                        <?php else: ?>
                            <a href="index.php?login_as_member=1">Login as Member (test)</a>
                        <?php endif; ?>
                    </nav>
                </header>

                <main>
                    <p>Use <a href="index.php?action=car_details&id=1">car details</a> to view the Day 1 feature.</p>
                </main>

                <footer>
                    <p>&copy; Online Car Rent - Day 1</p>
                </footer>
            </div>
        </body>
        </html>
        <?php
        break;
}

?>
