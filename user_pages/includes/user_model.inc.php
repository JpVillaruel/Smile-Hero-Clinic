<?php
declare(strict_types=1);

function isValidRegularPatient(mysqli $conn, string $user_id){
    $query = "SELECT COUNT(*) as total FROM appointments WHERE user_id = ? AND (status != 'request') OR (status = 'completed')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total = $row['total'];

    return $total;
}
