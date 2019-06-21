-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 04, 2019 at 09:58 AM
-- Server version: 8.0.11
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgic-user`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `deleteUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUser` (IN `u_c_id` INT(11))  BEGIN   
           DELETE FROM user_company WHERE user_company_id = u_c_id;  
           END$$

DROP PROCEDURE IF EXISTS `insertUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUser` (IN `user_id_company` INT(11), `company_name` INT(11), `recruited_date` DATE, `work_role` VARCHAR(100), `Contract_Period` VARCHAR(100))  BEGIN  
                INSERT INTO user_company(user_id, company_id,recruited_date,working_status,work_role,Contract_Period) VALUES (user_id_company, company_name,recruited_date,'Working',work_role,Contract_Period);   
                END$$

DROP PROCEDURE IF EXISTS `selectUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `selectUser` (IN `u_id` INT(11))  BEGIN  
  SELECT  oc.company_name,uc.recruited_date,uc.working_status,uc.user_company_id,uc.work_role,uc.contract_period 
  FROM USER_COMPANY uc JOIN out_source_company oc 
  ON uc.company_id = oc.company_id 
  WHERE user_id=u_id ORDER BY user_company_id DESC; 
  END$$

DROP PROCEDURE IF EXISTS `updateUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUser` (IN `u_c_id` INT(11), `company_name` INT(11), `recruited_date1` DATE, `work_role1` VARCHAR(100), `Contract_Period1` VARCHAR(100))  BEGIN   
                UPDATE user_company SET company_id = company_name, recruited_date = recruited_date1,work_role = work_role1,Contract_Period = Contract_Period1
                WHERE user_company_id = u_c_id;  
                END$$

DROP PROCEDURE IF EXISTS `whereUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `whereUser` (IN `u_company_id` INT(11))  BEGIN   
      SELECT * FROM USER_COMPANY WHERE user_company_id = u_company_id;  
      END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `time_in` time NOT NULL,
  `time_out` time DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `time_in`, `time_out`, `user_id`, `date`) VALUES
(1, '10:00:00', NULL, 1, '2019-05-29'),
(2, '01:00:00', '04:00:00', 1, '2019-05-30'),
(3, '09:00:00', '10:00:00', 1, '2019-05-27'),
(4, '01:00:00', '08:00:00', 1, '2019-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `color`, `start`, `end`, `duration`, `description`, `project_id`) VALUES
(2, 'okop', NULL, '2019-05-14 00:00:00', '2019-05-18 00:00:00', 90, 'ok123', 1),
(4, 'gfgh', NULL, '2019-05-22 00:00:00', '2019-05-22 00:00:00', 60, 'jh', 1),
(5, 'done', NULL, '2019-05-23 00:00:00', '2019-05-23 00:00:00', 120, 'fine', 1),
(6, '123', NULL, '2019-05-24 00:00:00', '2019-05-24 00:00:00', 120, 'test', 2),
(8, '456', NULL, '2019-05-24 00:00:00', '2019-05-24 00:00:00', 30, 'iop', 2),
(9, 'xyz', NULL, '2019-05-24 00:00:00', '2019-05-24 00:00:00', 120, 'test', 1),
(10, 'lmn', NULL, '2019-05-24 00:00:00', '2019-05-24 00:00:00', 120, 'ok', 1),
(11, 'tgesty', NULL, '2019-05-24 00:00:00', '2019-05-24 00:00:00', 120, 'ok', 1),
(12, 'ok', NULL, '2019-05-27 00:00:00', '2019-05-27 00:00:00', 60, 'test', 1),
(14, 'yu', NULL, '2019-05-27 00:00:00', '2019-05-27 00:00:00', 120, 'ko', 1),
(15, 'test', NULL, '2019-05-27 00:00:00', '2019-05-27 00:00:00', 120, 'ok', 2),
(16, 'op', NULL, '2019-05-27 00:00:00', '2019-05-27 00:00:00', 60, 'op', 1),
(17, 'ok', NULL, '2019-03-04 00:00:00', '2019-03-04 00:00:00', 30, 'fine', 2),
(26, 'ok', NULL, '2019-05-30 00:00:00', '2019-05-30 00:00:00', 60, 'fine', 3),
(29, 'goog', NULL, '2019-05-31 00:00:00', '2019-05-31 00:00:00', 120, 'ok', 3),
(32, 'okghhjjhjjjjj', NULL, '2019-05-31 00:00:00', '2019-06-02 00:00:00', 120, 'fine', 3);

-- --------------------------------------------------------

--
-- Table structure for table `out_source_company`
--

DROP TABLE IF EXISTS `out_source_company`;
CREATE TABLE IF NOT EXISTS `out_source_company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_status` enum('Active','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `company_name` (`company_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `out_source_company`
--

INSERT INTO `out_source_company` (`company_id`, `company_name`, `contact_number`, `email`, `address`, `company_status`) VALUES
(1, 'sgic', '0212222345', 'sgic@ty.com', '10,address', 'Active'),
(3, 'invicta', '0231111112', 'test@gmail.com', 'test, dsdsd', 'Active'),
(4, 'xyz', '123456789', 'email@qwe.com', '72 , palaly road', 'Active'),
(5, 'test', '1234567810', 'as@we.com', '11, plaly road', 'Active'),
(6, 'testwer', '1234567891', 'testEr@we.com', 'ok,12 ,fgghh', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_status` enum('In_progress','Finished') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `user_id`, `project_name`, `start_date`, `description`, `remarks`, `project_status`) VALUES
(1, 61, 'test', '2019-05-14', 'ok', 'ok', 'In_progress'),
(2, 61, 'test', '2019-05-15', 'ty124@', 'test', 'In_progress'),
(3, 1, 'test', '2019-05-09', 'test', 'test', 'In_progress'),
(4, 1, 'test1', '2019-05-17', 'ok', 'fine', 'In_progress');

-- --------------------------------------------------------

--
-- Table structure for table `pwdreset`
--

DROP TABLE IF EXISTS `pwdreset`;
CREATE TABLE IF NOT EXISTS `pwdreset` (
  `pwdResetId` int(11) NOT NULL AUTO_INCREMENT,
  `pwdResetEmail` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pwdResetSelector` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pwdResetToken` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pwdResetExpires` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pwdResetId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `termination`
--

DROP TABLE IF EXISTS `termination`;
CREATE TABLE IF NOT EXISTS `termination` (
  `termination_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_company_id` int(11) NOT NULL,
  `date_of_termination` date NOT NULL,
  PRIMARY KEY (`termination_id`),
  KEY `termination_key` (`user_company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `termination`
--

INSERT INTO `termination` (`termination_id`, `user_company_id`, `date_of_termination`) VALUES
(1, 3, '2018-09-23'),
(5, 2, '2019-06-11'),
(7, 3, '2018-09-23');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int(11) NOT NULL,
  `user_status` enum('Active','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_type`, `user_status`) VALUES
(1, 'jeromeqw', 'jerome11sgic@gmail.com', '$2y$10$mGXMJJVqNGNPi.om5R9A/u84.TWmtR9nKC/R1e2bHQFXxXjAg0oae', 1, 'Inactive'),
(2, 'thiruppghh', 'thirupparan1994@gmai.com', 'zYRtoQlZ', 1, 'Active'),
(3, 'test', 'thu45@hj.com', '$2y$10$F1LOrYp8qUZjRx2bc.6CK.5/rz1wIgfOz3DRJ.Kju3MtZe7QDFz1S', 2, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `user_company`
--

DROP TABLE IF EXISTS `user_company`;
CREATE TABLE IF NOT EXISTS `user_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `recruited_date` date NOT NULL,
  `working_status` enum('Working','Not_working') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_period` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_key` (`company_id`),
  KEY `user_key` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_company`
--

INSERT INTO `user_company` (`id`, `user_id`, `company_id`, `recruited_date`, `working_status`, `work_role`, `contract_period`) VALUES
(2, 1, 1, '2019-12-09', 'Working', 'se', '6'),
(3, 1, 5, '2019-05-15', 'Not_working', 'admin', 'test'),
(8, 2, 3, '2019-06-07', 'Working', 'Q-A Engineer', '6');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE IF NOT EXISTS `user_profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`profile_id`, `user_id`, `first_name`, `last_name`, `address`, `contact_number`, `photo`) VALUES
(8, 18, 'paran123', 'shanmuganathan', '																																																																																																																																																								sgic																																												', '0778368806', '6fc84d975a1d3ec9c0fd76241d4436ba.PNG'),
(39, 61, '#####', '#####', '#####', '####', 'person.png'),
(40, 63, '#####', '#####', '#####', '####', 'person.png'),
(41, 64, '#####', '#####', '#####', '####', 'person.png'),
(42, 65, '#####', '#####', '#####', '####', 'person.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_status` enum('Active','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `role_name`, `role_status`) VALUES
(1, 'Admin', 'Active'),
(2, 'HR', 'Active'),
(3, 'engineer', 'Active'),
(4, 'ty manager', 'Active');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `termination`
--
ALTER TABLE `termination`
  ADD CONSTRAINT `recruit_key` FOREIGN KEY (`user_company_id`) REFERENCES `user_company` (`id`);

--
-- Constraints for table `user_company`
--
ALTER TABLE `user_company`
  ADD CONSTRAINT `company_key` FOREIGN KEY (`company_id`) REFERENCES `out_source_company` (`company_id`),
  ADD CONSTRAINT `user_key` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
