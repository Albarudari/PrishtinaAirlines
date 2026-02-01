-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2026 at 08:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prishtinaairlines`
--

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `airline` varchar(100) NOT NULL,
  `route` varchar(100) NOT NULL,
  `flight_time` time NOT NULL,
  `duration` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT 'default-flight.jpg',
  `stops` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `airline`, `route`, `flight_time`, `duration`, `price`, `image_url`, `stops`, `created_by`) VALUES
(2, 'Lufthansa', 'PRN-ARS', '10:40:00', '1h20min', 95.00, 'default-flight.jpg', 0, 10),
(3, 'Eurowings', 'PRN-EUR', '12:30:00', '1h50min', 200.00, 'default-flight.jpg', 1, 10),
(4, 'Wizz Air', 'PRN-MUC', '23:30:00', '1h45min', 79.00, 'default-flight.jpg', 0, 10),
(5, 'British Airways', 'PRN-LON', '12:40:00', '2h50min', 300.00, 'default-flight.jpg', 1, 10),
(6, 'Turkish Airlines', 'PRN-IST', '19:50:00', '1h40min', 150.00, 'default-flight.jpg', 0, 10),
(7, 'Austrian Airlines', 'PRN-JFK', '22:50:00', '13h45min', 600.00, 'default-flight.jpg', 2, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
