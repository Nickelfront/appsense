<?php

namespace util;

class User {
    
    private $userData;
    private $employeeData;

    public function __construct(array $userData) {
        $this->userData = $userData;
    }

    /**
     * Returns value by a given property
     * @param string $key 
     * @return string if the property exists or null if it doesn't
     */
    public function get($key) {
        if (isset($this->userData[$key])) {
            return $this->userData[$key];
        } return null;
    }

    public function __get($name)
    {
        return $this->get($name);
    
    }

    public function __call($name, $arguments) {
        $db = new DB();
        return $db->$name(...$arguments);
    }

    public function put($key, $value) {
        $this->userData[$key] = $value;
    }
}