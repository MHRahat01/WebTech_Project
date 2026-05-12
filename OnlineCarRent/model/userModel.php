<?php

require_once('db.php');

function insertUser($user) {

    global $conn;

    $sql = "INSERT INTO users
    (name, email, password_hash, role, address, phone)
    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $user['name'],
        $user['email'],
        $user['password'],
        $user['role'],
        $user['address'],
        $user['phone']
    );

    return mysqli_stmt_execute($stmt);
}


function getUserByEmail($email) {

    global $conn;

    $sql = "SELECT * FROM users WHERE email=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}


function updateProfile($user) {

    global $conn;

    $sql = "UPDATE users
            SET name=?,
                email=?,
                address=?,
                phone=?,
                profile_picture=?
            WHERE id=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssi",
        $user['name'],
        $user['email'],
        $user['address'],
        $user['phone'],
        $user['profile_picture'],
        $user['id']
    );

    return mysqli_stmt_execute($stmt);
}

?>