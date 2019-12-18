<?php
namespace util;

use DateTime;

class RegistrationValidator {
    
    // const EMAIL_REGEX = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
    

    public function validate(array $inputs, array $rules) : bool
    {
        return true;
    }

    // key -> value
    // age -> [minAge -> 18, empty -> false]

    public static function validateNotEmpty($input) {
        if ($input == "" || is_null($input)) {
            return false;
        } return true;
    }

    public static function validateAge($input) { // dd/MM/yyyy
        $birthDate = DateTime::createFromFormat('d/m/Y', $input);
        // show($birthDate);
        $currentDate = new DateTime();
        $difference = $currentDate->diff($birthDate)->y;
        return $difference >= 18;
    }
    
    public static function validateEmail($input) {
        return filter_var($input, FILTER_VALIDATE_EMAIL);
    }
    
    public static function validatePhone($input) {
        // $regex = "/\+?([0-9]{2})-?([0-9]{3})-?([0-9]{6,7})/";
        $regex = "/0\d{9}/"; // TODO handle phone formats from different countries; find an html for choosing country codes 

        return (bool) preg_match($regex, $input);          
    }

    public static function validatePassword($password) {
        return strlen($password) >= 8;
    }
    
    public static function validateConfirmedPassword($password, $confPassword) {
        return $password == $confPassword;
    }
}