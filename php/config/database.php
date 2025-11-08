<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    public $conn;

    public function __construct() {
        // Check if running on Railway (production) or locally
        if (getenv('MYSQL_HOST')) {
            // Railway production environment
            $this->host = getenv('MYSQL_HOST');
            $this->db_name = getenv('MYSQL_DATABASE');
            $this->username = getenv('MYSQL_USER');
            $this->password = getenv('MYSQL_PASSWORD');
            $this->port = getenv('MYSQL_PORT') ?: '3306';
        } else {
            // Local XAMPP environment
            $this->host = 'localhost';
            $this->db_name = 'real_estate_management';
            $this->username = 'root';
            $this->password = '';
            $this->port = '3306';
        }
    }

    public function getConnection() {
        $this->conn = null;
        
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Optional: Log successful connection (remove in production)
            error_log("Database connected successfully to: {$this->host}");
            
        } catch(PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
            throw new Exception("Database connection failed");
        }
        
        return $this->conn;
    }
}
?>