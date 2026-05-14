<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: adminlogin.php");
}

require_once "../model/db.php";
require_once "../model/OrderModel.php";


// ======================================
// DEFAULT SHOW ALL ORDER
// ======================================

$orders = getAllOrders($conn);


// ======================================
// FILTER ORDER
// ======================================

if(isset($_GET['filter'])){

    $filter_type = $_GET['filter_type'];


    // STATUS FILTER

    if($filter_type == "status"){

        $status = $_GET['status'];

        if($status != ""){

            $orders = getOrdersByStatus(
                $conn,
                $status
            );
        }
    }


    // DATE FILTER

    if($filter_type == "date"){

        $from_date = $_GET['from_date'];

        $to_date = $_GET['to_date'];

        if(
            $from_date != ""
            &&
            $to_date != ""
        ){

            $orders = getOrdersByDate(
                $conn,
                $from_date,
                $to_date
            );
        }
    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Order History</title>

</head>

<body>

<h2>Order History</h2>

<br>

<a href="AdminDashboard.php">

    Back to Dashboard

</a>

<br><br>


<!-- FILTER BAR -->

<form method="GET">


    <!-- FILTER TYPE -->

    <select name="filter_type">

        <option value="all">

            All Orders

        </option>

        <option value="status">

            Filter By Status

        </option>

        <option value="date">

            Filter By Date

        </option>

    </select>

    <br><br>


    <!-- STATUS -->

    <select name="status">

        <option value="">

            Select Status

        </option>

        <option value="Pending">

            Pending

        </option>

        <option value="Approved">

            Approved

        </option>

        <option value="Completed">

            Completed

        </option>

    </select>

    <br><br>


    <!-- DATE -->

    From :

    <input
    type="date"
    name="from_date">


    To :

    <input
    type="date"
    name="to_date">

    <br><br>


    <!-- BUTTON -->

    <button
    type="submit"
    name="filter">

        Apply Filter

    </button>


    <a href="OrderHistory.php">

        Reset

    </a>

</form>

<br><br>


<!-- ORDER TABLE -->

<table
border="1"
cellpadding="10">

<tr>

    <th>Order ID</th>

    <th>Member Name</th>

    <th>Car Name/Model</th>

    <th>Rental Dates</th>

    <th>Total Cost</th>

    <th>Status</th>

    <th>Payment Method</th>

    <th>Order Date</th>

</tr>


<?php if(!empty($orders)){ ?>

<?php foreach($orders as $order){ ?>

<tr>

    <td><?= $order['id'] ?></td>

    <td><?= $order['member_name'] ?></td>

    <td><?= $order['car_name_model'] ?></td>

    <td>

        <?= $order['start_date'] ?>

        to

        <?= $order['end_date'] ?>

    </td>

    <td><?= $order['total_cost'] ?></td>

    <td><?= $order['status'] ?></td>

    <td><?= $order['payment_method'] ?></td>

    <td><?= $order['order_date'] ?></td>

</tr>

<?php } ?>

<?php } ?>


<?php if(empty($orders)){ ?>

<tr>

    <td
    colspan="8"
    align="center">

        No Orders Found

    </td>

</tr>

<?php } ?>

</table>

</body>

</html>