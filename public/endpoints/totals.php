<?php
include_once "../../app/bootstrap.php";

$totalUsedDaysOff = 0;

$companies = $currentUser->getCompanies();
foreach ($companies as $company) {
    $employees = $company->getAllemployees();
    foreach ($employees as $employee) {
        $totalUsedDaysOff += $employee->get('used_days_off');
    }
}

//TODO
$totalWorkHours = 0;

//TODO
$totalPendingRequests = 0;

$statistics = array(
    "totalAbsences" => $totalUsedDaysOff,
    "totalWorkHours" => $totalWorkHours, 
    "totalPendingRequests" => $totalPendingRequests, 
);

header("Content-Type: application/json");
echo json_encode($statistics);

exit();