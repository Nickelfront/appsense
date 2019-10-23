<?php
namespace util;

class Template {

    public static function header($pageName, $templateDir) {
        $header = self::getTemplate(getBaseDir($templateDir) . "template-header.html");
        $header = self::setTitle($header, $pageName);
        return $header;
    }

    public static function footer($templateDir) {
        return self::getTemplate(getBaseDir($templateDir) . "template-footer.html");
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
