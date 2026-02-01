-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2026 at 08:30 PM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `birthdate`, `nationality`, `country`, `city`, `zip_code`, `phone`, `email`, `password`, `role`, `created_at`) VALUES
(10, 'Gerta', 'Borovci', '2006-12-22', 'Kosovar', 'Kosovo', 'Prishtinë', '10000', '+38344223074', 'borovcigerta@gmail.com', '$2y$10$p34jRIeddL1zh//0S10amuiCrZAprA4CylVqqYWZ6bS7yudHkqOuy', 'admin', '2026-01-31 02:35:47'),
(11, 'ajan', 'Borovci', '2013-09-26', 'Albanian', 'Albania', 'Tirana', '10000', '+38344223074', 'ajanborovci96@gmail.com', '$2y$10$ms9LPiPZ51v4mooyEqpbnOm89liDiMVUdHnMUOn.jzl3QEBoxIC82', 'user', '2026-01-31 21:11:21'),
(18, 'Valza', 'Reqica', '2006-04-25', 'Albanian', 'Kosovo', 'Prishtinë', '10000', '+38344123456', 'valza@gmail.com', '$2y$10$cmKCaBf6fw6JGWpGbwSnNOLak/jKUnuw6egklwLulUdPECxz3Divy', 'user', '2026-02-01 18:09:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
