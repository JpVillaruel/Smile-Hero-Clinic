<?php 
require_once '../../includes/config_session.inc.php';
require_once '../../includes/login_view.inc.php';
require_once '../../includes/dbh.inc.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $aptID = $_POST['appointmentId'];

    // Update the appointment status to 'completed'
    $queryComplete = "UPDATE appointments SET status = 'completed' WHERE appointment_id = ?";
    $stmt = $conn->prepare($queryComplete);
    $stmt->bind_param("s", $aptID);  // Use $aptID, not $aptId
    $stmt->execute();

    // Close connection after update
    $stmt->close();
    $conn->close();

    // Redirect back to appointment details page

     $_SESSION['complete_process'] = 'success';

    header("Location: ../appointment-details.php?aptId=" . urlencode($aptID));
    exit;
}