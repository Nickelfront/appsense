<?php
    include_once "../../app/bootstrap.php";
    
    $userEmail = $_POST['email'];
    $userPass = password_hash($_POST['pass'], PASSWORD_BCRYPT); 
    
    session_start();
    // show($_SESSION);

    if (!$userEmail && $userPass) { // TODO if user email and pass are the correct
        $_SESSION['loggedIn'] = true;
        // header ("location: ../welcome.php");    
    } else {
        header("location: ../login.php?incorrect");
    }

    if ($_SESSION['loggedIn']) {
        // load user page
    }

