<?php

if (!function_exists("show")) {
    function show($data) {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";            
        die();
    }
}

function fillTemplate(string $template, string $placeholder, string $replacement) {
    return str_replace($placeholder, $replacement, $template);
}

function fillTemplateWithData(string $template, array $placeholders, array $data) {
    $templateWithData = $template;
    foreach ($placeholders as $placeholderString) {
        // $templateWithData = str_replace($placeholderString);
    }
    return $templateWithData;
}

function returnToPage($pathToPage) {
    header("location: $pathToPage");    
}