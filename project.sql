-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 03:05 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `acc_no` int(11) NOT NULL,
  `c_id` int(11) DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `date` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`acc_no`, `c_id`, `balance`, `status`, `date`) VALUES
(20502801, 8, 99.49, 'ACTIVE', '2025-05-03 10:02:43 pm'),
(20502803, 10, 999.99, 'ACTIVE', '2025-05-25 01:08:34 am'),
(20502804, 11, 0, 'ACTIVE', '2025-05-25 01:12:56 am'),
(20502805, 12, 0, 'ACTIVE', '2025-05-25 01:14:44 am'),
(20502806, 13, 0, 'PENDING', '2025-05-25 01:23:20 am');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `number` varchar(11) DEFAULT NULL,
  `password` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `name`, `number`, `password`) VALUES
(8, 'Raiyan Hossain', '01303268944', '123456'),
(10, 'Bisnu Das', '01779511397', '123456'),
(11, 'Tasnim Tabasum', '01723146547', '123456'),
(12, 'Khalid Hossain', '01894738473', '123456'),
(13, 'Shorif Islam', '01938472742', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `t_id` int(11) NOT NULL,
  `acc_no` int(11) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `sender` int(11) DEFAULT NULL,
  `date` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`t_id`, `acc_no`, `type`, `amount`, `sender`, `date`) VALUES
(1, 20502801, 'DEPOSIT', 1, NULL, '2025-05-04 02:53:41 am'),
(4, 20502801, 'DEPOSIT', 1, NULL, '2025-05-24 09:52:10 pm'),
(5, 20502801, 'DEPOSIT', 50, NULL, '2025-05-24 10:23:43 pm'),
(6, 20502801, 'DEPOSIT', 1, NULL, '2025-05-24 10:24:11 pm'),
(7, 20502801, 'WITHDRAW', 3, NULL, '2025-05-24 10:30:39 pm'),
(8, 20502801, 'WITHDRAW', 5, NULL, '2025-05-24 10:30:42 pm'),
(9, 20502801, 'WITHDRAW', 16.12, NULL, '2025-05-24 10:30:51 pm'),
(10, 20502803, 'DEPOSIT', 999.99, NULL, '2025-05-25 01:09:17 am');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`acc_no`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `number` (`number`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`t_id`),
  ADD KEY `acc_no` (`acc_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `acc_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20502807;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`acc_no`) REFERENCES `account` (`acc_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
