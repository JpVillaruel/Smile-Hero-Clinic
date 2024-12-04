<?php

declare(strict_types=1);

function getcontact(mysqli $conn, string $contact) {
    $query = "SELECT user_id FROM users WHERE contact = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $contact);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    return $user;
}

function getEmail(mysqli $conn, string $email) {
    $query = "SELECT user_id FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    return $user;
}

function isEmailUnique($dbConnection, $email, $currentEmail ) {
    $query = "SELECT COUNT(*) AS total FROM users WHERE email = ? AND email != ?";
    $stmt = $dbConnection->prepare($query);
    $stmt->bind_param("ss", $email, $currentEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total = $row['total'];
    
    return $total == 0; // Return true if email is unique, false otherwise
}

function getName(mysqli $conn, string $fname, string $mname, string $lname, string $suffix) {
    $query = "SELECT user_id FROM users WHERE first_name = ? AND middle_name = ? AND last_name = ? AND suffix = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $fname, $mname, $lname, $suffix);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    return $user;
}

function getUserPass($conn, $user_id) {
    $query = "SELECT pass FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the password column only
    if ($row = $result->fetch_assoc()) {
        return $row['pass']; // Return only the hashed password as a string
    }
    return null; // Return null if no result found
}

function setUser(mysqli $conn, string $userid,string $fname, string $mname, string $lname, string $suffix, string $email, string $contact, string $password, string $label, string  $activation_token_hash) {
    $query = "INSERT INTO users (user_id, first_name, middle_name, last_name, suffix, email, contact, pass, label, account_activation_hash, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);

    $options = [
        'cost' => 12
    ];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

    $stmt->bind_param("ssssssssss", $userid, $fname, $mname, $lname, $suffix, $email, $contact, $hashedPassword, $label, $activation_token_hash);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}
