<?php
class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $surname, $birthdate, $nationality, $country, $city, $zip_code, $phone, $email, $password) {
        
        $query = "INSERT INTO " . $this->table_name . " 
                  (name, surname, birthdate, nationality, country, city, zip_code, phone, email, password, role) 
                  VALUES (:name, :surname, :birthdate, :nationality, :country, :city, :zip_code, :phone, :email, :password, 'user')";

        $stmt = $this->conn->prepare($query);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([
            ':name' => $name,
            ':surname' => $surname,
            ':birthdate' => $birthdate,
            ':nationality' => $nationality,
            ':country' => $country,
            ':city' => $city,
            ':zip_code' => $zip_code,
            ':phone' => $phone,
            ':email' => $email,
            ':password' => $hashed_password
        ]);
    }

    public function login($email, $password) {
        
        $email = trim($email); 
        
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