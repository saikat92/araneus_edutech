<?php
require_once 'config.php';

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $conn;
    private $error;
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        
        if($this->conn->connect_error) {
            $this->error = "Connection failed: " . $this->conn->connect_error;
            die($this->error);
        }
        
        $this->conn->set_charset("utf8");
    }
    
    public function getConnection() {
        return $this->conn;
    }
    
    public function close() {
        $this->conn->close();
    }
}

$db = new Database();
$conn = $db->getConnection();

?>