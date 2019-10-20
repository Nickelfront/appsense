<?php 

// $name = isset($_POST['name']) ? $_POST['name'] : '';

$html = '<form action="starter.php" method="POST">';
// $html .= '<input type="text" name="name" placeholder="Name" value="' . $name . '">
$html .= '<input type="text" name="name" placeholder="Name">
	</br>
	<input type="text" name="email" placeholder="E-Mail">
	</br>
    <input type="text" name="phone" placeholder="Phone number">
    </br>
	<textarea name="message" placeholder="Message..."></textarea>
    </br>
    
	<input type="checkbox" name="checkboxes[]" value="OPTION 1">
	</br>
	<input type="checkbox" name="checkboxes[]" value="OPTION 2">
	</br>
	<input type="checkbox" name="checkboxes[]" value="OPTION 3">
	</br>
	<input type="submit" name="send" >
</form>
	';
echo $html;

// isset($_GET['name']) or exit;
// isset($_GET['email']) or exit;
// isset($_GET['message']) or exit;

// $name = $_GET['name'];
// $email = $_GET['email'];
// $message = $_GET['message'];

// $phone = $_GET['phone'];

// if (isset($_GET)) {
//    	echo "<pre>";
//    	print_r($_GET);
//   	echo "</pre>";
// }


isset($_POST['name']) or exit;
isset($_POST['email']) or exit;
isset($_POST['message']) or exit;
// isset($_POST['check']) or exit;

if (isset($_POST)) {
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
}

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

echo $name . " с имейл: " . $email . " каза: '" . $message . "'";

// $check = [];

$check = $_POST['checkboxes'];

echo "<pre>";
for ($i = 0; $i < count($check); $i++) { 
	echo "</br> OPTION ". $i . ": " . $check[$i];
}
echo "</pre>";

// if ($name != null && $email != null && $message != null) {
// 	echo $name . ' with e-mail ' . $email . ' has said: ' . $message;
// } else {
// 	echo '<p style="color: red"> Not everything is entered! </p>';
// }

// validate all fields at once

// $fields = array(
// 	'name' => array(0, 100, 1, '/[0-9]+' ),
// 	'email' => array(0, 50, 0, '' )
// 	 );

// foreach ($_POST as $field => $value) {
// 	if (!validate($field, $value)) {
// 		$errors[] = ....;
// 	}
// }