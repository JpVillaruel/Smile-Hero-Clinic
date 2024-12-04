<?php
require_once "includes/config_session.inc.php";
require_once "includes/signup_view.inc.php";

// unset($_SESSION["signup_data"]);

$showModal = false;
if (isset($_SESSION['signup_process'])) {
    if ($_SESSION['signup_process'] === 'created') {
        $showModal = true;

        // Clear session data after successful signup
        unset($_SESSION['signup_data']);  // Clear the form data session
    }
    unset($_SESSION['signup_process']);  // Clear the signup process session
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="./assets/images/logoipsum.svg" type="image/x-icon">
  <title>Signup an Account | Smile Hero Clinic</title>
  
  
  <!-- stylesheets -->
  <link rel="stylesheet" href="src/dist/styles.css" />
  <style>
  .error_container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    gap: 5px;
    width: 100%;
    z-index: -999;
  }

  .form_error {
    color: red;
    font-size: .75rem;
  }

  @keyframes shake {
    0%, 100% { transform: translateX(0); }
    20%, 60% { transform: translateX(-5px); }
    40%, 80% { transform: translateX(5px); }
  }

  .shake {
      animation: shake 0.3s ease;
  }

  </style>
</head>

<body class="homepage">
  <main class="signup__page">
    <!-- navigation bar -->
    <?php include('nav.php') ?>

    <!-- sign up form -->
    <section class="signup form_container">
      <!-- form -->
      <form action="includes/signup.inc.php" onsubmit="return validate()" method="post" class="signup__form error_handler">
        <h1 class="header">Create new account</h1>
        
        <div class="field-group-container">
          <div class="group-field">
            <div class="field">
                <input type="text" placeholder="e.g. Dela Cruz" id="fname" name="fname" value="<?php echo isset($_SESSION['signup_data']['fname']) ? $_SESSION['signup_data']['fname'] : ''; ?>" autofocus />
                <label for="fname">Firstname</label>
              </div>
              <div class="field">
                  <input type="text" placeholder="e.g. Juan" id="mname" name="mname" value="<?php echo isset($_SESSION['signup_data']['mname']) ? $_SESSION['signup_data']['mname'] : ''; ?>" autofocus />
                  <label for="mname">Middlename</label>
              </div>
          </div>

          <div class="group-field">
            <div class="field">
                <input type="text" placeholder="e.g. Victorio" id="lname" name="lname" value="<?php echo isset($_SESSION['signup_data']['lname']) ? $_SESSION['signup_data']['lname'] : ''; ?>" autofocus />
                <label for="lname">Lastname</label>
            </div>
            <div class="field">
                <input type="text" placeholder="e.g. Sr./ III" id="suff" name="suffix" value="<?php echo isset($_SESSION['signup_data']['suffix']) ? $_SESSION['signup_data']['suffix'] : ''; ?>" autofocus />
                <label for="suff">Suffix</label>
            </div>
          </div>

          <div class="group-field">
            <div class="field">
                <input type="email" placeholder="e.g. juandelacruz@gmail.com" id="email" name="email" value="<?php echo isset($_SESSION['signup_data']['email']) ? $_SESSION['signup_data']['email'] : ''; ?>" />
                <label for="email">Email</label>
            </div>
            <div class="field">
                <input type="tel" onkeypress="isNumber(event)" placeholder="e.g. 09000000000" id="contact" name="contact" value="<?php echo isset($_SESSION['signup_data']['contact']) ? $_SESSION['signup_data']['contact'] : ''; ?>" />
                <label for="contact">Contact Number</label>
            </div>
          </div>

          <div class="group-field">
            <div class="field">
                <input type="password" placeholder="" id="password" onkeypress="return event.charCode != 32" name="password" />
                <label for="password">Password</label>
            </div>

            <div class="field">
              <input type="password" placeholder="" id="Cpassword" onkeypress="return event.charCode != 32" name="Cpassword" />
              <label for="Cpassword">Confirm Password</label>
            </div> 
          </div>
          
          <div class="error_container">
          <!-- //class name of text is form_error -->
              <?php checkSignupErrors() ;?>
              <p id="error_msg" class="form_error">
                <!-- Password must be at least 8 characters long, include one uppercase letter, one lowercase letter, one digit, and one special character. e.g !@#$%^&* -->
              </p>

          </div>

        </div>

        <div class="terms-and-conditions-container">
          <input type="checkbox" name="tnc" id="tnc" class="terms-and-conditions">
          <div class="group">
            <label for="tnc">I agree with the</label>
            <p class="tnc-button" id="tncBtn">Terms and Conditions</p>
          </div>

          <div class="tnc-text-container">
            <div class="contents">
              <button><img src="././assets/landing-page/close-circle.svg" alt="" class="close-tnc" id="closeTNC"></button>
              <div class="texts">
                <p class="tnc-header">Terms and Conditions</p>

                <div class="paragraphs">
                  <div class="group-text">
                    <p class="heading">Introduction</p>
                    <p class="desc">
                      Smile Hero Dental Clinic, We collect and use personal data to provide you
                      with quality dental care. By using our services, you agree to the
                      collection and use of your information as described here.
                    </p>
                  </div>

                  <div class="group-text">
                    <p class="heading">Data Collection</p>
                    <p class="desc">
                      We collect necessary personal details such as your name, contact
                      information, medical history, and insurance details to ensure proper
                      treatment, billing, and communication.
                    </p>
                  </div>

                  <div class="group-text">
                    <p class="heading">Data Use and Security</p>
                    <p class="desc">
                      Your information is used solely for dental care, appointment scheduling,
                      billing, and insurance purposes. We safeguard your data through
                      encryption, secure storage, and restricted access to authorized personnel
                      only.
                    </p>
                  </div>

                  <div class="group-text">
                    <p class="heading">Data Privacy Law</p>
                    <p class="desc">
                      According to Republic Act 10173, or Data Privacy Law 2012. Section 8.
                      Confidentiality. – The Commission shall ensure at all times the
                      confidentiality of any personal information that comes to its knowledge
                      and possession.
                    </p>
                  </div>

                  <div class="group-text">
                    <p class="heading">Sharing of Information</p>
                    <p class="desc">
                      Your data will only be shared with relevant medical professionals, your
                      insurance provider, or as required by law. We do not sell or rent your
                      personal information.
                    </p>
                  </div>

                  <div class="group-text">
                    <p class="heading">Your Rights</p>
                    <p class="desc">
                      You have the right to access, correct, or request the deletion of your
                      personal information.
                    </p>
                  </div>

                  <div class="group-text">
                    <p class="heading">Changes and Contact</p>
                    <p class="desc">
                      We may update these terms as needed. For any concerns, please contact us
                      at <a href="mailto:smilehero@gmail.com">smilehero@gmail.com</a>, or
                      09123456789.
                    </p>
                  </div>

                  <div class="group-text">
                    <p class="desc">
                      By using our services, you acknowledge and accept these terms.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-links">
          <button type="submit" class="submit__button">Signup</button>
          <a href="login.php" rel="noopener noreferrer" class="login__link">Already have an account? Login</a>
        </div>
      </form>

      <div class="image-container">
        <img src="././assets/landing-page/form-bg.jpg" alt="dental clinic room">
      </div>

      <!-- modal -->
      <div class="modal" style="display: none">
       <div class="modal__content">
         <div class="body-text">
           <div class="modal__header">
             <h3 id="modalStatus" class="modal__status">
               You have <br> successfully <br> registered
             </h3>
             <p id="modalMessage" class="modal__message" style="color: red;"> 
                 We Sent an Email to Activate your account.
             </p>
           </div>
           <a href="https://mail.google.com/mail/u/0/" target="_blank" id="exitButton" class="modal__button" style="text-align: center;">
               GO TO EMAIL
           </a>
         </div>
         <div class="illustration__container">
           <svg width="369" height="369" viewBox="0 0 369 369" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_693_4184)">
            <g filter="url(#filter0_f_693_4184)">
            <circle cx="200.5" cy="404.5" r="67.5" fill="#1D72F2"/>
            </g>
            <g filter="url(#filter1_f_693_4184)">
            <circle cx="394.034" cy="109.527" r="67.5" fill="#1D72F2"/>
            </g>
            <path d="M487.9 321.341H221.185C220.363 321.34 219.575 321.013 218.994 320.43C218.413 319.848 218.086 319.059 218.085 318.236V70.1055C218.086 69.2822 218.413 68.4929 218.994 67.9108C219.575 67.3286 220.363 67.0011 221.185 67H487.9C488.722 67.0011 489.51 67.3286 490.091 67.9108C490.672 68.4929 490.999 69.2822 491 70.1055V318.235C490.999 319.058 490.672 319.848 490.091 320.43C489.51 321.012 488.722 321.34 487.9 321.341ZM221.185 68.2398C220.692 68.2408 220.22 68.4373 219.872 68.7862C219.523 69.1351 219.327 69.608 219.326 70.1014V318.235C219.327 318.729 219.523 319.201 219.872 319.55C220.22 319.899 220.692 320.096 221.185 320.097H487.9C488.393 320.096 488.865 319.899 489.213 319.55C489.561 319.202 489.757 318.729 489.758 318.235V70.1055C489.757 69.6121 489.561 69.1392 489.213 68.7903C488.865 68.4414 488.393 68.2449 487.9 68.2438L221.185 68.2398Z" fill="#616161"/>
            <path d="M347.212 131.478C346.654 131.478 346.119 131.7 345.724 132.095C345.33 132.49 345.108 133.027 345.108 133.586C345.108 134.145 345.33 134.681 345.724 135.077C346.119 135.472 346.654 135.694 347.212 135.694H462.696C463.255 135.694 463.79 135.472 464.185 135.077C464.579 134.681 464.801 134.145 464.801 133.586C464.801 133.027 464.579 132.49 464.185 132.095C463.79 131.7 463.255 131.478 462.696 131.478H347.212Z" fill="#616161"/>
            <path d="M347.212 144.129C346.654 144.129 346.119 144.351 345.724 144.746C345.33 145.142 345.108 145.678 345.108 146.237C345.108 146.796 345.33 147.332 345.724 147.728C346.119 148.123 346.654 148.345 347.212 148.345H406.169C406.728 148.345 407.263 148.123 407.658 147.728C408.052 147.332 408.274 146.796 408.274 146.237C408.274 145.678 408.052 145.142 407.658 144.746C407.263 144.351 406.728 144.129 406.169 144.129H347.212Z" fill="#616161"/>
            <path d="M246.276 205.362C245.718 205.362 245.182 205.584 244.788 205.98C244.393 206.375 244.171 206.911 244.171 207.471C244.171 208.03 244.393 208.566 244.788 208.961C245.182 209.357 245.718 209.579 246.276 209.579H462.809C463.367 209.579 463.902 209.357 464.297 208.961C464.692 208.566 464.913 208.03 464.913 207.471C464.913 206.911 464.692 206.375 464.297 205.98C463.902 205.584 463.367 205.362 462.809 205.362H246.276Z" fill="#616161"/>
            <path d="M246.276 218.014C245.718 218.014 245.182 218.236 244.788 218.631C244.393 219.027 244.171 219.563 244.171 220.122C244.171 220.681 244.393 221.217 244.788 221.613C245.182 222.008 245.718 222.23 246.276 222.23H406.282C406.84 222.23 407.375 222.008 407.77 221.613C408.165 221.217 408.386 220.681 408.386 220.122C408.386 219.563 408.165 219.027 407.77 218.631C407.375 218.236 406.84 218.014 406.282 218.014H246.276Z" fill="#616161"/>
            <path d="M246.276 230.379C245.718 230.379 245.182 230.601 244.788 230.996C244.393 231.392 244.171 231.928 244.171 232.487C244.171 233.046 244.393 233.582 244.788 233.978C245.182 234.373 245.718 234.595 246.276 234.595H462.809C463.367 234.595 463.902 234.373 464.297 233.978C464.692 233.582 464.913 233.046 464.913 232.487C464.913 231.928 464.692 231.392 464.297 230.996C463.902 230.601 463.367 230.379 462.809 230.379H246.276Z" fill="#616161"/>
            <path d="M246.276 243.03C245.718 243.03 245.182 243.252 244.788 243.647C244.393 244.043 244.171 244.579 244.171 245.138C244.171 245.697 244.393 246.234 244.788 246.629C245.182 247.024 245.718 247.246 246.276 247.246H406.282C406.84 247.246 407.375 247.024 407.77 246.629C408.165 246.234 408.386 245.697 408.386 245.138C408.386 244.579 408.165 244.043 407.77 243.647C407.375 243.252 406.84 243.03 406.282 243.03H246.276Z" fill="#616161"/>
            <path d="M318.027 175.898H150.618C149.796 175.897 149.008 175.57 148.427 174.987C147.845 174.405 147.519 173.616 147.518 172.793V99.1944C147.519 98.371 147.845 97.5817 148.427 96.9995C149.008 96.4173 149.796 96.0898 150.618 96.0889H318.027C318.849 96.0898 319.637 96.4173 320.218 96.9995C320.799 97.5817 321.126 98.371 321.127 99.1944V172.793C321.126 173.616 320.799 174.405 320.218 174.987C319.637 175.57 318.849 175.897 318.027 175.898Z" fill="#E84531"/>
            <path d="M85.4263 191.563C82.6917 189.518 81.8891 185.696 83.6338 183.027C83.8071 182.766 84.0031 182.52 84.2196 182.293L84.3944 127.921L92.4622 129.43L92.8167 182.906C94.6547 185.042 95.0259 188.155 93.5371 190.433C91.7924 193.102 88.1611 193.608 85.4263 191.563Z" fill="#FFB8B8"/>
            <path d="M127.383 313.265L135.701 313.264L139.658 281.126L127.382 281.126L127.383 313.265Z" fill="#FFB8B8"/>
            <path d="M125.262 310.544L141.642 310.543H141.643C144.411 310.544 147.066 311.645 149.024 313.606C150.981 315.567 152.081 318.227 152.081 321V321.34L125.262 321.341L125.262 310.544Z" fill="#616161"/>
            <path d="M50.0421 313.265L58.36 313.264L62.3166 281.126L50.0409 281.126L50.0421 313.265Z" fill="#FFB8B8"/>
            <path d="M47.9207 310.544L64.3008 310.543H64.3014C67.0698 310.544 69.7248 311.645 71.6824 313.606C73.64 315.567 74.7399 318.227 74.7401 321V321.34L47.9212 321.341L47.9207 310.544Z" fill="#616161"/>
            <path d="M126.898 304.288L126.201 300.098C125.485 299.847 124.876 299.357 124.477 298.711C123.728 297.527 123.609 295.859 124.122 293.754L118.51 246.278L89.2114 215.825L70.4156 261.241L62.975 297.18V302.372L48.1193 304.283L48.7953 299.389C48.227 299.145 47.7535 298.722 47.4464 298.185C46.5928 296.762 46.6045 294.556 47.481 291.629L47.519 291.502L47.4705 291.065C47.4364 290.759 47.6598 261.404 56.3709 246.859L65.0952 202.702C64.8687 202.08 63.7502 198.459 65.8015 192.341C67.826 186.303 73.488 176.576 88.9652 164.525L89.0184 164.484L89.0843 164.47C89.2557 164.435 106.326 161.035 115.154 172.6L115.214 172.678V172.777C115.214 173.492 115.199 190.131 113.886 193.823L134.835 232.411C135.242 232.844 138.905 237.081 137.604 248.22L140.988 286.191C141.375 286.932 144.878 293.906 141.018 296.667L141.71 301.461L126.898 304.288Z" fill="#616161"/>
            <path d="M91.8525 144.725C87.919 144.725 82.6918 143.332 79.492 136.912L79.4291 136.786L87.3121 120.046C88.3333 117.877 90.1614 116.195 92.405 115.359C94.6486 114.524 97.1296 114.601 99.3173 115.574C101.505 116.548 103.225 118.34 104.111 120.568C104.996 122.796 104.975 125.282 104.054 127.496L97.2385 143.863L97.1199 143.907C95.4178 144.454 93.6402 144.73 91.8525 144.725Z" fill="#E84531"/>
            <path d="M113.689 177.914L88.8375 166.158L92.2535 124.409L98.4811 116.784L99.6876 116.525C105.232 115.336 110.993 115.656 116.372 117.451L116.491 117.49L126.72 139.351C126.784 139.46 134.161 152.508 123.963 159.387L113.689 177.914Z" fill="#E84531"/>
            <path d="M147.853 164.609C147.557 164.733 147.27 164.88 146.997 165.048L120.81 153.049L120.138 146.073L109.496 145.712L109.488 158.177C109.487 159.184 109.812 160.165 110.415 160.97C111.018 161.776 111.865 162.365 112.83 162.647L144.276 171.854C144.599 173.051 145.278 174.121 146.223 174.922C147.168 175.723 148.334 176.217 149.566 176.338C150.798 176.458 152.037 176.201 153.119 175.599C154.201 174.997 155.075 174.079 155.623 172.968C156.172 171.856 156.37 170.604 156.191 169.377C156.012 168.15 155.464 167.007 154.621 166.099C153.777 165.192 152.678 164.563 151.469 164.297C150.26 164.031 148.999 164.139 147.853 164.609Z" fill="#FFB8B8"/>
            <path d="M115.822 149.05C112.838 149.05 109.47 148.016 106.238 144.778L106.138 144.678L108.323 126.299C108.605 123.918 109.807 121.742 111.671 120.237C113.535 118.733 115.913 118.018 118.296 118.248C120.678 118.477 122.877 119.631 124.421 121.463C125.965 123.296 126.732 125.661 126.558 128.052L125.268 145.739L125.17 145.818C125.106 145.869 121.055 149.05 115.822 149.05Z" fill="#E84531"/>
            <path d="M123.807 102.24C128.222 94.151 125.254 84.0086 117.179 79.5866C109.104 75.1646 98.9796 78.1376 94.5654 86.2268C90.1513 94.3161 93.1189 104.459 101.194 108.881C109.269 113.303 119.393 110.33 123.807 102.24Z" fill="#FFB8B8"/>
            <path d="M126.145 85.3892C125.318 80.5716 121.458 76.5779 116.859 74.9438C112.26 73.3097 107.074 73.8412 102.57 75.7229C101.82 76.0377 101.087 76.3909 100.373 76.7812C98.7269 73.6379 94.6912 71.8149 91 72.0117C86.5407 72.2494 82.5135 74.6131 78.6406 76.8408C74.7676 79.0685 70.6117 81.2849 66.147 81.1812C58.0787 80.9938 52.0762 73.5004 44.3178 71.2734C40.8641 70.2821 37.1892 70.3824 33.7944 71.5606C30.3997 72.7388 27.4505 74.9375 25.3492 77.8568C23.2479 80.7761 22.0969 84.2737 22.0532 87.8725C22.0094 91.4713 23.0751 94.996 25.1049 97.9656C28.4152 92.0228 36.1891 90.0155 42.9346 90.8246C49.6798 91.6336 55.9664 94.5956 62.5746 96.1733C69.1831 97.751 76.8365 97.6833 81.9551 93.209C84.8589 90.6711 86.5636 87.0437 89.0913 84.1301C90.8012 82.1594 93.2354 80.4953 95.7225 80.1036C93.2727 82.3137 91.4025 85.0928 90.2761 88.1967C88.2818 93.8729 89.348 100.688 93.4852 105.051C97.9204 109.729 104.882 110.975 111.321 110.9L111.456 110.763C109.484 107.806 107.928 103.707 110.099 100.894C112.242 98.1171 116.468 98.5262 119.75 97.2976C124.321 95.5863 126.972 90.2068 126.145 85.3892Z" fill="#616161"/>
            <path d="M226.81 121.902C226.083 121.904 225.495 122.85 225.497 124.014C225.498 125.176 226.085 126.116 226.81 126.119H288.874C289.601 126.116 290.189 125.17 290.188 124.006C290.186 122.845 289.599 121.904 288.874 121.902H226.81Z" fill="white"/>
            <path d="M226.81 134.119C226.083 134.121 225.495 135.067 225.497 136.231C225.498 137.393 226.085 138.333 226.81 138.336H288.874C289.601 138.333 290.189 137.387 290.188 136.223C290.186 135.062 289.599 134.121 288.874 134.119H226.81Z" fill="white"/>
            <path d="M226.81 146.188C226.083 146.191 225.495 147.137 225.497 148.301C225.498 149.462 226.085 150.403 226.81 150.405H253.516C254.243 150.403 254.832 149.457 254.83 148.293C254.829 147.131 254.241 146.191 253.516 146.188H226.81Z" fill="white"/>
            <path d="M195.298 152.865C204.599 152.865 212.14 145.311 212.14 135.993C212.14 126.676 204.599 119.122 195.298 119.122C185.997 119.122 178.457 126.676 178.457 135.993C178.457 145.311 185.997 152.865 195.298 152.865Z" fill="white"/>
            </g>
            <defs>
            <filter id="filter0_f_693_4184" x="33" y="237" width="335" height="335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
            <feGaussianBlur stdDeviation="50" result="effect1_foregroundBlur_693_4184"/>
            </filter>
            <filter id="filter1_f_693_4184" x="226.534" y="-57.9727" width="335" height="335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
            <feGaussianBlur stdDeviation="50" result="effect1_foregroundBlur_693_4184"/>
            </filter>
            <clipPath id="clip0_693_4184">
            <rect width="369" height="369" fill="white"/>
            </clipPath>
            </defs>
          </svg>
         </div>
       </div>
      </div>
    </section>
  </main>

  <?php include("footer.php"); ?>
</body>

  <script src="././js/nav.js"></script>
  <script>
     document.addEventListener('DOMContentLoaded', () => {
    const modalContainer = document.querySelector(".modal");
    const exitBtn = modalContainer.querySelector("#exitButton");

    <?php if ($showModal) : ?>
      modalContainer.style.display = "flex";
    <?php endif; ?>

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

  function validate(){

    var fname = document.getElementById("fname"); 
    var mname = document.getElementById("mname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email");
    var contact = document.getElementById("contact");
    var password = document.getElementById("password");
    var Cpassword = document.getElementById("Cpassword");
    var tnc = document.getElementById("tnc");
    var tncGroup = document.querySelector(".group");

    
    notValid = false;

    var passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

    var error_msg =  document.getElementById("error_msg");
    var form_error =  document.getElementById("form_error");

    if (fname.value == "" || mname.value == "" || lname.value == "" || email.value == "" || contact.value == "" || password.value == "" || Cpassword.value == "") {
        error_msg.innerHTML = "Please fill up the form";
        error_msg.style.display = "flex";

        setTimeout(() => {
          error_msg.style.display = "none";
            }, 2000);

        return false; // prevent form submission
    } else if (contact.value.length != 11) {
        error_msg.innerHTML = "Invalid Contact Number";
        error_msg.style.display = "flex";

        setTimeout(() => {
            error_msg.style.display = "none";
        }, 2000);

        return false;
    }
    else if (password.value !== Cpassword.value) {
        error_msg.innerHTML = "Passwords do not match";
        error_msg.style.display = "flex";

        setTimeout(() => {
          error_msg.style.display = "none";
            }, 2000);

        return false; // prevent form submission
    } else if (!passwordRegex.test(password.value)) {
        error_msg.innerHTML = "Password must be at least 8 characters long, include one uppercase letter, one lowercase letter, one digit, and one special character. e.g !@#$%^&*";
        error_msg.style.display = "flex";
        error_msg.style.width = "50%";

        setTimeout(() => {
          error_msg.style.display = "none";
          error_msg.style.width = "fit-content";
            }, 4000);

        return false; // prevent form submission
    }  else if (!tnc.checked) {
        tncGroup.classList.add("shake"); // Add the shake class to the group
        setTimeout(() => {
            tncGroup.classList.remove("shake"); // Remove the shake class after animation
        }, 300);
        return false; // prevent form submission
    }

    return true; // allow form submission if all checks pass
    }

      // terms and conditons
      const tncContainer = document.querySelector('.tnc-text-container')
      const tncCloseBtn = document.getElementById('closeTNC')
      const tncOpenBtn = document.getElementById('tncBtn')

      tncOpenBtn.addEventListener('click', e => {
        tncContainer.style.display = 'flex'
      })

      tncCloseBtn.addEventListener('click', e => {
        tncContainer.style.display = 'none'
      })
  </script>
</body>

</html>