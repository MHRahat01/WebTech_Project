<?php

require_once('../controller/autoLogin.php');

if(!isset($_SESSION['status'])){
    header('location: login.php');
}

require_once('../model/db.php');

$id = $_GET['id'];

$sql = "SELECT * FROM cars WHERE id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$car = mysqli_fetch_assoc($result);

?>

<html>
<head>
</head>

<body>

<?php include('navbar.php'); ?>

<a href="browse.php">Back</a>

<hr>

<img src="../asset/upload/<?=$car['image_path']?>"
     width="300">

<h2><?=$car['name']?></h2>

<h3><?=$car['model']?></h3>

<p><?=$car['type']?></p>

<p><?=$car['price_per_day']?></p>

<p><?=$car['description']?></p>

</body>
</html>