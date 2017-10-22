-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2017 at 01:17 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

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
-- Table structure for table `wp_shc_stock_closing`
--

CREATE TABLE `wp_shc_stock_closing` (
  `id` int(11) NOT NULL,
  `closing_date` date NOT NULL,
  `modified_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_stock_closing_detail`
--

CREATE TABLE `wp_shc_stock_closing_detail` (
  `closing_id` int(11) NOT NULL,
  `lot_id` bigint(20) NOT NULL,
  `closing_stock` bigint(20) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_stock_closing_detail`
--

INSERT INTO `wp_shc_stock_closing_detail` (`closing_id`, `lot_id`, `closing_stock`, `active`) VALUES
(1, 1, -1892, 1),
(1, 2, -30, 1),
(1, 3, 63, 1),
(1, 4, -1040, 1),
(1, 5, -262, 1),
(1, 6, -1761, 1),
(1, 7, 325, 1),
(1, 8, -49, 1),
(1, 9, -11, 1),
(1, 10, -781, 1),
(1, 11, -55, 1),
(1, 12, -1, 1),
(1, 13, -150, 1),
(1, 14, -829, 1),
(1, 15, 30, 1),
(1, 16, -101, 1),
(1, 17, -2410, 1),
(1, 18, -750, 1),
(1, 19, -62, 1),
(1, 20, -143, 1),
(1, 21, 0, 1),
(1, 22, -1, 1),
(1, 23, -11, 1),
(1, 24, 0, 1),
(1, 25, 183, 1),
(1, 26, 59, 1),
(1, 27, 39, 1),
(1, 28, 0, 1),
(1, 29, -40, 1),
(1, 30, 0, 1),
(1, 31, -760, 1),
(1, 32, 0, 1),
(1, 33, 1016, 1),
(1, 34, -373, 1),
(1, 35, 0, 1),
(1, 36, 0, 1),
(1, 37, -1, 1),
(1, 38, 0, 1),
(1, 39, -45, 1),
(1, 40, -13, 1),
(1, 41, -14, 1),
(1, 42, -106, 1),
(1, 43, -51, 1),
(1, 44, -106, 1),
(1, 45, -2000, 1),
(1, 46, -1481, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_shc_stock_closing`
--
ALTER TABLE `wp_shc_stock_closing`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_shc_stock_closing`
--
ALTER TABLE `wp_shc_stock_closing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
