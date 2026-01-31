<?php
// Ndryshoje këtë që të shkojë një folder prapa
require_once __DIR__ . '/../Database.php'; 

class UserMapper extends Database {
    public function getAllUsers() {
        $db = $this->getConnection();
        
        // Sigurohu që tabela quhet 'users'
        $sql = "SELECT id, name, email, role FROM users ORDER BY id DESC"; 
        $statement = $db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id) {
        $db = $this->getConnection();
        $sql = "DELETE FROM users WHERE id = :id";
        $statement = $db->prepare($sql);
        $statement->bindParam(':id', $id);
        return $statement->execute();
    }
}