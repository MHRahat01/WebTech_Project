<html>

<head>

    <title>Login</title>

    <link rel="stylesheet" href="../asset/css/login.css">

</head>

<body>

<div class="container">

    <div class="left-panel">

        <h1>WELCOME</h1>

        <h3>ONLINE CAR RENTAL</h3>

        <p>
            Rent your favourite cars easily and
            explore different categories with comfort.
        </p>

        <div class="circle big"></div>
        <div class="circle small"></div>

    </div>

    <div class="right-panel">

        <h2>Sign in</h2>

        <form method="post"
              action="../controller/loginCheck.php">

            <label>Email</label>

            <input type="email"
                   name="email"
                   placeholder="Enter email">

            <label>Password</label>

            <div class="password-box">

                <input type="password"
                       name="password"
                       id="password"
                       placeholder="Enter password">

                <button type="button"
                        onclick="showPassword()">
                    Show
                </button>

            </div>

            <div class="remember">

                <div>

                    <input type="checkbox" name="remember">

                    Remember me

                </div>

            </div>

            <input type="submit"
                   value="Sign in">

        </form>

        <p class="signup">

            Don't have an account?

            <a href="registration.php">
                Sign Up
            </a>

        </p>

    </div>

</div>

<script src="../asset/js/showpass.js"></script>

</body>
</html>