<?php

include_once "../../../app/bootstrap.php";

use Util\FileManager;

if (isset($_GET['user'])) {	
	if (FileManager::deleteFromFS($currentUser->get('avatar'))) {
		$db->updateUserField($currentUser->get('id'), "avatar", null);
		$result = "success";
	} else {
		$result = "fail";
	}

	returnToPage("../edit-profile.php?removed=" . $result);
} else if (isset($_GET['company-id'])) {
	
	if ($db->update("companies", "logo", null, "id", $_GET['company-id'])) {
		$result = "success";
	}
	
	returnToPage("../edit-company.php?id=" . $_GET['company-id'] . "&removed=" . $result);
} else {
	returnToPage("../index.php");
}