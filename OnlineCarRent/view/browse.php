<?php

require_once('../controller/autoLogin.php');

if(!isset($_SESSION['status'])){
    header('location: login.php');
}

require_once('../model/db.php');

$type = "";

if(isset($_GET['type'])){

    $type = $_GET['type'];

    $sql = "SELECT * FROM cars WHERE type=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $type);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

}else{

    $sql = "SELECT * FROM cars";

    $result = mysqli_query($conn, $sql);
}

?>

<html>
<head>
</head>

<body>

<?php include('navbar.php'); ?>

<a href="home.php">Back</a>

<hr>

<h2>

<?php

if($type != ""){
    echo $type;
}else{
    echo "All Cars";
}

?>

</h2>

<?php

while($car = mysqli_fetch_assoc($result)){
?>

<a href="carDetails.php?id=<?=$car['id']?>">

<div>

    <img src="../asset/upload/<?=$car['image_path']?>"
         width="200">

    <h3><?=$car['name']?></h3>

</div>

</a>

<hr>

<?php
}
?>

</body>
</html>