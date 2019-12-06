<?php

if (!function_exists("show")) {
    function show($data) {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";            
        die();
    }
}

/**
 * Checks two given strings for literal equality
 * @return boolean 
 */
function compareStrings(string $str1, string $str2) {
    return strcmp($str1, $str2) == 0;
}

function fillTemplate(string $template, string $placeholder, string $replacement) {
    return str_replace($placeholder, $replacement, $template);
}

/**
 * NOTE: the keys in the associative arrays must be the same in order to replace the placeholders with the corresponding data
 * @param string $template the HTML to fill with data
 * @param array $placeholders an associative array of all placeholders in the template
 * @param array $data an associative array the data to put on the corresponding placeholders
 * @return string the filled template ready to be printed into the HTML
 */
function fillTemplateWithData(string $template, array $placeholders, array $data) {
    $templateWithData = $template;
    foreach ($placeholders as $key => $placeholderString) {
        $templateWithData = fillTemplate($templateWithData, $placeholderString, $data[$key]);
        // show($template);
    }
    return $templateWithData;
}

function returnToPage($pathToPage) {
    header("location: $pathToPage");    
}