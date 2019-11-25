<?php
include_once "../../app/bootstrap.php";

use app\DataBase\DB;
use util\RegistrationValidator;
use util\Mail;

if (isset($_SESSION['oldValues']))
    unset($_SESSION['oldValues']);

if (isset($_SESSION['errorMessages']))
    unset($_SESSION['errorMessages']);

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

    unset($_SESSION['errorMessages']);    
    unset($_SESSION['oldValues']);    

    $db = new DB();
    $userData = array($firstName, $lastName, $email, password_hash($password, PASSWORD_BCRYPT), $gender, $phone, "1");
    $db->createUser($userData);

    $endpoint = "../index.php";
    // header("location: ../contact.php");

    // TODO send confirmation email
    // $message = "Hello there, $firstName $lastName. You have been registered for our services. Please verify your registration here: http://google.com/";
    // Mail::send("runawaygirl196@gmail.com", $email, "Registration confirmation", $message);

} catch (Exception $e) {
    // show($e);
    $_SESSION['errorMessages'] = $errorMessages;
 
    $_SESSION['oldValues'] = $_POST;

    $endpoint = "../register.php?invalid";
    // header("location: ../register.php?invalid");
}

// finally:
header("location: $endpoint");


function saveErrorMessage(&$errorMessages, $inputType, $message) {
    $errorMessages[$inputType] = $message;
}