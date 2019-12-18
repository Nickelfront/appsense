<?php

include_once "../../../app/bootstrap.php";
use entity\Company;
use Util\FileManager;

// show($_POST);
// if ($_POST['upload-type'] == 'user') {
$baseUploadDir = "uploads". DIRECTORY_SEPARATOR;

if (isset($_FILES['user-avatar'])) {
	$avatar = $_FILES['user-avatar'];
	$path = $avatar['name'];
	$ext = pathinfo($path, PATHINFO_EXTENSION);

	$uploadDir = $baseUploadDir . "users";
	$fileName = $currentUser->get('id') . "_" . generateRandomString() . "_" . date_format(new DateTime(), "Y-m-d/H:m:s");
	// show($fileName);
	$hashFileName = hash('ripemd160', $fileName) . "." . $ext;
	// show($hashFileName);

	if ($filePath = FileManager::upload($avatar, $hashFileName, $uploadDir)) {
		if ($currentUser->get('avatar') != null) {
			$oldPic = ("../" . $currentUser->get('avatar'));
			unlink($oldPic); // TODO make a delete function?
		}
		$db->updateUserField($currentUser->get('id'), "avatar", "../../" . $filePath);
		$result = "success";
	} else {
		$result = "fail";
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
			$oldPic = ("../" . $company->get('logo'));
			unlink($oldPic); // TODO make a delete function?
		}
		$db->update("companies", "logo", "../../" . $filePath, "id", $companyId);
		$result = "success";
	} else {
		$result = "fail";
	}
	returnToPage("../edit-company.php?id=" . $companyId . "&upload=" . $result);

}