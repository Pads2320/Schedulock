-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2025 at 06:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(125) NOT NULL,
  `yearlevel` int(2) NOT NULL,
  `added_by` varchar(125) NOT NULL,
  `date_time_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_time_last_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `yearlevel`, `added_by`, `date_time_added`, `date_time_last_updated`) VALUES
(2, 'A42', 4, '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'A32', 3, '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'A41', 4, '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule`
--

CREATE TABLE `class_schedule` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `professor_qrcode` varchar(150) NOT NULL,
  `subject_code` varchar(75) NOT NULL,
  `monday` varchar(25) NOT NULL,
  `tuesday` varchar(25) NOT NULL,
  `wednesday` varchar(25) NOT NULL,
  `thursday` varchar(25) NOT NULL,
  `friday` varchar(25) NOT NULL,
  `saturday` varchar(25) NOT NULL,
  `sunday` varchar(25) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `schoolyear` varchar(11) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT current_timestamp(),
  `has_limit` int(1) NOT NULL,
  `limit_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_schedule`
--

INSERT INTO `class_schedule` (`id`, `class_id`, `event_id`, `professor_qrcode`, `subject_code`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `date_start`, `date_end`, `schoolyear`, `added_by`, `date_time_created`, `has_limit`, `limit_time`) VALUES
(48, 3, 73, 'EVENT_SESSION_PROFESSOR_20250117_hgtbD6lP4RJhqSmJEcDv21O82nrd922AeEv', 'COM IV', '00:00-05:30', '', '', '00:00-05:30', '00:00-05:30', '', '', '2025-01-17', '2025-05-17', NULL, 1, '2025-01-17 00:03:36', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_audience`
--

CREATE TABLE `event_audience` (
  `id` int(30) NOT NULL,
  `id_number` varchar(35) NOT NULL,
  `event_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `remarks` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `qrcode_value` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_list`
--

CREATE TABLE `event_list` (
  `id` int(30) NOT NULL,
  `title` varchar(250) NOT NULL,
  `subject_code` varchar(75) NOT NULL,
  `class_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `room` varchar(75) NOT NULL,
  `description` text NOT NULL,
  `venue` text NOT NULL,
  `limit_registration` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Don''t Close, 1= entry has timeout',
  `limit_time` float DEFAULT NULL,
  `user_id` int(30) NOT NULL,
  `class_schedule_id` varchar(175) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_list`
--

INSERT INTO `event_list` (`id`, `title`, `subject_code`, `class_id`, `professor_id`, `room`, `description`, `venue`, `limit_registration`, `limit_time`, `user_id`, `class_schedule_id`, `date_created`, `date_update`, `added_by`) VALUES
(73, 'Java Programming', 'COM IV', 3, 16, '23', 'desc', 'venue', 0, 0, 0, 'CLASS_SCHEDULE_20250117_754Z0FxR7ta8e6Z88EW34JvxoqzkiA7vrvB', '2025-01-17 00:03:36', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `id` int(11) NOT NULL,
  `program_name` varchar(125) NOT NULL,
  `program_abbrev` varchar(15) NOT NULL,
  `status` int(1) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_time_last_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`id`, `program_name`, `program_abbrev`, `status`, `date_time_created`, `date_time_last_updated`, `added_by`) VALUES
(1, 'BS Computer Science', 'BSCS', 1, '2025-01-16 11:23:40', '2025-01-16 11:23:40', 1),
(2, 'BS Mechanical Engineering', 'BSME', 1, '2025-01-16 11:24:10', '2025-01-16 11:24:10', 1),
(3, 'BS Information Technology', 'BSIT', 1, '2025-01-16 11:02:42', '2025-01-16 11:02:42', 1),
(4, 'BS Information Systems', 'BSIS', 1, '2025-01-16 11:07:38', '2025-01-16 11:07:38', 1),
(5, 'BS Tourism Management', 'BSTM', 1, '2025-01-16 11:09:32', '2025-01-16 11:09:32', 1),
(6, 'BS Marine Engineering', 'BSMARENG', 1, '2025-01-16 11:23:44', '2025-01-16 11:23:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `registration_history`
--

CREATE TABLE `registration_history` (
  `id` int(30) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration_history`
--

INSERT INTO `registration_history` (`id`, `student_id`, `class_id`, `date_created`, `added_by`) VALUES
(11, 80, 3, '2025-01-14 15:28:23', 1),
(12, 81, 3, '2025-01-15 21:06:43', 1),
(13, 82, 1, '2025-01-16 15:13:52', 1),
(14, 83, 0, '2025-01-17 17:54:44', 1),
(15, 84, 3, '2025-01-17 17:55:50', 1),
(16, 85, 3, '2025-01-18 01:27:30', 1),
(17, 86, 3, '2025-01-18 01:28:25', 1),
(18, 87, 3, '2025-01-18 01:31:11', 1),
(19, 88, 3, '2025-01-18 01:37:12', 1),
(20, 89, 3, '2025-01-18 01:37:58', 1),
(21, 90, 3, '2025-01-18 01:39:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `room_name` varchar(75) NOT NULL,
  `added_by` varchar(125) NOT NULL,
  `status` int(1) NOT NULL,
  `date_time_added` datetime DEFAULT NULL,
  `date_time_last_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `room_name`, `added_by`, `status`, `date_time_added`, `date_time_last_updated`) VALUES
(18, 'Room 402', '1', 1, '2025-01-16 11:37:43', '2025-01-16 11:37:43'),
(23, 'Room 404 - Room Not Found', '1', 1, '2025-01-16 11:38:37', '2025-01-16 11:38:37');

-- --------------------------------------------------------

--
-- Table structure for table `schoolyear`
--

CREATE TABLE `schoolyear` (
  `id` int(11) NOT NULL,
  `schoolyear_name` varchar(25) NOT NULL,
  `added_by` varchar(125) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `section_name` int(25) NOT NULL,
  `added_by` varchar(125) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_time_last_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `schoolyear_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(30) NOT NULL,
  `id_number` varchar(35) NOT NULL,
  `class_id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `remarks` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `qrcode_value` varchar(125) NOT NULL,
  `program` varchar(125) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `id_number`, `class_id`, `firstname`, `lastname`, `contact`, `email`, `remarks`, `status`, `date_created`, `date_updated`, `qrcode_value`, `program`, `added_by`) VALUES
(90, '1991-9991-22201', 3, 'vic', 'yap', '991029301003', 'vicyap@gmail.com', 'remakr', 1, '2025-01-18 01:39:37', NULL, 'EVENT_SESSION_USER_20250118_G0DJmZ61J4eVxf8dKa5E5oc25D7mc4VJdSj', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Event Registration System with QR Code - PHP'),
(2, 'address', 'Philippines'),
(3, 'contact', '+1234567890'),
(4, 'email', 'info@sample.com'),
(5, 'fb_page', 'https://www.facebook.com/myPageName'),
(6, 'short_name', 'ERS-QR-PHP'),
(9, 'logo', 'uploads/1627260420_checklist.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `time_schedule`
--

CREATE TABLE `time_schedule` (
  `id` int(11) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `id_number` varchar(35) NOT NULL,
  `qrcode` varchar(125) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `email` varchar(125) NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=Admin,2=Registrar, 3=Professor',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_number`, `qrcode`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, '', '', 'Adminstrator', 'Admin', 'admin', '', '0192023a7bbd73250516f069df18b500', 'uploads/1627261440_avatar.png', NULL, 1, '2021-01-20 14:02:37', '2021-07-26 09:57:03'),
(3, '', '', 'John', 'Smith', 'jsmiths', '', '39ce7e2a8573b41ce73b5ba41617f8f7', 'uploads/1627264800_avatar.png', NULL, 2, '2021-07-26 10:00:18', '2024-12-19 20:07:21'),
(16, '1991-9991-22201', 'EVENT_SESSION_PROFESSOR_20250117_hgtbD6lP4RJhqSmJEcDv21O82nrd922AeEv', 'Reynaldo', 'Rubio', 'reynaldorubui', 'reynaldorubio@gmail.com', '93191d42497f1fae521b16bf10bd5bb5', 'uploads/1737043320_black-guy-pointing-at-head.jpg', NULL, 3, '2025-01-17 00:02:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `yearlevel`
--

CREATE TABLE `yearlevel` (
  `id` int(11) NOT NULL,
  `yearlevel_name` varchar(125) NOT NULL,
  `added_by` varchar(125) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_audience`
--
ALTER TABLE `event_audience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_list`
--
ALTER TABLE `event_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration_history`
--
ALTER TABLE `registration_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schoolyear`
--
ALTER TABLE `schoolyear`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_schedule`
--
ALTER TABLE `time_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yearlevel`
--
ALTER TABLE `yearlevel`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `class_schedule`
--
ALTER TABLE `class_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `event_audience`
--
ALTER TABLE `event_audience`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `event_list`
--
ALTER TABLE `event_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `registration_history`
--
ALTER TABLE `registration_history`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `schoolyear`
--
ALTER TABLE `schoolyear`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `time_schedule`
--
ALTER TABLE `time_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `yearlevel`
--
ALTER TABLE `yearlevel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
