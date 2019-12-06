<?php

namespace entity;

use app\DataBase\DB;

class User extends Entity {
    
    public function __construct($userId) {
        $this->tableName = "users";
        parent::__construct($userId);
        // $this->data = $this->db->getUserData($userId);
    }

    public function getCompanies() {
        $companies = array();
        if ($this->get('user_type_id') == 1) {
            $results = $this->db->getUserCompanies($this->get('id'));
            foreach($results as $result) {
                $companies[] = new Company($result['id']);
            }
        } return $companies;
    }

    public function getEmployeeData() {
        return new Employee($this->db->getEmployeeByUserId($this->get('id')));
    }

    public static function getUserByEmail($userEmail) {
        $db = new DB();
        return new User($db->getUserIdByEmail($userEmail));
    }

    static function insertInDB($newUserData, $db) {
        $query = "INSERT INTO users (`first_name`, `last_name`, `email`, `password`, `gender`, `phone`, `user_type_id`) VALUES (";        
        return $db->create($query, $newUserData);
    }

    public function isColleague($userId) {
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
            $company = new Company($this->get('company_id'));
            
            $colleagues = $company->getAllEmployees();
            $isColleague = false;
            foreach($colleagues as $colleague) {
                if ($colleague->get('id') == $userId) {
                    $isColleague = true;
                    break;
                }
            }
            return $isColleague;
        }
    }


} 