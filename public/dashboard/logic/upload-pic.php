<?php
use util\FileManager;

include_once "../../../app/bootstrap.php";


// show($_FILES);
$avatar = $_FILES['user-avatar'];
$path = $avatar['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);

$uploadDir = DIRECTORY_SEPARATOR . "uploads". DIRECTORY_SEPARATOR . "users";
$fileName = $currentUser->get('id') . "_" . generateRandomString() . "_" . date_format(new DateTime(), "Y-m-d/H:m:s");
// show($fileName);
$hashFileName = hash('ripemd160', $fileName) . "." . $ext;
// show($hashFileName);
if (FileManager::upload($avatar, $hashFileName, $uploadDir)) {
	$result = "success";
} else {
	$result = "fail";
}

returnToPage("../edit-profile.php?upload=" . $result);