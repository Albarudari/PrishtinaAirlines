<?php
require_once __DIR__ . '/../Database.php';

class FlightMapper extends Database {

    public function getAllFlights($filterStops = null) {
        try {
            $conn = $this->getConnection();
            
            $sql = "SELECT f.*, u.name as admin_name, u2.name as updated_by_name 
                    FROM flights f 
                    LEFT JOIN users u ON f.created_by = u.id
                    LEFT JOIN users u2 ON f.updated_by = u2.id";
            
            $params = [];
            if ($filterStops !== null) {
                if ($filterStops === 2) {
                    $sql .= " WHERE f.stops >= 2";
                } else {
                    $sql .= " WHERE f.stops = :stops";
                    $params[':stops'] = $filterStops;
                }
            }
            
            $sql .= " ORDER BY f.id DESC";
            $statement = $conn->prepare($sql);
            $statement->execute($params);
            
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    public function getFlightById($id) {
        try {
            $conn = $this->getConnection();
            $sql = "SELECT * FROM flights WHERE id = :id";
            $statement = $conn->prepare($sql);
            $statement->bindParam(':id', $id);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function addFlight($airline, $route, $time, $duration, $price, $stops = 0, $admin_id = null) {
        try {
            $conn = $this->getConnection();
            
            $sql = "INSERT INTO flights (airline, route, flight_time, duration, price, stops, created_by) 
                    VALUES (:airline, :route, :time, :duration, :price, :stops, :admin_id)";
            
            $statement = $conn->prepare($sql);
            $statement->bindParam(':airline', $airline);
            $statement->bindParam(':route', $route);
            $statement->bindParam(':time', $time);
            $statement->bindParam(':duration', $duration);
            $statement->bindParam(':price', $price);
            $statement->bindParam(':stops', $stops);
            $statement->bindParam(':admin_id', $admin_id);

            return $statement->execute();
        } catch (PDOException $e) {
            die("Insert Error: " . $e->getMessage());
        }
    }

    public function updateFlight($id, $airline, $route, $time, $duration, $price, $stops, $admin_id) {
        try {
            $conn = $this->getConnection();
            $sql = "UPDATE flights SET 
                    airline = :airline, 
                    route = :route, 
                    flight_time = :time, 
                    duration = :duration, 
                    price = :price, 
                    stops = :stops,
                    updated_by = :admin_id 
                    WHERE id = :id";
            
            $statement = $conn->prepare($sql);
            $statement->bindParam(':id', $id);
            $statement->bindParam(':airline', $airline);
            $statement->bindParam(':route', $route);
            $statement->bindParam(':time', $time);
            $statement->bindParam(':duration', $duration);
            $statement->bindParam(':price', $price);
            $statement->bindParam(':stops', $stops);
            $statement->bindParam(':admin_id', $admin_id);
            
            return $statement->execute();
        } catch (PDOException $e) {
            die("Update Error: " . $e->getMessage());
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