<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';

if(!isset($_SESSION['user_id'])) {
  // Redirect user to login if not logged in
  header("Location: ../login.php");
  exit();
}

$showModal = false;
if (isset($_SESSION['feedback_proccess'])) {
    if ($_SESSION['feedback_proccess'] === 'created') {
        $showModal = true;
    }
    unset($_SESSION['feedback_proccess']);  // Clear the signup process session
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/images/logoipsum.svg" type="image/x-icon" />
  <title>Feedback Form | Smile Hero Clinic</title>
  
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

      <!--  -->
      <div class="feedback__page account__container">
        <h1 class="header">We’d love to hear your feedback</h1>

        <form action="includes/send_feedback.php" method="post" class="form">
          <div class="form__rating">
            <h2>How would you rate our service?</h2>

            <div class="rating-container">
              <div class="radio-field">
                <input type="radio" name="rating" id="terrible" value="1">
                <label for="terrible">😡 <span>Terrible</span></label>
              </div>

              <div class="radio-field">
                <input type="radio" name="rating" id="bad" value="2">
                <label for="bad">😟 <span>Bad</span></label>
              </div>

              <div class="radio-field">
                <input type="radio" name="rating" id="okay" value="3"> 
                <label for="okay">😐 <span>Okay</span></label>
              </div>

              <div class="radio-field">
                <input type="radio" name="rating" id="good" value="4">
                <label for="good">🙂 <span>Good</span></label>
              </div>

              <div class="radio-field">
                <input type="radio" name="rating" id="awesome" value="5">
                <label for="awesome">😁 <span>Awesome</span></label>
              </div>
            </div>
          </div>

          <textarea class="feedback-message" name="feedback" id="feedback" placeholder="Write your feedback here..." rows="3"></textarea>

          <input type="submit" name="submit" value="Submit" class="feedback__submit-btn" id="submitBtn">
        </form>
      </div>

      <!-- modal -->
      <div class="feedback-modal" style="display: none">
        <div class="modal__content">
          <div class="body-text">
            <div class="modal__header">
              <h3 id="modalStatus" class="modal__status">
                Thank you for your feedback!
              </h3>
              <p id="modalMessage" class="modal__message">
                Your feedback helps us improve and serve you better!
              </p>
            </div>
            <button type="button" id="exitButton" class="modal__button">
              okay, got it!
            </button>
          </div>
          <div class="illustration__container f-c">
            <img src="../assets/feedback.svg" alt="feedback illustration">
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
<script>
  const feedbackMsg = document.getElementById('feedback')

  const adjustHeight = () => {
    feedbackMsg.style.height = 'auto'
    feedbackMsg.style.height = `${feedbackMsg.scrollHeight}px`
  }

  feedbackMsg.addEventListener('input', adjustHeight)

  adjustHeight()

  document.addEventListener('DOMContentLoaded', () => {
    const modalContainer = document.querySelector(".feedback-modal");
    const submitBtn = document.getElementById('submitBtn');
    const exitBtn = modalContainer.querySelector("#exitButton");
    const feedbackMsg = document.getElementById('feedback');
    const form = document.querySelector(".form");

    form.addEventListener('submit', (e) => {  
      const rating = form.querySelector('input[name="rating"]:checked');
      const feedback = feedbackMsg.value.trim();

      if (!rating || feedback === "") {
        e.preventDefault(); 
        alert("Please select a rating and provide feedback.");
      } 
    });

    <?php if ($showModal) : ?>
      modalContainer.style.display = "flex";
    <?php endif; ?>
    
    exitBtn.addEventListener("click", () => {
      modalContainer.style.display = "none"; 
    });
  });
</script>
</html>