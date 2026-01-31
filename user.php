<?php
class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $surname, $dob, $nationality, $country, $city, $zip, $phone, $email, $password) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (name, surname, dob, nationality, country, city, zip, phone, email, password, role) 
                  VALUES (:name, :surname, :dob, :nationality, :country, :city, :zip, :phone, :email, :password, 'user')";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':nationality', $nationality);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':zip', $zip);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashed_password);

        return $stmt->execute();
    }

    public function login($email, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        
        return false;
    }
}
?>