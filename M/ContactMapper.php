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