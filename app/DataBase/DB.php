<?php
namespace app\DataBase;
use PDO;

class DB {

    private $connection;

    public function __construct($dbName)
    {
        $this->connection = new PDO("mysql:host=localhost;dbname=$dbName", "root", "");
    }

    public function fetchAll($tableName) {
        $results = $this->connection->query("SELECT * FROM $tableName");
        return $results;
    }

    // public function create($tableName, $newData) {
    //     $stmt = $dbh->prepare("INSERT INTO $tableName (name, value) VALUES (:name, :value)");
    //     $stmt->bindParam(':name', $name);
    //     $stmt->bindParam(':value', $value);
    // }

    public function createUser($userData) //ORDER: first, last, email, pass
    {
        $query = "INSERT INTO users (`first_name`, `last_name`, `email`, `password`) VALUES (";
        foreach ($userData as $data) {
            $query .= "'" . $data . "'" .",";
        }

        $query[strlen($query) - 1] = ")";

        print_r($this->connection->exec($query));
    }

    // TODO update and delete      

}