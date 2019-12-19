<?php

namespace entity;

use app\DataBase\DB;

class AbsenceRequest extends Entity {

    public function __construct($absenceRequestId) {
        $this->tableName = "absence_requests";
        parent::__construct($absenceRequestId);
    }

    static function insertInDB($newAbsenceData, $db) {
        $withSubstitute = (isset($newAbsenceData['substitute']) ? '`substitute_id`,': "");
        $query = "INSERT INTO absence_requests (from_date, to_date, absence_type_id," . $withSubstitute . " comment, employee_id, document_path) VALUES (";
        return $db->create($query, $newAbsenceData);
    }

    public static function getReviewedRequests($ownerId) {
        $db = new DB();
        $reviewedRequests = array(
            "approved" => array(),
            "rejected" => array()
        );
        $query = "SELECT from_date FROM absence_requests ar JOIN employees e ON ar.employee_id = e.id JOIN companies c ON e.company_id = c.id JOIN users u ON c.owner_id = u.id WHERE c.owner_id = $ownerId AND status_id = ";
        // show($query);

        $reviewedRequests['approved'] = $db->searchInDB($query . 4);
        $reviewedRequests['rejected'] = $db->searchInDB($query . 3);

        return $reviewedRequests;
    }

    public function notfiyHRs() {
    	// get HRs
    	$absenceRequest = array(
    		"for_user_id" => null,
    		"from_user_id" => $this->get('employee_id')->getUserData()->get('id'),
    		"absence_request_id" => $this->get('id')
    	);
    	$query = "INSERT INTO absence_requests_notifications (for_user_id, from_user_id, absence_request_id) VALUES(";
    	// $this->db->create($query, $absenceRequest); TODO
    }

}