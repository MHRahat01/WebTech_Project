<a href="home.php">Home</a>

<a href="profile.php">Profile</a>

<a href="browse.php">Browse Cars</a>

<?php

if($_SESSION['role'] == 'admin'){
?>

<a href="#">Admin Panel</a>

<?php
}
?>

<a href="../controller/logout.php">Logout</a>


<hr>