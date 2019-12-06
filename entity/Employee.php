<?php

namespace entity;

class Employee extends Entity {

    public function __construct($employeeId) {
        $this->tableName = "employees";
        parent::__construct($employeeId);
    }

    public function getUserData() {
        return new User($this->db->getUserByEmployeeId($this->get('id')));
    }

    static function insertInDB($newEmployeeData, $db) {
        $query = "INSERT INTO employees (`user_id`, `company_id`, `position_id`, `available_days_off`, `work_hours_per_day`) VALUES (";
        return $db->create($query, $newEmployeeData);
    }

}