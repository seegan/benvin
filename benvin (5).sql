-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2017 at 06:24 AM
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
-- Table structure for table `wp_shc_return_damage`
--

CREATE TABLE `wp_shc_return_damage` (
  `id` int(11) NOT NULL,
  `master_id` bigint(11) NOT NULL,
  `return_id` bigint(11) NOT NULL,
  `damage_total` decimal(15,2) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_return_damage`
--

INSERT INTO `wp_shc_return_damage` (`id`, `master_id`, `return_id`, `damage_total`, `updated_by`, `active`) VALUES
(1, 12, 9, '457.00', 1, 1),
(2, 12, 10, '100.00', 1, 1),
(3, 12, 11, '300.00', 1, 1),
(4, 12, 12, '1510.00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_return_damage_detail`
--

CREATE TABLE `wp_shc_return_damage_detail` (
  `id` int(11) NOT NULL,
  `damage_id` bigint(11) NOT NULL,
  `master_id` bigint(11) NOT NULL,
  `return_id` bigint(11) NOT NULL,
  `damage_detail` text NOT NULL,
  `damage_charge` decimal(15,2) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_return_damage_detail`
--

INSERT INTO `wp_shc_return_damage_detail` (`id`, `damage_id`, `master_id`, `return_id`, `damage_detail`, `damage_charge`, `active`) VALUES
(1, 3, 12, 11, 'dsdg', '300.00', 1),
(2, 4, 12, 12, 'Damage 1', '1000.00', 0),
(3, 4, 12, 12, 'Damage 2', '2000.00', 0),
(4, 0, 12, 12, 'Damage 11', '1500.00', 0),
(5, 0, 12, 12, 'Damage 21', '2200.00', 0),
(6, 0, 12, 12, 'fdgdfgf', '34.00', 0),
(7, 0, 12, 12, 'fdgdfgf', '34.00', 0),
(8, 4, 12, 12, 'fdgdfgf', '34.00', 0),
(9, 4, 12, 12, 'Damage 1', '1500.00', 0),
(10, 4, 12, 12, 'Damage 4', '10.00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_shc_return_damage`
--
ALTER TABLE `wp_shc_return_damage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_return_damage_detail`
--
ALTER TABLE `wp_shc_return_damage_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_shc_return_damage`
--
ALTER TABLE `wp_shc_return_damage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `wp_shc_return_damage_detail`
--
ALTER TABLE `wp_shc_return_damage_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
