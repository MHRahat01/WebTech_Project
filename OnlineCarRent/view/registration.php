<html>
<head>
    <title>Registration</title>
</head>

<body>

<form method="post"
      action="../controller/regCheck.php"
      onsubmit="return validate()">

    Name:
    <input type="text" name="name" id="name"> <br><br>

    Email:
    <input type="email" name="email" id="email"> <br><br>

    Password:
    <input type="password" name="password" id="password"> <br><br>

    Address:
    <textarea name="address"></textarea> <br><br>

    Phone:
    <input type="text" name="phone"> <br><br>

    Role:
    <select name="role">
        <option value="member">Member</option>
        <option value="admin">Admin</option>
    </select>

    <br><br>

    <input type="submit" name="submit" value="Register">

</form>

<script>

function validate(){

    let name = document.getElementById('name').value;
    let password = document.getElementById('password').value;

    if(name == ""){
        alert("Name required");
        return false;
    }

    if(password.length < 8){
        alert("Password must be 8 characters");
        return false;
    }

    return true;
}

</script>

</body>
</html>