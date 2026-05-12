<?php

session_start();

if(!isset($_SESSION['role'])){
    header("Location: adminlogin.php");
    exit;
}

require_once "../model/db.php";
require_once "../model/CarModel.php";

$error = '';

if(isset($_POST['add_car'])){

    $name = $_POST['name'];
    $model = $_POST['model'];
    $type = $_POST['type'];
    $price_per_day = $_POST['price_per_day'];
    $availability_status = $_POST['availability_status'];
    $description = $_POST['description'];

    if(addCar($conn, $name, $model, $type, $price_per_day, $availability_status, $description)){
        header("Location: CarList.php");
        exit;
    } else {
        $error = "Unable to add car. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Add New Car</title>
</head>

<body>

    <h2>Add New Car</h2>

    <?php if($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="AddCar.php">

        <label>Name</label><br>
        <input type="text" name="name" required><br><br>

        <label>Model</label><br>
        <input type="text" name="model" required><br><br>

        <label>Type</label><br>
        <input type="text" name="type" required><br><br>

        <label>Price per Day</label><br>
        <input type="number" step="0.01" name="price_per_day" required><br><br>

        <label>Availability Status</label><br>
        <input type="text" name="availability_status" required><br><br>

        <label>Description</label><br>
        <textarea name="description" rows="4"></textarea><br><br>

        <button type="submit" name="add_car">Add Car</button>

    </form>

    <br>
    <a href="CarList.php">Back to Car List</a>

</body>

</html>