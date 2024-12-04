<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $fname = ucwords(htmlspecialchars($_POST["fname"]));
    $mname = ucwords(htmlspecialchars($_POST["mname"]));
    $lname = ucwords(htmlspecialchars($_POST["lname"]));
    $suffix = ucwords(htmlspecialchars($_POST["suffix"]));
    $label = "new";
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $password = $_POST["password"];

    $activation_token = bin2hex(random_bytes(16));
    $activation_token_hash = hash("sha256", $activation_token);

    require_once("dbh.inc.php");
    require_once("signup_model.inc.php");
    require_once("signup_contr.inc.php");

    $user_id = generateUserID($conn);

    // ERROR HANDLERS
    $errors = [];

    if (isNameTaken($conn,$fname, $mname, $lname, $suffix)) {
        $errors["nameTaken"] = "Name is already taken. ";
    }
    if (isEmailInvalid($email)) {
        $errors["invalidEmail"] = "Email is invalid!. ";
    }
    if (iscontactTaken($conn, $contact)) {
        $errors["contactTaken"] = "Contact is already taken. ";
    }
    if (isEmailRegistered($conn, $email)) {
        $errors["emailRegistered"] = "Email is already registered. ";
    }

    require_once("config_session.inc.php");

    if ($errors) {
        $_SESSION["errors_signup"] = $errors;
        $_SESSION["signup_data"] = [
            "fname" => isset($errors['nameTaken']) ? '' : $fname,
            "mname" => isset($errors['nameTaken']) ? '' : $mname,
            "lname" => isset($errors['nameTaken']) ? '' : $lname,
            "suffix" => $suffix,
            "email" => isset($errors['emailRegistered']) || isset($errors['invalidEmail']) ? '' : $email,
            "contact" => isset($errors['contactTaken']) ? '' : $contact
        ];

       

        header("Location: ../signup.php");
        die();
    }

    createUser($conn, $user_id, $fname, $mname, $lname, $suffix, $email, $contact, $password, $label, $activation_token_hash);

    $mail = require __DIR__ . "/../mailer.php"; 
    $mail->setFrom("jpvillaruel02@gmail.com");
    $mail->addAddress($_POST["email"]);
    $baseUrl = "http://localhost/smile_hero_clinic"; // Replace with your local project folder path
    $activationUrl = $baseUrl . "/includes/activate_account.php?token=$activation_token";
    $mail->Subject = "Smile Hero Dental Clinic Account Activation";
    $mail->Body = <<<END

    <p>Hello $fname $mname $lname $suffix Thank you for signing up! Please click the link below to activate your account:</p>
    <p><a href="$activationUrl">Activate your account</a></p>

    END;

    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        exit;
    }

    $_SESSION["signup_process"] = "created";
    unset($_SESSION["signup_data"]);
    header("Location: ../signup.php");
    $stmt->close();
    $conn->close();
    die();
} else {
    echo "<script>alert('Account is not created');</script>";
    echo "<script>window.location.href='../signup.php';</script>";
    die();
}