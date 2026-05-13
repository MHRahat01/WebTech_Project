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
<br><br>

<a href="../logout.php">

Logout

</a>
<br><br>

<a href="CarList.php">

    Manage Cars

</a>
<br><br>


<a href="MemberList.php">

    Members

</a>
<br><br>

<a href="OrderHistory.php">

    Orders

</a>