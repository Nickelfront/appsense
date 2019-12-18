<?php
include_once "../../../app/bootstrap.php";

use entity\Company;

$company = new Company($_GET['id']);
// show($company);
$newValues = array();
$newValues['name'] = $_POST['companyName'];
$newValues['business_type_id'] = $_POST['business_type_id'];
$newValues['address'] = $_POST['companyAddress'];
$newValues['status'] = $_POST['companyStatus'];

// show($newValues);
foreach ($newValues as $key => $value) {
	if ($value == null || $value == "" ) {
		$result = "fail";
		break;
	}
    if ($company->get($key) != $value) {
    	// show($value);
        $company->updateField($key, $value);
        $result = "success";
    } 
}
$page = "../edit-company.php?id=". $_GET['id'];
if ($result) {
	$page .= "&updatedDetails=$result";
}
returnToPage($page);