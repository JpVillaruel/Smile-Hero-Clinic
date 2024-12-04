<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/dbh.inc.php';
require_once './includes/pagination.php';

if (!isset($_SESSION['adminID'])) {
  // Redirect user to login if not logged in
  header("Location: ../login.php?login=failed");
  exit();
}

// Pagination setup
$limit = 5; // Number of entries to show per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$start = ($page - 1) * $limit; // Calculate the starting row for the query

// Get total number of records for doctors
$totalQuery = "SELECT COUNT(*) AS total FROM doctors";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];

// Fetch records for the current page
// $query = "SELECT * FROM doctors LIMIT $start, $limit";
$query = "SELECT doctor_id, first_name, last_name, phone_number, email, availability FROM doctors LIMIT $start, $limit";
$result = $conn->query($query);
$doctors = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
  }
}

// Calculate total pages needed
$totalPages = ceil($totalRecords / $limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/images/logoipsum.svg" type="image/x-icon" />
  <title>Doctors | Admin</title>
  <link rel="stylesheet" href="../src/dist/styles.css" />
  
</head>

<body class="admin__page">
  <main class="admin__main">
    <!-- nav header -->
    <?php include("includes/nav.php"); ?>

     <section class="admin__content">
      <!-- side bar -->
      <?php include("includes/side_nav.php"); ?>
      
      <!-- doctors -->
      <div class="doctors__container">
        <div class="doctors__table">
          <h1 class="table-heading">
            doctors <span class="table-item-count"><?php echo $totalRecords?></span>
          </h1>

          <table>
            <thead>
              <tr>
                <th>doctor id</th>
                <th>name & email</th>
                <th>contact #</th>
                <th>status</th>
                <th>actions</th>
              </tr>
            </thead>

            <tbody>
              <?php if (!empty($doctors)): ?>
                <?php foreach ($doctors as $doctor): ?>
              <tr>
                <td><?php echo htmlspecialchars($doctor['doctor_id']); ?></td>
                <td class="patient-cell name-email">
                  <p class="name" title="<?php echo $doctor['last_name'] ." ". $doctor['first_name'] ?>">
                    <?php echo htmlspecialchars($doctor['last_name']); ?>
                    <?php echo htmlspecialchars($doctor['first_name']); ?>
                  </p>
                  <p class="email" title="<?php echo $doctor['email'] ?>">
                    <?php echo htmlspecialchars($doctor['email']); ?>
                  </p>
                </td>
                <td><?php echo htmlspecialchars($doctor['phone_number']); ?></td>
                <td><?php echo htmlspecialchars($doctor['availability']);?></td>
                <td>
                  <form class="status-toggle-form" method="POST">
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor['doctor_id']; ?>">
                    <input type="hidden" name="newStatus" value="<?php echo $doctor['availability'] === 'On Duty' ? 'Off Duty' : 'On Duty'; ?>">
                    
                    <button type="submit" name="toggle" value="update">
                      Set <?php echo $doctor['availability'] === 'On Duty' ? 'Off Duty' : 'On Duty'; ?>
                    </button>
                  </form>
                </td>
              </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5">No doctors found.</td>
                  </tr>
                <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="status-modal">
          <p class="status-message">
            Doctor Status Updated
          </p>
        </div>

        <!-- Pagination -->
        <?php renderPagination($page, $totalPages) ?>
      </div>
      
    </section>
  </main>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const forms = document.querySelectorAll('.status-toggle-form');

      forms.forEach(form => {
        form.addEventListener('submit', function(event) {
          event.preventDefault();

          const formData = new FormData(form);
          const doctorId = formData.get('doctor_id');
          const newStatus = formData.get('newStatus');

          const xhr = new XMLHttpRequest();
          xhr.open('POST', 'includes/update_doctor_availability.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

          console.log(`doctor_id=${doctorId}&new_status=${newStatus}`); // Debugging
          xhr.send(`doctor_id=${doctorId}&new_status=${newStatus}`);

          xhr.onload = function() {
            if (xhr.status === 200) {
              const modal = document.querySelector('.status-modal');
              modal.style.top = '2rem'; 
              
              setTimeout(() => {
                modal.style.top = '-100%'; 
              }, 3000); 

              setTimeout(() => {
               location.reload(); 
              }, 3125); 
            } else {
              alert('An error occurred while updating the status.');
            }
          };
        });
      });
    });
  </script>
</body>

</html>