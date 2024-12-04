<?php
require_once '../../includes/dbh.inc.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $doctorId = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : null;
    $newStatus = isset($_POST['new_status']) ? $_POST['new_status'] : null;

    if (empty($doctorId) || !in_array($newStatus, ['On Duty', 'Off Duty'])) {
        http_response_code(400);
        echo "Invalid input.";
        exit();
    }

    // Validate inputs
    if ($doctorId && ($newStatus === 'On Duty' || $newStatus === 'Off Duty')) {
        // Prepare the update query
        $stmt = $conn->prepare("UPDATE doctors SET availability = ? WHERE doctor_id = ?");
        $stmt->bind_param("ss", $newStatus, $doctorId);

        if ($stmt->execute()) {
            // Success
            echo "Status updated successfully.";
        } else {
            // Error
            http_response_code(500);
            echo "Failed to update status.";
        }
        $stmt->close();
    } else {
        http_response_code(400);
        echo "Invalid input.";
    }
} else {
    http_response_code(405);
    echo "Method not allowed.";
}
$conn->close();
