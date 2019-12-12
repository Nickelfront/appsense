<?php

use entity\User;

include_once "../../app/bootstrap.php";
        
$userEmail = $_POST['email'];
// $db = new DB();

$correctPass = verifyUser($db, $userEmail, $_POST['pass']);

if ($correctPass) {
    $loggedInUser = User::getUserByEmail($userEmail);
    if ($loggedInUser->getEmployeeCompany()->get('status') != 'active') {
        $endpoint = "../login.php?inactive-company";
    } else {
        $existingToken = ($loggedInUser->get('login_token') != null || $loggedInUser->get('login_token') != "");
        if ($existingToken) {
            returnToPage("../login.php?already-logged-in");
            // die();
        }
        
        $_SESSION['id'] = $loggedInUser->get('id');
        $token = generateToken();
        $loggedInUser->updateField("login_token", $token);
        
        $_SESSION['login_token'] = $token;
        
        $endpoint = "../dashboard/index.php";
        $_SESSION['loggedIn'] = true;
    } 
} else {
    $endpoint = "../login.php?incorrect";
}

returnToPage($endpoint);

function verifyUser($db, $userEmail, $userPass) {
    return password_verify($userPass, $db->findUserPass($userEmail));
}

function generateToken() {
    $token = bin2hex(random_bytes(64));
    $token = base64_encode($token);
    
    return $token;
}