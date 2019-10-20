<!-- Includes all required imports -->
<?php
// include "template.php";
include "helper.php";

// spl_autoload();

function getBaseDir($path = null) {
    return dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . (is_null($path) ? "" : $path . DIRECTORY_SEPARATOR);
}

spl_autoload_register(function ($class_name) {
    $class_name = str_replace("\\", DIRECTORY_SEPARATOR, $class_name);

    include_once getBaseDir() . "$class_name.php";
});

