-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2020 at 03:26 PM
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
('5f9cec65e6043', '5f8af85752225', '5f959e7341ea3', '8:00', '11:15', '07/10/2020'),
('5fa1885392ea8', '5f8afccb1da27', '5f959edf3e148', '13:10', '15:45', '07/10/2020'),
('5fa1897de824b', '5f8afce1b50d5', '5f959eedcdf06', '7:25', '8:00', '07/10/2020'),
('5fa2492cdf87b', '5f8afccb1da27', '5f959edf3e148', '7:00', '11:00', '04/11/2020'),
('5fa2c6fef3c72', '5f8af85752225', '5f959edf3e148', '18:00', '20:30', '03/11/2020'),
('5fa41a08791e2', '5f8afce1b50d5', '5f959ecb2c2aa', '7:00', '13:00', '03/11/2020');

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
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `other_cost` float NOT NULL,
  `total_cost` float NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profits`
--

CREATE TABLE `profits` (
  `profit_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
('5f8af85752225', '', 'blebleble', '0918231234', '7ac66c0f148de9519b8bd264312c4d64', 'blebleble@gmail.com', '', 'Bùi Quang Khải'),
('5f8afcb816260', '', 'Staff', '', 'adcaec3805aa912c0d0b14a81bedb6ff', 'khaiquang690@gmail.com', 'staff', ''),
('5f8afccb1da27', '', 'blablabla', '0929823921', 'e80b5017098950fc58aad83c8c14978e', 'abc@gmail.com', '', 'Nguyễn Minh Hiếu'),
('5f8afce1b50d5', '', 'abcd', '0912812345', 'e2fc714c4727ee9395f324cd2e7f331f', 'abcd@gmail.com', '', 'Phạm Văn Vĩ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookingdetails`
--
ALTER TABLE `bookingdetails`
  ADD PRIMARY KEY (`booking_id`);

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
-- Indexes for table `payment`
--
ALTER TABLE `payment`
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
