-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.17 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for science_olympiad
CREATE DATABASE IF NOT EXISTS `science_olympiad` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `science_olympiad`;


-- Dumping structure for table science_olympiad.reg_batch
CREATE TABLE IF NOT EXISTS `reg_batch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `year` year(4) NOT NULL,
  `age_as_at` date DEFAULT NULL,
  `date_of_examination` date NOT NULL,
  `time` varchar(20) NOT NULL,
  `examination_center` varchar(150) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `counter` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table science_olympiad.reg_batch: ~2 rows (approximately)
/*!40000 ALTER TABLE `reg_batch` DISABLE KEYS */;
INSERT INTO `reg_batch` (`id`, `name`, `year`, `age_as_at`, `date_of_examination`, `time`, `examination_center`, `counter`, `status`) VALUES
	(1, 'SLJSO-2016', '2016', '2015-12-31', '2015-11-01', '9.30 -11.30 am', 'කොමන්ස් ඇට්‍රිබ්යුශන්', 7, 1),
	(2, 'SLJSO-2015', '2015', '2015-12-01', '2015-11-01', '9.30 -11.30 am', 'University of Kelaniya, 001', 1, 0);
/*!40000 ALTER TABLE `reg_batch` ENABLE KEYS */;


-- Dumping structure for table science_olympiad.reg_migration
CREATE TABLE IF NOT EXISTS `reg_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table science_olympiad.reg_migration: ~2 rows (approximately)
/*!40000 ALTER TABLE `reg_migration` DISABLE KEYS */;
INSERT INTO `reg_migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1440563509),
	('m130524_201442_init', 1440563516);
/*!40000 ALTER TABLE `reg_migration` ENABLE KEYS */;


-- Dumping structure for table science_olympiad.reg_user
CREATE TABLE IF NOT EXISTS `reg_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` tinyint(4) DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` tinyint(4) DEFAULT '0',
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table science_olympiad.reg_user: ~11 rows (approximately)
/*!40000 ALTER TABLE `reg_user` DISABLE KEYS */;
INSERT INTO `reg_user` (`id`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `title`, `full_name`, `is_admin`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'dWHUCqDn7xLrY3bZ2wAAza_tDK4xh6SJ', '$2y$13$Xcx7szOxqiE3wai9teRvEeL/5usu1fOkYsySmAC.WfADz/7/389MK', NULL, 'antonlashan@gmail.com', 1, 'Lashan Fernando', 1, 1, '2015-08-26 12:22:27', '2015-10-07 17:34:07'),
	(2, 'hbPzX0qU2zfECI_LNZ8NqDUaC9oo5mjj', '$2y$13$Jc0d7mEjsRPbBwJA5NJg6.QpXn2kt0MSQQFtVKayH4SSpgcYkUB/O', NULL, 'antonlashan2@gmail.com', 1, 'Lashan Kraken', 0, 1, '2015-08-26 13:45:47', '2015-10-07 17:34:23'),
	(3, '', '', NULL, NULL, NULL, 'Tennakon Mudiyanselage Thanuja Nayana Malmi Kumari Tennakon', 0, 0, '2015-10-08 12:54:07', '2015-10-08 12:54:07'),
	(4, '', '', NULL, NULL, NULL, 'Tennakon Mudiyanselage Thanuja Nayana Malmi Kumari Tennakon', 0, 0, '2015-10-08 15:47:27', '2015-10-08 15:47:27'),
	(5, '', '', NULL, NULL, NULL, 'Tennakon Mudiyanselage Thanuja Nayana Malmi Kumari Tennakon', 0, 0, '2015-10-08 15:50:00', '2015-10-08 15:50:00'),
	(6, '', '', NULL, NULL, NULL, 'Tennakon Mudiyanselage Thanuja Nayana Malmi Kumari Tennakon', 0, 0, '2015-10-08 16:25:35', '2015-10-08 16:25:35'),
	(7, '', '', NULL, NULL, NULL, 'Tennakon Mudiyanselage Thanuja Nayana Malmi Kumari Tennakon', 0, 0, '2015-10-08 16:27:42', '2015-10-08 16:27:42'),
	(8, '', '', NULL, NULL, NULL, 'Tennakon Mudiyanselage Thanuja Nayana Malmi Kumari Tennakon', 0, 0, '2015-10-08 16:28:13', '2015-10-08 16:28:13'),
	(9, '', '', NULL, 'antonlashan@gmail.com', NULL, 'Tennakon Mudiyanselage Thanuja Nayana Malmi Kumari Tennakon', 0, 0, '2015-10-08 17:00:42', '2015-10-08 17:00:42'),
	(10, '', '', NULL, 'antonlashan@gmail.com', NULL, 'Tennakon Mudiyanselage Thanuja Nayana Malmi Kumari Tennakon', 0, 0, '2015-10-08 17:14:38', '2015-10-08 17:14:38'),
	(11, '', '', NULL, '', NULL, 'Tennakon Mudiyanselage Thanuja Nayana Malmi Kumari Tennakon', 0, 0, '2015-10-09 10:07:09', '2015-10-09 10:07:09');
/*!40000 ALTER TABLE `reg_user` ENABLE KEYS */;


-- Dumping structure for table science_olympiad.reg_user_detail
CREATE TABLE IF NOT EXISTS `reg_user_detail` (
  `user_id` int(11) NOT NULL,
  `initials` varchar(150) NOT NULL,
  `reg_no` varchar(50) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL,
  `dob` date NOT NULL,
  `college_and_address` varchar(250) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `medium` tinyint(4) NOT NULL,
  `academic_year` year(4) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table science_olympiad.reg_user_detail: ~6 rows (approximately)
/*!40000 ALTER TABLE `reg_user_detail` DISABLE KEYS */;
INSERT INTO `reg_user_detail` (`user_id`, `initials`, `reg_no`, `gender`, `dob`, `college_and_address`, `telephone`, `medium`, `academic_year`) VALUES
	(3, 'T M T N M K Tennakoon', 'FFF KK', 2, '1990-01-01', 'test', '01234567', 2, NULL),
	(5, 'T M T N M K Tennakoon', 'SLJSO-2016-00002', 2, '1990-01-01', 'dfdfdf', '01234567', 1, '2016'),
	(6, 'T M T N M K Tennakoon', 'SLJSO-2016-00003', 1, '2011-03-10', 'ggg', '01234567', 2, '2016'),
	(9, 'T M T N M K Tennakoon', 'SLJSO-2016-00004', 2, '2011-02-01', 'opop', '01234567', 1, '2016'),
	(10, 'T M T N M K Tennakoon', 'SLJSO-2016-00005', 2, '2011-02-01', 'opop', '01234567', 1, '2016'),
	(11, 'T M T N M K Tennakoon', 'SLJSO-2016-00006', 1, '2010-06-15', 'test', '01234567', 2, '2016');
/*!40000 ALTER TABLE `reg_user_detail` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
