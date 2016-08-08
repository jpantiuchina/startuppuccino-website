CREATE DATABASE  IF NOT EXISTS `startuppuccino`;
USE `startuppuccino`;

--
-- Table structure for table `Account`
--

DROP TABLE IF EXISTS `Account`;
CREATE TABLE `Account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `about` longtext COLLATE utf8mb4_unicode_ci,
  `avatar` longblob,
  `background` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstName` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `Project`
--

DROP TABLE IF EXISTS `Project`;
CREATE TABLE `Project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `title` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `ProjectAccount`
--

DROP TABLE IF EXISTS `ProjectAccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProjectAccount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_account` (`project_id`,`account_id`),
  KEY `FK_csq71jrxvrigq6i6s8e9pag4i` (`account_id`),
  CONSTRAINT `FK_iuswbwlcoenp18plrhymglury` FOREIGN KEY (`project_id`) REFERENCES `Project` (`id`),
  CONSTRAINT `FK_csq71jrxvrigq6i6s8e9pag4i` FOREIGN KEY (`account_id`) REFERENCES `Account` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `Comment`
--

DROP TABLE IF EXISTS `Comment`;
CREATE TABLE `Comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_project` (`project_id`),
  KEY `comment_account` (`account_id`),
  KEY `comment_author` (`author_id`),
  CONSTRAINT `comment_project` FOREIGN KEY (`project_id`) REFERENCES `Project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `comment_author` FOREIGN KEY (`author_id`) REFERENCES `Account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `comment_account` FOREIGN KEY (`account_id`) REFERENCES `Account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `Like`
--

DROP TABLE IF EXISTS `Like`;
CREATE TABLE `Like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `like_unique_project_author` (`project_id`,`author_id`),
  UNIQUE KEY `like_unique_account_author` (`account_id`,`author_id`),
  KEY `like_project` (`project_id`),
  KEY `like_account` (`account_id`),
  KEY `like_author` (`author_id`),
  CONSTRAINT `like_project` FOREIGN KEY (`project_id`) REFERENCES `Project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `like_author` FOREIGN KEY (`author_id`) REFERENCES `Account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `like_account` FOREIGN KEY (`account_id`) REFERENCES `Account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE Project ADD vision LONGTEXT;
ALTER TABLE Project MODIFY COLUMN title varchar(63) NOT NULL UNIQUE;
CREATE TABLE Teams ( id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(63) NOT NULL UNIQUE, mentor_id INT(11));
CREATE TABLE TeamProject ( id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, team_id INT(11) NOT NULL, project_id INT(11) NOT NULL, date DATE);
CREATE TABLE TeamAccount ( id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, team_id INT(11) NOT NULL, account_id INT(11) NOT NULL, date DATE);
DROP TABLE ProjectAccount;
CREATE TABLE Ideas ( id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, title VARCHAR(63) NOT NULL UNIQUE, description VARCHAR(144), owner_id INT(11) NOT NULL, team_size INT(2) NOT NULL DEFAULT '2', background_pref LONGTEXT, date DATE);
CREATE TABLE IdeaAccount ( id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, idea_id INT(11) NOT NULL, account_id INT(11) NOT NULL, date DATE);
ALTER TABLE Project ADD COLUMN team_id int(11) NOT NULL UNIQUE;
ALTER TABLE Project ADD COLUMN created_date DATE NOT NULL;
ALTER TABLE Project ADD COLUMN updated_date DATE NOT NULL;
DROP TABLE TeamProject;
ALTER TABLE `IdeaAccount` ADD UNIQUE (`idea_id`, `account_id`);
ALTER TABLE Ideas ADD COLUMN current_team_size INT(2) NOT NULL DEFAULT '1';
CREATE TABLE Milestones ( id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(63) NOT NULL UNIQUE);
CREATE TABLE ProjectMilestones ( project_id INT(11) NOT NULL, milestone_id INT(11) NOT NULL, update_date DATE NOT NULL, PRIMARY KEY(project_id, milestone_id));

ALTER TABLE 'account' ADD 'skills' VARCHAR(255) NOT NULL AFTER 'background';

ALTER TABLE `account` ADD `socials` LONGTEXT COLLATE utf8mb4_unicode_ci AFTER `skills`;

ALTER TABLE `ideas` ADD `avatar` TEXT NULL AFTER `team_size`;

ALTER TABLE `ideas` ADD `approved` CHAR(1) NOT NULL DEFAULT 'F' AFTER `background_pref`;
CREATE TABLE `startuppuccino`.`ideacomment` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `account_id` INT(11) NOT NULL , `idea_id` INT(11) NOT NULL , `text` TEXT NOT NULL , `date` DATE NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `startuppuccino`.`idealike` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `account_id` INT(11) NOT NULL , `idea_id` INT(11) NOT NULL , `date` DATE NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `idealike` ADD UNIQUE( `account_id`, `idea_id`);