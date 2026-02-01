<?php
// M/ContactMapper.php
require_once __DIR__ . '/../Database.php'; 

class ContactMapper extends Database {
    protected $db;

    public function __construct() {
        // 1. Create the database object
        $database = new Database();
        
        // 2. Call the specific method that actually starts the connection
        // This sets the $conn variable inside your Database class
        $this->db = $database->getConnection(); 
    }

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
        // This will now work because $this->db is no longer null!
        $sql = "SELECT * FROM contact_inquiries ORDER BY created_at DESC";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertInquiry($name, $email, $message) {
        $sql = "INSERT INTO contact_inquiries (emri, email, mesazhi) VALUES (?, ?, ?)";
        $statement = $this->db->prepare($sql);
        return $statement->execute([$name, $email, $message]);
    }
}