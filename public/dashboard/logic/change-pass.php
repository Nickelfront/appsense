<?php

include_once "../../../app/bootstrap.php";

$currentPass = $_POST['currentPassword'];

$result = "fail";
if (password_verify($currentPass, $currentUser->get('password'))) {
    $newPass = $_POST['newPassword'];
    if ($_POST['newPassword'] != $_POST['confirmedNewPassword']) {
    	$result .= "&reason=noMatch";
    } else if (strlen($newPass) < 6) {
    	$result .= "&reason=shortPass";
    } else {
	    $currentUser->updateField("password", password_hash($newPass, PASSWORD_BCRYPT));
	    $result = "success";
    }
} else {
	$result .= "&reason=wrongPass";
}

returnToPage("../edit-profile.php?changedPassword=$result#passwordChange");
