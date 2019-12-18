<?phpCreated
include_once "../../../app/bootstrap.php";

use entity\Employee;
use entity\Position;
use entity\User;

$redirect = "../add-employee.php?employeeAdded=";

foreach($_POST as $key => $value) {
    if ($key != "text") {
        if (!$value) {
            returnToPage($redirect . 'fail' . '&reason=empty');
            return;
        } 
    }
} 

if (User::getUserByEmail($_POST['email'])) {
    // show(User::getUserByEmail($_POST['email']));
    returnToPage($redirect . 'fail' . '&reason=existing');
    die();
}

$position = new Position($_POST['position']);
$isHR = strpos($position->get('name'), "HR ") != -1;

$userTypeId = $isHR ? 2 : 3;

$tempPass = generateRandomString();
$userData = array(
    $_POST['first_name'],
    $_POST['last_name'],
    $_POST['email'],
    // password_hash($tempPass, PASSWORD_BCRYPT),
    password_hash("123", PASSWORD_BCRYPT),
    null,
    $_POST['phone'],
    $userTypeId
);

// $db = new DB();
User::insertInDB($userData, $db);

$newUser = User::getUserByEmail($_POST['email']);
// show($newUser->get('id'));
$employeeData = array(
    $newUser->get('id'),
    $_POST['company'],
    $_POST['position'], 
    $_POST['available_days_off'],
    $_POST['work_hours_per_day'],
);

// show ($employeeData);
Employee::insertInDB($employeeData, $db);

returnToPage($redirect . 'success');

