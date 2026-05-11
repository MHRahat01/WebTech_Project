<?php

require_once('../model/userModel.php');

$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$address = $_REQUEST['address'];
$phone = $_REQUEST['phone'];
$role = $_REQUEST['role'];

if($name == "" || $email == "" || $password == ""){

    echo "Null data found!";
}
else{

    $checkUser = getUserByEmail($email);

    if($checkUser){
        echo "Email already exists";
    }
    else{

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $user = [
            'name'=>$name,
            'email'=>$email,
            'password'=>$hashPassword,
            'role'=>$role,
            'address'=>$address,
            'phone'=>$phone
        ];

        $status = insertUser($user);

        if($status){
            header('location: ../view/login.php');
        }else{
            echo "Database Error";
        }
    }
}

?>