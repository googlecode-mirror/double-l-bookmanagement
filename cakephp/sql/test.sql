-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 建立日期: Dec 02, 2012, 06:24 上午
-- 伺服器版本: 5.1.44
-- PHP 版本: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: 'books'
--

--
-- 列出以下資料庫的數據： 'book_catagorys'
--

INSERT INTO book_catagorys (id, catagory_name, valid, create_time) VALUES
('100', 'å¤§çœ¾é¡ž', 1, '2012-11-12 22:53:48'),
('200', 'é›œèªŒ(é›»è…¦)', 1, '2012-11-18 23:04:38');

--
-- 列出以下資料庫的數據： 'person_groups'
--

INSERT INTO person_groups (id, group_name, valid, create_time) VALUES
(1, 'å­¸ç”Ÿ', 1, '2012-11-19 22:45:12'),
(2, 'è€å¸«', 1, '2012-11-19 22:45:19');

--
-- 列出以下資料庫的數據： 'person_levels'
--

INSERT INTO person_levels (id, level_name, max_day, max_book, valid, create_time) VALUES
(1, 'é•·å®˜', 7, 7, 1, '2012-11-15 22:28:10'),
(2, 'å­¸ç”Ÿ', 5, 5, 1, '2012-11-18 22:54:21'),
(3, 'å®¶é•·', 3, 3, 1, '2012-11-28 22:00:52');

--
-- 列出以下資料庫的數據： 'person_titles'
--

INSERT INTO person_titles (id, title_name, valid, create_time) VALUES
(1, 'è€å¸«', 1, '2012-11-28 22:00:15'),
(2, 'å­¸ç”Ÿ', 1, '2012-11-28 22:00:21');

--
-- 列出以下資料庫的數據： 'system_incs'
--

INSERT INTO system_incs (id, format, count, create_time, modi_time) VALUES
('BOOK_B', 'B%1$07d', 0, '2012-11-19 22:49:35', '2012-11-28 23:50:06'),
('BOOK_M', 'M%1$07d', 0, '2012-11-19 22:50:03', '2012-11-21 00:01:28');

--
-- 列出以下資料庫的數據： 'system_locations'
--

INSERT INTO system_locations (id, location_name, create_time, modi_time, valid) VALUES
('A', 'ç¸½éƒ¨', '0000-00-00 00:00:00', '2012-11-28 22:21:00', 1),
('B', 'å¤©æ¯åˆ†æ ¡', '0000-00-00 00:00:00', '2012-11-28 22:21:12', 1);
