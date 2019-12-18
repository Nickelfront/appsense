<?php

use entity\User;

include_once "../../app/bootstrap.php";

// $userToken = getallheaders()['user-token']; 
$userToken = $_POST['user-token'];
$user = User::getUserByToken($userToken);

if ($user->get('user_type_id') == 1) { // Company owner
    $companyId = $_POST['company-id'];
} else {
    $employee = $user->getEmployeeData();
    $companyId = $employee->get('company_id');
}

// $colleagues = $db->listAllEmployees($employee['company_id']);
// $approvedAbsenceRequests = $db->getApprovedAbsences($employee->get('company_id'));
// show($approvedAbsenceRequests);
$query = "SELECT absence_type_id, user_id, from_date, to_date FROM absence_requests ar JOIN employees e ON ar.employee_id = e.id WHERE ar.status_id = 3 AND e.company_id = " . $companyId;
// show($query);
$approvedAbsenceRequests = $db->searchInDB($query);
// show($approvedAbsenceRequests);
$results = array();
// $index = 0;
foreach ($approvedAbsenceRequests as $index => $absence) {
    $user = new User($absence['user_id']);
    $results[$index]['title'] = $user->get('first_name') . " " . $user->get('last_name');
    $results[$index]['start'] = $absence['from_date'];
    $results[$index]['end'] = $absence['to_date'];
    // $index++;
}

header("Content-Type: application/json");

echo json_encode($results); 