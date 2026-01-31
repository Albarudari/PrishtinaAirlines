<?php
require_once 'Database.php';

class ContactMapper extends Database {
    public function getAllInquiries() {
        $db = $this->getConnection();
        
        // Sigurohu që tabela në MySQL quhet saktësisht 'contact_form'
        $sql = "SELECT * FROM contact_form ORDER BY id DESC"; 
        $statement = $db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>