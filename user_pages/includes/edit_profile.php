<?php
require_once '../../includes/config_session.inc.php';
require_once '../../includes/login_view.inc.php';
require_once '../../includes/dbh.inc.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
    $user_id = $_SESSION['user_id'];
    $currentEmail = $_SESSION['email'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and sanitize input
        $fname = ucwords(htmlspecialchars(trim($_POST['fname'])));
        $mname = ucwords(htmlspecialchars(trim($_POST['mname'])));
        $lname = ucwords(htmlspecialchars(trim($_POST['lname'])));
        $suffix = htmlspecialchars(trim($_POST['suffix']));
        $contact = htmlspecialchars(trim($_POST['contact']));
        $address = htmlspecialchars(trim($_POST['address']));
        $birthdate = htmlspecialchars(trim($_POST['bday']));
        $gender = htmlspecialchars(trim($_POST['gender']));
        $oldPass = $_POST['oPass'];
        $newPass = $_POST['nPass'];
        $confirmPass = $_POST['cPass'];

        require_once '../../includes/signup_model.inc.php';
        require_once '../../includes/signup_contr.inc.php';

        // Check if all required fields are filled
        if (!isInputEmpty($fname, $mname, $lname, $contact, $address, $birthdate, $gender)) {
            
                // Update user details in the database
                $query = "UPDATE users SET 
                          first_name = ?, middle_name = ?, last_name = ?, suffix = ?, 
                          birthdate = ?, gender = ?, contact = ?, address = ? 
                          WHERE user_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param(
                    "sssssssss", 
                    $fname, $mname, $lname, $suffix, 
                    $birthdate, $gender, $contact, $address, $user_id
                );
                $stmt->execute();

                // Check if password fields are provided for password update
                if (!empty($oldPass) && !empty($newPass) && !empty($confirmPass)) {

                  $passwordRegex ='/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/';

                  if(!preg_match($passwordRegex, $newPass)){
                    echo "<script>alert('Password must be at least 8 characters long, include one uppercase letter, one lowercase letter, one digit, and one special character. e.g !@#$%^&*');</script>";
                    echo "<script>window.location.href = 'edit_profile.php' </script>";
                    exit();
                  }
                  
                  $currPass = getUserPass($conn, $user_id);
                    
                    if ($currPass !== null && password_verify($oldPass, $currPass)) {
                        if ($newPass === $confirmPass) {
                            $hashed_password = password_hash($newPass, PASSWORD_DEFAULT);
                            $password_query = "UPDATE users SET pass = ? WHERE user_id = ?";
                            $password_stmt = $conn->prepare($password_query);
                            $password_stmt->bind_param("ss", $hashed_password, $user_id);
                            $password_stmt->execute();
                        } else {
                            echo "<script>alert('New passwords do not match');</script>";
                            echo "<script>window.location.href = 'edit_profile.php' </script>";
                            exit();
                        }
                    } else {
                        echo "<script>alert('Incorrect old password');</script>";
                        echo "<script>window.location.href = 'edit_profile.php' </script>";
                        exit();
                    }
                }

                $_SESSION['edit_process'] = "success";
                header("Location: edit_profile.php");
                exit();
        } else {
            echo "<script>alert('Please fill in all fields!');</script>";
            echo "<script>window.location.href = 'edit_profile.php' </script>";
        }
    }

    // Fetch user details to display in the form
    $user_query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($user_query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

} else {
    // Redirect to login page if not logged in
    header("Location: ../../login.php");
    exit();
}

// Handle success modal display
$current_page = basename($_SERVER['PHP_SELF']);

$showModal = false;
if (isset($_SESSION['edit_process'])) {
    if ($_SESSION['edit_process'] === 'success') {
        $showModal = true;
    }
    unset($_SESSION['edit_process']);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/images/logoipsum.svg" type="image/x-icon">
  <title>Edit account | Smile Hero Clinic</title>
  
  <link rel="stylesheet" href="../../src/dist/styles.css" />
  <script src="../js/mobile-nav.js" defer></script>
  <style>
  #loading-screen {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    font-size: 1.5rem;
    flex-direction: column;
  }

  .spinner {
    border: 8px solid rgba(255, 255, 255, 0.3);
    border-top: 8px solid #fff;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;
    margin-bottom: 20px;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }
  </style>

</head>

<body class="user__page">
  <main class="user__main">
    <div id="loading-screen" style="display: none;">
      <div class="spinner"></div>
      <p>Loading...</p>
    </div>

    <!-- navigation header bar -->
    <nav class="account__header user-header">
      <svg class="header__icon" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="44" height="44" rx="22" fill="#1D72F2" />
        <g clip-path="url(#clip0_246_1826)">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M16 10C19.3137 10 22 12.6863 22 16V10H28C31.3137 10 34 12.6863 34 16C34 19.3137 31.3137 22 28 22C31.3137 22 34 24.6863 34 28C34 29.6454 33.3377 31.1361 32.2651 32.22L32.2427 32.2427L32.2227 32.2625C31.1385 33.3366 29.6468 34 28 34C26.3645 34 24.8817 33.3456 23.7994 32.2843C23.7854 32.2705 23.7713 32.2566 23.7573 32.2427C23.7442 32.2295 23.7311 32.2163 23.7181 32.2031C22.6554 31.1205 22 29.6368 22 28C22 31.3137 19.3137 34 16 34C12.6863 34 10 31.3137 10 28V22H16C12.6863 22 10 19.3137 10 16C10 12.6863 12.6863 10 16 10ZM20.8 16C20.8 18.651 18.651 20.8 16 20.8V11.2C18.651 11.2 20.8 13.349 20.8 16ZM32.8 28C32.8 25.349 30.651 23.2 28 23.2C25.349 23.2 23.2 25.349 23.2 28H32.8ZM11.2 23.2V28C11.2 30.651 13.349 32.8 16 32.8C18.651 32.8 20.8 30.651 20.8 28V23.2H11.2ZM23.2 20.8V11.2H28C30.651 11.2 32.8 13.349 32.8 16C32.8 18.651 30.651 20.8 28 20.8H23.2Z" fill="white" />
        </g>
        <defs>
          <clipPath id="clip0_246_1826">
            <rect width="24" height="24" fill="white" transform="translate(10 10)" />
          </clipPath>
        </defs>
      </svg>

      <div class="header__content">
        <div class="header__date">
          Getting date and time...
        </div>
      </div>
    </nav>

    <section class="edit-profile">
      <!-- Header -->
      <form method="post" class="edit-profile__form">
        <div class="edit-profile__header">
          <h1 class="edit-profile__title">edit your profile details</h1>

          <div class="edit-profile__actions">
            <input type="submit" value="Save" class="edit-profile__save-btn" />
            <button class="edit-profile__cancel-btn" id="cancel-btn" type="button">
              <a href="../profile.php" class="edit-profile__cancel-link">Cancel</a>
            </button>
          </div>
        </div>
        <!-- End of Header -->

        <div class="edit-profile__details">
        <?php if($row = $result->fetch_assoc()) { ?>
          <div class="edit-profile__item">
            <p class="edit-profile__label">Firstname</p>
            <input type="text" name="fname" value="<?php echo htmlspecialchars($row["first_name"]); ?>"
              class="edit-profile__input" id="fname" style="width: 100%;">
          </div>
          <div class="edit-profile__item">
            <p class="edit-profile__label">Middlename</p>
            <input type="text" name="mname" value="<?php echo htmlspecialchars($row["middle_name"]); ?>"
              class="edit-profile__input" id="mname" style="width: 100%;">
          </div>
          <div class="edit-profile__item">
            <p class="edit-profile__label">Lastname</p>
            <input type="text" name="lname" value="<?php echo htmlspecialchars($row["last_name"]); ?>"
              class="edit-profile__input" id="lname" style="width: 100%;">
          </div>
          <?php if($row["suffix"] === ""){ ?>
            <div class="edit-profile__item" style="display: none;">
         <?php } else { ?>
          <div class="edit-profile__item"">
          <?php } ?>
            <p class="edit-profile__label">Suffix</p>
            <input type="text" name="suffix" value="<?php echo htmlspecialchars($row["suffix"]); ?>"
              class="edit-profile__input" id="suffix" style="width: 100%;">
          </div>
          <div class="edit-profile__item">
            <p class="edit-profile__label">Birthdate</p>
            <input type="date" placeholder="N/a" name="bday" value="<?php echo htmlspecialchars($row["birthdate"]); ?>"
              class="edit-profile__input" id="bday" style="width: 100%;">
          </div>
          <div class="edit-profile__item">
            <p class="edit-profile__label">Gender</p>
            <select name="gender" class="edit-profile__input" id="gender" style="width: 100%;">
                <option value="<?php echo ucfirst($row["gender"]) ?>">
                <?php if(strlen($row["gender"])===0) { ?>
                  N/a
                  <?php }else {
                    echo ucfirst($row["gender"]);
                  } ?>
                </option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
          </div>
          <div class="edit-profile__item">
            <p class="edit-profile__label">Contact Number</p>
            <input type="text" onkeypress="isNumber(event)" name="contact" value="<?php echo htmlspecialchars($row["contact"]); ?>"
              class="edit-profile__input" id="contactNumber" style="width: 100%;">
          </div>
          <div class="edit-profile__item">
            <p class="edit-profile__label">Address</p>
            <input type="text" name="address" value="<?php echo htmlspecialchars($row["address"]); ?>"
              placeholder="no address" class="edit-profile__input" id="address" style="width: 100%;">
          </div>
          <div class="edit-profile__item">
            <p class="edit-profile__label">Old Password</p>
            <input type="password" name="oPass" placeholder="********" class="edit-profile__input">
          </div>
          <div class="edit-profile__item">
            <p class="edit-profile__label">Enter New Password</p>
            <input type="password" name="nPass" placeholder="********" onkeypress="return event.charCode != 32" class="edit-profile__input">
          </div>
          <div class="edit-profile__item">
            <p class="edit-profile__label">Confirm New Password</p>
            <input type="password" name="cPass" placeholder="********" onkeypress="return event.charCode != 32" class="edit-profile__input">
          </div>
        <?php } ?>
        </div>
      </form>

      <!-- modal -->
      <div class="modal" style="display: none">
        <div class="modal__content">
          <div class="body-text">
            <div class="modal__header">
              <h3 id="modalStatus" class="modal__status">
                Your profile is <br> successfully <br> updated
              </h3>
              <p id="modalMessage" class="modal__message">
                <a href="../profile.php">
                  Go to profile
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.62 3.95337L13.6667 8.00004L9.62 12.0467" stroke="#E84531" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2.33333 8H13.5533" stroke="#E84531" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
              </p>
            </div>
            <button type="button" id="exitButton" class="modal__button">
              Okay, Got it!
            </button>
          </div>
          <div class="illustration__container">
            <svg width="369" height="369" viewBox="0 0 369 369" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_696_4399)">
            <g filter="url(#filter0_f_696_4399)">
            <circle cx="200.5" cy="404.5" r="67.5" fill="#1D72F2"/>
            </g>
            <g filter="url(#filter1_f_696_4399)">
            <circle cx="394.034" cy="109.527" r="67.5" fill="#E84531"/>
            </g>
            <g clip-path="url(#clip1_696_4399)">
            <path d="M241.17 276.088H33.3099V39H241.17V276.088Z" fill="white"/>
            <path d="M241.17 276.088H33.3099V39H241.17V276.088ZM36.3553 273.256H238.125V41.8316H36.3553V273.256Z" fill="#E6E6E6"/>
            <path d="M241.255 39H33.6604V69.3291H241.255V39Z" fill="#1D72F2"/>
            <path d="M63.4235 114.299C73.1848 114.299 81.0979 106.368 81.0979 96.5831C81.0979 86.7986 73.1848 78.8667 63.4235 78.8667C53.6622 78.8667 45.7491 86.7986 45.7491 96.5831C45.7491 106.368 53.6622 114.299 63.4235 114.299Z" fill="#E6E6E6"/>
            <path d="M155.85 84.0774H95.3066V89.2881H155.85V84.0774Z" fill="#E6E6E6"/>
            <path d="M228.731 96.583H95.3066V101.794H228.731V96.583Z" fill="#E6E6E6"/>
            <path d="M228.731 109.089H95.3066V114.299H228.731V109.089Z" fill="#E6E6E6"/>
            <path d="M63.4235 259.314C73.1848 259.314 81.0979 251.382 81.0979 241.598C81.0979 231.813 73.1848 223.881 63.4235 223.881C53.6622 223.881 45.7491 231.813 45.7491 241.598C45.7491 251.382 53.6622 259.314 63.4235 259.314Z" fill="#E6E6E6"/>
            <path d="M155.85 229.092H95.3066V234.303H155.85V229.092Z" fill="#E6E6E6"/>
            <path d="M228.731 241.598H95.3066V246.809H228.731V241.598Z" fill="#E6E6E6"/>
            <path d="M228.731 254.104H95.3066V259.314H228.731V254.104Z" fill="#E6E6E6"/>
            <path d="M66.3693 46.7495H40.031V50.5707H66.3693V46.7495Z" fill="white"/>
            <path d="M66.3693 53.3496H40.031V57.1708H66.3693V53.3496Z" fill="white"/>
            <path d="M66.3693 59.95H40.031V63.7711H66.3693V59.95Z" fill="white"/>
            <path d="M263.48 202.803H11V135.378H263.48V202.803Z" fill="white"/>
            <path d="M263.48 202.803H11V135.378H263.48V202.803ZM14.0454 199.75H260.435V138.43H14.0454V199.75Z" fill="#CCCCCC"/>
            <path d="M42.3315 186.509C51.9822 186.509 59.8057 178.667 59.8057 168.993C59.8057 159.319 51.9822 151.477 42.3315 151.477C32.6809 151.477 24.8574 159.319 24.8574 168.993C24.8574 178.667 32.6809 186.509 42.3315 186.509Z" fill="#E84531"/>
            <path d="M151.288 154.225H78.9929V159.377H151.288V154.225Z" fill="#3F3D56"/>
            <path d="M238.316 166.589H78.9929V171.741H238.316V166.589Z" fill="#3F3D56"/>
            <path d="M238.316 178.953H78.9929V184.105H238.316V178.953Z" fill="#3F3D56"/>
            <path d="M303.87 220.576C304.093 220.487 304.322 220.416 304.556 220.363L312.265 200.286L308.993 196.217L314.476 190.466C316.059 192.802 323.894 197.725 321.51 201.235L309.545 222.57C309.881 223.171 310.076 223.841 310.116 224.529C310.156 225.217 310.04 225.905 309.776 226.541C309.513 227.178 309.109 227.746 308.595 228.203C308.081 228.661 307.47 228.995 306.808 229.182C301.467 230.787 298.674 222.55 303.87 220.576Z" fill="#A0616A"/>
            <path d="M311.166 200.2C309.783 200.6 304.56 192.459 303.687 191.751C302.647 190.765 302.04 189.405 301.998 187.971C301.956 186.536 302.483 185.143 303.465 184.098C304.446 183.053 305.8 182.44 307.231 182.394C308.662 182.348 310.053 182.873 311.099 183.854L319.132 189.49C319.36 189.652 319.55 189.861 319.691 190.103C319.831 190.345 319.918 190.614 319.946 190.893C319.975 191.171 319.943 191.453 319.854 191.718C319.765 191.983 319.62 192.226 319.43 192.431C318.469 193.086 312.531 200.7 311.166 200.2Z" fill="#1D72F2"/>
            <path d="M313.898 322.33L307.676 322.329L306.746 298.27L313.899 298.271L313.898 322.33Z" fill="#A0616A"/>
            <path d="M315.485 328.375L295.421 328.375C295.233 317.729 308.806 320.632 315.486 320.293L315.485 328.375Z" fill="#2C2C2C"/>
            <path d="M334.165 320.276L327.984 320.994L322.277 297.438L331.4 296.377L334.165 320.276Z" fill="#A0616A"/>
            <path d="M336.437 326.099L316.506 328.416C315.095 317.863 328.911 319.178 335.508 318.07L336.437 326.099Z" fill="#2C2C2C"/>
            <path d="M315.012 316.618H304.78V277.961L298.805 245.691L290.631 217.017L309.806 207.667L313.463 213.426C314.028 213.943 323.189 222.44 324.178 230.86C325.185 239.442 315.456 313.259 315.041 316.397L315.012 316.618Z" fill="#2C2C2C"/>
            <path d="M291.324 223.023L288.166 209.144C287.425 208.43 280.414 201.226 288.174 192.02L292.264 181.332L304.244 177.613L308.928 181.247C310.815 182.71 312.314 184.614 313.294 186.793C314.273 188.973 314.704 191.36 314.547 193.745L313.268 213.381L291.324 223.023Z" fill="#2C2C2C"/>
            <path d="M301.582 154.592C313.928 161.634 303.793 180.213 291.217 173.597C278.872 166.556 289.007 147.976 301.582 154.592Z" fill="#A0616A"/>
            <path d="M267.621 179.627C267.66 179.885 267.679 180.145 267.678 180.406L286.991 193.518L292.093 191.045L296.821 198.276C293.964 199.382 286.841 206.489 283.719 203.096L264.122 185.16C263.404 185.368 262.649 185.411 261.912 185.284C261.176 185.158 260.478 184.865 259.87 184.43C259.263 183.994 258.762 183.425 258.405 182.767C258.048 182.11 257.845 181.379 257.81 180.631C257.426 174.569 266.813 173.627 267.621 179.627Z" fill="#A0616A"/>
            <path d="M287.352 192.373C287.269 190.807 297.15 187.263 298.112 186.511C299.409 185.649 300.994 185.338 302.52 185.646C304.045 185.954 305.387 186.856 306.25 188.154C307.113 189.451 307.428 191.039 307.125 192.569C306.822 194.099 305.926 195.447 304.634 196.315L296.708 203.457C296.481 203.659 296.213 203.809 295.923 203.899C295.633 203.989 295.327 204.015 295.026 203.977C294.725 203.938 294.436 203.836 294.178 203.676C293.919 203.516 293.698 203.303 293.529 203.051C293.073 201.87 286.488 193.699 287.352 192.373Z" fill="#1D72F2"/>
            <path d="M323.202 308.954L310.505 277.072L318.964 264.884L337.559 307.858L323.202 308.954Z" fill="#2C2C2C"/>
            <path d="M358.492 329H274.744C274.61 329 274.48 328.946 274.385 328.851C274.29 328.756 274.237 328.626 274.237 328.491C274.237 328.356 274.29 328.227 274.385 328.131C274.48 328.036 274.61 327.982 274.744 327.982H358.492C358.627 327.982 358.756 328.036 358.851 328.131C358.947 328.227 359 328.356 359 328.491C359 328.626 358.947 328.756 358.851 328.851C358.756 328.946 358.627 329 358.492 329Z" fill="#CCCCCC"/>
            <path d="M334.687 163.843C330.563 164.605 326.247 163.345 322.713 161.081C319.179 158.818 316.34 155.618 313.82 152.258C312.401 150.366 311.03 148.371 309.099 147.009C307.168 145.648 304.497 145.044 302.434 146.195C300.615 147.21 299.814 149.874 300.881 151.541C298.016 150.822 294.978 151.038 292.083 151.652C289.294 152.243 286.46 153.264 284.53 155.367C282.6 157.47 281.869 160.887 283.5 163.231L285.921 163.649C290.339 162.639 292.381 163.088 296.799 164.098C296.65 163.314 297.877 162.898 298.497 163.397C299.118 163.896 298.895 164.889 299.295 165.578C301.003 168.513 301.005 172.114 300.132 174.842C304.51 173.02 307.719 168.086 308.615 163.421C309.058 161.383 308.895 159.26 308.145 157.315C307.784 156.463 307.289 155.674 306.68 154.979C308.321 155.462 309.835 156.302 311.114 157.44C313.368 159.406 314.998 161.971 316.8 164.359C318.602 166.747 320.705 169.061 323.474 170.186C327.719 171.911 332.761 170.402 336.246 167.422C338.966 165.097 340.888 162.015 342.419 158.752C341.537 160.077 340.397 161.21 339.069 162.085C337.741 162.959 336.251 163.557 334.687 163.843Z" fill="#2C2C2C"/>
            <path d="M342.419 158.752C342.971 157.895 343.38 156.954 343.629 155.965C343.252 156.9 342.85 157.833 342.419 158.752Z" fill="#2C2C2C"/>
            </g>
            </g>
            <defs>
            <filter id="filter0_f_696_4399" x="33" y="237" width="335" height="335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
            <feGaussianBlur stdDeviation="50" result="effect1_foregroundBlur_696_4399"/>
            </filter>
            <filter id="filter1_f_696_4399" x="226.534" y="-57.9727" width="335" height="335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
            <feGaussianBlur stdDeviation="50" result="effect1_foregroundBlur_696_4399"/>
            </filter>
            <clipPath id="clip0_696_4399">
            <rect width="369" height="369" fill="white"/>
            </clipPath>
            <clipPath id="clip1_696_4399">
            <rect width="348" height="290" fill="white" transform="translate(11 39)"/>
            </clipPath>
            </defs>
            </svg>
          </div>
        </div> 
      </div>
    </section>

  </main>
  <script>
    document.querySelector('form').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent the form from submitting immediately
      document.getElementById('loading-screen').style.display = 'flex';

      // Wait for 3 seconds
      setTimeout(function() {
        event.target.submit(); // Submit the form after 3 seconds
      }, 3000);
    });

    document.addEventListener('DOMContentLoaded', () => {
    const doctorForm = document.getElementById('edit-profile__form');
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
  </script>

</body>
</html>