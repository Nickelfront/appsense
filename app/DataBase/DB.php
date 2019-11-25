<?php
namespace app\DataBase;

use app\Configuration\Configuration;
use PDO;
use util\Company;
use util\User;

class DB {

    private $connection;
       
    public function __construct() {
        $dbName = Configuration::get("database");
        $user = Configuration::get("username");
        $pass = Configuration::get("password");
        $host = Configuration::get("host");
        $this->connection = new PDO("mysql:host=$host;dbname=$dbName", "$user", "$pass", [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]); // Return result as associative array
    }

    /* CREATE OPERATIONS */

    /**
     * @param array $userData: consists of first name, last name, email, password, gender, phone, user_type_id in said order
     */
    public function createUser(array $userData) { 
        $query = "INSERT INTO users (`first_name`, `last_name`, `email`, `password`, `gender`, `phone`, `user_type_id`) VALUES (";
        $query = $this->addDataToQuery($query, $userData);
        
        $this->execute($query);
    }

    /**
     * @param array $companyData: consists of name, registration_number, address, business_type_id, owner_id in said order
     */
    public function createCompany(array $companyData) {
        $query = "INSERT INTO companies (`name`, `registration_number`, `address`, `business_type_id`, `owner_id`) VALUES (";
        $query = $this->addDataToQuery($query, $companyData);
        
        $this->execute($query);    
    }

    /**
    * @param array $employeeData: consists of user_id, company_id, position_id, available_days_off, work_hours_per_day in said order
     */
    public function createEmployee(array $employeeData) {
        $query = "INSERT INTO employees (`user_id`, `company_id`, `position_id`, `available_days_off`, `work_hours_per_day`) VALUES (";
        $query = $this->addDataToQuery($query, $employeeData);

         $this->execute($query);    
    }

    public function createPosition(array $positionData) {
        $query = "INSERT INTO employees (`name`) VALUES (";
        $query = $this->addDataToQuery($query, $positionData);

        $this->execute($query);        
    }
    
    private function addDataToQuery(string $query, array $data) {
        foreach ($data as $entry) {
            $query .= "'" . $entry . "'" .",";
        }
        
        $query[strlen($query) - 1] = ")";
        return $query;
    }

    /** GET OPERATIONS */
    
    public function getUser($userEmail) {
        $query = "SELECT id FROM users WHERE email = '$userEmail'";
        
        $result = $this->searchInDB($query)[0];
        // show($result);
        return new User($result);
    }

    public function getUserData($userId, $requiredField)
    {
        $userData = $this->searchInDB("SELECT * FROM users WHERE id = $userId")[0];
        return $this->getField($userData, $requiredField);

    }

    /**
     * @param mixed $userId the ID of the user whose companies we want to see
     * @return array array of all the Companies
     */
    public function getUserCompanies($userId) {
        $query = "SELECT * FROM companies WHERE companies.owner_id = $userId";
        $results = $this->searchInDB($query);
        // show($results);
        $companies = array();
        foreach ($results as $result) {
            $companies[] = new Company($result);
        }
        return $companies;
    }
  
    public function getEmployee($employeeId) {
        return $this->searchInDB("SELECT * FROM employees WHERE id = $employeeId")[0];
    }
    
    public function getCompany($companyId) {
        $companyResult = $this->searchInDB("SELECT * FROM companies WHERE id = $companyId")[0];
        if ($companyResult) {
            return new Company($companyResult);
        } return false;
    }
        
    /** LIST OPERATIONS */
       
    /**
     * Lists  all employees of a given company
     * @param $companyId : the ID of the company whose employees need to be listed  
     */
    public function listAllEmployees($companyId) {
        return $this->searchInDB("SELECT * FROM employees WHERE company_id = $companyId");
    }

    /** UPDATE OPERATIONS -TODO */
    /** DELETE OPERATIONS -TODO */

    /**
     * Returns all records that match a SELECT SQL query.
     * @return array of search results
     */
    private function searchInDB($query) {
        return $this->connection->query($query)->fetchAll();
    }

    public function getType($name, $id) {
        $query = "SELECT name FROM " . $name . "_types WHERE id = " . $id;
        return $this->searchInDB($query)[0]['name'];
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
     * Find a single record in a table by a specified filter.
     * @param $table the name of the table from the database to search in  
     * @param $uniqueFilter the condition that you are sure that makes the record unique from the rest
     */
    public function findRecord($table, $uniqueFilter) {
        return $this->searchInDB("SELECT * FROM $table WHERE $uniqueFilter")[0];
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
    
    /**
     *  @param $table the name of the table to update in the database
     *  @param $record the record to update - it must be a condition that makes the record unique for this table, e.g. email = 'useremail@mail.com'
     *  @param $field the field to update
     *  @param $newValue the new value for this field
     *
     */
    public function update($table, $uniqueField, $uniqueValue, $field, $newValue) {
        $query = "UPDATE $table SET $field = '$newValue' WHERE $uniqueField = '$uniqueValue'"; 
        $this->execute($query);
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