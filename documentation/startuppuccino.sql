-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema startuppuccino
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `startuppuccino` ;

-- -----------------------------------------------------
-- Schema startuppuccino
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `startuppuccino` DEFAULT CHARACTER SET utf8mb4 ;
USE `startuppuccino` ;

-- -----------------------------------------------------
-- Table `startuppuccino`.`account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startuppuccino`.`account` (
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
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `startuppuccino`.`project`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startuppuccino`.`project` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(63) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `owner_id` INT(11) NOT NULL,
  `description` LONGTEXT COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `vision` LONGTEXT COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `avatar` TEXT NULL,
  `ideal_team_size` INT(2) NULL,
  `looking_for` VARCHAR(63) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `is_approved` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `title` (`title` ASC),
  INDEX `fk_project_author_idx` (`owner_id` ASC),
  CONSTRAINT `fk_project_author`
    FOREIGN KEY (`owner_id`)
    REFERENCES `startuppuccino`.`account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `startuppuccino`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startuppuccino`.`comment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `project_id` INT(11) NOT NULL,
  `author_id` INT(11) NOT NULL,
  `text` LONGTEXT COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `commented_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `comment_project` (`project_id` ASC),
  INDEX `comment_author` (`author_id` ASC),
  CONSTRAINT `comment_author`
    FOREIGN KEY (`author_id`)
    REFERENCES `startuppuccino`.`account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `comment_project`
    FOREIGN KEY (`project_id`)
    REFERENCES `startuppuccino`.`project` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `startuppuccino`.`project_participant`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startuppuccino`.`project_participant` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `project_id` INT(11) NOT NULL,
  `account_id` INT(11) NOT NULL,
  `joined_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idea_id` (`project_id` ASC, `account_id` ASC),
  INDEX `fk_account_id_idx` (`account_id` ASC),
  CONSTRAINT `fk_project_id`
    FOREIGN KEY (`project_id`)
    REFERENCES `startuppuccino`.`project` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_account_id`
    FOREIGN KEY (`account_id`)
    REFERENCES `startuppuccino`.`account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 58
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `startuppuccino`.`like`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startuppuccino`.`like` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `project_id` INT(11) NOT NULL,
  `account_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `like_project` (`project_id` ASC),
  INDEX `like_account` (`account_id` ASC),
  UNIQUE INDEX `unique_likes` (`project_id` ASC, `account_id` ASC),
  CONSTRAINT `like_account`
    FOREIGN KEY (`account_id`)
    REFERENCES `startuppuccino`.`account` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `like_project`
    FOREIGN KEY (`project_id`)
    REFERENCES `startuppuccino`.`project` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `startuppuccino`.`milestone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startuppuccino`.`milestone` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(63) NOT NULL,
  `description` VARCHAR(45) NOT NULL,
  `deadline` DATETIME NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name` (`title` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `startuppuccino`.`project_milestones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startuppuccino`.`project_milestones` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `project_id` INT(11) NOT NULL,
  `milestone_id` INT(11) NOT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `project_milestones_idx` (`project_id` ASC),
  INDEX `fk_milestone_p_idx` (`milestone_id` ASC),
  CONSTRAINT `fk_project_m`
    FOREIGN KEY (`project_id`)
    REFERENCES `startuppuccino`.`project` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_milestone_p`
    FOREIGN KEY (`milestone_id`)
    REFERENCES `startuppuccino`.`milestone` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `startuppuccino`.`session`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startuppuccino`.`session` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` VARCHAR(45) NULL,
  `date` DATETIME NOT NULL,
  `description` VARCHAR(255) NULL,
  `resource` LONGTEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `startuppuccino`.`mentor_availability`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startuppuccino`.`mentor_availability` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `mentor_id` INT(11) NOT NULL,
  `session_id` INT(11) NOT NULL,
  `confirmed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pitch` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `available_id` (`mentor_id` ASC, `session_id` ASC),
  INDEX `fk_session_id_idx` (`session_id` ASC),
  CONSTRAINT `fk_mentor_id`
    FOREIGN KEY (`mentor_id`)
    REFERENCES `startuppuccino`.`account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_session_id`
    FOREIGN KEY (`session_id`)
    REFERENCES `startuppuccino`.`session` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `startuppuccino`.`assignments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `startuppuccino`.`assignments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(63) NOT NULL,
  `deadline` DATETIME NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `milestone/session_fk` INT(11) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
