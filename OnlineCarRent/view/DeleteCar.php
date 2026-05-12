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

deleteCar($conn, $id);
header("Location: CarList.php");
exit;

?>