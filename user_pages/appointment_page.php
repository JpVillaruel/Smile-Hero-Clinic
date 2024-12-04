<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/appointment_view.inc.php';

require_once '../includes/dbh.inc.php';

if(!isset($_SESSION['user_id'])) {
   // Redirect user to login if not logged in
   header("Location: ../login.php");
   exit();
}
  $user_id = $_SESSION['user_id'];


  // Fetch appointments for the user
  $query = "SELECT * FROM appointments WHERE user_id = ? AND status =  'accepted' ";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/images/logoipsum.svg" type="image/x-icon">
  <title>Appointment | Smile Hero Clinic</title>
  
  
  <link rel="stylesheet" href="../src/dist/styles.css" />
  <script src="js/mobile-nav.js" defer></script>
</head>

<body class="user__page">
  <main class="user__main">
    <!-- navigation header bar -->
    <?php include('includes/nav.php'); ?>

    <section class="user-contents">
      <!-- navigation side nav -->
      <?php include('includes/sidenav.php'); ?>

    <!-- appointment page -->
    <section class="appointment__page account__container">
        <?php if ($row = $result->fetch_assoc()) {  
          
          // update the appointment if it is finished
          $dateNow = date('l, m/d/Y');
          $appointment_date = $row['date'];
          $appointment_id = $row['appointment_id'];
          ?>
        <div class="appointments__container">
          <div class="appointment__item">
            <div class="header">
              <div class="header__body-text">
                <p class="appointment-id">Appointment ID: <?php echo $row["appointment_id"]; ?></p>
                <h2 class="appointment-date"><?php echo $row['date'] ?></h2>
                <p class="appointment-time">at <?php echo $row["time"]; ?></p>
              </div>

              <button class="header__cancel-btn" id="cancelAppointmentBtn" style="display: <?php $tomorrow = date("Y-m-d", strtotime("+1 day")); echo ($row['date'] <= $tomorrow) ? 'none' : '' ?>;">Cancel Appointment</button>
            </div>  
            <div class="modal cancel-appointment" style="transform: scale(0)">
              <div class="modal__header">
                <h3>Are you sure you want to cancel your Appointment?</h3>
                <p>*This action cannot be undone and all appointment details will be lost.*
                </p>
              </div>

              <div class="modal__buttons">
                <form action="" method="get" class="confirm-cancel">
                  <input type="submit" name="submit" value=" Yes, cancel appointment" style="color: white; cursor: pointer;">
                </form>

                <button id="exitButton">No, keep my appointment</button>
              </div>
            </div>

            <?php 
              $appointment_id = $row['appointment_id'];
              if(isset($_GET["submit"])) {
                $query = "UPDATE appointments SET status = 'canceled' WHERE appointment_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $appointment_id);
                $stmt->execute();

                  echo "<script> alert('Appointment is now canceled'); </script>";
                  echo "<script>window.location.href='appointment_page.php';</script>";
              }?>

              <div class="appointment__details">
                <div class="detail">
                  <p class="detail__header">Name</p>
                  <p class="detail__content" id="appName"><?php echo $row["name"]; ?></p>
                </div>
                <div class="detail">
                      <p class="detail__header">Date</p>
                      <p class="detail__content" id="appDate"><?php echo $row["date"]; ?></p>
                </div>
                <div class="detail">
                      <p class="detail__header">Email</p>
                      <p class="detail__content" id="appEmail"><?php echo $row["email"]; ?></p>
                </div>
                <div class="detail">
                      <p class="detail__header">Time</p>
                      <p class="detail__content" id="appTime"><?php echo $row["time"]; ?></p>
                </div>
                <div class="detail">
                      <p class="detail__header">Contact Number</p>
                      <p class="detail__content" id="appContact"><?php echo $row["contact"]; ?></p>
                </div>
                <div class="detail">
                      <p class="detail__header">Location</p>
                      <p class="detail__content" id="appLoc"><?php echo $row["location"]; ?></p>
                </div>
                <div class="detail">
                      <p class="detail__header">Message</p>
                      <p class="detail__content" id="appMessage"><?php echo $row["message"]; ?></p>
                </div>
            </div>
            <?php } else {
                  echo "<p class='no-appointment-message' 
                  style='width: 100%;
                         font-size: 1.5rem;
                         font-weight: bold;
                         color: #616161;
                         text-align: center;
                         padding: 1.5rem;
                         border-radius: 0.5rem;
                         background-color: var(--ntrl-clr-100);'
                         >No appointments scheduled yet.</p>";
            } 

            $conn->close()?>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>

<script>
  const modalContainer = document.querySelector(".cancel-appointment");
  const cancelAppointmentBtn = document.getElementById("cancelAppointmentBtn");
  const exitBtn = document.getElementById("exitButton");

  cancelAppointmentBtn.addEventListener("click", () => {
    modalContainer.style.transform = "scale(1)";
  })

  exitBtn.addEventListener("click", () => {
    modalContainer.style.transform = "scale(0)";
  })
</script>

</html>