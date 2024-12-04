<?php 
require_once "config_session.inc.php";

if($_SERVER["REQUEST_METHOD"] = "POST"){

    $token = $_POST["token"];
    $password = $_POST["password"];

    $token_hash = hash("sha256", $token);


    $mysqli = require __DIR__ ."/dbh.inc.php";
    $query = "SELECT * FROM users WHERE reset_token_hash = ?";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $token_hash);
    $stmt-> execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user === null) {
        echo "<script>alert('Invalid or expired token.'); window.close();</script>";
        exit;
    }

    if (strtotime($user["reset_token_expires_at"]) <= time()){
        echo "<script>alert('Invalid or expired token.'); window.close();</script>";
        exit;
    }

    $qryUpdatePass = "UPDATE users SET pass = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE user_id = ?";

    $options = [
        'cost' => 12
    ];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

    $stmt = $mysqli->prepare($qryUpdatePass);
    $stmt->bind_param("ss", $hashedPassword, $user["user_id"]);
    $stmt->execute();

    $mysqli->close();
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="shortcut icon"
      href="../assets/images/logoipsum.svg"
      type="image/x-icon"
    />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css"> -->
    <title>Smile Hero Dental Clinic</title>
    <!-- stylesheets -->
    <link rel="stylesheet" href="../src/dist/styles.css" />
</head>
<body>
      <!-- modal -->
      <div class="forgot-pass-modal">
       <div class="modal__content">
         <div class="body-text">
           <div class="modal__header">
             <h3 id="modalStatus" class="modal__status">
               You have <br> successfully reset <br> your password!
             </h3>
             <p id="modalMessage" class="modal__message" style="color: #616161;"> 
                 You can now login and enter your new password
             </p>
           </div>
           <a href="../login.php" target="_blank" id="exitButton" class="modal__button" style="text-align: center;">
               LOG IN
           </a>
         </div>
         <div class="illustration__container">
          <img src="../assets/reset-password.svg" alt="">
         </div>
       </div>
      </div>
    </main>
</body>
</html>
