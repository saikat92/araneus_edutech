<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'init.php';

define('DB_HOST', $_ENV['DB_HOST'] ?? 'UNKNOWN_HOST');
define('DB_USER', $_ENV['DB_USER'] ?? 'UNKNOWN_USER');
define('DB_PASS', $_ENV['DB_PASS'] ?? 'UNKNOWN_PASSWORD');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'UNKNOWN_DATABASE');

define('COMPANY_NAME', $_ENV['COMPANY_NAME'] ?? 'UNKNOWN_SITE');
define('DOMAIN', $_ENV['DOMAIN'] ?? 'UNKNOWN_URL');
define('COMPANY_CUSTOM_MAIL', $_ENV['COMPANY_CUSTOM_MAIL'] ?? 'UNKNOWN_EMAIL');
define('COMPANY_PHONE', $_ENV['COMPANY_PHONE'] ?? 'UNKNOWN_PHONE');
define('COMPANY_ADDRESS', $_ENV['COMPANY_ADDRESS'] ?? 'UNKNOWN_ADDRESS');
define('COMPANY_LLPIN', $_ENV['COMPANY_LLPIN'] ?? 'UNKNOWN_LLPIN');

class Database
{
    private $conn;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->conn = new mysqli(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME
        );

        if ($this->conn->connect_error) {
            die('Database connection failed: ' . $this->conn->connect_error);
        }

        $this->conn->set_charset('utf8mb4');
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function close()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

$database = new Database();
$conn = $database->getConnection();
?>