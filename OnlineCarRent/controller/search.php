<?php

require_once('../model/db.php');

$key = $_REQUEST['key'];

$sql = "SELECT * FROM cars WHERE name LIKE '%$key%'";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){

    echo $row['name']."<br>";
}

?>