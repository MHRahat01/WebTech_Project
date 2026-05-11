<?php

session_start();

require_once "../model/db.php";
require_once "../model/UserModel.php";


// ======================================
// ADMIN LOGIN---------------------------

if(isset($_POST['login'])){

    $email = $_POST['email'];

    $password = $_POST['password'];

    $admin = adminLogin($conn, $email, $password);

    // LOGIN SUCCESS
    if($admin){

        $_SESSION['id'] = $admin['id'];

        $_SESSION['name'] = $admin['name'];

        $_SESSION['role'] = $admin['role'];

        header("Location: ../view/AdminDashboard.php");
    }

    // LOGIN FAILED
    else{

        echo "Invalid Email or Password";
    }
}

?>