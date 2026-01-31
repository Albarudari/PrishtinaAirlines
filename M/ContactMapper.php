<?php
require_once 'Database.php';

class ContactMapper extends Database {
    public function getAllInquiries() {
        $db = $this->getConnection();
        // Kjo supozon që tabela në DB quhet 'contact_form'
        $sql = "SELECT * FROM contact_form";
        $statement = $db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}