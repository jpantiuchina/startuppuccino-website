CREATE TABLE IF NOT EXISTS `startuppuccino`.`account_logged` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `account_id` INT(11) NOT NULL,
  `cookie_token` VARCHAR(63) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `logged_account` (`account_id` ASC),
  UNIQUE INDEX `cookie_token_UNIQUE` (`cookie_token` ASC),
  CONSTRAINT `logged_account`
    FOREIGN KEY (`account_id`)
    REFERENCES `startuppuccino`.`account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;