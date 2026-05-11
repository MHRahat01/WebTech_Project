<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: adminlogin.php");
}

?>

<h1>

Welcome :
<?= $_SESSION['name'] ?>

</h1>

<a href="../logout.php">

Logout

</a>