<?php

namespace util;

class FileManager {
    
    // TODO:
    // upload file to path
    public static function upload($file, $customFileName = null, $uploadDir = null) {
        $fileName = $customFileName ? $customFileName : "";
        // if ($uploadDir) {
            // $uploadDir = getBaseDir() . $uploadDir;
            // show($uploadDir);
        // }
        if ($file['error'] == 0) {
            if ($uploadDir) {
                // store in custom destination, under custom (or the same) name.
                if (move_uploaded_file($file["tmp_name"], getBaseDir() . $uploadDir . DIRECTORY_SEPARATOR . $fileName)) {
                    return $uploadDir . DIRECTORY_SEPARATOR . $fileName;
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

    }

}