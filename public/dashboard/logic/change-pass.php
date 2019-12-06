<?php

include_once "../../../app/bootstrap.php";

$currentPass = $_POST['currentPassword'];

$result = "fail";
if (password_verify($currentPass, $currentUser->get('password'))) {
    $newPass = $_POST['newPassword'];
    $currentUser->updateField("password", password_hash($newPass, PASSWORD_BCRYPT));
    $result = "success";
}

returnToPage("../edit-profile.php?changedPassword=$result");
