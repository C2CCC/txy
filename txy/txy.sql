-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-12-23 08:41:26
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `txy`
--

-- --------------------------------------------------------

--
-- 表的结构 `booked_tickets`
--

CREATE TABLE IF NOT EXISTS `booked_tickets` (
  `stunum` varchar(10) NOT NULL,
  `tno` varchar(20) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `complete` int(11) NOT NULL,
  PRIMARY KEY (`stunum`,`tno`),
  KEY `tno` (`tno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `order_form`
--

CREATE TABLE IF NOT EXISTS `order_form` (
  `stunum` varchar(10) NOT NULL,
  `tno` varchar(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(5) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `order_form`
--

INSERT INTO `order_form` (`stunum`, `tno`, `amount`, `status`, `time`) VALUES
('031302305', '1', 2, '已完成', '2015-12-23 08:36:14'),
('031302305', '1', 2, '已完成', '2015-12-23 08:37:54'),
('031302305', '1', 2, '已完成', '2015-12-23 08:39:43'),
('031302305', '1', 2, '已退票', '2015-12-23 08:39:45');

-- --------------------------------------------------------

--
-- 表的结构 `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `tno` varchar(20) NOT NULL,
  `departure` varchar(20) NOT NULL,
  `destination` varchar(20) NOT NULL,
  `time` datetime NOT NULL,
  `price` int(11) NOT NULL,
  `rest` int(11) NOT NULL,
  `deadline` datetime NOT NULL,
  PRIMARY KEY (`tno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ticket`
--

INSERT INTO `ticket` (`tno`, `departure`, `destination`, `time`, `price`, `rest`, `deadline`) VALUES
('1', '福州', '晋江', '2015-12-17 00:00:00', 66, 233, '2015-12-29 00:00:00'),
('2', '福州', '石狮', '2015-12-31 00:00:00', 66, 233, '2016-01-20 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `stunum` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `dept` varchar(20) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`stunum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`stunum`, `name`, `dept`, `role`) VALUES
('031302305', '出陈铖', '数学与计算机科学学院', 0);

--
-- 限制导出的表
--

--
-- 限制表 `booked_tickets`
--
ALTER TABLE `booked_tickets`
  ADD CONSTRAINT `booked_tickets_ibfk_1` FOREIGN KEY (`stunum`) REFERENCES `user` (`stunum`),
  ADD CONSTRAINT `booked_tickets_ibfk_2` FOREIGN KEY (`tno`) REFERENCES `ticket` (`tno`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
