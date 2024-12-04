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

$showModal = false;
$modalStatus = '';
$modalMessage = '';
$modalMessage1 = '';
if (isset($_SESSION['appointment_status'])) {
    if ($_SESSION['appointment_status'] === 'created') {
        $showModal = true;
        $modalStatus = 'Your appointment request has been successfully submitted.';
        $modalMessage1 = '*Please allow 3 to 4 hours for processing and confirmation.*';
        $modalMessage = '*Kindly await an email notification for the confirmation of your appointment.*';
    } elseif ($_SESSION['appointment_status'] === 'exists') {
        $showModal = true;
        $modalStatus = 'You already submitted an appointment.';
        $modalMessage1 = '*Please wait for processing and confirmation.*';
        $modalMessage = '*Kindly await an email notification for the confirmation of your appointment.*';
    }
    unset($_SESSION['appointment_status']);
}

$TimeMessageError = '';
if (isset($_SESSION['time_limit'])) {
    if ($_SESSION['time_limit'] === 'invalid') { 
        $TimeMessageError = 'Sorry, the selected time on your selected date is fully booked.';
    }
    unset($_SESSION['time_limit']);
}

$DateMessageError = '';
if (isset($_SESSION['date_limit'])) {
    if ($_SESSION['date_limit'] === 'invalid') { 
        $DateMessageError = 'Sorry, the selected time is fully booked.';
    }
    unset($_SESSION['date_limit']);
}

$query = "SELECT available_dates FROM appointment_dates WHERE available_dates >= CURDATE()";
$result = $conn->query($query);

$availableDates = [];
while ($row = $result->fetch_assoc()) {
    $availableDates[] = $row['available_dates'];
}

// Fetch dates with 20 or more appointments
// $disabledDatesQuery = "SELECT date FROM appointments GROUP BY date HAVING COUNT(*) >= 20 ";
// $disabledDatesResult = $conn->query($disabledDatesQuery);

// $disabledDates = [];
// while ($row = $disabledDatesResult->fetch_assoc()) {
//     $disabledDates[] = $row['date'];
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/images/logoipsum.svg" type="image/x-icon">
  <title>Create an appointment | Smile Hero Clinic</title>

  <style>
    .time_error{
      color: red;
      font-size: 0.875rem;
    }

    .flatpickr-calendar {
      font-family: 'Inter', sans-serif !important;
      font-size: 0.68rem !important;
      color: #616161 !important;
      background-color: #fff !important;
      border: 1px solid #ccc;
      border-radius: .5rem !important;
      overflow: hidden !important;
    }

    .flatpickr-calendar > * {
      color: #616161 !important;
      letter-spacing: -1px !important;
    }

    .flatpickr-day.today {
      background-color: hsl(0, 0%, 38%, 0.6) !important;
      color: #fff !important;
      font-weight: 600 !important;
    }

    .flatpickr-day.selected {
      background-color: #1D72F2 !important;
      color: #fff !important; 
      font-weight: 600 !important;
    }

    .flatpickr-month {
      font-weight: 600 !important;
      letter-spacing: -1px !important;
    }

    .flatpickr-day.disabled {
      background-color: 	hsla(216, 89%, 53%, 0.5);
        color: white !important;
        pointer-events: none;
        cursor: progress;
    }
  </style>
  
  <link rel="stylesheet" href="../src/dist/styles.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="js/mobile-nav.js" defer></script>
</head>

<body class="user__page">
  <main class="user__main">
    <!-- navigation header bar -->
    <?php include('includes/nav.php'); ?>

    <section class="user-contents">
      <!-- navigation side nav -->
      <?php include('includes/sidenav.php'); ?>

      <!-- appointment form -->
      <div class="appointment_form">
        <h1>Schedule fresh meeting</h1> 

        <form action="../includes/appointment.inc.php" method="post" id="appointmentForm">
          <!-- Personal Details Section -->
          <section class="appointment-form__section appointment-form__section--personal-details">
            <div class="appointment-form__field">
              <label for="name" class="appointment-form__label">Name</label>
              <input type="text" name="name" id="name" placeholder="e.g. Fahatmah Mabang" value="<?php outputFullName() ?>" class="appointment-form__input" />
              <div class="appointment-form__validation">
                <p class="appointment-form__text appointment-form__text--error">Error</p>
                <p class="appointment-form__text appointment-form__text--valid">Valid</p>
              </div>
            </div>
            <div class="appointment-form__field">
              <label for="email" class="appointment-form__label">Email</label>
              <input type="email" name="email" id="email" placeholder="e.g. fahatmahmabang@gmail.com" value="<?php outputEmail() ?>" class="appointment-form__input" />
              <div class="appointment-form__validation">
                <p class="appointment-form__text appointment-form__text--error">Error</p>
                <p class="appointment-form__text appointment-form__text--valid">Valid</p>
              </div>
            </div>
            <div class="appointment-form__field">
              <label for="contactnumber" class="appointment-form__label">Contact Number</label>
              <input type="tel" name="contactnumber" id="contactnumber" placeholder="e.g. 09123456789" value="<?php outputContact() ?>" class="appointment-form__input" />
              <div class="appointment-form__validation">
                <p class="appointment-form__text appointment-form__text--error">Error</p>
                <p class="appointment-form__text appointment-form__text--valid">Valid</p>
              </div>
            </div>
            <div class="appointment-form__field">
              <label for="message" class="appointment-form__label">Message/Requests</label>
              <input type="text" name="message" id="message" class="appointment-form__input" />
              <div class="appointment-form__validation">
                <p class="appointment-form__text appointment-form__text--error">Error</p>
                <p class="appointment-form__text appointment-form__text--valid">Valid</p>
              </div>
            </div>
          </section> 
          <!-- Modal -->
          <div class="modal" style="display: none; z-index: 1;">
            <div class="modal__content">
              <div class="modal__header">
                <h3 id="modalStatus" class="modal__status"></h3>
                <p id="modalMessage1" class="modal__message"></p>
                <p id="modalMessage" class="modal__message"></p>
              </div>
              <button type="button" id="exitButton" class="modal__button">Okay, got it!</button>
            </div>
          </div>
          <!-- Preferences Section -->
          <section class="appointment-form__section appointment-form__section--preferences">
            <div class="appointment-form__field">
              <label for="appointmentDate" class="appointment-form__label">Date</label>
              <input type="text" name="appointmentDate" id="appointmentDate" class="appointment-form__input" placeholder="Select a date" 
                      value="<?php echo (isset( $_SESSION['selectAppointmentDate']) ? $_SESSION['selectAppointmentDate'] : ''); ?>">
              <div class="appointment-form__validation">
                <p class="appointment-form__text appointment-form__text--error">Error</p>
                <p class="appointment-form__text appointment-form__text--valid">Valid</p>
              </div>
              <p class="time_error"><?php echo $DateMessageError ?></p>
            </div>

            <div class="appointment-form__field">
              <label for="appointmentTime" class="appointment-form__label">Time</label>
              <select name="appointmentTime" id="appointmentTime" class="appointment-form__select">
                  <option value="-">Select time</option>
                  <option value="9:00 AM">09:00 AM</option>
                  <option value="10:00 AM">10:00 AM</option>
                  <option value="11:00 AM">11:00 AM</option>
                  <option value="1:00 PM">01:00 PM</option>
                  <option value="2:00 PM">02:00 PM</option>
                  <option value="3:00 PM">03:00 PM</option>
                  <option value="4:00 PM">04:00 PM</option>
                  <option value="5:00 PM">05:00 PM</option>
              </select>
              <div class="appointment-form__validation">
                <p class="appointment-form__text appointment-form__text--error">Error</p>
                <p class="appointment-form__text appointment-form__text--valid">Valid</p>
              </div>
              <p class="time_error"><?php echo $TimeMessageError ?></p>
            </div>
            <div class="appointment-form__field">
              <label class="appointment-form__label">Service</label>
              <input type="button" value="Select service" class="services-btn" id="servicesBtn">
              <div class="selected-services" id="selectedServices"></div>
              <div class="appointment-form__checkbox-group">
                <div class="checkbox-container">
                    <input type="checkbox" id="cleaning" name="dentalService[]" value="teeth cleaning  ₱2,800">
                    <label for="cleaning">Teeth Cleaning <span class="service-price">₱2,800</span></label>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" id="whitening" name="dentalService[]" value="teeth whitening  ₱8,400">
                    <label for="whitening">Teeth Whitening <span class="service-price">₱8,400</span></label>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" id="extraction" name="dentalService[]" value="tooth extraction  ₱4,200">
                    <label for="extraction">Tooth Extraction <span class="service-price">₱4,200</span></label>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" id="filling" name="dentalService[]" value="dental filling  ₱6,700">
                    <label for="filling">Dental Filling <span class="service-price">₱6,700</span></label>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" id="checkup" name="dentalService[]" value="routine checkup-up ₱2,200">
                    <label for="checkup">Routine Check-up <span class="service-price">₱2,200</span></label>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" id="braces" name="dentalService[]" value="braces consultation  ₱5,600">
                    <label for="braces">Braces Consultation <span class="service-price">₱5,600</span></label>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" id="root_canal" name="dentalService[]" value="root canal treatment ₱16,800">
                    <label for="root_canal">Root Canal Treatment <span class="service-price">₱16,800</span></label>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" id="implants" name="dentalService[]" value="dental implants  ₱56,000">
                    <label for="implants">Dental Implants <span class="service-price">₱56,000</span></label>
                </div>
            </div>

              
              <div id="selectedServicesError" class="appointment-form__text--error" style="display: none; color: red; font-size: 14px; "></div>
            </div>

            <div class="appointment-form__field">
              <label for="location" class="appointment-form__label">Location</label>
              <select name="location" id="location" class="appointment-form__select">
                  <!-- <option value="-">Select location</option> -->
                  <option value="Bayani Road, Taguig City" selected>Bayani Road, Taguig City</option>
                  <!-- <option value="Main Street, Makati City">Main Street, Makati City</option>
                  <option value="Central Avenue, Quezon City">Central Avenue, Quezon City</option> -->
              </select>
              <div class="appointment-form__validation">
                <p class="appointment-form__text appointment-form__text--error">Error</p>
                <p class="appointment-form__text appointment-form__text--valid">Valid</p>
              </div>
            </div>
            <input type="submit" name="submit" value="Create Appointment" class="appointment-form__submit-button">
          </section>
        </form>

      </div>
    </section>
  </main>

  <!-- scripts -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const appointmentForm = document.getElementById('appointmentForm');
      const modalContainer = document.querySelector(".modal");
      const exitBtn = modalContainer.querySelector("#exitButton");
      const modalStatus = modalContainer.querySelector("#modalStatus");
      const modalMessage1 = modalContainer.querySelector("#modalMessage1");
      const modalMessage = modalContainer.querySelector("#modalMessage");
      const appointmentDateSelect = document.getElementById('appointmentDate');

      // Check if the modal should be displayed
      <?php if ($showModal) : ?>
      modalStatus.innerText = "<?php echo $modalStatus; ?>";
      modalMessage1.innerText = "<?php echo $modalMessage1; ?>";
      modalMessage.innerText = "<?php echo $modalMessage; ?>";
      modalContainer.style.display = "flex";
      modalContainer.style.transform = "scale(1)";
      <?php endif; ?>
      exitBtn.addEventListener("click", () => {
        modalContainer.style.transform = "scale(0)";
        // window.close()
      });

      appointmentForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const fields = [{
            id: 'name',
            errorMessage: 'Name cannot be empty'
          },
          {
            id: 'email',
            errorMessage: 'Email cannot be empty'
          },
          {
            id: 'contactnumber',
            errorMessage: 'Contact number cannot be empty'
          },
          {
            id: 'appointmentDate',
            errorMessage: 'Please select a date'
          },
          {
            id: 'appointmentTime',
            errorMessage: 'Please select a time'
          },
          {
            id: 'location',
            errorMessage: 'Please select a location'
          },
          // {
          //   id: 'selectedServices',
          //   errorMessage: 'Please select a service'
          // },
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

        // Validate dentalService checkboxes
        const serviceCheckboxes = document.querySelectorAll('input[name="dentalService[]"]');
        const selectedServicesError = document.getElementById('selectedServicesError');
        const anyServiceSelected = Array.from(serviceCheckboxes).some(checkbox => checkbox.checked);

        if (!anyServiceSelected) {
          selectedServicesError.innerText = 'Please select at least one service';
          selectedServicesError.style.display = 'block'; // Show error message
          isValid = false;
        } else {
          selectedServicesError.style.display = 'none'; // Hide error message
        }

        if (isValid) {
          HTMLFormElement.prototype.submit.call(appointmentForm);
        }
      });
    });

    function getCurrentDateTime() {
      const date = new Date()
      const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
      const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
      ]

      // get current day, month, date and year
      const dayOfWeek = daysOfWeek[date.getDay()]
      const month = months[date.getMonth()]
      const day = date.getDate()
      const year = date.getFullYear()

      let hours = date.getHours()
      let minutes = date.getMinutes().toString().padStart(2, '0')

      const period = hours >= 12 ? 'PM':'AM'
      hours = hours % 12 || 12

      return document.querySelector('.header__date').innerText = `${dayOfWeek} ${hours}:${minutes} ${period} | ${month} ${day}, ${year}`
    }

    setInterval(getCurrentDateTime, 1000)
  
    document.querySelector('.services-btn').addEventListener('click', function() {
      const checkboxGroup = document.querySelector('.appointment-form__checkbox-group')
      checkboxGroup.classList.toggle('active')
    })

    const checkBoxContainers = document.querySelectorAll('.checkbox-container')
    const servicesBtn = document.getElementById('servicesBtn')
    const selectedServicesContainer = document.getElementById('selectedServices')
    let selectedServices = []
    
    checkBoxContainers.forEach(container => {
      const inputEl = container.querySelector('input')
      
      inputEl.addEventListener('change', () => {
        selectedServices = []
        
        checkBoxContainers.forEach(checkBoxContainer => {
          const checkbox = checkBoxContainer.querySelector('input')
          const label = checkBoxContainer.querySelector('label')

          if(checkbox.checked) {
            checkBoxContainer.style.backgroundColor = '#1d72f2'
            label.classList.add('active')
            selectedServices.push(checkbox.value)            
          } else {
            checkBoxContainer.style.backgroundColor = ''
            label.classList.remove('active')
          }
        })
        showSelectedServices()
      })
    })

    function showSelectedServices() {
      selectedServicesContainer.innerHTML = `
      <ul>
        ${selectedServices.map(service => {
          return `<li>${service}</li>`
        }).join('')}
      </ul>
      `
    }

  // Pass PHP array to JavaScript
  const availableDates = <?php echo json_encode($availableDates); ?>;
  // const disabledDates = <?php 
  // echo json_encode($disabledDates)
  ; ?>;

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