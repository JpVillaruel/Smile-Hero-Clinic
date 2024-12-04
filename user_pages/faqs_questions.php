<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';

if(!isset($_SESSION['user_id'])) {
  // Redirect user to login if not logged in
  header("Location: ../login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/images/logoipsum.svg" type="image/x-icon">
  <title>FAQs & Questions | Smile Hero Clinic</title>
  
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

      <div class="faqs-and-questions__page account__container">
        <h1 class="header">FAQs & QUESTIONS</h1>

        <div class="accordion">
          <details>
            <summary>How do I schedule an appointment? <img src="../assets/icons/user_account/up-angle.png" alt="up-angle-icon" class="arrow-angle"></summary>
            <div class="content">
              To schedule an appointment, you can call our clinic directly or use the <strong>online booking system</strong> available on
              our website. Simply choose your preferred date and time, and <strong>we'll confirm your appointment via
              email.</strong>
            </div>
          </details>

          <details>
            <summary>Can I cancel or reschedule my appointment online? <img src="../assets/icons/user_account/up-angle.png" alt="up-angle-icon" class="arrow-angle"></summary>
            <div class="content">
              Yes, you can cancel or reschedule your appointment online by logging into your Smile Hero Dental Clinic
              account. Go to the <strong>Appointments section</strong>, find the appointment you want to change, and
              follow the instructions to cancel or reschedule.
            </div>
          </details>

          <details>
            <summary>What should I do if I have a dental emergency? <img src="../assets/icons/user_account/up-angle.png" alt="up-angle-icon" class="arrow-angle"></summary>
            <div class="content">
              If you have a dental emergency, <strong>please contact our clinic immediately</strong>. We offer
              emergency dental services and will do our best to accommodate you as soon as possible. For after-hours emergencies, please follow
              the instructions on our voicemail.
            </div>
          </details>

          <details>
            <summary>How can I update my contact information? <img src="../assets/icons/user_account/up-angle.png" alt="up-angle-icon" class="arrow-angle"></summary>
            <div class="content">
              You can update your contact information, and other personal information by logging in to your Smile Hero
              Dental Clinic account and accessing the <strong>Profile section</strong>. From there, you can edit your
              information as needed and save the changes.
            </div>
          </details>

          <details>
            <summary>Can I leave feedback or review my experience with Smile Hero Dental Clinic? <img src="../assets/icons/user_account/up-angle.png" alt="up-angle-icon" class="arrow-angle"></summary>
            <div class="content">
              We appreciate your feedback! You can leave a review of your experience by logging into your Smile Hero
              Dental Clinic account and navigating to the <strong>Feedback section</strong>. Your feedback helps us
              improve our services.
            </div>
          </details>

          <details>
            <summary>Can I view my upcoming and past appointments online? <img src="../assets/icons/user_account/up-angle.png" alt="up-angle-icon" class="arrow-angle"></summary>
            <div class="content">
              Yes, you can view your upcoming and past appointments by logging in to your Smile Hero Dental Clinic
              account and accessing the <strong>Appointments section</strong>. There, you'll find a list of all your scheduled
              appointments, including date, time, and any additional details.
            </div>
          </details>
        </div>
      </div>
    </section>
  </main>
</body>
<script>
  const accordions = document.querySelectorAll('details')

  accordions.forEach(acc => {  
    acc.addEventListener('toggle', function() {
      if(this.open) {
        accordions.forEach(otherAcc => {
          otherAcc.querySelector('img').src = '../assets/icons/user_account/down-angle.png'
          if(otherAcc !== this) {
            otherAcc.removeAttribute('open')
            otherAcc.querySelector('img').src = '../assets/icons/user_account/up-angle.png'
          }
        })
      } else acc.querySelector('img').src = '../assets/icons/user_account/up-angle.png'
    })
  })
</script>
</html>