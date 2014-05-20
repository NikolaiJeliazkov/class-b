/*
SQLyog Community v9.33 GA
MySQL - 5.1.30-community : Database - classb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
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
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`messageFrom`) REFERENCES `users` (`userId`),
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`messageParent`) REFERENCES `messages` (`messageId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `messages` */

insert  into `messages`(`messageId`,`messageParent`,`messageStatus`,`messageDate`,`messageFrom`,`messageSubject`,`messageText`) values (1,NULL,1,'2012-03-21 13:13:12',1,'testSubject','testText'),(2,NULL,1,'2012-03-21 15:33:48',1,'alabala portokala','ново съобщение');

/*Table structure for table `messagesto` */

DROP TABLE IF EXISTS `messagesto`;

CREATE TABLE `messagesto` (
  `messageId` bigint(20) unsigned NOT NULL,
  `messageTo` bigint(20) unsigned NOT NULL,
  `messageStatus` int(10) unsigned NOT NULL,
  PRIMARY KEY (`messageId`,`messageTo`),
  KEY `messageTo` (`messageTo`),
  CONSTRAINT `messagesto_ibfk_1` FOREIGN KEY (`messageTo`) REFERENCES `users` (`userId`),
  CONSTRAINT `messagesto_ibfk_2` FOREIGN KEY (`messageId`) REFERENCES `messages` (`messageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `messagesto` */

insert  into `messagesto`(`messageId`,`messageTo`,`messageStatus`) values (1,3,0),(2,3,0);

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
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `posts` */

insert  into `posts`(`postId`,`userId`,`postStatus`,`postDate`,`postTitle`,`postAnonce`,`postText`,`postTags`,`postLastUpdate`) values (3,1,2,'2012-03-20 18:20:41','ХХ училищен конкурс \"Евтимиев ученик\" - финал','<p>\r\n	На 06.02.2012 г. от 14.30 часа в Дома на киното ще се състои финалният кръг от ХХ училищен конкурс &quot;Евтимиев ученик&quot;.</p>\r\n','<p>\r\n	На 06.02.2012 г. от 14.30 часа в Дома на киното ще се състои финалният кръг от ХХ училищен конкурс &quot;Евтимиев ученик&quot;.</p>\r\n<p>\r\n	На 06.02.2012 г. от 14.30 часа в Дома на киното ще се състои финалният кръг от ХХ училищен конкурс &quot;Евтимиев ученик&quot;.</p>\r\n<p>\r\n	На 06.02.2012 г. от 14.30 часа в Дома на киното ще се състои финалният кръг от ХХ училищен конкурс &quot;Евтимиев ученик&quot;.</p>\r\n<p>\r\n	На 06.02.2012 г. от 14.30 часа в Дома на киното ще се състои финалният кръг от ХХ училищен конкурс &quot;Евтимиев ученик&quot;.</p>\r\n','','2012-03-20 18:20:41'),(4,1,2,'2012-03-20 18:21:33','Начало на ІІ учебен срок - 07.02.2012 г.','<p>\r\n	Учениците от V, VІ и VІІ клас ще учат първа смяна, а второкласниците, третокласниците и четвъртокласниците - втора смяна.</p>\r\n<p>\r\n	Без промяна остава графикът за провеждане на учебните занятия за ПГ и І клас.</p>\r\n','<p>\r\n	Учениците от V, VІ и VІІ клас ще учат първа смяна, а второкласниците, третокласниците и четвъртокласниците - втора смяна.</p>\r\n<p>\r\n	Без промяна остава графикът за провеждане на учебните занятия за ПГ и І клас.</p>\r\n','','2012-03-20 18:21:33'),(5,1,2,'2012-03-20 18:22:54','Проект \"УСПЕХ\"','<p>\r\n	На 7 февруари 2012 г. започна работата по проект &quot;УСПЕХ&quot; в 41 ОУ, съфинансиран от ЕСФ по ОП &quot;Развитие на човешките ресурси&quot;</p>\r\n','<p align=\"justify\">\r\n	На 7 февруари 2012 г. започна работата по проект &quot;УСПЕХ&quot; в 41 ОУ, съфинансиран от ЕСФ по ОП &quot;Развитие на човешките ресурси&quot;. 106 деца са включени в 8 извънкласни форми на обучение:&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		<div align=\"justify\">\r\n			Клуб &quot;Млад природолюбител&quot; - ІІ в клас, ръководител Ваня Александрова</div>\r\n	</li>\r\n	<li>\r\n		<div align=\"justify\">\r\n			Клуб &quot;Млад природолюбител&quot; - ІІ г клас, ръководител Дима Бянова</div>\r\n	</li>\r\n	<li>\r\n		<div align=\"justify\">\r\n			Езиците на Европа - Русия и руският език, ръководител Антонина Хаджова</div>\r\n	</li>\r\n	<li>\r\n		<div align=\"justify\">\r\n			Езиците на Европа - Английският език е лесен, ръководител Анна Стаменкова</div>\r\n	</li>\r\n	<li>\r\n		<div align=\"justify\">\r\n			Театрално студио за начинаещи - ръководител Петя Букурещлиева</div>\r\n	</li>\r\n	<li>\r\n		<div align=\"justify\">\r\n			Театрално студио за напреднали - ръководители Ирена Василева</div>\r\n	</li>\r\n	<li>\r\n		<div align=\"justify\">\r\n			За правилна и чиста българска реч - ръководител Ирена Василева</div>\r\n	</li>\r\n	<li>\r\n		<div align=\"justify\">\r\n			Български фолклорни танци - ръководител Рангел Вангелов</div>\r\n	</li>\r\n</ul>\r\n','','2012-03-20 18:22:54'),(6,1,2,'2012-03-20 18:27:27','ПРИЕМ ЗА ПОДГОТВИТЕЛНИ ГРУПИ И ПЪРВИ КЛАС','<p>\r\n	<img alt=\"\" src=\"/files/.thumbs/images/S4023431.JPG\" style=\"width: 75px; height: 100px; float: left; padding:3px;\" />График на дейностите по приема на първокласници в 41 ОУ ...</p>\r\n','<ol>\r\n	<li>\r\n		График на дейностите по приема на първокласници в 41 ОУ:\r\n		<ul>\r\n			<li>\r\n				02.04 &ndash; 30.05.2012 г. &ndash; подаване на заявления по образец за постъпване в 1.клас</li>\r\n			<li>\r\n				30.05 &ndash; 15.06.2012 г. &ndash; записване на първокласниците в 41 ОУ</li>\r\n		</ul>\r\n	</li>\r\n	<li>\r\n		Необходими документи за записване на първокласници в 41 ОУ:\r\n		<ul>\r\n			<li>\r\n				оригинал на удостоверението за завършена подготвителна група</li>\r\n			<li>\r\n				копие от удостоверението за&nbsp; раждане</li>\r\n			<li>\r\n				декларация по образец за училищния учебен план за периода 1. &ndash; 4. клас и за целодневно обучение</li>\r\n		</ul>\r\n	</li>\r\n	<li>\r\n		Критерии за прием на първокласници в 41 ОУ:</li>\r\n</ol>\r\n<table border=\"1\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<p>\r\n					&nbsp;</p>\r\n			</td>\r\n			<td>\r\n				<p>\r\n					Точки</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<p>\r\n					Местоживеене в района на училището, доказано с адресна регистрация, непроменена след 01.01.2012г.</p>\r\n			</td>\r\n			<td>\r\n				<p>\r\n					2т.</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<p>\r\n					Друго дете от семейството, обучаващо се в 41 ОУ</p>\r\n			</td>\r\n			<td>\r\n				<p>\r\n					2т.</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<p>\r\n					Деца от подготвителен клас в 41 ОУ</p>\r\n			</td>\r\n			<td>\r\n				<p>\r\n					2т.</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<p>\r\n					Деца на служители в 41 ОУ</p>\r\n			</td>\r\n			<td>\r\n				<p>\r\n					2т.</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<p>\r\n					Деца на бивши възпитаници и служители на 41 ОУ</p>\r\n			</td>\r\n			<td>\r\n				<p>\r\n					1т.</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<p>\r\n					Месторабота на поне един родител в района на училището, удостоверено със служебна бележка</p>\r\n			</td>\r\n			<td>\r\n				<p>\r\n					1т.</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<p>\r\n					Деца сираци</p>\r\n			</td>\r\n			<td>\r\n				<p>\r\n					1т.</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<p>\r\n	<img alt=\"\" src=\"/files/images/S4023431.JPG\" style=\"width: 200px; height: 267px;\" /></p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	&nbsp;</p>\r\n','','2012-03-21 10:42:37');

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `students` */

insert  into `students`(`studentId`,`studentOrder`,`studentName`) values (1,1,'АЛЕКСАНДЪР КИРИЛОВ НИКОЛОВ'),(2,2,'АНАСТАСИЯ ПЕТРОВА НЕЙКОВА'),(3,3,'АННА МАРИА'),(4,4,'БОЖИДАР КИРИЛОВ АЛЕКСИЕВ'),(5,5,'БОРИСЛАВ ПЛАМЕНОВ ПЕТРОВ'),(6,6,'ВАСИЛЕНА ГЕОРГИЕВА ГОДИНЯЧКА'),(7,7,'ВИКТОРИЯ ЛЮДМИЛОВА МАРКОВА'),(8,8,'ГЕОРГИ ГЕОРГИЕВ ГАНЧЕВ'),(9,9,'ДАРА БОРИСЛАВОВА ТАНКОВА'),(10,10,'ДАРИНА ЦВЕТАНОВА БОНЧЕВА'),(11,11,'ДИМИТЪР ДИМИТРОВ ТОШКОВ'),(12,12,'ЕЛЕНА НИКОЛАЕВА ЖЕЛЯЗКОВА'),(13,13,'ИВАН АНДРЕЕВ КАСАБОВ'),(14,14,'ИСИДОР ИЛИЯНОВ ХЛЕБАРОВ'),(15,15,'КОНСТАНТИН НИКОЛОВ ЦВЕТКОВ'),(16,16,'ЛИДИЯ КЛИМЕНТОВА КЛИМЕНТОВА'),(17,17,'НИКОЛ НИКОЛАЕВА ИЛИЕВА'),(18,18,'НИКОЛА ДЕЯНОВ СИМОНОВИЧ'),(19,19,'НИКОЛА РАДОСЛАВОВ РАЙКОВ'),(20,20,'СВЕТЛИН ИВАНОВ ГЕНОВ'),(21,21,'ЮЛИАН САШКОВ МЕТОДИЕВ'),(22,22,'КАМЕН ПЕТКОВ СТАМЕНОВ');

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `frequency` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `students` (`studentId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`userId`,`userStatus`,`userType`,`userName`,`userPass`,`studentId`,`userEmail`,`userPhones`,`userIsVisible`,`notes`,`userFullName`) values (1,1,100,'root','d8578edf8458ce06fbc5bb76a58c5ca4',NULL,'njeliazkov@gmail.com','',0,'','Superuser'),(2,1,3,'bozhilova','e10adc3949ba59abbe56e057f20f883e',NULL,'hr_bozhilova@abv.bg','',0,'','Христина Божилова'),(3,1,1,'njeliazkov','d8578edf8458ce06fbc5bb76a58c5ca4',12,'njeliazkov@bobs.bg','',1,'','Николай Желязков');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
