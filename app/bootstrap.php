<?php
// include "template.php";

use app\DataBase\DB;
use entity\User;

include "util.php";
include "session-loader.php";

// spl_autoload();


function getBaseDir($path = null) {
    return dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . (is_null($path) ? "" : $path . DIRECTORY_SEPARATOR);
}

/**
 *  Declares the way of loading classes
 * 
 *  */
spl_autoload_register(function ($class_name) {
    $class_name = str_replace("\\", DIRECTORY_SEPARATOR, $class_name);
    
    include_once getBaseDir() . "$class_name.php";
});

$db = new DB();

session_start();
if (isset($_SESSION['id'])) {
    $currentUser = new User($_SESSION['id']);
}
