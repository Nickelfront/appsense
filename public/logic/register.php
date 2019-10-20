<?php
include_once "../../app/bootstrap.php";

use util\RegistrationValidator;
// show($_POST);

if (isset($_SESSION['oldValues']))
    unset($_SESSION['oldValues']);

if (isset($_SESSION['errorMessages']))
    unset($_SESSION['errorMessages']);

session_start();

// $method = "validate";
// $validator = new RegistrationValidator();
// show($validator->$method("asdd"));

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$birthDate = $_POST['birthday'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$confPassword = $_POST['conf_pass'];

$errorMessages = array();
try {

    foreach($_POST as $key => $value) {
        if (!RegistrationValidator::validateNotEmpty($value)) {
            $message = "This field is required.";
            // saveErrorMessage($errorMessages, "general", $message);
            saveErrorMessage($errorMessages, "general_$key", $message);
            // show($errorMessages);
            // $errorMessages[] = $message;
            throw new Exception($message);
        }
    }

    if (!RegistrationValidator::validateAge($birthDate)){
        $message = "You must be 18 or older to access our services.";
        saveErrorMessage($errorMessages, "birthday", $message);
    }
    if (!RegistrationValidator::validateConfirmedPassword($password, $confPassword)){
        $message = "Passwords do not match.";
        saveErrorMessage($errorMessages, "conf_pass", $message);
    }
    if (!RegistrationValidator::validatePassword($password)){
        $message = "Password must be longer than 8 characters.";
        saveErrorMessage($errorMessages, "password", $message);
    }
    if (!RegistrationValidator::validateEmail($email)) {
        $message = "Invalid email format.";
        saveErrorMessage($errorMessages, "email", $message);
    }
    if (!RegistrationValidator::validatePhone($phone)) {
        $message = "Invalid phone format.";
        saveErrorMessage($errorMessages, "phone", $message);
    }

    if (!empty($errorMessages)) {
        throw new Exception("Registration validation failed.");
    }
    
    header("location: ../contact.php");

} catch (Exception $e) {
    // $_SESSION['errors'] = [$e->getCode() => $e->getMessage()];
    $_SESSION['errorMessages'] = $errorMessages;
 
    $_SESSION['oldValues'] = $_POST;
    header("location: ../register.php?invalid");
}

function saveErrorMessage(&$errorMessages, $inputType, $message) {
    $errorMessages[$inputType] = $message;
    // $errorMessages[] = [$inputType => $message];
}