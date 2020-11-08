-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


CREATE DATABASE IF NOT EXISTS `nautilusv2` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `nautilusv2`;

CREATE TABLE IF NOT EXISTS `comptesFB` (
  `id` varchar(50) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `jeton` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `comptesFB` (`id`,`nom`,`jeton`) VALUES
	('10156975604778178', 'Sim On','EAANX4doqDDsBAOBQszs1wRZCIUG5SEQaArSVtofdWwdZA6ivaIvn6JnvaMFfIyHN7AynqP2Sf9gfeSFKXFDGIJEupHBB0wiyZArFt5hIodzJPreTYqZBK4tO7408TQhiiaqc20hJuuYZC6cT0Fjl4xug8CWLb6APtZCWOGYX2jvgZDZD'),
	('454172598774501', 'Thomas Lemoine','EAANX4doqDDsBAFjo5yb1gPfWzZAQ7TGlzxRVl5CtDilGpYFi9E9kuvzfrFkALgZAE43JiPQiJPilWtvqzV42Lszgkz1X6PbXsK4NeXSI3lwWmuiPCwMDEcdG9oQ6yoApQQysoig3xsDvreLwO6ZCTHZCfeEhjoukj4If7q0ZCq9YPB89s1xhN');

CREATE TABLE IF NOT EXISTS `pagesFB` (
  `id` varchar(100) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `id_comptes` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_pages_id_comptes` FOREIGN KEY (`id_comptes`) REFERENCES `comptesFB` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `pagesInsta` (
  `id` varchar(100) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `id_pagesFB` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_pages_1` FOREIGN KEY (`id_pagesFB`) REFERENCES `pagesFB` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pagesFB` (`id`, `nom`, `id_comptes`) VALUES
	('106656610804614', 'Double Test', '454172598774501'),
	('106713080776694', 'Test', '454172598774501'),
	('112020496873982', 'Khalass King', '454172598774501'),
	('112611456769611', 'Réa Délice Antilles - Guyane', '10156975604778178'),
	('140323356713031', 'PACE Trail Experience', '10156975604778178'),
	('160532500751607', 'Find 815', '10156975604778178'),
	('160906327694733', 'Parking Longue Durée Aéroport Roland Garros', '10156975604778178'),
	('195515040501274', 'Edena Réunion', '10156975604778178'),
	('206492482774257', 'Hollywood Chewing Gum', '10156975604778178'),
	('258272560952334', 'Sofider - Un projet, prêt, partez', '10156975604778178'),
	('262604187118903', 'Johnnie Walker', '10156975604778178'),
	('304197823052471', 'Aéro Club Roland Garros, Ile de La Réunion, FMEE', '10156975604778178'),
	('308143455961241', 'SEGA Réunion', '10156975604778178'),
	('312005579380525', 'Amazonia', '10156975604778178'),
	('313798005823460', 'Petit Navire', '10156975604778178'),
	('394306750779686', 'Corbeille d\'Or', '10156975604778178'),
	('439470426824588', 'Maoré Majoiy', '10156975604778178'),
	('465148270187970', 'A Toute Allure', '10156975604778178'),
	('487116651409898', 'BIG COLA Réunion', '10156975604778178'),
	('550616768290028', 'Nautilus', '10156975604778178'),
	('557564277665463', 'Ewa-Air', '10156975604778178'),
	('631048053582092', 'Help les mamans', '10156975604778178'),
	('670666149977057', 'Agence Nautilus Mayotte', '10156975604778178'),
	('732809193517648', 'Réaliz', '10156975604778178'),
	('847952655326491', 'Air Austral', '10156975604778178'),
	('874873169357426', 'Austral Voyages', '10156975604778178'),
	('886436244863904', 'Citro', '10156975604778178');


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `mdp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`,`pseudo`, `login`, `mdp`) VALUES
	(1, 'admin','supernautilus', 'b09c600fddc573f117449b3723f23d64'),
	(2,'admin', 'toto', 'f71dbe52628a3f83a77ab494817525c6');
