<?php
include_once "../../app/bootstrap.php";

$userToken = getallheaders()['user-token']; 
$user = $db->findRecord("users", "login_token='$userToken'");

$db->getNewAbsenceRequests($user['id']);