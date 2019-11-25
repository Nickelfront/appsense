<?php

namespace util;

class Company {
    
    private $details;

    public function __construct(array $details) {
        $this->details = $this->normalize($details);
    }
    
    public function get($key) {
        if (isset($this->details[$key])) {
            return $this->details[$key];
        } return null;
    }
    
    public function put($key, $value) {
        $this->details[$key] = $value;
    }

    private function normalize($details) {
        foreach ($details as $key => $data) {
            $details[$key] = str_replace("'", "\'", $data);
        }
        return $details;
    }
    
}