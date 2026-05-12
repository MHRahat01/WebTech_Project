<?php

require_once('../model/db.php');

$key = $_REQUEST['key'];

if($key == "" || $key == null){
    exit;
}

$sql = "SELECT * FROM cars WHERE name LIKE '%$key%'";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){

    echo "<a href='../view/carDetails.php?id=".$row['id']."'>".$row['name']."</a><br>";
}

?>