<?php

use entity\AbsenceRequest;
use entity\Company;

include_once "../../../app/bootstrap.php";

$requestData = $_POST;
$requestingEmployee = $currentUser->getEmployeeData();
$requestData['employee_id'] = $requestingEmployee->get('id');

if (!isset($requestData['substitute']) || $requestData['substitute'] == "null") {
    unset($requestData['substitute']);
}
if (!isset($requestData['absence-document']) || $requestData['absence-document'] == "") {
    $requestData['absence-document'] = null;
}

// $requestData['']
// show($requestData);

AbsenceRequest::insertInDB($requestData, $db);
$company = new Company($requestingEmployee->get('company_id'));
$hrs = $company->getHumanResourcesEmployees();

foreach ($hrs as $hr) {
    $notificationData = array(
        $hr->get('id'),
        $requestData['employee_id'],
        $db->getLastInsertedID()
    );
    $db->createAbsenceRequestNotification($notificationData);
}

header("location: ../send-absence-request.php?success");

