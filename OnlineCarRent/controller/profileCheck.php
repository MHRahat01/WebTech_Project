<?php

session_start();

require_once('../model/userModel.php');

$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$address = $_REQUEST['address'];
$phone = $_REQUEST['phone'];

$picture = "";

if($_FILES['mypic']['name'] != ""){

    $fileName = $_FILES['mypic']['name'];
    $tmpName = $_FILES['mypic']['tmp_name'];

    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $newName = time().".".$ext;

    $path = "../asset/upload/profile/".$newName;

    move_uploaded_file($tmpName, $path);

    $picture = $newName;
}

$user = [
    'id'=>$_SESSION['id'],
    'name'=>$name,
    'email'=>$email,
    'address'=>$address,
    'phone'=>$phone,
    'profile_picture'=>$picture
];

$status = updateProfile($user);

if($status){

    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;

    header('location: ../view/profile.php?success=1');

}else{
    echo "Update failed";
}

?>