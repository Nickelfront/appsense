<?php

use entity\User;

include_once "../../app/bootstrap.php";

$userToken = getallheaders()['user-token']; 
$user = User::getUserByToken($userToken);

$vacations = 0;
$workFromHome = 0;
$sicknesses = 0;
$school = 0;

$companies = $user->getCompanies();

$now = new DateTime();
$thisMonth = $now->format("n");
$secondMonth = $now->format("n")-1;
$thirdMonth = $now->format("n")-2;

$monthlyStats = array(
    $thisMonth => array(),
    $secondMonth => array(),
    $thirdMonth => array()
);
//TODO GET FOR EACH OF THREE MONTHS
foreach ($companies as $company) {
    $query = "SELECT absence_type_id, from_date, to_date FROM absence_requests ar JOIN employees e ON ar.employee_id = e.id WHERE e.company_id = " . $company->get('id');
    $absences = $db->searchInDB($query);
    foreach ($absences as $absence) {
        $absenceType = $absence['absence_type_id'];
        switch($absenceType) {
            case 1:
                $vacations++;
                break;
            case 2:
                $sicknesses++;
                break;
            case 3:
                $school++;
                break;
            case 4:
                $workFromHome++;
                break;
            default:
                break;
        }
    }
}


$statistics = array(
    "vacation" => $vacations,
    "sickness" => $sicknesses, 
    "school" => $school,
    "home" => $workFromHome 
);

header("Content-Type: application/json");
echo json_encode($statistics);

exit();