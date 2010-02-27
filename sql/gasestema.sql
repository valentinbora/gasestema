SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


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
  `localitate` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email` (`email`(50) ASC) ,
  INDEX `fk_user_localitate1` (`localitate` ASC) ,
  CONSTRAINT `fk_user_localitate1`
    FOREIGN KEY (`localitate` )
    REFERENCES `localitate` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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
  `descriere` VARCHAR(45) NULL ,
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
  PRIMARY KEY (`id`) ,
  FULLTEXT INDEX `nume` (`nume` ASC) )
ENGINE = MyISAM;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `localitate`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `gasestema`;
insert into `gasestema`.`localitate` (`id`, `name`, `lat`, `long`) values (1, 'timisoara', 45.7494399999999999, 21.2272199999999991);
insert into `gasestema`.`localitate` (`id`, `name`, `lat`, `long`) values (2, 'bucuresti', NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `user`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `gasestema`;
insert into `gasestema`.`user` (`id`, `email`, `password`, `realname`, `registered`, `token`, `active`, `localitate`) values (1, 'contact@valentinbora.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Valentin B', 1267289919, NULL, 1, 1);
insert into `gasestema`.`user` (`id`, `email`, `password`, `realname`, `registered`, `token`, `active`, `localitate`) values (2, 'mihai.oaida@gmail.com', 'pm0bc1be59e8c035d4e466aabda5cbcee18507bfa4', 'Mihai O', 1267289919, NULL, 1, 2);

COMMIT;

-- -----------------------------------------------------
-- Data for table `locatie`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `gasestema`;
insert into `gasestema`.`locatie` (`id`, `nume`, `localitate`, `adresa`, `link`, `lat`, `long`, `contact`, `descriere`, `orar`, `logo`) values (1, 'tequila', 1, 'aleea studentilor nr 1', 'clubtequila.ro', NULL, NULL, '0741548443', 'club de dat cu bile si jucat biliard', '10-22', NULL);
insert into `gasestema`.`locatie` (`id`, `nume`, `localitate`, `adresa`, `link`, `lat`, `long`, `contact`, `descriere`, `orar`, `logo`) values (2, '3f', 1, 'aleea studentilor nr 1', '3f.ro', NULL, NULL, NULL, 'food and drinks', '0-24', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `obiect`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `gasestema`;
insert into `gasestema`.`obiect` (`id`, `nume`, `localitate`, `locatie`, `user`, `adaugat`, `descriere`) values (1, 1, 1, 1, 1, NULL, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
insert into `gasestema`.`obiect` (`id`, `nume`, `localitate`, `locatie`, `user`, `adaugat`, `descriere`) values (2, 2, 1, 2, 2, NULL, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

COMMIT;

-- -----------------------------------------------------
-- Data for table `obiect_nume`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `gasestema`;
insert into `gasestema`.`obiect_nume` (`id`, `nume`) values (1, 'paulaner');
insert into `gasestema`.`obiect_nume` (`id`, `nume`) values (2, 'jacob');

COMMIT;
