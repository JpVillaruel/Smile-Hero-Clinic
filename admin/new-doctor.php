<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once './includes/pagination.php';

if (!isset($_SESSION['adminID'])) {
  // Redirect user to login if not logged in
  header("Location: ../login.php?login=failed");
  exit();
}

$showModal = false;
if (isset($_SESSION['doctors_process'])) {
    if ($_SESSION['doctors_process'] === 'created') {
        $showModal = true;
    }
    unset($_SESSION['doctors_process']);
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
    <title>Add Doctor | Admin</title>
    <link rel="stylesheet" href="../src/dist/styles.css" />
  </head>
  <body class="admin__page">
    <main class="admin__main">
      <!-- nav header -->
      <?php include("includes/nav.php"); ?>

      <section class="admin__content">
        <!-- side bar -->
        <?php include("includes/side_nav.php"); ?>

        <div class="new-doctor__container">
          <h1>Add Doctor</h1>

          <form action="includes/add_doctor.php" method="post" id="doctorForm">
            <section
              class="doctor-form__section doctor-form__section--personal-details"
            >
              <div class="doctor-form__field">
                <label for="firstname" class="doctor-form__label">First Name</label>
                <input
                  type="text"
                  name="firstname"
                  id="firstname"
                  placeholder="e.g. Juan"
                  class="doctor-form__input"
                />
                <div class="doctor-form__validation">
                  <p
                    class="doctor-form__text doctor-form__text--error"
                  >
                    Error
                  </p>
                  <p
                    class="doctor-form__text doctor-form__text--valid"
                  >
                    Valid
                  </p>
                </div>
              </div>
              <div class="doctor-form__field">
                <label for="lastname" class="doctor-form__label">Last Name</label>
                <input
                  type="text"
                  name="lastname"
                  id="lastname"
                  placeholder="e.g. Dela Cruz"
                  class="doctor-form__input"
                />
                <div class="doctor-form__validation">
                  <p class="doctor-form__text doctor-form__text--error">
                    Error
                  </p>
                  <p class="doctor-form__text doctor-form__text--valid">
                    Valid
                  </p>
                </div>
              </div>
              <div class="doctor-form__field">
                <label for="email" class="doctor-form__label">Email</label>
                <input
                  type="email"
                  name="email"
                  id="email"
                  placeholder="e.g. juandelacruz@gmail.com"
                  class="doctor-form__input"
                />
                <div class="doctor-form__validation">
                  <p
                    class="doctor-form__text doctor-form__text--error"
                  >
                    Error
                  </p>
                  <p
                    class="doctor-form__text doctor-form__text--valid"
                  >
                    Valid
                  </p>
                </div>
              </div>
              <div class="doctor-form__field">
                <label for="contactnumber" class="doctor-form__label"
                  >Contact Number</label
                >
                <input
                  type="tel"
                  onkeypress="isNumber(event)"
                  name="contactnumber"
                  id="contactnumber"
                  placeholder="e.g. 09123456789"
                  class="doctor-form__input"
                />
                <div class="doctor-form__validation">
                  <p
                    class="doctor-form__text doctor-form__text--error"
                  >
                    Error
                  </p>
                  <p
                    class="doctor-form__text doctor-form__text--valid"
                  >
                    Valid
                  </p>
                </div>
              </div>
              <input
                type="submit"
                name="submit"
                value="Add Doctor"
                class="doctor-form__submit-button"
              />
            </section>

            <!-- modal -->
            <div class="modal" style="display: none">
              <div class="modal__content">
                <div class="body-text">
                  <div class="modal__header">
                    <h3 id="modalStatus" class="modal__status">
                      New Doctor <br> successfully <br> Added
                    </h3>
                    <p id="modalMessage" class="modal__message">
                      <a href="doctors.php">
                        Go to doctors
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
                    <g clip-path="url(#clip0_652_3291)">
                    <rect width="369" height="369" fill="#1D72F2"/>
                    <g filter="url(#filter0_f_652_3291)">
                    <circle cx="12.0337" cy="368.527" r="67.5" fill="#EBEBEB"/>
                    </g>
                    <g filter="url(#filter1_f_652_3291)">
                    <circle cx="394.034" cy="109.527" r="67.5" fill="#EBEBEB"/>
                    </g>
                    <g filter="url(#filter2_f_652_3291)">
                    <circle cx="309" cy="369" r="87" fill="#EBEBEB"/>
                    </g>
                    <g filter="url(#filter3_f_652_3291)">
                    <circle cx="52" cy="-32" r="87" fill="#EBEBEB"/>
                    </g>
                    <g clip-path="url(#clip1_652_3291)">
                    <path d="M351.382 138.325H296.882V64.5657L344.006 90.3815L351.382 138.325Z" fill="#4F4F4F"/>
                    <path d="M306.95 125.307C326.492 125.307 342.334 109.465 342.334 89.9234C342.334 70.3816 326.492 54.5398 306.95 54.5398C287.409 54.5398 271.567 70.3816 271.567 89.9234C271.567 109.465 287.409 125.307 306.95 125.307Z" fill="#FFB6B6"/>
                    <path d="M286.638 130.539L285.039 114.38L316.961 108.411L335.811 154.306L303.029 192.005L279.672 146.111L286.638 130.539Z" fill="#FFB6B6"/>
                    <path d="M383.284 167.845C382.886 168.259 382.48 168.669 382.075 169.074C380.788 170.361 379.477 171.611 378.137 172.824C358.058 191.034 332.295 201 305 201C279.836 201 255.975 192.53 236.67 176.938C236.658 176.93 236.65 176.922 236.638 176.909C236.052 176.438 235.474 175.959 234.896 175.471C234.998 175.176 235.109 174.885 235.22 174.598C241.428 158.424 253.688 150.512 261.13 147.049C264.818 145.332 267.321 144.705 267.321 144.705L276.058 128.97L282.209 140.443L286.741 148.901L305.336 183.597L321.379 143.652L326.349 131.269L327.624 128.097L333.684 132.813L339.421 137.276L350.973 139.825L360.344 141.894L373.072 144.705C378.219 148.897 381.349 156.871 383.099 166.78C383.165 167.132 383.226 167.489 383.284 167.845Z" fill="white"/>
                    <path d="M288.338 49.7126C292.648 42.4727 300.564 37.5053 308.958 36.7731C317.352 36.041 326.008 39.563 331.507 45.9473C334.783 49.7518 336.932 54.411 340.125 58.2852C346.998 66.6223 358.718 71.4969 361.72 81.8762C363.03 86.4054 362.377 91.2409 361.715 95.9089C361.146 99.91 360.578 103.911 360.01 107.912C359.568 111.026 359.144 114.308 360.311 117.229C361.681 120.655 364.959 122.899 367.079 125.919C370.685 131.058 370.421 138.582 366.464 143.457C364.748 145.57 362.473 147.165 360.673 149.208C358.874 151.252 357.54 154.046 358.293 156.662C359.737 161.674 367.597 162.876 368.459 168.02C368.9 170.65 367.083 173.277 364.703 174.479C362.323 175.682 359.521 175.717 356.874 175.395C346.813 174.172 337.497 167.885 332.598 159.012C327.7 150.139 327.343 138.907 331.669 129.741C335.222 122.213 341.825 115.56 341.753 107.236C341.714 102.701 339.634 98.4656 337.6 94.4123C333.437 86.1161 329.274 77.8199 325.111 69.5237C322.881 65.0797 320.293 60.2908 315.702 58.3817C312.154 56.9062 308.128 57.4785 304.333 58.082C300.538 58.6854 296.518 59.2729 292.959 57.8231C289.401 56.3733 286.712 52.0658 288.407 48.6174" fill="#616161"/>
                    <path d="M294.539 50.0907C287.703 47.8405 280.034 51.4529 275.406 56.9645C270.778 62.476 268.533 69.547 266.395 76.4189C265.17 80.3551 263.945 84.2913 262.72 88.2275C261.567 91.9304 260.415 95.6332 259.262 99.336C257.907 103.691 256.54 108.318 257.653 112.742C258.457 115.94 260.526 118.844 260.571 122.142C260.617 125.586 258.46 128.61 256.57 131.49C254.68 134.369 252.905 137.791 253.806 141.116C255.176 146.173 262.207 148.953 261.822 154.178C261.693 155.922 260.685 157.535 260.703 159.284C260.726 161.508 262.468 163.431 264.509 164.317C266.549 165.203 268.845 165.252 271.069 165.212C277.893 165.092 284.703 164.282 291.364 162.798C293.927 162.227 296.533 161.526 298.666 159.996C300.8 158.465 302.391 155.929 302.113 153.318C301.681 149.25 297.306 146.941 295.099 143.497C292.931 140.113 292.981 135.826 292.046 131.917C290.761 126.546 287.588 121.856 285.205 116.873C276.249 98.1402 279.384 74.2621 292.873 58.476C294.066 57.0803 295.369 55.6761 295.866 53.909C296.364 52.1418 295.722 49.8902 293.994 49.272" fill="#616161"/>
                    <path d="M382.074 14.9255C361.487 -5.66155 334.114 -17 305 -17C275.886 -17 248.513 -5.66155 227.926 14.9255C207.338 35.5126 196 62.8855 196 92C196 118.574 205.445 143.697 222.754 163.534C224.406 165.432 226.131 167.28 227.926 169.074C228.348 169.497 228.774 169.919 229.204 170.328C230.351 171.439 231.519 172.525 232.708 173.578C233.429 174.221 234.158 174.852 234.896 175.471C235.474 175.959 236.051 176.438 236.637 176.909C236.65 176.922 236.658 176.93 236.67 176.938C255.975 192.53 279.836 201 305 201C332.295 201 358.058 191.034 378.137 172.824C379.477 171.611 380.788 170.361 382.074 169.074C382.48 168.669 382.886 168.259 383.283 167.845C384.39 166.706 385.463 165.546 386.512 164.37C404.284 144.406 414 118.951 414 92C414 62.8855 402.662 35.5126 382.074 14.9255ZM386.246 163.35C385.222 164.514 384.173 165.661 383.099 166.78C381.427 168.521 379.702 170.21 377.919 171.836C377.243 172.459 376.559 173.066 375.866 173.668C368.872 179.753 361.086 184.949 352.69 189.088C349.743 190.543 346.723 191.866 343.634 193.05C331.631 197.656 318.605 200.18 305 200.18C291.871 200.18 279.283 197.828 267.633 193.526C262.851 191.764 258.228 189.67 253.79 187.273C253.139 186.92 252.491 186.564 251.848 186.199C248.463 184.281 245.189 182.187 242.046 179.925C239.698 178.241 237.42 176.467 235.22 174.598C234.449 173.947 233.687 173.287 232.937 172.611C231.716 171.525 230.519 170.406 229.352 169.259C227.139 167.091 225.024 164.833 223.004 162.485C206.691 143.537 196.82 118.902 196.82 92C196.82 32.3491 245.349 -16.1805 305 -16.1805C364.651 -16.1805 413.18 32.3491 413.18 92C413.18 119.316 403.006 144.295 386.246 163.35Z" fill="white"/>
                    </g>
                    <g clip-path="url(#clip2_652_3291)">
                    <path d="M55.9505 307.308C75.4923 307.308 91.3341 291.466 91.3341 271.924C91.3341 252.382 75.4923 236.541 55.9505 236.541C36.4087 236.541 20.5669 252.382 20.5669 271.924C20.5669 291.466 36.4087 307.308 55.9505 307.308Z" fill="#FFB6B6"/>
                    <path d="M35.638 312.54L34.0395 296.381L65.9613 290.412L84.811 336.307L52.029 374.006L28.6719 328.112L35.638 312.54Z" fill="#FFB6B6"/>
                    <path d="M33.5264 304.47L40.5053 306.047C40.5053 306.047 35.0191 288.65 36.8813 286.989C38.7434 285.328 43.3066 287.945 43.3066 287.945L48.1017 293.321L53.9426 287.375C53.9426 287.375 60.2839 279.49 62.7667 277.275C65.2495 275.061 61.2615 266.841 61.2615 266.841C61.2615 266.841 98.0969 256.908 84.3904 239.042C84.3904 239.042 76.3544 225.034 73.7374 229.597C71.1204 234.16 67.9999 226.913 67.9999 226.913L58.4711 228.725C58.4711 228.725 39.6648 217.636 21.8154 241.358C3.96601 265.08 33.5264 304.47 33.5264 304.47Z" fill="#616161"/>
                    <path d="M122.498 358.803C103.161 374.481 79.238 383 53.9999 383C30.9542 383 9.00262 375.894 -9.35938 362.724C-9.32658 362.38 -9.2938 362.04 -9.26511 361.7C-8.77748 356.373 -8.34312 351.193 -8.0563 346.899C-6.9458 330.225 31.9541 319.112 31.9541 319.112C31.9541 319.112 32.1303 319.288 32.4827 319.595C34.6299 321.48 43.3458 328.315 58.6304 330.225C72.2595 331.93 76.7465 323.845 78.1029 319.972C78.5127 318.792 78.6356 318.001 78.6356 318.001L118.646 336.896C121.256 340.625 122.277 348.657 122.477 357.684C122.486 358.057 122.494 358.426 122.498 358.803Z" fill="white"/>
                    <path d="M131.074 196.926C110.487 176.338 83.1145 165 54 165C24.8855 165 -2.4874 176.338 -23.0745 196.926C-43.6615 217.513 -55 244.886 -55 274C-55 300.574 -45.5547 325.697 -28.2458 345.534C-26.5944 347.432 -24.8693 349.28 -23.0745 351.074C-22.6524 351.497 -22.2262 351.919 -21.796 352.328C-20.6486 353.439 -19.4807 354.525 -18.2924 355.578C-17.5712 356.221 -16.8418 356.852 -16.1042 357.471C-15.5264 357.959 -14.9486 358.438 -14.3626 358.909C-14.3504 358.922 -14.3422 358.93 -14.3299 358.938C-12.7031 360.249 -11.0476 361.511 -9.35932 362.724C9.00268 375.895 30.9543 383 54 383C79.238 383 103.161 374.481 122.498 358.803C124.076 357.524 125.62 356.197 127.137 354.824C128.476 353.611 129.788 352.361 131.074 351.074C131.48 350.669 131.886 350.259 132.283 349.845C133.39 348.706 134.463 347.546 135.512 346.37C153.284 326.406 163 300.951 163 274C163 244.886 151.662 217.513 131.074 196.926ZM135.246 345.35C134.222 346.514 133.173 347.661 132.099 348.78C130.427 350.521 128.702 352.21 126.919 353.836C126.243 354.459 125.559 355.066 124.866 355.668C124.08 356.352 123.285 357.024 122.477 357.684C116.114 362.909 109.143 367.416 101.69 371.088C98.7433 372.543 95.7232 373.866 92.6335 375.05C80.6313 379.656 67.6045 382.18 54 382.18C40.8708 382.18 28.2826 379.828 16.6327 375.526C11.8506 373.764 7.22836 371.67 2.7905 369.273C2.13895 368.92 1.49152 368.564 0.848172 368.199C-2.53657 366.281 -5.81066 364.187 -8.95362 361.925C-9.05607 361.852 -9.16261 361.774 -9.26506 361.7C-11.5024 360.085 -13.6783 358.385 -15.7805 356.598C-16.5509 355.947 -17.313 355.287 -18.0629 354.611C-19.284 353.525 -20.4806 352.406 -21.6485 351.259C-23.8612 349.091 -25.9757 346.833 -27.9959 344.485C-44.309 325.537 -54.1805 300.902 -54.1805 274C-54.1805 214.349 -5.65084 165.82 54 165.82C113.651 165.82 162.18 214.349 162.18 274C162.18 301.316 152.006 326.295 135.246 345.35Z" fill="white"/>
                    </g>
                    </g>
                    <defs>
                    <filter id="filter0_f_652_3291" x="-155.466" y="201.027" width="335" height="335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                    <feGaussianBlur stdDeviation="50" result="effect1_foregroundBlur_652_3291"/>
                    </filter>
                    <filter id="filter1_f_652_3291" x="226.534" y="-57.9727" width="335" height="335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                    <feGaussianBlur stdDeviation="50" result="effect1_foregroundBlur_652_3291"/>
                    </filter>
                    <filter id="filter2_f_652_3291" x="122" y="182" width="374" height="374" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                    <feGaussianBlur stdDeviation="50" result="effect1_foregroundBlur_652_3291"/>
                    </filter>
                    <filter id="filter3_f_652_3291" x="-135" y="-219" width="374" height="374" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                    <feGaussianBlur stdDeviation="50" result="effect1_foregroundBlur_652_3291"/>
                    </filter>
                    <clipPath id="clip0_652_3291">
                    <rect width="369" height="369" fill="white"/>
                    </clipPath>
                    <clipPath id="clip1_652_3291">
                    <rect width="218" height="218" fill="white" transform="translate(196 -17)"/>
                    </clipPath>
                    <clipPath id="clip2_652_3291">
                    <rect width="218" height="218" fill="white" transform="translate(-55 165)"/>
                    </clipPath>
                    </defs>
                  </svg>
                </div>
              </div>
            </div>
          </form>
        </div>
      </section>
    </main>
  </body>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const doctorForm = document.getElementById('doctorForm');
      const modalContainer = document.querySelector(".modal");
      const exitBtn = modalContainer.querySelector("#exitButton");
      
    <?php if ($showModal) : ?>
      modalContainer.style.display = "flex";
    <?php endif; ?>

      doctorForm.addEventListener('submit', (e) => {
        e.preventDefault()

        const fields = [
          {
            id: 'firstname',
            errorMessage: 'First name cannot be empty'
          },
          {
            id: 'lastname',
            errorMessage: 'Last name cannot be empty'
          },
          {
            id: 'email',
            errorMessage: 'Email cannot be empty'
          },
          {
            id: 'contactnumber',
            errorMessage: 'Contact number cannot be empty'
          },
        ]

        let isValid = true
        fields.forEach((field) => {
          const fieldElement = document.getElementById(field.id);
          const errorElement = fieldElement.nextElementSibling.querySelector('.doctor-form__text--error');
          const validElement = fieldElement.nextElementSibling.querySelector('.doctor-form__text--valid');

          if (fieldElement.value.trim() === '-' || fieldElement.value.trim() === '') {
            errorElement.innerText = field.errorMessage;
            errorElement.style.display = 'block'; // Show error message
            validElement.style.display = 'none'; // Hide valid message
            isValid = false;
          } else {
            errorElement.style.display = 'none'; // Hide error message
            validElement.style.display = 'block'; // Show valid message
          }
        })

        if (isValid) {
          HTMLFormElement.prototype.submit.call(doctorForm);
        }
      });
        // Close modal when exit button is clicked
        exitBtn.addEventListener("click", () => {
            modalContainer.style.transform = "scale(0)";
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
  </script>
</html>
