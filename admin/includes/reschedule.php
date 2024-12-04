<?php 
require_once '../../includes/config_session.inc.php';
require_once '../../includes/login_view.inc.php';
require_once '../../includes/dbh.inc.php';


if($_SERVER['REQUEST_METHOD'] === "POST"){
    $aptID = $_POST['aptID'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $originalDate = $_POST['date'];
    $originalTime = $_POST['time'];
    $reschedDate = $_POST['appointmentDate'];
    $reschedTime = $_POST['appointmentTime'];
    $reason_message = $_POST['reason_message'];
    $subject = "Smile Hero Clinic Reschuling Appointment";

    $query = "UPDATE appointments SET date = ?, time = ? WHERE appointment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $reschedDate, $reschedTime, $aptID);
    
    if($stmt->execute()){
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $reschedDate, $reschedTime, $aptID);
         // Mail setup
        $mail = require __DIR__ . "/../../mailer.php"; 
        $mail->setFrom("jpvillaruel02@gmail.com", "Smile Hero Clinic");
        $mail->addAddress($email, $name);

        $mail->Subject = $subject;
        $mail->Body = <<<END
            <p>Dear $name,</p>
            </br><p>We regret to inform you that your appointment originally scheduled for <b>$originalDate</b> at <b>$originalTime</b> has been rescheduled.</p>
            <p>Your new appointment schedule is on <b>$reschedDate</b> at <b>$reschedTime</b></p>
            </br><p><b>Reason for Rescheduling:</b></p>
            <p>$reason_message</p>
            </br><p>Please let us know your availability so we can arrange a new date and time that works for you.</p>
            <p>Thank you for your understanding. If you have any questions, feel free to contact us</p>
            <p><a href="https://www.facebook.com/BayaniRoadSmileHeroDentalClinic">Message us on Facebook</a> or Call us on 0917-160-6212</p>
            </br><p>Best regards,</p>
            <p>Smile Hero Clinic</p>
        END;
       
    if ($mail->send()) {
        $_SESSION['complete_process'] = 'rescheduled';
        header("Location: ../appointment-details.php?aptId=" . urlencode($aptID));
    } else {
        echo "Failed to send email: " . $mail->ErrorInfo;
    }
    $stmt->close();
    $conn->close();
    exit();

    } else {
        echo "Failed to update the appointment: " . $stmt->error;
    }
}
