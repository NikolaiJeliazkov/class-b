/*
SQLyog Community v12.01 (64 bit)
MySQL - 5.5.36-cll : Database - classbn_main
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`classbn_main` /*!40100 DEFAULT CHARACTER SET latin1 */;

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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='Galleries';

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
) ENGINE=InnoDB AUTO_INCREMENT=441 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=366 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

/*Data for the table `posts` */

insert  into `posts`(`postId`,`userId`,`postStatus`,`postDate`,`postTitle`,`postAnonce`,`postText`,`postTags`,`postLastUpdate`) values (70,2,2,'2014-09-21 17:41:14','ПЪРВИЯТ УЧЕБЕН ДЕН','<p>\r\n	&nbsp;Учениците от 1. Б клас прекрачиха прага на училището изпълнени с много&nbsp; вълнение и добро настроение .</p>\r\n','<p>\r\n	&nbsp;&nbsp; На 15.09. 2014 год. учениците от 1. Б клас прекрачиха прага на 41 ОУ с много &nbsp;вълнение и добро настроение .Те отвориха нова страница в своя живот &ndash; вече са ученици . Децата изпитаха голяма радост от срещата със своите нови другари . Всеки се представи като каза стихотворение, &nbsp;разказа за изминалото весело лято или за домашните си любимци . За благополучие и здраве учениците похапнаха вкусна пита с мед , които родителите бяха донесли . Видяхме в очите им голямо желание да бъдат ученици, защото освен отговорности в училище има и много радост, смях и игри с новите приятели .</p>\r\n<p>\r\n	&nbsp; &nbsp;Пожелаваме им здраве, успех и усмивки през цялата година !</p>\r\n','събития','2014-09-22 10:05:04');

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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

/*Data for the table `students` */

insert  into `students`(`studentId`,`studentOrder`,`studentName`) values (29,1,'Александър  Венелинов  Кръстев'),(30,2,'Божидар Георгиев Георгиев'),(31,3,'Василена Георгиева Чакърова'),(32,4,'Виктор Николай Димитров'),(33,5,'Виктория Константинова Чернова'),(34,6,'Георги Стоилов Огнянов'),(35,7,'Ива Димитрова Кехайова'),(36,8,'Иван Константинов Чернов'),(37,9,'Йоан Асен Александров Събев'),(38,10,'Йордан Илков Кръстителски'),(39,11,'Калоян Каменов Попов'),(40,12,'Ливия Станиславова Борисова'),(41,13,'Мария Димитрова Лозанова'),(42,14,'Мирела Георгиева Чакърова'),(43,15,'Михаил Николаев Желязков'),(44,16,'Никола Николаев Николов'),(45,17,'Никола Петков Баръмов'),(46,18,'Николай Илиянов Белперчинов'),(47,19,'Николета Христова Христова'),(48,20,'Яна Яворова Димитрова');

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `frequency` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tags` */

insert  into `tags`(`id`,`name`,`frequency`) values (15,'събития',1);

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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`userId`,`userStatus`,`userType`,`userName`,`userPass`,`studentId`,`userEmail`,`userPhones`,`userIsVisible`,`notes`,`userFullName`) values (1,1,100,'root','28481abe20b2405738104a5350204987',NULL,'njeliazkov@gmail.com','',0,'адмистраторски акаунт',NULL),(2,1,3,'bozhilova','e10adc3949ba59abbe56e057f20f883e',NULL,'hr_bozhilova@abv.bg','',1,'','Христина Божилова'),(36,1,1,'Krusteva','827ccb0eea8a706c4c34a16891f84e7b',29,'Roumiana.Krusteva@gmail.com','0885984207',1,'','Румяна Кръстева'),(37,1,1,'Georgieva','827ccb0eea8a706c4c34a16891f84e7b',30,'dorisdm@abv.bg','0885151530',1,'','Теодора Георгиева'),(38,1,1,'Chakarova','827ccb0eea8a706c4c34a16891f84e7b',31,'yoli69@abv.bg','0878496048',1,'','Йоана Чакърова'),(39,1,1,'Dimitrova','827ccb0eea8a706c4c34a16891f84e7b',32,'lidia.p.filipova@abv.bg','0887654960',1,'','Лидия Димитрова'),(40,1,1,'Chernova','827ccb0eea8a706c4c34a16891f84e7b',33,'dimada@abv.bg','0899871775',1,'','Адриана Чернова'),(41,1,1,'Ognianov','827ccb0eea8a706c4c34a16891f84e7b',34,'sognianov@yahoo.com','0885841250',1,'','Стоил Огнянов'),(42,1,1,'Kehajova','827ccb0eea8a706c4c34a16891f84e7b',35,'n_georgieva7@yahoo.com','0896707675',1,'','Надежда Кехайова'),(43,1,1,'Sabeva','827ccb0eea8a706c4c34a16891f84e7b',37,'dentarai@abv.bg','0888811729',1,'','Йоана Събева'),(44,1,1,'Krastitelska','827ccb0eea8a706c4c34a16891f84e7b',38,'anely_cvetanova@abv.bg','0897915349',1,'','Анелия Кръстителска'),(45,1,1,'Popov','827ccb0eea8a706c4c34a16891f84e7b',39,'mr.green@mail.bg','0888601337',1,'','Камен Попов'),(46,1,1,'Alexieva','827ccb0eea8a706c4c34a16891f84e7b',39,'elena.alexy@gmail.com','0888585888',1,'','Елена Алексиева'),(47,1,1,'Borisov','827ccb0eea8a706c4c34a16891f84e7b',40,'stanislav.borisov@gmail.com','0886233245',1,'','Станислав Борисов'),(48,1,1,'Lozanova','827ccb0eea8a706c4c34a16891f84e7b',41,'t.loz@abv.bg','0887306203',1,'','Таня Лозанова'),(49,1,1,'Zheliazkova','827ccb0eea8a706c4c34a16891f84e7b',43,'nikoletag@gmail.com','0898710665',1,'','Николета Желязкова'),(50,1,1,'Nikolova','827ccb0eea8a706c4c34a16891f84e7b',44,'polinazaharieva@abv.bg','0896616552',1,'','Полина Николова'),(51,1,1,'Baramov','827ccb0eea8a706c4c34a16891f84e7b',45,'zekman@mail.bg','0896887050',1,'','Петко Баръмов'),(52,1,1,'Belperchinova','587189e66a08eff85bc3e6dd0f0068fd',46,'toni_vassileva@abv.bg','0897849038',1,'','Антоанета Белперчинова'),(53,1,1,'Radionova','827ccb0eea8a706c4c34a16891f84e7b',47,'philippa.radionova@gmail.com','0889500110',1,'','Филипа Радионова'),(54,1,1,'Dimitrov','827ccb0eea8a706c4c34a16891f84e7b',48,'javord@abv.bg','0877512111',1,'','Явор Димитров'),(55,1,1,'Krastitelski','827ccb0eea8a706c4c34a16891f84e7b',38,'ilkokrastitelski@abv.bg','',0,'','Илко Кръстителски');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
