<?php

declare(strict_types= 1); 

// function signupNameInputs(){ // function for keeping the user's input if have an inputting error

//     if(isset($_SESSION["signup_data"]["name"])){
//         echo '<input type="text" placeholder="e.g. Fahatmah Mabang" id="name" name="name"
//         value="' . $_SESSION["signup_data"]["name"] . '"  />';
//     }else{
//         echo '<input type="text" placeholder="e.g. Fahatmah Mabang" id="name" name="name" />';
//     }
// }
    
// function signupEmailInputs(){ // function for keeping the user's input if have an inputting error
//     if(isset($_SESSION["signup_data"]["email"]) 
//     && !isset($_SESSION["errors_signup"]["emailRegistered"])
//     && !isset($_SESSION["errors_signup"]["invalidEmail"]))
//     {
//     echo '<input type="email" placeholder="e.g. fahatmahmabang@gmail.com" id="email" name="email"
//             value="' . $_SESSION["signup_data"]["email"] . '" />';
//     }else{
//     echo '<input type="email" placeholder="e.g. fahatmahmabang@gmail.com" id="email" name="email" />';
//     }
// }
    
// function signupUsernameInputs(){ // function for keeping the user's input if have an inputting error
//     if(isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["usernameTaken"])){
//         echo '<input type="text" placeholder="e.g. Fahatmah Mabang" id="name" name="name" 
//         value = "' . $_SESSION["signup_data"]["username"] . '" />';
//     }else{
//         echo '<input type="text" placeholder="e.g. Fahatmah Mabang" id="name" name="name" />';
//     }
// }
// function signupPasswordInputs(){ // function for keeping the user's input if have an inputting error
//     echo'<input type="password" placeholder="e.g. password" id="password" name="password" />';
// }
    
function checkSignupErrors() {
    if (isset($_SESSION["errors_signup"])) {
        $errors = $_SESSION["errors_signup"];

        foreach ($errors as $index => $error) {
            echo '<p class="form_error" id="form_error">' . $error . ' </p>';
        }
        unset($_SESSION["errors_signup"]);
    } else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        // Handle success case here
    }
}