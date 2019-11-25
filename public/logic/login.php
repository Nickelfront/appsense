<?php

use app\DataBase\DB;

include_once "../../app/bootstrap.php";
        
$userEmail = $_POST['email'];

$correctPass = verifyUser($db, $userEmail, $_POST['pass']);

if ($correctPass) {
    $_SESSION['loggedIn'] = true;
} else {
    $endpoint = "../login.php?incorrect";
}

if ($_SESSION['loggedIn']) {
    $endpoint = "../dashboard/index.php";

    $_SESSION['userData'] = $db->findRecord("users", "email='$userEmail'");
    // $_SESSION['loggedUserEmail'] = $userEmail;
}

header("location: $endpoint");

function verifyUser($db, $userEmail, $userPass) {
    return password_verify($userPass, $db->findUserPass($userEmail));
}