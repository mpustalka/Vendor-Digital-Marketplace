-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 26, 2020 at 08:40 AM
-- Server version: 5.7.28
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

DROP TABLE IF EXISTS `item_category`;
CREATE TABLE IF NOT EXISTS `item_category` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(50) NOT NULL,
  `c_date` date NOT NULL,
  `c_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_childcategory`
--

DROP TABLE IF EXISTS `item_childcategory`;
CREATE TABLE IF NOT EXISTS `item_childcategory` (
  `ch_id` int(11) NOT NULL AUTO_INCREMENT,
  `ch_name` varchar(50) NOT NULL,
  `ch_c_id` int(11) NOT NULL,
  `ch_c_name` varchar(50) NOT NULL,
  `ch_s_id` int(11) NOT NULL,
  `ch_s_name` varchar(50) NOT NULL,
  `ch_status` tinyint(1) NOT NULL DEFAULT '1',
  `ch_date` date NOT NULL,
  PRIMARY KEY (`ch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_db`
--

DROP TABLE IF EXISTS `item_db`;
CREATE TABLE IF NOT EXISTS `item_db` (
  `item_Id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL,
  `regular_price` int(11) NOT NULL,
  `extended_price` int(11) NOT NULL,
  `main_category` int(11) NOT NULL,
  `sub_category` varchar(10) DEFAULT NULL,
  `child_category` varchar(10) DEFAULT NULL,
  `item_description` longtext NOT NULL,
  `item_thumbnail` varchar(100) DEFAULT NULL,
  `item_preview` varchar(100) DEFAULT NULL,
  `item_mainfile` varchar(100) DEFAULT NULL,
  `item_docufile` varchar(100) DEFAULT NULL,
  `item_tags` text,
  `item_demo_link` varchar(255) DEFAULT NULL,
  `item_youtube_link` varchar(255) DEFAULT NULL,
  `item_youtube_id` varchar(100) DEFAULT NULL,
  `item_sale` int(11) NOT NULL DEFAULT '0',
  `item_rated_by` int(11) NOT NULL DEFAULT '0',
  `item_star_count` decimal(18,2) NOT NULL DEFAULT '0.00',
  `item_rating` decimal(18,2) NOT NULL DEFAULT '0.00',
  `item_featured` tinyint(1) NOT NULL DEFAULT '0',
  `was_featured` tinyint(1) NOT NULL DEFAULT '0',
  `item_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`item_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_rating`
--

DROP TABLE IF EXISTS `item_rating`;
CREATE TABLE IF NOT EXISTS `item_rating` (
  `item_rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_rating_itemid` int(11) NOT NULL,
  `item_u_id` int(11) NOT NULL,
  `item_star` decimal(18,2) NOT NULL,
  `item_rating_description` varchar(255) DEFAULT NULL,
  `item_rating_date` date NOT NULL,
  `rating_rights_revoke` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_rating_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_subcategory`
--

DROP TABLE IF EXISTS `item_subcategory`;
CREATE TABLE IF NOT EXISTS `item_subcategory` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_c_name` varchar(50) NOT NULL,
  `s_c_id` int(11) NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `s_status` tinyint(1) NOT NULL DEFAULT '1',
  `s_date` date NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ot_admin`
--

DROP TABLE IF EXISTS `ot_admin`;
CREATE TABLE IF NOT EXISTS `ot_admin` (
  `id` int(11) NOT NULL,
  `adm_email` varchar(100) NOT NULL,
  `adm_password` varchar(60) NOT NULL,
  `otp` int(4) DEFAULT NULL,
  `user_chance` tinyint(1) NOT NULL DEFAULT '3',
  `rec_email` varchar(50) DEFAULT NULL,
  `email_comment` tinyint(1) NOT NULL DEFAULT '0',
  `rec_email_comment` tinyint(1) NOT NULL DEFAULT '0',
  `pay_email` tinyint(1) NOT NULL DEFAULT '0',
  `unblock_msg` varchar(100) NOT NULL DEFAULT 'We''ve Unblocked you. Thanks.',
  `mainfile_email` tinyint(1) NOT NULL DEFAULT '0',
  `rating_email` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ot_admin`
--

INSERT INTO `ot_admin` (`id`, `adm_email`, `adm_password`, `otp`, `user_chance`, `rec_email`, `email_comment`, `rec_email_comment`, `pay_email`, `unblock_msg`, `mainfile_email`, `rating_email`) VALUES
(1, 'admin@admin.com', '$2y$10$dtllVJZBMzAsbt608Vs1sOyi8DCAL4pzqZM/6oZEXoXg6BHOIpale', NULL, 3, NULL, 0, 0, 0, 'We&#39;ve Unblocked you. Thanks.', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ot_admin_pages`
--

DROP TABLE IF EXISTS `ot_admin_pages`;
CREATE TABLE IF NOT EXISTS `ot_admin_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(25) NOT NULL,
  `page_slug` varchar(25) NOT NULL,
  `page_text` text NOT NULL,
  `page_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ot_payments`
--

DROP TABLE IF EXISTS `ot_payments`;
CREATE TABLE IF NOT EXISTS `ot_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_user_id` int(11) NOT NULL,
  `p_item_id` int(11) NOT NULL,
  `p_total_amt` decimal(18,2) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `payment_date` date NOT NULL,
  `complete_status` tinyint(1) NOT NULL DEFAULT '0',
  `p_license` varchar(25) NOT NULL DEFAULT 'Regular',
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ot_tags`
--

DROP TABLE IF EXISTS `ot_tags`;
CREATE TABLE IF NOT EXISTS `ot_tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_item_id` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ot_user`
--

DROP TABLE IF EXISTS `ot_user`;
CREATE TABLE IF NOT EXISTS `ot_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_pass` varchar(60) NOT NULL,
  `user_otp` varchar(10) DEFAULT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT '0',
  `u_chance` tinyint(1) NOT NULL DEFAULT '0',
  `register_date` date NOT NULL,
  `user_blocked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ot_user_comment`
--

DROP TABLE IF EXISTS `ot_user_comment`;
CREATE TABLE IF NOT EXISTS `ot_user_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_user_id` int(11) NOT NULL,
  `comment_item_id` int(11) NOT NULL,
  `user_comment` text NOT NULL,
  `admin_comment` text,
  `comment_status` tinyint(1) NOT NULL DEFAULT '1',
  `comment_date` date NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
