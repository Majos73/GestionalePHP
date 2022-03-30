<?php
class Database
{
    private $host = "sql11.freesqldatabase.com";
    private $database_name = "sql11478095";
    private $username = "sql11478095";
    private $password = "MgJTgx4WEC";
    public $conn;
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
