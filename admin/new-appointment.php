<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/appointment_view.inc.php';
require_once '../includes/dbh.inc.php';

if (!isset($_SESSION['adminID'])) {
  // Redirect user to login if not logged in
  header("Location: ../login.php?login=failed");
  exit();
}

$showModal = false;
$modalStatus = '';
if (isset($_SESSION['appointment_status'])) {
    if ($_SESSION['appointment_status'] === 'created') {
        $showModal = true;
        $modalStatus = 'Appointment Successfully Created.';
    } elseif ($_SESSION['appointment_status'] === 'exists') {
        $showModal = true;
        $modalStatus = 'The patient already has an appointment.';
    }
    unset($_SESSION['appointment_status']);
}

$query = "SELECT available_dates FROM appointment_dates WHERE available_dates >= CURDATE()";
$result = $conn->query($query);

$availableDates = [];
while ($row = $result->fetch_assoc()) {
    $availableDates[] = $row['available_dates'];
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
    <title>Create Appointment | Admin</title>

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
  </head>
  <body class="admin__page">
    <main class="admin__main">
      <!-- nav header -->
      <?php include("includes/nav.php"); ?>

      <section class="admin__content">
        <!-- side bar -->
        <?php include("includes/side_nav.php"); ?>

        <div class="new-appointment__container">
          <h1>create new appointment</h1>

          <form action="includes/admin_appointment.php" method="post" id="appointmentForm">
            <section
              class="appointment-form__section appointment-form__section--personal-details"
            >
              <div class="appointment-form__field">
                <label for="fname" class="appointment-form__label">Firstname</label>
                <input
                  type="text"
                  name="fname"
                  id="fname"
                  placeholder="e.g. Juan"
                  class="appointment-form__input"/>
                <div class="appointment-form__validation">
                  <p class="appointment-form__text appointment-form__text--error">Error</p>
                  <p class="appointment-form__text appointment-form__text--valid">Valid</p>
                </div>
              </div>
              <div class="appointment-form__field">
                <label for="mname" class="appointment-form__label">Middlename</label>
                <input
                  type="text"
                  name="mname"
                  id="mname"
                  placeholder="e.g. Manuel"
                  class="appointment-form__input"/>
                <div class="appointment-form__validation">
                  <p class="appointment-form__text appointment-form__text--error">Error</p>
                  <p class="appointment-form__text appointment-form__text--valid">Valid</p>
                </div>
              </div>
              <div class="appointment-form__field">
                <label for="lname" class="appointment-form__label">Lastname</label>
                <input
                  type="text"
                  name="lname"
                  id="lname"
                  placeholder="e.g. Dela Cruz"
                  class="appointment-form__input"/>
                <div class="appointment-form__validation">
                  <p class="appointment-form__text appointment-form__text--error">Error</p>
                  <p class="appointment-form__text appointment-form__text--valid">Valid</p>
                </div>
              </div>
              <div class="appointment-form__field">
                <label for="suffix" class="appointment-form__label">Suffix</label>
                <input
                  type="text"
                  name="suffix"
                  id="suffix"
                  placeholder="Sr. / Jr."
                  class="appointment-form__input"/>
                <div class="appointment-form__validation">
                  <p class="appointment-form__text appointment-form__text--error">Error</p>
                  <p class="appointment-form__text appointment-form__text--valid">Valid</p>
                </div>
              </div>
              <div class="appointment-form__field">
                <label for="email" class="appointment-form__label">Email</label>
                <input
                  type="email"
                  name="email"
                  id="email"
                  placeholder="e.g. fahatmahmabang@gmail.com"
                  class="appointment-form__input"/>
                <div class="appointment-form__validation">
                  <p class="appointment-form__text appointment-form__text--error">Error</p>
                  <p class="appointment-form__text appointment-form__text--valid">Valid</p>
                </div>
              </div>
              <div class="appointment-form__field">
                <label for="contactnumber" class="appointment-form__label">Contact Number</label>
                <input
                  type="tel"
                  onkeypress="isNumber(event)"
                  name="contactnumber"
                  id="contactnumber"
                  placeholder="e.g. 09123456789"
                  class="appointment-form__input"/>
                <div class="appointment-form__validation">
                  <p class="appointment-form__text appointment-form__text--error">Error</p>
                  <p class="appointment-form__text appointment-form__text--valid">Valid</p>
                </div>
              </div>
              <div class="appointment-form__field">
                <label for="message" class="appointment-form__label">Message/Requests</label>
                <input
                  type="text"
                  name="message"
                  id="message"
                  class="appointment-form__input"/>
                <div class="appointment-form__validation">
                  <p class="appointment-form__text appointment-form__text--error">Error</p>
                  <p class="appointment-form__text appointment-form__text--valid">Valid</p>
                </div>
              </div>
            </section>

            <div class="modal" style="display: none;">
              <div class="modal__content">
                <div class="body-text">
                  <div class="modal__header">
                    <h3 id="modalStatus" class="modal__status"></h3>
                    <p id="modalMessage" class="modal__message">
                      <a href="booked.php">
                        Go to appointments
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
                  <svg width="369" height="369" viewBox="0 0 369 369" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_635_2797)">
                    <rect width="369" height="369" fill="#1D72F2"/>
                    <g clip-path="url(#clip1_635_2797)">
                    <path d="M314.728 368.609L318.18 435.027C318.18 435.027 172.154 295.76 153.961 255.013C135.769 214.265 170.013 113.468 170.013 113.468L245.993 155.288L314.728 368.609Z" fill="#E84531"/>
                    <path d="M90.8233 85.5874L68.3505 87.732C68.3505 87.732 56.579 113.467 92.9636 115.612L90.8233 85.5874Z" fill="#E84531"/>
                    <path d="M90.8233 125.263L68.3505 127.408C68.3505 127.408 56.579 153.143 92.9636 155.288L90.8233 125.263Z" fill="#E84531"/>
                    <path d="M90.8233 168.156L68.3505 170.3C68.3505 170.3 56.579 196.036 92.9636 198.18L90.8233 168.156Z" fill="#E84531"/>
                    <path d="M97.2441 211.048L74.7712 213.192C74.7712 213.192 62.9997 238.928 99.3843 241.073L97.2441 211.048Z" fill="#E84531"/>
                    <path d="M79.8826 95.9264H81.5878V49.1185C81.5877 45.5608 82.2871 42.038 83.6457 38.7512C85.0044 35.4643 86.9959 32.4778 89.5064 29.9622C92.017 27.4465 94.9974 25.451 98.2776 24.0895C101.558 22.7281 105.073 22.0273 108.624 22.0273H207.591C211.142 22.0273 214.658 22.7281 217.938 24.0895C221.218 25.451 224.198 27.4465 226.709 29.9621C229.219 32.4778 231.211 35.4642 232.57 38.7511C233.928 42.0379 234.628 45.5608 234.628 49.1184V305.91C234.628 309.468 233.928 312.991 232.57 316.277C231.211 319.564 229.22 322.551 226.709 325.066C224.198 327.582 221.218 329.578 217.938 330.939C214.658 332.301 211.142 333.001 207.592 333.001H108.624C101.454 333.001 94.5768 330.147 89.5065 325.067C84.4363 319.986 81.5878 313.095 81.5878 305.91V129.245H79.8826V95.9264Z" fill="#3F3D56"/>
                    <path d="M107.533 29.0755H120.452C119.858 30.5349 119.631 32.1184 119.791 33.6864C119.952 35.2544 120.495 36.7588 121.372 38.067C122.249 39.3752 123.435 40.4472 124.823 41.1884C126.211 41.9296 127.76 42.3173 129.333 42.3175H186.03C187.603 42.3174 189.152 41.9296 190.54 41.1884C191.928 40.4472 193.114 39.3752 193.991 38.067C194.868 36.7588 195.411 35.2544 195.572 33.6864C195.732 32.1184 195.505 30.5349 194.911 29.0754H206.977C212.332 29.0754 217.468 31.2069 221.254 35.001C225.04 38.7952 227.168 43.9411 227.168 49.3068V305.722C227.168 308.378 226.645 311.009 225.631 313.464C224.616 315.918 223.129 318.149 221.254 320.027C219.379 321.906 217.153 323.396 214.704 324.413C212.254 325.43 209.629 325.953 206.977 325.953H107.533C104.882 325.953 102.256 325.43 99.8066 324.413C97.357 323.396 95.1312 321.906 93.2564 320.027C91.3815 318.149 89.8943 315.918 88.8797 313.464C87.865 311.009 87.3428 308.379 87.3428 305.722V49.3068C87.3428 46.65 87.865 44.0192 88.8797 41.5646C89.8943 39.11 91.3815 36.8797 93.2564 35.0011C95.1312 33.1224 97.357 31.6322 99.8066 30.6155C102.256 29.5987 104.882 29.0755 107.533 29.0755Z" fill="white"/>
                    <path d="M178.561 100.91H135.949V111.214H178.561V100.91Z" fill="#1D72F2"/>
                    <path d="M180.59 145.184H133.921V155.487H180.59V145.184Z" fill="#E5E5E5"/>
                    <path d="M209.335 167.317H105.175V177.62H209.335V167.317Z" fill="#E5E5E5"/>
                    <path d="M209.335 189.45H105.175V199.753H209.335V189.45Z" fill="#E5E5E5"/>
                    <path d="M415.534 403.202L295.754 266.272L291.474 178.342L246.528 103.281L233.686 71.1113C233.686 71.1113 203.723 74.3283 228.336 135.45L238.502 168.155C229.338 187.934 224.59 209.477 224.59 231.283V306.227C224.59 323.874 308.515 419.998 318.284 434.681L415.534 403.202Z" fill="#E84531"/>
                    <path opacity="0.2" d="M237.21 109.641L246.145 105.241L245.841 104.62L237.585 108.686L225.122 75.9451L224.477 76.1921L237.21 109.641Z" fill="black"/>
                    <path opacity="0.2" d="M68.4701 87.4064L68.2314 88.0557L81.468 92.9415L81.7067 92.2922L68.4701 87.4064Z" fill="black"/>
                    <path opacity="0.2" d="M68.4701 127.534L68.2314 128.183L81.468 133.069L81.7067 132.42L68.4701 127.534Z" fill="black"/>
                    <path opacity="0.2" d="M68.4701 170.429L68.2314 171.078L81.468 175.964L81.7067 175.315L68.4701 170.429Z" fill="black"/>
                    <path opacity="0.2" d="M75.4049 213.337L75.1062 213.96L81.5505 217.06L81.8492 216.436L75.4049 213.337Z" fill="black"/>
                    <path d="M157.308 288.672C173.793 288.672 187.156 275.282 187.156 258.763C187.156 242.245 173.793 228.854 157.308 228.854C140.823 228.854 127.46 242.245 127.46 258.763C127.46 275.282 140.823 288.672 157.308 288.672Z" fill="#1D72F2"/>
                    <path d="M154.463 271.389L145.53 259.878L150.725 255.829L154.955 261.279L169.245 246.164L174.024 250.7L154.463 271.389Z" fill="white"/>
                    </g>
                    <g filter="url(#filter0_f_635_2797)">
                    <circle cx="12.0337" cy="368.527" r="67.5" fill="#EBEBEB"/>
                    </g>
                    <g filter="url(#filter1_f_635_2797)">
                    <circle cx="394.034" cy="109.527" r="67.5" fill="#EBEBEB"/>
                    </g>
                    </g>
                    <defs>
                    <filter id="filter0_f_635_2797" x="-155.466" y="201.027" width="335" height="335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                    <feGaussianBlur stdDeviation="50" result="effect1_foregroundBlur_635_2797"/>
                    </filter>
                    <filter id="filter1_f_635_2797" x="226.534" y="-57.9727" width="335" height="335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                    <feGaussianBlur stdDeviation="50" result="effect1_foregroundBlur_635_2797"/>
                    </filter>
                    <clipPath id="clip0_635_2797">
                    <rect width="369" height="369" fill="white"/>
                    </clipPath>
                    <clipPath id="clip1_635_2797">
                    <rect width="349" height="413" fill="white" transform="translate(66.5337 22.0273)"/>
                    </clipPath>
                    </defs>
                  </svg>
                </div>
              </div>
            </div>

            <section
              class="appointment-form__section appointment-form__section--preferences"
            >
              <div class="appointment-form__field">
                <label for="appointmentDate" class="appointment-form__label">Date</label>
                <input type="text" name="appointmentDate" id="appointmentDate" class="appointment-form__input" placeholder="Select a date">
                <div class="appointment-form__validation">
                  <p class="appointment-form__text appointment-form__text--error">Error</p>
                  <p class="appointment-form__text appointment-form__text--valid">Valid</p>
                </div>
              </div>
              <div class="appointment-form__field">
                <label for="appointmentTime" class="appointment-form__label">Time</label>
                <select
                  name="appointmentTime"
                  id="appointmentTime"
                  class="appointment-form__select"
                >
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
              </div>

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

              <div class="appointment-form__field">
                <label for="appointmentDoctor" class="appointment-form__label">Doctor</label>
                <select
                  name="appointmentDoctor"
                  id="appointmentDoctor"
                  class="appointment-form__select">

                  <option value="-">Select doctor</option>
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
                <label for="location" class="appointment-form__label"
                  >Location</label
                >
                <select
                  name="location"
                  id="location"
                  class="appointment-form__select"
                >
                  <option value="Bayani Road, Taguig City" selected>
                    Bayani Road, Taguig City
                  </option>
                </select>
                <div class="appointment-form__validation">
                  <p class="appointment-form__text appointment-form__text--error">Error</p>
                  <p class="appointment-form__text appointment-form__text--valid">Valid</p>
                </div>
              </div>
              <input
                type="submit"
                name="submit"
                value="Create Appointment"
                class="appointment-form__submit-button"
              />
            </section>
          </form>
        </div>
      </section>
    </main>
  </body>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const appointmentForm = document.getElementById('appointmentForm');
      const modalContainer = document.querySelector(".modal");
      const exitBtn = modalContainer.querySelector("#exitButton");
      const modalStatus = modalContainer.querySelector("#modalStatus");
      const modalMessage = modalContainer.querySelector("#modalMessage");
      const appointmentDateSelect = document.getElementById('appointmentDate');

      // Check if the modal should be displayed
      <?php if ($showModal) : ?>
      modalStatus.innerText = "<?php echo $modalStatus; ?>";
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
            id: 'fname',
            errorMessage: 'Firstname cannot be empty'
          },
          {
            id: 'mname',
            errorMessage: 'Middlename cannot be empty'
          },
          {
            id: 'lname',
            errorMessage: 'Lastname cannot be empty'
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
            id: 'appointmentDoctor',
            errorMessage: 'Please select a doctor'
          },
          {
            id: 'location',
            errorMessage: 'Please select a location'
          },
          // {
          //   id: 'dentalService',
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

    function isNumber(evt) {
    var input = evt.target.value;

    // Ensure only digits are entered
    var contactNum = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(contactNum))) {
        evt.preventDefault();
        return;
    }

    // Check if the input starts with "09" and length is less than 11 digits
    if (input.length === 0 && contactNum !== '0') {
        evt.preventDefault();
    } else if (input.length === 1 && contactNum !== '9') {
        evt.preventDefault();
    } else if (input.length >= 11) {
        evt.preventDefault();
    }
  } 

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
</html>
