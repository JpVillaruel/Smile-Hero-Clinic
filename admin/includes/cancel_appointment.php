<?php
require_once '../../includes/config_session.inc.php';
require_once '../../includes/login_view.inc.php';
require_once '../../includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["cancel"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $appointment_id = $_POST["app_id"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $status = "rejected";

    // Update appointment status to rejected
    $query = "UPDATE appointments SET status = ? WHERE appointment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $status, $appointment_id);
     

    if ( $stmt->execute()) {
         // Mail setup
    $mail = require __DIR__ . "/../../mailer.php"; 
    $mail->setFrom("jpvillaruel02@gmail.com");
    $mail->addAddress($email, $name);

    $mail->Subject = $subject;
    $mail->Body = $message;


    $mail->send();
    $_SESSION['pending_appointment'] = 'reject';
        header("Location: ../appointments.php");
        die();
    } else {
        echo "Error: " . $stmt->error;
    }
    $conn->close();
}
