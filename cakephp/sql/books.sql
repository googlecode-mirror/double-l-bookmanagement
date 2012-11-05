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

-- --------------------------------------------------------

--
-- 表的結構 `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '書籍編號',
  `version_id` int(11) NOT NULL COMMENT '書籍版別資料編號',
  `purchase_price` int(11) NOT NULL COMMENT '購買金額',
  `book_status` int(11) NOT NULL COMMENT '狀態',
  `person_level` int(11) NOT NULL COMMENT '借閱等級',
  `purchase_date` date NOT NULL COMMENT '購入日期',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '登記日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='書籍資料資料' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `book_basics`
--

CREATE TABLE IF NOT EXISTS `book_basics` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '書籍基本資料編號',
  `book_name` varchar(100) NOT NULL COMMENT '書籍名稱',
  `book_author` varchar(50) NOT NULL COMMENT '作者',
  `book_publisher` varchar(50) NOT NULL COMMENT '出版商',
  `book_catagory` int(11) NOT NULL COMMENT '書籍分類',
  `publish_date` date NOT NULL COMMENT '出版日期',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登記日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='書籍基本資料' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `book_versions`
--

CREATE TABLE IF NOT EXISTS `book_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '書籍版別資料編號',
  `basic_id` int(11) NOT NULL COMMENT '書籍基本資料編號',
  `isbn` varchar(13) NOT NULL COMMENT '(根據定義有時版別不同會有不同ISBN)',
  `book_version` varchar(10) NOT NULL COMMENT '版別',
  `book_search_code` varchar(20) NOT NULL COMMENT '索書號',
  `book_location` varchar(20) NOT NULL COMMENT '櫃別',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登記日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='書籍版別資料' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
