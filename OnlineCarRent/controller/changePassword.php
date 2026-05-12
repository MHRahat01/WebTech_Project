<?php

session_start();

require_once('../model/db.php');
require_once('../model/userModel.php');

$currentPassword = $_REQUEST['current_password'];
$newPassword = $_REQUEST['new_password'];

$email = $_SESSION['email'];

$user = getUserByEmail($email);

if(password_verify($currentPassword, $user['password_hash'])){

    $newHash = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password_hash=? WHERE id=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $newHash,
        $_SESSION['id']
    );

    mysqli_stmt_execute($stmt);

    echo "
    <script>
        alert('Password changed successfully');
        window.location.href='../view/profile.php';
    </script>
    ";

}else{

    echo "
    <script>
        alert('Current password incorrect');
        window.location.href='../view/profile.php';
    </script>
    ";
}

?>