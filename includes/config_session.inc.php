<?php

ini_set("session.use_only_cookies",1);
ini_set("session.use_strict_mode",1);

session_set_cookie_params([
    "lifetime"=> "1800",
    "domain"=> "localhost",
    "path"=> "/",
    "secure"=> true,
    "httponly"=> true,
]);

session_start();

// checking if the user is login to the website
if (isset($_SESSION["userId"])){
    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id_loggedin();
    } else {
        $interval = 60 * 30; // generate new id every 30min
        if(time() -  $_SESSION["last_regeneration"] >= $interval){
        regenerate_session_id_loggedin();
        }
    }

} else {
    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id();
    } else {
        $interval = 60 * 30; // generate new id every 30sec
        if(time() -  $_SESSION["last_regeneration"] >= $interval){
         regenerate_session_id();
        }
    }
}


function regenerate_session_id_loggedin() {
    $userId = $_SESSION["user_id"];
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $userId;
    session_id($sessionId);
    
    $_SESSION["last_regeneration"] = time();
}

function regenerate_session_id(){
    session_regenerate_id(true);    
    $_SESSION["last_regeneration"] = time();
}