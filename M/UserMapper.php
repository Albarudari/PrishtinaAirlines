<?php
require_once __DIR__ . '/../Database.php';

class UserMapper extends Database {


    public function getAllUsers() {
        $db = $this->getConnection();
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

    
    public function getUserById($id) {
        $db = $this->getConnection();
        $sql = "SELECT * FROM users WHERE id = :id";
        $statement = $db->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    
    public function updateUser($id, $data) {
        $db = $this->getConnection();
        $sql = "UPDATE users SET name = :name, surname = :surname, nationality = :nationality, 
                city = :city, role = :role WHERE id = :id";
        $statement = $db->prepare($sql);
        return $statement->execute([
            ':name' => $data['name'],
            ':surname' => $data['surname'],
            ':nationality' => $data['nationality'],
            ':city' => $data['city'],
            ':role' => $data['role'],
            ':id' => $id
        ]);
    }
} 