<?php
require_once __DIR__ . '/../Database.php';

class ContactMapper extends Database {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function insertInquiry($name, $email, $message) {
        try {
            $sql = "INSERT INTO contact_inquiries (emri, email, mesazhi) VALUES (?, ?, ?)";
            $statement = $this->db->prepare($sql);
            return $statement->execute([$name, $email, $message]);
        } catch (PDOException $e) {
            die("Gabim në DB: " . $e->getMessage());
        }
    }

    public function getAllInquiries() {
        $sql = "SELECT * FROM contact_inquiries ORDER BY created_at DESC";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
