<?php

use entity\User;

include_once "../../app/bootstrap.php";

$userToken = getallheaders()['user-token']; 
$user = User::getUserByToken($userToken);

$db->getNewAbsenceRequests($user['id']);