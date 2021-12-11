-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2020 at 11:06 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mini_football_ground_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `beverages`
--

CREATE TABLE `beverages` (
  `beverage_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `beverage_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `beverage_cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `beverages`
--

INSERT INTO `beverages` (`beverage_id`, `beverage_name`, `beverage_cost`) VALUES
('5fbcf62e1de2b', 'Pepsi', 15000),
('5fbcfbac9450a', 'Sprite', 11000),
('5fbcfbcf54245', 'Fanta', 11000),
('5fc284e8d6686', 'Sting vàng', 14000),
('5fc28eefc6b31', 'Sting đỏ', 13000);

-- --------------------------------------------------------

--
-- Table structure for table `bookingdetails`
--

CREATE TABLE `bookingdetails` (
  `booking_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ground_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `booking_start` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `booking_end` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `booking_date` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bookingdetails`
--

INSERT INTO `bookingdetails` (`booking_id`, `user_id`, `ground_id`, `booking_start`, `booking_end`, `booking_date`) VALUES
('5fc5fccce2aed', '5f8af85752225', '5f959e7341ea3', '9:15', '13:00', '01/12/2020'),
('5fc601660cbb2', '5f8afccb1da27', '5f959edf3e148', '17:30', '19:00', '01/12/2020'),
('5fc6040d0cf6a', '5f8afce1b50d5', '5f959ecb2c2aa', '20:00', '21:00', '01/12/2020'),
('5fc6042e9a959', '5fa984dacf884', '5f959f061aed5', '15:30', '17:15', '01/12/2020'),
('5fc60446efcd4', '5fc21c272ca60', '5f959f061aed5', '9:45', '11:45', '01/12/2020'),
('5fca043a0b106', '5fc45ba9a2ab3', '5f959e7341ea3', '16:30', '18:00', '01/12/2020'),
('5fca04f714915', '5fc6007fdc15d', '5f959e7341ea3', '14:15', '15:45', '01/12/2020'),
('5fca06ee2be5f', '5fbcb6f40633e', '5f959ead1c45d', '12:15', '14:30', '01/12/2020');

-- --------------------------------------------------------

--
-- Table structure for table `bookinghistories`
--

CREATE TABLE `bookinghistories` (
  `history_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `booking_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ground_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `booking_start` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `booking_end` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `booking_date` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bookinghistories`
--

INSERT INTO `bookinghistories` (`history_id`, `booking_id`, `user_id`, `ground_id`, `booking_start`, `booking_end`, `booking_date`) VALUES
('5fc5fccce2afd', '5fc5fccce2aed', '5f8af85752225', '5f959e7341ea3', '9:15', '13:00', '01/12/2020'),
('5fc6007fdc411', '5fc6007fdc40a', '5fc6007fdc15d', '5f959e7341ea3', '13:45', '15:00', '01/12/2020'),
('5fc601660cbb7', '5fc601660cbb2', '5f8afccb1da27', '5f959edf3e148', '17:30', '19:00', '01/12/2020'),
('5fc6040d0cf82', '5fc6040d0cf6a', '5f8afce1b50d5', '5f959ecb2c2aa', '20:00', '21:00', '01/12/2020'),
('5fc6042e9a95f', '5fc6042e9a959', '5fa984dacf884', '5f959f061aed5', '15:30', '17:15', '01/12/2020'),
('5fc60446efcd7', '5fc60446efcd4', '5fc21c272ca60', '5f959f061aed5', '9:45', '11:45', '01/12/2020'),
('5fc604f79bd8b', '5fc604f79bd47', '5fc45ba9a2ab3', '5f959eedcdf06', '13:15', '16:45', '01/12/2020'),
('5fca043a1ba60', '5fca043a0b106', '5fc45ba9a2ab3', '5f959e7341ea3', '16:30', '18:00', '01/12/2020'),
('5fca04f714918', '5fca04f714915', '5fc6007fdc15d', '5f959e7341ea3', '14:15', '15:45', '01/12/2020'),
('5fca06ee2be70', '5fca06ee2be5f', '5fbcb6f40633e', '5f959ead1c45d', '12:15', '14:30', '01/12/2020'),
('5fcae3e6efc19', '5fcae3e6efc16', '5fa984dacf884', '5f959e83891fa', '11:45', '13:15', '02/12/2020'),
('5fcb47c42a296', '5fcb47c427d56', '5f8afccb1da27', '5f959e83891fa', '13:30', '15:00', '02/12/2020'),
('5fcb519b6ec44', '5fcb519b6ec2e', '5f8afccb1da27', '5f959e83891fa', '13:30', '15:00', '02/12/2020');

-- --------------------------------------------------------

--
-- Table structure for table `grounds`
--

CREATE TABLE `grounds` (
  `ground_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ground_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `grounds`
--

INSERT INTO `grounds` (`ground_id`, `ground_name`) VALUES
('5f959e7341ea3', 'Sân 1'),
('5f959e83891fa', 'Sân 2'),
('5f959ead1c45d', 'Sân 3'),
('5f959ecb2c2aa', 'Sân 4'),
('5f959edf3e148', 'Sân 5'),
('5f959eedcdf06', 'Sân 6'),
('5f959f061aed5', 'Sân 7');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `image_name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `image_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `image_src` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `image_name`, `image_type`, `image_src`) VALUES
('5f959f474a247', 'Ưu đãi', 'slide', './Images/slide_1.jpg'),
('5f959f7f35870 ', 'Cảnh quan sân bóng', 'slide', './Images/slide_2.jpg'),
('5f959f9d02db1 ', 'Sân bóng chất lượng', 'slide', './Images/slide_3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `booking_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `beverage_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `beverage_cost` float NOT NULL,
  `ground_cost` float NOT NULL,
  `total_cost` float NOT NULL,
  `payment_date` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `beverage_type`, `beverage_cost`, `ground_cost`, `total_cost`, `payment_date`) VALUES
('5fc60525cc7c8', '5fc6007fdc40a', 'Sting vàng x 13', 182000, 225000, 407000, '01/12/2020'),
('5fc633282bc4a', '5fc604f79bd47', ' x 0', 0, 630000, 630000, '01/12/2020'),
('5fcb287590e25', '5fcae3e6efc16', 'Pepsi x 15', 225000, 270000, 495000, '02/12/2020');

-- --------------------------------------------------------

--
-- Table structure for table `profits`
--

CREATE TABLE `profits` (
  `profit_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `payment_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profits`
--

INSERT INTO `profits` (`profit_id`, `payment_id`) VALUES
('5fcb1f8a0093d', '5fc60525cc7c8'),
('5fcb24ac2f63d', '5fc633282bc4a'),
('5fcb287596712', '5fcb287590e25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `image_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `user_realname` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `image_id`, `user_name`, `user_phone`, `user_password`, `user_email`, `user_type`, `user_realname`) VALUES
('5f8af6a230541', '', 'Admin', '', 'e10adc3949ba59abbe56e057f20f883e', '', 'admin', ''),
('5f8af85752225', '', 'blebleble', '0918231908', '7ac66c0f148de9519b8bd264312c4d64', 'blablabla@gmail.com', '', 'Bùi Quang Khải'),
('5f8afcb816260', '', 'Staff', '', 'e10adc3949ba59abbe56e057f20f883e', 'khaiquang690@gmail.com', 'staff', ''),
('5f8afccb1da27', '', 'blablabla', '0929823922', 'e10adc3949ba59abbe56e057f20f883e', 'abc@gmail.com', '', 'Nguyễn Minh Hiếu'),
('5f8afce1b50d5', '', 'abcd', '0912812345', 'e2fc714c4727ee9395f324cd2e7f331f', 'abcd@gmail.com', '', 'Phạm Văn Vĩ'),
('5fa984dacf884', '', 'nguyenvana', '0939123111', 'e10adc3949ba59abbe56e057f20f883e', 'vana@gmail.com', '', 'Nguyễn Văn A'),
('5fbcb6f40633e', '', '', '0937012444', '', 'qkhai@gmail.com', '', 'Quang Khải'),
('5fc21c272ca60', '', '', '0112339309', '', 'vand@gmail.com', '', 'Nguyển Văn D'),
('5fc45ba9a2ab3', '', 'quangkhai', '0928192800', 'e10adc3949ba59abbe56e057f20f883e', 'quangkhai@gmail.com', '', 'Quang Khải'),
('5fc6007fdc15d', '', 'nguyenvane', '0938921234', 'e10adc3949ba59abbe56e057f20f883e', 'nguyenvane@gmail.com', '', 'Nguyễn Văn E'),
('5fca75d0dd251', '', 'vanf', '0219211211', 'e10adc3949ba59abbe56e057f20f883e', 'vanf@gmail.com', '', 'Nguyễn Văn F');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beverages`
--
ALTER TABLE `beverages`
  ADD PRIMARY KEY (`beverage_id`);

--
-- Indexes for table `bookingdetails`
--
ALTER TABLE `bookingdetails`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `bookinghistories`
--
ALTER TABLE `bookinghistories`
  ADD PRIMARY KEY (`history_id`);

--
-- Indexes for table `grounds`
--
ALTER TABLE `grounds`
  ADD PRIMARY KEY (`ground_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
