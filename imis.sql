-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: imis_sput
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.17.10.1

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
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (1,'I',1000,NULL,1,'2018-04-29 15:41:07','2018-04-29 15:41:07'),(2,'II',1000,NULL,1,'2018-04-29 15:41:34','2018-04-29 15:41:34'),(3,'III',1000,NULL,1,'2018-04-29 15:41:41','2018-04-29 15:41:41'),(4,'IV',1000,NULL,1,'2018-04-29 15:41:47','2018-04-29 15:41:47');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `authorizations`
--

DROP TABLE IF EXISTS `authorizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authorizations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `controller` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view` tinyint(1) NOT NULL DEFAULT '0',
  `create` tinyint(1) NOT NULL DEFAULT '0',
  `update` tinyint(1) NOT NULL DEFAULT '0',
  `delete` tinyint(1) NOT NULL DEFAULT '0',
  `export` tinyint(1) NOT NULL DEFAULT '0',
  `import` tinyint(1) NOT NULL DEFAULT '0',
  `dashboard` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authorizations`
--

LOCK TABLES `authorizations` WRITE;
/*!40000 ALTER TABLE `authorizations` DISABLE KEYS */;
INSERT INTO `authorizations` VALUES (2,4,'User',1,1,1,1,1,1,1,'2018-04-25 18:47:17','2018-04-25 19:07:32');
/*!40000 ALTER TABLE `authorizations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barges`
--

DROP TABLE IF EXISTS `barges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `anchored` tinyint(1) NOT NULL DEFAULT '0',
  `capacity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barges`
--

LOCK TABLES `barges` WRITE;
/*!40000 ALTER TABLE `barges` DISABLE KEYS */;
INSERT INTO `barges` VALUES (1,'HASNUR 309',NULL,'2018-04-21 06:42:32','2018-04-25 01:46:20',1,NULL),(2,'SANTAN 3003',NULL,'2018-04-21 06:42:36','2018-04-21 06:47:20',0,NULL),(3,'INTAN KELANA 18',NULL,'2018-04-21 06:47:32','2018-04-21 06:47:32',0,NULL),(4,'LESTARI 3201',NULL,'2018-04-21 06:47:42','2018-04-21 06:47:42',0,NULL),(5,'TAMA 3058',NULL,'2018-04-21 06:47:52','2018-04-21 06:47:52',0,NULL),(6,'PULAU TIGA 330-22',NULL,'2018-04-21 06:48:13','2018-04-21 06:48:13',0,NULL),(7,'INTAN KELANA 12',NULL,'2018-04-21 06:48:26','2018-04-21 06:48:26',0,NULL),(8,'EADYRA MEGA 333',NULL,'2018-04-21 06:48:43','2018-04-25 01:46:12',1,NULL),(9,'AZAMARA 25',NULL,'2018-04-21 06:48:53','2018-04-25 20:20:04',1,NULL),(10,'HASNUR 302',NULL,'2018-04-21 06:49:01','2018-04-25 20:20:54',0,NULL);
/*!40000 ALTER TABLE `barges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `breakdown_categories`
--

DROP TABLE IF EXISTS `breakdown_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `breakdown_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breakdown_categories`
--

LOCK TABLES `breakdown_categories` WRITE;
/*!40000 ALTER TABLE `breakdown_categories` DISABLE KEYS */;
INSERT INTO `breakdown_categories` VALUES (2,'SCM','Schedule Service','Service terjadwal',1,NULL,NULL),(3,'USM','Unschedule Service','Service tidak terjadwal',1,NULL,NULL),(4,'TRM','Tyre Maintenance','Perbaikan Ban',1,NULL,NULL),(5,'ICM','Incident','Insiden',1,NULL,NULL),(6,'RCM','Recommissioning','Recommissioning',1,NULL,NULL),(7,'ISM','Instrument','INSTRUMENT (RADIO JIGSAW /MMS/ DISPATCH/ EWACS AUTO RECORDING)',1,NULL,NULL);
/*!40000 ALTER TABLE `breakdown_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `breakdown_statuses`
--

DROP TABLE IF EXISTS `breakdown_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `breakdown_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breakdown_statuses`
--

LOCK TABLES `breakdown_statuses` WRITE;
/*!40000 ALTER TABLE `breakdown_statuses` DISABLE KEYS */;
INSERT INTO `breakdown_statuses` VALUES (1,'B/D','Breakdown','2018-04-08 08:33:13','2018-04-11 07:00:54'),(2,'RFU','RFU','2018-04-08 08:35:07','2018-04-11 07:01:00'),(3,'W/P','W/P','2018-04-11 07:01:08','2018-04-11 07:01:08');
/*!40000 ALTER TABLE `breakdown_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `breakdowns`
--

DROP TABLE IF EXISTS `breakdowns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `breakdowns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `breakdown_category_id` int(10) unsigned NOT NULL,
  `km` int(11) NOT NULL,
  `hm` int(11) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime DEFAULT NULL,
  `time_ready` datetime DEFAULT NULL,
  `diagnosa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tindakan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warning_part` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wo_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breakdown_status_id` int(10) unsigned DEFAULT NULL,
  `component_criteria_id` int(10) unsigned DEFAULT NULL,
  `update_pcr_time` datetime DEFAULT NULL,
  `time_close` datetime DEFAULT NULL,
  `update_pcr_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `breakdowns_unit_id_foreign` (`unit_id`),
  KEY `breakdowns_user_id_foreign` (`user_id`),
  KEY `breakdowns_location_id_foreign` (`location_id`),
  KEY `breakdowns_breakdown_category_id_foreign` (`breakdown_category_id`),
  KEY `breakdowns_breakdown_status_id_foreign` (`breakdown_status_id`),
  KEY `breakdowns_component_criteria_id_foreign` (`component_criteria_id`),
  CONSTRAINT `breakdowns_breakdown_category_id_foreign` FOREIGN KEY (`breakdown_category_id`) REFERENCES `breakdown_categories` (`id`),
  CONSTRAINT `breakdowns_breakdown_status_id_foreign` FOREIGN KEY (`breakdown_status_id`) REFERENCES `breakdown_statuses` (`id`),
  CONSTRAINT `breakdowns_component_criteria_id_foreign` FOREIGN KEY (`component_criteria_id`) REFERENCES `component_criterias` (`id`),
  CONSTRAINT `breakdowns_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  CONSTRAINT `breakdowns_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  CONSTRAINT `breakdowns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breakdowns`
--

LOCK TABLES `breakdowns` WRITE;
/*!40000 ALTER TABLE `breakdowns` DISABLE KEYS */;
INSERT INTO `breakdowns` VALUES (1,7,2,4,1000,1000,'2018-04-27 14:45:00','2018-04-27 14:45:00',NULL,'dwefef','ganti unitdwefwe',NULL,'dwefefw','21323',1,15,'2018-04-29 22:05:10',NULL,1,0,1,'2018-04-27 07:45:36','2018-04-29 15:05:10'),(2,27,5,5,100,100,'2018-04-27 20:29:00',NULL,NULL,'ok jos','dlkwjofjew',NULL,'dewfhj','222dkjwkdhwsss',NULL,20,'2018-04-27 21:13:48',NULL,1,0,1,'2018-04-27 13:30:00','2018-04-27 14:13:48'),(3,29,3,2,1000,1000,'2018-04-28 21:26:00',NULL,NULL,'dwefwefw',NULL,NULL,NULL,NULL,NULL,NULL,'2018-04-29 22:04:55',NULL,1,0,1,'2018-04-27 14:26:32','2018-04-29 15:04:55');
/*!40000 ALTER TABLE `breakdowns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buyers`
--

DROP TABLE IF EXISTS `buyers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buyers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buyers`
--

LOCK TABLES `buyers` WRITE;
/*!40000 ALTER TABLE `buyers` DISABLE KEYS */;
INSERT INTO `buyers` VALUES (1,'Bagas',NULL,NULL,NULL,NULL,'2018-04-21 06:42:56','2018-04-21 06:42:56');
/*!40000 ALTER TABLE `buyers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `component_criterias`
--

DROP TABLE IF EXISTS `component_criterias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `component_criterias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `component_criterias`
--

LOCK TABLES `component_criterias` WRITE;
/*!40000 ALTER TABLE `component_criterias` DISABLE KEYS */;
INSERT INTO `component_criterias` VALUES (4,'0000','Machine (Main Frame & Guard)',NULL,NULL),(5,'1000','Engine',NULL,NULL),(6,'2000','Clutch System/Coupler/',NULL,NULL),(7,'3000','Transmission',NULL,NULL),(8,'4000','Final Drive / Travel Motor',NULL,NULL),(9,'5000','Steering System',NULL,NULL),(10,'6000','Undercarriage',NULL,NULL),(11,'7000','Electrical System',NULL,NULL),(12,'7200','Brake System',NULL,NULL),(13,'7400','Suspension Sys',NULL,NULL),(14,'7600','Hydraulic System',NULL,NULL),(15,'7800','Pneumatic Sys',NULL,NULL),(16,'8500','Optional Accesor',NULL,NULL),(17,'9175','2000 Hour Service',NULL,NULL),(18,'9180','1000 Hour Service',NULL,NULL),(19,'9185','500 Hour Service',NULL,NULL),(20,'9190','250 Hour Service',NULL,NULL),(21,'INSIDEN','EX INCIDENT',NULL,NULL),(22,'TRANMISSION','TRANSMISI 7 + 10 KE 11 ERROR NETRAL',NULL,NULL),(23,'SUSPENSION SYS','SHAF BROKEN + BOGIE TRUNION LEPAS DARI RUMAHAN SAMBUNGANNYA / M',NULL,NULL),(24,'TYRE','FINAL DRIF TYRE NO 3 & 4 BOCOR(WILL HUB PATAH,BREAK DRUMM PPATAH, BREAK DRUM CRECK)',NULL,NULL),(25,'SUSPENSION SYS','CLUTH TIDAK BERFUNGSI',NULL,NULL),(26,'TYRE','WILL HUB TYRE NO 4 BROKEN ( MR . CAPUNG )',NULL,NULL),(27,'SERVICE','PS 250 + REPAIR COMMISIONING',NULL,NULL),(28,'SERVICE','REPAIR COMMISIONING',NULL,NULL),(29,'TYRE','TYRE NO 4 BOCOR / M',NULL,NULL),(30,'TYRE','TYRE NO 7,8 BOCOR',NULL,NULL),(31,'TYRE','TYRE NO 9 BOCOR',NULL,NULL),(32,'TYRE','TYRE NO 8 BOCOR',NULL,NULL),(33,'TYRE','TYRE NO 4 BOCOR',NULL,NULL),(34,'TYRE','TYRE NO 7 BOCOR',NULL,NULL);
/*!40000 ALTER TABLE `component_criterias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'PT. BRE - KPP',NULL,NULL,NULL,NULL,'2018-04-21 06:44:14','2018-04-30 04:18:16'),(2,'PT. BRE - HRS',NULL,NULL,NULL,NULL,'2018-04-30 04:18:30','2018-04-30 04:18:30'),(3,'PT. KPP - SALE',NULL,NULL,NULL,NULL,'2018-04-30 04:18:47','2018-04-30 04:18:47'),(4,'PT. PAMA',NULL,NULL,NULL,NULL,'2018-04-30 04:18:56','2018-04-30 04:18:56');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_check_settings`
--

DROP TABLE IF EXISTS `daily_check_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `daily_check_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `day` tinyint(1) NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_check_settings`
--

LOCK TABLES `daily_check_settings` WRITE;
/*!40000 ALTER TABLE `daily_check_settings` DISABLE KEYS */;
INSERT INTO `daily_check_settings` VALUES (1,0,26,1,'2018-04-30 08:03:52','2018-04-30 08:10:13'),(2,2,28,1,'2018-04-30 08:10:29','2018-04-30 08:11:34'),(3,3,23,1,'2018-04-30 13:23:13','2018-04-30 13:23:13'),(4,0,30,1,'2018-05-02 02:07:10','2018-05-02 02:07:10'),(5,1,8,1,'2018-05-02 02:08:16','2018-05-02 02:08:16');
/*!40000 ALTER TABLE `daily_check_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'HCD',NULL,1,'2018-04-15 02:39:46','2018-04-15 02:39:46'),(2,'Project Management',NULL,1,'2018-04-15 02:39:54','2018-04-15 02:39:54'),(3,'Engineering Site',NULL,1,'2018-04-15 02:40:08','2018-04-15 02:40:08'),(4,'Road & Hauling',NULL,1,'2018-04-15 02:40:16','2018-04-15 02:40:16'),(5,'Quarry Operation',NULL,1,'2018-04-15 02:40:24','2018-04-15 02:40:24'),(6,'Plant Site',NULL,1,'2018-04-15 02:40:45','2018-04-15 02:40:45'),(7,'HCGS',NULL,1,'2018-04-15 02:41:04','2018-04-15 02:41:04'),(8,'FAT',NULL,1,'2018-04-15 02:41:12','2018-04-15 02:41:12'),(9,'SM Site',NULL,1,'2018-04-15 02:41:20','2018-04-15 02:41:20'),(10,'SHE Site',NULL,1,'2018-04-15 02:41:27','2018-04-15 02:41:27'),(11,'Port Operation',NULL,1,'2018-04-15 02:41:41','2018-04-15 02:41:41');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `egis`
--

DROP TABLE IF EXISTS `egis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `egis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fc` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `egis`
--

LOCK TABLES `egis` WRITE;
/*!40000 ALTER TABLE `egis` DISABLE KEYS */;
INSERT INTO `egis` VALUES (1,'BL1500',NULL,1,'2018-04-15 02:33:01','2018-04-15 02:33:01',NULL),(2,'BL2000',NULL,1,'2018-04-15 02:33:11','2018-04-15 02:33:11',NULL),(3,'BL750',NULL,1,'2018-04-15 02:33:23','2018-04-15 02:33:23',NULL),(4,'FM220',NULL,1,'2018-04-15 02:33:32','2018-04-30 01:39:45',12),(5,'FN260',NULL,1,'2018-04-15 02:33:39','2018-04-30 01:39:31',12),(6,'GD705A4',NULL,1,'2018-04-15 02:33:46','2018-04-30 01:40:35',19),(7,'GD825',NULL,1,'2018-04-15 02:33:53','2018-04-30 01:40:56',25),(8,'P-420LA6X4',NULL,1,'2018-04-15 02:34:00','2018-04-30 01:41:51',12),(9,'P380CWB',NULL,1,'2018-04-15 02:34:07','2018-04-30 01:42:13',12),(10,'PC200',NULL,1,'2018-04-15 02:34:13','2018-04-30 01:39:13',15),(11,'SV512',NULL,1,'2018-04-15 02:34:20','2018-04-30 01:41:10',10),(12,'TB. ASSIST',NULL,1,'2018-04-15 02:34:27','2018-04-30 01:38:14',10),(13,'TZWTFM260',NULL,1,'2018-04-15 02:34:35','2018-04-30 01:38:54',5),(14,'WA5003',NULL,1,'2018-04-15 02:34:42','2018-04-30 01:40:01',35),(15,'WA6003',NULL,1,'2018-04-15 02:34:49','2018-04-30 01:40:19',53);
/*!40000 ALTER TABLE `egis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nrp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(10) unsigned NOT NULL,
  `position_id` int(10) unsigned NOT NULL,
  `owner_id` int(10) unsigned DEFAULT NULL,
  `office_id` int(10) unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employees_department_id_foreign` (`department_id`),
  KEY `employees_owner_id_foreign` (`owner_id`),
  KEY `employees_position_id_foreign` (`position_id`),
  KEY `employees_office_id_foreign` (`office_id`),
  CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  CONSTRAINT `employees_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`),
  CONSTRAINT `employees_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`id`),
  CONSTRAINT `employees_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'KA12022','H. ABRAR',5,1,NULL,NULL,1,NULL,NULL),(2,'KD11029','RAIDA RAHMADANI',4,1,NULL,NULL,1,NULL,NULL),(3,'KA06109','JUMARITO HARO',5,1,NULL,NULL,1,NULL,NULL),(4,'KC11024','MUHAMMAD ZAINUL ARIP',5,1,NULL,NULL,1,NULL,NULL),(5,'KC11099','WILDAN SHOLIHAN',5,1,NULL,NULL,1,NULL,NULL),(6,'KD11061','FEBRY KRESNA YUDHA',4,1,NULL,NULL,1,NULL,NULL),(7,'KD11058','EGAR RESTYADI',4,1,NULL,NULL,1,NULL,NULL),(8,'KE17076','DESTA HARDIANTO',4,1,NULL,NULL,1,NULL,NULL),(9,'KE17075','AGUS SLAMET RIYADI',4,1,NULL,NULL,1,NULL,NULL),(10,'KA12017','ANTOK SUTARYANTO',5,1,NULL,NULL,1,NULL,NULL),(11,'KE17081','HAVID DIDIT PRASETYO',11,1,NULL,NULL,1,NULL,NULL),(12,'KE17073','AHMAD BUSTOMI',11,1,NULL,NULL,1,NULL,NULL),(13,'KE17071','AMBAR FADOLI',11,1,NULL,NULL,1,NULL,NULL),(14,'KE17074','TRI KUSMIAJI',11,1,NULL,NULL,1,NULL,NULL),(15,'KE17013','RIZKI FARID SULISTIAN',11,1,NULL,NULL,1,NULL,NULL),(16,'KE17012',' FREDIYANTO',11,1,NULL,NULL,1,NULL,NULL),(17,'KE18005','SAHRIL SAFINGI',11,1,NULL,NULL,1,NULL,NULL),(18,'KE18006','SURYA AJI SUTIYONO',11,1,NULL,NULL,1,NULL,NULL),(19,'KE18009','SAID NUR ALIM',11,1,NULL,NULL,1,NULL,NULL),(20,'KE18007','KHOIRIL IMAM',11,1,NULL,NULL,1,NULL,NULL),(21,'KE18008',' PRASETIYO',11,1,NULL,NULL,1,NULL,NULL),(22,'KE18010','RYAN AGUS SALIM',11,1,NULL,NULL,1,NULL,NULL),(23,'KC11113',' SAPRIYADI',11,1,NULL,NULL,1,NULL,NULL),(24,'KC12005','OLO MARIANTO',11,1,NULL,NULL,1,NULL,NULL),(25,'KC12029',' SYARIFUDIN',11,1,NULL,NULL,1,NULL,NULL),(26,'KA12018','AHMAD FAUZI',11,1,NULL,NULL,1,NULL,NULL),(27,'KD13012','RIZA RIFANI',11,1,NULL,NULL,1,NULL,NULL),(28,'KC13018',' IMRAN',11,1,NULL,NULL,1,NULL,NULL),(29,'KC14019','AHMAD FADHILLAH',11,1,NULL,NULL,1,NULL,NULL),(30,'KC05093','RIDANI FAJRI',11,1,NULL,NULL,1,NULL,NULL),(31,'KC04131',' AKHYAR',11,1,NULL,NULL,1,NULL,NULL),(32,'KC06018','FAJAR SETYAWAN',11,1,NULL,NULL,1,NULL,NULL),(33,'KC06058',' IRWAN',11,1,NULL,NULL,1,NULL,NULL),(34,'KC09010','DODDY PRAMANA PUTRA',11,1,NULL,NULL,1,NULL,NULL),(35,'KC04119',' HUSNI',11,1,NULL,NULL,1,NULL,NULL),(36,'KC09062',' HAIRULLAH',11,1,NULL,NULL,1,NULL,NULL),(37,'KC08138','BASUKI RAHMAN',11,1,NULL,NULL,1,NULL,NULL),(38,'KC04137',' SABERAN',11,1,NULL,NULL,1,NULL,NULL),(39,'KC04150',' DARMAN',11,1,NULL,NULL,1,NULL,NULL),(40,'KE17014','YOGA ADI PRADANA',5,1,NULL,NULL,1,NULL,NULL),(41,'KC13036','AHMAD MAULANA',5,1,NULL,NULL,1,NULL,NULL),(42,'KC13031','AHMAD HARIS',5,1,NULL,NULL,1,NULL,NULL),(43,'KE17015','DENI MAULANA SAPUTRA',5,1,NULL,NULL,1,NULL,NULL),(44,'KC07071','DIDI SUPRIADI',5,1,NULL,NULL,1,NULL,NULL),(45,'KC07048','RUSTAM EFFENDI',5,1,NULL,NULL,1,NULL,NULL),(46,'KC11003','MOEHAMMAD AGUNG WIJAYA',11,2,NULL,NULL,1,NULL,NULL),(47,'KC11004','NURMAN KAIMUDDIN',11,2,NULL,NULL,1,NULL,NULL),(48,'KC11009',' MAHYUNI',11,2,NULL,NULL,1,NULL,NULL),(49,'KC11011','NYOMAN SUPRIANTO',11,2,NULL,NULL,1,NULL,NULL),(50,'KC11012','RIFKY MAIDI',11,2,NULL,NULL,1,NULL,NULL),(51,'KC11119',' SUPIANI',11,2,NULL,NULL,1,NULL,NULL),(52,'KC12113','EKO PANJI ERWANTO',11,2,NULL,NULL,1,NULL,NULL),(53,'KC11123',' SOLIKIN',11,2,NULL,NULL,1,NULL,NULL),(54,'KC11121','AKHMAD YANI',11,2,NULL,NULL,1,NULL,NULL),(55,'KC11120',' MUGITO',11,2,NULL,NULL,1,NULL,NULL),(56,'KC11111','RAHMAT DARMAJI',6,3,NULL,NULL,1,NULL,NULL),(57,'KC05106',' ILMAN',6,3,NULL,NULL,1,NULL,NULL),(58,'KC12033','TAUFIK BAHTIAR',6,3,NULL,NULL,1,NULL,NULL),(59,'KE17035','DANANG KURNIAWAN',6,3,NULL,NULL,1,NULL,NULL),(60,'KE17037','GUNAWAN PRASETYAN',6,3,NULL,NULL,1,NULL,NULL),(61,'KC10042','ERY ERYADI SURIANSYAH',6,3,NULL,NULL,1,NULL,NULL),(62,'KC10010','NUR KHOLIS',6,3,NULL,NULL,1,NULL,NULL),(63,'KC12097','BAGUS ARIFIANTO',6,3,NULL,NULL,1,NULL,NULL),(64,'KC17051','RAFI ACHMAD RIZAL',6,3,NULL,NULL,1,NULL,NULL),(65,'KC11005','AGUS PERDANA',6,3,NULL,NULL,1,NULL,NULL),(66,'KC12096','ALFIAN NUR BARWIANTO',6,3,NULL,NULL,1,NULL,NULL),(67,'KE17100','SYAHRUL EKO PRASETYO',6,3,NULL,NULL,1,NULL,NULL),(68,'KC13063',' RAMLAN',6,3,NULL,NULL,1,NULL,NULL),(69,'KC17048','HASAN WIDI SAMPORNO',6,3,NULL,NULL,1,NULL,NULL),(70,'KC05107','MAULANA MAS\'UD',6,3,NULL,NULL,1,NULL,NULL),(71,'KC10041','ANTUNG MUHAMAD RAHMIN YAMANIE',6,3,NULL,NULL,1,NULL,NULL),(72,'KE17082','ADI YULIANTO',6,3,NULL,NULL,1,NULL,NULL),(73,'KC11122','ABDUL WAHID ALAMSYAH',11,4,NULL,NULL,1,NULL,NULL),(74,'KC10038','DEDY RIAN ANDRIADI',11,4,NULL,NULL,1,NULL,NULL),(75,'KC04130',' SUGIANTO',11,4,NULL,NULL,1,NULL,NULL),(76,'KC10016','AHMAD RABBANI',11,4,NULL,NULL,1,NULL,NULL),(77,'KC14012','AKHMAD SALAM',5,5,NULL,NULL,1,NULL,NULL),(78,'KC09060','EVA MAYA SARI',8,6,NULL,NULL,1,NULL,NULL),(79,'KC14014','ISMAIL NOOR',5,7,NULL,NULL,1,NULL,NULL),(80,'KC14013',' KASTHOLANI',5,7,NULL,NULL,1,NULL,NULL),(81,'KC14016','IWAN MAULANA',5,7,NULL,NULL,1,NULL,NULL),(82,'KC14015','RIYAN RAHMATULLAH',5,7,NULL,NULL,1,NULL,NULL),(83,'KC17021',' BALDI',3,8,NULL,NULL,1,NULL,NULL),(84,'KC11006','IQBAL ARIADI',3,9,NULL,NULL,1,NULL,NULL),(85,'KA06070',' RUSMILA',8,10,NULL,NULL,1,NULL,NULL),(86,'KD11001','RIZKAN NOOR',9,11,NULL,NULL,1,NULL,NULL),(87,'KB15006','AJI SETIAWAN',7,12,NULL,NULL,1,NULL,NULL),(88,'KC13057',' MURJANI',7,13,NULL,NULL,1,NULL,NULL),(89,'KQ17001','IMAM SAMRONI',2,14,NULL,NULL,1,NULL,NULL),(90,'KC04114',' RAIDA',9,15,NULL,NULL,1,NULL,NULL),(91,'KB11070','MUHAMMAD HIJAZ',9,16,NULL,NULL,1,NULL,NULL),(92,'KB16014',' SURAHMAN',2,17,NULL,NULL,1,NULL,NULL),(93,'KB13037','KRISNA DWI NURCAHYO',7,18,NULL,NULL,1,NULL,NULL),(94,'KC07103','AMIR MAHMUDI',3,19,NULL,NULL,1,NULL,NULL),(95,'KC17014',' HAEYUN',7,20,NULL,NULL,1,NULL,NULL),(96,'KC14017','NANA SUHARYANA',7,21,NULL,NULL,1,NULL,NULL),(97,'KD10001','MUHAMMAD FIRMANSYAH',6,22,NULL,NULL,1,NULL,NULL),(98,'KC11061',' SUYANTO',5,23,NULL,NULL,1,NULL,NULL),(99,'KC15017','DAUD NAPOLEON HUTAPEA',6,23,NULL,NULL,1,NULL,NULL),(100,'KC15008','MANSYUR KHALAJ',6,23,NULL,NULL,1,NULL,NULL),(101,'6106417','EDY EKO WIBOWO',6,23,NULL,NULL,1,NULL,NULL),(102,'KA11001','DAUD SIMANJUNTAK',5,23,NULL,NULL,1,NULL,NULL),(103,'1490017',' HARTONO',6,24,NULL,NULL,1,NULL,NULL),(104,'191149','TOTO SURYANTO',6,25,NULL,NULL,1,NULL,NULL),(105,'KC12037','HARIS FADILLAH MUSLIM',11,26,NULL,NULL,1,NULL,NULL),(106,'KB10050','RONY KURNIA',11,26,NULL,NULL,1,NULL,NULL),(107,'KC17027','PAUZAN AHKYAR',11,26,NULL,NULL,1,NULL,NULL),(108,'KC12036',' KASRAN',11,26,NULL,NULL,1,NULL,NULL),(109,'KC04096','MUHAMMAD YUSUF DJIUN',11,27,NULL,NULL,1,NULL,NULL),(110,'KA05048','MAHDI SYARIF',5,28,NULL,NULL,1,NULL,NULL),(111,'KB17002','ADISWIRA REZKY SINAGA',5,28,NULL,NULL,1,NULL,NULL),(112,'KB11005','AGUSMAN KOTO',5,28,NULL,NULL,1,NULL,NULL),(113,'KC04115','AMIRIL ANWAR',9,29,NULL,NULL,1,NULL,NULL),(114,'KC16006',' KHAIRUDIN',9,29,NULL,NULL,1,NULL,NULL),(115,'KB04003','MUS MUAYYAD',5,30,NULL,NULL,1,NULL,NULL),(116,'KD11054',' YUSRAN',5,31,NULL,NULL,1,NULL,NULL),(117,'KC11072','KHAIZUN TAFDILLAH',5,31,NULL,NULL,1,NULL,NULL),(118,'KA08053',' MUJIANTO',5,31,NULL,NULL,1,NULL,NULL),(119,'KA12031','RIYO HANDOKO',5,31,NULL,NULL,1,NULL,NULL),(120,'KA12029','M. KURNIAWAN',5,31,NULL,NULL,1,NULL,NULL),(121,'KA11063','EKO PURWANTO',5,31,NULL,NULL,1,NULL,NULL),(122,'KE17134','TEGUH TRIONO',5,31,NULL,NULL,1,NULL,NULL),(123,'KE17133','RIO SILVA DE GUSTA',5,31,NULL,NULL,1,NULL,NULL),(124,'KC17037',' RAMLANSYAH',5,31,NULL,NULL,1,NULL,NULL),(125,'KC17041',' SUTONO',5,31,NULL,NULL,1,NULL,NULL),(126,'KC17036','RIZKY ANDI SETIAWAN',5,31,NULL,NULL,1,NULL,NULL),(127,'KC17038','IHSAN NUR RAHMAN',5,31,NULL,NULL,1,NULL,NULL),(128,'KB08006','SEPTI AJI NUGROHO',2,32,NULL,NULL,1,NULL,NULL),(129,'KC17026','M SYAIFUL RAHMAN',4,33,NULL,NULL,1,NULL,NULL),(130,'KA13014',' HERLIANTO',4,33,NULL,NULL,1,NULL,NULL),(131,'KC09055','MUHAMMAD SYAIPULLAH',4,33,NULL,NULL,1,NULL,NULL),(132,'KC12062',' FAILI',4,33,NULL,NULL,1,NULL,NULL),(133,'KC10015',' HAYUN',7,34,NULL,NULL,1,NULL,NULL),(134,'KB13017','M. TAUFIQURROHMAN NOOR',10,35,NULL,NULL,1,NULL,NULL),(135,'KB11030','AMIN YAKUP',10,35,NULL,NULL,1,NULL,NULL),(136,'KB17021','HERWIN MANURUNG',10,35,NULL,NULL,1,NULL,NULL),(137,'KB16023','FAIZAL RIDHO ALFIANTO',10,35,NULL,NULL,1,NULL,NULL),(138,'KC17009','MUHAMMAD NUR FAUZI RACHMAN',3,36,NULL,NULL,1,NULL,NULL),(139,'KB12104','AGUS PRADANA',6,37,NULL,NULL,1,NULL,NULL),(140,'KC11092','ANGGA FITRI APRIANTO',6,38,NULL,NULL,1,NULL,NULL),(141,'KC12094','WARIS WAHDANI',6,38,NULL,NULL,1,NULL,NULL),(142,'KC12093','ACH RIFQI NURHALIM',6,38,NULL,NULL,1,NULL,NULL),(143,'KC12095','MUHAMMAD SAID',6,38,NULL,NULL,1,NULL,NULL),(144,'KC12032','DEKA ANGGA PRATAMA',6,38,NULL,NULL,1,NULL,NULL),(145,'KE17130','WAHYU PRIHATIN',6,38,NULL,NULL,1,NULL,NULL),(146,'KE17099',' SUHARTO',6,38,NULL,NULL,1,NULL,NULL),(147,'KE17102','YUSUF MUSTOFA',6,38,NULL,NULL,1,NULL,NULL),(148,'KE17098','SOBIRIN GUNAWAN',6,38,NULL,NULL,1,NULL,NULL),(149,'KE17101','TAJUDIN NURUL AMIN',6,38,NULL,NULL,1,NULL,NULL),(150,'KC17039','GUSHUDA ACHMANDANI',6,38,NULL,NULL,1,NULL,NULL),(151,'KE17131','TOMI YULIARDI',6,38,NULL,NULL,1,NULL,NULL),(152,'KC07008','HENDRA ARIYANTO',11,39,NULL,NULL,1,NULL,NULL),(153,'KC08078','YOUDHY PARMANA RAMPAY',11,39,NULL,NULL,1,NULL,NULL),(154,'KC13056',' RAIDIN',11,39,NULL,NULL,1,NULL,NULL),(155,'KB17125','IMAM MARDHATILLAH',11,39,NULL,NULL,1,NULL,NULL),(156,'KC15003','IWAN SURYA FIRDAUS',9,40,NULL,NULL,1,NULL,NULL),(157,'KA08064','AGUNG KRISTIYANTO SUBAKTI',9,41,NULL,NULL,1,NULL,NULL),(158,'KB17122','SATRIO LIBA PAMUNGKAS',1,42,NULL,NULL,1,NULL,NULL),(159,'KB17084','ARIQ ARSYA NANDA',1,43,NULL,NULL,1,NULL,NULL),(160,'KB17126','BENDI OKTARANDO',1,43,NULL,NULL,1,NULL,NULL),(161,'KB17128','YOGA PRANATA',1,43,NULL,NULL,1,NULL,NULL),(162,'KB17142','TOMY DEWANTARA PUTRA',1,44,NULL,NULL,1,NULL,NULL),(163,'KB18037','CHANDRA JATI KUSUMA',1,44,NULL,NULL,1,NULL,NULL),(164,'KB17090','IWAN PERDANA PUTRA',1,44,NULL,NULL,1,NULL,NULL),(165,'KB17093','PRIME HANDY SETYANA',1,45,NULL,NULL,1,NULL,NULL),(166,'KB18004','IBNU ARSAL N',1,45,NULL,NULL,1,NULL,NULL),(167,'KB17104','ADAM WISNU WARDANA',1,46,NULL,NULL,1,NULL,NULL),(168,'KB17087','EKO ARISANA ISMAWAN',1,46,NULL,NULL,1,NULL,NULL),(169,'KC17042','WAHYU KALIS TRI ATMOJO',5,47,NULL,NULL,1,NULL,NULL),(170,'KC11110','DEDE SAPUTRA',6,47,NULL,NULL,1,NULL,NULL),(171,'KC09075',' HERWANTO',6,47,NULL,NULL,1,NULL,NULL),(172,'KA08095','MUHAMMAD ILIS',6,47,NULL,NULL,1,NULL,NULL),(173,'KA08049','ANDI EDY HARYANTO',6,47,NULL,NULL,1,NULL,NULL),(174,'KE17034','ANDI SULISTYO PRANOTO',6,47,NULL,NULL,1,NULL,NULL),(175,'KC13055','MUKHAMAD SAMSUL ARIF',6,47,NULL,NULL,1,NULL,NULL),(176,'KC12091','MUHAMMAD BASRI',6,47,NULL,NULL,1,NULL,NULL),(177,'KE17036','EDY SUTOMO',6,47,NULL,NULL,1,NULL,NULL),(178,'KE17132','PRESA SANDERA',6,47,NULL,NULL,1,NULL,NULL),(179,'KE17129','KHOLIQ RIBUT SASONGKO',6,47,NULL,NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fuel_tanks`
--

DROP TABLE IF EXISTS `fuel_tanks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fuel_tanks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` decimal(8,3) NOT NULL,
  `stock` decimal(8,3) DEFAULT NULL,
  `last_stock_time` datetime DEFAULT NULL,
  `last_position_time` datetime DEFAULT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `altitude` decimal(6,2) DEFAULT NULL,
  `heading` decimal(5,2) DEFAULT NULL,
  `speed` decimal(5,2) DEFAULT NULL,
  `accuracy` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fuel_tanks`
--

LOCK TABLES `fuel_tanks` WRITE;
/*!40000 ALTER TABLE `fuel_tanks` DISABLE KEYS */;
INSERT INTO `fuel_tanks` VALUES (1,'MAIN TANK Besar',NULL,2500.000,2222.000,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-04-09 06:31:52','2018-04-24 06:07:40'),(2,'MAIN TANK SARANA',NULL,2000.000,1500.000,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-04-14 08:46:04','2018-04-14 09:05:55'),(3,'FT007',NULL,3000.000,1576.000,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-04-14 08:46:21','2018-04-24 06:07:00');
/*!40000 ALTER TABLE `fuel_tanks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jabatans`
--

DROP TABLE IF EXISTS `jabatans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jabatans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jabatans`
--

LOCK TABLES `jabatans` WRITE;
/*!40000 ALTER TABLE `jabatans` DISABLE KEYS */;
INSERT INTO `jabatans` VALUES (1,'Operator',NULL,'2018-04-08 08:57:40','2018-04-11 06:34:34'),(2,'Road Maintenance',NULL,'2018-04-11 06:34:46','2018-04-11 06:34:46'),(3,'HCGS',NULL,'2018-04-11 06:34:56','2018-04-11 06:34:56'),(4,'KPP',NULL,'2018-04-11 06:35:01','2018-04-11 06:35:01'),(5,'Perusahaan',NULL,'2018-04-11 06:35:15','2018-04-11 06:35:20'),(6,'Hauling',NULL,'2018-04-11 06:35:24','2018-04-11 06:35:24');
/*!40000 ALTER TABLE `jabatans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jetties`
--

DROP TABLE IF EXISTS `jetties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jetties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jetties`
--

LOCK TABLES `jetties` WRITE;
/*!40000 ALTER TABLE `jetties` DISABLE KEYS */;
INSERT INTO `jetties` VALUES (1,'H',NULL,'2018-04-21 06:44:22','2018-04-30 04:21:49',700),(2,'U',NULL,'2018-04-21 06:50:02','2018-04-30 04:21:55',700),(3,'J',NULL,'2018-04-21 06:50:05','2018-04-30 04:22:02',1200),(4,'K',NULL,'2018-04-21 06:50:09','2018-04-30 04:22:08',1200);
/*!40000 ALTER TABLE `jetties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'KM 0',NULL,'2018-04-08 08:59:13','2018-04-11 06:35:50'),(2,'KM 1',NULL,'2018-04-11 06:36:54','2018-04-11 06:36:54'),(3,'KM 2',NULL,'2018-04-11 06:36:58','2018-04-11 06:36:58'),(4,'KM 3',NULL,'2018-04-11 06:37:02','2018-04-11 06:37:02'),(5,'KM 4',NULL,'2018-04-11 06:37:08','2018-04-11 06:37:08'),(6,'KM 19',NULL,'2018-05-02 07:38:02','2018-05-02 07:38:02'),(7,'KM 20',NULL,'2018-05-02 07:38:06','2018-05-02 07:38:06');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lost_time_categories`
--

DROP TABLE IF EXISTS `lost_time_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lost_time_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lost_time_categories`
--

LOCK TABLES `lost_time_categories` WRITE;
/*!40000 ALTER TABLE `lost_time_categories` DISABLE KEYS */;
INSERT INTO `lost_time_categories` VALUES (3,'D01','Pre Used Check',1,NULL,NULL),(4,'D02','Fuel & Lubrication',1,NULL,NULL),(5,'D03','Tyre Check',1,NULL,NULL),(6,'D04','Moving Equipment',1,NULL,NULL),(7,'D05','Waiting Equipment',1,NULL,NULL),(8,'D06','Waiting Engineering',1,NULL,NULL),(9,'D07','Waiting Blasting',1,NULL,NULL),(10,'D08','Cleaning Equipment',1,NULL,NULL),(11,'D09','Meal & Rest',1,NULL,NULL),(12,'D10','Safety Check',1,NULL,NULL),(13,'D11','Standby by Request',1,NULL,NULL),(14,'D12','Waiting Operator',1,NULL,NULL),(15,'D13','Change Shift',1,NULL,NULL),(16,'D14','Dusty',1,NULL,NULL),(17,'D15','Praying',1,NULL,NULL),(18,'D16','Pit Stop',1,NULL,NULL),(19,'D17','Other',1,NULL,NULL),(20,'D21','Queuing at ROM',1,NULL,NULL),(21,'D22','Queuing at Port',1,NULL,NULL),(22,'D23','Queuing at Halte / Waiting Quota',1,NULL,NULL),(23,'D24','Queuing at Weight Bridge',1,NULL,NULL),(24,'D31','In - Out Jetty',1,NULL,NULL),(25,'D32','Shifting Barge',1,NULL,NULL),(26,'D33','Geser Barge',1,NULL,NULL),(27,'D34','Stock Cargo',1,NULL,NULL),(28,'D35','Unshifting Barge',1,NULL,NULL),(29,'I15','Rain',1,NULL,NULL),(30,'I16','Force Major & Need Verification',1,NULL,NULL),(31,'I17','Slippery',1,NULL,NULL),(32,'I18','Strike',1,NULL,NULL),(33,'I19','Customer Problem',1,NULL,NULL),(34,'I20','Bad Visibility',1,NULL,NULL),(35,'I41','Fail Barge',1,NULL,NULL);
/*!40000 ALTER TABLE `lost_time_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materials`
--

DROP TABLE IF EXISTS `materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materials`
--

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
INSERT INTO `materials` VALUES (2,'AW','After Wash','2018-04-08 09:04:04','2018-04-10 18:06:34'),(3,'BDG','Bedding Coal','2018-04-08 09:04:09','2018-04-10 18:06:49'),(4,'BT','Batu','2018-04-10 18:07:02','2018-04-10 18:07:02'),(5,'CC','Coal Cleaing','2018-04-10 18:07:16','2018-04-10 18:07:16');
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(4,'2018_03_29_142405_create_departments_table',2),(5,'2018_03_29_143024_create_equipment_categories_table',2),(6,'2018_03_29_143323_create_alocation_categories_table',3),(7,'2018_03_29_143357_create_bagians_table',4),(8,'2018_03_29_143447_create_breakdown_categories_table',5),(9,'2018_03_29_143636_create_staff_categories_table',6),(10,'2018_03_29_143735_create_egis_table',7),(11,'2018_03_29_143918_create_employees_table',8),(12,'2018_03_29_144150_create_positions_table',9),(13,'2018_03_29_144159_create_owners_table',9),(14,'2018_03_29_144212_create_offices_table',9),(15,'2018_03_29_144303_create_equipment_table',10),(16,'2018_03_29_144450_create_fuel_tanks_table',11),(17,'2018_03_29_145001_create_locations_table',12),(18,'2018_03_29_145112_create_lost_time_categories_table',13),(19,'2018_03_29_145312_create_jabatans_table',14),(20,'2018_03_29_145549_create_units_table',15),(21,'2018_03_29_145622_create_sub_units_table',16),(22,'2018_03_29_145710_create_materials_table',17),(23,'2018_03_29_145826_create_plan_categories_table',18),(24,'2018_03_29_145927_create_problem_productivity_categories_table',19),(25,'2018_03_29_150017_create_stop_working_predictions_table',20),(26,'2018_03_29_150136_create_supervising_predictions_table',21),(27,'2018_03_29_150339_create_breakdown_statuses_table',21),(28,'2018_03_29_150635_create_component_criterias_table',22),(30,'2018_04_10_134521_add_role_on_user',23),(31,'2018_04_10_140137_create_breakdowns_table',24),(32,'2018_04_17_060315_create_prajobs_table',25),(33,'2018_04_18_011934_create_terminal_absensis_table',26),(34,'2018_04_18_015655_add_unit_category_on_unit',27),(35,'2018_04_18_095420_change_nullable_breakdown_table',28),(36,'2018_04_20_043237_add_foreign_key_on_unit',29),(37,'2018_04_20_055433_add_foreign_key_on_employee',30),(38,'2018_04_20_055752_add_foreign_key_on_breakdowns',31),(39,'2018_04_20_061333_add_foreign_key_on_prajobs',32),(40,'2018_04_20_062358_create_pitstops_table',33),(41,'2018_04_21_125921_create_barges_table',34),(42,'2018_04_21_125939_create_jetties_table',34),(43,'2018_04_21_130020_create_customers_table',34),(44,'2018_04_21_130120_create_buyers_table',34),(45,'2018_04_21_130127_create_cargos_table',34),(46,'2018_04_23_063907_create_authorizations_table',35),(47,'2018_04_23_075119_change_user_schame',36),(48,'2018_04_25_073013_add_anchored_on_barge',37),(49,'2018_04_25_144756_add_api_token_on_user',38),(50,'2018_04_26_050042_create_running_texts_table',39),(51,'2018_04_28_101603_create_areas_table',40),(52,'2018_04_28_101630_create_sub_areas_table',40),(53,'2018_04_30_083120_add_fc_on_egi',41),(54,'2018_04_30_111516_add_capacity_on_barge',42),(55,'2018_04_30_111954_add_capacity_on_jetties',43),(56,'2018_04_30_112400_create_seams_table',44),(58,'2018_04_30_113426_create_port_activities_table',45),(59,'2018_04_30_131414_create_stock_balanceds_table',45),(60,'2018_04_30_144701_create_daily_check_settings_table',45);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offices`
--

DROP TABLE IF EXISTS `offices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offices`
--

LOCK TABLES `offices` WRITE;
/*!40000 ALTER TABLE `offices` DISABLE KEYS */;
INSERT INTO `offices` VALUES (2,'KPP',NULL,'2018-04-08 15:44:36','2018-04-15 06:46:24');
/*!40000 ALTER TABLE `offices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `owners`
--

DROP TABLE IF EXISTS `owners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `owners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `owners`
--

LOCK TABLES `owners` WRITE;
/*!40000 ALTER TABLE `owners` DISABLE KEYS */;
INSERT INTO `owners` VALUES (1,'KPP',NULL,'2018-04-15 02:29:02','2018-04-15 02:29:02'),(2,'BSB',NULL,'2018-04-15 02:29:08','2018-04-15 02:29:08'),(3,'BBA',NULL,'2018-04-15 02:29:17','2018-04-15 02:29:17'),(4,'BEM',NULL,'2018-04-15 02:29:22','2018-04-15 02:29:22'),(5,'SSP',NULL,'2018-04-15 02:29:34','2018-04-15 02:29:34'),(6,'BPU',NULL,'2018-04-15 02:29:45','2018-04-15 02:29:45'),(7,'TJ',NULL,'2018-04-15 02:29:49','2018-04-15 02:29:49');
/*!40000 ALTER TABLE `owners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pitstops`
--

DROP TABLE IF EXISTS `pitstops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pitstops` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `shift` tinyint(1) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hm` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pitstops_unit_id_foreign` (`unit_id`),
  KEY `pitstops_user_id_foreign` (`user_id`),
  KEY `pitstops_location_id_foreign` (`location_id`),
  CONSTRAINT `pitstops_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  CONSTRAINT `pitstops_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  CONSTRAINT `pitstops_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pitstops`
--

LOCK TABLES `pitstops` WRITE;
/*!40000 ALTER TABLE `pitstops` DISABLE KEYS */;
INSERT INTO `pitstops` VALUES (1,7,1,1,'2018-04-12 15:06:00','2018-04-13 15:06:00','fefewfew',1000,1,0,'2018-04-27 08:07:10','2018-04-27 09:12:09');
/*!40000 ALTER TABLE `pitstops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan_categories`
--

DROP TABLE IF EXISTS `plan_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plan_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_categories`
--

LOCK TABLES `plan_categories` WRITE;
/*!40000 ALTER TABLE `plan_categories` DISABLE KEYS */;
INSERT INTO `plan_categories` VALUES (1,'Pre Use Check',NULL,NULL,NULL),(2,'Tyre Check',NULL,NULL,NULL),(3,'Cleaning Equipment',NULL,NULL,NULL),(4,'Meal & Rest',NULL,NULL,NULL),(5,'Safety Check',NULL,NULL,NULL),(6,'Standby by Request',NULL,NULL,NULL),(7,'Waiting Operator',NULL,NULL,NULL),(8,'Change Shift ( P5M, Safety Talk )',NULL,NULL,NULL),(9,'Jam Tanggung',NULL,NULL,NULL),(10,'Dusty',NULL,NULL,NULL),(11,'Praying',NULL,NULL,NULL),(12,'Pit Stop ( Integrated )',NULL,NULL,NULL),(13,'Queuing at ROM',NULL,NULL,NULL),(14,'Queuing at Port',NULL,NULL,NULL),(15,'Queuing at Weight Bridge',NULL,NULL,NULL),(16,'Rain',NULL,NULL,NULL),(17,'Force Majour & Need Verification',NULL,NULL,NULL),(18,'Slippery',NULL,NULL,NULL),(19,'Strike',NULL,NULL,NULL),(20,'Customer Problem',NULL,NULL,NULL),(21,'Bad Visibility',NULL,NULL,NULL);
/*!40000 ALTER TABLE `plan_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `port_activities`
--

DROP TABLE IF EXISTS `port_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `port_activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `date` date NOT NULL,
  `from_area` int(10) unsigned NOT NULL,
  `from_sub_area` int(10) unsigned NOT NULL,
  `to_area` int(10) unsigned NOT NULL,
  `to_sub_area` int(10) unsigned NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `volume` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `port_activities`
--

LOCK TABLES `port_activities` WRITE;
/*!40000 ALTER TABLE `port_activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `port_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `positions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
INSERT INTO `positions` VALUES (1,'A2B/TP OPERATOR',NULL,'2018-04-15 02:43:11','2018-04-15 02:43:11'),(2,'BARGE LOADER CONTROLLER',NULL,'2018-04-15 02:43:21','2018-04-15 02:43:21'),(3,'BARGE LOADER MECHANIC',NULL,'2018-04-15 02:43:29','2018-04-15 02:43:29'),(4,'BARGE MASTER',NULL,'2018-04-15 02:43:36','2018-04-15 02:43:36'),(5,'BLASTER',NULL,'2018-04-15 02:43:43','2018-04-15 02:43:43'),(6,'CASHIER SITE',NULL,'2018-04-15 02:43:50','2018-04-15 02:43:50'),(7,'CRUSHER CONTROLLER',NULL,'2018-04-15 02:43:58','2018-04-15 02:43:58'),(8,'DATA PROCESSOR',NULL,'2018-04-15 02:44:06','2018-04-15 02:44:06'),(9,'FIELD & INFRASTRUCTURE ENGINEER',NULL,'2018-04-15 02:45:40','2018-04-15 02:45:40'),(10,'FINANCE, ACCOUNTING & TAX SECT. HEAD',NULL,'2018-04-15 02:45:54','2018-04-15 02:45:54'),(11,'FUEL & OIL GL',NULL,'2018-04-15 02:46:02','2018-04-15 02:46:02'),(12,'GS & CIVIL CONSTRUCTION GL',NULL,'2018-04-15 02:46:10','2018-04-15 02:46:10'),(13,'HCGS SECTION HEAD',NULL,'2018-04-15 02:46:20','2018-04-15 02:46:20'),(14,'ICT OFFICER',NULL,'2018-04-15 02:46:26','2018-04-15 02:46:26'),(15,'INVENTORY CONTROLLER',NULL,'2018-04-15 02:46:33','2018-04-15 02:46:33'),(16,'INVENTORY GL',NULL,'2018-04-15 02:46:41','2018-04-15 02:46:41'),(17,'MD OFFICER',NULL,'2018-04-15 02:46:48','2018-04-15 02:46:48'),(18,'MECH INSTRUCTOR',NULL,'2018-04-15 02:46:55','2018-04-15 02:46:55'),(19,'MONITOR CONTROL SECTION HEAD',NULL,'2018-04-15 02:47:01','2018-04-15 02:47:01'),(20,'OPR INSTRUCTOR',NULL,'2018-04-15 02:47:07','2018-04-15 02:47:07'),(21,'PAYROLL SITE OFFICER',NULL,'2018-04-15 02:47:14','2018-04-15 02:47:14'),(22,'PLANNER',NULL,'2018-04-15 02:47:19','2018-04-15 02:47:19'),(23,'PLANT GL',NULL,'2018-04-15 02:47:26','2018-04-15 02:47:26'),(24,'PLANT SECT. HEAD',NULL,'2018-04-15 02:47:34','2018-04-15 02:47:34'),(25,'PLANT SITE DEPT. HEAD',NULL,'2018-04-15 02:47:40','2018-04-15 02:47:40'),(26,'PORT HANDLING GL',NULL,'2018-04-15 02:47:48','2018-04-15 02:47:48'),(27,'PORT OPERATION SECT. HEAD',NULL,'2018-04-15 02:47:55','2018-04-15 02:47:55'),(28,'PRODUCTION GL',NULL,'2018-04-15 02:48:02','2018-04-15 02:48:02'),(29,'PURCHASER',NULL,'2018-04-15 02:48:10','2018-04-15 02:48:10'),(30,'QUARRY OPERATION DEPT. HEAD',NULL,'2018-04-15 02:48:16','2018-04-15 02:48:16'),(31,'QUARRY OPERATION MECHANIC',NULL,'2018-04-15 02:48:24','2018-04-15 02:48:24'),(32,'RANTAU PORT DPM',NULL,'2018-04-15 02:48:31','2018-04-15 02:48:31'),(33,'ROAD MAINTENANCE GL',NULL,'2018-04-15 02:48:38','2018-04-15 02:48:38'),(34,'SECURITY CHIEF',NULL,'2018-04-15 02:48:45','2018-04-15 02:48:45'),(35,'SHE SITE OFFICER',NULL,'2018-04-15 02:48:53','2018-04-15 02:48:53'),(36,'SHIPPING PLANNER',NULL,'2018-04-15 02:49:01','2018-04-15 02:49:01'),(37,'SITE TECHNICAL DEVELOPMENT',NULL,'2018-04-15 02:49:08','2018-04-15 02:49:08'),(38,'SSE MECHANIC',NULL,'2018-04-15 02:49:14','2018-04-15 02:49:14'),(39,'STOCKPILE GL',NULL,'2018-04-15 02:49:22','2018-04-15 02:49:22'),(40,'SUBCONTRACTOR MANAGEMENT SITE OFFICER',NULL,'2018-04-15 02:49:29','2018-04-15 02:49:29'),(41,'SUPPLY MANAGEMENT SITE DEPT. HEAD',NULL,'2018-04-15 02:49:35','2018-04-15 02:49:35'),(42,'TRAINEE FAT',NULL,'2018-04-15 02:49:42','2018-04-15 02:49:42'),(43,'TRAINEE HC',NULL,'2018-04-15 02:49:48','2018-04-15 02:49:48'),(44,'TRAINEE OPERATION',NULL,'2018-04-15 02:49:55','2018-04-15 02:49:55'),(45,'TRAINEE SHE',NULL,'2018-04-15 02:50:01','2018-04-15 02:50:01'),(46,'TRAINEE TC',NULL,'2018-04-15 02:50:09','2018-04-15 02:50:09'),(47,'WHEEL TYPE MECHANIC',NULL,'2018-04-15 02:50:18','2018-04-15 02:50:18');
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prajobs`
--

DROP TABLE IF EXISTS `prajobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prajobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) unsigned NOT NULL,
  `tgl` date NOT NULL,
  `shift` tinyint(4) NOT NULL,
  `jam_tidur` time NOT NULL,
  `jam_tidur_kemarin` time NOT NULL,
  `jam_bangun` time NOT NULL,
  `jam_bangun_kemarin` time NOT NULL,
  `minum_obat` tinyint(1) NOT NULL,
  `ada_masalah` tinyint(1) NOT NULL,
  `siap_bekerja` tinyint(1) NOT NULL,
  `approval_status` tinyint(1) NOT NULL,
  `supervising_prediction_id` int(10) unsigned DEFAULT NULL,
  `stop_working_prediction_id` int(10) unsigned DEFAULT NULL,
  `approval_by` int(10) unsigned DEFAULT NULL,
  `recomended_by` int(10) unsigned DEFAULT NULL,
  `approval_date` datetime DEFAULT NULL,
  `terminal_id` int(10) unsigned DEFAULT NULL,
  `spo` int(11) DEFAULT NULL,
  `bpm` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prajobs_employee_id_foreign` (`employee_id`),
  KEY `prajobs_supervising_prediction_id_foreign` (`supervising_prediction_id`),
  KEY `prajobs_stop_working_prediction_id_foreign` (`stop_working_prediction_id`),
  KEY `prajobs_terminal_id_foreign` (`terminal_id`),
  KEY `prajobs_approval_by_foreign` (`approval_by`),
  KEY `prajobs_recomended_by_foreign` (`recomended_by`),
  CONSTRAINT `prajobs_approval_by_foreign` FOREIGN KEY (`approval_by`) REFERENCES `users` (`id`),
  CONSTRAINT `prajobs_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `prajobs_recomended_by_foreign` FOREIGN KEY (`recomended_by`) REFERENCES `users` (`id`),
  CONSTRAINT `prajobs_stop_working_prediction_id_foreign` FOREIGN KEY (`stop_working_prediction_id`) REFERENCES `stop_working_predictions` (`id`),
  CONSTRAINT `prajobs_supervising_prediction_id_foreign` FOREIGN KEY (`supervising_prediction_id`) REFERENCES `supervising_predictions` (`id`),
  CONSTRAINT `prajobs_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminal_absensis` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prajobs`
--

LOCK TABLES `prajobs` WRITE;
/*!40000 ALTER TABLE `prajobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `prajobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `problem_productivity_categories`
--

DROP TABLE IF EXISTS `problem_productivity_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `problem_productivity_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `problem_productivity_categories`
--

LOCK TABLES `problem_productivity_categories` WRITE;
/*!40000 ALTER TABLE `problem_productivity_categories` DISABLE KEYS */;
INSERT INTO `problem_productivity_categories` VALUES (2,'P01','Skill Operator DT',NULL,NULL),(3,'P02','Operator Training',NULL,NULL),(4,'P03','Manuver Mundur Jauh ROM',NULL,NULL),(5,'P04','Manuver Mundur Jauh Port',NULL,NULL),(6,'P05','Antri di ROM (Mesin Nyala)',NULL,NULL),(7,'P06','Antri di Timbangan (Mesin Nyala)',NULL,NULL),(8,'P07','Antri di Port (Mesin Nyala)',NULL,NULL),(9,'P08','ROM Crowded',NULL,NULL),(10,'P09','ROM Amblas',NULL,NULL),(11,'P10','ROM Lembek / Berair',NULL,NULL),(12,'P11','ROM Licin',NULL,NULL),(13,'P12','ROM Sempit',NULL,NULL),(14,'P13','ROM Undulating',NULL,NULL),(15,'P14','Port Crowded',NULL,NULL),(16,'P15','Port Amblas',NULL,NULL),(17,'P16','Port Lembek / Berair',NULL,NULL),(18,'P17','Port Licin',NULL,NULL),(19,'P18','Port Sempit',NULL,NULL),(20,'P19','Port Undulating',NULL,NULL),(21,'P20','Perbaikan Jalan Hauling',NULL,NULL),(22,'P21','Jalan Rusak',NULL,NULL),(23,'P22','Jalan Berdebu',NULL,NULL),(24,'P23','Jalan Undulating',NULL,NULL),(25,'P24','Jalan Berkabut',NULL,NULL),(26,'P25','Jalan Licin',NULL,NULL),(27,'P26','Jalan Crowded',NULL,NULL),(28,'P27','Jalan Sempit',NULL,NULL),(29,'P28','Jalan Berair',NULL,NULL),(30,'P29','Jalan Banyak Tikungan/Rambu',NULL,NULL),(31,'P30','Grade Tinggi',NULL,NULL),(32,'P31','Material Sedikit',NULL,NULL),(33,'P32','Material Habis',NULL,NULL);
/*!40000 ALTER TABLE `problem_productivity_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `running_texts`
--

DROP TABLE IF EXISTS `running_texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `running_texts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `running_texts`
--

LOCK TABLES `running_texts` WRITE;
/*!40000 ALTER TABLE `running_texts` DISABLE KEYS */;
INSERT INTO `running_texts` VALUES (1,'Ini sangat hebat bro..','Operation',1,'2018-04-25 23:22:35','2018-04-25 23:22:35'),(2,'ok siap komandan','Operation',1,'2018-04-26 00:14:48','2018-04-26 00:14:48'),(3,'ooidjewojf iofjewoijfw','kkl',0,'2018-04-26 00:24:10','2018-04-26 00:25:22'),(4,'lorem ipsum','dwefewf',0,'2018-04-26 00:24:44','2018-04-26 00:25:07');
/*!40000 ALTER TABLE `running_texts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seams`
--

DROP TABLE IF EXISTS `seams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seams`
--

LOCK TABLES `seams` WRITE;
/*!40000 ALTER TABLE `seams` DISABLE KEYS */;
INSERT INTO `seams` VALUES (1,'A',NULL,'2018-04-30 04:30:26','2018-04-30 04:30:26'),(2,'G',NULL,'2018-04-30 04:30:30','2018-04-30 04:30:30'),(3,'O',NULL,'2018-04-30 04:30:33','2018-04-30 04:30:33'),(4,'W',NULL,'2018-04-30 04:30:37','2018-04-30 04:30:37');
/*!40000 ALTER TABLE `seams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_categories`
--

DROP TABLE IF EXISTS `staff_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_categories`
--

LOCK TABLES `staff_categories` WRITE;
/*!40000 ALTER TABLE `staff_categories` DISABLE KEYS */;
INSERT INTO `staff_categories` VALUES (1,'Staff',NULL,'2018-04-09 06:24:12','2018-04-10 17:53:44'),(3,'Kontrak',NULL,'2018-04-10 17:53:55','2018-04-10 17:53:55');
/*!40000 ALTER TABLE `staff_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_balanceds`
--

DROP TABLE IF EXISTS `stock_balanceds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_balanceds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `area_id` int(10) unsigned NOT NULL,
  `sub_area_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `dumping_date` date NOT NULL,
  `volume` int(11) NOT NULL,
  `seam_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_balanceds`
--

LOCK TABLES `stock_balanceds` WRITE;
/*!40000 ALTER TABLE `stock_balanceds` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_balanceds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stop_working_predictions`
--

DROP TABLE IF EXISTS `stop_working_predictions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stop_working_predictions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stop_working_predictions`
--

LOCK TABLES `stop_working_predictions` WRITE;
/*!40000 ALTER TABLE `stop_working_predictions` DISABLE KEYS */;
INSERT INTO `stop_working_predictions` VALUES (1,'Stop Bekerja',0,'2018-04-09 06:23:34','2018-04-11 06:49:15'),(2,'Stop Bekerja dalam 11 Jam Setelah Bangun Hari Ini',11,'2018-04-11 06:49:27','2018-04-11 06:49:27'),(3,'Stop Bekerja dalam 12 Jam Setelah Bangun Hari Ini',12,'2018-04-11 06:49:39','2018-04-11 06:49:39'),(4,'Stop Bekerja dalam 14 Jam Setelah Bangun Hari Ini',14,'2018-04-11 06:49:51','2018-04-11 06:49:51'),(5,'Stop Bekerja dalam 15 Jam Setelah Bangun Hari Ini',15,'2018-04-11 06:50:03','2018-04-11 06:50:03'),(6,'Stop Bekerja dalam 18 Jam Setelah Bangun Hari Ini',18,'2018-04-11 06:50:15','2018-04-11 06:50:15'),(7,'Stop Bekerja dalam 21 Jam Setelah Bangun Hari Ini',21,'2018-04-11 06:50:27','2018-04-11 06:50:27'),(8,'Stop Bekerja dalam 22 Jam Setelah Bangun Hari Ini',22,'2018-04-11 06:50:44','2018-04-11 06:50:44');
/*!40000 ALTER TABLE `stop_working_predictions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_areas`
--

DROP TABLE IF EXISTS `sub_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `area_id` int(10) unsigned NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_areas`
--

LOCK TABLES `sub_areas` WRITE;
/*!40000 ALTER TABLE `sub_areas` DISABLE KEYS */;
/*!40000 ALTER TABLE `sub_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supervising_predictions`
--

DROP TABLE IF EXISTS `supervising_predictions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supervising_predictions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supervising_predictions`
--

LOCK TABLES `supervising_predictions` WRITE;
/*!40000 ALTER TABLE `supervising_predictions` DISABLE KEYS */;
INSERT INTO `supervising_predictions` VALUES (1,'Stop Bekerja',0,'2018-04-09 06:18:46','2018-04-11 06:47:04'),(2,'Butuh Pengawasan',0,'2018-04-11 06:47:25','2018-04-11 06:47:25'),(3,'Butuh Pengawasan dalam 11 Jam Setelah Bangun Hari Ini',1,'2018-04-11 06:47:39','2018-04-11 06:47:39'),(4,'Butuh Pengawasan dalam 14 Jam Setelah Bangun Hari Ini',14,'2018-04-11 06:47:52','2018-04-11 06:47:52'),(5,'Butuh Pengawasan dalam 17 Jam Setelah Bangun Hari Ini',17,'2018-04-11 06:48:04','2018-04-11 06:48:04'),(6,'Butuh Pengawasan dalam 18 Jam Setelah Bangun Hari Ini',18,'2018-04-11 06:48:17','2018-04-11 06:48:17');
/*!40000 ALTER TABLE `supervising_predictions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terminal_absensis`
--

DROP TABLE IF EXISTS `terminal_absensis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `terminal_absensis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terminal_absensis`
--

LOCK TABLES `terminal_absensis` WRITE;
/*!40000 ALTER TABLE `terminal_absensis` DISABLE KEYS */;
INSERT INTO `terminal_absensis` VALUES (1,2,'TA-01','192.168.0.201','2018-04-26 18:48:42','2018-04-26 18:49:33'),(2,3,'TA-02','192.168.0.202','2018-04-26 18:49:28','2018-04-26 18:49:28');
/*!40000 ALTER TABLE `terminal_absensis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_categories`
--

DROP TABLE IF EXISTS `unit_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_categories`
--

LOCK TABLES `unit_categories` WRITE;
/*!40000 ALTER TABLE `unit_categories` DISABLE KEYS */;
INSERT INTO `unit_categories` VALUES (1,'BARGE LOADER',NULL,'2018-04-17 19:13:02','2018-04-17 19:13:02'),(2,'PORT OPERATION',NULL,'2018-04-17 19:13:18','2018-04-17 19:13:18'),(3,'ROAD MAINTENANCE',NULL,'2018-04-17 19:13:26','2018-04-17 19:13:26'),(4,'SUBCONT',NULL,'2018-04-27 04:40:21','2018-04-27 04:40:21');
/*!40000 ALTER TABLE `unit_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `egi_id` int(10) unsigned NOT NULL,
  `owner_id` int(10) unsigned NOT NULL,
  `alocation_id` int(10) unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit_category_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `units_egi_id_foreign` (`egi_id`),
  KEY `units_owner_id_foreign` (`owner_id`),
  KEY `units_alocation_id_foreign` (`alocation_id`),
  KEY `units_unit_category_id_foreign` (`unit_category_id`),
  CONSTRAINT `units_egi_id_foreign` FOREIGN KEY (`egi_id`) REFERENCES `egis` (`id`),
  CONSTRAINT `units_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`id`),
  CONSTRAINT `units_unit_category_id_foreign` FOREIGN KEY (`unit_category_id`) REFERENCES `unit_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (2,'JETTY H',3,1,NULL,1,NULL,NULL,1),(3,'JETTY J',2,1,NULL,1,NULL,NULL,1),(4,'JETTY U',3,1,NULL,1,NULL,NULL,1),(5,'JETTY K',1,1,NULL,1,NULL,NULL,1),(6,'BA09',12,2,NULL,1,NULL,NULL,2),(7,'BBA01',13,3,NULL,0,NULL,'2018-04-29 15:05:11',2),(8,'EX01BEM',10,4,NULL,1,NULL,NULL,2),(9,'LD114',5,1,NULL,1,NULL,NULL,2),(10,'LD116',5,1,NULL,1,NULL,NULL,2),(11,'LD158',5,1,NULL,1,NULL,NULL,2),(12,'LD185',5,1,NULL,1,NULL,NULL,2),(13,'SSP412',4,5,NULL,1,NULL,NULL,2),(14,'SSP433',4,5,NULL,1,NULL,NULL,2),(15,'SSP442',4,5,NULL,1,NULL,NULL,2),(16,'WL1002',14,1,NULL,1,NULL,NULL,2),(17,'WL1003',14,1,NULL,1,NULL,NULL,2),(18,'WL1004',14,1,NULL,1,NULL,NULL,2),(19,'WL1006',14,1,NULL,1,NULL,NULL,2),(20,'WL2003',15,1,NULL,1,NULL,NULL,2),(21,'WL2004',15,1,NULL,1,NULL,NULL,2),(22,'WL2009',15,1,NULL,1,NULL,NULL,2),(23,'GR1002',6,1,NULL,1,NULL,NULL,3),(24,'GR1020',6,1,NULL,1,NULL,NULL,3),(25,'GR2020',7,1,NULL,1,NULL,NULL,3),(26,'CP101',11,1,NULL,1,NULL,NULL,3),(27,'CP22BPU',11,6,NULL,1,NULL,NULL,3),(28,'CP230-TJ',11,7,NULL,1,NULL,NULL,3),(29,'EX607',10,7,NULL,0,NULL,'2018-04-27 14:26:32',3),(30,'PM4002',8,1,NULL,1,NULL,NULL,3),(31,'WT0013',9,1,NULL,1,NULL,NULL,3),(32,'WT0016',9,1,NULL,1,NULL,NULL,3),(33,'WT0018',9,1,NULL,1,NULL,NULL,3),(34,'WT0019',8,1,NULL,1,NULL,NULL,3),(35,'WT0020',9,1,NULL,1,NULL,NULL,3);
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `super_admin` tinyint(1) NOT NULL DEFAULT '0',
  `api_token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Bagas Udi Sahsangka','udibagas@gmail.com','$2y$10$loKlGuMs5zQN47I1whRx9uP/83h2j3t/hr1PNGWiQxXlwIeKcuMBC','bUuzFfxHXKgZZiywsuZBO4aF1GHjBRIjcPBs74mlPUfUvo15Ed1mDd47N5zx','2018-03-29 08:10:10','2018-04-25 07:53:57',1,1,'EA74blogK5ho4EWAoY7Y8eW2mIVtMNTxh2CWpGpzLZBZoa8awFJNfnPRphxG'),(4,'Udi','bagas@yahii.com','$2y$10$eJD3bcLCD9T1VZaYiGK7t.dWZMZGzoxmKLalH3SlnKlIxBXu8Ghlq',NULL,'2018-04-08 03:39:33','2018-04-25 18:43:48',1,0,NULL),(5,'Sahsangka','bagas@yahoo.com','$2y$10$7YreswgwKFlTxOvYTRyP.ubE8Nf/atQ7bvVX5NddtzP0P4gGeP0OW',NULL,'2018-04-08 03:40:27','2018-04-25 18:43:57',1,0,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-04 14:55:30
