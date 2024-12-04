<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMAiler::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->Username = "jpvillaruel02@gmail.com";
$mail->Password = "vfng rcwc dhon tovf";
$mail->isHTML(true);

return $mail;