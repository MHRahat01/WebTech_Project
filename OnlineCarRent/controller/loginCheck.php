<?php

session_start();

require_once('../model/userModel.php');
require_once('../model/db.php');

$email = $_REQUEST['email'];
$password = $_REQUEST['password'];

$user = getUserByEmail($email);

if($user){

    if(password_verify($password, $user['password_hash'])){

        $_SESSION['status'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        if(isset($_REQUEST['remember'])){

            $token = bin2hex(random_bytes(16));

            setcookie(
                "remember_token",
                $token,
                time() + (86400 * 30),
                "/"
            );

            $sql = "UPDATE users SET remember_token=? WHERE id=?";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "si",
                $token,
                $user['id']
            );

            mysqli_stmt_execute($stmt);
        }

        header('location: ../view/home.php');

    }else{

        echo "
        <script>
            alert('Invalid password');
            window.location.href='../view/login.php';
        </script>
        ";
    }

}else{

    echo "
    <script>
        alert('User not found');
        window.location.href='../view/login.php';
    </script>
    ";
}

?>