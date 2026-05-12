<?php

// ======================================
// GET ALL CARS
// ======================================

function getAllCars($conn){

    $result = mysqli_query(

        $conn,

        "SELECT * FROM cars
        ORDER BY id ASC"

    );

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// ======================================
// ADD NEW CAR
// ======================================

function addCar($conn, $name, $model, $type, $price_per_day, $availability_status, $description){

    $name = mysqli_real_escape_string($conn, $name);
    $model = mysqli_real_escape_string($conn, $model);
    $type = mysqli_real_escape_string($conn, $type);
    $price_per_day = mysqli_real_escape_string($conn, $price_per_day);
    $availability_status = mysqli_real_escape_string($conn, $availability_status);
    $description = mysqli_real_escape_string($conn, $description);

    $query = "INSERT INTO cars (name, model, type, price_per_day, availability_status, description) VALUES ('$name', '$model', '$type', '$price_per_day', '$availability_status', '$description')";

    return mysqli_query($conn, $query);
}

// ======================================
// GET CAR BY ID
// ======================================

function getCarById($conn, $id){
    $id = mysqli_real_escape_string($conn, $id);

    $result = mysqli_query(
        $conn,
        "SELECT * FROM cars WHERE id='$id'"
    );

    return mysqli_fetch_assoc($result);
}

// ======================================
// UPDATE CAR
// ======================================

function updateCar($conn, $id, $name, $model, $type, $price_per_day, $availability_status, $description){
    $id = mysqli_real_escape_string($conn, $id);
    $name = mysqli_real_escape_string($conn, $name);
    $model = mysqli_real_escape_string($conn, $model);
    $type = mysqli_real_escape_string($conn, $type);
    $price_per_day = mysqli_real_escape_string($conn, $price_per_day);
    $availability_status = mysqli_real_escape_string($conn, $availability_status);
    $description = mysqli_real_escape_string($conn, $description);

    $query = "UPDATE cars SET name='$name', model='$model', type='$type', price_per_day='$price_per_day', availability_status='$availability_status', description='$description' WHERE id='$id'";

    return mysqli_query($conn, $query);
}

// ======================================
// DELETE CAR
// ======================================

function deleteCar($conn, $id){
    $id = mysqli_real_escape_string($conn, $id);
    $query = "DELETE FROM cars WHERE id='$id'";

    return mysqli_query($conn, $query);
}

?>