-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2019 at 06:45 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `groupbuy`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `credit_card` int(20) DEFAULT NULL,
  `user_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`credit_card`, `user_id`) VALUES
(7845, 7);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(20) NOT NULL,
  `category_name` varchar(20) NOT NULL,
  `parent` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `parent`) VALUES
(3, 'electronics', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(20) NOT NULL,
  `datenow` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `commentText` text NOT NULL,
  `parent` int(10) NOT NULL,
  `user_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `datenow`, `commentText`, `parent`, `user_id`) VALUES
(1, '2019-06-22 12:28:03.000000', 'Hello', 1, 7),
(2, '2019-06-25 03:16:17.000000', 'hi group buy', 1, 8),
(4, '2019-06-25 15:34:07.000000', 'hi', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE `offer` (
  `offer_number` int(10) NOT NULL,
  `offer_name` varchar(20) NOT NULL,
  `discount` int(10) NOT NULL,
  `image` varchar(20) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `user_id` int(20) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offer`
--

INSERT INTO `offer` (`offer_number`, `offer_name`, `discount`, `image`, `start_date`, `end_date`, `user_id`, `deleted`) VALUES
(3, 'minre', 50, 'product-1', '2019-06-01', '2019-06-22', 8, 1),
(4, 'Very Hot', 50, 'product-2', '0000-00-00', '2019-07-31', 8, 0),
(5, 'bride', 20, 'product-4', '2019-06-01', '2019-06-23', 8, 0),
(6, 'make up', 30, 'product-1', '2018-12-31', '2019-01-01', 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `offer_line`
--

CREATE TABLE `offer_line` (
  `offer_line_id` int(20) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `offer_number` int(10) NOT NULL,
  `product_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offer_line`
--

INSERT INTO `offer_line` (`offer_line_id`, `quantity`, `price`, `offer_number`, `product_id`) VALUES
(1, 5, 20, 3, 2),
(2, 10, 10, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(20) NOT NULL,
  `offers_number` int(20) NOT NULL,
  `date_current` datetime(6) NOT NULL,
  `total_price` int(10) NOT NULL,
  `user_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `offers_number`, `date_current`, `total_price`, `user_id`) VALUES
(1, 1, '2019-06-22 14:30:42.000000', 100, 7),
(2, 2, '2019-06-01 00:00:00.000000', 20, 7),
(7, 1, '2019-06-28 17:00:20.000000', 50, 7),
(8, 1, '2019-06-28 17:01:24.000000', 50, 7),
(9, 1, '2019-06-28 17:04:04.000000', 50, 7),
(10, 1, '2019-06-28 17:05:37.000000', 50, 7);

-- --------------------------------------------------------

--
-- Table structure for table `order_line`
--

CREATE TABLE `order_line` (
  `order_line_id` int(20) NOT NULL,
  `quantity` int(10) NOT NULL,
  `order_id` int(20) NOT NULL,
  `offer_number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_line`
--

INSERT INTO `order_line` (`order_line_id`, `quantity`, `order_id`, `offer_number`) VALUES
(1, 2, 1, 3),
(2, 1, 2, 4),
(3, 3, 2, 3),
(1849, 5, 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(20) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `discrption` text NOT NULL,
  `category_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `discrption`, `category_id`) VALUES
(2, 'TV', 'Toshiba black', 3);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `bank_account` int(20) DEFAULT NULL,
  `tax_card` int(20) DEFAULT NULL,
  `commercial_register` int(20) DEFAULT NULL,
  `user_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`bank_account`, `tax_card`, `commercial_register`, `user_id`) VALUES
(7842, 5412153, 86454, 8);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(20) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Address` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_firstname`, `user_lastname`, `user_email`, `password`, `Address`) VALUES
(7, 'maryan', 'louis', 'maryan@gmail.com', '$2y$10$ye9t/8aRoeStLBG2e9zAyu2GexPI.5C7DqQ91vyA6DaW.5m579YdG', 'Waffik abass - Ain Shams'),
(8, 'test', 'test', 'test@gmail.com', '$2y$10$YQZIc8MMYaBNvWCsJMiqVO0uPeVt4YJgMjf1TCFJnjMkGav7mJB7q', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `wish`
--

CREATE TABLE `wish` (
  `wish_id` int(20) NOT NULL,
  `wishname` varchar(20) NOT NULL,
  `discrption` text NOT NULL,
  `counter` int(5) NOT NULL,
  `status` varchar(30) NOT NULL,
  `publishdate` datetime(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `cancel_date` datetime(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `user_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wish`
--

INSERT INTO `wish` (`wish_id`, `wishname`, `discrption`, `counter`, `status`, `publishdate`, `cancel_date`, `user_id`) VALUES
(1, 'T-Shirt', 'Size: XLL, Color:red', 1, 'active', '2019-06-22 14:36:52.000000', '0000-00-00 00:00:00.000000', 7),
(2, 'pan', 'cooking pan,\r\n\r\nSize: 30,\r\n\r\nColor: Silver', 5, 'cancled', NULL, '2019-06-26 00:00:00.000000', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent` (`parent`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent` (`parent`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`offer_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `offer_line`
--
ALTER TABLE `offer_line`
  ADD PRIMARY KEY (`offer_line_id`),
  ADD KEY `offer_number` (`offer_number`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_line`
--
ALTER TABLE `order_line`
  ADD PRIMARY KEY (`order_line_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `offer_number` (`offer_number`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wish`
--
ALTER TABLE `wish`
  ADD PRIMARY KEY (`wish_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
  MODIFY `offer_number` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `offer_line`
--
ALTER TABLE `offer_line`
  MODIFY `offer_line_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_line`
--
ALTER TABLE `order_line`
  MODIFY `order_line_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1850;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wish`
--
ALTER TABLE `wish`
  MODIFY `wish_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buyer`
--
ALTER TABLE `buyer`
  ADD CONSTRAINT `buyer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`parent`) REFERENCES `comment` (`comment_id`);

--
-- Constraints for table `offer`
--
ALTER TABLE `offer`
  ADD CONSTRAINT `offer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `seller` (`user_id`);

--
-- Constraints for table `offer_line`
--
ALTER TABLE `offer_line`
  ADD CONSTRAINT `offer_line_ibfk_1` FOREIGN KEY (`offer_number`) REFERENCES `offer` (`offer_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offer_line_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `buyer` (`user_id`);

--
-- Constraints for table `order_line`
--
ALTER TABLE `order_line`
  ADD CONSTRAINT `order_line_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`),
  ADD CONSTRAINT `order_line_ibfk_2` FOREIGN KEY (`offer_number`) REFERENCES `offer` (`offer_number`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `seller`
--
ALTER TABLE `seller`
  ADD CONSTRAINT `seller_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `wish`
--
ALTER TABLE `wish`
  ADD CONSTRAINT `wish_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `buyer` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
