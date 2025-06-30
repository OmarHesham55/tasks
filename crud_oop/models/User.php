<?php
require_once __DIR__ . '/../config/Database.php';
class User extends Database
{
    public function getAllUsers()
    {
        $stmt = $this->getConnect()->prepare("SELECT * FROM users ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $stmt = $this->getConnect()->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function addUser($name,$email,$password)
    {
        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
        $stmt = $this->getConnect()->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
        return $stmt->execute([$name,$email,$hashedPassword]);
    }

    public function updateUser($id,$name,$email)
    {
        $stmt = $this->getConnect()->prepare("UPDATE users SET name = ? , email = ? WHERE id = ?");
        return $stmt->execute([$name,$email,$id]);
    }
    public function deleteUser($id)
    {
        $stmt = $this->getConnect()->prepare("DELETE FROM users WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function login($email,$password)
    {
        $stmt = $this->getConnect()->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password,$user['password']))
        {
            return $user;
        }
        return false;
    }

    public function isEmailExist($email)
    {
        $stmt = $this->getConnect()->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([$email]);
//      $exist = $stmt->fetch(PDO::FETCH_ASSOC);
//        if($exist)
//            return true;
        return $stmt->rowCount()>0;
    }
}