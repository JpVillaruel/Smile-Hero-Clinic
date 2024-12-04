<?php 
require_once '../../includes/config_session.inc.php';
require_once '../../includes/login_view.inc.php';
require_once '../../includes/dbh.inc.php';

if($_SERVER['REQUEST_METHOD'] === "POST" && !empty($_POST['rating'])){

    $user_id = $_SESSION['user_id'];
    $fname = $_SESSION['fname'];
    $mname = $_SESSION['mname'];
    $lname = $_SESSION['lname'];
    $suffix = $_SESSION['suffix'];
    $fullname = "$fname $mname $lname $suffix";
    $email = $_SESSION['email'];
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];

    $query = "INSERT INTO feedback (user_id, name, email, feedback, rating, created_at) VALUES (?, ?, ?, ? ,?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $user_id,$fullname, $email, $feedback, $rating);
    $stmt->execute();

    $conn->close();

    $_SESSION['feedback_proccess'] = 'created';
    header("Location: ../feedback.php?success");
    die();
}else{
    header("Location: ../feedback.php?failed");
}
