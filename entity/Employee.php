<?php

namespace entity;

class Employee extends Entity {

    public function __construct($employeeId) {
        $this->tableName = "employees";
        parent::__construct($employeeId);
    }

    public function getPosition() {
        return $this->db->getType("position", $this->get('position_id'));
    }

    public function getUserData() { 
        $user = new User($this->db->getUserByEmployeeId($this->get('id')));
        return $user;
    }

    static function insertInDB($newEmployeeData, $db) {
        $query = "INSERT INTO employees (`user_id`, `company_id`, `position_id`, `available_days_off`, `work_hours_per_day`) VALUES (";
        return $db->create($query, $newEmployeeData);
    }

    public function getAbsences() {
        $query = "SELECT * FROM absence_requests WHERE employee_id = " . $this->get('id');
        return $this->db->searchInDB($query);
    }
}