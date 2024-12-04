<?php
require_once '../../includes/config_session.inc.php';
require_once '../../includes/login_view.inc.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dates'])) {
    $dates = $_POST['dates'];
    $datesArray = explode(',', $dates); // Assuming dates are separated by commas

    require_once '../../includes/dbh.inc.php';

    // Insert each date into the `appointment_dates` table
    $stmt = $conn->prepare("INSERT INTO appointment_dates (available_dates, created_at) VALUES (?, NOW())");
    foreach ($datesArray as $date) {
        $stmt->bind_param("s", $date);
        $stmt->execute();
    }
    $stmt->close();
    $conn->close();

    // Redirect back with a success message
    header("Location: ../set-dates.php?status=success");
    exit();
}
else{
    header("Location: ../set-dates.php?status=failed");
    exit();
}