<?php
require_once "../../includes/dbh.inc.php";
require_once 'SimpleXLSXGen.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export'])) {
    $fromDate = $_POST['fromDate'] ?? '';
    $toDate = $_POST['toDate'] ?? '';
    $status = isset($_POST['status']) ? json_decode($_POST['status'], true) : [];
    $label = isset($_POST['label']) ? json_decode($_POST['label'], true) : [];

    if (!empty($fromDate) && !empty($toDate)) {
        // Securely format date inputs to avoid SQL injection
        $fromDate = mysqli_real_escape_string($conn, $fromDate);
        $toDate = mysqli_real_escape_string($conn, $toDate);

        // Start building the SQL query
        $query = "SELECT user_id, doctor_id, appointment_id, label, name, email, date, time, service, status, created_at 
                  FROM appointments 
                  WHERE date BETWEEN '$fromDate' AND '$toDate'";
        
        // Handle status filter
        if (!empty($status)) {
            // Correcting the array_map usage for mysqli_real_escape_string
            $statusPlaceholders = implode("','", array_map(function($item) use ($conn) {
                return mysqli_real_escape_string($conn, $item);
            }, $status));
            $query .= " AND status IN ('$statusPlaceholders')";
        }

        // Handle label filter
        if (!empty($label)) {
            // Correcting the array_map usage for mysqli_real_escape_string
            $labelPlaceholders = implode("','", array_map(function($item) use ($conn) {
                return mysqli_real_escape_string($conn, $item);
            }, $label));
            $query .= " AND label IN ('$labelPlaceholders')";
        }

        $stmt = mysqli_query($conn, $query);

        if ($stmt) {
            $arr = array();
            $arr[] = array("user_id", "doctor_id", "appointment_id", "label", "name", "email", "date", "time", "service", "status", "created_at");
            
            while ($data = mysqli_fetch_assoc($stmt)) {
                $arr[] = $data;
            }

            if (count($arr) > 1) {
                $xlsx = Shuchkin\SimpleXLSXGen::fromArray($arr);
                $xlsx->downloadAs("AppointmentDate.xlsx");
            } else {
                echo "No data found for the selected filters.";
            }
        } else {
            echo "Error fetching data.";
        }
    } else {
        echo "<script> alert('Please Provide Date'); window.location.href = '../raw_report.php' ; </script>";
    }
}
