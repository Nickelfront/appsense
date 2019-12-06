<?php
include_once "../../../app/bootstrap.php";

$newValues = array();

$newValues['phone'] = $_POST['phone-number']; 
$newValues['gender'] = $_POST['gender'];

foreach ($newValues as $key => $value) {
    if ($currentUser->get($key) != $value) {
        $currentUser->updateField($key, $value);
        $result = "success";
        $now = date_format(new DateTime(), "Y-m-d H:m:s");
        $currentUser->updateField("updated_at", $now);
    }
}

returnToPage("../edit-profile.php?updatedDetails=$result");