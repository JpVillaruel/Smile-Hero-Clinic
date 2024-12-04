<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/dbh.inc.php';

if (!isset($_SESSION['adminID'])) {
  // Redirect user to login if not logged in
  header("Location: ../login.php?login=failed");
  exit();
}


if(!isset($_GET['aptId'])){
  header("Location: booked.php");
  exit;
}

$aptId = $_GET['aptId'];

$query = "SELECT * FROM appointments WHERE appointment_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $aptId);
$stmt->execute();
$aptDetailesResult = $stmt->get_result();


$query = "SELECT available_dates FROM appointment_dates WHERE available_dates >= CURDATE()";
$result = $conn->query($query);

$availableDates = [];
while ($row = $result->fetch_assoc()) {
    $availableDates[] = $row['available_dates'];
}

$showModal = false;
$modalmessage = '';
if (isset($_SESSION['complete_process'])) {
    if ($_SESSION['complete_process'] === 'success') {
      $showModal = true;
      $modalmessage = "Appointment Completed ✓";
    }
    if ($_SESSION['complete_process'] === 'rescheduled') {
      $showModal = true;
      $modalmessage = "Rescheduling Completed ✓";
    }
    unset($_SESSION['complete_process']);
}
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
    <title>Appointment Details | Admin | Smile Hero Clinic</title>
    <link rel="stylesheet" href="../src/dist/styles.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  </head>
  <body class="admin__page">
    <main class="admin__main">
      <!-- nav header -->
      <?php include("includes/nav.php"); ?>
      <section class="admin__content">
        <!-- side bar -->
        <?php include("includes/side_nav.php"); ?>

        <?php if($aptResult =  $aptDetailesResult->fetch_assoc()){ ?>

        <div class="appointment-details-cont">
          <header>
            <div class="header-and-btn">
              <h1>Appointment Details</h1>
              <a href="booked.php">Go Back</a>
            </div>

            <div class="overview-details">
              <div class="details">
                <!-- date -->
                <div class="date">
                  <p class="day" id="weekday">
                    <!-- oks na dito, automatic nang magrereturn ng weekday -->
                  </p>
                  <p class="apt-date" id="date">
                    <!-- return mo lang dito is apt date (ex. 2024-11-18) -->
                    <?php echo $aptResult['date']; ?>
                  </p>
                </div>
                <!-- time apt-id -->
                <div class="time-apt-id">
                  <p class="time">
                    <img src="../assets/admin_assets/icons/clock.svg" alt="">
                    <?php echo $aptResult['time']; ?>
                  </p>
                  <p class="apt-id">
                    <img src="../assets/admin_assets/icons/book.svg" alt="">
                    <?php echo $aptResult['appointment_id']; ?>
                  </p>
                </div>
                <!-- services -->
                <div class="service-message">
                  <p class="service">
                    <img src="../assets/admin_assets/icons/note-text.svg" alt="">
                    <?php echo $aptResult['date']; ?>
                  </p>
                  <p class="message">
                    <img src="../assets/admin_assets/icons/message-text.svg" alt="">
                    <?php echo $aptResult['label'] != "walk-in" ? "Online Appointment" : "Walk-in Appointment" ?>
                  </p>
                </div>
              </div>
              <div class="actions">
                <?php if($aptResult['status'] === "completed"){ ?>
                  <p class="complete-text">Completed ✓</p>
                <?php } elseif($aptResult['status'] === "canceled"){ ?>
                  <p class="complete-text" style="color: red;">Canceled</p>
                <?php } elseif($aptResult['status'] === "missed"){ ?>
                  <p class="complete-text" style="color: orange;">Missed</p>
                <?php }else{ ?>
                  <div class="btn-container">
                     <form action="includes/complete_apt.php" method="post">
                        <input type="hidden" name="appointmentId" value= <?php echo $aptResult['appointment_id']; ?>>
                        <button type="submit" class="complete-btn" id="completeBtn" name="completeBtn" value="complete">Complete</button>
                      </form>

                      <button type="button" class="reschedule-btn" id="rescheduleBtn" style="display: <?php $tomorrow = date("Y-m-d", strtotime("+1 day")); echo ($aptResult['date'] <= $tomorrow) ? 'none' : '' ?>;">
                        Reschedule
                      </button>
                  </div>
                  <!-- <p class="complete-text">Completed ✓</p> -->
                <?php } ?>
              </div>
            </div>
          </header>

          <div class="table-cont">
            <table>
              <tbody>
                <tr>
                  <td>Name</td>
                  <td><?php echo $aptResult['name']; ?></td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td> <?php echo $aptResult['email']; ?></td>
                </tr>
                <tr>
                  <td>Contact Number</td>
                  <td> <?php echo $aptResult['contact']; ?></td>
                </tr>
                <tr>
                  <td>Label</td>
                  <td> <?php echo $aptResult['label']; ?></td>
                </tr>
                <tr>
                  <td>Location</td>
                  <td>Bayani Road, Taguig City</td>
                </tr>

                <?php
                // Get Doctor Name
                $doctorName = $aptResult['doctor_id'] ?? null;

                if ($doctorName) {
                    $doctor_query = "SELECT * FROM doctors WHERE doctor_id = ?";
                    $stmt = $conn->prepare($doctor_query);
                    $stmt->bind_param("s", $doctorName);
                    $stmt->execute(); 
                    $resultDoctorName = $stmt->get_result();
                    $rowDoctors = $resultDoctorName->fetch_assoc();
                
                    $rowDoctors ?  $doctorFullName = "Doc. " . htmlspecialchars($rowDoctors['first_name']) . " " . 
                                                               htmlspecialchars($rowDoctors['last_name']) 
                                :  $doctorFullName = "Doctor not found.";  
                } else {
                    $doctorFullName = "Doctor information unavailable.";
                }
                ?>
                <tr>
                    <td>Dentist</td>
                    <td><?php echo $doctorFullName; ?></td>
                </tr>
                
                <tr>
                  <td>Services</td>
                  <td> <?php echo $aptResult['service']; ?></td>
                </tr>
              
                <tr>
                  <td>Message</td>
                  <td> <?php echo empty($aptResult['message']) ? "No Message" : $aptResult['message']?></td>
                </tr>
                <tr>
                  <td>Status</td>
                  <td><?php echo $aptResult['status']; ?></td>
                </tr>
                <tr>
                  <td>Appointment Date</td>
                  <td><?php echo $aptResult['date']; ?></td>
                </tr>
                <tr>
                  <td>Appointment Time</td>
                  <td><?php echo $aptResult['time']; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </main>
    <!-- modals -->
    <section class="reschedule-modal" id="rescheduleModal" style="display: none;">
      <div class="content">
        <p class="header">Reschedule Appointment</p>
        <form action="includes/reschedule.php" method="post"  id="rescheduleForm">
          <section>
            <input type="hidden" name="aptID" value="<?php echo $aptResult['appointment_id'] ?>">
            <input type="hidden" name="email" value="<?php echo $aptResult['email'] ?>">
            <input type="hidden" name="name" value="<?php echo $aptResult['name'] ?>">
            <input type="hidden" name="date" value="<?php echo $aptResult['date'] ?>">
            <input type="hidden" name="time" value="<?php echo $aptResult['time'] ?>">
            <div class="appointment-form__field">
              <label for="appointmentDate" class="appointment-form__label">Date</label>
              <input type="text" name="appointmentDate" id="appointmentDate" class="appointment-form__input" placeholder="Select a date" 
                      value="<?php echo $aptResult['date'] ?>">
              <div class="appointment-form__validation">
                <p class="appointment-form__text appointment-form__text--error">Error</p>
                <p class="appointment-form__text appointment-form__text--valid">Valid</p>
              </div>
              <p class="time_error"></p>
            </div>
            <div class="appointment-form__field">
              <label for="appointmentTime" class="appointment-form__label">Time</label>
              <select name="appointmentTime" id="appointmentTime" class="appointment-form__select">
                  <option value="--"> Select time</option>
                  <option value="9:00 AM" <?php echo ($aptResult['time'] == '9:00 AM') ? 'selected' : ''; ?>>09:00 AM</option>
                  <option value="10:00 AM" <?php echo ($aptResult['time'] == '10:00 AM') ? 'selected' : ''; ?>>10:00 AM</option>
                  <option value="11:00 AM" <?php echo ($aptResult['time'] == '11:00 AM') ? 'selected' : ''; ?>>11:00 AM</option>
                  <option value="1:00 PM" <?php echo ($aptResult['time'] == '1:00 PM') ? 'selected' : ''; ?>>01:00 PM</option>
                  <option value="2:00 PM" <?php echo ($aptResult['time'] == '2:00 PM') ? 'selected' : ''; ?>>02:00 PM</option>
                  <option value="3:00 PM" <?php echo ($aptResult['time'] == '3:00 PM') ? 'selected' : ''; ?>>03:00 PM</option>
                  <option value="4:00 PM" <?php echo ($aptResult['time'] == '4:00 PM') ? 'selected' : ''; ?>>04:00 PM</option>
                  <option value="5:00 PM" <?php echo ($aptResult['time'] == '5:00 PM') ? 'selected' : ''; ?>>05:00 PM</option>
              </select>
              <div class="appointment-form__validation">
                <p class="appointment-form__text appointment-form__text--error">Error</p>
                <p class="appointment-form__text appointment-form__text--valid">Valid</p>
              </div>
              <p class="time_error"></p>
            </div>

            <div class="appointment-form__field">
              <label for="reason_message" class="appointment-form__label">Reason</label>
              <textarea id="reason_message" name="reason_message" class="appointment-form__select rows="10" cols="50" style="resize: none;"></textarea>
              <div class="appointment-form__validation">
                <p class="appointment-form__text appointment-form__text--error">Error</p>
                <p class="appointment-form__text appointment-form__text--valid">Valid</p>
              </div>
              <p class="time_error"></p>
            </div>
            
            <div class="btn-container">
              <input type="submit" name="submit" value="Reschedule" class="appointment-form__submit-button">
              <input type="button" value="Cancel" class="appointment-form__cancel-button" id="cancelBtn">
            </div>
          </section>
        </form>
        <?php } ?>
      </div>
    </section>

    <section class="complete-modal" id="completeModal" style="display: none;">
      <div class="content">
        <div class="body-text">
          <p class="header" id="modalMessage">Appointment Completed ✓</p>
          <button type="button" class="close-btn" id="closeBtn">
            Close
          </button>
        </div>
          
       <div class="illustration-container">
         <img src="../assets/admin_assets/complete.svg" alt="illustration of complete appointment">
       </div>
      </div>
    </section>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const modalContainer = document.querySelector(".complete-modal");
        const exitBtn = modalContainer.querySelector("#closeBtn");
        const modalMessage = modalContainer.querySelector("#modalMessage");

      <?php if ($showModal) : ?>
        modalMessage.innerText = "<?php echo $modalmessage; ?>";
        modalContainer.style.display = "flex";
      <?php endif; ?>

      // Close modal when exit button is clicked
      exitBtn.addEventListener("click", () => {
              modalContainer.style.transform = "scale(0)";
          });
      });




      const weekdayText = document.getElementById('weekday')
      const dateEl = document.getElementById('date')
      const dateText = dateEl.textContent.trim()
      
      const date = new Date(dateText)
      const day = date.getDate()

      const weekdays = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"]
      const weekday = weekdays[date.getDay()]
      weekdayText.textContent = weekday
      dateEl.textContent = day

      document.addEventListener('DOMContentLoaded', () => {
        const rescheduleForm = document.getElementById('rescheduleForm');
        const cancelBtn = document.getElementById('cancelBtn')
        const rescheduleModal = document.getElementById('rescheduleModal')
        const actions = document.querySelector('.actions')
        const form = document.querySelector('form[action="includes/complete_apt.php"]')
        const completeModal = document.getElementById('completeModal')
        const closeBtn = document.getElementById('closeBtn')

        actions.addEventListener('click', (e) => {
          const completeBtn = e.target.closest('#completeBtn');
          const rescheduleBtn = e.target.closest('#rescheduleBtn')

          if (completeBtn) {
            e.preventDefault();

            const formData = new FormData(form); // Collect form data
            fetch(form.action, {
              method: 'POST',
              body: formData,
            })
              .then((response) => {
                if (response.ok) return response.text();
                else throw new Error('Failed to complete the appointment.');
              })
              .then((data) => {
                while (actions.firstChild) actions.removeChild(actions.firstChild);

                const completeText = document.createElement('p');
                completeText.textContent = 'Completed ✓';
                completeText.classList = 'complete-text';
                
                actions.appendChild(completeText);                
                completeModal.style.display = 'flex';
              })
              .catch((error) => {
                console.error('Error:', error);
                alert('An error occurred while completing the appointment.');
              });
          }

          if (rescheduleBtn) {
            rescheduleModal.style.display = 'flex'
          }
        });

        cancelBtn.addEventListener('click', () => {
          if(rescheduleModal.style.display == 'flex') rescheduleModal.style.display = 'none'
        })

        rescheduleForm.addEventListener('submit', (e) => {
          e.preventDefault();

          const fields = [
            {
              id: 'appointmentDate',
              errorMessage: 'Please select a date'
            },
            {
              id: 'appointmentTime',
              errorMessage: 'Please select a time'
            },
            {
              id: 'reason_message',
              errorMessage: 'Please indicate a reason'
            },
          ];

          let isValid = true;
          fields.forEach((field) => {
            const fieldElement = document.getElementById(field.id);
            const errorElement = fieldElement.nextElementSibling.querySelector('.appointment-form__text--error');
            const validElement = fieldElement.nextElementSibling.querySelector('.appointment-form__text--valid');

            if (fieldElement.value.trim() === '-' || fieldElement.value.trim() === '') {
              errorElement.innerText = field.errorMessage;
              errorElement.style.display = 'block'; // Show error message
              validElement.style.display = 'none'; // Hide valid message
              isValid = false;
            } else {
              errorElement.style.display = 'none'; // Hide error message
              validElement.style.display = 'block'; // Show valid message
            }
          });
        
          if (isValid) {
            HTMLFormElement.prototype.submit.call(rescheduleForm);
          }
        });

        closeBtn.addEventListener('click', () => {
          completeModal.style.display = 'none'
        })
      });

      // Pass PHP array to JavaScript
      const availableDates = <?php echo json_encode($availableDates); ?>;

      document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#appointmentDate", {
            dateFormat: "Y-m-d",
            minDate: "today",
            enable: availableDates,
        });
      });
    </script>
  </body>
</html>
