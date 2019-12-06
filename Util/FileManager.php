<?php

class FileManager {
    
    // TODO:
    // upload file to path
    public static function upload($file, $customFileName = null, $uploadDir = null) {
        $fileName = $customFileName ? $customFileName : "";
        if ($file['error'] == 0) {
            if ($uploadDir) {
                // store in custom destination, under custom (or the same) name.
                move_uploaded_file($file["tmp_name"], $uploadDir . DIRECTORY_SEPARATOR . $fileName);  
            }
        }
    }

    // open file from path
    public static function open($filePath) {
        return file_get_contents($filePath);
    }

    // resize file if needed

}