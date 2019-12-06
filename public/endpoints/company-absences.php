<?php
include_once "../../app/bootstrap.php";

$userToken = $_POST['user_token']; 
// $userToken = getallheaders()['user-token']; 
$user = $db->findRecord("users", "login_token='$userToken'");

if ($user['user_type_id'] == 1) {
    $companyId = "TODO";
} else {
    $employee = $db->getEmployeeByUserId($user['id']);
}

// $colleagues = $db->listAllEmployees($employee['company_id']);
$approvedAbsenceRequests = $db->getApprovedAbsences($employee['company_id']);
// show($approvedAbsenceRequests);
$results = array();

foreach ($approvedAbsenceRequests as $employeeAbsences) {
    foreach ($employeeAbsences as $employeeAbsence) {
        $employeeId = $employeeAbsence["employee_id"];
        $employeeUser = $db->getUserByEmployeeId($employeeId);
        // TODO refactor
        $requestDetails[] = array(
            "title" => $employeeUser["first_name"] . " " . $employeeUser["last_name"],
            "start" => $employeeAbsence["from_date"],
            "end" => $employeeAbsence["to_date"]
        );
        $results[] = $requestDetails;
    }
}

header("Content-Type: application/json");

echo json_encode($results[0]); // TODO why 0?

// exit();
// [
//     [
//         {
//             "title":"ya Plat",
//             "start":"2019-11-16",
//             "end":"2019-11-30"
//         }
//     ]
// ]