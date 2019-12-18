<?php
include_once "../../app/bootstrap.php";
$query = "SELECT e.id FROM employees e JOIN users u ON e.user_id = u.id where user_type_id <> 1";
// $hrs = $db->searchInDB("SELECT e.`id` FROM `users` u JOIN `employees` e ON e.`user_id` = u.`id` WHERE `user_type_id` <> 1");
$hrs =  $db->searchInDB($query);
$counter = 0;
foreach ($hrs as $hr) {
    echo $hr['id'] . "|";
    $counter++;
}
echo "\n" . $counter . " results.";
die();
// $table = $_POST['db_table'];
// if (isset($_FILES['db_records_file'])) {
//     $recordsFile = $_FILES['db_records_file'];
//     $separator = "\n";
//     $content = file_get_contents($recordsFile['tmp_name']);
//     $records = explode($separator, $content);
//     $query = "INSERT INTO business_types (`name`) VALUES (";

//     $count = 0;
//     foreach ($records as $record) {
//         // echo $record;
//         // echo $count++;
//         // echo $query . trim($record) . ")";
//         // $db->create($query, array(trim($record)));
//    }

//    echo "Done";
// }
