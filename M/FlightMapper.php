<?php
// M/FlightMapper.php
require_once __DIR__ . '/../Database.php';

class FlightMapper extends Database {

    public function getAllFlights() {
        try {
            $conn = $this->getConnection(); 
            $sql = "SELECT * FROM flights";
            $statement = $conn->query($sql);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    // Single merged function to handle adding flights
    public function addFlight($airline, $route, $time, $duration, $price, $isDirect) {
        try {
            $conn = $this->getConnection();
            $sql = "INSERT INTO flights (airline, route, flight_time, duration, price, is_direct) 
                    VALUES (:airline, :route, :time, :duration, :price, :is_direct)";
            
            $statement = $conn->prepare($sql);
            
            $statement->bindParam(':airline', $airline);
            $statement->bindParam(':route', $route);
            $statement->bindParam(':time', $time);
            $statement->bindParam(':duration', $duration);
            $statement->bindParam(':price', $price);
            $statement->bindParam(':is_direct', $isDirect);
            
            return $statement->execute();
        } catch (PDOException $e) {
            die("Insert Error: " . $e->getMessage());
        }
    }

    public function deleteFlight($id) {
        try {
            $conn = $this->getConnection();
            $sql = "DELETE FROM flights WHERE id = :id";
            $statement = $conn->prepare($sql);
            $statement->bindParam(':id', $id);
            return $statement->execute();
        } catch (PDOException $e) {
            die("Delete Error: " . $e->getMessage());
        }
    }
}