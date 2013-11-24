-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: skeleton
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `mainOrganizationaUnitId` int(11) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `secondary_email` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_realm` varchar(50) NOT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user_preferences` (
  `user_preferencesId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `language` enum('catalan','spanish','english') NOT NULL DEFAULT 'catalan',
  `theme` enum('flexigrid','datatables','twitter-bootstrap') NOT NULL DEFAULT 'flexigrid',
  `dialogforms` enum('n','y') NOT NULL DEFAULT 'n',
  `description` text,
  `entryDate` datetime NOT NULL,
  `manualEntryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `manualLast_update` datetime NOT NULL,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`user_preferencesId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `organizational_unit` (
  `organizational_unitId` int(11) NOT NULL AUTO_INCREMENT,
  `externalCode` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `shortName` varchar(150) NOT NULL,
  `description` text,
  `entryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `location` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL,
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`organizational_unitId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `location` (
  `locationId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `shortName` varchar(150) NOT NULL,
  `description` text,
  `entryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `parentLocation` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL,
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`locationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Database: `ebre_escool`
--

-- --------------------------------------------------------

--
-- Table structure for table `classroom_group`
--

CREATE TABLE IF NOT EXISTS `classroom_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `group_shortName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `group_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `group_course_id` int(11) NOT NULL,
  `group_description` text COLLATE utf8_unicode_ci NOT NULL,
  `group_educationalLevelId` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `group_mentorId` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_entryDate` datetime NOT NULL,
  `group_lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `group_creationUserId` int(11) DEFAULT NULL,
  `group_lastupdateUserId` int(11) DEFAULT NULL,
  `group_parentLocation` int(11) DEFAULT NULL,
  `group_markedForDeletion` enum('n','y') COLLATE utf8_unicode_ci NOT NULL,
  `group_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_code` (`group_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Restriccions per la taula `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

-- Dump completed on 2013-09-13  7:33:11



-- --------------------------------------------------------

--
-- Estructura de la taula `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `course_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `course_number` int(11) NOT NULL,
  `course_cycle_id` int(11) NOT NULL,
  `course_estudies_id` int(11) NOT NULL,
  `course_entryDate` datetime NOT NULL,
  `course_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `course_creationUserId` int(11) DEFAULT NULL,
  `course_lastupdateUserId` int(11) DEFAULT NULL,
  `course_markedForDeletion` enum('n','y') NOT NULL,
  `course_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `cycle`
--

CREATE TABLE IF NOT EXISTS `cycle` (
  `cycle_id` int(11) NOT NULL AUTO_INCREMENT,
  `cycle_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `cycle_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `cycle_entryDate` datetime NOT NULL,
  `cycle_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cycle_creationUserId` int(11) DEFAULT NULL,
  `cycle_lastupdateUserId` int(11) DEFAULT NULL,
  `cycle_markedForDeletion` enum('n','y') NOT NULL,
  `cycle_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`cycle_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `enrollment` (
  `enrollment_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_periodid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_personid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_entryDate` datetime NOT NULL,
  `enrollment_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enrollment_creationUserId` int(11) DEFAULT NULL,
  `enrollment_lastupdateUserId` int(11) DEFAULT NULL,
  `enrollment_markedForDeletion` enum('n','y') NOT NULL,
  `enrollment_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`enrollment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `enrollment_class_group`
--

CREATE TABLE IF NOT EXISTS `enrollment_class_group` (
  `enrollment_class_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_class_group_periodid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_class_group_personid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_class_group_study_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_class_group_group_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_class_group_entryDate` datetime NOT NULL,
  `enrollment_class_group_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enrollment_class_group_creationUserId` int(11) DEFAULT NULL,
  `enrollment_class_group_lastupdateUserId` int(11) DEFAULT NULL,
  `enrollment_class_group_markedForDeletion` enum('n','y') NOT NULL,
  `enrollment_class_group_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`enrollment_class_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `enrollment_modules`
--

CREATE TABLE IF NOT EXISTS `enrollment_modules` (
  `enrollment_modules_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_modules_periodid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_modules_personid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_modules_study_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_modules_group_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_modules_moduleid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_modules_entryDate` datetime NOT NULL,
  `enrollment_modules_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enrollment_modules_creationUserId` int(11) DEFAULT NULL,
  `enrollment_modules_lastupdateUserId` int(11) DEFAULT NULL,
  `enrollment_modules_markedForDeletion` enum('n','y') NOT NULL,
  `enrollment_modules_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`enrollment_modules_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `enrollment_studies`
--

CREATE TABLE IF NOT EXISTS `enrollment_studies` (
  `enrollment_studies_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_studies_periodid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_studies_personid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_studies_study_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_studies_entryDate` datetime NOT NULL,
  `enrollment_studies_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enrollment_studies_creationUserId` int(11) DEFAULT NULL,
  `enrollment_studies_lastupdateUserId` int(11) DEFAULT NULL,
  `enrollment_studies_markedForDeletion` enum('n','y') NOT NULL,
  `enrollment_studies_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`enrollment_studies_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `enrollment_submodules`
--

CREATE TABLE IF NOT EXISTS `enrollment_submodules` (
  `enrollment_submodules_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_submodules_periodid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_submodules_personid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_submodules_study_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_submodules_group_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_submodules_moduleid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_submodules_submoduleid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_submodules_entryDate` datetime NOT NULL,
  `enrollment_submodules_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enrollment_submodules_creationUserId` int(11) DEFAULT NULL,
  `enrollment_submodules_lastupdateUserId` int(11) DEFAULT NULL,
  `enrollment_submodules_markedForDeletion` enum('n','y') NOT NULL,
  `enrollment_submodules_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`enrollment_submodules_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



--
-- Estructura de la taula `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `department_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `department_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `department_parent_department_id` int(11) NOT NULL,
  `department_entryDate` datetime NOT NULL,
  `department_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `department_creationUserId` int(11) DEFAULT NULL,
  `department_lastupdateUserId` int(11) DEFAULT NULL,
  `department_markedForDeletion` enum('n','y') NOT NULL,
  `department_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `studies`
--

CREATE TABLE IF NOT EXISTS `studies` (
  `studies_id` int(11) NOT NULL AUTO_INCREMENT,
  `studies_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `studies_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `studies_entryDate` datetime NOT NULL,
  `studies_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `studies_creationUserId` int(11) DEFAULT NULL,
  `studies_lastupdateUserId` int(11) DEFAULT NULL,
  `studies_markedForDeletion` enum('n','y') NOT NULL,
  `studies_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`studies_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `studies_organizational_unit`
--

CREATE TABLE IF NOT EXISTS `studies_organizational_unit` (
  `studiesOU_id` int(11) NOT NULL AUTO_INCREMENT,
  `studiesOU_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `studiesOU_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `studiesOU_entryDate` datetime NOT NULL,
  `studiesOU_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `studiesOU_creationUserId` int(11) DEFAULT NULL,
  `studiesOU_lastupdateUserId` int(11) DEFAULT NULL,
  `studiesOU_markedForDeletion` enum('n','y') NOT NULL,
  `studiesOU_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`studiesOU_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- Dump completed on 2013-11-04  9:26:45

-- --------------------------------------------------------

--
-- Estructura de la taula `study_module`
--

CREATE TABLE IF NOT EXISTS `study_module` (
  `study_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `study_module_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `study_module_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `study_module_hoursPerWeek` int(3) NOT NULL,
  `study_module_course_id` int(11) NOT NULL,
  `study_module_teacher_id` int(11) NOT NULL,
  `study_module_initialDate` datetime NOT NULL,
  `study_module_endDate` datetime NOT NULL,
  `study_module_type` enum('Troncal','Alternativa','Optativa') NOT NULL,
  `study_module_subtype` enum('Trimestral','Quadrimestral') NOT NULL,
  `study_module_entryDate` datetime NOT NULL,
  `study_module_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `study_module_creationUserId` int(11) DEFAULT NULL,
  `study_module_lastupdateUserId` int(11) DEFAULT NULL,
  `study_module_markedForDeletion` enum('n','y') NOT NULL,
  `study_module_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`study_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Estructura de la taula `study_submodules`
--

CREATE TABLE IF NOT EXISTS `study_submodules` (
  `study_submodules_id` int(11) NOT NULL AUTO_INCREMENT,
  `study_submodules_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `study_submodules_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `study_submodules_entryDate` datetime NOT NULL,
  `study_submodules_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `study_submodules_creationUserId` int(11) DEFAULT NULL,
  `study_submodules_lastupdateUserId` int(11) DEFAULT NULL,
  `study_submodules_markedForDeletion` enum('n','y') NOT NULL,
  `study_submodules_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`study_submodules_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- Dump completed on 2013-09-13  7:33:11

-- --------------------------------------------------------

