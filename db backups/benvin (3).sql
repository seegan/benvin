-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2017 at 03:31 PM
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
-- Table structure for table `wp_shc_admin_history`
--

CREATE TABLE `wp_shc_admin_history` (
  `id` bigint(20) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_in` int(11) NOT NULL,
  `detail` text NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_admin_history`
--

INSERT INTO `wp_shc_admin_history` (`id`, `updated_by`, `update_in`, `detail`, `updated_at`, `active`) VALUES
(1, 1, 5, 'site_update', '2017-09-06 11:17:56', 1),
(2, 1, 0, 'special_price_create', '2017-09-06 11:17:56', 1),
(3, 1, 1, 'customer_create', '2017-09-06 11:56:15', 1),
(4, 1, 1, 'site_create', '2017-09-06 12:02:00', 1),
(5, 1, 1, 'site_update', '2017-09-06 12:04:59', 1),
(6, 1, 0, 'special_price_create', '2017-09-06 12:04:59', 1),
(7, 1, 1, 'site_update', '2017-09-06 12:17:42', 1),
(8, 1, 0, 'special_price_create', '2017-09-06 12:17:42', 1),
(9, 1, 1, 'site_update', '2017-09-06 12:25:13', 1),
(10, 1, 0, 'special_price_create', '2017-09-06 12:25:13', 1),
(11, 1, 2, 'customer_create', '2017-09-06 14:17:59', 1),
(12, 1, 0, 'site_create', '2017-09-06 14:23:44', 1),
(13, 1, 0, 'site_create', '2017-09-06 14:24:36', 1),
(14, 1, 2, 'site_create', '2017-09-06 14:27:15', 1),
(15, 1, 2, 'site_update', '2017-09-06 14:28:43', 1),
(16, 1, 0, 'special_price_create', '2017-09-06 14:28:43', 1),
(17, 1, 1, 'master_create', '2017-09-06 14:32:55', 1),
(18, 1, 0, 'master_create', '2017-09-06 14:33:07', 1),
(19, 1, 1, 'deposit_create', '2017-09-06 14:50:52', 1),
(20, 1, 1, 'delivery_create', '2017-09-06 15:14:06', 1),
(21, 1, 1, 'delivery_update', '2017-09-06 15:14:36', 1),
(22, 1, 2, 'delivery_create', '2017-09-06 15:16:22', 1),
(23, 1, 3, 'delivery_create', '2017-09-06 15:17:35', 1),
(24, 1, 1, 'return_create', '2017-09-06 15:24:05', 1),
(25, 1, 2, 'return_create', '2017-09-06 15:26:03', 1),
(26, 1, 1, 'delivery_update', '2017-09-06 15:46:45', 1),
(27, 1, 1, 'hiring_create', '2017-09-06 15:50:26', 1),
(28, 1, 2, 'hiring_create', '2017-09-06 15:53:24', 1),
(29, 1, 1, 'hiring_create', '2017-09-06 15:55:19', 1),
(30, 1, 2, 'hiring_create', '2017-09-06 15:55:35', 1),
(31, 1, 1, 'hiring_update', '2017-09-06 15:58:58', 1),
(32, 1, 2, 'hiring_update', '2017-09-06 16:00:42', 1),
(33, 1, 3, 'hiring_create', '2017-09-06 16:02:39', 1),
(34, 1, 2, 'site_update', '2017-09-06 16:26:39', 1),
(35, 1, 3, 'site_create', '2017-09-06 16:26:39', 1),
(36, 1, 0, 'special_price_create', '2017-09-06 16:26:40', 1),
(37, 1, 3, 'return_create', '2017-09-06 21:31:01', 1),
(38, 1, 4, 'return_create', '2017-09-06 21:31:44', 1),
(39, 1, 5, 'return_create', '2017-09-06 21:35:13', 1),
(40, 1, 4, 'delivery_create', '2017-09-06 23:31:39', 1),
(41, 1, 6, 'return_create', '2017-09-06 23:42:36', 1),
(42, 1, 4, 'hiring_create', '2017-09-06 23:54:21', 1),
(43, 1, 3, 'customer_create', '2017-09-07 09:41:09', 1),
(44, 1, 2, 'site_update', '2017-09-07 09:43:43', 1),
(45, 1, 3, 'site_update', '2017-09-07 09:43:43', 1),
(46, 1, 0, 'special_price_create', '2017-09-07 09:43:43', 1),
(47, 1, 4, 'site_create', '2017-09-07 09:43:54', 1),
(48, 1, 2, 'deposit_create', '2017-09-07 11:48:10', 1),
(49, 1, 2, 'deposit_update', '2017-09-07 12:17:54', 1),
(50, 1, 2, 'site_update', '2017-09-07 16:07:55', 1),
(51, 1, 3, 'site_update', '2017-09-07 16:07:55', 1),
(52, 1, 0, 'special_price_create', '2017-09-07 16:07:55', 1),
(53, 1, 2, 'site_update', '2017-09-07 17:14:47', 1),
(54, 1, 3, 'site_update', '2017-09-07 17:14:47', 1),
(55, 1, 0, 'special_price_create', '2017-09-07 17:14:47', 1),
(56, 1, 5, 'hiring_create', '2017-09-07 17:25:57', 1),
(57, 1, 5, 'hiring_update', '2017-09-07 17:26:58', 1),
(58, 1, 5, 'hiring_update', '2017-09-07 17:30:46', 1),
(59, 1, 2, 'deposit_update', '2017-09-07 17:42:51', 1),
(60, 1, 6, 'hiring_create', '2017-09-07 22:14:54', 1),
(61, 1, 6, 'hiring_update', '2017-09-07 22:21:47', 1),
(62, 1, 3, 'deposit_create', '2017-09-08 07:48:02', 1),
(63, 1, 5, 'delivery_create', '2017-09-08 07:50:52', 1),
(64, 1, 5, 'delivery_update', '2017-09-08 07:51:16', 1),
(65, 1, 5, 'delivery_update', '2017-09-08 07:51:50', 1),
(66, 1, 7, 'return_create', '2017-09-08 07:56:52', 1),
(67, 1, 5, 'hiring_update', '2017-09-08 08:04:55', 1),
(68, 1, 6, 'hiring_update', '2017-09-08 08:08:32', 1),
(69, 1, 6, 'delivery_create', '2017-09-08 11:15:40', 1),
(70, 1, 6, 'delivery_update', '2017-09-08 11:15:52', 1),
(71, 1, 5, 'hiring_update', '2017-09-08 11:21:52', 1),
(72, 1, 3, 'deposit_update', '2017-09-08 11:28:45', 1),
(73, 1, 6, 'delivery_update', '2017-09-08 11:30:50', 1),
(74, 1, 6, 'quotation_create', '2017-09-09 12:01:44', 1),
(75, 1, 8, 'return_create', '2017-09-11 10:54:15', 1),
(76, 1, 1, 'lost_create', '2017-09-11 10:54:16', 1),
(77, 1, 9, 'return_create', '2017-09-11 11:02:46', 1),
(78, 1, 0, 'lost_create', '2017-09-11 11:02:46', 1),
(79, 1, 10, 'return_create', '2017-09-11 11:18:05', 1),
(80, 1, 11, 'return_create', '2017-09-11 11:40:11', 1),
(81, 1, 0, 'lost_create', '2017-09-11 11:40:11', 1),
(82, 1, 3, 'return_update', '2017-09-11 13:53:22', 1),
(83, 1, 5, 'lot_update', '2017-09-11 14:59:21', 1),
(84, 1, 12, 'return_create', '2017-09-11 15:16:07', 1),
(85, 1, 0, 'lost_create', '2017-09-11 15:16:08', 1),
(86, 1, 13, 'return_create', '2017-09-11 15:18:27', 1),
(87, 1, 14, 'return_create', '2017-09-11 15:21:49', 1),
(88, 1, 0, 'lost_create', '2017-09-11 15:21:49', 1),
(89, 1, 15, 'return_create', '2017-09-11 15:22:43', 1),
(90, 1, 16, 'return_create', '2017-09-11 15:23:02', 1),
(91, 1, 17, 'return_create', '2017-09-11 15:23:23', 1),
(92, 1, 18, 'return_create', '2017-09-11 15:23:54', 1),
(93, 1, 19, 'return_create', '2017-09-11 15:24:34', 1),
(94, 1, 20, 'return_create', '2017-09-11 15:28:24', 1),
(95, 1, 3, 'lost_create', '2017-09-11 15:28:25', 1),
(96, 1, 21, 'return_create', '2017-09-11 15:46:08', 1),
(97, 1, 22, 'return_create', '2017-09-11 15:46:43', 1),
(98, 1, 4, 'lost_create', '2017-09-11 15:46:43', 1),
(99, 1, 18, 'lot_update', '2017-09-11 17:55:06', 1),
(100, 1, 23, 'return_create', '2017-09-11 17:55:28', 1),
(101, 1, 5, 'lost_create', '2017-09-11 17:55:28', 1),
(102, 1, 24, 'return_create', '2017-09-12 10:22:43', 1),
(103, 1, 6, 'lost_create', '2017-09-12 10:22:43', 1),
(104, 1, 24, 'lost_update', '2017-09-12 10:24:47', 1),
(105, 1, 24, 'lost_update', '2017-09-12 10:25:12', 1),
(106, 1, 24, 'lost_update', '2017-09-12 10:25:29', 1),
(107, 1, 1, 'obc_create', '2017-09-12 16:24:19', 1),
(108, 1, 0, 'obc_create', '2017-09-12 17:15:24', 1),
(109, 1, 0, 'obc_create', '2017-09-12 17:16:18', 1),
(110, 1, 0, 'obc_create', '2017-09-12 17:17:53', 1),
(111, 1, 2, 'obc_create', '2017-09-12 17:19:20', 1),
(112, 1, 3, 'obc_create', '2017-09-12 17:20:34', 1),
(113, 1, 3, 'obc_update', '2017-09-12 17:27:37', 1),
(114, 1, 25, 'return_create', '2017-09-12 17:36:43', 1),
(115, 1, 7, 'lost_create', '2017-09-12 17:36:44', 1),
(116, 1, 25, 'lost_update', '2017-09-12 17:37:11', 1),
(117, 1, 4, 'customer_create', '2017-09-12 18:41:53', 1),
(118, 1, 5, 'site_create', '2017-09-12 18:42:17', 1),
(119, 1, 2, 'master_create', '2017-09-12 18:42:31', 1),
(120, 1, 7, 'delivery_create', '2017-09-12 18:49:28', 1),
(121, 1, 4, 'deposit_create', '2017-09-12 18:50:51', 1),
(122, 1, 4, 'obc_create', '2017-09-12 18:51:30', 1),
(123, 1, 4, 'obc_update', '2017-09-12 18:51:40', 1),
(124, 1, 4, 'obc_update', '2017-09-12 18:51:53', 1),
(125, 1, 4, 'obc_update', '2017-09-12 18:52:02', 1),
(126, 1, 4, 'obc_update', '2017-09-12 18:52:29', 1),
(127, 1, 4, 'obc_update', '2017-09-12 18:52:37', 1),
(128, 1, 4, 'obc_update', '2017-09-12 18:53:20', 1),
(129, 1, 4, 'obc_update', '2017-09-12 18:53:40', 1),
(130, 1, 2, 'obc_update', '2017-09-12 18:54:20', 1),
(131, 1, 4, 'obc_update', '2017-09-12 18:57:25', 1),
(132, 1, 4, 'obc_update', '2017-09-12 18:57:31', 1),
(133, 1, 4, 'obc_update', '2017-09-12 18:59:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_companies`
--

CREATE TABLE `wp_shc_companies` (
  `id` int(11) NOT NULL,
  `company_id` varchar(10) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` text NOT NULL,
  `mobile` text NOT NULL,
  `tin_number` text NOT NULL,
  `gst_number` text NOT NULL,
  `current_year` int(4) NOT NULL,
  `financial_year` varchar(255) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_companies`
--

INSERT INTO `wp_shc_companies` (`id`, `company_id`, `company_name`, `address`, `phone`, `mobile`, `tin_number`, `gst_number`, `current_year`, `financial_year`, `active`) VALUES
(1, 'BEN', 'Benvin Associates', '5 V.G.P Santhanammal Nagar, Velachery Main Road, Gowrivakkam, Chennai 600073', '2278 0605 / 2278 1866', '94440 50664', '', '33AALPF8569L1Z5', 2017, '2017 - 2018', 1),
(2, 'JVB', 'JVB Associates', '1 V.G.P Santhanammal Nagar, Velachery Main Road, Gowrivakkam, Chennai 600073', '2278 0605 / 2278 1866', '94440 50664', '', '33AEBPC6423Q1ZJ', 2017, '2017 - 2018', 1),
(3, 'JBC', 'JBC Associates', 'Plot No 28 Mambakkam Main Road, Ponmar, Chennai - 600 048', '2278 0605 / 2278 1866', '94440 50664', '33446373536', '33BGIPC3084P1Z6', 2017, '2017 - 2018', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_companies_master`
--

CREATE TABLE `wp_shc_companies_master` (
  `id` int(11) NOT NULL,
  `company_id` varchar(10) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` text NOT NULL,
  `mobile` text NOT NULL,
  `tin_number` text NOT NULL,
  `gst_number` text NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_companies_master`
--

INSERT INTO `wp_shc_companies_master` (`id`, `company_id`, `company_name`, `address`, `phone`, `mobile`, `tin_number`, `gst_number`, `active`) VALUES
(1, 'BEN', 'Benvin Associates', '5 V.G.P Santhanammal Nagar, Velachery Main Road, Gowrivakkam, Chennai 600073', '2278 0605 / 2278 1866', '94440 50664', '', '33AALPF8569L1Z5', 1),
(2, 'JVB', 'JVB Associates', '1 V.G.P Santhanammal Nagar, Velachery Main Road, Gowrivakkam, Chennai 600073', '2278 0605 / 2278 1866', '94440 50664', '', '33AEBPC6423Q1ZJ', 1),
(3, 'JBC', 'JBC Associates', 'Plot No 28 Mambakkam Main Road, Ponmar, Chennai - 600 048', '2278 0605 / 2278 1866', '94440 50664', '33446373536', '33BGIPC3084P1Z6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_customers`
--

CREATE TABLE `wp_shc_customers` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'retail',
  `bill_from_comp` int(2) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_customers`
--

INSERT INTO `wp_shc_customers` (`id`, `name`, `mobile`, `address`, `type`, `bill_from_comp`, `created_at`, `modified_at`, `updated_by`, `active`) VALUES
(1, 'M.Arunachalam Projects And Infrastructure Co.Pvt.Ltd', '044 - 28112881', 'RSS Building in Chennai - 600003', 'retail', 3, '2017-09-06 11:56:14', '0000-00-00 00:00:00', 1, 1),
(2, 'M/S. ENMAS GB POWER SYSTEMS PROJECTS LTD', '044 4901 8100', 'V Floor. Guna Building Annexe, 443 Anna Salai,\r\nTheynampet, Chennai - 600 018', 'retail', 3, '2017-09-06 14:17:59', '0000-00-00 00:00:00', 1, 1),
(3, 'new', '45435', 'dfgfdg', 'retail', 2, '2017-09-07 09:41:09', '0000-00-00 00:00:00', 1, 1),
(4, 'seegan', '56545', 'fdgfdgdf', 'retail', 1, '2017-09-12 18:41:53', '0000-00-00 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_customer_site`
--

CREATE TABLE `wp_shc_customer_site` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `site_address` text NOT NULL,
  `phone_number` varchar(250) NOT NULL,
  `extra_contact` text NOT NULL,
  `gst_number` varchar(255) NOT NULL,
  `gst_for` varchar(10) NOT NULL,
  `vat_number` varchar(255) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_customer_site`
--

INSERT INTO `wp_shc_customer_site` (`id`, `customer_id`, `site_name`, `site_address`, `phone_number`, `extra_contact`, `gst_number`, `gst_for`, `vat_number`, `discount`, `created_at`, `modified_at`, `updated_by`, `active`) VALUES
(1, 1, 'RSS Building (Chennai Central)', 'Arunachala, 2nd Floor,\r\nNo.107/76, Avvai Shanmugam Salai', '044 - 28112881', 'Phone 1 : 28111775, \r\nPhone 2 : 28115038,\r\nPhone 3 : 28112673,\r\nFax : 044 - 28111635\r\n', '33BGIPC3084PIZ6', 'cgst', '33446373536', '0.00', '2017-09-06 12:02:00', '2017-09-06 12:25:13', 1, 1),
(2, 2, 'Thiruvankaranai - W/O 1', 'Enmas GB Power Systems Projects Ltd.,\r\nc/o Jeppiaar Power Corporation Pvt. Ltd.,\r\nThiruvankaranai', '9952004235', '', '33AAACE1267G1Z2', 'cgst', '33660821076', '5.00', '2017-09-06 14:27:15', '2017-09-07 17:14:47', 1, 1),
(3, 2, 'Thiruvankaranai - W/O 2', 'Enmas GB Power Systems Projects Ltd.,\r\nc/o Jeppiaar Power Corporation Pvt. Ltd.,\r\nThiruvankaranai', '9952004235', '', '33AAACE1267G1Z2', 'cgst', '33660821076', '0.00', '2017-09-06 16:26:39', '0000-00-00 00:00:00', 1, 1),
(4, 3, 'fgdfg', 'vcbvcb', '53453', '', '', 'cgst', '', '4.00', '2017-09-07 09:43:54', '0000-00-00 00:00:00', 1, 1),
(5, 4, 'karungal', 'fgdfgdfg,fdgdfgdfg', '45654', '', 'DFD3434', 'cgst', 'V223232', '2.00', '2017-09-12 18:42:17', '0000-00-00 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_delivery`
--

CREATE TABLE `wp_shc_delivery` (
  `id` int(11) NOT NULL,
  `bill_from_comp` int(2) NOT NULL,
  `financial_year` int(4) NOT NULL,
  `bill_no` bigint(11) NOT NULL,
  `ref_number` varchar(255) NOT NULL,
  `master_id` int(11) NOT NULL,
  `delivery_date` datetime NOT NULL,
  `last_billed_date` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vehicle_number` varchar(255) NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `driver_mobile` varchar(255) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_delivery`
--

INSERT INTO `wp_shc_delivery` (`id`, `bill_from_comp`, `financial_year`, `bill_no`, `ref_number`, `master_id`, `delivery_date`, `last_billed_date`, `created_at`, `vehicle_number`, `driver_name`, `driver_mobile`, `updated_by`, `active`) VALUES
(1, 3, 2016, 1, '', 1, '2016-12-27 09:36:00', '2016-12-26', '2017-09-06 15:14:06', 'TN32W6688', 'Ayyanar', '9444646763', 1, 1),
(2, 3, 2016, 2, '', 1, '2017-01-06 09:45:00', '2017-01-05', '2017-09-06 15:16:22', 'TN22CR2113', 'Murugan', '', 1, 1),
(3, 3, 2016, 3, '', 1, '2017-02-04 09:46:00', '2017-02-03', '2017-09-06 15:17:35', 'TN22CR2113', 'Murugan', '', 1, 1),
(4, 3, 0, 4, '', 1, '2017-03-08 17:58:00', '2017-03-07', '2017-09-06 23:31:39', '', '', '', 1, 1),
(5, 3, 2016, 4, '', 1, '2016-09-08 02:19:00', '2016-09-07', '2017-09-08 07:50:52', '', '', '', 1, 1),
(6, 3, 2017, 1, 'fdgfdg', 1, '2017-09-08 05:45:00', '2017-09-07', '2017-09-08 11:15:40', '', '', '', 1, 1),
(7, 1, 2017, 1, '', 2, '2017-09-12 13:12:00', '2017-09-11', '2017-09-12 18:49:28', 'TN75 2323', 'sdfsd', '435345345', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_delivery_detail`
--

CREATE TABLE `wp_shc_delivery_detail` (
  `id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `lot_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `rate_per_unit` decimal(15,2) NOT NULL,
  `delivery_date` date NOT NULL,
  `last_billed_date` date NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_delivery_detail`
--

INSERT INTO `wp_shc_delivery_detail` (`id`, `delivery_id`, `master_id`, `lot_id`, `qty`, `rate_per_unit`, `delivery_date`, `last_billed_date`, `active`) VALUES
(1, 1, 1, 14, 1000, '1.80', '2016-12-27', '2016-12-26', 1),
(2, 1, 1, 18, 2000, '0.30', '2016-12-27', '2016-12-26', 1),
(3, 2, 1, 18, 1300, '0.30', '2017-01-06', '2017-01-05', 1),
(4, 3, 1, 18, 1500, '0.30', '2017-02-04', '2017-02-03', 1),
(5, 4, 1, 16, 10, '0.25', '2017-03-08', '2017-03-07', 1),
(6, 5, 1, 4, 100, '2.00', '2016-09-08', '2016-09-07', 1),
(7, 6, 1, 5, 100, '3.00', '2017-09-08', '2017-09-07', 1),
(8, 7, 2, 4, 100, '2.00', '2017-09-12', '2017-09-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_deposit`
--

CREATE TABLE `wp_shc_deposit` (
  `id` int(11) NOT NULL,
  `bill_from_comp` int(2) NOT NULL,
  `financial_year` int(4) NOT NULL,
  `bill_no` bigint(11) NOT NULL,
  `ref_number` varchar(255) NOT NULL,
  `master_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `amt_times` int(2) NOT NULL,
  `total_thirty_days` decimal(15,2) NOT NULL,
  `total_ninety_days` decimal(15,2) NOT NULL,
  `deposit_date` datetime NOT NULL,
  `discount_avail` varchar(5) NOT NULL,
  `discount_percentage` decimal(10,2) NOT NULL,
  `discount_amt` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `active` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_deposit`
--

INSERT INTO `wp_shc_deposit` (`id`, `bill_from_comp`, `financial_year`, `bill_no`, `ref_number`, `master_id`, `customer_id`, `site_id`, `amt_times`, `total_thirty_days`, `total_ninety_days`, `deposit_date`, `discount_avail`, `discount_percentage`, `discount_amt`, `total`, `created_at`, `modified_at`, `updated_by`, `active`) VALUES
(1, 3, 2016, 4, '', 1, 2, 2, 3, '72000.00', '216000.00', '2016-12-27 09:03:00', '', '0.00', '0.00', '0.00', '2017-09-06 14:50:52', '2017-09-09 10:45:40', 1, 1),
(2, 3, 2017, 5, '', 1, 2, 2, 3, '45750.00', '137250.00', '2017-09-07 06:17:00', 'no', '0.00', '0.00', '137250.00', '2017-09-07 11:48:10', '2017-09-09 10:45:32', 1, 1),
(3, 3, 2017, 5, '43df', 1, 2, 2, 3, '6000.00', '18000.00', '2017-09-08 02:16:00', 'yes', '5.00', '900.00', '17100.00', '2017-09-08 07:48:02', '2017-09-08 11:28:45', 1, 1),
(4, 1, 2017, 1, '', 2, 4, 5, 3, '90.00', '27000.00', '2017-09-11 13:19:00', 'yes', '2.00', '540.00', '26460.00', '2017-09-12 18:50:51', '0000-00-00 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_deposit_cheque`
--

CREATE TABLE `wp_shc_deposit_cheque` (
  `id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `deposit_id` int(11) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `cheque_date` date NOT NULL,
  `cheque_amount` decimal(10,0) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_deposit_cheque`
--

INSERT INTO `wp_shc_deposit_cheque` (`id`, `master_id`, `deposit_id`, `cheque_no`, `cheque_date`, `cheque_amount`, `active`) VALUES
(1, 1, 1, '518000', '2016-12-16', '207600', 1),
(2, 1, 2, 'dfdsdg', '2017-09-01', '100000', 1),
(3, 1, 3, '0.00', '0000-00-00', '0', 1),
(4, 2, 4, 'EERE343434', '2017-09-12', '30000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_deposit_detail`
--

CREATE TABLE `wp_shc_deposit_detail` (
  `id` int(11) NOT NULL,
  `deposit_id` int(11) NOT NULL,
  `lot_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `rate_thirty` decimal(15,2) NOT NULL,
  `rate_ninety` decimal(15,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_deposit_detail`
--

INSERT INTO `wp_shc_deposit_detail` (`id`, `deposit_id`, `lot_id`, `qty`, `unit_price`, `rate_thirty`, `rate_ninety`, `created_at`, `modified_at`, `active`) VALUES
(1, 1, 14, 1000, '1.80', '54000.00', '162000.00', '2017-09-06 14:50:53', '0000-00-00 00:00:00', 1),
(2, 1, 17, 2000, '0.30', '18000.00', '54000.00', '2017-09-06 14:50:53', '0000-00-00 00:00:00', 1),
(3, 2, 10, 500, '3.00', '45000.00', '135000.00', '2017-09-07 11:48:10', '2017-09-07 17:42:51', 1),
(4, 2, 16, 100, '0.25', '750.00', '2250.00', '2017-09-07 11:48:10', '2017-09-07 17:42:52', 1),
(5, 3, 4, 100, '2.00', '6000.00', '18000.00', '2017-09-08 07:48:03', '2017-09-08 11:28:45', 1),
(6, 4, 3, 100, '3.00', '90.00', '27000.00', '2017-09-12 18:50:52', '0000-00-00 00:00:00', 1);

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

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_employee_attendance`
--

CREATE TABLE `wp_shc_employee_attendance` (
  `id` int(11) NOT NULL,
  `emp_id` int(20) NOT NULL,
  `emp_attendance` int(2) NOT NULL,
  `attendance_date` datetime DEFAULT NULL,
  `active` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_hiring`
--

CREATE TABLE `wp_shc_hiring` (
  `id` int(11) NOT NULL,
  `bill_from_comp` int(2) NOT NULL,
  `financial_year` int(4) NOT NULL,
  `bill_no` bigint(11) NOT NULL,
  `ref_number` varchar(255) NOT NULL,
  `master_id` int(11) NOT NULL,
  `bill_from` date NOT NULL,
  `bill_to` date NOT NULL,
  `return_ids` text NOT NULL,
  `transportation_charge` decimal(15,2) NOT NULL,
  `sub_tot` decimal(15,2) NOT NULL,
  `discount_avail` varchar(5) NOT NULL,
  `discount_percentage` decimal(10,2) NOT NULL,
  `discount_amount` decimal(15,2) NOT NULL,
  `total_after_discount` decimal(15,2) NOT NULL,
  `tax_from` varchar(10) NOT NULL,
  `gst_for` varchar(20) NOT NULL,
  `igst_amt` decimal(15,2) NOT NULL,
  `cgst_amt` decimal(15,2) NOT NULL,
  `sgst_amt` decimal(15,2) NOT NULL,
  `vat_amt` decimal(15,2) NOT NULL,
  `tax_include_tot` decimal(15,2) NOT NULL,
  `round_off` decimal(15,2) NOT NULL,
  `hiring_total` decimal(15,2) NOT NULL,
  `bill_date` date NOT NULL,
  `bill_time` time NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_hiring`
--

INSERT INTO `wp_shc_hiring` (`id`, `bill_from_comp`, `financial_year`, `bill_no`, `ref_number`, `master_id`, `bill_from`, `bill_to`, `return_ids`, `transportation_charge`, `sub_tot`, `discount_avail`, `discount_percentage`, `discount_amount`, `total_after_discount`, `tax_from`, `gst_for`, `igst_amt`, `cgst_amt`, `sgst_amt`, `vat_amt`, `tax_include_tot`, `round_off`, `hiring_total`, `bill_date`, `bill_time`, `created_at`, `modified_at`, `updated_by`, `active`) VALUES
(1, 3, 2016, 1, '', 1, '2016-12-27', '2017-01-31', '1', '0.00', '94808.40', '', '0.00', '0.00', '0.00', '', 'cgst', '0.00', '8532.76', '8532.76', '0.00', '111873.92', '0.00', '111873.92', '2017-01-31', '10:27:00', '2017-09-06 15:55:19', '2017-09-06 23:44:39', 1, 1),
(2, 3, 2016, 2, '', 1, '2017-02-01', '2017-02-28', '', '0.00', '81289.20', '', '0.00', '0.00', '0.00', '', 'cgst', '0.00', '7316.03', '7316.03', '0.00', '95921.26', '0.00', '95921.26', '2017-02-28', '10:29:00', '2017-09-06 15:55:35', '2017-09-06 23:44:45', 1, 1),
(3, 3, 2016, 3, '', 1, '2017-03-01', '2017-03-31', '', '0.00', '91493.40', '', '0.00', '0.00', '0.00', '', 'cgst', '0.00', '8234.41', '8234.41', '0.00', '107962.22', '0.00', '107962.22', '2017-03-31', '10:30:00', '2017-09-06 16:02:39', '2017-09-06 23:44:49', 1, 1),
(4, 3, 0, 1, '', 1, '2017-04-01', '2017-04-30', '', '0.00', '88455.00', '', '0.00', '0.00', '0.00', '', 'cgst', '0.00', '7960.95', '7960.95', '0.00', '104376.90', '0.00', '104376.90', '2017-04-01', '18:23:00', '2017-09-06 23:54:21', '0000-00-00 00:00:00', 1, 1),
(5, 3, 2017, 1, 'DFEE23', 1, '2017-09-01', '2017-09-30', '3, 5, 7', '0.00', '79813.60', 'no', '0.00', '0.00', '79813.60', 'gst', 'cgst', '0.00', '7183.22', '7183.22', '0.00', '94180.04', '0.00', '94180.04', '2017-09-08', '05:51:00', '2017-09-07 17:25:57', '2017-09-08 11:21:52', 1, 1),
(6, 3, 2017, 1, '', 1, '2017-08-01', '2017-08-31', '2', '6250.00', '103151.50', 'no', '0.00', '0.00', '103151.50', 'gst', 'cgst', '0.00', '9283.64', '9283.64', '0.00', '121718.78', '0.00', '121718.78', '2017-09-08', '02:38:00', '2017-09-07 22:14:54', '2017-09-08 08:08:32', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_hiring_detail`
--

CREATE TABLE `wp_shc_hiring_detail` (
  `id` int(11) NOT NULL,
  `hiring_bill_id` int(11) NOT NULL,
  `delivery_detail_id` int(11) NOT NULL,
  `lot_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `bill_from` date NOT NULL,
  `bill_to` date NOT NULL,
  `bill_days` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `total_days` int(11) NOT NULL,
  `rate_per_day` decimal(15,2) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `got_return` int(1) NOT NULL,
  `min_checkbox_avail` int(1) NOT NULL,
  `min_checked` int(1) NOT NULL,
  `hiring_amt` decimal(15,2) NOT NULL,
  `hiring_amt_min` decimal(15,2) NOT NULL,
  `for_thirty_days` decimal(15,2) NOT NULL,
  `previous_paid` decimal(15,2) NOT NULL,
  `bal_to_pay` decimal(15,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_hiring_detail`
--

INSERT INTO `wp_shc_hiring_detail` (`id`, `hiring_bill_id`, `delivery_detail_id`, `lot_id`, `qty`, `bill_from`, `bill_to`, `bill_days`, `delivery_date`, `total_days`, `rate_per_day`, `amount`, `got_return`, `min_checkbox_avail`, `min_checked`, `hiring_amt`, `hiring_amt_min`, `for_thirty_days`, `previous_paid`, `bal_to_pay`, `created_at`, `modified_at`, `active`) VALUES
(1, 1, 1, 14, 1000, '2016-12-27', '2017-01-31', 36, '0000-00-00', 0, '1.80', '64800.00', 0, 0, 0, '64800.00', '0.00', '0.00', '0.00', '0.00', '2017-09-06 15:55:20', '2017-09-06 15:58:58', 0),
(2, 1, 3, 18, 1300, '2017-01-06', '2017-01-31', 26, '0000-00-00', 0, '0.30', '10140.00', 0, 0, 0, '10140.00', '0.00', '0.00', '0.00', '0.00', '2017-09-06 15:55:20', '2017-09-06 15:58:58', 0),
(3, 1, 2, 18, 1038, '2016-12-27', '2017-01-31', 36, '0000-00-00', 0, '0.30', '11210.40', 0, 0, 0, '11210.40', '0.00', '0.00', '0.00', '0.00', '2017-09-06 15:55:20', '2017-09-06 15:58:58', 0),
(4, 1, 2, 18, 962, '2016-12-27', '2017-01-06', 11, '2016-12-27', 11, '0.30', '8658.00', 1, 1, 1, '3174.60', '8658.00', '8658.00', '0.00', '8658.00', '2017-09-06 15:55:20', '2017-09-06 15:58:58', 0),
(5, 2, 1, 14, 1000, '2017-02-01', '2017-02-28', 28, '0000-00-00', 0, '1.80', '50400.00', 0, 0, 0, '50400.00', '0.00', '0.00', '0.00', '0.00', '2017-09-06 15:55:35', '2017-09-06 16:00:42', 0),
(6, 2, 4, 18, 1500, '2017-02-04', '2017-02-28', 25, '0000-00-00', 0, '0.30', '11250.00', 0, 0, 0, '11250.00', '0.00', '0.00', '0.00', '0.00', '2017-09-06 15:55:35', '2017-09-06 16:00:42', 0),
(7, 2, 2, 18, 2338, '2017-02-01', '2017-02-28', 28, '0000-00-00', 0, '0.30', '19639.20', 0, 0, 0, '19639.20', '0.00', '0.00', '0.00', '0.00', '2017-09-06 15:55:35', '2017-09-06 16:00:42', 0),
(8, 1, 1, 14, 1000, '2016-12-27', '2017-01-31', 36, '0000-00-00', 0, '1.80', '64800.00', 0, 0, 0, '64800.00', '0.00', '0.00', '0.00', '0.00', '2017-09-06 15:58:58', '0000-00-00 00:00:00', 1),
(9, 1, 3, 18, 1300, '2017-01-06', '2017-01-31', 26, '0000-00-00', 0, '0.30', '10140.00', 0, 0, 0, '10140.00', '0.00', '0.00', '0.00', '0.00', '2017-09-06 15:58:58', '0000-00-00 00:00:00', 1),
(10, 1, 2, 18, 1038, '2016-12-27', '2017-01-31', 36, '0000-00-00', 0, '0.30', '11210.40', 0, 0, 0, '11210.40', '0.00', '0.00', '0.00', '0.00', '2017-09-06 15:58:58', '0000-00-00 00:00:00', 1),
(11, 1, 2, 18, 962, '2016-12-27', '2017-01-06', 11, '2016-12-27', 11, '0.30', '8658.00', 1, 1, 1, '3174.60', '8658.00', '8658.00', '0.00', '8658.00', '2017-09-06 15:58:58', '0000-00-00 00:00:00', 1),
(12, 2, 1, 14, 1000, '2017-02-01', '2017-02-28', 28, '0000-00-00', 0, '1.80', '50400.00', 0, 0, 0, '50400.00', '0.00', '0.00', '0.00', '0.00', '2017-09-06 16:00:42', '0000-00-00 00:00:00', 1),
(13, 2, 4, 18, 1500, '2017-02-04', '2017-02-28', 25, '0000-00-00', 0, '0.30', '11250.00', 0, 0, 0, '11250.00', '0.00', '0.00', '0.00', '0.00', '2017-09-06 16:00:42', '0000-00-00 00:00:00', 1),
(14, 2, 2, 18, 2338, '2017-02-01', '2017-02-28', 28, '0000-00-00', 0, '0.30', '19639.20', 0, 0, 0, '19639.20', '0.00', '0.00', '0.00', '0.00', '2017-09-06 16:00:42', '0000-00-00 00:00:00', 1),
(15, 3, 1, 14, 1000, '2017-03-01', '2017-03-31', 31, '0000-00-00', 0, '1.80', '55800.00', 0, 0, 0, '55800.00', '0.00', '0.00', '0.00', '0.00', '2017-09-06 16:02:39', '0000-00-00 00:00:00', 1),
(16, 3, 2, 18, 3838, '2017-03-01', '2017-03-31', 31, '0000-00-00', 0, '0.30', '35693.40', 0, 0, 0, '35693.40', '0.00', '0.00', '0.00', '0.00', '2017-09-06 16:02:39', '0000-00-00 00:00:00', 1),
(17, 4, 1, 14, 997, '2017-04-01', '2017-04-30', 30, '0000-00-00', 0, '1.80', '53838.00', 0, 0, 0, '53838.00', '0.00', '0.00', '0.00', '0.00', '2017-09-06 23:54:21', '0000-00-00 00:00:00', 1),
(18, 4, 5, 16, 10, '2017-04-01', '2017-04-30', 30, '0000-00-00', 0, '0.25', '75.00', 0, 0, 0, '75.00', '0.00', '0.00', '0.00', '0.00', '2017-09-06 23:54:21', '0000-00-00 00:00:00', 1),
(19, 4, 2, 18, 3838, '2017-04-01', '2017-04-30', 30, '0000-00-00', 0, '0.30', '34542.00', 0, 0, 0, '34542.00', '0.00', '0.00', '0.00', '0.00', '2017-09-06 23:54:22', '0000-00-00 00:00:00', 1),
(20, 5, 1, 14, 606, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '1.80', '32724.00', 0, 0, 0, '32724.00', '0.00', '0.00', '0.00', '0.00', '2017-09-07 17:25:57', '2017-09-07 17:26:58', 0),
(21, 5, 5, 16, 10, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '0.25', '75.00', 0, 0, 0, '75.00', '0.00', '0.00', '0.00', '0.00', '2017-09-07 17:25:57', '2017-09-07 17:26:58', 0),
(22, 5, 2, 18, 3838, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '0.30', '34542.00', 0, 0, 0, '34542.00', '0.00', '0.00', '0.00', '0.00', '2017-09-07 17:25:57', '2017-09-07 17:26:58', 0),
(23, 5, 1, 14, 1, '2017-09-01', '2017-09-07', 7, '2016-12-27', 255, '1.80', '12.60', 1, 0, 0, '12.60', '0.00', '0.00', '0.00', '0.00', '2017-09-07 17:25:57', '2017-09-07 17:26:58', 0),
(24, 5, 1, 14, 606, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '1.80', '32724.00', 0, 0, 0, '32724.00', '0.00', '0.00', '0.00', '0.00', '2017-09-07 17:26:59', '2017-09-07 17:30:46', 0),
(25, 5, 5, 16, 10, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '0.25', '75.00', 0, 0, 0, '75.00', '0.00', '0.00', '0.00', '0.00', '2017-09-07 17:26:59', '2017-09-07 17:30:46', 0),
(26, 5, 2, 18, 3838, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '0.30', '34542.00', 0, 0, 0, '34542.00', '0.00', '0.00', '0.00', '0.00', '2017-09-07 17:26:59', '2017-09-07 17:30:46', 0),
(27, 5, 1, 14, 1, '2017-09-01', '2017-09-07', 7, '2016-12-27', 255, '1.80', '12.60', 1, 0, 0, '12.60', '0.00', '0.00', '0.00', '0.00', '2017-09-07 17:26:59', '2017-09-07 17:30:46', 0),
(28, 5, 1, 14, 606, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '1.80', '32724.00', 0, 0, 0, '32724.00', '0.00', '0.00', '0.00', '0.00', '2017-09-07 17:30:46', '2017-09-08 08:04:55', 0),
(29, 5, 5, 16, 10, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '0.25', '75.00', 0, 0, 0, '75.00', '0.00', '0.00', '0.00', '0.00', '2017-09-07 17:30:47', '2017-09-08 08:04:55', 0),
(30, 5, 2, 18, 3838, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '0.30', '34542.00', 0, 0, 0, '34542.00', '0.00', '0.00', '0.00', '0.00', '2017-09-07 17:30:47', '2017-09-08 08:04:55', 0),
(31, 5, 1, 14, 1, '2017-09-01', '2017-09-07', 7, '2016-12-27', 255, '1.80', '12.60', 1, 0, 0, '12.60', '0.00', '0.00', '0.00', '0.00', '2017-09-07 17:30:47', '2017-09-08 08:04:55', 0),
(32, 6, 1, 14, 607, '2017-08-01', '2017-08-31', 31, '0000-00-00', 0, '1.80', '33870.60', 0, 0, 0, '33870.60', '0.00', '0.00', '0.00', '0.00', '2017-09-07 22:14:54', '2017-09-07 22:21:47', 0),
(33, 6, 5, 16, 10, '2017-08-01', '2017-08-31', 31, '0000-00-00', 0, '0.25', '77.50', 0, 0, 0, '77.50', '0.00', '0.00', '0.00', '0.00', '2017-09-07 22:14:54', '2017-09-07 22:21:47', 0),
(34, 6, 2, 18, 3838, '2017-08-01', '2017-08-31', 31, '0000-00-00', 0, '0.30', '35693.40', 0, 0, 0, '35693.40', '0.00', '0.00', '0.00', '0.00', '2017-09-07 22:14:54', '2017-09-07 22:21:47', 0),
(35, 6, 1, 14, 390, '2017-08-01', '2017-08-30', 30, '2016-12-27', 247, '1.80', '21060.00', 1, 0, 0, '21060.00', '0.00', '0.00', '0.00', '0.00', '2017-09-07 22:14:54', '2017-09-07 22:21:47', 0),
(36, 6, 1, 14, 607, '2017-08-01', '2017-08-31', 31, '0000-00-00', 0, '1.80', '33870.60', 0, 0, 0, '33870.60', '0.00', '0.00', '0.00', '0.00', '2017-09-07 22:21:47', '2017-09-08 08:08:32', 0),
(37, 6, 5, 16, 10, '2017-08-01', '2017-08-31', 31, '0000-00-00', 0, '0.25', '77.50', 0, 0, 0, '77.50', '0.00', '0.00', '0.00', '0.00', '2017-09-07 22:21:47', '2017-09-08 08:08:32', 0),
(38, 6, 2, 18, 3838, '2017-08-01', '2017-08-31', 31, '0000-00-00', 0, '0.30', '35693.40', 0, 0, 0, '35693.40', '0.00', '0.00', '0.00', '0.00', '2017-09-07 22:21:47', '2017-09-08 08:08:32', 0),
(39, 6, 1, 14, 390, '2017-08-01', '2017-08-30', 30, '2016-12-27', 247, '1.80', '21060.00', 1, 0, 0, '21060.00', '0.00', '0.00', '0.00', '0.00', '2017-09-07 22:21:48', '2017-09-08 08:08:32', 0),
(40, 5, 6, 4, 90, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '2.00', '5400.00', 0, 0, 0, '5400.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 08:04:55', '2017-09-08 11:21:52', 0),
(41, 5, 1, 14, 606, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '1.80', '32724.00', 0, 0, 0, '32724.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 08:04:55', '2017-09-08 11:21:52', 0),
(42, 5, 5, 16, 10, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '0.25', '75.00', 0, 0, 0, '75.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 08:04:55', '2017-09-08 11:21:52', 0),
(43, 5, 2, 18, 3838, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '0.30', '34542.00', 0, 0, 0, '34542.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 08:04:55', '2017-09-08 11:21:52', 0),
(44, 5, 1, 14, 1, '2017-09-01', '2017-09-07', 7, '2016-12-27', 255, '1.80', '12.60', 1, 0, 0, '12.60', '0.00', '0.00', '0.00', '0.00', '2017-09-08 08:04:56', '2017-09-08 11:21:52', 0),
(45, 5, 6, 4, 10, '2017-09-01', '2017-09-08', 8, '2016-09-08', 366, '2.00', '160.00', 1, 0, 0, '160.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 08:04:56', '2017-09-08 11:21:52', 0),
(46, 6, 6, 4, 100, '2017-08-01', '2017-08-31', 31, '0000-00-00', 0, '2.00', '6200.00', 0, 0, 0, '6200.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 08:08:32', '0000-00-00 00:00:00', 1),
(47, 6, 1, 14, 607, '2017-08-01', '2017-08-31', 31, '0000-00-00', 0, '1.80', '33870.60', 0, 0, 0, '33870.60', '0.00', '0.00', '0.00', '0.00', '2017-09-08 08:08:32', '0000-00-00 00:00:00', 1),
(48, 6, 5, 16, 10, '2017-08-01', '2017-08-31', 31, '0000-00-00', 0, '0.25', '77.50', 0, 0, 0, '77.50', '0.00', '0.00', '0.00', '0.00', '2017-09-08 08:08:32', '0000-00-00 00:00:00', 1),
(49, 6, 2, 18, 3838, '2017-08-01', '2017-08-31', 31, '0000-00-00', 0, '0.30', '35693.40', 0, 0, 0, '35693.40', '0.00', '0.00', '0.00', '0.00', '2017-09-08 08:08:32', '0000-00-00 00:00:00', 1),
(50, 6, 1, 14, 390, '2017-08-01', '2017-08-30', 30, '2016-12-27', 247, '1.80', '21060.00', 1, 0, 0, '21060.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 08:08:32', '0000-00-00 00:00:00', 1),
(51, 5, 6, 4, 90, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '2.00', '5400.00', 0, 0, 0, '5400.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 11:21:52', '0000-00-00 00:00:00', 1),
(52, 5, 7, 5, 100, '2017-09-08', '2017-09-30', 23, '0000-00-00', 0, '3.00', '6900.00', 0, 0, 0, '6900.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 11:21:52', '0000-00-00 00:00:00', 1),
(53, 5, 1, 14, 606, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '1.80', '32724.00', 0, 0, 0, '32724.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 11:21:52', '0000-00-00 00:00:00', 1),
(54, 5, 5, 16, 10, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '0.25', '75.00', 0, 0, 0, '75.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 11:21:52', '0000-00-00 00:00:00', 1),
(55, 5, 2, 18, 3838, '2017-09-01', '2017-09-30', 30, '0000-00-00', 0, '0.30', '34542.00', 0, 0, 0, '34542.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 11:21:52', '0000-00-00 00:00:00', 1),
(56, 5, 1, 14, 1, '2017-09-01', '2017-09-07', 7, '2016-12-27', 255, '1.80', '12.60', 1, 0, 0, '12.60', '0.00', '0.00', '0.00', '0.00', '2017-09-08 11:21:52', '0000-00-00 00:00:00', 1),
(57, 5, 6, 4, 10, '2017-09-01', '2017-09-08', 8, '2016-09-08', 366, '2.00', '160.00', 1, 0, 0, '160.00', '0.00', '0.00', '0.00', '0.00', '2017-09-08 11:21:52', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_loading`
--

CREATE TABLE `wp_shc_loading` (
  `id` int(11) NOT NULL,
  `deposit_id` int(11) NOT NULL,
  `loading_charge` decimal(15,2) NOT NULL,
  `master_id` int(11) NOT NULL,
  `deposit_date` datetime NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_loading`
--

INSERT INTO `wp_shc_loading` (`id`, `deposit_id`, `loading_charge`, `master_id`, `deposit_date`, `active`) VALUES
(1, 1, '2400.00', 1, '2016-12-27 09:03:00', 1),
(2, 2, '800.00', 1, '2017-09-07 06:17:00', 1),
(3, 3, '0.00', 1, '2017-09-08 02:16:00', 1),
(4, 4, '2200.00', 2, '2017-09-11 13:19:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_loading_detail`
--

CREATE TABLE `wp_shc_loading_detail` (
  `id` int(11) NOT NULL,
  `deposit_id` int(11) NOT NULL,
  `loading_id` int(11) NOT NULL,
  `charge_for` varchar(250) NOT NULL,
  `charge_amt` decimal(15,2) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_loading_detail`
--

INSERT INTO `wp_shc_loading_detail` (`id`, `deposit_id`, `loading_id`, `charge_for`, `charge_amt`, `active`) VALUES
(1, 1, 1, 'loading', '2400.00', 1),
(2, 1, 1, 'transportation', '0.00', 1),
(3, 2, 2, 'loading', '300.00', 1),
(4, 2, 2, 'transportation', '500.00', 1),
(5, 3, 3, 'loading', '0.00', 1),
(6, 3, 3, 'transportation', '0.00', 1),
(7, 4, 4, 'loading', '200.00', 1),
(8, 4, 4, 'transportation', '2000.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_lost`
--

CREATE TABLE `wp_shc_lost` (
  `id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `return_id` int(11) NOT NULL,
  `lost_qty` int(11) NOT NULL,
  `lost_total` decimal(15,2) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_lost`
--

INSERT INTO `wp_shc_lost` (`id`, `master_id`, `return_id`, `lost_qty`, `lost_total`, `updated_by`, `active`) VALUES
(1, 1, 8, 90, '17100.00', 1, 1),
(2, 1, 19, 1, '40.00', 1, 1),
(3, 1, 20, 1, '40.00', 1, 1),
(4, 1, 22, 3, '40.00', 1, 1),
(5, 1, 23, 2000, '300000.00', 1, 1),
(6, 1, 24, 340, '50670.00', 1, 1),
(7, 1, 25, 15, '0.00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_lost_detail`
--

CREATE TABLE `wp_shc_lost_detail` (
  `id` bigint(20) NOT NULL,
  `master_id` bigint(11) NOT NULL,
  `lost_id` bigint(11) NOT NULL,
  `return_id` bigint(11) NOT NULL,
  `lot_id` bigint(11) NOT NULL,
  `lost_qty` int(11) NOT NULL,
  `lost_unit_price` int(11) NOT NULL,
  `lost_total` decimal(15,2) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_lost_detail`
--

INSERT INTO `wp_shc_lost_detail` (`id`, `master_id`, `lost_id`, `return_id`, `lot_id`, `lost_qty`, `lost_unit_price`, `lost_total`, `active`) VALUES
(1, 1, 1, 8, 4, 90, 190, '17100.00', 1),
(2, 1, 0, 9, 16, 10, 0, '0.00', 1),
(3, 1, 0, 11, 4, 90, 190, '17100.00', 1),
(4, 1, 0, 12, 5, 50, 40, '2000.00', 1),
(5, 1, 0, 14, 5, 10, 40, '400.00', 1),
(6, 1, 3, 20, 5, 1, 40, '40.00', 1),
(7, 1, 4, 22, 5, 1, 40, '40.00', 1),
(8, 1, 4, 22, 14, 1, 0, '0.00', 1),
(9, 1, 4, 22, 18, 1, 0, '0.00', 1),
(10, 1, 5, 23, 18, 2000, 150, '300000.00', 1),
(11, 1, 6, 24, 5, 3, 40, '120.00', 0),
(12, 1, 6, 24, 5, 3, 40, '120.00', 0),
(13, 1, 6, 24, 14, 337, 0, '0.00', 0),
(14, 1, 6, 24, 5, 3, 40, '120.00', 0),
(15, 1, 6, 24, 5, 3, 40, '120.00', 1),
(16, 1, 6, 24, 18, 337, 150, '50550.00', 1),
(17, 1, 7, 25, 14, 10, 0, '0.00', 0),
(18, 1, 7, 25, 14, 15, 0, '0.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_lots`
--

CREATE TABLE `wp_shc_lots` (
  `id` int(11) NOT NULL,
  `lot_no` varchar(250) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `product_type` varchar(250) NOT NULL,
  `unit_price` decimal(9,2) NOT NULL,
  `tax1` decimal(9,2) NOT NULL,
  `buying_price` decimal(15,2) NOT NULL,
  `weight` decimal(15,2) NOT NULL,
  `stock_in` int(11) NOT NULL DEFAULT '0',
  `sale_out` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `active` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_lots`
--

INSERT INTO `wp_shc_lots` (`id`, `lot_no`, `product_name`, `product_type`, `unit_price`, `tax1`, `buying_price`, `weight`, `stock_in`, `sale_out`, `created_at`, `modified_at`, `active`) VALUES
(1, 'CS1', 'Centring Sheet', '900 x 600mm', '1.10', '0.00', '0.00', '0.00', 0, 0, '2017-07-17 06:36:36', '2017-08-09 14:12:48', 1),
(2, 'ADC1', 'Adj Centring Sheet', '900 x 400 mm', '0.80', '0.00', '0.00', '0.00', 0, 0, '2017-07-17 10:21:02', '2017-08-09 14:16:37', 1),
(3, 'SPAN(N)', 'Tele Span', '2.50x4.15m', '3.00', '0.00', '250.00', '10.00', 0, 0, '2017-07-17 10:22:18', '2017-08-25 14:39:11', 1),
(4, 'P12', 'Tele Props ', '2.00x3.70m', '2.00', '0.00', '190.00', '5.00', 0, 0, '2017-07-17 10:23:02', '2017-08-25 19:51:11', 1),
(5, 'P18', 'Tele Props', '3.15 x 5.70m', '3.00', '0.00', '40.00', '10.00', 0, 0, '2017-08-09 12:02:34', '2017-09-11 14:59:21', 1),
(6, 'STHD STD', 'Stirrup Head', 'Standard', '0.70', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 12:49:29', '2017-08-09 14:17:25', 1),
(7, 'BJKSTD', 'Base Jack ', 'Standard', '0.70', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 12:51:07', '2017-08-09 14:30:56', 1),
(8, 'CS2', 'Centring Sheet', '1150 x 600 mm', '1.40', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:13:42', '2017-08-09 14:15:38', 1),
(9, 'ADC1', 'Adj Centring Sheet', '1150 x 400 mm', '0.90', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:15:17', '0000-00-00 00:00:00', 1),
(10, 'TELS1', 'Tellescopic Span', '2.40 x 4.15 m', '3.00', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:19:20', '2017-08-09 14:21:48', 1),
(11, 'TELS2', 'Tellescopic Span', '3.00 x 4.80 m', '3.50', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:20:31', '0000-00-00 00:00:00', 1),
(12, 'PROPEX', 'Prop Extension', '1m', '1.00', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:28:09', '0000-00-00 00:00:00', 1),
(13, 'LP10', 'Ledger Pipes', '3m', '1.00', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:29:31', '2017-08-10 10:45:05', 1),
(14, 'LP20', 'Ledger Pipes', '6m', '1.80', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:30:03', '2017-08-10 10:44:50', 1),
(15, 'BPLSTD', 'Baseplate', '0.150 x 0.150 m', '0.25', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:31:23', '0000-00-00 00:00:00', 1),
(16, 'EJP', 'Expanding Joint Pin', 'Standard', '0.25', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:32:08', '0000-00-00 00:00:00', 1),
(17, 'FC', 'Coupler Fixed', 'Standard', '0.30', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:32:55', '2017-08-10 11:03:50', 1),
(18, 'SC', 'Coupler Swivel', 'Standard', '0.30', '0.00', '150.00', '0.00', 0, 0, '2017-08-09 14:33:50', '2017-09-11 17:55:06', 1),
(19, 'CC10', 'C.Channel', '3m', '2.50', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:36:19', '0000-00-00 00:00:00', 1),
(20, 'CC20', 'C.Channel', '6m', '4.50', '0.00', '350.00', '10.00', 0, 0, '2017-08-09 14:36:48', '2017-08-25 22:49:47', 1),
(21, 'TIER1', 'Tie Rod', '1.2m', '0.30', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:38:02', '0000-00-00 00:00:00', 1),
(22, 'WALT', 'Waller Plate for Tirod', 'Standard', '0.20', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:38:56', '0000-00-00 00:00:00', 1),
(23, 'WNUT', 'Wing Nut', 'Standard', '0.20', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:43:49', '0000-00-00 00:00:00', 1),
(24, 'CLV10', 'Cuplock Vertical', '3m', '1.50', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:44:46', '0000-00-00 00:00:00', 1),
(25, 'CLV8', 'Cuplock Vertical', '2.5m', '1.20', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:49:40', '0000-00-00 00:00:00', 1),
(26, 'CLV6.5', 'Cuplock Vertical', '2m', '1.00', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:51:14', '0000-00-00 00:00:00', 1),
(27, 'CLV5', 'Cuplock Vertical', '1.5m', '0.90', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:51:51', '0000-00-00 00:00:00', 1),
(28, 'CLV3', 'Cuplock Vertical', '1m', '0.80', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:52:26', '2017-08-09 14:52:37', 1),
(29, 'CLV1.5', 'Cuplock Vertical', '0.50m', '0.60', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:53:19', '2017-08-09 14:53:34', 1),
(30, 'CLH10', 'Cuplock Horizontal', '3m', '1.10', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:54:17', '0000-00-00 00:00:00', 1),
(31, 'CLH6.5', 'Cuplock Horizontal', '2m', '1.00', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:54:51', '0000-00-00 00:00:00', 1),
(32, 'CLH6', 'Cuplock Horizontal', '1.8m', '1.00', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:55:21', '0000-00-00 00:00:00', 1),
(33, 'CLH4', 'Cuplock Horizontal', '1.2m', '0.70', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:55:53', '0000-00-00 00:00:00', 1),
(34, 'CLH3', 'Cuplock Horizontal', '1m', '0.70', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:56:18', '0000-00-00 00:00:00', 1),
(35, 'CLH2.5', 'Cuplock Horizontal', '0.75m', '0.70', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:56:43', '0000-00-00 00:00:00', 1),
(36, 'JPIN', 'Joint Pin (SPIGOT)', '0.30m', '0.20', '0.00', '0.00', '0.00', 0, 0, '2017-08-09 14:57:57', '0000-00-00 00:00:00', 1),
(37, 'WFS', 'Wall Form Sheet', '1200 x 500mm', '2.00', '0.00', '200.00', '1.00', 0, 0, '2017-08-09 14:58:38', '2017-08-20 19:58:30', 1),
(38, 'PP', 'Props Pin', 'Standard', '0.10', '0.00', '0.00', '0.00', 0, 0, '2017-08-10 10:49:26', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_master`
--

CREATE TABLE `wp_shc_master` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `master_date` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_master`
--

INSERT INTO `wp_shc_master` (`id`, `customer_id`, `site_id`, `master_date`, `created_at`, `modified_at`, `updated_by`, `active`) VALUES
(1, 2, 2, '2017-09-06 07:16:00', '2017-09-06 14:32:55', '0000-00-00 00:00:00', 1, 1),
(2, 4, 5, '2017-09-12 13:12:00', '2017-09-12 18:42:31', '0000-00-00 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_obc_cheque`
--

CREATE TABLE `wp_shc_obc_cheque` (
  `id` int(11) NOT NULL,
  `bill_from_comp` int(2) NOT NULL,
  `financial_year` int(4) NOT NULL,
  `bill_no` bigint(11) NOT NULL,
  `ref_number` varchar(255) NOT NULL,
  `master_id` int(11) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `cheque_date` date NOT NULL,
  `cheque_amount` decimal(15,2) NOT NULL,
  `notes` text NOT NULL,
  `obc_date` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_obc_cheque`
--

INSERT INTO `wp_shc_obc_cheque` (`id`, `bill_from_comp`, `financial_year`, `bill_no`, `ref_number`, `master_id`, `cheque_no`, `cheque_date`, `cheque_amount`, `notes`, `obc_date`, `created_at`, `modified_at`, `updated_by`, `active`) VALUES
(1, 3, 2017, 1, '', 1, 'SDS23', '2017-09-12', '200000.00', 'dsfsdf', '2017-09-12 00:00:00', '2017-09-12 16:24:19', '2017-09-12 17:00:52', 1, 1),
(2, 3, 2017, 2, '', 1, '45345', '2017-09-12', '232433.00', '', '2017-09-13 00:00:00', '2017-09-12 17:19:20', '2017-09-12 18:54:20', 1, 1),
(3, 3, 2017, 3, '3434', 1, 'drgfdg43543', '2017-09-14', '34234234.00', '', '2017-09-04 00:00:00', '2017-09-12 17:20:34', '2017-09-12 17:28:23', 1, 1),
(4, 1, 2017, 1, '', 2, 'ERE3434', '2017-09-30', '30000.00', 'dsfdxsfsdf', '2017-09-20 00:00:00', '2017-09-12 18:51:30', '2017-09-12 18:59:32', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_quotation`
--

CREATE TABLE `wp_shc_quotation` (
  `id` int(11) NOT NULL,
  `bill_from_comp` int(2) NOT NULL,
  `financial_year` int(4) NOT NULL,
  `bill_no` bigint(11) NOT NULL,
  `ref_number` varchar(255) NOT NULL,
  `master_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `quotation_date` datetime NOT NULL,
  `sub_total` decimal(15,2) NOT NULL,
  `discount_avail` varchar(5) NOT NULL,
  `discount_percentage` decimal(10,2) NOT NULL,
  `discount_amt` decimal(15,2) NOT NULL,
  `after_discount_amt` decimal(15,2) NOT NULL,
  `tax_from` varchar(10) NOT NULL,
  `gst_for` varchar(20) NOT NULL,
  `igst_amt` decimal(15,2) NOT NULL,
  `cgst_amt` decimal(15,2) NOT NULL,
  `sgst_amt` decimal(15,2) NOT NULL,
  `vat_amt` decimal(15,2) NOT NULL,
  `tax_include_tot` decimal(15,2) NOT NULL,
  `round_off` decimal(15,2) NOT NULL,
  `hiring_total` decimal(15,2) NOT NULL,
  `for_thirty_days` decimal(15,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `active` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_quotation`
--

INSERT INTO `wp_shc_quotation` (`id`, `bill_from_comp`, `financial_year`, `bill_no`, `ref_number`, `master_id`, `customer_id`, `site_id`, `quotation_date`, `sub_total`, `discount_avail`, `discount_percentage`, `discount_amt`, `after_discount_amt`, `tax_from`, `gst_for`, `igst_amt`, `cgst_amt`, `sgst_amt`, `vat_amt`, `tax_include_tot`, `round_off`, `hiring_total`, `for_thirty_days`, `created_at`, `modified_at`, `updated_by`, `active`) VALUES
(1, 3, 2017, 1, '', 1, 2, 2, '2017-09-09 06:15:00', '90.00', 'no', '0.00', '0.00', '90.00', 'gst', 'cgst', '0.00', '8.10', '8.10', '0.00', '106.20', '0.00', '90.00', '106.20', '2017-09-09 11:47:39', '0000-00-00 00:00:00', 1, 1),
(2, 3, 2017, 2, 'sef', 1, 2, 2, '2017-09-09 06:20:00', '90.00', 'no', '0.00', '0.00', '90.00', 'gst', 'cgst', '0.00', '8.10', '8.10', '0.00', '106.20', '0.00', '90.00', '106.20', '2017-09-09 11:50:46', '2017-09-12 13:25:15', 1, 1),
(3, 3, 2017, 3, '', 1, 2, 2, '2017-09-09 06:21:00', '90.00', 'yes', '5.00', '4.50', '85.50', 'gst', 'cgst', '0.00', '7.70', '7.70', '0.00', '100.90', '0.00', '85.50', '100.90', '2017-09-09 11:51:44', '0000-00-00 00:00:00', 1, 1),
(4, 3, 2017, 4, '', 1, 2, 2, '2017-09-09 06:22:00', '90.00', 'yes', '5.00', '4.50', '85.50', 'vat', 'cgst', '0.00', '0.00', '0.00', '4.28', '89.78', '0.00', '85.50', '89.78', '2017-09-09 11:52:38', '0000-00-00 00:00:00', 1, 1),
(5, 3, 2017, 5, '', 1, 2, 2, '2017-09-09 06:23:00', '63000.00', 'no', '0.00', '0.00', '63000.00', 'no_tax', 'cgst', '0.00', '0.00', '0.00', '0.00', '63000.00', '0.00', '63000.00', '63000.00', '2017-09-09 11:54:00', '0000-00-00 00:00:00', 1, 1),
(6, 3, 2017, 3, '', 1, 2, 2, '2017-09-09 06:31:00', '27000.00', 'yes', '5.00', '1350.00', '25650.00', 'gst', 'cgst', '0.00', '2308.50', '2308.50', '0.00', '30267.00', '0.00', '25650.00', '30267.00', '2017-09-09 12:01:43', '2017-09-12 13:46:46', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_quotation_detail`
--

CREATE TABLE `wp_shc_quotation_detail` (
  `id` int(11) NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `lot_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `rate_thirty` decimal(15,2) NOT NULL,
  `rate_ninety` decimal(15,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `active` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_quotation_detail`
--

INSERT INTO `wp_shc_quotation_detail` (`id`, `quotation_id`, `lot_id`, `qty`, `unit_price`, `rate_thirty`, `rate_ninety`, `created_at`, `modified_at`, `active`) VALUES
(1, 6, 10, 200, '3.00', '90.00', '18000.00', '2017-09-09 12:01:44', '0000-00-00 00:00:00', 1),
(2, 6, 10, 100, '3.00', '90.00', '9000.00', '2017-09-09 12:01:44', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_return`
--

CREATE TABLE `wp_shc_return` (
  `id` int(11) NOT NULL,
  `bill_from_comp` int(2) NOT NULL,
  `financial_year` int(4) NOT NULL,
  `bill_no` bigint(11) NOT NULL,
  `ref_number` varchar(255) NOT NULL,
  `master_id` int(11) NOT NULL,
  `return_date` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_return` int(2) NOT NULL,
  `vehicle_number` varchar(255) NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `driver_mobile` varchar(255) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_return`
--

INSERT INTO `wp_shc_return` (`id`, `bill_from_comp`, `financial_year`, `bill_no`, `ref_number`, `master_id`, `return_date`, `created_at`, `is_return`, `vehicle_number`, `driver_name`, `driver_mobile`, `updated_by`, `active`) VALUES
(1, 3, 2016, 1, '', 1, '2017-01-06', '2017-09-06 15:24:05', 1, 'TN22CR2113', 'Murugan', '', 0, 1),
(2, 3, 2017, 2, '', 1, '2017-08-30', '2017-09-06 15:26:03', 1, 'TN21AX3011', 'Manimaran', '', 0, 1),
(3, 3, 2017, 3, '', 1, '2017-09-12', '2017-09-06 21:31:01', 0, '', '', '', 0, 1),
(4, 3, 2017, 4, '', 1, '2016-09-06', '2017-09-06 21:31:43', 1, '', '', '', 0, 1),
(5, 3, 2017, 5, '', 1, '2017-09-07', '2017-09-06 21:35:13', 1, '', '', '', 1, 1),
(6, 3, 0, 2, '', 1, '2017-03-06', '2017-09-06 23:42:36', 1, '', '', '', 1, 1),
(7, 3, 2017, 6, 'fghgf32swd', 1, '2017-09-08', '2017-09-08 07:56:52', 1, '', '', '', 1, 1),
(10, 0, 2017, 0, '', 1, '2017-09-11', '2017-09-11 11:18:05', 0, '', '', '', 1, 1),
(11, 3, 2017, 0, '', 1, '2017-09-11', '2017-09-11 11:40:11', 0, '', '', '', 1, 1),
(12, 3, 2017, 0, '', 1, '2017-09-11', '2017-09-11 15:16:07', 0, '', '', '', 1, 1),
(13, 3, 2017, 0, '', 1, '2017-09-11', '2017-09-11 15:18:26', 0, '', '', '', 1, 1),
(14, 3, 2017, 0, '', 1, '2017-09-11', '2017-09-11 15:21:49', 0, '', '', '', 1, 1),
(15, 3, 2017, 7, '', 1, '2017-09-11', '2017-09-11 15:22:43', 1, '', '', '', 1, 1),
(16, 3, 2017, 8, '', 1, '2017-09-11', '2017-09-11 15:23:02', 1, '', '', '', 1, 1),
(17, 3, 2017, 0, '', 1, '2017-09-11', '2017-09-11 15:23:23', 0, '', '', '', 1, 1),
(18, 3, 2017, 9, '', 1, '2017-09-11', '2017-09-11 15:23:54', 1, '', '', '', 1, 1),
(19, 3, 2017, 0, '', 1, '2017-09-11', '2017-09-11 15:24:34', 0, '', '', '', 1, 1),
(20, 3, 2017, 0, '', 1, '2017-09-11', '2017-09-11 15:28:24', 0, '', '', '', 1, 1),
(21, 3, 2017, 10, '', 1, '2017-09-11', '2017-09-11 15:46:08', 1, '', '', '', 1, 1),
(22, 3, 2017, 0, '', 1, '2017-09-11', '2017-09-11 15:46:43', 0, '', '', '', 1, 1),
(23, 3, 2017, 0, '', 1, '2017-09-11', '2017-09-11 17:55:28', 0, '', '', '', 1, 1),
(24, 3, 2017, 0, '', 1, '2017-09-12', '2017-09-12 10:22:43', 0, '', '', '', 1, 1),
(25, 3, 2017, 0, '', 1, '2017-09-12', '2017-09-12 17:36:43', 0, '', '', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_return_detail`
--

CREATE TABLE `wp_shc_return_detail` (
  `id` int(11) NOT NULL,
  `return_id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `delivery_detail_id` int(11) NOT NULL,
  `lot_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `return_date` date NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_return_detail`
--

INSERT INTO `wp_shc_return_detail` (`id`, `return_id`, `master_id`, `delivery_detail_id`, `lot_id`, `qty`, `return_date`, `active`) VALUES
(1, 1, 1, 2, 18, 962, '2017-01-06', 1),
(2, 2, 1, 1, 14, 390, '2017-08-30', 1),
(3, 3, 1, 1, 14, 1, '1017-09-06', 0),
(4, 4, 1, 1, 14, 1, '1016-09-06', 1),
(5, 5, 1, 1, 14, 1, '2017-09-07', 1),
(6, 6, 1, 1, 14, 1, '2017-03-06', 1),
(7, 7, 1, 6, 4, 10, '2017-09-08', 1),
(10, 10, 1, 5, 16, 10, '2017-09-11', 1),
(11, 11, 1, 6, 4, 90, '2017-09-11', 1),
(12, 3, 1, 1, 14, 10, '2017-09-12', 1),
(13, 12, 1, 7, 5, 50, '2017-09-11', 1),
(14, 13, 1, 7, 5, 20, '2017-09-11', 1),
(15, 14, 1, 7, 5, 10, '2017-09-11', 1),
(16, 15, 1, 7, 5, 10, '2017-09-11', 1),
(17, 16, 1, 7, 5, 1, '2017-09-11', 1),
(18, 17, 1, 7, 5, 1, '2017-09-11', 1),
(19, 18, 1, 7, 5, 1, '2017-09-11', 1),
(20, 19, 1, 7, 5, 1, '2017-09-11', 1),
(21, 20, 1, 7, 5, 1, '2017-09-11', 1),
(22, 21, 1, 7, 5, 1, '2017-09-11', 1),
(23, 21, 1, 1, 14, 1, '2017-09-11', 1),
(24, 21, 1, 2, 18, 1, '2017-09-11', 1),
(25, 22, 1, 7, 5, 1, '2017-09-11', 1),
(26, 22, 1, 1, 14, 1, '2017-09-11', 1),
(27, 22, 1, 2, 18, 1, '2017-09-11', 1),
(28, 23, 1, 2, 18, 1036, '2017-09-11', 1),
(29, 23, 1, 3, 18, 964, '2017-09-11', 1),
(30, 24, 1, 7, 5, 3, '2017-09-12', 0),
(31, 24, 1, 7, 5, 3, '2017-09-12', 0),
(32, 24, 1, 1, 14, 337, '2017-09-12', 0),
(33, 24, 1, 7, 5, 3, '2017-09-12', 0),
(34, 24, 1, 7, 5, 3, '2017-09-12', 1),
(35, 24, 1, 3, 18, 336, '2017-09-12', 1),
(36, 24, 1, 4, 18, 1, '2017-09-12', 1),
(37, 25, 1, 1, 14, 10, '2017-09-12', 0),
(38, 25, 1, 1, 14, 15, '2017-09-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_special_price`
--

CREATE TABLE `wp_shc_special_price` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `lot_id` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_stock`
--

CREATE TABLE `wp_shc_stock` (
  `id` int(11) NOT NULL,
  `lot_number` varchar(250) NOT NULL,
  `stock_count` int(11) NOT NULL,
  `buying_total` decimal(9,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `active` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_unloading`
--

CREATE TABLE `wp_shc_unloading` (
  `id` int(11) NOT NULL,
  `return_id` int(11) NOT NULL,
  `unloading_charge` decimal(15,2) NOT NULL,
  `master_id` int(11) NOT NULL,
  `return_date` datetime NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_unloading`
--

INSERT INTO `wp_shc_unloading` (`id`, `return_id`, `unloading_charge`, `master_id`, `return_date`, `active`) VALUES
(1, 1, '0.00', 1, '1017-01-06 09:48:00', 1),
(2, 2, '6250.00', 1, '1017-08-30 09:54:00', 1),
(3, 3, '0.00', 1, '2017-09-12 00:00:00', 1),
(4, 4, '0.00', 1, '1016-09-06 16:01:00', 1),
(5, 5, '0.00', 1, '2017-09-07 16:05:00', 1),
(6, 6, '0.00', 1, '2017-03-06 18:12:00', 1),
(7, 7, '0.00', 1, '2017-09-08 02:26:00', 1),
(8, 8, '0.00', 1, '2017-09-11 05:23:00', 1),
(9, 9, '0.00', 1, '2017-09-11 05:31:00', 1),
(10, 10, '0.00', 1, '2017-09-11 05:47:00', 1),
(11, 11, '0.00', 1, '2017-09-11 06:10:00', 1),
(12, 12, '0.00', 1, '2017-09-11 09:29:00', 1),
(13, 13, '0.00', 1, '2017-09-11 09:48:00', 1),
(14, 14, '0.00', 1, '2017-09-11 09:51:00', 1),
(15, 15, '0.00', 1, '2017-09-11 09:52:00', 1),
(16, 16, '0.00', 1, '2017-09-11 09:52:00', 1),
(17, 17, '0.00', 1, '2017-09-11 09:53:00', 1),
(18, 18, '0.00', 1, '2017-09-11 09:53:00', 1),
(19, 19, '0.00', 1, '2017-09-11 09:54:00', 1),
(20, 20, '0.00', 1, '2017-09-11 09:58:00', 1),
(21, 21, '0.00', 1, '2017-09-11 10:16:00', 1),
(22, 22, '0.00', 1, '2017-09-11 10:16:00', 1),
(23, 23, '0.00', 1, '2017-09-11 12:25:00', 1),
(24, 24, '0.00', 1, '2017-09-12 04:52:00', 1),
(25, 25, '0.00', 1, '2017-09-12 12:06:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_shc_unloading_detail`
--

CREATE TABLE `wp_shc_unloading_detail` (
  `id` int(11) NOT NULL,
  `return_id` int(11) NOT NULL,
  `unloading_id` int(11) NOT NULL,
  `charge_for` varchar(250) NOT NULL,
  `charge_amt` decimal(15,2) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_shc_unloading_detail`
--

INSERT INTO `wp_shc_unloading_detail` (`id`, `return_id`, `unloading_id`, `charge_for`, `charge_amt`, `active`) VALUES
(1, 1, 1, 'unloading', '0.00', 1),
(2, 1, 1, 'transportation', '0.00', 1),
(3, 1, 1, 'damage', '0.00', 1),
(4, 2, 2, 'unloading', '750.00', 1),
(5, 2, 2, 'transportation', '5500.00', 1),
(6, 2, 2, 'damage', '0.00', 1),
(7, 3, 3, 'unloading', '0.00', 1),
(8, 3, 3, 'transportation', '0.00', 1),
(9, 3, 3, 'damage', '0.00', 1),
(10, 4, 4, 'unloading', '0.00', 1),
(11, 4, 4, 'transportation', '0.00', 1),
(12, 4, 4, 'damage', '0.00', 1),
(13, 5, 5, 'unloading', '0.00', 1),
(14, 5, 5, 'transportation', '0.00', 1),
(15, 5, 5, 'damage', '0.00', 1),
(16, 6, 6, 'unloading', '0.00', 1),
(17, 6, 6, 'transportation', '0.00', 1),
(18, 6, 6, 'damage', '0.00', 1),
(19, 7, 7, 'unloading', '0.00', 1),
(20, 7, 7, 'transportation', '0.00', 1),
(21, 7, 7, 'damage', '0.00', 1),
(22, 8, 8, 'unloading', '0.00', 1),
(23, 8, 8, 'transportation', '0.00', 1),
(24, 8, 8, 'damage', '0.00', 1),
(25, 9, 9, 'unloading', '0.00', 1),
(26, 9, 9, 'transportation', '0.00', 1),
(27, 9, 9, 'damage', '0.00', 1),
(28, 10, 10, 'unloading', '0.00', 1),
(29, 10, 10, 'transportation', '0.00', 1),
(30, 10, 10, 'damage', '0.00', 1),
(31, 11, 11, 'unloading', '0.00', 1),
(32, 11, 11, 'transportation', '0.00', 1),
(33, 11, 11, 'damage', '0.00', 1),
(34, 12, 12, 'unloading', '0.00', 1),
(35, 12, 12, 'transportation', '0.00', 1),
(36, 12, 12, 'damage', '0.00', 1),
(37, 13, 13, 'unloading', '0.00', 1),
(38, 13, 13, 'transportation', '0.00', 1),
(39, 13, 13, 'damage', '0.00', 1),
(40, 14, 14, 'unloading', '0.00', 1),
(41, 14, 14, 'transportation', '0.00', 1),
(42, 14, 14, 'damage', '0.00', 1),
(43, 15, 15, 'unloading', '0.00', 1),
(44, 15, 15, 'transportation', '0.00', 1),
(45, 15, 15, 'damage', '0.00', 1),
(46, 16, 16, 'unloading', '0.00', 1),
(47, 16, 16, 'transportation', '0.00', 1),
(48, 16, 16, 'damage', '0.00', 1),
(49, 17, 17, 'unloading', '0.00', 1),
(50, 17, 17, 'transportation', '0.00', 1),
(51, 17, 17, 'damage', '0.00', 1),
(52, 18, 18, 'unloading', '0.00', 1),
(53, 18, 18, 'transportation', '0.00', 1),
(54, 18, 18, 'damage', '0.00', 1),
(55, 19, 19, 'unloading', '0.00', 1),
(56, 19, 19, 'transportation', '0.00', 1),
(57, 19, 19, 'damage', '0.00', 1),
(58, 20, 20, 'unloading', '0.00', 1),
(59, 20, 20, 'transportation', '0.00', 1),
(60, 20, 20, 'damage', '0.00', 1),
(61, 21, 21, 'unloading', '0.00', 1),
(62, 21, 21, 'transportation', '0.00', 1),
(63, 21, 21, 'damage', '0.00', 1),
(64, 22, 22, 'unloading', '0.00', 1),
(65, 22, 22, 'transportation', '0.00', 1),
(66, 22, 22, 'damage', '0.00', 1),
(67, 23, 23, 'unloading', '0.00', 1),
(68, 23, 23, 'transportation', '0.00', 1),
(69, 23, 23, 'damage', '0.00', 1),
(70, 24, 24, 'unloading', '0.00', 1),
(71, 24, 24, 'transportation', '0.00', 1),
(72, 24, 24, 'damage', '0.00', 1),
(73, 25, 25, 'unloading', '0.00', 1),
(74, 25, 25, 'transportation', '0.00', 1),
(75, 25, 25, 'damage', '0.00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_shc_admin_history`
--
ALTER TABLE `wp_shc_admin_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_companies`
--
ALTER TABLE `wp_shc_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_companies_master`
--
ALTER TABLE `wp_shc_companies_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_customers`
--
ALTER TABLE `wp_shc_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_customer_site`
--
ALTER TABLE `wp_shc_customer_site`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_delivery`
--
ALTER TABLE `wp_shc_delivery`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `wp_shc_delivery_detail`
--
ALTER TABLE `wp_shc_delivery_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_deposit`
--
ALTER TABLE `wp_shc_deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_deposit_cheque`
--
ALTER TABLE `wp_shc_deposit_cheque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_deposit_detail`
--
ALTER TABLE `wp_shc_deposit_detail`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `wp_shc_employees`
--
ALTER TABLE `wp_shc_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_employee_attendance`
--
ALTER TABLE `wp_shc_employee_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_hiring`
--
ALTER TABLE `wp_shc_hiring`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_hiring_detail`
--
ALTER TABLE `wp_shc_hiring_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_loading`
--
ALTER TABLE `wp_shc_loading`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_loading_detail`
--
ALTER TABLE `wp_shc_loading_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_lost`
--
ALTER TABLE `wp_shc_lost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_lost_detail`
--
ALTER TABLE `wp_shc_lost_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_lots`
--
ALTER TABLE `wp_shc_lots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_master`
--
ALTER TABLE `wp_shc_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_obc_cheque`
--
ALTER TABLE `wp_shc_obc_cheque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_quotation`
--
ALTER TABLE `wp_shc_quotation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_quotation_detail`
--
ALTER TABLE `wp_shc_quotation_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_return`
--
ALTER TABLE `wp_shc_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_return_detail`
--
ALTER TABLE `wp_shc_return_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_special_price`
--
ALTER TABLE `wp_shc_special_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_stock`
--
ALTER TABLE `wp_shc_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_unloading`
--
ALTER TABLE `wp_shc_unloading`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_shc_unloading_detail`
--
ALTER TABLE `wp_shc_unloading_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_shc_admin_history`
--
ALTER TABLE `wp_shc_admin_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
--
-- AUTO_INCREMENT for table `wp_shc_companies`
--
ALTER TABLE `wp_shc_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `wp_shc_companies_master`
--
ALTER TABLE `wp_shc_companies_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `wp_shc_customers`
--
ALTER TABLE `wp_shc_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `wp_shc_customer_site`
--
ALTER TABLE `wp_shc_customer_site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `wp_shc_delivery`
--
ALTER TABLE `wp_shc_delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `wp_shc_delivery_detail`
--
ALTER TABLE `wp_shc_delivery_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `wp_shc_deposit`
--
ALTER TABLE `wp_shc_deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `wp_shc_deposit_cheque`
--
ALTER TABLE `wp_shc_deposit_cheque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `wp_shc_deposit_detail`
--
ALTER TABLE `wp_shc_deposit_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `wp_shc_employees`
--
ALTER TABLE `wp_shc_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_shc_employee_attendance`
--
ALTER TABLE `wp_shc_employee_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_shc_hiring`
--
ALTER TABLE `wp_shc_hiring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `wp_shc_hiring_detail`
--
ALTER TABLE `wp_shc_hiring_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `wp_shc_loading`
--
ALTER TABLE `wp_shc_loading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `wp_shc_loading_detail`
--
ALTER TABLE `wp_shc_loading_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `wp_shc_lost`
--
ALTER TABLE `wp_shc_lost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `wp_shc_lost_detail`
--
ALTER TABLE `wp_shc_lost_detail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `wp_shc_lots`
--
ALTER TABLE `wp_shc_lots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `wp_shc_master`
--
ALTER TABLE `wp_shc_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `wp_shc_obc_cheque`
--
ALTER TABLE `wp_shc_obc_cheque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `wp_shc_quotation`
--
ALTER TABLE `wp_shc_quotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `wp_shc_quotation_detail`
--
ALTER TABLE `wp_shc_quotation_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `wp_shc_return`
--
ALTER TABLE `wp_shc_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `wp_shc_return_detail`
--
ALTER TABLE `wp_shc_return_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `wp_shc_special_price`
--
ALTER TABLE `wp_shc_special_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_shc_stock`
--
ALTER TABLE `wp_shc_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_shc_unloading`
--
ALTER TABLE `wp_shc_unloading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `wp_shc_unloading_detail`
--
ALTER TABLE `wp_shc_unloading_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
