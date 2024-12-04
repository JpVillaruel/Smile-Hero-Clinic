<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/dbh.inc.php';

if (!isset($_SESSION['adminID'])) {
  // Redirect user to login if not logged in
  header("Location: ../login.php?login=failed");
  exit();
}

// Delete dates older than the current date
$deleteQuery = "DELETE FROM appointment_dates WHERE available_dates < CURDATE()";
$conn->query($deleteQuery);

$query = "SELECT available_dates FROM appointment_dates WHERE available_dates >= CURDATE()";
$result = $conn->query($query);

$availableDates = [];
while ($row = $result->fetch_assoc()) {
    $availableDates[] = $row['available_dates'];
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="../assets/images/logoipsum.svg"
      type="image/x-icon"
    />
    <title>Set Dates | Admin</title>
    <link rel="stylesheet" href="../src/dist/styles.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
      /* Shake animation */
      @keyframes shake {
          0% { transform: translateX(0); }
          25% { transform: translateX(-5px); }
          50% { transform: translateX(5px); }
          75% { transform: translateX(-5px); }
          100% { transform: translateX(0); }
      }

      .shake {
          animation: shake 0.25s ease-in-out;
      }
    </style>
  </head>
  <body class="admin__page">
    <main class="admin__main">
      <!-- nav header -->
      <?php include("includes/nav.php"); ?>

      <section class="admin__content">
        <!-- side bar -->
        <?php include("includes/side_nav.php"); ?>

        <div class="set-date-container">
          <h1>Create Appointment Dates</h1>

          <form action="includes/save_dates.php" method="post" id="setDatesForm">
              <div class="field-group">
                  <label for="dates">Select Available Dates</label>
                  <input type="text" id="dates" name="dates" placeholder="Select dates" required="true" />
              </div>
              <button type="submit">Generate Appointment Dates</button>
          </form>
          
        </div>
      </section>
    </main>
  </body>
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const availableDates =  <?php  echo json_encode($availableDates); ?>;

      flatpickr("#dates", {
          mode: "multiple",
          dateFormat: "Y-m-d",
          minDate: "today",
          disable: availableDates,
          onChange: function(selectedDates) {
              const datesArray = selectedDates.map(date => date.toLocaleDateString('en-CA'));
              console.log(datesArray); // for debugging purposes
          }
          });

      const form = document.getElementById('setDatesForm');
      form.addEventListener('submit', function(event) {
          const datesInput = document.getElementById('dates');

          if (!datesInput.value) {
              event.preventDefault();
              datesInput.classList.add('shake');
              datesInput.style.borderColor = "red";
              setTimeout(() => {
                datesInput.classList.remove('shake');
                datesInput.style.borderColor = "black";
              }, 250);
          }
      });
    });
    </script>
</html>
