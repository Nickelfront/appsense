<?php

namespace util;

class FileManager {
    
    public static function upload($file, $customFileName = null, $uploadDir = null) {
        $fileName = $customFileName ? $customFileName : "";

        if ($file['error'] == 0) {
            if ($uploadDir) {
                // store in custom destination, under custom (or the same) name.
                // show(move_uploaded_file($file["tmp_name"], getBaseDir() . $uploadDir . DIRECTORY_SEPARATOR . $fileName));
                if (move_uploaded_file($file["tmp_name"], getBaseDir() . $uploadDir . DIRECTORY_SEPARATOR . $fileName)) {
                    $filePath = str_replace("\\", "/", $uploadDir . DIRECTORY_SEPARATOR . $fileName);
                    return $filePath;
                } 
            }
        } 
        return false;
    }

    // open file from path
    public static function open($filePath) {
        return file_get_contents($filePath);
    }

    // resize file if needed
    public static function resize($file) {
        //TODO
    }

    public static function deleteFromFS($file) {
        return unlink("../" . $file);
    }

}