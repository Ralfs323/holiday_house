-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 30, 2024 at 08:13 AM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL,
  `content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `content`) VALUES
(1, 'sdf');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `hashed_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `hashed_password`) VALUES
(1, 'admin', '$2y$10$Jd48fy5q3o3XMVpGKsu6fus9BvMeNtPQMR9T2gZWUuivT.mxEsDWG');

-- --------------------------------------------------------

--
-- Table structure for table `Gallery`
--

CREATE TABLE `Gallery` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `adults` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `email`, `check_in`, `check_out`, `adults`, `children`, `user_id`) VALUES
(1, 'janis', 'janis@example.com', '2024-03-29', '2024-03-31', 1, 0, 0),
(2, 'janis', 'janis@example.com', '2024-03-28', '2024-03-29', 1, 0, 0),
(3, 'janis', 'janis@example.com', '2024-03-29', '2024-03-30', 1, 0, 0),
(4, 'janois', 'fdf\'@gds', '2024-04-04', '2024-04-06', 1, 0, 0),
(5, 'fdfdf', 'fdfdf@rdf', '2024-04-08', '2024-04-09', 3, 0, 0),
(6, 'dada', 'dsds@gthxd', '2024-04-10', '2024-04-11', 3, 3, 0),
(7, 'fdfdf', 'adsd@fdhf', '2024-04-12', '2024-04-13', 1, 0, 0),
(8, 'fdfdf', 'dsdsd@frgtg', '2024-04-14', '2024-04-15', 1, 0, 0),
(9, 'dsdsd', 'sdsds@fdf', '2024-04-16', '2024-04-17', 1, 0, 0),
(10, 'dsdsd', 'rutkovskis2004@gmail.com', '2024-04-21', '2024-04-23', 1, 0, 0),
(11, 'janis', 'janis@example.com', '2024-04-28', '2024-04-30', 1, 0, 0),
(13, '0', 'janis@example.com', '2024-04-18', '2024-04-19', 1, 0, 26),
(14, '0', 'test@example.com', '2024-05-23', '2024-05-24', 2, 3, 24);

-- --------------------------------------------------------

--
-- Table structure for table `Reviews`
--

CREATE TABLE `Reviews` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `review_text` text NOT NULL,
  `rating` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Reviews`
--

INSERT INTO `Reviews` (`id`, `user_name`, `review_text`, `rating`, `status`) VALUES
(1, 'ralfs', 'ir labi', 5, 'approved'),
(2, 'Gatis', 'sdsdsdsdsd', 1, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `RoomPrices`
--

CREATE TABLE `RoomPrices` (
  `id` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `RoomPrices`
--

INSERT INTO `RoomPrices` (`id`, `price`, `description`, `image`) VALUES
(2, '55.00', 'ldfdfd', '../images/room1.jpg'),
(4, '100.00', '5 cilvēkiem', '../images/room1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `surename` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `surename`, `email`, `password_hash`, `is_admin`) VALUES
(24, 'test', 'test', 'test@example.com', '$2y$10$4smBM8.0ljvePask6LPhOeI79yF/osn2AMKWaOGthfIXhd.sZ50lW', 1),
(25, 'ralfs', 'Rut', 'ralfs@test.lv', '$2y$10$NCyCzrYUd/fbW9952hooDefYJOsedJp06.bNxnItutaH5YrXlttUu', 0),
(26, 'janis', 'janis', 'janis@example.com', '$2y$10$ZNLP.b0V/X9UeDtleQ83MuMayqLmaVsBstr5x3uTg3xlQeGsNzbJS', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Gallery`
--
ALTER TABLE `Gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Reviews`
--
ALTER TABLE `Reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `RoomPrices`
--
ALTER TABLE `RoomPrices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Gallery`
--
ALTER TABLE `Gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `Reviews`
--
ALTER TABLE `Reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `RoomPrices`
--
ALTER TABLE `RoomPrices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
