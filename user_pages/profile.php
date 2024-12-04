<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/dbh.inc.php';

if(!isset($_SESSION['user_id'])) {
   // Redirect user to login if not logged in
   header("Location: ../login.php");
   exit();
} 
$user_id = $_SESSION['user_id'];

// Fetch user details from users table
$user_query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($user_query); $stmt->bind_param("s", $user_id);
$stmt->execute(); $result = $stmt->get_result(); ?>

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
    <title>Account | Smile Hero Clinic</title>
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

        <?php if($row= $result->fetch_assoc() ) { ?>
        <!-- profile info -->
        <div class="user-profile">
          <!-- header -->
          <div class="user-profile__header">
            <div class="user-profile__info">
              <h1 class="user-profile__name"><?php echo $row["first_name"] ." ". $row["middle_name"] ." ". $row["last_name"] ." ". $row["suffix"] ?></h1>
              <p class="user-profile__address">
                <?php if(strlen($row["address"])===0) { ?>
                  No Address
                  <?php }else {
                    echo $row["address"];
                  } ?>
              </p>
            </div>

            <div class="user-profile__actions">
              <button class="user-profile__edit-btn" id="edit-btn">
                <a href="includes/edit_profile.php">
                  Edit Profile
                </a>
              </button>
              <button class="user-profile__delete-btn" id="delete-btn">
                Delete Account
              </button>
            </div>
          </div>
          <!-- end of header -->

          <!-- modal - delete account -->
          <div class="modal_container delete-account">
           <div class="delete-account">
             <div class="header">
               <!-- <h3>Are you sure you want to permanently delete your account?</h3> -->
               <p>*This action cannot be undone and all your data will be lost.*
               </p>
             </div>
             <div class="button_container">
               <button type="submit" id="deleteAccountButton">
                 <a href="includes/delete_acc.php" style="color: white;">
                   Yes, delete my account
                 </a>
               </button>
               <button id="exitButton">No, keep my account</button>
             </div>
           </div>
          </div>
          <!-- end of modal - delete account -->

          <ul class="user-profile__details">
            <li class="user-profile__detail-item">
              <p class="user-profile__detail-label">Name</p>
              <p class="user-profile__detail-value"><?php echo $row["first_name"] ." ". $row["middle_name"] ." ". $row["last_name"] ." ". $row["suffix"] ?></p>
            </li>
            <li class="user-profile__detail-item">
              <p class="user-profile__detail-label">Birthdate</p>
              <p class="user-profile__detail-value">
              <?php if($row['birthdate'] === null){?>
                  N/a
                  <?php } else{
                    echo $row['birthdate'];
                  }?>
              </p>
            </li>
            <li class="user-profile__detail-item">
              <p class="user-profile__detail-label">Gender</p>
              <p class="user-profile__detail-value">
              <?php if(strlen($row["gender"])===0) { ?>
                  N/a
                  <?php }else {
                    echo ucfirst($row["gender"]);
                  } ?>
              </p>
            </li>
            <li class="user-profile__detail-item">
              <p class="user-profile__detail-label">Contact Number</p>
              <p class="user-profile__detail-value"><?php echo $row["contact"]; ?></p>
            </li>
            <li class="user-profile__detail-item">
              <p class="user-profile__detail-label">Address</p>
              <p class="user-profile__detail-value">
                 <?php if(strlen($row["address"])===0) { ?>
                  No Address
                  <?php }else {
                    echo $row["address"];
                  } ?>
              </p>
            </li>
            <li class="user-profile__detail-item">
              <p class="user-profile__detail-label">Email</p>
              <p class="user-profile__detail-value"><?php echo $row["email"]; ?></p>
            </li>
            <li class="user-profile__detail-item">
              <p class="user-profile__detail-label">Password</p>
              <p class="user-profile__detail-value">***************</p>
            </li>
          </ul>
        </div>
        <?php } ?>
      </section>
    </main>
  </body>
   <script>
      const openModalBtn = document.getElementById("delete-btn");
      const modalContainer = document.querySelector(".modal_container.delete-account");
      const exitBtn = document.getElementById("exitButton");
      const deleteAccountBtn = document.getElementById("deleteAccountButton");

      openModalBtn.addEventListener("click", () => {
        modalContainer.style.transform = "scale(1)";
      })

      exitBtn.addEventListener("click", () => {
        modalContainer.style.transform = "scale(0)";
      })

      // AJAX request to delete user when confirmation is clicked
      deleteAccountBtn.addEventListener("click", () => {
        console.log("Delete Account Button Clicked!");
      });
    </script>
</html>
<!-- <?php if($row= $result->fetch_assoc() ) { ?> -->
<!-- <div class="account">
          
          <div class="info__header">
            <div class="details__container">
              
              <div class="user__details">
                <h2 class="user__name" id="headerUserName">
                  <?php echo $row["fullname"]; ?> </h2>
                <p class="user__address" id="headerUserAddress">
                  <?php if(strlen($row["address"])===0) { ?>
                  No Address
                  <?php }else {
                    echo $row["address"];
                  } ?>
                </p>
              </div>
            </div>

            <div class="button_container">
              <a href="includes/edit_profile.php" style="text-align: center;" class="button edit" id="editAccountBtn">
                Edit Account
              </a>
              <button class="button delete" id="deleteAccountBtn">
                Delete Account
              </button>
            </div>
          </div>

          <div class="modal_container delete-account">
            <div class="delete-account">
              <div class="header">
                <h3>Are you sure you want to permanently delete your account?</h3>
                <p>*This action cannot be undone and all your data will be lost.*
                </p>
              </div>
              <div class="button_container">
                <button type="submit" id="deleteAccountButton">
                  <a href="includes/delete_acc.php" style="color: white;">
                    Yes, delete my account
                  </a>
                </button>
                <button id="exitButton">No, keep my account</button>
              </div>
            </div>
          </div>

        <div class="additional_details__container">
          <div class="item">
            <div class="details">
              <p class="detail__header">Name</p>
              <p class="full__name detail_content" id="fullName"><?php echo $row["fullname"]; ?></p>
            </div>
          </div>
          <div class="item">
            <div class="details">
              <p class="detail__header">Contact Number</p>
              <p class="contact__number detail_content" id="contactNumber">
                <?php echo $row["contact"]; ?></p>
            </div>
          </div>
          <div class="item">
            <div class="details">
              <p class="detail__header">Address</p>
              <p class="address detail_content" id="address">
                <?php if(strlen($row["address"])===0) { ?>
                No Address
                <?php }else {
                  echo $row["address"];
                } ?>
              </p>
            </div>
          </div>
            <div class="item">
              <div class="details">
                <p class="detail__header">Email</p>
                <p class="email detail_content" id="email"><?php echo $row["email"]; ?></p>
              </div>
            </div>
            <div class="item">
              <div class="details">
                <p class="detail__header">Password</p>
                <p class="password detail_content" id="password">********</p>
              </div>
            </div>
          </div>
        </div> -->
<!-- <?php } ?> -->
