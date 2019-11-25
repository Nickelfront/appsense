<?php

namespace util;

class Session {
    
    private $session;

    public function __construct(array $session) {
        $this->session = $session;
    }

    public function get($key) {
        if (isset($this->session[$key])) {
            return $this->session[$key];
        } return null;
    }
    
    // public function __call($name, $arguments)
    // {
    //     echo $name . " has arguments: " . implode(", ", $arguments);
    // }

    public function put($key, $value) {
        $this->session[$key] = $value;
    }
}