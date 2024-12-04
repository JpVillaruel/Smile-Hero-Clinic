<?php

declare(strict_types= 1);

function outputUserId(){
    if(isset($_SESSION["user_id"])){
      $userid = $_SESSION["user_id"];
      echo $userid;
        // Header("Location: ../userpage.php?login=success");

    }else{
        Header("Location: ../login.php?login=failed");
        // echo"you are not logged in";
    }
}

function outputFullName(){
    if(isset($_SESSION["fname"]) && isset($_SESSION["mname"]) && isset($_SESSION["lname"]) && isset($_SESSION["suffix"])){
        $fname = $_SESSION["fname"];
        $mname = $_SESSION["mname"];
        $lname = $_SESSION["lname"];
        $suffix = $_SESSION["suffix"];

        echo "$fname $mname $lname $suffix";
    }else{
            Header("Location: ../login.php?login=failed");
            // echo"you are not logged in";
        } 
}

// function outputFName(){
//     if(isset($_SESSION["fname"])){
//       $fname = $_SESSION["fname"];
//       echo $fname;
//         // Header("Location: ../userpage.php?login=success");

//     }else{
//         Header("Location: ../login.php?login=failed");
//         // echo"you are not logged in";
//     }
// }

// function outputMName(){
//     if(isset($_SESSION["mname"])){
//         $fname = $_SESSION["fname"];
//       echo $mname;
//         // Header("Location: ../userpage.php?login=success");

//     }else{
//         Header("Location: ../login.php?login=failed");
//         // echo"you are not logged in";
//     }
// }
// function outputLName(){
//     if(isset($_SESSION["lname"])){
//         $fname = $_SESSION["fname"];
//       echo $lname;
//         // Header("Location: ../userpage.php?login=success");

//     }else{
//         Header("Location: ../login.php?login=failed");
//         // echo"you are not logged in";
//     }
// }
// function outputSuffix(){
//     if(isset($_SESSION["suffix"])){
//       $suffix = $_SESSION["suffix"];
//       echo $suffix;
//         // Header("Location: ../userpage.php?login=success");

//     }else{
//         Header("Location: ../login.php?login=failed");
//         // echo"you are not logged in";
//     }
// }


function outputEmail(){
    if(isset($_SESSION["email"])){
      $email = $_SESSION["email"];
      echo $email;
        // Header("Location: ../userpage.php?login=success");

    }else{
        Header("Location: ../login.php?login=failed");
        // echo"you are not logged in";
    }
}
function outputAdminId(){
    if(isset($_SESSION['adminID'])){
      $admin_id = $_SESSION['adminID'];
      echo $admin_id;
        // Header("Location: ../userpage.php?login=success");

    }else{
        Header("Location: ../login.php?login=failed");
        // echo"you are not logged in";
    }
}

function outputContact(){
    if(isset($_SESSION["contact"])){
      $contact = $_SESSION["contact"];
      echo $contact;
        // Header("Location: ../userpage.php?login=success");

    }else{
        Header("Location: ../login.php?login=failed");
        // echo"you are not logged in";
    }
}
function outputLabel(){
    if(isset($_SESSION["label"])){
      $label = $_SESSION["label"];
      echo $label;
        // Header("Location: ../userpage.php?login=success");

    }else{
        Header("Location: ../login.php?login=failed");
        // echo"you are not logged in";
    }
}

function checkLoginErrors(){
    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];

         foreach ($errors as $error) {
            echo '<p class="form_error">'.$error .'</p>';
        }   

        unset($_SESSION["errors_login"]);
    }
    elseif (isset($_GET["login"]) && $_GET["login"] === "success") {
        
    }
}