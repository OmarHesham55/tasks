<?php
class Database
{
private $dsn = "mysql:host=localhost;dbname=crud_oop;charset=utf8";
private $username = "root";
private $password = "";
public $conn;


public function __construct()
{
    try {
        $this->conn = new PDO($this->dsn,$this->username,$this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        die("Connection failed " . $e->getMessage());
    }
}
    public function getConnect()
    {
        return $this->conn;

    }

}

