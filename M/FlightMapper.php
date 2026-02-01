<?php
// M/FlightMapper.php
require_once __DIR__ . '/../Database.php';

class FlightMapper extends Database {

    public function getAllFlights($filterStops = null) {
        try {
            $conn = $this->getConnection();
            $sql = "SELECT * FROM flights";
            $params = [];
            if ($filterStops !== null) {
                if ($filterStops === 2) {
                    $sql .= " WHERE stops >= 2";
                } else {
                    $sql .= " WHERE stops = :stops";
                    $params[':stops'] = $filterStops;
                }
            }
            $sql .= " ORDER BY price ASC";
            $statement = $conn->prepare($sql);
            $statement->execute($params);
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as &$row) {
                if (!isset($row['stops']) && isset($row['is_direct'])) {
                    $row['stops'] = $row['is_direct'] == 1 ? 0 : 1;
                }
            }
            return $rows;
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    public function addFlight($airline, $route, $time, $duration, $price, $stops = 0) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->query("SHOW COLUMNS FROM flights LIKE 'stops'");
            $hasStops = $stmt && $stmt->rowCount() > 0;
            if ($hasStops) {
                $sql = "INSERT INTO flights (airline, route, flight_time, duration, price, stops) 
                        VALUES (:airline, :route, :time, :duration, :price, :stops)";
                $statement = $conn->prepare($sql);
                $statement->bindParam(':stops', $stops);
            } else {
                $isDirect = ($stops === 0) ? 1 : 0;
                $sql = "INSERT INTO flights (airline, route, flight_time, duration, price, is_direct) 
                        VALUES (:airline, :route, :time, :duration, :price, :is_direct)";
                $statement = $conn->prepare($sql);
                $statement->bindParam(':is_direct', $isDirect);
            }
            $statement->bindParam(':airline', $airline);
            $statement->bindParam(':route', $route);
            $statement->bindParam(':time', $time);
            $statement->bindParam(':duration', $duration);
            $statement->bindParam(':price', $price);
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