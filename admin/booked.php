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
$limit = 10; // Number of entries to show per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$start = ($page - 1) * $limit; // Calculate the starting row for the query

// Get total number of records for booked meetings
$totalQuery = "SELECT COUNT(*) AS total FROM appointments WHERE status = 'accepted' OR status = 'completed' ";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];

// Fetch records for the current page
$query = "SELECT * FROM appointments WHERE status = 'accepted' OR status = 'completed' OR  status = 'canceled' OR status = 'missed' ORDER BY status, date, time ASC LIMIT $start, $limit";
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

  <style>

    .appointment-row{
      position: relative;
    }

    .identifier{
      position: absolute;
      width: 3px;
      height: 100%;
      top: 0;
      right: 0;
      border-radius: 5px 0 0 5px;
    }
  </style>
  
</head>

<body class="admin__page">
  <main class="admin__main">
    <!-- nav header -->
    <?php include("includes/nav.php"); ?>

     <section class="admin__content">
      <!-- side bar -->
      <?php include("includes/side_nav.php"); ?>
       
      <!-- booked appointments -->
      <div class="booked__container">
        <div class="booked-appointments__table">
          <div class="table-heading__container">
            <h1 class="table-heading">booked appointments <span class="table-item-count"><?php echo $totalRecords ?></span></h1>
            <?php include("includes/search.php"); ?>
          </div>

          <table>
            <thead>
              <tr>
                <th>
                  date 
                  <div class="dropdown-container">
                    <button class="filter-btn">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.22488 3.35999L3.36487 1.5L1.50488 3.35999" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3.36499 10.5V1.5" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.77466 8.64001L8.63467 10.5L10.4947 8.64001" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.63379 1.5V10.5" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    </button>

                    <ul class="dropdown date">
                      <li><button>all</button></li>
                      <li><button>today</button></li>
                      <li><button>this week</button></li>
                      <li><button>this month</button></li>
                    </ul>
                  </div>
                </th>
                <th>
                  time 
                </th>
                <th>doctor</th>
                <th>
                  patient name
                  <div class="dropdown-container">
                    <button class="filter-btn">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.22488 3.35999L3.36487 1.5L1.50488 3.35999" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3.36499 10.5V1.5" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.77466 8.64001L8.63467 10.5L10.4947 8.64001" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.63379 1.5V10.5" stroke="#616161" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    </button>
                    <ul class="dropdown patients">
                      <li><button>all</button></li>
                      <li><button>new</button></li>
                      <li><button>regular</button></li>
                    </ul>
                  </div>
                </th>
                <th>phone #</th>
                <th>id #</th>
                <th>action</th>
              </tr>
            </thead>

            <tbody id="items">
              <tr class="no-appointment-message" style="display:none;">
                <td colspan="6" style="text-align: center;">There's no such appointment in this section</td>
              </tr>
              <?php foreach ($users as $user){?>
              <tr class="item-row appointment-row" 
                data-date="<?php echo date('Y-m-d', strtotime($user['date'])); ?>">
                <td class="patient-cell date" data-date="<?php echo $user['date'] ?>">
                  <?php echo date('l, m/d/Y', strtotime($user['date'])); ?>
                </td>

                <td class="patient-cell time">
                  <?php echo $user['time']; ?>
                </td>

                <td class="patient-cell doctor">
                  <!-- lagay mo dito yung name ng doctor -->
                  <?php echo $user['doctor_id']; ?>
                </td>

                <td class="patient-cell name-email" data-label="<?php echo $user['label'] ?>">
                  <p class="patient-name" title="<?php echo $user['name']; ?>">
                    <?php echo $user['name']; ?>
                  </p>
                  <p class="patient-email" title="<?php echo $user['email']; ?>">
                    <?php echo $user['email']; ?>
                  </p>
                </td>

                <td class="patient-cell phone">
                  <?php echo $user['contact']; ?>
                </td>

                <td class="patient-cell apt-id">
                  <?php echo $user['appointment_id']; ?>
                </td>

                <?php
                $bgColor = '';
                  switch ($user['status']) {
                    case 'accepted':
                      $bgColor = '#1d72f2';
                      break;
                    case 'canceled':
                      $bgColor = 'red';
                      break;
                    case 'missed':
                      $bgColor = 'orange';
                      break;
                    case 'completed':
                      $bgColor = '#2bc757';
                      break;
                    
                    default:
                      $bgColor = '';
                      break;
                  }
                ?>
                <td class="patient-cell action" data-status="<?php echo $user['status']; ?>">
                  <button type="button">
                    <a href="appointment-details.php?aptId=<?php echo $user['appointment_id'] ?>">
                      View Details
                    </a>
                  </button>
                  <div class="identifier" style=" background-color:<?php echo $bgColor ?>; "></div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <?php if($result->num_rows == 0) { ?>
          <p>No appointment requests</p>
          <?php } ?>
        </div>

        <!-- Pagination -->
        <?php renderPagination($page, $totalPages) ?>
      </div>
    </section>
  </main>
</body>
<script>
  // actions styles
  // const actions = document.querySelectorAll('.patient-cell.action')
  // actions.forEach(action => {
  //   action.innerHTML = `<button class="reschedule-btn">${action.dataset.status === 'accepted'? 'Reschedule': 'View History'}</button>`
    
  //   const button = action.querySelector('button')
  //   let actionText = button.textContent.trim()
    
  //   if(actionText === 'Reschedule') 
  //     button.style.color = 'var(--cancel-btn-clr)'
  // })

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

  const filterByLabel = (label) => {
  const rows = document.querySelectorAll('#items tr:not(.no-appointment-message)');
  let visibleRows = 0;
  let showRow = false;

  rows.forEach(row => {
    const userLabel = row.querySelector('.patient-cell.name-email').dataset.label.trim();
    console.log(label);
    console.log(userLabel);
    
    if (label === 'all' || userLabel.toLowerCase() === label.toLowerCase()) {
      row.style.display = '';
      showRow = true;
    } else {
      row.style.display = 'none';
    }
    if (showRow) visibleRows++;
  });

  document.querySelector('.no-appointment-message').style.display = visibleRows === 0 ? '' : 'none';
  };

  const labelButtons = document.querySelectorAll('.dropdown.patients button');
  labelButtons.forEach(button => {
    button.addEventListener('click', (e) => {
      const selectedLabel = e.target.textContent.toLowerCase().replace(' ', '');
      filterByLabel(selectedLabel);
    });
  });

  // filter date
  const dateDropdown = document.querySelector('.dropdown.date')
  function isDateRange(date, startDate, endDate) {
    console.log(date >= startDate && date <= endDate);
    return date >= startDate && date <= endDate
  }

  function filterByDate(filterType) {
    const today = new Date()
    const startOfWeek = new Date(today);
    const endOfWeek = new Date(startOfWeek)
    startOfWeek.setDate(today.getDate() - today.getDay()); // start of the week - Sunday
    endOfWeek.setDate(startOfWeek.getDate() + 6) // end of the week saturday
    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1); // start of the current month
    const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0); // end of the current month

    let visibleRows = 0

    appointmentRows.forEach(row => {
      const appointmentDate = new Date(row.querySelector('.patient-cell.date').getAttribute('data-date'))

      let showRow = false
      if (filterType === 'all') showRow = true
      else if (filterType === 'today') showRow = today.toDateString() === appointmentDate.toDateString()
      else if (filterType === 'this week') showRow = isDateRange(appointmentDate, startOfWeek, endOfWeek)
      else if (filterType === 'this month') showRow = isDateRange(appointmentDate, startOfMonth, endOfMonth)

      row.style.display = showRow ? '' : 'none'
      if (showRow) visibleRows++
    })
    document.querySelector('.no-appointment-message').style.display = visibleRows === 0 ? '' : 'none'
  }

  dateDropdown.addEventListener('click', e => {
    const filterType = e.target.textContent.trim().toLowerCase()
    filterByDate(filterType)
  })
  
  // filter accepted or rescheduled appointments
  // const actionsDropdown = document.querySelector('.dropdown.actions')
  const appointmentRows = document.querySelectorAll('.appointment-row')
  function filterAppointments(filterType) {
    let visibleRows = 0
    appointmentRows.forEach(row => {
      const status = row.querySelector('.patient-cell.action').getAttribute('data-status')
      const showRow = filterType === 'all' || status === filterType;
      row.style.display = showRow ? '' : 'none';
      
      if (showRow) visibleRows++
    })
    document.querySelector('.no-appointment-message').style.display = visibleRows === 0 ? '' : 'none'
  }

  // actionsDropdown.addEventListener('click', e => {
  //   const filterType = e.target.textContent.trim().toLowerCase()
  //   if(filterType === 'updated') filterAppointments('rescheduled')
  //   else if (filterType === 'accepted') filterAppointments('accepted')
  //   else filterAppointments('all')
  // })
</script>
</html>