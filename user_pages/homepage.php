<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/dbh.inc.php';

if(!isset($_SESSION['user_id'])) {
   // Redirect user to login if not logged in
   header("Location: ../login.php");
   exit();
} 

require_once 'includes/user_model.inc.php';

$user_id = $_SESSION['user_id'];

$totalAppointment = isValidRegularPatient($conn, $user_id);

if($totalAppointment >= 5){
  $query = "UPDATE users SET label = 'regular' WHERE user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s",$user_id);
  $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../assets/images/logoipsum.svg" type="image/x-icon" />
    <title>Homepage | Smile Hero Clinic</title>
    <link rel="stylesheet" href="../src/dist/styles.css" />
  </head>
  <body class="user-homepage">
    <main>
      <!-- user navigation -->
      <nav class="navbar__user" aria-label="Main Navigation">
        <!-- logo -->
        <div class="navbar__user-logo">
          <a href="#" aria-label="Smile Hero Clinic Homepage">
            <svg
              width="40"
              height="40"
              viewBox="0 0 40 40"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              role="img"
              aria-labelledby="logoTitle"
            >
              <title id="logoTitle">Smile Hero Clinic Logo</title>
              <path
                class="logo__icon"
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M10 0C15.5228 0 20 4.47715 20 10V0H30C35.5228 0 40 4.47715 40 10C40 15.5228 35.5228 20 30 20C35.5228 20 40 24.4772 40 30C40 32.7423 38.8961 35.2268 37.1085 37.0334L37.0711 37.0711L37.0379 37.1041C35.2309 38.8943 32.7446 40 30 40C27.2741 40 24.8029 38.9093 22.999 37.1405C22.9756 37.1175 22.9522 37.0943 22.9289 37.0711C22.907 37.0492 22.8852 37.0272 22.8635 37.0051C21.0924 35.2009 20 32.728 20 30C20 35.5228 15.5228 40 10 40C4.47715 40 0 35.5228 0 30V20H10C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0ZM18 10C18 14.4183 14.4183 18 10 18V2C14.4183 2 18 5.58172 18 10ZM38 30C38 25.5817 34.4183 22 30 22C25.5817 22 22 25.5817 22 30H38ZM2 22V30C2 34.4183 5.58172 38 10 38C14.4183 38 18 34.4183 18 30V22H2ZM22 18V2L30 2C34.4183 2 38 5.58172 38 10C38 14.4183 34.4183 18 30 18H22Z"
                fill="#1d72f2"
              ></path>
            </svg>
          </a>
        </div>
        <!-- end of logo -->

        <div class="navbar__user-menu" role="menu">
          <button
            type="button"
            class="menu__button"
            id="logoutBtn"
            role="menuitem"
          >
            <a href="../includes/logout.php">Logout</a>
          </button>
          <button
            type="button"
            class="menu__button"
            role="menuitem"
            id="accountBtn"
          >
            <a href="profile.php"
              >Account
              <img
                src="../assets/icons/user_account/arrow-up-small.svg"
                alt="Arrow icon"
              />
            </a>
          </button>
        </div>
      </nav>
      <!-- end of user navigation -->

      <!-- hero -->
      <header class="hero">
        <h1>Welcome to Smile Hero <span class="circle-span">Clinic</span></h1>
        <section class="hero__details" aria-labelledby="clinicInfo">
          <ul class="contact__info" aria-label="Clinic Contact Information">
            <li>
              Ground Floor Amber Place, #67 Bayani Road, Western Bicutan, Fort
              Bonifacio, Taguig, Philippines
            </li>
            <li>Monday to Sunday</li>
            <li>0917 160 6212</li>
          </ul>
          <p class="current__date">Loading...</p>
        </section>
      </header>
      <!-- end of hero -->

      <!-- about -->
      <section class="about" aria-labelledby="aboutTitle">
        <div class="about__intro">
          <h2 id="aboutTitle">
            Your Trusted Partner for Comprehensive Dental Care
          </h2>
          <p class="sub-header">
            We make booking easy with our web-based appointment system. Schedule
            your dental visits quickly from anywhere—home, work, or on the go.
          </p>
        </div>

        <article class="services" aria-labelledby="servicesTitle">
          <h3 id="servicesTitle">Our Services</h3>
          <ul class="services__list" aria-label="List of Dental Services">
            <li>
              <img
                src="../assets/icons/user_account/check-icon.svg"
                alt="Check icon"
              />
              Routine dental check-ups and cleanings
            </li>
            <li>
              <img
                src="../assets/icons/user_account/check-icon.svg"
                alt="Check icon"
              />
              Cosmetic dentistry, such as teeth whitening and veneers
            </li>
            <li>
              <img
                src="../assets/icons/user_account/check-icon.svg"
                alt="Check icon"
              />
              Orthodontic treatments, including braces and Invisalign
            </li>
            <li>
              <img
                src="../assets/icons/user_account/check-icon.svg"
                alt="Check icon"
              />
              Restorative procedures like fillings, crowns, and bridges
            </li>
            <li>
              <img
                src="../assets/icons/user_account/check-icon.svg"
                alt="Check icon"
              />
              Emergency dental services
            </li>
          </ul>
          <a class="appointment__button" href="appointment_form_page.php" role="button">
            Book Your Appointment
            <img
              src="../assets/icons/user_account/arrow-up-large.svg"
              alt="Arrow icon"
            />
          </a>
        </article>
      </section>
      <!-- end of about -->
    </main>

    <script>
      function getDate() {
        let currentDate = document.querySelector('.current__date')
        let date = new Date()

        const days = [
          'Sunday',
          'Monday',
          'Tuesday',
          'Wednesday',
          'Thursday',
          'Friday',
          'Saturday',
        ]
        let day = days[date.getDay()]
        let hours = date.getHours()
        let minutes = date.getMinutes()

        let ampm = hours >= 12 ? 'pm' : 'am'
        hours = hours % 12 || 12

        const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes

        currentDate.innerText = `Today is ${day} ${hours}:${formattedMinutes}${ampm}`
      }

      setInterval(getDate, 1000)
    </script>
  </body>
</html>
