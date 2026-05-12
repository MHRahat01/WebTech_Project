<?php

session_start();
require_once('../model/db.php');

if(!isset($_SESSION['status'])){

    if(isset($_COOKIE['remember_token'])){

        $token = $_COOKIE['remember_token'];

        $sql = "SELECT * FROM users WHERE remember_token=?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "s", $token);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $user = mysqli_fetch_assoc($result);

        if($user){

            $_SESSION['status'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
        }
    }
}

?>