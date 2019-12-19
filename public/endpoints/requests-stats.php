<?php

use entity\AbsenceRequest;
use entity\User;
use util\DateTimeUtil;

include_once "../../app/bootstrap.php";

$userToken = getallheaders()['user-token']; 
$user = User::getUserByToken($userToken);

$reviewedRequests = AbsenceRequest::getReviewedRequests($user->get('id'));

$now = new DateTime();

$monthlyStats = array();
$i = 6;
while ($i > 0 ) {
    $month = DateTimeUtil::getMonthsBefore($now, $i, "name");
    $monthlyStats[$month] = array(
        "approved" => 0,
        "rejected" => 0
    ); 
    $i--;
}

$thisMonth = DateTimeUtil::getMonth($now, 'name');
$monthlyStats[$thisMonth] = array(
    "approved" => 0,
    "rejected" => 0
); 

foreach ($reviewedRequests['approved'] as $request) {
    $dt = DateTimeUtil::stringToDateTime($request['from_date']);
    $monthlyStats[DateTimeUtil::getMonth($dt, "name")]['approved']++;
}

foreach ($reviewedRequests['rejected'] as $request) {
    $dt = DateTimeUtil::stringToDateTime($request['from_date']);
    $monthlyStats[DateTimeUtil::getMonth($dt, "name")]['rejected']++;
}

header("Content-Type: application/json");
echo json_encode($monthlyStats);

exit();