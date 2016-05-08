-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 05 月 08 日 13:55
-- 服务器版本: 5.5.47
-- PHP 版本: 5.5.32-1+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- 数据库: `isee_crm`
--

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `position` tinyint(4) NOT NULL DEFAULT '0',
  `order` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- 表的结构 `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(16) NOT NULL,
  `title` varchar(64) NOT NULL,
  `title_color` varchar(7) NOT NULL,
  `subtitle` varchar(64) NOT NULL,
  `pub_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(10) unsigned NOT NULL,
  `article_text` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `is_hidden` tinyint(1) NOT NULL,
  `is_top` tinyint(1) NOT NULL,
  `read_count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `author_2` (`author`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(64) CHARACTER SET utf8 NOT NULL,
  `passhash` varchar(32) CHARACTER SET utf8 NOT NULL,
  `passsalt` varchar(32) CHARACTER SET utf8 NOT NULL,
  `nickname` varchar(32) NOT NULL,
  `privilege` tinyint(1) NOT NULL COMMENT '0:标准,1:可发布,2:可维护',
  `status` tinyint(1) NOT NULL,
  `post_available` varchar(16) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`),
  KEY `id_3` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='用户表' AUTO_INCREMENT=3 ;

--
-- 限制导出的表
--

--
-- 限制表 `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`author`) REFERENCES `user` (`id`);
