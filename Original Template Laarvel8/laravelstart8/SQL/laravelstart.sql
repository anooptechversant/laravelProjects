-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 21, 2020 at 07:33 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravelstart`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `user_type`, `status`) VALUES
(1, 'admin', 'RHdKQlVHYVJ2N3hnSTZqbWhObi9Ndz09', 'admin', 'active'),
(2, 'sumesh', 'RHdKQlVHYVJ2N3hnSTZqbWhObi9Ndz09', 'staff', 'active'),
(3, 'test', 'NjArcVgzdkxMbFE2emJXT3gydUtsZz09', 'staff', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

DROP TABLE IF EXISTS `api`;
CREATE TABLE IF NOT EXISTS `api` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api`
--

INSERT INTO `api` (`id`, `content`) VALUES
(1, 'test1'),
(2, 'test2');

-- --------------------------------------------------------

--
-- Table structure for table `left_menu`
--

DROP TABLE IF EXISTS `left_menu`;
CREATE TABLE IF NOT EXISTS `left_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `url` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `menu_order` int(11) NOT NULL,
  `menu_table` varchar(50) DEFAULT NULL,
  `active_file` text DEFAULT NULL,
  `menu_type` varchar(100) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `show_home` enum('yes','no') NOT NULL DEFAULT 'yes',
  `color` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `left_menu`
--

INSERT INTO `left_menu` (`id`, `name`, `url`, `icon`, `menu_order`, `menu_table`, `active_file`, `menu_type`, `menu_id`, `status`, `show_home`, `color`) VALUES
(2, 'Manage Pages', 'list-page', 'edit', 4, 'pages', 'list-page,add-page,pages', 'sub-menu', 7, 'active', 'yes', '#E91E63'),
(3, 'Manage News', 'list-news', 'far fa-newspaper', 3, 'news', 'list-news,news', 'menu', NULL, 'active', 'yes', '#3498DB'),
(4, 'Admin Users', 'list-admin', 'users', 5, 'admin', 'list-admin,user', 'menu', NULL, 'active', 'yes', 'green'),
(6, 'Dashboard', 'dashboard', 'th-large', 1, '', 'home', 'menu', NULL, 'active', 'no', 'green'),
(7, 'Manage Content', NULL, 'edit', 2, '', 'list-page,add-page,pages', 'menu', NULL, 'active', 'no', NULL),
(14, 'Sumesh', '3434', '343', 10, '', '343', 'sub-menu', 11, 'active', 'no', '343'),
(15, 'Sumesh2', '3434', '343', 11, '', '343', 'sub-menu', 11, 'active', 'no', '343'),
(16, 'Sumesh2w', '232', '23', 12, '', '232', 'sub-menu', 11, 'active', 'no', NULL),
(17, 'Sumesh2w', '232', '23', 13, 'admin', '232', 'sub-menu', 11, 'active', 'no', NULL),
(18, 'Sumesh2w', '232', '23', 14, '', '232', 'sub-menu', 11, 'active', 'no', NULL),
(19, 'Sumesh66', '232232', '23', 18, '', '232', 'sub-menu', 11, 'active', 'no', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(200) NOT NULL,
  `description` blob NOT NULL,
  `news_date` date NOT NULL,
  `news_location` varchar(200) DEFAULT NULL,
  `news_image` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `news_title`, `description`, `news_date`, `news_location`, `news_image`) VALUES
(1, 'Test', '', '2020-07-04', '2323', ''),
(2, 'wewew', '', '2020-07-10', NULL, ''),
(3, 'we', '', '2020-07-28', NULL, ''),
(4, 'ere', '', '2020-11-20', NULL, ''),
(5, 'erere', '', '2020-07-04', NULL, ''),
(6, 'wew', '', '2020-07-04', NULL, ''),
(7, 'wew', '', '2020-07-04', NULL, ''),
(8, 'ere', '', '2020-07-04', NULL, ''),
(10, 'ere', 0x5048412b64336338596e492b5043397750673d3d, '2020-07-05', 'www', ''),
(11, 'ere', 0x5048412b64336338596e492b5043397750673d3d, '2020-07-05', 'www', ''),
(12, 'ere', 0x5048412b64336338596e492b5043397750673d3d, '2020-07-05', 'www', ''),
(13, 'qwqw', 0x5048412b6358647863547869636a34384c33412b, '2020-07-06', NULL, ''),
(14, 'qwqw', 0x5048412b6358647863547869636a34384c33412b, '2020-07-06', NULL, ''),
(15, 'qwqw', 0x5048412b6358647863547869636a34384c33412b, '2020-07-06', NULL, ''),
(16, 'qwqw', 0x5048412b6358647863547869636a34384c33412b, '2020-07-06', NULL, ''),
(18, 'we4e', '', '2020-07-28', '232', '');

-- --------------------------------------------------------

--
-- Table structure for table `news_images`
--

DROP TABLE IF EXISTS `news_images`;
CREATE TABLE IF NOT EXISTS `news_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_image` varchar(200) NOT NULL,
  `news_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news_images`
--

INSERT INTO `news_images` (`id`, `sub_image`, `news_id`) VALUES
(1, 'F:\\wamp\\tmp\\php6D62.tmp', 16),
(2, 'F:\\wamp\\tmp\\php6D63.tmp', 16);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` longblob NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  `page` varchar(50) NOT NULL,
  `created_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
