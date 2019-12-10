<?php

namespace entity;

class Company extends Entity {
    
    public function __construct($companyId) {
        $this->tableName = "companies";
        parent::__construct($companyId);
        // $this->data = $this->db->getCompanyData($companyId);
    }

    public function getBusinessType() {
        return $this->db->getType("business", $this->get('business_type_id'));
    }

    public function getHumanResourcesEmployees() {
        $hrs = array();
        $results = $this->db->listHRsForCompany($this->get('id'));
        foreach($results as $result) {
            $hrs[] = new Employee($result['id']);
        }
        return $hrs;
    }

    public function getAllEmployees() {
        $employeesResults = $this->db->listAllEmployees($this->get('id'));
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