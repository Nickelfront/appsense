<?php
include_once "../../app/bootstrap.php";

// $table = $_POST['db_table'];
if (isset($_FILES['db_records_file'])) {
    $recordsFile = $_FILES['db_records_file'];
    $content = file_get_contents($recordsFile['tmp_name']);
    $positions = explode("\n", $content);
    $query = "INSERT INTO users (`name`) VALUES (";

    foreach ($positions as $position) {
        echo $query;
        // $db->create($query, array($position));

   }

   echo "Done";
}