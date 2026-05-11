<?php

$conn = mysqli_connect(
    'localhost',
    'root',
    '',
    'online_car_rent'
);

if(!$conn){
    die("Database connection error");
}

?>