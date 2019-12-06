<?php

use app\DataBase\DB;
use entity\User;

include_once "../../app/bootstrap.php";
        
$userEmail = $_POST['email'];
$db = new DB();

$correctPass = verifyUser($db, $userEmail, $_POST['pass']);

if ($correctPass) {
    $_SESSION['loggedIn'] = true;
} else {
    $endpoint = "../login.php?incorrect";
}

if ($_SESSION['loggedIn']) {

    $loggedInUser = User::getUserByEmail($userEmail);
    
    $_SESSION['id'] = $loggedInUser->get('id');
    $token = generateToken();
    $loggedInUser->updateField("login_token", $token);
    
    $_SESSION['login_token'] = $token;
    // show($_SESSION);
    // fillUserDataForSession($userEmail, $db); 
    // cleanUserData($_SESSION['userData']);
    $endpoint = "../dashboard/index.php";

    // show($_SESSION['userData']);
}

header("location: $endpoint");

function verifyUser($db, $userEmail, $userPass) {
    return password_verify($userPass, $db->findUserPass($userEmail));
}

function generateToken() {
    $token = bin2hex(random_bytes(64));
    $token = base64_encode($token);
    
    return $token;
}

//TODO delete
function fillUserDataForSession($userEmail, $db) {
    $_SESSION['userData'] = $db->findRecord("users", "email='$userEmail'");
    $userId = $_SESSION['userData']['id'];
    $_SESSION['userData']['user_type'] = $db->getType("user", $_SESSION['userData']['user_type_id']);
    $_SESSION['userData']['login_token'] = generateToken();

    $db->setToken($userId, $_SESSION['userData']['login_token']);
    
    $employeeData = $db->findRecord("employees", "user_id='$userId'");
    if ($employeeData) {
        $employeeData['employee_id'] = $employeeData['id'];
        // $employeeData['company'] = $db->getCompany($employeeData['company_id']);
    } else {
        $employeeData['employee_id'] = 0;
        $_SESSION['userData']['position'] = $_SESSION['userData']['user_type'];
        // TODO is this the best approach or is it useless?
    }
    
    $_SESSION['userData'] = array_merge($_SESSION['userData'], $employeeData);    
    $_SESSION['userData']['id'] = $userId;

    $_SESSION['userData']['position'] = $db->getType("position", $_SESSION['userData']['position_id']);
    
}

function cleanUserData() {
    $fieldsToRemove = array(
        'password'
    );

    foreach ($fieldsToRemove as $field) {
        // unset($userData[$field]);
        unset($_SESSION['userData'][$field]);
    }   
    // return $userData;
}
