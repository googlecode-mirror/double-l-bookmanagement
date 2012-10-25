-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2012 年 10 月 25 日 07:30
-- 伺服器版本: 5.5.16
-- PHP 版本: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `books`
--
CREATE DATABASE IF NOT EXISTS  `books` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `books`;

-- --------------------------------------------------------

--
-- 表的結構 `book_catagorys`
--

DROP TABLE IF EXISTS `book_catagorys`;
CREATE TABLE IF NOT EXISTS `book_catagorys` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分類號',
  `catagory_name` varchar(20) NOT NULL COMMENT '分類名稱',
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='書籍分類資料' AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- 表的結構 `person_groups`
--

DROP TABLE IF EXISTS `person_groups`;
CREATE TABLE IF NOT EXISTS `person_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分類號',
  `group_name` varchar(20) NOT NULL COMMENT '群組名稱',
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='借閱者群組資料' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的結構 `person_levels`
--

DROP TABLE IF EXISTS `person_levels`;
CREATE TABLE IF NOT EXISTS `person_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分類號',
  `level_name` varchar(20) NOT NULL COMMENT '等級權限名稱',
  `max_day` int(11) NOT NULL DEFAULT '0' COMMENT '借閱天數',
  `max_book` int(11) NOT NULL DEFAULT '0' COMMENT '借閱書籍',
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='借閱者等級權限' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的結構 `person_titles`
--

DROP TABLE IF EXISTS `person_titles`;
CREATE TABLE IF NOT EXISTS `person_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '職務代碼',
  `title_name` varchar(20) NOT NULL COMMENT '職務名稱',
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='人員職務名稱' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的結構 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
