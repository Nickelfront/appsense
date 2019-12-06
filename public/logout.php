<?php 
include_once "../app/bootstrap.php";

$db->setToken($_SESSION['id'], null);

unset($_SESSION);
session_destroy();

header("location: index.php");
