<?php
class Database {
    private $host = "localhost";
    private $db_name = "PrishtinaAirlines";
    private $username = ""; 
    private $password = ""; 
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
    
        error_reporting(E_ALL & ~E_WARNING);
        
        $connectionInfo = array(
            "Database" => $this->db_name,
            "CharacterSet" => "UTF-8"
        );
        
        $this->conn = sqlsrv_connect($this->host, $connectionInfo);
        
        if($this->conn) {
        
            return $this->conn;
        } else {
        
            error_log("Database connection failed: " . print_r(sqlsrv_errors(), true));
            return false;
        }
    }
}
?>