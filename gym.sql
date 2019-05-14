-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2019-05-14 07:15:31
-- 服务器版本： 5.7.24
-- PHP 版本： 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `gym`
--

-- --------------------------------------------------------

--
-- 表的结构 `gym_cate`
--

DROP TABLE IF EXISTS `gym_cate`;
CREATE TABLE IF NOT EXISTS `gym_cate` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(30) NOT NULL,
  `cate_desc` varchar(50) NOT NULL,
  `pid` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gym_cate`
--

INSERT INTO `gym_cate` (`id`, `cate_name`, `cate_desc`, `pid`) VALUES
(1, '有氧', '有氧锻炼', 0),
(11, '营养', '', 0),
(3, '跑步', '', 1),
(4, '无氧', '', 0),
(5, '器械', '', 4),
(12, '康复', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `gym_coach`
--

DROP TABLE IF EXISTS `gym_coach`;
CREATE TABLE IF NOT EXISTS `gym_coach` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `co_num` varchar(20) NOT NULL,
  `co_name` varchar(20) NOT NULL,
  `co_sex` varchar(10) NOT NULL,
  `co_id` varchar(50) NOT NULL,
  `co_phone` varchar(30) NOT NULL,
  `co_address` text NOT NULL,
  `co_pic` varchar(50) DEFAULT NULL,
  `addtime` int(50) NOT NULL,
  `co_course` varchar(60) DEFAULT NULL,
  `co_qualify` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gym_coach`
--

INSERT INTO `gym_coach` (`id`, `co_num`, `co_name`, `co_sex`, `co_id`, `co_phone`, `co_address`, `co_pic`, `addtime`, `co_course`, `co_qualify`) VALUES
(1, 'C1557568535', '113', '女', 'ewqe', '123456', 'ewq2', '20190514\\ebab5e8094c8b2f09688710fa5e9c6da.png', 1557568535, '减脂', 1),
(4, 'C1557796919', '李志展', '男', '123', '321', '123123', '20190514\\3b2f4816765b5c7fcde3c39ab0b257f1.png', 1557796919, '无氧教练', 2);

-- --------------------------------------------------------

--
-- 表的结构 `gym_course`
--

DROP TABLE IF EXISTS `gym_course`;
CREATE TABLE IF NOT EXISTS `gym_course` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `kc_num` varchar(20) NOT NULL,
  `kc_title` varchar(20) NOT NULL,
  `cateId` int(20) NOT NULL DEFAULT '0',
  `kc_level` varchar(10) NOT NULL,
  `kc_type` int(5) NOT NULL,
  `kc_content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gym_course`
--

INSERT INTO `gym_course` (`id`, `kc_num`, `kc_title`, `cateId`, `kc_level`, `kc_type`, `kc_content`) VALUES
(5, 'K1557801793', '1233', 12, '3', 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `gym_member`
--

DROP TABLE IF EXISTS `gym_member`;
CREATE TABLE IF NOT EXISTS `gym_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mem_num` varchar(20) NOT NULL,
  `mem_name` varchar(50) NOT NULL,
  `mem_sex` varchar(10) NOT NULL,
  `mem_id` varchar(50) NOT NULL,
  `mem_pic` varchar(50) DEFAULT NULL,
  `mem_address` varchar(60) DEFAULT NULL,
  `mem_phone` varchar(20) NOT NULL,
  `mem_type` varchar(20) DEFAULT NULL,
  `addtime` int(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mem_num` (`mem_num`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gym_member`
--

INSERT INTO `gym_member` (`id`, `mem_num`, `mem_name`, `mem_sex`, `mem_id`, `mem_pic`, `mem_address`, `mem_phone`, `mem_type`, `addtime`) VALUES
(3, 'Y0001', '乔琳', '男', '370703199706240834', '20190507\\57b46106a092aa210fe162e580dfb2b6.jpg', '大师第撒大多撒大', '13722187899', '普通用户', 1557219617),
(6, 'Y002', '321', '男', '', '', '', '', '次卡用户', 1557229169),
(5, 'Y003', '123', '男', '', '', '', '', '次卡用户', 1557229162),
(7, 'Y004', '111', '男', '', '', '', '', '次卡用户', 1557229175),
(8, 'Y1557566621', '12', '男', '', '20190511\\e7cac86cab35ff20111466b42319ccfb.png', '', '123123123123', '普通用户', 1557566621),
(9, 'Y1557566764', '123321', '男', '', NULL, '', '', '次卡用户', 1557566764);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
