<?php
require_once __DIR__ . '/../database.php';

class ContactMapper extends Database {

    public function getAllInquiries() {
        $db = $this->getConnection();
        $sql = "SELECT * FROM contact_messages ORDER BY id DESC"; 
        $statement = $db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}