-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2012 年 10 月 22 日 03:35
-- 伺服器版本: 5.5.16
-- PHP 版本: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `cakeblogtutorial`
--
DROP DATABASE `cakeblogtutorial`;
CREATE DATABASE `cakeblogtutorial` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `cakeblogtutorial`;

-- --------------------------------------------------------

--
-- 表的結構 `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `created`, `modified`, `user_id`) VALUES
(1, 'The title', 'This is the post body.', '2012-10-15 16:21:36', NULL, NULL),
(2, 'A title once again', 'And the post body follows.', '2012-10-15 16:21:36', NULL, NULL),
(3, 'Title strikes back', 'This is really exciting! Not.', '2012-10-15 16:21:36', NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- 轉存資料表中的資料 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created`, `modified`) VALUES
(1, 'admin', 'b54025851dd54398f9c83ae6b3a0a376e0b28095', 'admin', '2012-10-15 11:47:08', '2012-10-15 11:47:08'),
(2, 'admin', 'e6986a70e65749b7a9432aa28934ba26a74599f4', 'admin', '2012-10-16 08:10:44', '2012-10-16 08:10:44'),
(3, 'test1', 'e6986a70e65749b7a9432aa28934ba26a74599f4', 'author', '2012-10-16 08:16:27', '2012-10-16 08:16:27'),
(4, 'test1', 'e6986a70e65749b7a9432aa28934ba26a74599f4', 'author', '2012-10-16 08:17:23', '2012-10-16 08:17:23');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
