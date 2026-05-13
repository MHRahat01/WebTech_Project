<html>

<head>

    <title>Registration</title>

    <link rel="stylesheet"  href="../asset/css/registration.css">

</head>

<body>

<div class="container">

    <div class="left-panel">

    <div class="logo-box">

        <h1>
            CAR<br>
            <span>RENT</span>
        </h1>

    </div>

</div>

    <div class="right-panel">
        <a href="login.php" class="back-btn">← Back</a>

        <h2>Register</h2>

        <p class="subtitle">
            Create your account. It's free and only takes a minute.
        </p>

        <form method="post"
              action="../controller/regCheck.php"
              onsubmit="return validate()"
              autocomplete="off">

            <input type="text"
                   name="name"
                   id="name"
                   placeholder="Full Name">

            <input type="email"
                   name="email"
                   id="email"
                   placeholder="Email">

            <div class="password-box">

                <input type="password"
                       name="password"
                       id="password"
                       placeholder="Password">

                <button type="button"
                        onclick="showPassword()">
                    Show
                </button>

            </div>

            <textarea name="address"
                      placeholder="Address"></textarea>

            <input type="number"
                   name="phone"
                   placeholder="Phone">

            <select name="role">

                <option value="">
                    Select Role
                </option>

                <option value="member">
                    Member
                </option>

                <option value="admin">
                    Admin
                </option>

            </select>

            <input type="submit"
                   name="submit"
                   value="SIGN UP">

        </form>

        
    </div>

</div>

<script src="../asset/js/showpass.js"></script>

<script src="../asset/js/regValidate.js"></script>

</body>
</html>