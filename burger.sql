-- MySQL dump 10.16  Distrib 10.3.10-MariaDB, for osx10.14 (x86_64)
--
-- Host: localhost    Database: burger
-- ------------------------------------------------------
-- Server version	10.3.10-MariaDB

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
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `home` varchar(5) DEFAULT NULL,
  `part` smallint(6) DEFAULT NULL,
  `appt` varchar(5) DEFAULT NULL,
  `floor` smallint(6) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `payment` enum('cash','card') DEFAULT NULL,
  `callback` enum('yes','no') DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,2,'Улица Новая','2а',1,'22',5,'Оплата по карте','card','yes'),(2,2,'Улица Новая','2а',1,'22',5,'Оплата по карте','card','yes'),(3,2,'Улица Новая','2а',1,'22',5,'Оплата по карте','card','yes'),(4,2,'Улица Новая','2а',1,'22',5,'Оплата по карте','card','yes'),(5,2,'Улица Новая','2а',1,'22',5,'Оплата по карте','card','yes'),(6,2,'Улица Новая','2а',1,'22',5,'Оплата по карте','card','yes'),(7,2,'Улица Новая','2а',1,'22',5,'Оплата по карте','card','yes'),(8,2,'Улица Новая','2а',1,'22',5,'Оплата по карте','card','yes'),(9,2,'Улица Новая','2а',1,'22',5,'Оплата по карте','card','yes'),(10,2,'Улица Новая','2а',1,'22',5,'Оплата по карте','card','yes'),(11,2,'Улица Новая','2а',1,'22',5,'Оплата по карте','card','yes'),(12,3,'Петровская','33',0,'32',0,'Побыстрее','cash','yes'),(13,3,'Петровская','33',0,'32',0,'Побыстрее','cash','yes'),(14,3,'Петровская','33',0,'32',0,'Побыстрее','cash','no');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test@mail.ru','+7(900)888-77-88','Имя'),(2,'test2@mail.ru','+7(900)888-88-88','Имя Фамилия'),(3,'petr2@mail.ru','+7(900)888-99-88','Петр');
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

-- Dump completed on 2018-11-20  0:34:18
