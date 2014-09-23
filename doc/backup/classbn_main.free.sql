/*
SQLyog Community v12.01 (64 bit)
MySQL - 5.5.34 : Database - classbn_main
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`classbn_main` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `classbn_main`;

/*Table structure for table `gal` */

DROP TABLE IF EXISTS `gal`;

CREATE TABLE `gal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `tr_title` varchar(128) DEFAULT NULL,
  `g_desc` varchar(512) DEFAULT NULL,
  `tr_desc` varchar(512) DEFAULT NULL,
  `order` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Galleries';

/*Data for the table `gal` */

/*Table structure for table `images` */

DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
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
  KEY `gal_FK` (`gid`),
  CONSTRAINT `gal_FK` FOREIGN KEY (`gid`) REFERENCES `gal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `images` */

/*Table structure for table `messages` */

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `messageId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `messageParent` bigint(20) unsigned DEFAULT NULL,
  `messageStatus` int(10) unsigned NOT NULL,
  `messageDate` datetime NOT NULL,
  `messageFrom` bigint(20) unsigned NOT NULL,
  `messageSubject` text,
  `messageText` text,
  PRIMARY KEY (`messageId`),
  KEY `messageFrom` (`messageFrom`),
  KEY `messageParent` (`messageParent`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`messageFrom`) REFERENCES `users` (`userId`) ON DELETE CASCADE,
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`messageParent`) REFERENCES `messages` (`messageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `messages` */

/*Table structure for table `messagesto` */

DROP TABLE IF EXISTS `messagesto`;

CREATE TABLE `messagesto` (
  `messageId` bigint(20) unsigned NOT NULL,
  `messageTo` bigint(20) unsigned NOT NULL,
  `messageStatus` int(10) unsigned NOT NULL,
  PRIMARY KEY (`messageId`,`messageTo`),
  KEY `messageTo` (`messageTo`),
  CONSTRAINT `messagesto_ibfk_1` FOREIGN KEY (`messageTo`) REFERENCES `users` (`userId`) ON DELETE CASCADE,
  CONSTRAINT `messagesto_ibfk_2` FOREIGN KEY (`messageId`) REFERENCES `messages` (`messageId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `messagesto` */

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `pageId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pageParent` bigint(20) unsigned DEFAULT NULL,
  `pageStatus` int(10) unsigned NOT NULL DEFAULT '0',
  `pageTitile` text NOT NULL,
  `pageDesc` text,
  `pageText` text,
  `pageTags` text,
  PRIMARY KEY (`pageId`),
  KEY `pageParent` (`pageParent`),
  CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`pageParent`) REFERENCES `pages` (`pageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pages` */

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `postId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) unsigned NOT NULL,
  `postStatus` int(10) unsigned NOT NULL DEFAULT '0',
  `postDate` datetime NOT NULL,
  `postTitle` text NOT NULL,
  `postAnonce` text,
  `postText` text,
  `postTags` text,
  `postLastUpdate` datetime DEFAULT NULL,
  PRIMARY KEY (`postId`),
  KEY `userId` (`userId`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `posts` */

insert  into `posts`(`postId`,`userId`,`postStatus`,`postDate`,`postTitle`,`postAnonce`,`postText`,`postTags`,`postLastUpdate`) values (7,2,2,'2012-04-02 18:34:12','Започваме','<p>\r\n	Този сайт е създаден за учениците от 2 Б клас.</p>\r\n<p>\r\n	В сайта ще се постараем да предоставим на децата интересни факти и материали, за да продължат да задават вълнуващи въпроси като:</p>\r\n<p>\r\n	&quot;Защо минералите могат да растат? Нали те са нежива природа.&quot;</p>\r\n<p>\r\n	Те заслужават да бъдат поощрени за своето трудолюбие, упоритост и любознателност.</p>\r\n','<p>\r\n	Този сайт е създаден за учениците от 2 Б клас.</p>\r\n<p>\r\n	В сайта ще се постараем да предоставим на децата интересни факти и материали, за да продължат да задават вълнуващи въпроси като:</p>\r\n<p>\r\n	&quot;Защо минералите могат да растат? Нали те са нежива природа.&quot;</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Те заслужават да бъдат поощрени за своето трудолюбие, упоритост и любознателност.</p>\r\n','','2012-04-02 22:54:46');

/*Table structure for table `schedules` */

DROP TABLE IF EXISTS `schedules`;

CREATE TABLE `schedules` (
  `scheduleid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `weekday` smallint(5) unsigned NOT NULL,
  `starttime` varchar(5) DEFAULT NULL,
  `stoptime` varchar(5) DEFAULT NULL,
  `courseName` varchar(255) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`scheduleid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `schedules` */

/*Table structure for table `students` */

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
  `studentId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `studentOrder` int(10) unsigned NOT NULL,
  `studentName` text NOT NULL,
  PRIMARY KEY (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `students` */

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `frequency` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tags` */

/*Table structure for table `tbl_lookup` */

DROP TABLE IF EXISTS `tbl_lookup`;

CREATE TABLE `tbl_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `type` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_lookup` */

insert  into `tbl_lookup`(`id`,`name`,`code`,`type`,`position`) values (1,'Чернова',1,'PostStatus',1),(2,'Публикувано',2,'PostStatus',2),(3,'Archived',3,'PostStatus',3),(6,'Ново',0,'messageStatus',0),(7,'Получено',1,'messageStatus',1),(8,'Изтрито',2,'messageStatus',2);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userStatus` int(10) unsigned NOT NULL DEFAULT '1',
  `userType` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  `studentId` int(10) unsigned DEFAULT NULL,
  `userEmail` text,
  `userPhones` text,
  `userIsVisible` int(1) DEFAULT '0',
  `notes` text,
  `userFullName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `AK_Users` (`userName`),
  KEY `studentId` (`studentId`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `students` (`studentId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`userId`,`userStatus`,`userType`,`userName`,`userPass`,`studentId`,`userEmail`,`userPhones`,`userIsVisible`,`notes`,`userFullName`) values (1,1,100,'root','d8578edf8458ce06fbc5bb76a58c5ca4',NULL,'njeliazkov@gmail.com','',0,'',''),(2,1,3,'bozhilova','e10adc3949ba59abbe56e057f20f883e',NULL,'hr_bozhilova@abv.bg','',1,'','Христина Божилова');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
