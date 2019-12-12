<?php

namespace entity;

use app\DataBase\DB;

class User extends Entity {
    
    public function __construct($userId) {
        $this->tableName = "users";
        parent::__construct($userId);
        // $this->data = $this->db->getUserData($userId);
    }
    
    public function getUserType() {
        return $this->db->getType("user", $this->get('user_type_id'));
    }

    public function getCompanies() {
        $companies = null;
        if ($this->get('user_type_id') == 1) {
            $query = "SELECT id FROM companies WHERE owner_id = " . $this->get('id');
            $results = $this->db->searchInDB($query);
            
            $companies = array();
            foreach($results as $result) {
                $companies[] = new Company($result['id']);
            }
        } return $companies;
    }

    public function getEmployeeData() {
        $query = "SELECT id FROM employees WHERE user_id = " . $this->get('id');
        $employeeId = $this->db->searchInDB($query);
        return new Employee($employeeId);
    }

    public static function getUserByEmail($userEmail) {
        $db = new DB();
        return new User($db->getUserIdByEmail($userEmail));
    }

    public static function getUserByToken($userToken) {
        $db = new DB();
        return new User($db->getUserIdByToken($userToken));
    }

    public static function insertInDB($newUserData, $db) {
        $query = "INSERT INTO users (`first_name`, `last_name`, `email`, `password`, `gender`, `phone`, `user_type_id`) VALUES (";        
        return $db->create($query, $newUserData);
    }

    public function getColleagues() {
        $companyId = $this->getEmployeeData()->get('company_id');
        $colleagues = $this->db->listAllEmployees($companyId);
        
        // show($colleagues);
        // foreach ($colleagues as $colleague) {
        //     if ($colleague->get('id') == $this->get('id')) {
        //         $
        //     }
        // }
        return $colleagues;
    }

    public function getColleaguesWithThisPosition() {
        $colleagues = $this->getColleagues();
        $colleaguesWithThisPosition = array();
        foreach ($colleagues as $colleague) {
            if ($colleague['position_id'] == $this->getEmployeeData()->get('position_id')) {
                $colleaguesWithThisPosition[] = $colleague;
            }
        }
        return $colleaguesWithThisPosition;
    }

    public function isInCompany($userId) {
        if ($userId == $this->get('id')) {
            return true;
        }
        if ($this->get('user_type_id') == 1) {
            $companies = $this->getCompanies();
            $isEmployee = false;
            foreach ($companies as $company) {
                $employees = $company->getAllEmployees();
                foreach($employees as $employee) {
                    if ($employee->get('id') == $userId) {
                        $isEmployee = true;
                        break;
                    }
                }
            }
            return $isEmployee;
        } else {
            // $company = new Company($this->e('company_id'));
            
            $colleagues = $this->getColleagues();
            $isColleague = false;
            foreach($colleagues as $colleague) {
                if ($colleague['id'] == $userId) {
                    $isColleague = true;
                    break;
                }
            }
            return $isColleague;
        }
    }

} 