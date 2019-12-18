<?php
include_once "../../../app/bootstrap.php";

use app\DataBase\DB;
use entity\Company;

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
// $db->createCompany($companyDetails);
Company::insertInDB($companyDetails, $db);

$_GET['companyAdded'] = "success";
returnToPage($redirect . $_GET['companyAdded']);

// function returnToPage() {
//     header("location: ../add-company.php?companyAdded=" . $_GET['companyAdded']);
// }