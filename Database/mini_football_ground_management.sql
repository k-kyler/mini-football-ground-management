-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2020 at 05:42 AM
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
  `booking_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `booking_phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `booking_ground` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `booking_start` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `booking_end` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `booking_totaltime` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `booking_totalmoney` int(11) NOT NULL,
  `booking_date` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `booking_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bookingdetails`
--

INSERT INTO `bookingdetails` (`booking_id`, `booking_name`, `booking_phone`, `booking_ground`, `booking_start`, `booking_end`, `booking_totaltime`, `booking_totalmoney`, `booking_date`, `booking_status`) VALUES
('5f8af909172cd', 'Bùi Quang Khải', '0938028109', 'Sân 5', '17:00', '20:00', '180 phút', 540000, '07/10/2020', 'isPaid'),
('5f8af9ea9df1b', 'Phạm Văn Vĩ', '0928186789', 'Sân 7', '13:00', '14:00', '60 phút', 180000, '07/10/2020', 'isPaid'),
('5f8afa11d2bac', 'Nguyễn Minh Hiếu', '0938012987', 'Sân 1', '9:00', '12:00', '180 phút', 540000, '07/10/2020', '');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL,
  `image_name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `image_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `image_src` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `image_name`, `image_type`, `image_src`) VALUES
(1, 'Ưu đãi', 'slide', './Images/slide_1.jpg'),
(2, 'Cảnh quan sân bóng', 'slide', './Images/slide_2.jpg'),
(3, 'Sân bóng chất lượng', 'slide', './Images/slide_3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
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

INSERT INTO `users` (`user_id`, `user_name`, `user_phone`, `user_password`, `user_email`, `user_type`, `user_realname`) VALUES
(' 5f8af85752225', 'blebleble', '0918231234', '7ac66c0f148de9519b8bd264312c4d64', 'blebleble@gmail.com', '', 'Bùi Quang Khải'),
('5f8af6a230541', 'Admin', '', 'e10adc3949ba59abbe56e057f20f883e', '', 'admin', ''),
('5f8afcb816260', 'Staff', '0938028109', 'adcaec3805aa912c0d0b14a81bedb6ff', 'khaiquang690@gmail.com', 'staff', ''),
('5f8afccb1da27', 'blablabla', '0929823921', 'e80b5017098950fc58aad83c8c14978e', 'abc@gmail.com', '', ''),
('5f8afce1b50d5', 'abcd', '0912812345', 'e2fc714c4727ee9395f324cd2e7f331f', 'abcd@gmail.com', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookingdetails`
--
ALTER TABLE `bookingdetails`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
