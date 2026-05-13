<link rel="stylesheet" href="../asset/css/nav.css">

<div class="nav">

    <div class="left-links">
        <a href="home.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="browse.php">Browse Cars</a>
        <a href="blog.php">Blog</a>
        <a href="orderHistory.php">Order History</a>
    </div>

    <div class="right-links">

        <?php
        if($_SESSION['role'] == 'admin'){
        ?>
            <a href="#">Admin Dashboard</a>
        <?php
        }
        ?>

        <a href="../controller/logout.php">Logout</a>

    </div>

</div>

<hr>
