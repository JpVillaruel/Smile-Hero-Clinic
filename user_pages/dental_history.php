<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/appointment_view.inc.php';

require_once '../includes/dbh.inc.php';
require_once 'includes/user_model.inc.php';

if(!isset($_SESSION['user_id'])) {
  // Redirect user to login if not logged in
  header("Location: ../login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

  // Fetch appointments for the user
  $query = "SELECT * FROM appointments WHERE user_id = ? AND status != 'request' ORDER BY created_at DESC";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $users = [];
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $users[] = $row;
      }
  }
  $stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/images/logoipsum.svg" type="image/x-icon">
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
    <section class="dental-history__page account__container">
      <table>
        <thead>
          <tr>
            <th>Apt ID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Req. Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user){ ?>
          <tr>
            <td><?php echo htmlspecialchars($user['appointment_id']) ?></td>
            <td><?php echo htmlspecialchars($user['date'])?> </td>
            <td><?php echo htmlspecialchars($user['time'])?> </td>
            <td><?php echo htmlspecialchars($user['created_at'])?> </td>
            <td>
              <p class="status">
                <?php echo htmlspecialchars($user['status'])?> 
              </p>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </section>
  </main>
</body>
<script>
  const setStatusStyles = (statusElement, statusText) => statusElement.classList.add(statusText === 'pending' ? 'pending' :  statusText === 'completed' ? 'completed' : statusText === 'accepted' ? 'accepted' : statusText === 'missed' ? 'missed' : statusText = 'canceled' ? 'canceled' : 'rejected')
  document.querySelectorAll('.status').forEach((status) => setStatusStyles(status, status.innerText.toLowerCase()))
</script>

</html>