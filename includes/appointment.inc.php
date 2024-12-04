<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $doctor_id = '';
    $label = $_SESSION["label"];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contactnumber'];     
    $message = $_POST['message'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];
    $location = $_POST['location'];
    $dentalService = implode(', ', $_POST['dentalService']);
    $status = 'request';

    require_once("dbh.inc.php");
    require_once("appointment_model.inc.php");
    

    if (isDateReachedLimit($conn, $appointmentDate)) {
        $_SESSION['date_limit'] = 'invalid';
        $_SESSION['selectAppointmentDate'] = $appointmentDate;
        header("Location: ../user_pages/appointment_form_page.php");
        die();
    }

    if (isTimeReachedLimit($conn, $appointmentDate, $appointmentTime)) {
        $_SESSION['time_limit'] = 'invalid';
        header("Location: ../user_pages/appointment_form_page.php");
        die();
    }
    
    $appointmentId = generateAppoinmentID($conn);

    if (haveAppointment($conn, $name)) {
        $_SESSION['appointment_status'] = 'exists';
        header("Location: ../user_pages/appointment_form_page.php");
        die();
    }
    else{
        createAppointment($conn, $user_id, $appointmentId, $label, $name, $email, $contact, $message, $appointmentDate, $appointmentTime, $doctor_id,  $dentalService, $location, $status);
        $_SESSION['appointment_status'] = 'created';
        
        $conn->close();
        header("Location: ../user_pages/appointment_form_page.php");
        die();
    }
    } else {
        $_SESSION['appointment_status'] = 'failed';
        header("Location: ../user_pages/appointment_form_page.php");
        die();
    }

function haveAppointment(mysqli $conn, string $name) {
    $user = getUserid($conn, $name);
    return $user !== null;
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
