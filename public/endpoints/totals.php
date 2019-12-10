<?php

include_once "../../app/bootstrap.php";

$companies = $currentUser->getCompanies();

$totalUsedDaysOff = 0;
$totalWorkHours = 0;
$totalPendingRequests = 0;

foreach ($companies as $company) {
    $employees = $company->getAllemployees();
    foreach ($employees as $employee) {
        $totalUsedDaysOff += $employee->get('used_days_off');
        $employeeActualWorkHours = calculateActualWorkedHours($employee);
        $totalWorkHours += $employeeActualWorkHours;
        $absences = $employee->getAbsences();
        foreach ($absences as $absence) {
            if ($absence['status_id'] < 3) {
                $totalPendingRequests++;
            }
        }
    }
}


$statistics = array(
    "totalAbsences" => $totalUsedDaysOff,
    "totalWorkHours" => $totalWorkHours, 
    "totalPendingRequests" => $totalPendingRequests, 
);

header("Content-Type: application/json");
echo json_encode($statistics);

exit();


function calculateActualWorkedHours($employee) {
    $now = new DateTime();
    $workingWeeks = datediffInWeeks($employee->getUserData()->get('created_at'), $now->format('Y-m-d H:i:s'));
    $dailyWorkHours = $employee->get('work_hours_per_day');
    $workingHours = $dailyWorkHours * 5 * $workingWeeks; // 5 WORKING DAYS
    $actualWorkedHours = $workingHours - ($employee->get('used_days_off') * $dailyWorkHours);
    return $actualWorkedHours;
}
