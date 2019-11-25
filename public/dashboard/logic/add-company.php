<?php
include_once "../../../app/bootstrap.php";

use app\DataBase\DB;
use util\Company;

$redirect = "../add-company.php?companyAdded=";

foreach($_POST as $value) {
    if (!$value) {
        $_GET['companyAdded'] = "fail";
        returnToPage($redirect . $_GET['companyAdded']);
        return;
    } 
} 

$companyDetails = $_POST;
$companyDetails['owner_id'] = $_SESSION['userData']['id'];

$db = new DB();
$db->createCompany($companyDetails);

$_GET['companyAdded'] = "success";
returnToPage($redirect . $_GET['companyAdded']);

// function returnToPage() {
//     header("location: ../add-company.php?companyAdded=" . $_GET['companyAdded']);
// }