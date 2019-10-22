<?php
namespace app\DataBase;
use PDO;

class DB {

    private $connection;

    public function __construct($dbName) {
        $this->connection = new PDO("mysql:host=localhost;dbname=$dbName", "root", "", [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]); // Return result as associative array
    }

    /**
     * Fetches all records that match a SELECT SQL query.
     */
    private function searchInDB($query) {
        return $this->connection->query($query)->fetchAll();
    }

    /** Get a single value for a given record
     * @param $record: a single record fetched from the database
     * @param $field: a required field from the record
     */
    public function getField($record, string $field) {
        return $record[$field];
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
    public function fetchAll($tableName) {
        $results = $this->searchInDB("SELECT * FROM $tableName");
        return $results;
    }

    // public function findUser($userEmail, $userPassword) {
    //     $passResult = $this->connection->query("SELECT users.password FROM users WHERE users.password='$userPassword' AND email='$userEmail'")->fetchAll();
    //     return !empty($passResult);
    // }

    // public function create($tableName, $newData) {
    //     $stmt = $dbh->prepare("INSERT INTO $tableName (name, value) VALUES (:name, :value)");
    //     $stmt->bindParam(':name', $name);
    //     $stmt->bindParam(':value', $value);
    // }

    /**
     * @param array $userData: consists of first name, last name, email and password in said order
     */
    public function createUser(array $userData) 
    {
        $query = "INSERT INTO users (`first_name`, `last_name`, `email`, `password`) VALUES (";
        foreach ($userData as $data) {
            $query .= "'" . $data . "'" .",";
        }

        $query[strlen($query) - 1] = ")";

        $this->execute($query);
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