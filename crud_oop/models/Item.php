<?php
require_once __DIR__ . '/../config/Database.php';
class Item extends Database
{
    public function getAllItems($userID)
    {
        $stmt = $this->getConnect()->prepare("SELECT * FROM items WHERE user_id=? ORDER BY  created_at DESC");
        $stmt->execute([$userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getItem($itemID,$userID)
    {
        $stmt = $this->getConnect()->prepare("SELECT id,title,description,created_at FROM items WHERE id=? AND user_id=?");
        $stmt->execute([$itemID,$userID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function addItem($title,$description,$userID)
    {
        $stmt = $this->getConnect()->prepare("INSERT INTO items(title,description,user_id) VALUES(?,?,?)");
        return $stmt->execute([$title,$description,$userID]);
    }

    public function deleteItem($id,$userId)
    {
        $stmt = $this->getConnect()->prepare("DELETE FROM items WHERE id=? AND user_id=?");
        return $stmt->execute([$id,$userId]);
    }

    public function updateItem($itemId,$userId,$title,$description)
    {
        $stmt = $this->getConnect()->prepare("UPDATE items SET title = ? , description = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$title,$description,$itemId,$userId]);
    }
}