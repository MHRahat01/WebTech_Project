<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
</head>

<body>

<h2>Admin Login</h2>

<form
method="POST"
action="../controller/AdminController.php">

    Email: <input
    type="email"
    name="email"
    placeholder="Email"
    required>

    <br><br>

    Password: <input
    type="password"
    name="password"
    placeholder="Password"
    required>

    <br><br>

    <button type="submit" name="login">
        Login
    </button>

</form>

</body>
</html>