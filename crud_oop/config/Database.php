<?php
class Database
{
private $dsn = "mysql:host=localhost;dbname=crud_oop;charset=utf8";
private $username = "root";
private $password = "";
public $conn;

    public function getConnect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO($this->dsn,$this->username,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        }
        catch (PDOException $e)
        {
            die("Connection failed " . $e->getMessage());
        }
    }

}

