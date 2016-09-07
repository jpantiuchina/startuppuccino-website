-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema startup
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `startup` DEFAULT CHARACTER SET utf8mb4 ;
USE `startup` ;

-- -----------------------------------------------------
-- Table `startup`.`account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startup`.`account` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `linkedin_id` VARCHAR(63) NULL,
  `about` LONGTEXT COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `avatar` LONGBLOB NULL DEFAULT NULL,
  `background` VARCHAR(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `skills` VARCHAR(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `socials` LONGTEXT COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `email` VARCHAR(63) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `firstName` VARCHAR(63) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `lastName` VARCHAR(63) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `password` VARCHAR(63) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `role` VARCHAR(15) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `account_email` (`email` ASC),
  UNIQUE INDEX `linkedin_id_UNIQUE` (`linkedin_id` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 5
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `startup`.`project`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startup`.`project` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(63) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `owner_id` INT(11) NOT NULL,
  `description` LONGTEXT COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `vision` LONGTEXT COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `avatar` TEXT NULL,
  `ideal_team_size` INT(2) NULL,
  `current_team_size` INT(2) NULL,
  `looking_for` VARCHAR(63) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `approved` CHAR(1) NOT NULL DEFAULT 'F',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `title` (`title` ASC),
  INDEX `fk_project_author_idx` (`owner_id` ASC),
  CONSTRAINT `fk_project_author`
    FOREIGN KEY (`owner_id`)
    REFERENCES `startup`.`account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `startup`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startup`.`comment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `project_id` INT(11) NOT NULL,
  `author_id` INT(11) NOT NULL,
  `text` LONGTEXT COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `comment_project` (`project_id` ASC),
  INDEX `comment_author` (`author_id` ASC),
  CONSTRAINT `comment_author`
    FOREIGN KEY (`author_id`)
    REFERENCES `startup`.`account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `comment_project`
    FOREIGN KEY (`project_id`)
    REFERENCES `startup`.`project` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `startup`.`project_participants`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startup`.`project_participants` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `project_id` INT(11) NOT NULL,
  `account_id` INT(11) NOT NULL,
  `joined_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idea_id` (`project_id` ASC, `account_id` ASC),
  INDEX `fk_account_id_idx` (`account_id` ASC))
ENGINE = MyISAM
AUTO_INCREMENT = 58
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `startup`.`like`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startup`.`like` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `project_id` INT(11) NOT NULL,
  `account_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `like_project` (`project_id` ASC),
  INDEX `like_account` (`account_id` ASC),
  UNIQUE INDEX `unique_likes` (`project_id` ASC, `account_id` ASC),
  CONSTRAINT `like_account`
    FOREIGN KEY (`account_id`)
    REFERENCES `startup`.`account` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `like_project`
    FOREIGN KEY (`project_id`)
    REFERENCES `startup`.`project` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `startup`.`milestone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startup`.`milestone` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(63) NOT NULL,
  `description` VARCHAR(45) NOT NULL,
  `deadline` DATETIME NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name` (`name` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `startup`.`project_milestones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startup`.`project_milestones` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `project_id` INT(11) NOT NULL,
  `milestone_id` INT(11) NOT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `project_milestones_idx` (`project_id` ASC),
  INDEX `fk_milestone_p_idx` (`milestone_id` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
