<?php
namespace app\Configuration;
use LazyProperty\LazyPropertiesTrait;

class Configuration {

    private static $configurations;

    private static function init() {
        $path = getBaseDir() . "app" . DIRECTORY_SEPARATOR . "Configuration" . DIRECTORY_SEPARATOR . "config.json";
        $json = file_get_contents($path);
        self::$configurations = json_decode($json, true);
    }

    static function get(string $property) {
        if (!self::$configurations) {
            self::init();
        } 
        return self::$configurations[$property];
    }

}
