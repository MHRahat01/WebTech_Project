
<?php



require_once('../controller/autoLogin.php');

if(!isset($_SESSION['status'])){
    header('location: login.php');
}

require_once('../model/db.php');

?>

<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="../asset/css/home.css">
    </head>
<body>

<?php include('navbar.php'); ?>

<h2>Welcome <?=$_SESSION['name']?>  [<?=$_SESSION['role']?>]</h2>

<input type="text" id="search" placeholder="Search car" onkeyup="searchCar()">

<div id="result"></div>

<hr>

<h3>Categories</h3>

<?php

$sql = "SELECT DISTINCT type FROM cars";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
?>

<a href="browse.php?type=<?=$row['type']?>">

    <?=$row['type']?>

</a>

<br><br>

<?php
}
?>

<hr>

<h3>Featured Cars</h3>

<?php

$sql2 = "SELECT * FROM cars LIMIT 4";

$result2 = mysqli_query($conn, $sql2);

while($car = mysqli_fetch_assoc($result2)){
?>

<a href="carDetails.php?id=<?=$car['id']?>">

    <div>

        <img src="../asset/upload/<?=$car['image_path']?>"
             width="200">

        <h3><?=$car['name']?></h3>

        <p><?=$car['model']?></p>

        <p><?=$car['price_per_day']?></p>

    </div>

</a>

<hr>

<?php
}
?>

<script>

function searchCar(){

    let key = document.getElementById('search').value;

    let xhttp = new XMLHttpRequest();

    xhttp.open(
        'GET',
        '../controller/search.php?key='+key,
        true
    );

    xhttp.send();

    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 && this.status == 200){

            document.getElementById('result').innerHTML =
            this.responseText;
        }
    }
}

</script>

</body>
</html>