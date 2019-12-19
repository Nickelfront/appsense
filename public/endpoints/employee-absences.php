<?php

use entity\User;

include_once "../../app/bootstrap.php";

$userToken = getallheaders()['user-token']; 
$user = User::getUserByToken($userToken);

$employee = $user->getEmployeeData();
$results = $db->searchInDB("SELECT * FROM absence_requests WHERE employee_id = " . $employee->get('id') . " AND status_id = 4");

foreach($results as $result) {
    show($results);
}