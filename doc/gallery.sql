/*
SQLyog Enterprise - MySQL GUI v6.15
MySQL - 5.1.30-community : Database - classbn_main
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='Galleries';

/*Data for the table `gal` */

insert  into `gal`(`id`,`title`,`tr_title`,`g_desc`,`tr_desc`,`order`) values (27,'2010 Първи учебен ден',NULL,'',NULL,'a:9:{s:29:\"p178gnclet1vo8u3t1n4f176782u1\";s:29:\"p178gnclet1vo8u3t1n4f176782u1\";s:29:\"p178gnd5a5efj11mc1183td710nt2\";s:29:\"p178gnd5a5efj11mc1183td710nt2\";s:27:\"p178gndaq7kqvd6u3o16np1veu3\";s:27:\"p178gndaq7kqvd6u3o16np1veu3\";s:28:\"p178gndfng73r1u6rjvduje1ah04\";s:28:\"p178gndfng73r1u6rjvduje1ah04\";s:29:\"p178gndl8jqc3uma10fp1s4l1aha5\";s:29:\"p178gndl8jqc3uma10fp1s4l1aha5\";s:27:\"p178gndq0k12e7oj8u8g1mg3ap6\";s:27:\"p178gndq0k12e7oj8u8g1mg3ap6\";s:28:\"p178gnduc9u21119n5803jp1vms7\";s:28:\"p178gnduc9u21119n5803jp1vms7\";s:28:\"p178gne2lq101dck4caenl61nk28\";s:28:\"p178gne2lq101dck4caenl61nk28\";s:29:\"p178gneahq1dt71o87o3sfq81lt69\";s:29:\"p178gneahq1dt71o87o3sfq81lt69\";}'),(28,'2012 Посещение на художествената галерия',NULL,'',NULL,'a:7:{s:28:\"p178gnkhvg7o914se1bu4ulpcap1\";s:28:\"p178gnkhvg7o914se1bu4ulpcap1\";s:29:\"p178gnkm0jo221t1bsna17ks18ve2\";s:29:\"p178gnkm0jo221t1bsna17ks18ve2\";s:29:\"p178gnkp6nf571hs81qmjpum1isk3\";s:29:\"p178gnkp6nf571hs81qmjpum1isk3\";s:27:\"p178gnkrnuq2mic3mi81rveh2p4\";s:27:\"p178gnkrnuq2mic3mi81rveh2p4\";s:29:\"p178gnku621abn1ih6n0t1m44ja25\";s:29:\"p178gnku621abn1ih6n0t1m44ja25\";s:28:\"p178gnl2gn1ru61tf0ss3qtutoc6\";s:28:\"p178gnl2gn1ru61tf0ss3qtutoc6\";s:29:\"p178gnl6ho1ok71ludu91v0g1q367\";s:29:\"p178gnl6ho1ok71ludu91v0g1q367\";}'),(29,'2012 Операта и Южния парк',NULL,'',NULL,'a:9:{s:29:\"p178gnpjt07b01hgls481h041m7a1\";s:29:\"p178gnpjt07b01hgls481h041m7a1\";s:27:\"p178gnpovc1vkfg3hndp1df8ls2\";s:27:\"p178gnpovc1vkfg3hndp1df8ls2\";s:29:\"p178gnpshv1fqr2dn1o391i75vtv3\";s:29:\"p178gnpshv1fqr2dn1o391i75vtv3\";s:27:\"p178gnq39inkfaq5drjkoc1co94\";s:27:\"p178gnq39inkfaq5drjkoc1co94\";s:30:\"p178gnq8mk14m1ug0141m1u8r11165\";s:30:\"p178gnq8mk14m1ug0141m1u8r11165\";s:27:\"p178gnqbcv2511r9bvfhighkam6\";s:27:\"p178gnqbcv2511r9bvfhighkam6\";s:28:\"p178gnqevje6ts4250b186p157o7\";s:28:\"p178gnqevje6ts4250b186p157o7\";s:31:\"p178gnqnv21usc1vre1t411fch11tv9\";s:31:\"p178gnqnv21usc1vre1t411fch11tv9\";s:29:\"p178gnqsfrda015herei1n3n1cpba\";s:29:\"p178gnqsfrda015herei1n3n1cpba\";}');

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
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

/*Data for the table `images` */

insert  into `images`(`id`,`file_id`,`gid`,`basename`,`extension`,`title`,`tr_title`,`desc`,`tr_desc`,`size`,`type`,`path`,`url`,`created`,`updated`) values (49,'p178gnclet1vo8u3t1n4f176782u1',27,'small_P9154919','.jpg','','','','','29 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:33:13','2012-10-02 15:33:13'),(50,'p178gnd5a5efj11mc1183td710nt2',27,'small_P9154924','.jpg','','','','','34 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:33:15','2012-10-02 15:33:15'),(51,'p178gndaq7kqvd6u3o16np1veu3',27,'small_P9154925','.jpg','','','','','21 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:33:18','2012-10-02 15:33:18'),(52,'p178gndfng73r1u6rjvduje1ah04',27,'small_P9154927','.jpg','','','','','30 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:33:20','2012-10-02 15:33:20'),(53,'p178gndl8jqc3uma10fp1s4l1aha5',27,'small_P9154929','.jpg','','','','','30 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:33:23','2012-10-02 15:33:23'),(54,'p178gndq0k12e7oj8u8g1mg3ap6',27,'small_P9154932','.jpg','','','','','32 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:33:25','2012-10-02 15:33:25'),(55,'p178gnduc9u21119n5803jp1vms7',27,'small_P9154940','.jpg','','','','','28 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:33:28','2012-10-02 15:33:28'),(56,'p178gne2lq101dck4caenl61nk28',27,'small_P9154953','.jpg','','','','','30 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:33:30','2012-10-02 15:33:30'),(57,'p178gneahq1dt71o87o3sfq81lt69',27,'small_P9154985','.jpg','','','','','34 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:33:33','2012-10-02 15:33:33'),(58,'p178gnkhvg7o914se1bu4ulpcap1',28,'small_S4023462','.jpg','','','','','31 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:36:57','2012-10-02 15:36:57'),(59,'p178gnkm0jo221t1bsna17ks18ve2',28,'small_S4023463','.jpg','','','','','33 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:37:00','2012-10-02 15:37:00'),(60,'p178gnkp6nf571hs81qmjpum1isk3',28,'small_S4023464','.jpg','','','','','28 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:37:02','2012-10-02 15:37:02'),(61,'p178gnkrnuq2mic3mi81rveh2p4',28,'small_S4023465','.jpg','','','','','28 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:37:05','2012-10-02 15:37:05'),(62,'p178gnku621abn1ih6n0t1m44ja25',28,'small_S4023466','.jpg','','','','','30 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:37:07','2012-10-02 15:37:07'),(63,'p178gnl2gn1ru61tf0ss3qtutoc6',28,'small_S4023467','.jpg','','','','','32 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:37:10','2012-10-02 15:37:10'),(64,'p178gnl6ho1ok71ludu91v0g1q367',28,'small_S4023468','.jpg','','','','','33 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:37:12','2012-10-02 15:37:12'),(65,'p178gnpjt07b01hgls481h041m7a1',29,'small_S4023530','.jpg','','','','','20 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:40:04','2012-10-02 15:40:04'),(66,'p178gnpovc1vkfg3hndp1df8ls2',29,'small_S4023531','.jpg','','','','','19 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:40:07','2012-10-02 15:40:07'),(67,'p178gnpshv1fqr2dn1o391i75vtv3',29,'small_S4023532','.jpg','','','','','19 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:40:09','2012-10-02 15:40:09'),(68,'p178gnq39inkfaq5drjkoc1co94',29,'small_S4023525','.jpg','','','','','32 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:40:12','2012-10-02 15:40:12'),(69,'p178gnq8mk14m1ug0141m1u8r11165',29,'small_S4023533','.jpg','','','','','34 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:40:14','2012-10-02 15:40:14'),(70,'p178gnqbcv2511r9bvfhighkam6',29,'small_S4023534','.jpg','','','','','34 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:40:17','2012-10-02 15:40:17'),(71,'p178gnqevje6ts4250b186p157o7',29,'small_S4023535','.jpg','','','','','32 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:40:19','2012-10-02 15:40:19'),(73,'p178gnqnv21usc1vre1t411fch11tv9',29,'small_S4023537','.jpg','','','','','28 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:40:24','2012-10-02 15:40:24'),(74,'p178gnqsfrda015herei1n3n1cpba',29,'small_S4023541','.jpg','','','','','20 KB','image/jpeg','/gal_images','http://www.yiiframework.com','2012-10-02 15:40:27','2012-10-02 15:40:27');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
