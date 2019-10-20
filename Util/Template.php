<?php
namespace util;

class Template {

    public static function header() {
        return self::getTemplate(getBaseDir("public") . "template-header.html");
    }

    public static function footer() {
        return self::getTemplate(getBaseDir("public") . "template-footer.html");
    }

    private static function getTemplate($templateFile) {
        $templateContent = "";
        if (file_exists($templateFile)) {
            $templateContent = file_get_contents($templateFile);
        }
        return $templateContent; 
    }
}
