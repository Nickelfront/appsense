<?php
namespace util;

class Template {

    public static function header($pageName, $templateDir) {
        $header = self::content($templateDir, "template-header.html");
        $header = self::setTitle($header, $pageName);
        return $header;
    }

    public static function footer($templateDir) {
        return self::content($templateDir, "template-footer.html");
    }

    public static function content($templateDir, $templateFileName) {
        return self::getTemplate(getBaseDir($templateDir) . $templateFileName);
        // include_once getBaseDir($templateDir) . $templateFileName;
    }

    private static function getTemplate($templateFile) {
        $templateContent = "";
        if (file_exists($templateFile)) {
            $templateContent = file_get_contents($templateFile);
        }
        return $templateContent;
    }


    private static function setTitle($source, $pageName) {
        return str_replace("{page_name}", $pageName, $source);
    }
}
