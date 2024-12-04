<?php 
require_once "config_session.inc.php";

if (!isset($_GET["token"])) {
    echo "<script>alert('Invalid or expired token.'); window.close();</script>";
    exit;
}

$token = $_GET["token"];
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
    <main class="form-modal f-c">
      <form onsubmit="return validate()" method="post" action="process_reset_password.php" class="forgot-pass-form f-c">
        <h1 class="form-header">Reset Password</h1>
        <input type="hidden" name="token" id="token" value="<?=htmlspecialchars($token); ?>">

        <div class="field f-c">
          <label for="password">New Password</label>
          <input type="password" id="password" name="password" required>
        </div>
        
        <div class="field f-c">
          <label for="password">Confirm Password</label>
          <input type="password" id="Cpassword" name="Cpassword">
        </div>

        <p id="error_msg" class="form_error" 
        style="color:red;
              font-size: .75rem;"
        ></p>

        <button type="submit" class="confirm-pass-btn">Confirm</button>
      </form>
    </main>
</body>

<script>
    function validate(){
        var contact = document.getElementById("contact");
        var password = document.getElementById("password");
        var Cpassword = document.getElementById("Cpassword");


        notValid = false;

        var passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

        var error_msg =  document.getElementById("error_msg");

        if (password.value == "" || Cpassword.value == "") {
            error_msg.innerHTML = "Please fill up the form";
            error_msg.style.display = "flex";

            setTimeout(() => {
            error_msg.style.display = "none";
                }, 2000);

            return false; // prevent form submission
        } else if (password.value !== Cpassword.value) {
            error_msg.innerHTML = "Passwords does not match";
            error_msg.style.display = "flex";

            setTimeout(() => {
            error_msg.style.display = "none";
                }, 2000);

            return false; // prevent form submission
        } else if (!passwordRegex.test(password.value)) {
            error_msg.innerHTML = "Password must be at least 8 characters long, include one uppercase letter, one lowercase letter, one digit, and one special character. e.g !@#$%^&*";
            error_msg.style.display = "flex";

            setTimeout(() => {
            error_msg.style.display = "none";
                }, 4000);

            return false; // prevent form submission
        }

        return true; // allow form submission if all checks pass
    }
</script>
</html>