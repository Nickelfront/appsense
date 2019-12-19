<?php

use app\DataBase\DB;
use Util\DateTimeUtil;
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
$thisMonth = DateTimeUtil::getMonth($now,'name');

$lastMonth = DateTimeUtil::getMonthsBefore($now, "1", "name");
$secondToLastMonth = DateTimeUtil::getMonthsBefore($now, "2", "name");

$monthlyStats = array(
    $thisMonth => array(
        "vacation" => 0,
        "sickness" => 0,
        "school" => 0,
        "work from home" => 0
    ),
    $lastMonth => array(
        "vacation" => 0,
        "sickness" => 0,
        "school" => 0,
        "work from home" => 0
    ),
    $secondToLastMonth => array(
        "vacation" => 0,
        "sickness" => 0,
        "school" => 0,
        "work from home" => 0
    )
);

$db = new DB();

foreach ($companies as $company) {
    $query = "SELECT absence_type_id, from_date, to_date FROM absence_requests ar JOIN employees e ON ar.employee_id = e.id WHERE e.company_id = " . $company->get('id');
    $absences = $db->searchInDB($query);
    foreach ($absences as $absence) {
        $month = DateTimeUtil::getMonth(DateTimeUtil::stringToDateTime($absence['from_date']), 'name');
        $absenceType = strtolower($db->getType("absence", $absence['absence_type_id']));
        $monthlyStats[$month][$absenceType]++;
        
        $month = DateTimeUtil::getMonth(DateTimeUtil::stringToDateTime($absence['to_date']), 'name');
        $absenceType = strtolower($db->getType("absence", $absence['absence_type_id']));
        $monthlyStats[$month][$absenceType]++;
    }
}

header("Content-Type: application/json");
echo json_encode($monthlyStats);

exit();