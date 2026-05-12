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

    $id = (int)$user['id'];

    $sql = "UPDATE users SET 
    name='{$user['name']}',
    email='{$user['email']}',
    address='{$user['address']}',
    phone='{$user['phone']}',
    profile_picture='{$user['profile_picture']}'
    WHERE id=$id";

    return mysqli_query($conn, $sql);
}

?>