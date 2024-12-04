<?php
require_once '../../includes/config_session.inc.php';
require_once '../../includes/login_view.inc.php';
require_once '../../includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["selected_doctor"]) && $_POST["selected_doctor"] != '') {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $doctor_id = $_POST["selected_doctor"];
    $appointment_id = $_POST["app_id"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $status = "accepted";

    // Update appointment status to accepted
    $query = "UPDATE appointments SET status = ?, doctor_id = ? WHERE appointment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $status, $doctor_id, $appointment_id);
  
    if($stmt->execute()) {
          // Mail setup
        $mail = require __DIR__ . "/../../mailer.php"; 
        $mail->setFrom("jpvillaruel02@gmail.com");
        $mail->addAddress($email, $name);
    
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
        $_SESSION['pending_appointment'] = 'accept';
        header("Location: ../appointments.php");
        die();
    }else {
        echo "Error: " . $stmt->error;
    }
    $conn->close();
}else{
    header("Location: ../appointments.php?failed");
    exit();
}
