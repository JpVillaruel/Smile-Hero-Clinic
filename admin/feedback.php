<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/dbh.inc.php';
require_once './includes/pagination.php'; // Ensure this file includes a `renderPagination` function

if (!isset($_SESSION['adminID'])) {
  // Redirect user to login if not logged in
  header("Location: ../login.php?login=failed");
  exit();
}

// Pagination setup
$limit = 10; // Number of entries to show per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$start = ($page - 1) * $limit; // Calculate the starting row for the query

// Get total number of feedback records
$totalQuery = "SELECT COUNT(*) AS total FROM feedback"; // Adjust table name as needed
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];

// Fetch records for the current page
$query = "SELECT * FROM feedback LIMIT $start, $limit"; // Adjust table name as needed
$result = $conn->query($query);
$users = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $users[] = $row;
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
  <title>Reports | Admin</title>
  <link rel="stylesheet" href="../src/dist/styles.css" />
  
</head>

<body class="admin__page">
  <main class="admin__main">
    <!-- nav header -->
    <?php include("includes/nav.php"); ?>

    <section class="admin__content">
      <!-- side bar -->
      <?php include("includes/side_nav.php"); ?>
      
      <div class="feedbacks__container">
        <div class="feedbacks__table">
          <h1 class="table-heading">feedbacks<span class="table-item-count"><?php echo $totalRecords ?></span></h1>

          <table>
            <thead>
              <tr>
                <th>feedback id</th>
                <th>client name</th>
                <th>email</th>
                <th>
                  rating
                  <div class="dropdown-container">
                    <button class="filter-btn">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.22488 3.35999L3.36487 1.5L1.50488 3.35999" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3.36499 10.5V1.5" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.77466 8.64001L8.63467 10.5L10.4947 8.64001" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.63379 1.5V10.5" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    </button>

                    <ul class="dropdown rating">
                      <li><button>all</button></li>
                      <li><button>1</button></li>
                      <li><button>2</button></li>
                      <li><button>3</button></li>
                      <li><button>4</button></li>
                      <li><button>5</button></li>
                    </ul>
                  </div>
                </th>
                <th>message</th>
                <th>date</th>
              </tr>
            </thead>

            <tbody>
              <tr class="no-appointment-message" style="display:none;">
                <td colspan="6" style="text-align: center;">There's no such appointment in this section</td>
              </tr>
              <?php foreach($users as $user){?>
              <tr>
                <td class="patient-cell id">FB00  <?php echo $user['id']?></td>
                <td class="patient-cell name"><?php echo $user['name']?></td>
                <td class="patient-cell email"><?php echo $user['email']?></td>
                <td class="patient-cell rating"><?php echo $user['rating']?></td>
                <td class="patient-cell message"><?php echo $user['feedback']?></td>
                <td class="patient-cell date"><?php echo $user['created_at']?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <?php renderPagination($page, $totalPages) ?>
      </div>
    </section>
  </main>
</body>
<script>
  const registrationDates = document.querySelectorAll('.patient-cell.date')
  
  function sliceRegistrationDate(dateObjs){   
    return Array.from(dateObjs).map(dateObj => {
      let dateText = dateObj.textContent.trim()
      let date = dateText.slice(0, 11) // remove time and get date
      dateObj.textContent = date
    })
  }
  sliceRegistrationDate(registrationDates)

  const dropdownContainers = document.querySelectorAll('.dropdown-container')
  dropdownContainers.forEach(container => {
    container.addEventListener('click', e => {   
      if(e.target.closest('.filter-btn')) {
        const dropdown = container.querySelector('.dropdown')
        dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex'
      } 
    })
  })

  document.addEventListener('click', e => {
    if(!e.target.closest('.filter-btn'))
     document.querySelectorAll('.dropdown').forEach(dropdown => {
      dropdown.style.display = 'none'
     })
  })

  // Rating filter function
  const filterByRating = (rating) => {
    const rows = document.querySelectorAll('.feedbacks__table tbody tr');

    rows.forEach(row => {
      const ratingCell = row.querySelector('.patient-cell.rating');
      if (rating === 'all' || (ratingCell && ratingCell.textContent.trim() === rating)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });

    // Show/hide no appointment message
    const noAppointmentMessage = document.querySelector('.no-appointment-message');
    const anyVisible = [...rows].some(row => row.style.display !== 'none');
    noAppointmentMessage.style.display = anyVisible ? 'none' : 'table-row';
  };

  // Add event listeners for dropdown buttons
  const ratingButtons = document.querySelectorAll('.dropdown.rating button');
  ratingButtons.forEach(button => {
    button.addEventListener('click', (e) => {
      const selectedRating = e.target.textContent.trim();
      filterByRating(selectedRating);
    });
  });
</script>
</html>