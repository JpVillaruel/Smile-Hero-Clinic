<?php

declare(strict_types=1);

function isInputEmpty(string $fname, string $mname, string $lname, string $contact, string $password, string $birthdate, string $gender) {
    return empty($fname) || empty($mname) || empty($lname) || empty($contact) || empty($password) || empty($birthdate) || empty($gender);
}

function isEmailInvalid(string $email) {
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

function iscontactTaken(mysqli $conn, string $contact) {
    $user = getcontact($conn, $contact);
    return $user !== null;
}

function isNameTaken(mysqli $conn, string $fname, string $mname, string $lname, string $suffix) {
    $user = getName($conn,$fname, $mname, $lname, $suffix);
    return $user !== null;
}

function isEmailRegistered(mysqli $conn, string $email) {
    $user = getEmail($conn, $email);
    return $user !== null;
}

function createUser(mysqli $conn, string $userid, string $fname, string $mname, string $lname, string $suffix, string $email, string $contact, string $password, string $label, string  $activation_token_hash) {
    setUser($conn, $userid, $fname, $mname, $lname, $suffix, $email, $contact, $password, $label, $activation_token_hash);
}

function generateUserID(mysqli $conn) {
    $unique = false;
    $userID = '';
    while (!$unique) {
        $randString = strval(mt_rand()); // Convert integer to string
        $userID = 'SHC' . substr(md5(uniqid($randString, true)), 0, 4) . 'TCU';
        $query = "SELECT user_id FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $userID);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $unique = true;
        }
    }
    return $userID;
}

