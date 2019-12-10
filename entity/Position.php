<?php

namespace entity;

class Position extends Entity {

    public function __construct($positionId) {
        $this->tableName = "position_types";
        parent::__construct($positionId);
    }

    static function insertInDB($newPositionData, $db) {
        $query = "INSERT INTO position_types (`name`) VALUES (";

        return $db->create($query, $newPositionData);
    }

    function getAllPositions() {
        $results = $this->db->listAllRecords("position_types");
        // show($results);
        $positions = array();
        foreach ($results as $result) {
            $positions[] = new Position($result['id']);
        }
        return $positions;
    }
}