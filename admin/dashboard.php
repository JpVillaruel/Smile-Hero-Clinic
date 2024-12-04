<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/dbh.inc.php';

if(!isset($_SESSION['adminID'])) {
  // Redirect user to login if not logged in
  header("Location: ../login.php?login=failed");
  exit();
}

$query = "SELECT * FROM doctors WHERE availability = 'On Duty'";
$result = $conn->query($query);
$doctors = 0;
$GetOnDUty = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $GetOnDUty[] = $row;
    $doctors++;
  }
}

$query = "SELECT * FROM appointments WHERE status = 'rejected' OR status = 'canceled'";
$result = $conn->query($query);
$countStats = 0;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()){
    $countStats++;
  }
}

$query = "SELECT * FROM appointments WHERE status = 'rejected' OR status = 'canceled' 
  ORDER BY created_at DESC LIMIT 3";
$result = $conn->query($query);
$allStats = [];
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()){
    $allStats[] = $row;
  }
}

$dateNow = date('Y-m-d, l');


$query  = "SELECT * FROM appointments WHERE status = 'accepted' AND date > CURDATE() ORDER BY time DESC LIMIT 3";
$result = $conn->query($query);
$users = [];
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $users[] = $row;
  }
}

$query  = "SELECT * FROM appointments WHERE status = 'accepted' AND date > CURDATE()";
$result = $conn->query($query);
$totalAppointments = 0;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $totalAppointments++;
  }
}

$query  = "SELECT * FROM appointments WHERE date = CURDATE() AND status = 'accepted'";
$result = $conn->query($query);
$todaysAppointment = 0;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $todaysAppointment++;
  }
}


$query  = "SELECT * FROM users";
$result = $conn->query($query);
$usersinfo = [];
$totalUsers = 0;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $usersinfo[] = $row;
      $totalUsers++;
  }
}

$query = "SELECT MONTH(created_at) as month, COUNT(*) as count FROM appointments
            GROUP BY MONTH(created_at)";
$result = $conn->query($query);
$totalAppointmentsPerMonth = 0;
if($result->num_rows > 0){
  while($row = $result->fetch_assoc()){
    $totalAppointmentsPerMonth++;
  }
}

$query = "SELECT WEEKDAY(created_at) + 1 as weekday, COUNT(*) as count
        FROM appointments
        GROUP BY WEEKDAY(created_at)
        ORDER BY weekday";
$result = $conn->query($query);
$totalAppointmentsPerWeek = 0;
if($result->num_rows > 0){
  while($row = $result->fetch_assoc()){
    $totalAppointmentsPerWeek++;
  }
}

// Count the number of walk-in and online appointments for today
$query = "SELECT 
            SUM(CASE WHEN label = 'walk-in' THEN 1 ELSE 0 END) as walkInCount,
            SUM(CASE WHEN label != 'walk-in' THEN 1 ELSE 0 END) as onlineCount
          FROM appointments 
          WHERE date = CURDATE() AND status = 'accepted'";

$result = $conn->query($query);
$counts = $result->fetch_assoc();

$walkInCount = $counts['walkInCount'] ?? 0; // Default to 0 if NULL
$onlineCount = $counts['onlineCount'] ?? 0; // Default to 0 if NULL

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'today';
$dateNow = date('Y-m-d');
$startOfWeek = date('Y-m-d', strtotime('monday this week'));
$startOfMonth = date('Y-m-01');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/images/logoipsum.svg" type="image/x-icon" />
  <!-- <link href="https://fonts.googleapis.com/css?family=Inter:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic" rel="stylesheet" /> -->
  <title>Dashboard | Admin</title>
  <link rel="stylesheet" href="../src/dist/styles.css" />
  
</head>

<body class="admin__page">
  <main class="admin__main">
    <!-- nav header -->
    <?php include("includes/nav.php"); ?>

    <!-- dashboard container -->
    <section class="admin__content dashboard">
      <!-- side bar -->
      <?php include("includes/side_nav.php"); ?>

      <div class="cards">
        <article class="overview">
          <div class="overview__header">

            <div class="overview_details">
              <h1 class="overview__title">Today's Overview</h1>
                
              <button class="filter-btn" id="filterBtn">
                <svg width="25" height="12" viewBox="0 0 25 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="6.66666" cy="6" r="2" fill="#616161"/>
                  <circle cx="12.6667" cy="6" r="2" fill="#616161"/>
                  <circle cx="18.6667" cy="6" r="2" fill="#616161"/>
                </svg>
              </button>    
              <div class="filter-summary" id="filterSummary">
                <div class="filter-types">
                  <label id="todayBtn">
                    Today
                    <input type="radio" name="filterType" value="today" onclick="scaleDownFilterSummary()" readonly/>
                  </label>
                  <label id="weeklyBtn">
                    Weekly
                    <input type="radio" name="filterType" value="weekly" onclick="scaleDownFilterSummary()" readonly/>
                  </label>
                  <label id="monthlyBtn">
                    Monthly
                    <input type="radio" name="filterType" value="monthly" onclick="scaleDownFilterSummary()" readonly/>
                  </label>
                </div>
              </div>
            </div>

            <div>
              <a href="includes/report.php" class="generate-report-btn" target="_blank">Generate Report</a>
              <a href="raw_report.php" class="generate-report-btn" target="_blank">Raw Report</a>
            </div>
          </div>
          
          <div class="overview__content">
           <section class="overview__item">
            <div class="header">
              <p class="overview__label">Today's Schedule</p>
              <button class="more-btn" id="moreBtn">
                <svg width="25" height="12" viewBox="0 0 25 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="6.66666" cy="6" r="2" fill="#616161"/>
                <circle cx="12.6667" cy="6" r="2" fill="#616161"/>
                <circle cx="18.6667" cy="6" r="2" fill="#616161"/>
                </svg>
              </button>

              <div class="appointment-summary dropdown" id="dropdown">
                <p class="summary-title title">Number of appointments</p>
                <hr>
                <div class="appointment-types lists">
                  <p class="appointment-type list">Walk-ins<span class="appointment-count"><?php echo $walkInCount; ?></span></p>
                  <p class="appointment-type list">Online<span class="appointment-count"><?php echo $onlineCount; ?></span></p>
                </div>
              </div>
            </div>
             <div class="overview__icon-wrapper">
              <img src="../assets/admin_assets/todays-schedule.svg" alt="">
              <p class="overview__value" id="todaysSchedule"><?php echo $todaysAppointment; ?></p>
             </div>
           </section>

           <section class="overview__item">
             <p class="overview__label">Total Patients</p>
             <div class="overview__icon-wrapper">
               <img src="../assets/admin_assets/new-patients.svg" alt="">

               <p class="overview__value" id="newPatients"><?php echo $totalUsers; ?></p>
             </div>
           </section>

           <section class="overview__item">
            <div class="header">
              <p class="overview__label">Doctor's On-Duty</p>
              <button class="more-btn" id="moreBtn">
                <svg width="25" height="12" viewBox="0 0 25 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="6.66666" cy="6" r="2" fill="#616161"/>
                <circle cx="12.6667" cy="6" r="2" fill="#616161"/>
                <circle cx="18.6667" cy="6" r="2" fill="#616161"/>
              </svg>
              </button>

              <div class="doctors-on-duty dropdown" id="dropdown">
                <p class="header-title title">On Duty Doctors <span><?php echo $doctors ?></span></p>
                <hr>
                <ul class="doctors lists">
                <?php foreach ($GetOnDUty as $ResOnduty) { ?>
                     <li class="list">Doc. <?php echo $ResOnduty['first_name'] . " " . $ResOnduty['last_name'];?></li>
                <?php  } ?>
                </ul>
              </div>
            </div>
             <div class="overview__icon-wrapper">
               <img src="../assets/admin_assets/doctors-on-duty.svg" alt="">

               <p class="overview__value" id="doctorsOnDuty"><?php echo $doctors ?></p>
             </div>
           </section>

          </div>
        </article>

        <article class="appointments">
          <h2>Appointments</h2>

          <div class="appointments-content">
            <section class="upcoming__appointments">
              <header class="appointments-header">
                <p>Upcoming<span class="upcoming appointments-count">
                  <?php if($todaysAppointment === "0"){ ?>0
                 <?php }else{ echo $totalAppointments; }?>
                </span></p>
                <button type="button">
                  <a href="booked.php">
                    See all 
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M9.62 3.95337L13.6667 8.00004L9.62 12.0467" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M2.33333 8H13.5533" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </a>
                </button>
              </header>

              <table class="appointments-table">
                <thead>
                  <tr>
                    <th>patient name</th>
                    <th>phone #</th>
                    <th>time</th>
                    <th>date</th>
                    <!-- <th>actions</th> -->
                  </tr>
                </thead>

                <tbody>
                  <?php foreach ($users as $user){?>
                  <tr>
                   <td><?php echo $user['name'] ?></td>
                    <td><?php echo $user['contact'] ?></td>
                    <td><?php echo $user['time'] ?></td>
                    <td><?php echo $user['date'] ?></td>
                    <!-- <td>
                      <div class="appointments-actions">
                        <button type="button" class="reschedule-btn">resched</button>
                        <button type="button" class="cancel-btn">cancel</button>
                      </div>
                    </td> -->
                  </tr>
              <?php  } ?>
                </tbody>
              </table>
            </section>

            <section class="missed__appointments">
              <header class="appointments-header">
                <p>missed/ <br> canceled/rejected<span class="missed appointments-count"><?php echo $countStats?></span></p>
                <!-- <button type="button">
                  <a href="#">
                    view
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M9.62 3.95337L13.6667 8.00004L9.62 12.0467" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M2.33333 8H13.5533" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </a>
                </button> -->
              </header>

              <table class="appointments-table">
                <thead>
                  <tr>
                    <th>time</th>
                    <th>date</th>
                    <th>status</th>
                  </tr>
                </thead>

                <tbody>
                  <?php foreach($allStats as $allStat){  ?>
                  <tr>
                    <td><?php echo $allStat['time']?></td>

                    <?php
                    $dateFromDatabase = $allStat['date'];
                    $dateOnly = explode(',', $dateFromDatabase)[0];
                    
                    $date = DateTime::createFromFormat('Y-m-d', $dateOnly);
                    $formattedDate = $date->format('m/d/Y');
                     ?>
                     
                    <td><?php echo $formattedDate?></td>
                    <td>
                    <?php switch ($allStat['status']) { 
                      case 'rejected': ?>
                        <p class="appointment-status rejected"><?php echo $allStat['status']?></p>
                      <?php  break;
                      case 'canceled': ?>
                        <p class="appointment-status canceled"><?php echo $allStat['status']?></p>
                      <?php break; 
                      case 'missed': ?>
                        <p class="appointment-status missed"><?php echo $allStat['status']?></p>
                      <?php break; 
                      default: ?>
                         <p class="appointment-status accepted"><?php echo $allStat['status']?></p>
                      <?php break;
                        } ?>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </section>
          </div>
        </article>

        <article class="summary">
          <h3>Performance Summary</h3>

          <section class="charts-container">
            <article>
              <!-- line chart -->
              <p class="chart-header daily">weekly<span><?php echo $totalAppointmentsPerWeek?></span></p>
              <div class="daily chart">
                <canvas id="lineChart" width="200" height="104" style="display: unset"></canvas>
              </div>
            </article>
            <article>
              <!-- bar chart -->
              <p class="chart-header monthly">monthly<span><?php echo $totalAppointmentsPerMonth?></span></p>
              <div class="monthly chart">
                <canvas id="barChart" width="200" height="104" style="display: unset"></canvas>
              </div>
            </article>
          </section>
        </article>
      </div>
    </section>
  </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Canvas contexts
  const lineCtx = document.getElementById('lineChart').getContext('2d');
  const barCtx = document.getElementById('barChart').getContext('2d');

  // Gradient for the line chart
  const gradient = lineCtx.createLinearGradient(0, 0, 0, 400);
  gradient.addColorStop(0, 'hsla(216, 89%, 53%, 0.35)');
  gradient.addColorStop(1, 'hsla(0, 0%, 100%, 0)');

  // Fetch daily appointments (weekdays)
  fetch('includes/getAppointmentsPerWeekday.php')
  .then(response => response.json())
  .then(data => {
    const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const appointmentsPerDay = new Array(7).fill(0);

    data.forEach(item => {
      appointmentsPerDay[item.weekday - 1] = item.count;
    });

    const lineGraphData = {
      labels: weekdays,
      datasets: [{
        label: 'Daily Appointments',
        data: appointmentsPerDay,
        fill: true,
        backgroundColor: gradient,
        borderColor: '#1D72F2',
        borderWidth: 2,
        pointBackgroundColor: '#fff',
        pointBorderColor: '#1D72F2',
        tension: 0.45,
      }]
    };

    const lineConfig = {
      type: 'line',
      data: lineGraphData,
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          x: {
            ticks: {
              font: { family: 'DM Sans, sans-serif' }
            }
          },
          y: {
            beginAtZero: true,
            max: Math.max(...appointmentsPerDay) + 16, // Adjust Y-axis dynamically
            ticks: {
              stepSize: 5,
              font: { family: 'DM Sans, sans-serif' }
            }
          }
        }
      }
    };

    new Chart(lineCtx, lineConfig);
  })
  .catch(error => console.error('Error fetching daily appointments data:', error));

  // Fetch monthly appointments
  fetch('includes/getAppointmentsPerMonth.php')
    .then(response => response.json())
    .then(data => {
      const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      const appointmentsPerMonth = new Array(12).fill(0);

      data.forEach(item => {
        appointmentsPerMonth[item.month - 1] = item.count;
      });

      const barGraphData = {
        labels: months,
        datasets: [{
          label: 'Monthly Appointments',
          data: appointmentsPerMonth,
          backgroundColor: [
            '#616161', '#1D72F2', '#FAAF0D', '#1D72F2', '#E84531', '#616161', '#1D72F2', 
            '#FAAF0D', '#1D72F2', '#E84531', '#FAAF0D', '#616161'
          ],
          borderColor: 'transparent',
          borderRadius: 20,
        }]
      };

      const barConfig = {
        type: 'bar',
        data: barGraphData,
        options: {
          responsive: true,
          plugins: {
            legend: { display: false }
          },
          scales: {
            x: {
              ticks: {
                font: { family: 'DM Sans, sans-serif' }
              }
            },
            y: {
              beginAtZero: true,
            max: Math.max(...appointmentsPerMonth) + 9, // Adjust Y-axis dynamically
            ticks: {
              stepSize: 10,
              font: { family: 'DM Sans, sans-serif' }
            }
            }
          }
        }
      };

      new Chart(barCtx, barConfig);
    })
    .catch(error => console.error('Error fetching monthly appointments data:', error));

    // overview pop up
    // const dropdown = document.querySelectorAll('#dropdown')
    const moreBtns = document.querySelectorAll('#moreBtn')

    moreBtns.forEach(btn => {
      btn.addEventListener('click', (e) => {
        const dropdown = e.currentTarget.nextElementSibling        
        dropdown.classList.toggle('active')
      })
    })

    const filterSummary = document.getElementById('filterSummary')
    const filterBtn = document.getElementById('filterBtn')

    filterBtn.addEventListener('click', (e) => {
      filterSummary.classList.toggle('active')
    })

    // Function to fetch data based on selected period (today, weekly, or monthly)
  function fetchData(period) {
    fetch(`includes/get_appointments_data.php?period=${period}`)
      .then(response => response.json())
      .then(dataFromDB => {
        if (period === 'today') {
          data.today = dataFromDB;
        } else if (period === 'weekly') {
          data.weekly = dataFromDB;
        } else if (period === 'monthly') {
          data.monthly = dataFromDB;
        }

        // Update the UI with the new data
        updateOverview(period); // Replace updateDashboard with updateOverview
      })
      .catch(error => console.error('Error fetching data:', error));
  }

    // Assuming you have data objects for each filter type
    const data = {
      today: {
        label: "Today's Overview",
        scheduleLabel: "Today's Schedule",
        walkInCount: 0,
        onlineCount: 0,
        totalAppointments: 0,
        newPatients: 0,
        doctorsOnDuty: 0
      },
      weekly: {
        label: "Weekly Overview",
        scheduleLabel: "This Week's Schedule",
        walkInCount: 0,
        onlineCount: 0,
        totalAppointments: 0,
        newPatients: 0,
        doctorsOnDuty: 0
      },
      monthly: {
        label: "Monthly Overview",
        scheduleLabel: "This Month's Schedule",
        walkInCount: 0,
        onlineCount: 0,
        totalAppointments: 0,
        newPatients: 0,
        doctorsOnDuty: 0
      }
    };

    // Event listener for radio button changes
    document.querySelectorAll('input[name="filterType"]').forEach(button => {
      button.addEventListener('change', function() {
        fetchData(this.value);
      });
    });

    // Initial data fetch
    fetchData('monthly');
    fetchData('weekly');
    fetchData('today');


    const overviewLabel = document.querySelector(".overview__header .overview__title");
    const scheduleLabel = document.querySelector(".overview__content .overview__label");
    const walkInCountElem = document.querySelector(".appointment-type span.appointment-count");
    const onlineCountElem = document.querySelector(".appointment-type:nth-child(2) span.appointment-count");
    const totalAppointmentsElem = document.querySelector(".overview__value"); 
    const newPatientsElem = document.querySelectorAll(".overview__value")[1]; 
    const doctorsOnDutyElem = document.querySelectorAll(".overview__value")[2]; 

    function updateOverview(filterType) {
      const filterData = data[filterType];
      
      overviewLabel.textContent = filterData.label;
      scheduleLabel.textContent = filterData.scheduleLabel;
      
      walkInCountElem.textContent = filterData.walkInCount;
      onlineCountElem.textContent = filterData.onlineCount;
      
      totalAppointmentsElem.textContent = filterData.totalAppointments;
      newPatientsElem.textContent = filterData.newPatients;
      doctorsOnDutyElem.textContent = filterData.doctorsOnDuty;
    }

    document.querySelectorAll('input[name="filterType"]').forEach(button => {
      button.addEventListener('change', function () {
        fetchData(this.value); // fetch data based on the selected filter
      });
    });

    // Event listeners for filter buttons
    document.getElementById("todayBtn").addEventListener("click", () => updateOverview("today"));
    document.getElementById("weeklyBtn").addEventListener("click", () => updateOverview("weekly"));
    document.getElementById("monthlyBtn").addEventListener("click", () => updateOverview("monthly"));

    function scaleDownFilterSummary() {
      const filterSummary = document.getElementById('filterSummary');
      filterSummary.classList.remove('active');
    }


    // Optionally, add an event listener to reset scale when the filter summary container is clicked again
    document.getElementById('filterSummary').addEventListener('click', function() {
        scaleDownFilterSummary();  // Apply scale-down when clicked
    });

</script>

</html>