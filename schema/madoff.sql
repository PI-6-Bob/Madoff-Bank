-- MariaDB dump 10.19  Distrib 10.5.16-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: madoff
-- ------------------------------------------------------
-- Server version	10.9.4-MariaDB-1:10.9.4+maria~ubu2204

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(60) NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `role` enum('admin','executive','client') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_UN` (`email`),
  KEY `account_FK` (`person_id`),
  CONSTRAINT `account_FK` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (5,'mcardenas@ucol.mx','3142175227','$2y$10$mmoqetkWBkhohPmc8tjtPOcNhfLOKTjpXbHJsGgj07zAJpk3B26vS',11,'admin');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_user` (`account_id`),
  CONSTRAINT `admin_account_FK` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `executive_id` int(10) unsigned NOT NULL,
  `balance` double NOT NULL DEFAULT 0,
  `account_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_executive` (`executive_id`),
  KEY `client_account_FK` (`account_id`),
  CONSTRAINT `client_account_FK` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `client_executive_FK` FOREIGN KEY (`executive_id`) REFERENCES `executive` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `executive`
--

DROP TABLE IF EXISTS `executive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `executive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `executive_user` (`account_id`),
  CONSTRAINT `executive_account_FK` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `executive`
--

LOCK TABLES `executive` WRITE;
/*!40000 ALTER TABLE `executive` DISABLE KEYS */;
/*!40000 ALTER TABLE `executive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loan`
--

DROP TABLE IF EXISTS `loan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amount` double NOT NULL DEFAULT 0,
  `periods` smallint(5) unsigned NOT NULL DEFAULT 1,
  `account_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `loan_account` (`account_id`),
  CONSTRAINT `loan_period_CHECK` CHECK (`periods` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loan`
--

LOCK TABLES `loan` WRITE;
/*!40000 ALTER TABLE `loan` DISABLE KEYS */;
/*!40000 ALTER TABLE `loan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `birth_date` date NOT NULL,
  `registered_on` datetime NOT NULL DEFAULT curdate(),
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `curp` varchar(18) NOT NULL,
  `address` text DEFAULT NULL,
  `rfc` varchar(13) NOT NULL,
  `marital_status` enum('married','single','widow') DEFAULT 'single',
  PRIMARY KEY (`id`),
  UNIQUE KEY `person_UN` (`curp`,`rfc`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person`
--

LOCK TABLES `person` WRITE;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` VALUES (11,'Mauricio','Cardenas','2022-11-10','2022-11-11 00:00:00',1,'CAGM68022123',NULL,'CAGM68092','single');
/*!40000 ALTER TABLE `person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `when` datetime NOT NULL DEFAULT curdate(),
  `amount` double NOT NULL DEFAULT 0,
  `ubication` text DEFAULT NULL,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  `body` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_to` (`to`),
  KEY `transactions_from` (`from`),
  CONSTRAINT `transactions_from` FOREIGN KEY (`from`) REFERENCES `account` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `transactions_to` FOREIGN KEY (`to`) REFERENCES `account` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'madoff'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-25  8:36:37
