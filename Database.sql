-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2022 at 02:16 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daemontech`
--
CREATE DATABASE IF NOT EXISTS `daemontech` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `daemontech`;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` int(10) NOT NULL,
  `identificationNo` varchar(10) NOT NULL,
  `checkinDate` date NOT NULL,
  `checkinTime` time NOT NULL,
  `duration` varchar(9) NOT NULL,
  `roomType` varchar(5) NOT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('WAITING','APPROVED','REJECTED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingID`, `identificationNo`, `checkinDate`, `checkinTime`, `duration`, `roomType`, `date_submitted`, `status`) VALUES
(13, 'A20EC0280', '2022-06-18', '17:07:00', 'DURATION4', 'TYPE6', '2022-06-17 09:08:03', 'APPROVED'),
(14, 'A20EC0280', '2022-06-16', '17:13:00', 'DURATION5', 'TYPE3', '2022-06-17 09:13:03', 'REJECTED'),
(15, 'A20EC0280', '2022-06-17', '17:18:00', 'DURATION5', 'TYPE5', '2022-06-17 09:17:42', 'WAITING'),
(16, 'A20EC0280', '2022-06-17', '17:19:00', 'DURATION2', 'TYPE1', '2022-06-17 09:19:17', 'WAITING'),
(17, 'A20EC0280', '2022-06-24', '13:49:00', 'DURATION4', 'TYPE3', '2022-06-18 05:45:08', 'WAITING'),
(18, 'A20EC0280', '2022-06-18', '13:47:00', 'DURATION1', 'TYPE1', '2022-06-18 05:47:46', 'WAITING'),
(19, 'A20EC0280', '2022-06-18', '13:48:00', 'DURATION2', 'TYPE1', '2022-06-18 05:48:51', 'WAITING'),
(20, 'A20EC0280', '2022-06-18', '13:49:00', 'DURATION3', 'TYPE3', '2022-06-18 05:49:07', 'WAITING'),
(21, 'A20EC0280', '2022-06-18', '13:49:00', 'DURATION2', 'TYPE3', '2022-06-18 05:49:23', 'WAITING'),
(22, 'A20EC0280', '2022-06-26', '19:16:00', 'DURATION3', 'TYPE5', '2022-06-26 11:16:33', 'WAITING');

-- --------------------------------------------------------

--
-- Table structure for table `duration`
--

CREATE TABLE `duration` (
  `durationID` varchar(9) NOT NULL,
  `period` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `duration`
--

INSERT INTO `duration` (`durationID`, `period`) VALUES
('DURATION1', '08.00 AM - 09.50 AM'),
('DURATION2', '10.00 AM - 11.50 AM'),
('DURATION3', '12.00 PM - 01.50 PM'),
('DURATION4', '02.00 PM - 03.50 PM'),
('DURATION5', '04.00 PM - 05.50 PM'),
('DURATION6', '08.00 PM - 09.50 PM');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `roomID` varchar(5) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomID`, `description`) VALUES
('TYPE1', 'Lecture Hall'),
('TYPE2', 'Examination Hall'),
('TYPE3', 'Seminar Room'),
('TYPE4', 'Interactive Learning'),
('TYPE5', 'Laboratorium'),
('TYPE6', 'Studio');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` varchar(10) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `userLevel` enum('ADMIN','SPACEMANAGER','LECTURER') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `pass`, `fullName`, `userLevel`) VALUES
('A20EC0280', 'huhuhu', 'M Iqbal Habibie', 'LECTURER'),
('A20EC0281', 'itsame', 'Iqbal', 'LECTURER'),
('A20ECXXX1', 'hahaha', 'Example Mister', 'SPACEMANAGER'),
('admin', 'admin', 'admin', 'ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `FK_IDNO` (`identificationNo`) USING BTREE,
  ADD KEY `FK_DURATIONID` (`duration`),
  ADD KEY `FK_ROOMID` (`roomType`);

--
-- Indexes for table `duration`
--
ALTER TABLE `duration`
  ADD PRIMARY KEY (`durationID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`roomID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`identificationNo`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`roomType`) REFERENCES `room` (`roomID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
