<?php
// view/member_menu.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'member') return;
?>
<nav class="navbar">
    <div class="nav-left">
        <div class="brand">
            <img src="/WebTech_Project/OnlineCarRent/asset/img/photo-1614200179396-2bdb77ebf81b.avif" alt="logo">
            <div class="title">OnlineCarRent</div>
        </div>
    </div>
    <div class="nav-right">
        <div class="user-badge">Member</div>
        <a class="logout" href="?action=rental_history">My Rentals</a>
        <a class="logout" href="?logout=1">Logout</a>
    </div>
</nav>
