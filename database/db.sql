-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 10, 2018 at 10:05 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookingsoftware`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `title`) VALUES
(1, 'Apple'),
(2, 'Blackberry'),
(3, 'Sony'),
(4, 'Samsung'),
(5, 'ZTE'),
(6, 'Alcatel'),
(7, 'Nokia'),
(8, 'Lumia');

-- --------------------------------------------------------

--
-- Table structure for table `brand_models`
--

CREATE TABLE `brand_models` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `brand_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `title` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand_models`
--

INSERT INTO `brand_models` (`id`, `brand_id`, `title`) VALUES
(1, 1, 'iPhone 4c'),
(2, 1, 'iPhone 4s'),
(3, 1, 'iPhone 5s'),
(4, 1, 'iPhone 5c'),
(5, 1, 'iPhone 6'),
(6, 2, 'Passport'),
(7, 2, 'Z30'),
(8, 2, '9720');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `office_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `created_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `office_id`, `name`, `phone`, `email`, `updated_datetime`, `created_datetime`) VALUES
(1, 1, 'shariq', '0321231321231', 'shariq2k@yahoo.com', '2016-04-09 20:13:42', '2016-03-05 23:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(225) NOT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `to_email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `updated_datetime` datetime DEFAULT NULL,
  `created_datetime` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `title`, `from_email`, `from_name`, `to_email`, `subject`, `message`, `updated_datetime`, `created_datetime`, `status`) VALUES
(1, 'Order received', 'info@exclusiveunlock.co.uk', 'Exclusive Repairs', '[EMAIL]', 'Thank you for visiting store.', 'Dear [NAME],\r\nThank you for ordering.\r\n\r\nOrder ID: [ORDER_ID]\r\nDelvery Date: [DELIVERY_DATE]\r\n\r\nRegards,\r\n', '2015-12-11 06:58:05', '2016-01-01 00:00:00', 1),
(2, 'Order ready', 'info@exclusiveunlock.co.uk', 'Exclusive Repairs', '[EMAIL]', 'Your order is ready to pick.', 'Dear [NAME],\r\nYour order number: [ORDER_ID] is ready to pick.\r\n\r\nReceived Date: [RECEIVE_DATE]\r\nRegards,\r\n', '2015-12-11 07:03:29', '2016-01-01 00:00:00', 1),
(3, 'Forgot Password', 'info@exclusiveunlock.co.uk', 'Exclusive Repairs', '[EMAIL]', 'Password Recovery.', 'Dear [NAME],\r\nYour password has sent on your request.\r\nUsername: [USERNAME]\r\nPassword: [PASSWORD]\r\n\r\nRegards,\r\nExclusive Repairs', '2016-04-10 12:39:51', '2016-04-10 12:39:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_template_tags`
--

CREATE TABLE `email_template_tags` (
  `tag` varchar(225) NOT NULL,
  `field_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_template_tags`
--

INSERT INTO `email_template_tags` (`tag`, `field_name`) VALUES
('[DELIVERY_DATE]', 'delivery_date'),
('[EMAIL]', 'email'),
('[NAME]', 'name'),
('[OFFICE]', 'office'),
('[ORDER_ID]', 'id'),
('[PASSWORD]', 'password'),
('[RECEIVE_DATE]', 'receive_date'),
('[USERNAME]', 'username');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `office_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `created_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `office_id`, `name`, `username`, `email`, `password`, `phone`, `is_admin`, `status`, `updated_datetime`, `created_datetime`) VALUES
(1, 1, 'shariq', 'admin', 'shariq2k@gmail.com', 'demo1234', '2312312321', 1, 1, '2016-09-09 15:55:45', '2015-11-05 19:18:07');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `employee_id` smallint(5) UNSIGNED NOT NULL,
  `office_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `technician` varchar(255) DEFAULT NULL,
  `receive_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` tinyint(1) UNSIGNED DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `created_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_items`
--

CREATE TABLE `job_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `job_id` int(10) UNSIGNED NOT NULL,
  `brand_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `brand_model_id` smallint(5) UNSIGNED DEFAULT NULL,
  `device_number` varchar(255) DEFAULT NULL COMMENT 'IMEI/ ESN/ SN',
  `color` varchar(255) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `device_password` varchar(255) DEFAULT NULL,
  `power_on` tinyint(1) UNSIGNED DEFAULT NULL,
  `charging` tinyint(1) UNSIGNED DEFAULT NULL,
  `network` tinyint(1) UNSIGNED DEFAULT NULL,
  `display` tinyint(1) UNSIGNED DEFAULT NULL,
  `camera` tinyint(1) UNSIGNED DEFAULT NULL,
  `battery` tinyint(1) UNSIGNED DEFAULT NULL,
  `fault_discription` varbinary(255) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `title`) VALUES
(1, 'Dallas, Texas'),
(2, 'Kuala Lumpur, Malaysia');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand_models`
--
ALTER TABLE `brand_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `PHONE_UNIQUE` (`phone`),
  ADD UNIQUE KEY `EMAIL_UNIQUE` (`email`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template_tags`
--
ALTER TABLE `email_template_tags`
  ADD PRIMARY KEY (`tag`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `USERNAME_UNIQUE` (`username`),
  ADD UNIQUE KEY `EMAIL_UNIQUE` (`email`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CUSTOMER` (`customer_id`);

--
-- Indexes for table `job_items`
--
ALTER TABLE `job_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `JOB_ITEMS` (`job_id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `brand_models`
--
ALTER TABLE `brand_models`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `job_items`
--
ALTER TABLE `job_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `CUSTOMER` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `job_items`
--
ALTER TABLE `job_items`
  ADD CONSTRAINT `JOB_ITEMS` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
