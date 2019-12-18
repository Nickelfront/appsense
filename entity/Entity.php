<?php

namespace entity;

use app\DataBase\DB;

abstract class Entity {

    protected $db;
    protected $data;
    protected $tableName;

    /**
     * Fetch a record by its ID
     */
    protected function __construct($id) {
        $this->db = new DB();
        $this->data = $this->db->getData($this->tableName, $id);

    }

    abstract static function insertInDB($newEntityData, $db);
    
    /**
     * Returns value by a given property
     * @param string $key 
     * @return string the property is returned if it exists or null if it doesn't
     */
    public function get($key) {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        } return null;
    }

    /**
     * Updates a field in the database with a new value
     * @param string $field the field to update
     * @param $newValue the new value for this field
     * @return int or false if there's been an error updating this field
     */
    public function updateField($field, $newValue) {
        return $this->db->update($this->tableName, $field, $newValue, "id", $this->get('id'));
    }

    protected function normalize($details) {
        foreach ($details as $key => $data) {
            $details[$key] = str_replace("'", "\'", $data);
        }
        return $details;
    }
    
    // TODO do i need this at all?
    public function put($key, $value) {
        $this->details[$key] = $value;
    }



}