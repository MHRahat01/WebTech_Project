<?php

// ======================================
// GET ALL ORDERS
// ======================================

function getAllOrders($conn){

    $result = mysqli_query(

        $conn,

        "SELECT

        orders.*,
        users.name AS member_name,
        CONCAT(cars.name,' ',cars.model) AS car_name_model

        FROM orders

        JOIN users
        ON orders.user_id = users.id

        JOIN cars
        ON orders.car_id = cars.id

        ORDER BY orders.id DESC"

    );

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}



// ======================================
// FILTER ORDERS BY STATUS
// ======================================

function getOrdersByStatus($conn, $status){

    $result = mysqli_query(

        $conn,

        "SELECT

        orders.*,
        users.name AS member_name,
        CONCAT(cars.name,' ',cars.model) AS car_name_model

        FROM orders

        JOIN users
        ON orders.user_id = users.id

        JOIN cars
        ON orders.car_id = cars.id

        WHERE orders.status='$status'

        ORDER BY orders.id DESC"

    );

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>