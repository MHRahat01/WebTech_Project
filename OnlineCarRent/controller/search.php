<?php

require_once('../model/db.php');

$key = $_REQUEST['key'];

if($key == "" || $key == null){
    exit;
}

$sql = "SELECT * FROM cars WHERE name LIKE ?";

$stmt = mysqli_prepare($conn, $sql);

$search = "%".$key."%";

mysqli_stmt_bind_param($stmt, "s", $search);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$data = [];

while($row = mysqli_fetch_assoc($result)){

    $data[] = $row;
}

echo json_encode($data);

?>