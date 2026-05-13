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


// ======================================
// GET ALL MEMBERS
// ======================================

function getAllMembers($conn){

    $result = mysqli_query(

        $conn,

        "SELECT * FROM users

        WHERE role='member'

        ORDER BY id ASC"

    );

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// ======================================
// DELETE MEMBER
// ======================================

function deleteMember($conn, $id){

    $userId = intval($id);

    // Delete payments for the user's orders first
    $orderResult = mysqli_query(
        $conn,
        "SELECT id FROM orders WHERE user_id=$userId"
    );

    if($orderResult){
        $orderIds = [];
        while($order = mysqli_fetch_assoc($orderResult)){
            $orderIds[] = intval($order['id']);
        }

        if(!empty($orderIds)){
            $orderIdsList = implode(',', $orderIds);
            mysqli_query(
                $conn,
                "DELETE FROM payments WHERE order_id IN ($orderIdsList)"
            );
        }
    }

    // Delete orders, blogs, then the member account
    mysqli_query(
        $conn,
        "DELETE FROM orders WHERE user_id=$userId"
    );

    mysqli_query(
        $conn,
        "DELETE FROM blogs WHERE user_id=$userId"
    );

    mysqli_query(
        $conn,
        "DELETE FROM users WHERE id=$userId AND role='member'"
    );
}

?>