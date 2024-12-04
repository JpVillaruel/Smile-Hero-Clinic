<?php 
require_once '../../includes/config_session.inc.php';
require_once '../../includes/login_view.inc.php';
require_once '../../includes/dbh.inc.php';

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];

    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();

    echo"<script> alert('Account is now Deleted'); </script>";
    echo "<script>window.location.href='../../includes/logout.php';</script>";

    $stmt->close();
    $conn->close();
}
