-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2017 at 07:24 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `benvin`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_employees`
--

CREATE TABLE `wp_shc_employees` (
  `id` int(11) NOT NULL,
  `emp_name` varchar(255) NOT NULL,
  `emp_mobile` varchar(100) NOT NULL,
  `emp_address` text NOT NULL,
  `emp_salary` decimal(9,2) NOT NULL,
  `emp_joining` datetime NOT NULL,
  `emp_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emp_modified_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `emp_current_status` int(2) NOT NULL DEFAULT '1',
  `updated_by` int(11) NOT NULL,
  `active` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_employees`
--

INSERT INTO `wp_shc_employees` (`id`, `emp_name`, `emp_mobile`, `emp_address`, `emp_salary`, `emp_joining`, `emp_created_at`, `emp_modified_at`, `emp_current_status`, `updated_by`, `active`) VALUES
(1, 'seegan', '9952380502', 'fghfgh', '500.00', '2017-09-29 00:00:00', '2017-09-04 22:42:49', '2017-09-04 22:51:31', 1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_shc_employees`
--
ALTER TABLE `wp_shc_employees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_shc_employees`
--
ALTER TABLE `wp_shc_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
