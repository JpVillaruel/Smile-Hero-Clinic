<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/dbh.inc.php';
require_once './includes/pagination.php';

if (!isset($_SESSION['adminID'])) {
  header("Location: ../login.php?login=failed");
  exit();
}

// Define how many results per page
$results_per_page = 10;

// Find out the number of results stored in the database
$query = "SELECT COUNT(*) AS total FROM appointments WHERE status = 'request'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$number_of_results = $row['total'];

// Determine the total number of pages available
$totalPages = ceil($number_of_results / $results_per_page);

// Determine which page number visitor is currently on
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure the page number is at least 1

// Determine the SQL LIMIT starting number for the results on the displaying page
$this_page_first_result = ($page - 1) * $results_per_page;

$query = "SELECT * FROM appointments WHERE status = 'request' LIMIT $this_page_first_result, $results_per_page";
$result = $conn->query($query);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$showModal = false;
$modalStatus = '';
if (isset($_SESSION['pending_appointment'])) {
    if ($_SESSION['pending_appointment'] === 'accept') {
        $showModal = true;
        $modalStatus = 'The Requested Appointment is Accepted.';
    } elseif ($_SESSION['pending_appointment'] === 'reject') {
        $showModal = true;
        $modalStatus = 'The Requested Appointment is Rejected.';
    }
    unset($_SESSION['pending_appointment']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/images/logoipsum.svg" type="image/x-icon" />
  <title>Appointments | Admin</title>
  <link rel="stylesheet" href="../src/dist/styles.css" />
  
</head>

<body class="admin__page">
  <main class="admin__main">
    <!-- nav header -->
    <?php include("includes/nav.php"); ?>

    <section class="admin__content">
      <!-- side bar -->
      <?php include("includes/side_nav.php"); ?>
      
      <div class="appointments__container appointments__page">
        <div class="appointments__table">
          <div class="table-heading__container">
            <h1 class="table-heading">pending appointments <span class="table-item-count"><?php echo $number_of_results ?></span></h1>
            <?php include("includes/search.php"); ?>
          </div>

          <?php if (count($users) > 0) { ?>
          <table>
            <thead>
              <tr>
                <th>patient id #</th>
                <th>
                  patient name
                </th>
                <th>phone</th>
                <th>time</th>
                <th>doctor</th>
                <th>
                  date
                  <div class="dropdown-container">
                    <button class="filter-btn">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.22488 3.35999L3.36487 1.5L1.50488 3.35999" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3.36499 10.5V1.5" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.77466 8.64001L8.63467 10.5L10.4947 8.64001" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.63379 1.5V10.5" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    </button>

                    <ul class="dropdown date">
                      <li><button>all</button></li>
                      <li><button>today</button></li>
                      <li><button>this week</button></li>
                      <li><button>this month</button></li>
                    </ul>
                  </div>
                </th>
                <th>Service</th>
                <th>actions</th>
              </tr>
            </thead>

            <tbody id="items">
              <tr class="no-appointment-message" style="display:none;">
                <td colspan="6" style="text-align: center;">There's no such appointment in this section</td>
              </tr>
              <?php foreach ($users as $user){?>
              <tr class="item-row appointment-row"
                data-date="<?php echo date('Y-m-d', strtotime($user['date'])); ?>">
                <td class="patient-cell id">
                  <?php echo $user['appointment_id']; ?>
                </td>
                <td class="patient-cell name">
                  <p class="patient-name" title="<?php echo $user['name']; ?>"><?php echo $user['name']; ?></p>
                  <p class="patient-email" title="<?php echo $user['email']; ?>"><?php echo $user['email']; ?></p>
                </td>
                <td class="patient-cell phone"> 
                  <?php echo $user['contact']; ?>
                </td>
                <td class="patient-cell time"><?php echo $user['time']; ?></td>
                <td class="patient-cell doctor">
                  <!-- lagay mo dito yung name ng doctor -->
                  <?php echo $user['doctor_id']; ?>
                </td>
                <td class="patient-cell date" data-date="<?php echo $user['date'] ?>"><?php echo $user['date']; ?></td>
                <td class="patient-cell message">
                  <!-- <button class="view-message-btn">View Message</button> -->
                  <p class="message-text" title="<?php echo $user['service'] . " " . $user['message']?>">
                    <?php echo $user['service'] . " " . $user['message']; ?>
                  </p>
                </td>
                <td class="patient-cell actions">
                  <div class="button-container">
                    <!-- accepts appointment -->
                    <form action="includes/accept_appointment.php" method="post">
                      <input type="button" value="Accept" name="accept" class="button accept" id="acceptBtn">
                    </form>

                    <?php
                        // Fetch appointments for the doctor that are on-duty
                        $query = "SELECT * FROM doctors";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $onDutyResult = $stmt->get_result();
                        $onDutyDoctors = [];
                        if ($onDutyResult->num_rows > 0) {
                            while ($row = $onDutyResult->fetch_assoc()) {
                                $onDutyDoctors[] = $row;
                            }
                        }
                    ?>

                    <div class="set-doctor-modal" id="setDoctorModal" style="display: none;">
                      <div class="content">
                        <p class="header">Set Doctor for Patient <?php echo $user['name']; ?></p>
                        <form action="includes/accept_appointment.php" method="post" id="setDoctorForm">
                              <input type="hidden" name="app_id" value="<?php echo $user['appointment_id']; ?>">
                              <input type="hidden" name="name" value="<?php echo $user['name']; ?>">
                              <input type="hidden" name="email" value="<?php echo $user['email']; ?>">
                              <input type="hidden" name="subject" value="Smile Hero Dental Clinic Appointment">
                              <input type="hidden" name="message"
                                value="Good Day <?php echo $user['name']; ?>, your appointment on <?php echo $user['date']; ?> at <?php echo $user['time']; ?> has been accepted. Appointment ID: <?php echo $user['appointment_id']; ?>">
                          <div>
                            <div class="appointment-form__field">
                              <label for="doctor" class="appointment-form__label">Doctor</label>
                              <select name="selected_doctor" id="doctor" class="appointment-form__select ">
                              <option value="">Select a Doctor</option>

                                <?php foreach($onDutyDoctors as $onDutyDoctor) { ?>
                                    <option value="<?php echo $onDutyDoctor['doctor_id']; ?>">
                                        Doc. <?php echo $onDutyDoctor['first_name'] . ' ' . $onDutyDoctor['last_name'] .' ('. $onDutyDoctor['availability'] . ')';?>
                                    </option>
                                <?php } ?>

                              </select>
                              <div class="appointment-form__validation">
                                <p class="appointment-form__text appointment-form__text--error">Error</p>
                                <p class="appointment-form__text appointment-form__text--valid">Valid</p>
                              </div>
                              <p class="time_error"></p>
                            </div>
                                                
                            <div class="btn-container">
                              <input type="submit" name="submit" value="Set Doctor" class="appointment-form__submit-button">
                              <input type="button" value="Cancel" class="appointment-form__cancel-button" id="cancelBtn">
                            </div>
                          </div>

                        </form>
                      </div>
                    </div>

                    <!-- cancel appointment -->
                    <form action="includes/cancel_appointment.php" method="post">
                      <input type="hidden" name="app_id" value="<?php echo $user['appointment_id']; ?>">
                      <input type="hidden" name="name" value="<?php echo $user['name']; ?>">
                      <input type="hidden" name="email" value="<?php echo $user['email']; ?>">
                      <input type="hidden" name="subject" value="Smile Hero Dental Clinic Appointment">
                      <input type="hidden" name="message"
                        value="Good Day <?php echo $user['name']; ?>, your appointment on <?php echo $user['date']; ?> at <?php echo $user['time']; ?> has been canceled. Please try again on another day.">
                      <input type="submit" value="Cancel" name="cancel" class="button cancel">
                    </form>
                  </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <?php } else { ?>
            <p>No appointment requests</p>
          <?php } ?>
        </div>

        <!-- modal -->
            <div class="modal" style="display: none">
              <div class="modal__content">
                <div class="body-text">
                  <div class="modal__header">
                    <h3 id="modalStatus" class="modal__status">
                    </h3>
                    <p id="modalMessage" class="modal__message">
                      <a href="appointments.php">
                        Go to booked appointments
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M9.62 3.95337L13.6667 8.00004L9.62 12.0467" stroke="#E84531" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M2.33333 8H13.5533" stroke="#E84531" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </a>
                    </p>
                  </div>
                  <button type="button" id="exitButton" class="modal__button">
                    okay, got it!
                  </button>
                </div>
                <div class="illustration__container">
                  <img src="../assets/appointment-update.svg" alt="illustration of accepted appointment">
                </div>
              </div>
            </div>

          <!-- Pagination -->
        <?php renderPagination($page, $totalPages) ?>
      </div>
    </section>
  </main>
</body>
<script>

  document.addEventListener('DOMContentLoaded', () => {
    const modalContainer = document.querySelector(".modal");
    const exitBtn = modalContainer.querySelector("#exitButton");
    const modalStatus = modalContainer.querySelector("#modalStatus");

    // Check if the modal should be displayed
    <?php if ($showModal) : ?>
    modalStatus.innerText = "<?php echo $modalStatus; ?>";
    modalContainer.style.display = "flex";
    <?php endif; ?>
    exitBtn.addEventListener("click", () => {
      modalContainer.style.transform = "scale(0)";
    });
  });


  const dropdownContainers = document.querySelectorAll('.dropdown-container')
  dropdownContainers.forEach(container => {
    container.addEventListener('click', e => {   
      if(e.target.closest('.filter-btn')) {
        const dropdown = container.querySelector('.dropdown')
        dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex'
      } 
    })
  })

  document.addEventListener('click', e => {
    if(!e.target.closest('.filter-btn'))
     document.querySelectorAll('.dropdown').forEach(dropdown => {
      dropdown.style.display = 'none'
     })
  })

  // filter date
  const dateDropdown = document.querySelector('.dropdown.date')
  const appointmentRows = document.querySelectorAll('.appointment-row')
  function isDateRange(date, startDate, endDate) {
    return date >= startDate && date <= endDate
  }

  function filterByDate(filterType) {
    const today = new Date()
    const startOfWeek = new Date(today);
    const endOfWeek = new Date(startOfWeek)
    startOfWeek.setDate(today.getDate() - today.getDay()); // start of the week - Sunday
    endOfWeek.setDate(startOfWeek.getDate() + 6) // end of the week saturday
    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1); // start of the current month
    const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0); // end of the current month

    let visibleRows = 0

    appointmentRows.forEach(row => {
      const appointmentDate = new Date(row.querySelector('.patient-cell.date').getAttribute('data-date'))

      let showRow = false
      if (filterType === 'all') showRow = true
      else if (filterType === 'today') showRow = today.toDateString() === appointmentDate.toDateString()
      else if (filterType === 'this week') showRow = isDateRange(appointmentDate, startOfWeek, endOfWeek)
      else if (filterType === 'this month') showRow = isDateRange(appointmentDate, startOfMonth, endOfMonth)

      row.style.display = showRow ? '' : 'none'
      if (showRow) visibleRows++
    })
    document.querySelector('.no-appointment-message').style.display = visibleRows === 0 ? '' : 'none'
  }

  dateDropdown.addEventListener('click', e => {
    const filterType = e.target.textContent.trim().toLowerCase()
    filterByDate(filterType)
  })

  const acceptBtns = document.querySelectorAll('#acceptBtn')
  acceptBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      // console.log(btn.parentElement.nextElementSibling.parentElement.parentElement.parentElement.querySelector('.name .patient-name').textContent);
      
      const doctorModal = btn.parentElement.nextElementSibling
      doctorModal.style.display = 'flex'
      
      const cancelBtnForm = doctorModal.querySelector('.appointment-form__cancel-button')
      cancelBtnForm.addEventListener('click', () => {
        doctorModal.style.display = 'none'
      })
    })
  })
</script>

</html>

