<?php
require_once "includes/config_session.inc.php";

$showModal = false;
if (isset($_SESSION['email_process'])) {
    if ($_SESSION['email_process'] === 'sent') {
        $showModal = true;
    }
    unset($_SESSION['email_process']);  // Clear the signup process session
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="./assets/images/logoipsum.svg"
      type="image/x-icon"
    />
    <title>Forgot Password | Smile Hero Clinic</title>
    <!-- stylesheets -->
    <link rel="stylesheet" href="src/dist/styles.css" />
   </head>
  <body>
    <main class="form-modal f-c">
      <form method="post" action="includes/send_password_reset.php" class="forgot-pass-form f-c">
        <p class="form-header">
          Enter your email below, and we’ll send you a reset link
        </p>
        <div class="field f-c">
          <label for="email">Email</label>
          <input
            type="email"
            name="email"
            id="email"
            placeholder="Your email here"
            required
          />
          <button type="submit">Send Reset Link</button>
        </div>
        <p class="form-note">
          If you don't receive the email within a few minutes, check your spam
          folder or try again.
        </p>
      </form>

      <!-- modal -->
      <div class="forgot-pass-modal" style="display: none">
       <div class="modal__content">
         <div class="body-text">
           <div class="modal__header">
             <h3 id="modalStatus" class="modal__status">
               Reset link is <br> sent to your <br> email
             </h3>
             <p id="modalMessage" class="modal__message" style="color: #616161;"> 
                Please check your email inbox, if you didn't receive, please try resetting your password again
             </p>
           </div>
           <a href="https://mail.google.com/mail/u/0/" target="_blank" id="exitButton" class="modal__button" style="text-align: center;">
               OPEN YOUR EMAIL
           </a>
         </div>
         <div class="illustration__container" style="display: flex;  align-items: flex-end;">
          <img src="assets/email-sent.svg" alt="">
        </div>
       </div>
      </div>
    </main>
  </body>

  <script>
      document.addEventListener('DOMContentLoaded', () => {
        const modalContainer = document.querySelector(".forgot-pass-modal");
        const exitBtn = modalContainer.querySelector("#exitButton");

        <?php if ($showModal) : ?>
          modalContainer.style.display = "flex";
        <?php endif; ?>

        if(exitBtn) {
          exitBtn.addEventListener("click", () => {
            modalContainer.style.transform = "scale(0)";
            window.close()
          });
        }
      });

  </script>
</html>
