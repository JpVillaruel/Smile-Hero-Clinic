<?php

declare(strict_types= 1);

function checkAppointErrors(){
    if (isset($_SESSION["errors_appointment"])) {
        $errors = $_SESSION["errors_appointment"];

        foreach ($errors as $error) {
            echo '<p class="form_error">' . $error . ' </p>';
        }   
        unset($_SESSION["errors_appointment"]);
    }else if (isset($_GET["submit"]) && $_GET["submit"] === "success" ) {
        // echo "<br>";
        // echo '<p class="form_success"> Signup Success </p>';
    }
}