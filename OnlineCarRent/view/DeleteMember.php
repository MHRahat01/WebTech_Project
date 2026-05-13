<?php

session_start();

if(!isset($_SESSION['role'])){
    header("Location: adminlogin.php");
    exit;
}

require_once "../model/db.php";
require_once "../model/UserModel.php";

if(isset($_POST['delete_member']) && isset($_POST['id'])){
    $id = intval($_POST['id']);
    deleteMember($conn, $id);
}

header("Location: MemberList.php");
exit;

?>