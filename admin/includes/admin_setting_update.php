<?php
require_once '../../includes/config_session.inc.php';
require_once '../../includes/login_view.inc.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $admin_id = $_SESSION['adminID'];
    $fname = htmlspecialchars($_POST['firstname']);
    $lname = htmlspecialchars($_POST['lastname']);
    $email = trim($_POST['email']);
    $contact = htmlspecialchars($_POST['contactnumber']);
    $password = trim($_POST['password']);
    $newPassword = trim($_POST['newPassword']);
    $confirmPassword = trim($_POST['confirmPassword']);

    $fileName = $_FILES['profileImage']['name'];
    $tempName = $_FILES['profileImage']['tmp_name'];
    $folder = 'images/'.$fileName;
    
    require_once "../../includes/dbh.inc.php";
    
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($contact)){

        $query = "UPDATE admin SET first_name = ?, last_name = ?, email = ?, contact = ?, profile_image = ? WHERE admin_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $fname, $lname, $email, $contact, $fileName, $admin_id);
        $stmt->execute();

        if (file_exists($folder)) {
            unlink($folder); // Delete the existing file
        }

        move_uploaded_file($tempName, $folder);

        if(!empty($password) && !empty($newPassword)){

            $passwordRegex ='/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/';

            $Pass = currPassword($conn,$admin_id);
            $currPass = $Pass['password'];
            
            if(!password_verify($password, $currPass)){
                echo "<script>alert('Incorrect old password');</script>";
                echo "<script>window.location.href = '../settings.php' </script>";
                exit();
            }

            if(!preg_match($passwordRegex, $newPassword)){
                echo "<script>alert('Password must be at least 8 characters long, include one uppercase letter, one lowercase letter, one digit, and one special character. e.g !@#$%^&*');</script>";
                echo "<script>window.location.href = '../settings.php' </script>";
                exit();
              }
  
            if($newPassword !== $confirmPassword){
                echo "<script>alert('New passwords do not match');</script>";
                echo "<script>window.location.href = '../settings.php' </script>";
                exit();
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $query = "UPDATE admin SET password = ? WHERE admin_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $hashedPassword, $admin_id);
            $stmt->execute();

            $_SESSION['admin_process'] = 'created';
        }
        $_SESSION['admin_process'] = 'created';
        header("Location: ../settings.php");
        exit();
    } else {
        echo "<script>alert('Failed to update');</script>";
        echo "<script>window.location.href = '../settings.php' </script>";
        exit();
    }
} else {
    header("Location: ../settings.php?failed");
    die();
}

function currPassword(mysqli $conn, string $admin_id){
    $query = "SELECT password FROM admin WHERE admin_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $password = $result->fetch_assoc();

    return $password;
}
