/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `class_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `limit_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(125) NOT NULL,
  `yearlevel` int(2) NOT NULL,
  `added_by` varchar(125) NOT NULL,
  `date_time_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_time_last_updated` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `event_audience` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `id_number` varchar(35) NOT NULL,
  `event_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `remarks` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `qrcode_value` varchar(125) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `event_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
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
  `added_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `program_name` varchar(125) NOT NULL,
  `program_abbrev` varchar(15) NOT NULL,
  `status` int(1) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_time_last_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `registration_history` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(75) NOT NULL,
  `added_by` varchar(125) NOT NULL,
  `status` int(1) NOT NULL,
  `date_time_added` datetime DEFAULT NULL,
  `date_time_last_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `schoolyear` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolyear_name` varchar(25) NOT NULL,
  `added_by` varchar(125) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_name` int(25) NOT NULL,
  `added_by` varchar(125) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_time_last_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `schoolyear_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `students` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
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
  `added_by` int(11) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `time_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
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
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `department_id` int(10) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `yearlevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yearlevel_name` varchar(125) NOT NULL,
  `added_by` varchar(125) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `class_schedule` (`id`, `class_id`, `event_id`, `professor_qrcode`, `subject_code`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `date_start`, `date_end`, `schoolyear`, `added_by`, `date_time_created`, `has_limit`, `limit_time`) VALUES
(48, 3, 73, 'EVENT_SESSION_PROFESSOR_20250117_hgtbD6lP4RJhqSmJEcDv21O82nrd922AeEv', 'COM IV', '00:00-05:30', '', '', '00:00-05:30', '00:00-05:30', '', '', '2025-01-17', '2025-05-17', NULL, 1, '2025-01-17 00:03:36', 0, 0);


INSERT INTO `classes` (`id`, `class_name`, `yearlevel`, `added_by`, `date_time_added`, `date_time_last_updated`) VALUES
(2, 'A42', 4, '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `classes` (`id`, `class_name`, `yearlevel`, `added_by`, `date_time_added`, `date_time_last_updated`) VALUES
(3, 'A32', 3, '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `classes` (`id`, `class_name`, `yearlevel`, `added_by`, `date_time_added`, `date_time_last_updated`) VALUES
(4, 'A41', 4, '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');



INSERT INTO `event_list` (`id`, `title`, `subject_code`, `class_id`, `professor_id`, `room`, `description`, `venue`, `limit_registration`, `limit_time`, `user_id`, `class_schedule_id`, `date_created`, `date_update`, `added_by`) VALUES
(73, 'Java Programming', 'COM IV', 3, 16, '23', 'desc1', 'venue1', 0, 0, 3, 'CLASS_SCHEDULE_20250117_754Z0FxR7ta8e6Z88EW34JvxoqzkiA7vrvB', '2025-01-17 00:03:36', '2025-01-23 03:36:36', 1);


INSERT INTO `program` (`id`, `program_name`, `program_abbrev`, `status`, `date_time_created`, `date_time_last_updated`, `added_by`) VALUES
(1, 'BS Computer Science', 'BSCS', 1, '2025-01-16 11:23:40', '2025-01-16 11:23:40', 1);
INSERT INTO `program` (`id`, `program_name`, `program_abbrev`, `status`, `date_time_created`, `date_time_last_updated`, `added_by`) VALUES
(2, 'BS Mechanical Engineering', 'BSME', 1, '2025-01-16 11:24:10', '2025-01-16 11:24:10', 1);
INSERT INTO `program` (`id`, `program_name`, `program_abbrev`, `status`, `date_time_created`, `date_time_last_updated`, `added_by`) VALUES
(3, 'BS Information Technology', 'BSIT', 1, '2025-01-16 11:02:42', '2025-01-16 11:02:42', 1);
INSERT INTO `program` (`id`, `program_name`, `program_abbrev`, `status`, `date_time_created`, `date_time_last_updated`, `added_by`) VALUES
(4, 'BS Information Systems', 'BSIS', 1, '2025-01-16 11:07:38', '2025-01-16 11:07:38', 1),
(5, 'BS Tourism Management', 'BSTM', 1, '2025-01-16 11:09:32', '2025-01-16 11:09:32', 1),
(6, 'BS Marine Engineering', 'BSMARENG', 1, '2025-01-16 11:23:44', '2025-01-16 11:23:44', 1);

INSERT INTO `registration_history` (`id`, `student_id`, `class_id`, `date_created`, `added_by`) VALUES
(11, 80, 3, '2025-01-14 15:28:23', 1);
INSERT INTO `registration_history` (`id`, `student_id`, `class_id`, `date_created`, `added_by`) VALUES
(12, 81, 3, '2025-01-15 21:06:43', 1);
INSERT INTO `registration_history` (`id`, `student_id`, `class_id`, `date_created`, `added_by`) VALUES
(13, 82, 1, '2025-01-16 15:13:52', 1);
INSERT INTO `registration_history` (`id`, `student_id`, `class_id`, `date_created`, `added_by`) VALUES
(14, 83, 0, '2025-01-17 17:54:44', 1),
(15, 84, 3, '2025-01-17 17:55:50', 1),
(16, 85, 3, '2025-01-18 01:27:30', 1),
(17, 86, 3, '2025-01-18 01:28:25', 1),
(18, 87, 3, '2025-01-18 01:31:11', 1),
(19, 88, 3, '2025-01-18 01:37:12', 1),
(20, 89, 3, '2025-01-18 01:37:58', 1),
(21, 90, 3, '2025-01-18 01:39:37', 1),
(22, 91, 0, '2025-01-20 06:25:27', 1),
(23, 92, 3, '2025-01-20 06:29:14', 1),
(24, 93, 3, '2025-01-20 07:15:43', 1),
(25, 94, 3, '2025-01-23 05:14:23', 1);

INSERT INTO `room` (`id`, `room_name`, `added_by`, `status`, `date_time_added`, `date_time_last_updated`) VALUES
(18, 'Room 402', '1', 1, '2025-01-16 11:37:43', '2025-01-16 11:37:43');
INSERT INTO `room` (`id`, `room_name`, `added_by`, `status`, `date_time_added`, `date_time_last_updated`) VALUES
(23, 'Room 404 - Room Not Found', '1', 1, '2025-01-16 11:38:37', '2025-01-16 11:38:37');






INSERT INTO `students` (`id`, `id_number`, `class_id`, `firstname`, `lastname`, `contact`, `email`, `remarks`, `status`, `date_created`, `date_updated`, `qrcode_value`, `program`, `added_by`, `middlename`) VALUES
(90, '1991-9991-22201', 3, 'vic', 'yap', '991029301003', 'vicyap@gmail.com', 'remakr', 1, '2025-01-18 01:39:37', NULL, 'EVENT_SESSION_USER_20250118_G0DJmZ61J4eVxf8dKa5E5oc25D7mc4VJdSj', '1', 1, NULL);
INSERT INTO `students` (`id`, `id_number`, `class_id`, `firstname`, `lastname`, `contact`, `email`, `remarks`, `status`, `date_created`, `date_updated`, `qrcode_value`, `program`, `added_by`, `middlename`) VALUES
(91, 'SN-0001', 0, 'John', 'Doe', '099999999', 'johndoe@gmail.com', 'test', 1, '2025-01-20 06:25:27', NULL, 'EVENT_SESSION_USER_20250120_0Q6FbxwH20ZiF0y2pA7KxytO35RCiRL2fH6', '1', 1, NULL);
INSERT INTO `students` (`id`, `id_number`, `class_id`, `firstname`, `lastname`, `contact`, `email`, `remarks`, `status`, `date_created`, `date_updated`, `qrcode_value`, `program`, `added_by`, `middlename`) VALUES
(92, 'SN-0002', 3, 'John', 'Doe II', '099999999', 'johndoeii@gmail.com', 'test', 1, '2025-01-20 06:29:14', NULL, 'EVENT_SESSION_USER_20250120_0Q6FbxwH20ZiF0y2pA7KxytO35RCiRL2fH6', '1', 1, NULL);
INSERT INTO `students` (`id`, `id_number`, `class_id`, `firstname`, `lastname`, `contact`, `email`, `remarks`, `status`, `date_created`, `date_updated`, `qrcode_value`, `program`, `added_by`, `middlename`) VALUES
(93, 'SN-0033', 3, 'joshua', 'palma', '09774708451', 'joshua@gmail.com', 'test', 1, '2025-01-20 07:15:43', NULL, 'EVENT_SESSION_USER_20250120_hFSLpE6i4wth3N6skhVZzH5T1L2mcl2pXdZ', '1', 1, NULL),
(94, 'SN-1231231298', 3, 'Rebecca', 'Mendoza', '09773728900', 'rebecca@gmail.com', '', 1, '2025-01-23 05:14:23', NULL, 'EVENT_SESSION_USER_20250123_4RibQD35M0DYMDRZltTQWnfbqF21sT8tQ8V', '1', 1, 'Gomez');

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Event Registration System with QR Code - PHP');
INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(2, 'address', 'Philippines');
INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(3, 'contact', '+1234567890');
INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(4, 'email', 'info@sample.com'),
(5, 'fb_page', 'https://www.facebook.com/myPageName'),
(6, 'short_name', 'ERS-QR-PHP'),
(9, 'logo', 'uploads/1627260420_checklist.jpg');



INSERT INTO `users` (`id`, `id_number`, `qrcode`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`, `department_id`, `middlename`) VALUES
(1, '', '', 'Adminstrator', 'Admin', 'admin', '', '0192023a7bbd73250516f069df18b500', 'uploads/1627261440_avatar.png', NULL, 1, '2021-01-20 14:02:37', '2021-07-26 09:57:03', NULL, NULL);
INSERT INTO `users` (`id`, `id_number`, `qrcode`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`, `department_id`, `middlename`) VALUES
(3, '', '', 'John', 'Smith', 'jsmiths', '', '39ce7e2a8573b41ce73b5ba41617f8f7', 'uploads/1627264800_avatar.png', NULL, 2, '2021-07-26 10:00:18', '2024-12-19 20:07:21', NULL, NULL);
INSERT INTO `users` (`id`, `id_number`, `qrcode`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`, `department_id`, `middlename`) VALUES
(16, '1991-9991-22201', 'EVENT_SESSION_PROFESSOR_20250117_hgtbD6lP4RJhqSmJEcDv21O82nrd922AeEv', 'Reynaldo', 'Rubio', 'reynaldorubui', 'reynaldorubio@gmail.com', '93191d42497f1fae521b16bf10bd5bb5', 'uploads/1737043320_black-guy-pointing-at-head.jpg', NULL, 3, '2025-01-17 00:02:39', NULL, NULL, NULL);
INSERT INTO `users` (`id`, `id_number`, `qrcode`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`, `department_id`, `middlename`) VALUES
(17, 'SN-12345', 'EVENT_SESSION_PROFESSOR_20250123_1C4w8hFGsnq9VC1TE8l10xTnNI7imE4FctX', 'Joshua', 'Palma', 'joshua123', 'joshuapalma@gmail.com', '1405516ac77b0a8c49e9fc08783d7d99', 'uploads/1737578580_joshua-palma.png', NULL, 3, '2025-01-23 04:43:09', NULL, NULL, 'Aguillon'),
(18, 'SN-1122', 'EVENT_SESSION_PROFESSOR_20250123_juh91HlL8wU2gL22v6BmHMIDJw7epWZb3wP', 'Juan', 'Cruz', 'juancruz', 'juancruz@gmail.com', 'fefe7bac6031df397276fa3d60e8d5fc', 'uploads/1737579000_Campus Connect.jpg', NULL, 3, '2025-01-23 04:50:47', NULL, 1, 'Mercado'),
(19, 'SN-112233', 'EVENT_SESSION_PROFESSOR_20250123_juh91HlL8wU2gL22v6BmHMIDJw7epWZb3wP', 'Juan Carlos', 'Cruz', 'juancruz123', 'juancruz123@gmail.com', 'fefe7bac6031df397276fa3d60e8d5fc', 'uploads/1737579060_Campus Connect.jpg', NULL, 3, '2025-01-23 04:51:20', NULL, 1, 'Mercado'),
(20, 'SN-00987', 'EVENT_SESSION_PROFESSOR_20250123_uAq4yf0ab8x8o9XVNFvnjDu9cuN8cwRGod8', 'testing', 'testing', 'testing123`', 'test@gmail.com', '026207b3512a2b3a6a942ebd30ef269d', 'uploads/1737579480_google-logo.png', NULL, 3, '2025-01-23 04:58:42', NULL, 1, 'testing'),
(21, 'SN-234232', 'EVENT_SESSION_PROFESSOR_20250123_TjLT3A9CjpWM6nOrdiv0PBzj2LSMpl1X7mL', 'james', 'dela cruz', 'jamescruz', 'james@gmail.com', '58bcb139c1d354bdeb472681d6463e33', 'uploads/1737579540_digitalsculpt-solutions-favicon-black.png', NULL, 1, '2025-01-23 04:59:43', NULL, 0, 'doe'),
(22, '1234567890', 'EVENT_SESSION_PROFESSOR_20250123_09HL6j4OLw5LTV5ovnoW5sr14xWoV4GRxqr', 'Hello', 'test', 'helloworld', 'hello@gmail.com', '8dad5d74c962e007d700e14a8c21a481', 'uploads/1737579780_about-us.png', NULL, 3, '2025-01-23 05:03:19', NULL, 0, 'World');




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;