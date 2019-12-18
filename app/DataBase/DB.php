<?php
namespace app\DataBase;

use app\Configuration\Configuration;
use DateTime;
use PDO;

class DB {

    private $connection;
       
    public function __construct() {
        $dbName = Configuration::get("database");
        $user = Configuration::get("username");
        $pass = Configuration::get("password");
        $host = Configuration::get("host");
        $this->connection = new PDO("mysql:host=$host;dbname=$dbName", "$user", "$pass", [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]); // Return result as associative array
    }

    public function getData($tableName, $uniqueId) {
        $entityData = $this->searchInDB("SELECT * FROM $tableName WHERE id = $uniqueId")[0];
        // show($entityData);
        return $entityData;
    }

    public function listAllRecords($tableName) {
        return $this->searchInDB("SELECT * FROM $tableName");
    }

    // public function getAllPositions() {
    //     return $this->searchInDB("SELECT * FROM position_types");
    // }

    /* CREATE OPERATIONS */

    public function create($query, $data) {
        $query = $this->addDataToQuery($query, $data);
        // show($quer`y);
        // echo $query;
        return $this->execute($query);
    }
    
    public function createAbsenceRequestNotification(array $notificationData) {
        $query = "INSERT INTO absence_request_notifications (`from_user_id`, `to_user_id`, `absence_request_id`) VALUES (";
        $query = $this->addDataToQuery($query, $notificationData);
        // show($query);
        return $this->execute($query);
    }

    private function addDataToQuery(string $query, array $data) {
        foreach ($data as $entry) {
            $query .= "'" . $entry . "'" .",";
        }
        // close values list
        $query[strlen($query) - 1] = ")";
        return $query;
    }

    /** GET OPERATIONS */
    
    public function getUserIdByEmail($userEmail) {
        $query = "SELECT id FROM users WHERE email = '$userEmail'";
        
        $result = $this->searchInDB($query)[0];
        return $result['id'];
    }
 
    public function getUserIdByToken($token) {
        $query = "SELECT id FROM users WHERE login_token = '$token'";

        $result = $this->getFirstResult($query);
        return $result['id'];
    }
 
    // public function getUserField($userId, $requiredField)
    // {
    //     $userData = $this->getUserData($userId);
    //     return $this->getField($userData, $requiredField);
    // }

    public function getUserData($userId) {
        $userData = $this->searchInDB("SELECT * FROM users WHERE id = $userId")[0];
        return $userData;
    }

    /**
     * @param mixed $userId the ID of the user whose companies we want to see
     * @return array array of all the Companies
     */
    // public function getUserCompanies($userId) {
    //     $query = "SELECT id FROM companies WHERE owner_id = $userId";
    //     $results = $this->searchInDB($query);
    //     return $results;
    // }
  
    // public function getEmployeeByUserId($userId) {
    //     $employeeId = $this->searchInDB("SELECT id FROM employees WHERE user_id = $userId")[0]['id'];
    //     return $employeeId;
    // }

    // public function getUserByEmployeeId($employeeId) {
    //     $employee = $this->getEmployee($employeeId);
    //     $userId = $this->searchInDB("SELECT id FROM users WHERE id = " . $employee['user_id'])[0]['id'];
    //     return $userId;
    // }

    // public function getEmployee($employeeId) {
    //     return $this->searchInDB("SELECT * FROM employees WHERE id = $employeeId")[0];
    // }
    
    // public function getCompany($companyId) {
    //     $companyResult = $this->searchInDB("SELECT * FROM companies WHERE id = $companyId")[0];
    //     if ($companyResult) {
    //         return $companyResult;
    //     } return false;
    // }

    // public function getCompanyData($companyId) {
    //     $companyData = $this->searchInDB("SELECT * FROM companies WHERE id = $companyId")[0];
    //     return $companyData;
    // }

    // public function getApprovedAbsences($companyId) {
    //     $query = "SELECT * FROM absence_requests WHERE status = 'Approved' AND employee_id = ";
    //     $approvedAbsences = array();
    //     $employees = $this->listAllEmployees($companyId);
        
    //     foreach ($employees as $employee) {
    //         $employeeAbsences = $this->searchInDB($query . $employee['id']); // array of all absences for this employee
    //         if ($employeeAbsences) {
    //             $approvedAbsences[] = $employeeAbsences; 
    //         }
    //     }
    //     return $approvedAbsences; 
    // }

    public function getNewAbsenceRequests($userId) {
        $result = $this->searchInDB("SELECT COUNT FROM absence_requests_notifications WHERE for_user_id = $userId")[0];

        return $result;
    }
    
    /** LIST OPERATIONS */
    /**
     * Lists all HRs working in the HR department of a given company
     *  
     *  */    
    // public function listHRsForCompany($companyId) {
    //     $hrResults = array();
    //     $query = "SELECT e.id FROM employees e JOIN users u ON e.user_id = u.id WHERE company_id = $companyId AND user_type_id = 2";
    //     // show($hrResults);
    //     $hrResults = $this->searchInDB($query);      
    //     return $hrResults;
    // }

    /**
     * Lists  all employees of a given company
     * @param $companyId : the ID of the company whose employees need to be listed  
     */
    // public function listAllEmployees($companyId) {
    //     return $this->searchInDB("SELECT id FROM employees WHERE company_id = $companyId");
    // }

    /** UPDATE OPERATIONS -TODO */
    public function updateUserField($userId, $field, $newValue) {
        $this->update("users", $field, $newValue, "id", $userId);
        $now = new DateTime();
        $this->update("users", "updated_at", date_format($now, 'Y-m-d H:i:s'), "id", $userId);
    }

    /** DELETE OPERATIONS -TODO */

    /**
     * Returns all records that match a SELECT SQL query.
     * @return array of search results
     */
    public function searchInDB($query) {
        return $this->connection->query($query)->fetchAll();
    }

    public function getFirstResult($query) {
        return $this->searchInDB($query)[0];
    }

    public function getType($name, $id) {
        $query = "SELECT name FROM " . $name . "_types WHERE id = " . $id;
        return $this->getFirstResult($query)['name'];
    }

    /** Get a single value for a given record
     * @param $record: a single record fetched from the database
     * @param $field: a required field from the record
     */
    
    public function getField($record, string $field) {
        if (isset($record[$field])) {
            return $record[$field];
        } return false;
    }

    public function findUserPass($userEmail) {
        $result = $this->searchInDB("SELECT * FROM users WHERE email='$userEmail'")[0];
        return $this->getField($result, 'password');
    }

    /**
     * Used to set a temporary login token to a user
     */
    public function setToken($userId, $token) {
        return $this->update("users", "login_token", $token, "id", $userId);
    }

    /**
     * Find a single record in a table by a specified filter.
     * @param $table the name of the table from the database to search in  
     * @param $uniqueFilter the condition that you are sure that makes the record unique from the rest
     */
    public function findRecord($table, $uniqueFilter) {
        return $this->searchInDB("SELECT * FROM $table WHERE $uniqueFilter") ? $this->searchInDB("SELECT * FROM $table WHERE $uniqueFilter")[0] : false;
    }
        
    /**
     * Retrieve all records from a specified table in the database.
     */
    public function listAll($tableName) {
        $results = $this->searchInDB("SELECT * FROM $tableName");
        return $results;
    }

     /**
     * A shortened version of PDO exec method.
     * @return int or false if transaction failed
     */
    private function execute($query) {
        $this->connection->exec($query);
    }
    
    public function getLastInsertedID() {
        return $this->connection->lastInsertId();
    }

    /**
     *  @param $table the name of the table to update in the database
     *  @param $record the record to update - it must be a condition that makes the record unique for this table, e.g. email = 'useremail@mail.com'
     *  @param $field the field to update
     *  @param $newValue the new value for this field
     *
     */
    public function update($table, $field, $newValue, $uniqueField, $uniqueValue) {
        $query = "UPDATE $table SET $field = '$newValue' WHERE $uniqueField = '$uniqueValue'"; 
        return $this->execute($query);
    }

    /**
     *  @param $table the name of the table to delete from in the database
     *  @param $record the record to delete - it must be a condition that makes the record unique for this table, e.g. email = 'useremail@mail.com'
     */
    public function delete($table, $uniqueField, $uniqueValue) {
        $query = "DELETE FROM $table WHERE $uniqueField = '$uniqueValue'";
        $this->execute($query);
    }
}