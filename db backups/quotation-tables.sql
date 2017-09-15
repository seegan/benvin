-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2017 at 08:32 AM
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
(2, 3, 2017, 2, '', 1, 2, 2, '2017-09-09 06:20:00', '90.00', 'no', '0.00', '0.00', '90.00', 'gst', 'cgst', '0.00', '8.10', '8.10', '0.00', '106.20', '0.00', '90.00', '106.20', '2017-09-09 11:50:46', '0000-00-00 00:00:00', 1, 1),
(3, 3, 2017, 3, '', 1, 2, 2, '2017-09-09 06:21:00', '90.00', 'yes', '5.00', '4.50', '85.50', 'gst', 'cgst', '0.00', '7.70', '7.70', '0.00', '100.90', '0.00', '85.50', '100.90', '2017-09-09 11:51:44', '0000-00-00 00:00:00', 1, 1),
(4, 3, 2017, 4, '', 1, 2, 2, '2017-09-09 06:22:00', '90.00', 'yes', '5.00', '4.50', '85.50', 'vat', 'cgst', '0.00', '0.00', '0.00', '4.28', '89.78', '0.00', '85.50', '89.78', '2017-09-09 11:52:38', '0000-00-00 00:00:00', 1, 1),
(5, 3, 2017, 5, '', 1, 2, 2, '2017-09-09 06:23:00', '63000.00', 'no', '0.00', '0.00', '63000.00', 'no_tax', 'cgst', '0.00', '0.00', '0.00', '0.00', '63000.00', '0.00', '63000.00', '63000.00', '2017-09-09 11:54:00', '0000-00-00 00:00:00', 1, 1),
(6, 3, 2017, 6, '', 1, 2, 2, '2017-09-09 06:31:00', '27000.00', 'yes', '5.00', '1350.00', '25650.00', 'gst', 'cgst', '0.00', '2308.50', '2308.50', '0.00', '30267.00', '0.00', '25650.00', '30267.00', '2017-09-09 12:01:43', '0000-00-00 00:00:00', 1, 1);

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

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

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
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
