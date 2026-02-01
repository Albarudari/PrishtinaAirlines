<?php
require_once __DIR__ . '/../database.php';

class ContactMapper extends Database {

    public function insertInquiry($name, $email, $message) {
        try {
            $db = $this->getConnection();
            $sql = "INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)";
            
            $statement = $db->prepare($sql);
            
            $statement->bindParam(':name', $name);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':message', $message);
            
            return $statement->execute();
        } catch (PDOException $e) {
            die("Gabim në DB: " . $e->getMessage());
        }
    }

    public function getAllInquiries() {
        $db = $this->getConnection();
        $sql = "SELECT * FROM contact_messages ORDER BY id DESC"; 
        $statement = $db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}