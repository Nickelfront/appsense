<?php

include_once "../../../app/bootstrap.php";
use entity\Company;
use Util\FileManager;

$baseUploadDir = "uploads". DIRECTORY_SEPARATOR;

$result = "fail";
if (isset($_FILES['user-avatar'])) {

	$avatar = $_FILES['user-avatar'];
	$path = $avatar['name'];
	$ext = pathinfo($path, PATHINFO_EXTENSION);

	$uploadDir = $baseUploadDir . "users";
	$fileName = $currentUser->get('id') . "_" . generateRandomString() . "_" . date_format(new DateTime(), "Y-m-d/H:m:s");
	$hashFileName = hash('ripemd160', $fileName) . "." . $ext;
	
	if ($filePath = FileManager::upload($avatar, $hashFileName, $uploadDir)) {
		if ($currentUser->get('avatar') != null) {
			FileManager::deleteFromFS($currentUser->get('avatar')); 
		}

		$db->updateUserField($currentUser->get('id'), "avatar", "../../" . $filePath);
		$result = "success";
	}
	returnToPage("../edit-profile.php?upload=" . $result);

} else if (isset($_FILES['company-logo'])) {
	$logo = $_FILES['company-logo'];
	$path = $logo['name'];
	$ext = pathinfo($path, PATHINFO_EXTENSION);

	$companyId = $_POST['company-id'];

	$uploadDir = $baseUploadDir . "companies";
	$fileName = $companyId . "-" . $currentUser->get('id') . "_" . generateRandomString() . "_" . date_format(new DateTime(), "Y-m-d/H:m:s");
	$hashFileName = hash('ripemd160', $fileName) . "." . $ext;
	
	$company = new Company($companyId);
	if ($filePath = FileManager::upload($logo, $hashFileName, $uploadDir)) {
		if ($company->get('logo') != null) {
			FileManager::deleteFromFS($company->get('logo'));
		}
		if ($db->update("companies", "logo", "../../" . $filePath, "id", $companyId)) {
			$result = "success";
		} 
	}
	returnToPage("../edit-company.php?id=" . $companyId . "&upload=" . $result);

} else {
	returnToPage("../index.php");
}