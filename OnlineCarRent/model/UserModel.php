<?php

// ======================================
// ADMIN LOGIN
// ======================================

function adminLogin($conn, $email, $password){

    $result = mysqli_query(

        $conn,

        "SELECT * FROM users

        WHERE email='$email'

        AND password_hash='$password'

        AND role='admin'"

    );

    return mysqli_fetch_assoc($result);
}

?>