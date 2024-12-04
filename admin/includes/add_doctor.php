<?php
require_once '../../includes/config_session.inc.php';
require_once '../../includes/login_view.inc.php';

if ($_SERVER['REQUEST_METHOD'] === "POST"){

    $fname = ucfirst($_POST['firstname']);
    $lname = ucfirst($_POST['lastname']);
    $email = $_POST['email'];
    $contactnumber = $_POST['contactnumber'];

    require_once "../../includes/dbh.inc.php";
    $doctor_id = generateDoctorID($conn);

    if(isEmailInvalid($email)){
        header("Location: ../new-doctor.php?error=invalid_email");
        exit();
    } else {
        $query = "INSERT INTO doctors (doctor_id, first_name, last_name, phone_number, email, created_at) VALUES (?, ?, ?, ?, ?, Now())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $doctor_id, $fname, $lname, $contactnumber, $email);

        try {
            if($stmt->execute()){
                $_SESSION['doctors_process'] = 'created';
            }
        } catch (\Throwable $th) {
            // Ideally, log the error to a file instead of showing it directly
            error_log($th->getMessage());
            die("Something went wrong. Please try again later.");
        }

        $conn->close();
        header("Location: ../new-doctor.php?success=1");
        exit();
    }

} else {
    echo "<script>alert('Adding Doctor : Failed');</script>";
    echo "<script>window.location.href='../new-doctor';</script>";
}

function isEmailInvalid(string $email) {
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

function generateDoctorID(mysqli $conn) {
    $unique = false;
    $doctorID = '';
    $attempts = 0; // limit to avoid infinite loops
    $maxAttempts = 10;

    while (!$unique && $attempts < $maxAttempts) {
        $randString = strval(mt_rand());
        $doctorID = 'DOC' . substr(md5(uniqid($randString, true)), 0, 4);
        $query = "SELECT doctor_id FROM doctors WHERE doctor_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $doctorID);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $unique = true;
        }
        $attempts++;
    }

    if (!$unique) {
        die("Error: Unable to generate a unique Doctor ID.");
    }

    return $doctorID;
}