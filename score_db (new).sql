-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 20, 2022 at 03:40 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `score_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkserver`
--

DROP TABLE IF EXISTS `checkserver`;
CREATE TABLE IF NOT EXISTS `checkserver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `progress` varchar(255) NOT NULL,
  `countup_progress` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `checkserver`
--

INSERT INTO `checkserver` (`id`, `progress`, `countup_progress`) VALUES
(1, 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `pool_list`
--

DROP TABLE IF EXISTS `pool_list`;
CREATE TABLE IF NOT EXISTS `pool_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(100) NOT NULL,
  `date` varchar(255) NOT NULL,
  `step` tinyint(4) NOT NULL COMMENT '0:active,1:first,2:second,3:third,4:fourth,5:top,6:start',
  `order_num` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waiting_time` int(11) NOT NULL,
  `countdown_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `waiting_time`, `countdown_time`) VALUES
(1, 30, 300);

-- --------------------------------------------------------

--
-- Table structure for table `table_num`
--

DROP TABLE IF EXISTS `table_num`;
CREATE TABLE IF NOT EXISTS `table_num` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `left_num` int(11) NOT NULL,
  `right_num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_num`
--

INSERT INTO `table_num` (`id`, `left_num`, `right_num`) VALUES
(1, 0, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
