<?php
require_once __DIR__ . '/../Database.php';

class UserMapper extends Database {

    public function getUserByEmail($email) {
        try {
            $db = $this->getConnection();
            $sql = "SELECT * FROM users WHERE email = :email";
            $statement = $db->prepare($sql);
            $statement->bindParam(':email', $email);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Login Error: " . $e->getMessage());
            return false;
        }
    }

    public function register($name, $surname, $birthdate, $nationality, $country, $city, $zip, $phone, $email, $password) {
        try {
            $db = $this->getConnection();
            
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $role = 'user';

            $sql = "INSERT INTO users (name, surname, birthdate, nationality, country, city, zip_code, phone, email, password, role) 
                    VALUES (:name, :surname, :birthdate, :nationality, :country, :city, :zip, :phone, :email, :password, :role)";
            
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':surname' => $surname,
                ':birthdate' => $birthdate,
                ':nationality' => $nationality,
                ':country' => $country,
                ':city' => $city,
                ':zip' => $zip,
                ':phone' => $phone,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => $role
            ]);
        } catch (PDOException $e) {
            error_log("Registration Error: " . $e->getMessage());
            return false;
        }
    }


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