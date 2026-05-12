<?php

session_start();

if(!isset($_SESSION['role'])){
    header("Location: adminlogin.php");
    exit;
}

require_once "../model/db.php";
require_once "../model/CarModel.php";

if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: CarList.php");
    exit;
}

$id = $_GET['id'];
$car = getCarById($conn, $id);

if(!$car){
    header("Location: CarList.php");
    exit;
}

$error = '';

if(isset($_POST['update_car'])){
    $name = $_POST['name'];
    $model = $_POST['model'];
    $type = $_POST['type'];
    $price_per_day = $_POST['price_per_day'];
    $availability_status = $_POST['availability_status'];
    $description = $_POST['description'];

    if(updateCar($conn, $id, $name, $model, $type, $price_per_day, $availability_status, $description)){
        header("Location: CarList.php");
        exit;
    } else {
        $error = "Unable to update car. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Car</title>
</head>

<body>

    <h2>Edit Car</h2>

    <?php if($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="EditCar.php?id=<?= urlencode($id) ?>">

        <label>Name</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($car['name']) ?>" required><br><br>

        <label>Model</label><br>
        <input type="text" name="model" value="<?= htmlspecialchars($car['model']) ?>" required><br><br>

        <label>Type</label><br>
        <input type="text" name="type" value="<?= htmlspecialchars($car['type']) ?>" required><br><br>

        <label>Price per Day</label><br>
        <input type="number" step="0.01" name="price_per_day" value="<?= htmlspecialchars($car['price_per_day']) ?>" required><br><br>

        <label>Availability Status</label><br>
        <input type="text" name="availability_status" value="<?= htmlspecialchars($car['availability_status']) ?>" required><br><br>

        <label>Description</label><br>
        <textarea name="description" rows="4"><?= htmlspecialchars($car['description']) ?></textarea><br><br>

        <button type="submit" name="update_car">Update Car</button>

    </form>

    <br>
    <a href="CarList.php">Back to Car List</a>

</body>

</html>