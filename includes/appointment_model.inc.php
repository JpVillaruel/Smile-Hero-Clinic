<?php

declare(strict_types=1);

function getUserid(mysqli $conn, string $name) {
    $query = "SELECT user_id FROM appointments WHERE name = ? AND (status != 'rejected') AND (status != 'canceled') AND (status != 'missed') AND (status != 'completed')";
    $stmt = $conn->prepare($query); 
    $stmt->bind_param("s", $name);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    return $user;
}

function getAccount(mysqli $conn, $email, string $fname, string $mname, string $lname, string $suffix){
    $query = "SELECT * FROM users WHERE first_name = ? AND middle_name = ? AND last_name = ? AND suffix = ? AND email = ?";
    $stmt = $conn->prepare($query); 
    $stmt->bind_param("sssss", $fname, $mname, $lname, $suffix, $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $account = $result->fetch_assoc();

    return $account;
}

function createAppointment(mysqli $conn, string $user_id, string $appointmentId, string $label, string $name, string $email, string $contact, string $message, string $appointmentDate, string $appointmentTime, string $appointmentDoctor , string  $dentalService, string $location, string $status) {

    $query = "INSERT INTO appointments (user_id, doctor_id, appointment_id, label, name, email, contact, message, date, time, service, location, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, NOW())";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssssss", $user_id,$appointmentDoctor ,$appointmentId, $label, $name, $email, $contact, $message, $appointmentDate, $appointmentTime,  $dentalService, $location, $status);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}

function isTimeReachedLimit(mysqli $conn, string $appointmentDate, string $appointmentTime){
    $query = "SELECT COUNT(*) as timeLimit FROM appointments WHERE date = ? AND time = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $appointmentDate, $appointmentTime);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $timeLimit = (int) $row['timeLimit'];

    return $timeLimit >= 5;
}

function isDateReachedLimit(mysqli $conn, string $appointmentDate){
    $query = "SELECT COUNT(*) as dateLimit FROM appointments WHERE date = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $appointmentDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $dateLimit = (int) $row['dateLimit'];

    return $dateLimit >= 40;
}