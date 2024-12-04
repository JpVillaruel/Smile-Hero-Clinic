<?php
$mysqli = new mysqli("localhost", "root", "", "smile_hero_clinic");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);    
}


// Appointments per month
$query = "SELECT MONTH(date) as month, COUNT(*) as count
          FROM appointments
          WHERE YEAR(date) = YEAR(CURDATE())
          GROUP BY month";
$result = $mysqli->query($query);

$appointmentData = array();
while($row = $result->fetch_assoc()) {
    $appointmentData[] = $row;
}

echo json_encode($appointmentData);

$mysqli->close();
