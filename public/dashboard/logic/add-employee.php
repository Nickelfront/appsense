<?php
include_once "../../../app/bootstrap.php";

use app\DataBase\DB;
use util\Company;

$redirect = "../add-employee.php?employeeAdded=";

foreach($_POST as $key => $value) {
    if ($key != "text") {
        if (!$value) {
            $_GET['employeeAdded'] = "fail";
            returnToPage($redirect . $_GET['employeeAdded']);
            return;
        } 
    }
} 

$tempPass = generateRandomString();
$userData = array(
    $_POST['first_name'],
    $_POST['last_name'],
    $_POST['email'],
    // password_hash($tempPass, PASSWORD_BCRYPT),
    password_hash("123", PASSWORD_BCRYPT),
    null,
    $_POST['phone'],
    2 //TODO dont hardcode user type id
);
// show($userData);
$db = new DB();
// show($db -> createUser($userData));
$db->createUser($userData);

$newUserId = $db->getUser($_POST['email'])->get('id');
// show($newUserId->get('id'));
$employeeData = array(
    $newUserId,
    $_POST['company'],
//    $_POST['position'], //TODO
    2,
    $_POST['available_days_off'],
    $_POST['work_hours_per_day'],
);

// show ($employeeData);
$db->createEmployee($employeeData);
$_GET['employeeAdded'] = "success";

returnToPage($redirect . $_GET['employeeAdded']);

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}