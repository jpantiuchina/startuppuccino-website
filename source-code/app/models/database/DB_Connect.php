<?php

// Inlcude db constants (table names, ...)
require_once 'DB_Names.php';

class DB_Connect {
    private $conn;
 
    // Connecting to database
    public function connect() {
        require_once 'DB_Config.php';
         
        // Connecting to mysql database
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
         
        // return database handler
        return $this->conn;
    }
}
 
?>