<?php

require_once('../controller/autoLogin.php');

if(!isset($_SESSION['status'])){
    header('location: login.php');
}

require_once('../model/userModel.php');

$user = getUserByEmail($_SESSION['email']);

?>

<html>
<head>
</head>

<body>

<?php include('navbar.php'); ?>

<a href="home.php">Back</a>

<hr>

<?php

if(isset($_GET['success'])){
    echo "<h3>Profile Updated Successfully</h3>";
}

if(isset($_GET['pass'])){
    echo "<h3>Password Changed Successfully</h3>";
}

?>

<form method="post"
      action="../controller/profileCheck.php"
      enctype="multipart/form-data"
      onsubmit="return validateProfile()">

    Name:
    <input type="text"
           id="name"
           name="name"
           value="<?=$user['name']?>">

    <br><br>

    Email:
    <input type="email"
           name="email"
           value="<?=$user['email']?>">

    <br><br>

    Address:
    <textarea name="address"><?=$user['address']?></textarea>

    <br><br>

    Phone:
    <input type="text"
           name="phone"
           value="<?=$user['phone']?>">

    <br><br>

    Profile Picture:
    <input type="file" name="mypic">

    <br><br>

    <input type="submit" value="Update">

</form>

<hr>

<h3>Change Password</h3>

<form method="post"
      action="../controller/changePassword.php">

    Current Password:
    <input type="password" name="current_password">

    <br><br>

    New Password:
    <input type="password" name="new_password">

    <br><br>

    <input type="submit" value="Change Password">

</form>

<script>

function validateProfile(){

    let name = document.getElementById('name').value;

    if(name == ""){
        alert("Name required");
        return false;
    }

    return true;
}

</script>

</body>
</html>