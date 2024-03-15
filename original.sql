-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2024 at 05:40 PM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `cdetails`
--

CREATE TABLE `cdetails` (
  `hostelid` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `messType` varchar(20) NOT NULL,
  `registration_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cdetails`
--

INSERT INTO `cdetails` (`hostelid`, `name`, `messType`, `registration_date`) VALUES
('21767', 'chandru', 'metro', '2024-03-14 16:54:45'),
('21321', 'david', 'non-veg', '2024-03-14 17:08:07'),
('21769', 'SUNIL', 'veg', '2024-03-14 17:23:12');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_counts`
--

CREATE TABLE `coupon_counts` (
  `id` int(11) NOT NULL,
  `mess_type` varchar(20) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `coupon_counts`
--

INSERT INTO `coupon_counts` (`id`, `mess_type`, `count`) VALUES
(1, 'veg', 95),
(2, 'metro', 42),
(3, 'non-veg', 91);

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `username` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `hostel_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`username`, `email`, `password`, `hostel_id`) VALUES
('SUNIL', 'ALDOSSINBOX@GMAIL.COM', 'sunil123', 21769),
('', 'admin@gmail.com', 'adminpassword', NULL),
('kisan', 'kisannallusamy@gmail.com', '123', 21028),
('nahul', 'nahul@gmail.com', '123', 21030),
('david', 'david@gmail.com', 'david', 21321),
('govind', 'govind@gmail.com', 'govind', 21343),
('chandru', 'chandru@gmail.com', 'chandru', 21767),
('Mishel', 'Mishel@gmail.com', 'mishel', 21752);

-- --------------------------------------------------------

--
-- Table structure for table `fdetails`
--

CREATE TABLE `fdetails` (
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `message` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rdetails`
--

CREATE TABLE `rdetails` (
  `hostelid` int(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `block` int(20) NOT NULL,
  `roomno` varchar(10) NOT NULL,
  `assistantdirector` varchar(20) NOT NULL,
  `daysLeaving` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coupon_counts`
--
ALTER TABLE `coupon_counts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coupon_counts`
--
ALTER TABLE `coupon_counts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
