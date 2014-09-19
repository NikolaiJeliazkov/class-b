-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2011 at 12:39 AM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- --------------------------------------------------------

--
-- Table structure for table `gal`
--

CREATE TABLE IF NOT EXISTS `gal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `tr_title` varchar(128) DEFAULT NULL,
  `g_desc` varchar(512) DEFAULT NULL,
  `tr_desc` varchar(512) DEFAULT NULL,
  `order` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Galleries' AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` varchar(80) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `basename` varchar(45) DEFAULT NULL,
  `extension` varchar(6) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `tr_title` varchar(256) DEFAULT NULL,
  `desc` varchar(512) DEFAULT NULL,
  `tr_desc` varchar(512) DEFAULT NULL,
  `size` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `path` varchar(256) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gal_FK` (`gid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `gal_FK` FOREIGN KEY (`gid`) REFERENCES `gal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
