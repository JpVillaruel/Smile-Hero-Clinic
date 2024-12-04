<?php
require_once '../../includes/config_session.inc.php';
require_once '../../includes/login_view.inc.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $fname = ucwords($_POST['fname']);
    $mname = ucwords($_POST['mname']);
    $lname = ucwords($_POST['lname']);
    $suffix = ucwords($_POST['suffix']);
    $name = strval($fname ) ." ". strval($mname )  ." ". strval($lname )  ." ". strval($suffix );
    $email = $_POST['email'];
    $contact = $_POST['contactnumber'];     
    $message = $_POST['message'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];
    $appointmentDoctor = $_POST['appointmentDoctor'];
    $location = $_POST['location'];
    $dentalService = implode(', ', $_POST['dentalService']);
    $status = 'request';

    $subject = "Smile Hero Dental Clinic Appointment";
    $Emailmessage = "Good Day $name, your appointment on $appointmentDate at $appointmentTime has been accepted. Thanks for Choosing Smile Hero Dental Clinic";
    
    require_once "../../includes/dbh.inc.php";
    require_once "../../includes/appointment_model.inc.php";

    $appointmentId = generateAppoinmentID($conn);

    $result = haveAccount($conn, $email, $fname, $mname , $lname, $suffix);

    if ($result) {
        $user_id = $result['user_id'];
        $label =  $result['label'];
    }else{
        $user_id = "walk-in";
        $label = "walk-in";
      
        disableForeignKeyChecks($conn);
    }
    
    if (haveAppointment($conn, $name)) {
        $_SESSION['appointment_status'] = 'exists';
        header("Location: ../new-appointment.php");
        die();
    }else{

        $mail = require __DIR__ . "/../../mailer.php"; 
        $mail->setFrom("jpvillaruel02@gmail.com");
        $mail->addAddress($email, $name);
    
        $mail->Subject = $subject;
        $mail->Body = $Emailmessage;
    
        if ($mail->send()) {
        $status = 'accepted';

        createAppointment($conn, $user_id, $appointmentId, $label, $name, $email, $contact, $message, $appointmentDate, $appointmentTime, $appointmentDoctor, $dentalService, $location, $status);

        }
        
        if(disableForeignKeyChecks($conn) === false){
            enableForeignKeyChecks($conn);
        }

        $_SESSION['appointment_status'] = 'created';
    
        $conn->close();
        header("Location: ../new-appointment.php");
        die();    
    }

    } else{
        $_SESSION['appointment_status'] = 'failed';
        header("Location: ../new-appointment.php");
        die();
    }

    function haveAppointment(mysqli $conn, string $name) {
        $user = getUserid($conn, $name);
        return $user !== null;
    }

    function haveAccount(mysqli $conn, string $email, string $fname, string $mname, string $lname, string $suffix){
        $account = getAccount($conn, $email, $fname, $mname, $lname, $suffix);
        return $account;
    }
    
    function generateAppoinmentID(mysqli $conn) {
        $unique = false;
        $appointmentID = '';
        while (!$unique) {
            $randString = strval(mt_rand());
            $appointmentID = 'SHC' . substr(md5(uniqid($randString, true)), 0, 4);
            $query = "SELECT appointment_id FROM appointments WHERE appointment_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $appointmentID);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows === 0) {
                $unique = true;
            }
        }
        return $appointmentID;
    }

    function disableForeignKeyChecks(mysqli $conn, bool $disable = false) {
        $query = "SET FOREIGN_KEY_CHECKS = 0";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        return $disable;
    }

    function enableForeignKeyChecks(mysqli $conn) {
        $query = "SET FOREIGN_KEY_CHECKS = 1";
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }