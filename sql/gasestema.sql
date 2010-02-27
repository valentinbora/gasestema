SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user` ;

CREATE  TABLE IF NOT EXISTS `user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(100) NULL ,
  `password` CHAR(40) NULL ,
  `realname` VARCHAR(255) NULL ,
  `registered` INT UNSIGNED NOT NULL ,
  `token` CHAR(40) NULL ,
  `active` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email` (`email`(50) ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `localitate`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `localitate` ;

CREATE  TABLE IF NOT EXISTS `localitate` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` MEDIUMTEXT NULL ,
  `lat` DOUBLE NULL DEFAULT 45 ,
  `long` DOUBLE NULL DEFAULT 23 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `locatie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `locatie` ;

CREATE  TABLE IF NOT EXISTS `locatie` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nume` TEXT NULL ,
  `localitate` INT UNSIGNED NOT NULL ,
  `adresa` TEXT NULL ,
  `link` TEXT NULL ,
  `lat` DOUBLE NULL ,
  `long` DOUBLE NULL ,
  `contact` TEXT NULL ,
  `descriere` TEXT NULL ,
  `orar` TEXT NULL ,
  `logo` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_locatie_localitate` (`localitate` ASC) ,
  CONSTRAINT `fk_locatie_localitate`
    FOREIGN KEY (`localitate` )
    REFERENCES `localitate` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `obiect`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `obiect` ;

CREATE  TABLE IF NOT EXISTS `obiect` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nume` INT UNSIGNED NOT NULL ,
  `localitate` INT UNSIGNED NOT NULL ,
  `locatie` INT UNSIGNED NOT NULL ,
  `user` INT UNSIGNED NOT NULL ,
  `adaugat` INT UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_obiect_localitate1` (`localitate` ASC) ,
  INDEX `fk_obiect_locatie1` (`locatie` ASC) ,
  INDEX `fk_obiect_user1` (`user` ASC) ,
  CONSTRAINT `fk_obiect_localitate1`
    FOREIGN KEY (`localitate` )
    REFERENCES `localitate` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_obiect_locatie1`
    FOREIGN KEY (`locatie` )
    REFERENCES `locatie` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_obiect_user1`
    FOREIGN KEY (`user` )
    REFERENCES `user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tag` ;

CREATE  TABLE IF NOT EXISTS `tag` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nume` TINYTEXT NULL ,
  `obiect` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `tag_obiect`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tag_obiect` ;

CREATE  TABLE IF NOT EXISTS `tag_obiect` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `obiect` INT UNSIGNED NOT NULL ,
  `tag` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`, `tag`, `obiect`) ,
  INDEX `fk_tag_obiect_obiect1` (`obiect` ASC) ,
  INDEX `fk_tag_obiect_tag1` (`tag` ASC) ,
  CONSTRAINT `fk_tag_obiect_obiect1`
    FOREIGN KEY (`obiect` )
    REFERENCES `obiect` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tag_obiect_tag1`
    FOREIGN KEY (`tag` )
    REFERENCES `tag` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `obiect_nume`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `obiect_nume` ;

CREATE  TABLE IF NOT EXISTS `obiect_nume` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nume` TEXT NULL ,
  `obiect` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  FULLTEXT INDEX `nume` (`nume` ASC) )
ENGINE = MyISAM;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
