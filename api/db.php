<?php
class Database {
    private $host = '127.0.0.1';
    private $db_name = 'hr_dwkeji';
    private $username = 'hr_dwkeji';
    private $password = 'Davidgzs228919';
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
