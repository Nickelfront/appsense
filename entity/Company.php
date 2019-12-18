<?php

namespace entity;

class Company extends Entity {
    
    public function __construct($companyId) {
        $this->tableName = "companies";
        parent::__construct($companyId);
        // $this->data = $this->db->getCompanyData($companyId);
    }

    public function getOwner() {
        return new User($this->get('owner_id'));
    }

    public function getBusinessType() {
        return $this->db->getType("business", $this->get('business_type_id'));
    }

    public function getFirstHR() {
        return $this->getHumanResourcesEmployees() ? $this->getHumanResourcesEmployees()[0] : null;
    }

    public function getHumanResourcesEmployees() {
        $query = "SELECT e.id FROM employees e JOIN users u ON e.user_id = u.id WHERE company_id = " . $this->get('id') . " AND user_type_id = 2";
        $hrs = array();
        $results = $this->db->searchInDB($query);;
        foreach($results as $result) {
            $hrs[] = new Employee($result['id']);
        }
        return $hrs;
    }

    public function getAllEmployees() {
        $query = "SELECT id FROM employees WHERE company_id = " . $this->get('id');
        $employeesResults = $this->db->searchInDB($query);
        $employees = array();
        foreach ($employeesResults as $employee) {
            $employees[] = new Employee($employee['id']);
        }
        return $employees;
    }
    
    static function insertInDB($newUserData, $db) {
        $query = "INSERT INTO " . $this->tableName . " (`name`, `registration_number`, `address`, `business_type_id`, `owner_id`) VALUES (";

        return $db->create($query, $newUserData);
    }
}