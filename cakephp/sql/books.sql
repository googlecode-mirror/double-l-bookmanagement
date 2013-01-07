-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2012 年 11 月 30 日 05:04
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
-- CREATE DATABASE `books` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
-- USE `books`;
USE `library`;

-- --------------------------------------------------------

--
-- 表的結構 `book_catagorys`
--

DROP TABLE IF EXISTS `book_catagorys`;
CREATE TABLE IF NOT EXISTS `book_catagorys` (
  `id` varchar(10) NOT NULL COMMENT '分類號',
  `catagory_name` varchar(20) NOT NULL COMMENT '分類名稱',
  `catagory_color` varchar(10) NOT NULL COMMENT '分類顏色',
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='書籍分類資料';

-- --------------------------------------------------------

--
-- 表的結構 `book_instances`
--

DROP TABLE IF EXISTS `book_instances`;
CREATE TABLE IF NOT EXISTS `book_instances` (
  `id` varchar(20) NOT NULL,
  `book_id` int(11) NOT NULL,
  `book_version` varchar(10) DEFAULT NULL,
  `purchase_price` int(11) DEFAULT NULL,
  `book_status` varchar(10) NOT NULL COMMENT '書籍狀態(0=>購買中,1=>在庫,2=>借出,3=>已歸還,4=>整理中,5=>運送中, 6=>預約中))',
  `level_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `is_lend` varchar(10) NOT NULL,
  `s_return_date` datetime DEFAULT NULL COMMENT '預計歸還時間',
  `reserve_person_id` varchar(20) DEFAULT NULL COMMENT '預約人代號',
  `location_id` varchar(3) DEFAULT NULL COMMENT '地點代號',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登記日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='書籍實體資料';

-- --------------------------------------------------------

--
-- 表的結構 `book_publishers`
--

DROP TABLE IF EXISTS `book_publishers`;
CREATE TABLE IF NOT EXISTS `book_publishers` (
  `id` varchar(15) NOT NULL COMMENT '公司編號',
  `comp_name` varchar(50) NOT NULL COMMENT '公司名稱',
  `address` varchar(200) NOT NULL COMMENT '地址',
  `phone` varchar(30) NOT NULL COMMENT '電話',
  `fax` varchar(30) NOT NULL COMMENT '傳真',
  `sales` varchar(20) NOT NULL COMMENT '業務姓名',
  `mobile_phone` varchar(30) NOT NULL COMMENT '行動電話',
  `memo` varchar(255) NOT NULL COMMENT '備註',
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='出版公司資料';

-- --------------------------------------------------------

--
-- 表的結構 `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '書籍編號',
  `book_type` varchar(5) NOT NULL COMMENT '書籍類型 (B:書, M:期刊)',
  `book_name` varchar(200) NOT NULL COMMENT 'B:書籍名稱, M:期刊名稱',
  `book_title` varchar(500) NOT NULL COMMENT 'B:書籍副標題, M:期刊名稱',
  `book_author` varchar(100) NOT NULL COMMENT 'B:作者 M:',
  `book_publisher` varchar(100) NOT NULL COMMENT '出版商',
  `cate_id` varchar(10) NOT NULL COMMENT '書籍分類',
  `isbn` varchar(20) NOT NULL COMMENT 'B:ISBN, M:ISSN',
  `book_version` varchar(20) NOT NULL COMMENT 'B:版別, M:刊期',
  `book_suite` varchar(10) NOT NULL COMMENT 'B:集叢書, M:刊期',
  `book_search_code` varchar(100) NOT NULL COMMENT 'B:索書號 M:',
  `book_location` varchar(100) NOT NULL COMMENT 'B:櫃別 M:',
  `book_attachment` varchar(100) NOT NULL COMMENT 'B:附屬媒體',
  `book_image` varchar(500) NOT NULL DEFAULT 'book_empty.png' COMMENT '書籍圖片',
  `publish_date` date NOT NULL COMMENT 'B:出版日期, M:創刊日',
  `order_start_date` date NOT NULL COMMENT 'B: M:訂購開始日期',
  `order_end_date` date NOT NULL COMMENT 'B: M:訂購結束日期',
  `order_start_version` int(11) NOT NULL COMMENT 'B: M:訂購開始期數',
  `order_end_version` int(11) NOT NULL COMMENT 'B: M:訂購結束期數',
  `memo` text NOT NULL COMMENT '備註',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '登記日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='書籍資料';

-- --------------------------------------------------------

--
-- 表的結構 `lend_records`
--

DROP TABLE IF EXISTS `lend_records`;
CREATE TABLE IF NOT EXISTS `lend_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `record_type` int(11) NOT NULL DEFAULT '0' COMMENT '種類(0:借閱, 1:預約)',
  `book_id` int(11) NOT NULL COMMENT '書籍',
  `book_instance_id` varchar(20) NOT NULL COMMENT '書本UID',
  `person_id` varchar(20) NOT NULL COMMENT '出借人',
  `status` char(1) NOT NULL COMMENT '狀態 (C:出借中, R:歸還, D:遺失, R:預約, D:取消, E:延長)',
  `reserve_time` datetime DEFAULT NULL COMMENT '預借日期',
  `lend_time` datetime NOT NULL COMMENT '出借日期',
  `s_return_date` date NOT NULL COMMENT '應歸還時間',
  `return_time` datetime DEFAULT NULL COMMENT '歸還日期',
  `lend_cnt` int(11) NOT NULL DEFAULT '0' COMMENT '續借次數',
  `location_id` varchar(3) DEFAULT NULL COMMENT '地點代號',
  `create_time` datetime NOT NULL COMMENT '建立日期',
  `modi_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '變更日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='書籍操作紀錄檔';

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='人員群組資料';

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='人員等級權限';

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='人員職務名稱';

-- --------------------------------------------------------

--
-- 表的結構 `persons`
--

DROP TABLE IF EXISTS `persons`;
CREATE TABLE IF NOT EXISTS `persons` (
  `id` varchar(20) NOT NULL COMMENT '卡號',
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `ename` varchar(30) DEFAULT NULL COMMENT '英文姓名',
  `gender` int(11) DEFAULT 1 COMMENT '性別',
  `social_id` varchar(15) DEFAULT NULL COMMENT '身份證',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `title_id` int(11) NOT NULL COMMENT '職稱',
  `group_id` int(11) NOT NULL COMMENT '群組',
  `location_id` varchar(3) NOT NULL COMMENT '地點代號',
  `phone` varchar(20) DEFAULT NULL COMMENT '聯絡電話',
  `home_phone` varchar(20) DEFAULT NULL COMMENT '住家電話',
  `mobile_phone` varchar(20) DEFAULT NULL COMMENT '行動電話',
  `fax` varchar(20) DEFAULT NULL COMMENT '傳真電話',
  `email` varchar(100) DEFAULT NULL COMMENT '電子郵件',
  `address` varchar(255) DEFAULT NULL COMMENT '通訊地址',
  `memo` varchar(255) DEFAULT NULL COMMENT '備註',
  `level_id` int(11) NOT NULL COMMENT '借閱等級',
  `password` varchar(100) NOT NULL COMMENT '查詢密碼',
  `role` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'user',
  `create_time` datetime NOT NULL COMMENT '建立日期',
  `card_create_date` date DEFAULT NULL COMMENT '發卡日期',
  `card_return_date` date DEFAULT NULL COMMENT '退卡日期',
  `card_create_count` int(11) DEFAULT NULL COMMENT '補卡次數',
  `card_reissue_date` date DEFAULT NULL COMMENT '補卡日期',
  `valid` tinyint(1) NOT NULL DEFAULT '1' COMMENT '生效',
  `modi_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改日期',
  PRIMARY KEY (`id`),
  UNIQUE KEY `social_id` (`social_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='借閱者資本資料';

-- --------------------------------------------------------

--
-- 表的結構 `system_incs`
--

DROP TABLE IF EXISTS `system_incs`;
CREATE TABLE IF NOT EXISTS `system_incs` (
  `id` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL COMMENT '流水號模式',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '最後一次值',
  `create_time` datetime NOT NULL COMMENT '建立日期',
  `modi_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系統編碼頁';

-- --------------------------------------------------------

--
-- 表的結構 `system_locations`
--

DROP TABLE IF EXISTS `system_locations`;
CREATE TABLE IF NOT EXISTS `system_locations` (
  `id` varchar(3) NOT NULL COMMENT '地點代號',
  `location_name` varchar(30) NOT NULL COMMENT '地點名稱',
  `create_time` datetime NOT NULL,
  `modi_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `location_name` (`location_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表格式： `system_prints`
--
DROP TABLE IF EXISTS `system_prints`;
CREATE TABLE IF NOT EXISTS `system_prints` (
  `id` varchar(50) NOT NULL,
  `print_type` varchar(1) NOT NULL COMMENT '分類(B:書籍, P:人員)',
  `print_owner` varchar(20) NOT NULL COMMENT '人員代碼',
  `print_id` varchar(20) NOT NULL COMMENT '列印Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` varchar(3) COLLATE utf8_unicode_ci NOT NULL COMMENT '地點代號',
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的結構 `book_status`
--

DROP TABLE IF EXISTS `book_status`;
CREATE TABLE IF NOT EXISTS `book_status` (
  `id` int(11) NOT NULL,
  `status_nme` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `lend_status`
--

DROP TABLE IF EXISTS `lend_status`;
CREATE TABLE IF NOT EXISTS `lend_status` (
  `id` char(1) NOT NULL,
  `lend_status_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
