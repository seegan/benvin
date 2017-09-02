-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2017 at 02:11 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wifieud6_uniqueth`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_employee_attendance`
--

CREATE TABLE `wp_employee_attendance` (
  `id` int(11) NOT NULL,
  `emp_id` int(20) NOT NULL,
  `emp_attendance` int(2) NOT NULL,
  `emp_intime` time NOT NULL,
  `emp_outtime` time NOT NULL,
  `emp_nextintime` time NOT NULL,
  `emp_nextouttime` time NOT NULL,
  `attendance_date` datetime DEFAULT NULL,
  `active` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_employee_attendance`
--

INSERT INTO `wp_employee_attendance` (`id`, `emp_id`, `emp_attendance`, `emp_intime`, `emp_outtime`, `emp_nextintime`, `emp_nextouttime`, `attendance_date`, `active`) VALUES
(1, 1, 1, '08:00:00', '12:00:00', '14:00:00', '19:00:00', '2017-09-02 00:00:00', 1),
(2, 2, 1, '07:00:00', '11:00:00', '13:00:00', '20:00:00', '2017-09-02 00:00:00', 1),
(3, 3, 1, '10:00:00', '12:00:00', '00:00:00', '00:00:00', '2017-09-02 00:00:00', 0),
(4, 3, 1, '10:00:00', '12:30:00', '13:00:00', '17:00:00', '2017-09-01 00:00:00', 1),
(5, 3, 1, '10:00:00', '12:00:00', '14:00:00', '21:00:00', '2017-08-31 00:00:00', 1),
(6, 3, 1, '13:00:00', '17:00:00', '00:00:00', '00:00:00', '2017-08-30 00:00:00', 1),
(7, 3, 1, '10:00:00', '14:00:00', '16:00:00', '19:00:00', '2017-08-29 00:00:00', 1),
(8, 3, 0, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '2017-09-02 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_income_list`
--

CREATE TABLE `wp_income_list` (
  `id` int(11) NOT NULL,
  `cash_date` datetime NOT NULL,
  `cash_amount` decimal(9,2) NOT NULL,
  `cash_description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `active` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_income_list`
--

INSERT INTO `wp_income_list` (`id`, `cash_date`, `cash_amount`, `cash_description`, `created_at`, `modified_at`, `active`) VALUES
(1, '2017-08-31 00:00:00', '10000.00', 'saree', '2017-09-02 11:51:28', '0000-00-00 00:00:00', 1),
(2, '2017-08-29 00:00:00', '50000.00', 'properties', '2017-09-02 11:52:00', '0000-00-00 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_employee_attendance`
--
ALTER TABLE `wp_employee_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_income_list`
--
ALTER TABLE `wp_income_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_employee_attendance`
--
ALTER TABLE `wp_employee_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `wp_income_list`
--
ALTER TABLE `wp_income_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
