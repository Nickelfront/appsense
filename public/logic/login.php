<?php

use app\DataBase\DB;

include_once "../../app/bootstrap.php";
        


    $userEmail = $_POST['email'];

    $db = new DB("appsenseDB");
    $correctPass = verifyUser($db, $userEmail, $_POST['pass']);
    
    session_start();
    // show($_SESSION);

    // if ($db->findUser($userEmail, $userPass)) { // TODO if user email and pass are the correct
    if ($correctPass) {
        $_SESSION['loggedIn'] = true;
    } else {
        // header("location: ../login.php?incorrect");
        $endpoint = "../login.php?incorrect";
    }
    
    if ($_SESSION['loggedIn']) {
        // header ("location: ../welcome.php");    
        // load user page
        $endpoint = "../welcome.php";
        
        $_SESSION['userData'] = $db->findRecord("users", "email='$userEmail'");
    }

    header("location: $endpoint");

function verifyUser($db, $userEmail, $userPass) {
    // $db = new DB("appsenseDB");
    return password_verify($userPass, $db->findUserPass($userEmail));
}