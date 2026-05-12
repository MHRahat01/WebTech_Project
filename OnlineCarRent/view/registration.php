<html>
<head>
    <title>Registration</title>
    <a
</head>

<body>

<form method="post" action="../controller/regCheck.php" onsubmit="return validate()" autocomplete="off">

    Name:
    <input type="text" name="name" id="name"> <br><br>

    Email:
    <input type="email" name="email" id="email"> <br><br>

    Password:
    <input type="password" name="password" id="password"> 

    <label>
    <input type="checkbox" onclick="togglePassword()"> Show Password
    </label><br><br>

    

    Address:
    <textarea name="address"></textarea> <br><br>

    Phone:
    <input type="number" name="phone"> <br><br>

    Role:
    <select name="role">
        <option value="">Select Role</option>
        <option value="member">Member</option>
        <option value="admin">Admin</option>
    </select>

    <br><br>

    <input type="submit" name="submit" value="Register">

</form>
<script src="../asset/js/showpass.js"></script>
<script src="../asset/js/regValidate.js"></script>

</body>
</html>