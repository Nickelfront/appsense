<?php

include_once "../../../app/bootstrap.php";

use Util\FileManager;
if (isset($_GET['user'])) {	
	if (unlink("../" . $currentUser->get('avatar'))) {
		$db->updateUserField($currentUser->get('id'), "avatar", null);
		$result = "success";
	} else {
		$result = "fail";
	}

	returnToPage("../edit-profile.php?removed=" . $result);
} else if (isset($_GET['id'])) {

	$db->update("companies", null, "id", $_GET['company-id']);
	$result = "success";
	
	returnToPage("../edit-company.php?id=" . $_GET['company-id'] . "removed=" . $result);
}