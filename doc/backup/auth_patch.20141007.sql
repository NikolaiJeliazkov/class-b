CREATE TABLE authitem (
	NAME VARCHAR(64) NOT NULL,
	TYPE INT NOT NULL,
	description TEXT,
	bizrule TEXT,
	DATA TEXT,
 PRIMARY KEY (NAME)) ENGINE = INNODB
DEFAULT CHARACTER SET utf8;

CREATE TABLE authitemchild (
	parent VARCHAR(64) NOT NULL,
	child VARCHAR(64) NOT NULL,
 PRIMARY KEY (parent,child)) ENGINE = INNODB
DEFAULT CHARACTER SET utf8;

CREATE TABLE authassignment (
	itemname VARCHAR(64) NOT NULL,
	userId BIGINT UNSIGNED NOT NULL,
	bizrule TEXT,
	DATA TEXT,
 PRIMARY KEY (itemname,userId)) ENGINE = INNODB
DEFAULT CHARACTER SET utf8;

CREATE INDEX authitemchild_ibfk_2 ON authitemchild (child);

ALTER TABLE authassignment ADD FOREIGN KEY (userId) REFERENCES users (userId) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE authitemchild ADD FOREIGN KEY (parent) REFERENCES authitem (NAME) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE authitemchild ADD FOREIGN KEY (child) REFERENCES authitem (NAME) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE authassignment ADD FOREIGN KEY (itemname) REFERENCES authitem (NAME) ON DELETE CASCADE ON UPDATE CASCADE;

/*Data for the table `authitem` */

INSERT  INTO authitem(NAME,TYPE,description,bizrule,DATA)
VALUES
	('admin',2,'superuser',NULL,NULL),
	('blogEditor',0,'BLOG editor',NULL,NULL),
	('editUsers',0,'Променя потребители',NULL,NULL),
	('form-master',2,'form-master',NULL,NULL),
	('galleryEditor',0,'Gallery editor',NULL,NULL),
	('viewUsers',0,'Преглежда потребители',NULL,NULL);

/*Data for the table `authitemchild` */

INSERT  INTO authitemchild(parent,child)
VALUES
	('admin','blogEditor'),
	('form-master','blogEditor'),
	('admin','editUsers'),
	('form-master','editUsers'),
	('admin','galleryEditor'),
	('form-master','galleryEditor'),
	('editUsers','viewUsers');


/*
INSERT  INTO authassignment(itemname,userId,bizrule,data) 
VALUES
	('admin',1,NULL,NULL),
	('form-master',2,NULL,NULL);
*/

CREATE TABLE galleries (
	galleryId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	userId BIGINT UNSIGNED NOT NULL,
	galleryOrder INT UNSIGNED NOT NULL,
	galleryStatus INT NOT NULL DEFAULT 0,
	galleryDate DATETIME NOT NULL,
	galleryTitle TEXT NOT NULL,
	galleryText TEXT,
	galleryTags TEXT,
 PRIMARY KEY (galleryId)) ENGINE = INNODB;

CREATE TABLE images (
	imageId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	galleryId INT UNSIGNED NOT NULL,
	imageOrder INT UNSIGNED NOT NULL,
	imageFileId VARCHAR(80),
	imageBaseName VARCHAR(45),
	imageExtension VARCHAR(6),
	imageTitle VARCHAR(256),
	imageDescription TEXT,
	imageSize VARCHAR(20),
	imageType VARCHAR(20),
	imagePath VARCHAR(256),
	imageUrl VARCHAR(256),
	imageCreated DATETIME,
	imageUpdated DATETIME,
 PRIMARY KEY (imageId)) ENGINE = INNODB;

ALTER TABLE galleries ADD FOREIGN KEY (userId) REFERENCES users (userId) ON DELETE  RESTRICT ON UPDATE  RESTRICT;
ALTER TABLE images ADD FOREIGN KEY (galleryId) REFERENCES galleries (galleryId) ON DELETE  RESTRICT ON UPDATE  RESTRICT;
