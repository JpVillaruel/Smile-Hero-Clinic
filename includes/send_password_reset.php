<?php

require_once "config_session.inc.php";

if($_SERVER["REQUEST_METHOD"] === "POST"){

  $email = $_POST['email'];
  
  $token = bin2hex(random_bytes(16));
  $token_hash = hash("sha256", $token);
  
  $expiry = date("Y-m-d H:i:s", time() + 60 * 30);
  
  $mysqli = require __DIR__ ."/dbh.inc.php";
  $sql = "UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email =?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("sss", $token_hash, $expiry, $email);
  
  $stmt->execute();
  
  if($mysqli->affected_rows){
  
    $mail = require __DIR__ ."/../mailer.php";
    $mail->setFrom("jpvillaruel02@gmail.com");
    $mail->addAddress($email);
    $baseUrl = "http://localhost/smile_hero_clinic";
    $activationUrl = $baseUrl . "/includes/reset_password.php?token=$token";
    $mail->Subject = "Smile Hero Clinic Password Reset";
    $mail->Body = <<<END
       <p>We received a request to reset your password. You can reset it by clicking the link below:</p>
        <p><a href="$activationUrl">Reset password</a></p>
        <p>This link will expire in 30 minutes.</p>
        <p>Thank you,</p>
        <p>Smile Hero Dental Clinic</p>
    END;
  
    try {
      $mail->send();
    } catch (Exception $e) {
      echo "Message could not send. Mailer Error: {$mail->ErrorInfo}";
    }
  }
  
  $_SESSION["email_process"] = "sent";

  $mysqli->close();
  $stmt->close();
  
  header("Location: ../forgot-pass.php");
  exit();
}