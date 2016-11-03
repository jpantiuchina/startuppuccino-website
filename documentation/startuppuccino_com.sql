-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: startuppuccino.com.mysql:3306
-- Generation Time: Nov 03, 2016 at 01:56 PM
-- Server version: 5.5.50-MariaDB-1~wheezy
-- PHP Version: 5.4.45-0+deb7u5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `startuppuccino_com`
--

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__account`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linkedin_id` varchar(63) DEFAULT NULL,
  `about` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `avatar` longblob,
  `background` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `skills` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `socials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` varchar(63) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstName` varchar(63) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(63) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(63) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_email` (`email`),
  UNIQUE KEY `linkedin_id_UNIQUE` (`linkedin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=105 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__account_logged`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__account_logged` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `cookie_token` varchar(63) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cookie_token_UNIQUE` (`cookie_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=508 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__assignments`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(63) NOT NULL,
  `deadline` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `milestone/session_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__mentor_availability`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__mentor_availability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mentor_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `confirmed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pitch` tinyint(1) NOT NULL DEFAULT '0',
  `pitch_approved` tinyint(1) DEFAULT NULL,
  `pitch_title` varchar(300) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `available_id` (`mentor_id`,`session_id`),
  KEY `fk_session_id_idx` (`session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__mentor_project`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__mentor_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mentor_id` (`project_id`,`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=73 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__mentor_residence`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__mentor_residence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mentor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk2_mentor_id` (`mentor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=203 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__milestone`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__milestone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(63) NOT NULL,
  `description` varchar(45) NOT NULL,
  `deadline` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__project`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(63) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` int(11) NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `vision` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `avatar` text,
  `ideal_team_size` int(2) DEFAULT NULL,
  `looking_for` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `milestone_2` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `fk_project_author_idx` (`owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__project_comment`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__project_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `commented_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `comment_project` (`project_id`),
  KEY `comment_author` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=70 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__project_like`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__project_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_likes` (`project_id`,`account_id`),
  KEY `like_project` (`project_id`),
  KEY `like_account` (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=171 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__project_mentor`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__project_mentor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mentor_id` (`project_id`,`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=96 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__project_milestones`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__project_milestones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `milestone_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `project_milestones_idx` (`project_id`),
  KEY `fk_milestone_p_idx` (`milestone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__project_participant`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__project_participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idea_id` (`project_id`,`account_id`),
  KEY `fk_account_id_idx` (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__session`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(45) DEFAULT NULL,
  `date` datetime NOT NULL,
  `description` text,
  `resource` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `startuppuccino__session_comment`
--

CREATE TABLE IF NOT EXISTS `startuppuccino__session_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `commented_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `session_comment_session` (`session_id`),
  KEY `session_comment_author` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `startuppuccino__mentor_availability`
--
ALTER TABLE `startuppuccino__mentor_availability`
  ADD CONSTRAINT `fk_mentor_id` FOREIGN KEY (`mentor_id`) REFERENCES `startuppuccino__account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_session_id` FOREIGN KEY (`session_id`) REFERENCES `startuppuccino__session` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `startuppuccino__mentor_residence`
--
ALTER TABLE `startuppuccino__mentor_residence`
  ADD CONSTRAINT `fk2_mentor_id` FOREIGN KEY (`mentor_id`) REFERENCES `startuppuccino__account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `startuppuccino__project`
--
ALTER TABLE `startuppuccino__project`
  ADD CONSTRAINT `fk_project_author` FOREIGN KEY (`owner_id`) REFERENCES `startuppuccino__account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `startuppuccino__session_comment`
--
ALTER TABLE `startuppuccino__session_comment`
  ADD CONSTRAINT `session_comment_author` FOREIGN KEY (`author_id`) REFERENCES `startuppuccino__account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `session_comment_session` FOREIGN KEY (`session_id`) REFERENCES `startuppuccino__session` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
