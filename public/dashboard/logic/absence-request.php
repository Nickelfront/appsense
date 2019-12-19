<?php

use entity\AbsenceRequest;
use entity\Company;
use util\FileManager;

include_once "../../../app/bootstrap.php";

$requestData = $_POST;
$requestingEmployee = $currentUser->getEmployeeData();
$requestData['employee_id'] = $requestingEmployee->get('id');

if (!isset($requestData['substitute']) || $requestData['substitute'] == "null") {
    unset($requestData['substitute']);
}
// if (!isset($requestData['absence-document']) || $requestData['absence-document'] == "") {
//     $requestData['absence-document'] = null;
// }

$documentPath = null;
if (isset($_FILES)) {
    $baseUploadDir = "uploads". DIRECTORY_SEPARATOR;
    $document = $_FILES['absence-document'];
    $ext = pathinfo($document['name'], PATHINFO_EXTENSION);
    // show($document);
    $fileName = $currentUser->get('id') . "_" . generateRandomString() . "_" . date_format(new DateTime(), "Y-m-d/H:m:s");
	$hashFileName = hash('ripemd160', $fileName) . "." . $ext;

	$uploadDir = $baseUploadDir . "docs";
    if ($filePath = FileManager::upload($document, $hashFileName, $uploadDir)) {
        $requestData['document_path'] = "../../" . $filePath;
    }
}
// $requestData['']
// show($requestData);

if (AbsenceRequest::insertInDB($requestData, $db)) {
    $result = "success";
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
} else {
    $result = "fail";
}
returnToPage("../send-absence-request.php?$result");

