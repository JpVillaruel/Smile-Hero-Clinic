<?php
require_once '../../includes/dbh.inc.php';

$query = "SELECT * FROM doctors";
$result = $conn->query($query);
$doctors = 0;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $doctors++;
  }
}

$query = "SELECT
(SELECT COUNT(*) FROM appointments WHERE DATE(date) = CURDATE()) AS TotalTodayApt,
(SELECT COUNT(*) FROM appointments WHERE WEEK(date) = WEEK(CURDATE())) AS TotalWeekApt,
(SELECT COUNT(*) FROM appointments WHERE MONTH(date) = MONTH(CURDATE())) AS TotalMonthApt";
$result = $conn->query($query);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
   $TotalTodayApt = $row['TotalTodayApt'];
   $TotalWeekApt = $row['TotalWeekApt'];
   $TotalMonthApt = $row['TotalMonthApt'];
  
}

$query = "SELECT
(SELECT COUNT(*) FROM appointments WHERE label = 'walk-in' AND MONTH(date) = MONTH(CURDATE())) AS walkInCount,
(SELECT COUNT(*) FROM appointments WHERE label != 'walk-in' AND MONTH(date) = MONTH(CURDATE())) AS onlineCount";
$result = $conn->query($query);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
   $walkInCount = $row['walkInCount'];
   $onlineCount = $row['onlineCount'];
  
}

$query = "SELECT
(SELECT COUNT(*) FROM appointments WHERE label = 'walk-in' AND DATE(date) = CURDATE()) AS todaywalkInCount,
(SELECT COUNT(*) FROM appointments WHERE label != 'walk-in' AND DATE(date) = CURDATE()) AS todayonlineCount,
(SELECT COUNT(*) FROM appointments WHERE label = 'walk-in' AND WEEK(date) = WEEK(CURDATE())) AS weeklywalkInCount,
(SELECT COUNT(*) FROM appointments WHERE label != 'walk-in' AND WEEK(date) = WEEK(CURDATE())) AS weeklyonlineCount,
(SELECT COUNT(*) FROM appointments WHERE label = 'walk-in' AND MONTH(date) = MONTH(CURDATE())) AS monthlywalkInCount,
(SELECT COUNT(*) FROM appointments WHERE label != 'walk-in' AND MONTH(date) = MONTH(CURDATE())) AS monthlyonlineCount";
$result = $conn->query($query);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
   $todaywalkInCount = $row['todaywalkInCount'];
   $todayonlineCount = $row['todayonlineCount'];
   $weeklywalkInCount = $row['weeklywalkInCount'];
   $weeklyonlineCount = $row['weeklyonlineCount'];
   $monthlywalkInCount = $row['monthlywalkInCount'];
   $monthlyonlineCount = $row['monthlyonlineCount'];
}

$query = "SELECT
(SELECT COUNT(*) FROM appointments WHERE status = 'completed' AND DATE(date) = CURDATE()) AS todaycompletedApt,
(SELECT COUNT(*) FROM appointments WHERE status = 'accepted' AND DATE(date) = CURDATE()) AS todayacceptedApt,
(SELECT COUNT(*) FROM appointments WHERE status = 'canceled' AND DATE(date) = CURDATE()) AS todaycanceledApt,
(SELECT COUNT(*) FROM appointments WHERE status = 'rejected' AND DATE(date) = CURDATE()) AS todayrejectedApt,
(SELECT COUNT(*) FROM appointments WHERE status = 'missed' AND DATE(date) = CURDATE()) AS todaymissedApt";
$result = $conn->query($query);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
   $todaycompletedApt = $row['todaycompletedApt'];
   $todayacceptedApt = $row['todayacceptedApt'];
   $todaycanceledApt = $row['todaycanceledApt'];
   $todayrejectedApt = $row['todayrejectedApt'];
   $todaymissedApt = $row['todaymissedApt'];
}

$query = "SELECT
(SELECT COUNT(*) FROM appointments WHERE status = 'completed' AND WEEK(date) = WEEK(CURDATE())) AS weeklycompletedApt,
(SELECT COUNT(*) FROM appointments WHERE status = 'accepted' AND WEEK(date) = WEEK(CURDATE())) AS weeklyacceptedApt,
(SELECT COUNT(*) FROM appointments WHERE status = 'canceled' AND WEEK(date) = WEEK(CURDATE())) AS weeklycanceledApt,
(SELECT COUNT(*) FROM appointments WHERE status = 'rejected' AND WEEK(date) = WEEK(CURDATE())) AS weeklyrejectedApt,
(SELECT COUNT(*) FROM appointments WHERE status = 'missed' AND WEEK(date) = WEEK(CURDATE())) AS weeklymissedApt";
$result = $conn->query($query);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
   $weeklycompletedApt = $row['weeklycompletedApt'];
   $weeklyacceptedApt = $row['weeklyacceptedApt'];
   $weeklycanceledApt = $row['weeklycanceledApt'];
   $weeklyrejectedApt = $row['weeklyrejectedApt'];
   $weeklymissedApt = $row['weeklymissedApt'];
}
$query = "SELECT
(SELECT COUNT(*) FROM appointments WHERE status = 'completed' AND MONTH(date) = MONTH(CURDATE())) AS monthlycompletedApt,
(SELECT COUNT(*) FROM appointments WHERE status = 'accepted' AND MONTH(date) = MONTH(CURDATE())) AS monthlyacceptedApt,
(SELECT COUNT(*) FROM appointments WHERE status = 'canceled' AND MONTH(date) = MONTH(CURDATE())) AS monthlycanceledApt,
(SELECT COUNT(*) FROM appointments WHERE status = 'rejected' AND MONTH(date) = MONTH(CURDATE())) AS monthlyrejectedApt,
(SELECT COUNT(*) FROM appointments WHERE status = 'missed' AND MONTH(date) = MONTH(CURDATE())) AS monthlymissedApt";
$result = $conn->query($query);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
   $monthlycompletedApt = $row['monthlycompletedApt'];
   $monthlyacceptedApt = $row['monthlyacceptedApt'];
   $monthlycanceledApt = $row['monthlycanceledApt'];
   $monthlyrejectedApt = $row['monthlyrejectedApt'];
   $monthlymissedApt = $row['monthlymissedApt'];
}

$query = "SELECT MONTH(date) as month, COUNT(*) as count FROM appointments
            GROUP BY MONTH(date)";
$result = $conn->query($query);
$totalAppointmentsPerMonth = 0;
if($result->num_rows > 0){
  while($row = $result->fetch_assoc()){
    $totalAppointmentsPerMonth++;
  }
}

$query = "SELECT WEEKDAY(date) + 1 as weekday, COUNT(*) as count
        FROM appointments
        GROUP BY WEEKDAY(date)
        ORDER BY weekday";
$result = $conn->query($query);
$totalAppointmentsPerWeek = 0;
if($result->num_rows > 0){
  while($row = $result->fetch_assoc()){
    $totalAppointmentsPerWeek++;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../src/dist/styles.css" />
    <link rel="shortcut icon" href="../../assets/images/logoipsum.svg" type="image/x-icon" />
    <title>Smile Hero Clinic Report - <span id="currentDate"></span></title>
</head>
<body class="dashboard-report">
  <main class="dashboard-report-container">

    <div class="report-header">
      <p class="heading">Smile Hero Clinic Report</p>
      <button class="print-report-btn" onclick="window.print()">Print Report</button>
    </div>
    <section class="table-container">
        
      <!-- Overview Table -->
      <div class="overview">
        <h1 class="table-header">Appointments Overview</h1>
        <table>
          <thead>
            <tr>
              <th>Today</th>
              <th>Weekly</th>
              <th>Monthly</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $TotalTodayApt ?></td>
              <td><?php echo $TotalWeekApt ?></td>
              <td><?php echo $TotalMonthApt ?></td>
            </tr>
          </tbody>
        </table>
        <!-- <table>
          <thead>
            <tr>
              <th>Walk-in Patients</th>
              <th>Online Patients</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            <td>
              <?php #echo $walkInCount ?>
            </td>
            <td>
              <?php #echo $onlineCount ?>
            </td>
            </tr>
          </tbody>
        </table> -->
      </div>

      <!-- Table for Patients -->
      <div class="patients-summary">
        <h2 class="table-header">Walk-in and Online Patients Summary</h2>
        <table>
          <thead>
            <tr>
              <th>Time Periods</th>
              <th>Walk-in</th>
              <th>Online</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="font-weight: bold;">Today</td>
              <td><?php echo $todaywalkInCount ?></td>
              <td><?php echo $todayonlineCount ?></td>
              <td><?php echo $todaywalkInCount + $todayonlineCount ?></td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Weekly</td>
              <td><?php echo $weeklywalkInCount ?></td>
              <td><?php echo $weeklyonlineCount ?></td>
              <td><?php echo $weeklywalkInCount + $weeklyonlineCount ?></td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Monthly</td>
              <td><?php echo $monthlywalkInCount ?></td>
              <td><?php echo $monthlyonlineCount ?></td>
              <td><?php echo $monthlywalkInCount + $monthlyonlineCount ?></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Table for Appointments -->
      <div class="appointments-summary">
        <h3 class="table-header">Appointments Summary</h3>
        <table>
          <thead>
            <tr>
              <th>Time Periods</th>
              <th>Completed</th>
              <th>Accepted</th>
              <th>Canceled</th>
              <th>Rejected</th>
              <th>Missed</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="font-weight: bold;">Today</td>
              <td><?php echo $todaycompletedApt ?></td>
              <td><?php echo $todayacceptedApt ?></td>
              <td><?php echo $todaycanceledApt ?></td>
              <td><?php echo $todayrejectedApt ?></td>
              <td><?php echo $todaymissedApt ?></td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Weekly</td>
              <td><?php echo $weeklycompletedApt ?></td>
              <td><?php echo $weeklyacceptedApt ?></td>
              <td><?php echo $weeklycanceledApt ?></td>
              <td><?php echo $weeklyrejectedApt ?></td>
              <td><?php echo $weeklymissedApt ?></td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Monthly</td>
              <td><?php echo $monthlycompletedApt ?></td>
              <td><?php echo $monthlyacceptedApt ?></td>
              <td><?php echo $monthlycanceledApt ?></td>
              <td><?php echo $monthlyrejectedApt ?></td>
              <td><?php echo $monthlymissedApt ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <article class="performance-summary">
      <h4 class="chart-header">Performance Summary</h4>

      <section class="charts-container">
        <article>
          <!-- line chart -->
          <p class="header daily">weekly<span><?php echo $totalAppointmentsPerWeek?></span></p>
          <div class="daily chart">
            <canvas id="lineChart" width="200" height="104" style="display: unset"></canvas>
          </div>
        </article>
        <article>
          <!-- bar chart -->
          <p class="header monthly">monthly<span><?php echo $totalAppointmentsPerMonth?></span></p>
          <div class="monthly chart">
            <canvas id="barChart" width="200" height="104" style="display: unset"></canvas>
          </div>
        </article>
      </section>
    </article>
  </main>
  
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
  // Canvas contexts
  const lineCtx = document.getElementById('lineChart').getContext('2d');
  const barCtx = document.getElementById('barChart').getContext('2d');

  // Gradient for the line chart
  const gradient = lineCtx.createLinearGradient(0, 0, 0, 400);
  gradient.addColorStop(0, 'hsla(216, 89%, 53%, 0.35)');
  gradient.addColorStop(1, 'hsla(0, 0%, 100%, 0)');

  // Fetch daily appointments (weekdays)
  fetch('getAppointmentsPerWeekday.php')
  .then(response => response.json())
  .then(data => {
    // Initialize weekday labels and default appointment counts
    const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const appointmentsPerDay = new Array(7).fill(0);

    // Populate appointments based on weekday (1 = Sun, 7 = Sat)
    data.forEach(item => {
      appointmentsPerDay[item.weekday - 1] = item.count;
    });

    // Prepare chart data
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

    // Configure and render the chart
    const lineConfig = {
      type: 'line',
      data: lineGraphData,
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          datalabels: { // Add data labels plugin configuration
            align: 'top', // Position labels above points
            anchor: 'end', // Anchor labels to the chart
            color: '#1D72F2',
            font: {
              family: 'DM Sans, sans-serif',
              size: 11,
              weight: 'bold'
            },
            formatter: (value) => value // Display the value for each data point
          }
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
      },
      plugins: [ChartDataLabels]
    };

    new Chart(lineCtx, lineConfig);
  })
  .catch(error => console.error('Error fetching daily appointments data:', error));

  // Fetch monthly appointments
  fetch('getAppointmentsPerMonth.php')
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
          legend: { display: false },
          datalabels: { // Add data labels plugin configuration
            align: 'top', // Position labels above points
            anchor: 'end', // Anchor labels to the chart
            color: [
            '#616161', '#1D72F2', '#FAAF0D', '#1D72F2', '#E84531', '#616161', '#1D72F2', 
            '#FAAF0D', '#1D72F2', '#E84531', '#FAAF0D', '#616161'
          ],
            font: {
              family: 'DM Sans, sans-serif',
              size: 11,
              weight: 'bold'
            },
            formatter: (value) => value // Display the value for each data point
          }
        },
          scales: {
            x: {
              ticks: {
                font: { family: 'DM Sans, sans-serif' }
              }
            },
            y: {
            beginAtZero: true,
            max: Math.max(...appointmentsPerMonth) + 16, // Adjust Y-axis dynamically
            ticks: {
              stepSize: 2,
              font: { family: 'DM Sans, sans-serif' }
              }
            }
          }
        },
        plugins: [ChartDataLabels]
      };

      new Chart(barCtx, barConfig);
    })
    .catch(error => console.error('Error fetching monthly appointments data:', error));
    
    // Get the current date
    const date = new Date();
    
    // Format the date (example: "November 20, 2024")
    const formattedDate = date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    
    // Update the title with the date
    document.title = `Smile Hero Clinic Report ${formattedDate}`;
</script>
</body>
</html>
