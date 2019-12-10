<?php

namespace entity;

class AbsenceRequest extends Entity {

    public function __construct($absenceRequestId) {
        $this->tableName = "absence_requests";
        parent::__construct($absenceRequestId);
    }

    static function insertInDB($newAbsenceData, $db) {
        $withSubstitute = (isset($newAbsenceData['substitute']) ? '`substitute_id`,': "");
        $query = "INSERT INTO absence_requests (from_date, to_date, absence_type_id," . $withSubstitute . " comment, document_path, employee_id) VALUES (";
        return $db->create($query, $newAbsenceData);
    }

}