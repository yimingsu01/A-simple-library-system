CREATE DATABASE  IF NOT EXISTS `lib` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `lib`;
-- MariaDB dump 10.17  Distrib 10.4.11-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: lib
-- ------------------------------------------------------
-- Server version	10.4.11-MariaDB

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
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_name` varchar(128) DEFAULT NULL,
  `isbn` varchar(13) NOT NULL,
  `publisher` varchar(128) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `author` varchar(128) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `isBorrow` int(11) DEFAULT 0,
  `img_link` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`,`isbn`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'1234','1234','1234','0000-00-00','1234',1234,2,'ayase.png'),(7,'My sister can\'t be this cute','12345','Unknown','2020-07-17','Fujiansi',1234,1,'ayase.png'),(9,'My sister can\'t be this cute2','12345','Unknown','2020-07-17','Fujiansi',1234,2,'ayase.png'),(11,'121','123','123','2020-07-11','123',111,0,'book_cover/artoriaPendragon.jpg'),(12,'12345666','123','12345666','2020-07-11','12345666',12345666,1,'book_cover/rin white shirt.jpg');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrow_application`
--

DROP TABLE IF EXISTS `borrow_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `borrow_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `create_time` date DEFAULT NULL,
  `days_of_borrow` double DEFAULT NULL,
  `updater` int(11) NOT NULL,
  `update_time` date DEFAULT NULL,
  `borrow_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `updater` (`updater`),
  KEY `book_id` (`book_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `borrow_application_ibfk_1` FOREIGN KEY (`updater`) REFERENCES `user` (`id`),
  CONSTRAINT `borrow_application_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  CONSTRAINT `borrow_application_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrow_application`
--

LOCK TABLES `borrow_application` WRITE;
/*!40000 ALTER TABLE `borrow_application` DISABLE KEYS */;
INSERT INTO `borrow_application` VALUES (5,1,1,'2020-07-16',2,1,'2020-07-19',0),(7,1,1,'2020-07-16',2,1,'2020-07-19',0),(13,1,7,'2020-07-19',9,1,'2020-07-19',2),(14,1,7,'2020-07-19',10,1,'2020-07-19',2),(15,1,7,'2020-07-19',10,1,'2020-07-19',2),(16,1,7,'2020-07-19',10,1,'2020-07-20',2),(19,1,9,'2020-07-19',15,1,'2020-07-19',2),(20,1,9,'2020-07-19',15,1,'2020-07-19',1),(21,1,9,'2020-07-19',21,1,'2020-07-19',1),(22,1,9,'2020-07-19',23,1,'2020-07-19',1),(23,13,1,'2020-07-20',10,1,'2020-07-20',2),(24,13,1,'2020-07-20',1,1,'2020-07-20',1),(25,13,7,'2020-07-20',2,1,'2020-07-20',2),(26,1,7,'2020-07-20',10,1,'2020-07-20',1),(27,1,11,'2020-07-21',123,1,NULL,3),(28,1,12,'2020-07-21',2,1,'2020-07-21',1);
/*!40000 ALTER TABLE `borrow_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delay_application`
--

DROP TABLE IF EXISTS `delay_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delay_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_books_id` int(11) NOT NULL,
  `additional_days` int(11) NOT NULL,
  `reasons_of_delay` text DEFAULT NULL,
  `create_time` date DEFAULT NULL,
  `updater` int(11) DEFAULT NULL,
  `update_time` date DEFAULT NULL,
  `status` varchar(128) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `updater` (`updater`),
  KEY `user_books_id` (`user_books_id`),
  CONSTRAINT `delay_application_ibfk_1` FOREIGN KEY (`updater`) REFERENCES `user` (`id`),
  CONSTRAINT `delay_application_ibfk_2` FOREIGN KEY (`user_books_id`) REFERENCES `user_books` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delay_application`
--

LOCK TABLES `delay_application` WRITE;
/*!40000 ALTER TABLE `delay_application` DISABLE KEYS */;
INSERT INTO `delay_application` VALUES (2,1,10,'nothing',NULL,1,'2020-07-20','1'),(5,12,10,'121','2020-07-20',1,'2020-07-20','2'),(6,22,10,'123','2020-07-20',1,'2020-07-20','1'),(7,23,10,'Cna\'t finish','2020-07-21',NULL,NULL,'0');
/*!40000 ALTER TABLE `delay_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loss_application`
--

DROP TABLE IF EXISTS `loss_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loss_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_book_id` int(11) NOT NULL,
  `create_time` date DEFAULT NULL,
  `reasons_of_loss` text DEFAULT NULL,
  `book_price` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_books_id` (`user_book_id`),
  CONSTRAINT `loss_application_ibfk_1` FOREIGN KEY (`user_book_id`) REFERENCES `user_books` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loss_application`
--

LOCK TABLES `loss_application` WRITE;
/*!40000 ALTER TABLE `loss_application` DISABLE KEYS */;
INSERT INTO `loss_application` VALUES (1,1,'2020-01-01','Nothing',1234),(2,13,'2020-07-19','I forgot',1234),(3,14,'2020-07-19','1234',1234),(4,14,'2020-07-19','86',1234),(5,16,'2020-07-19','1232',1234),(6,17,'2020-07-19','212',1234),(7,18,'2020-07-19','1231',1234),(8,20,'2020-07-20','I forgot',1234);
/*!40000 ALTER TABLE `loss_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `username` varchar(128) DEFAULT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `safe_questions` varchar(128) DEFAULT NULL,
  `safe_questions_answers` varchar(128) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `create_time` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`type`) REFERENCES `user_role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,1,'yimingsu','Yiming','Su',0,18,'020101','1,1,1',',,yimingsu',1,'2020-05-25'),(3,2,'toosaka_rin','Rin','Tohsaka',1,30,'1234','1,1,1','123,123,123',1,'2020-07-10'),(4,2,'suyim22','Yiming','Su',0,18,'1234','1,1,1','123,123,123',1,'2020-07-10'),(9,2,'suyim','yiming','sau',0,18,'1234','1,1,1','123,123,123',1,'2020-07-15'),(10,2,'matou_sakura','Sakura','Matou',1,18,'sakura','1,1,1','1,1,1',1,'2020-07-15'),(11,2,'utaha','utaha','kasumigao',1,17,'utaha','1,1,1','123,123,123',1,'2020-07-15'),(12,2,'123456','123456','123456',0,123456,'123456','1,1,1','123456,123456,123456',1,'2020-07-16'),(13,2,'bingheyi','Binghe','Yi',0,17,'123','1,1,1','123,123,123',1,'2020-07-20');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_application`
--

DROP TABLE IF EXISTS `user_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `safe_questions` varchar(128) DEFAULT NULL,
  `safe_questions_answers` varchar(128) DEFAULT NULL,
  `register_status` int(11) DEFAULT NULL,
  `create_time` date DEFAULT NULL,
  `updater` int(11) DEFAULT NULL,
  `update_time` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `updater` (`updater`),
  CONSTRAINT `user_application_ibfk_1` FOREIGN KEY (`updater`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_application`
--

LOCK TABLES `user_application` WRITE;
/*!40000 ALTER TABLE `user_application` DISABLE KEYS */;
INSERT INTO `user_application` VALUES (1,'toosaka_rin','Rin','Tohsaka',1,30,'1234','1,1,1','123,123,123',1,'2020-07-04',NULL,NULL),(2,'matou_sakura','Sakura','Matou',1,18,'sakura','1,1,1','1,1,1',1,'2020-07-08',1,'2020-07-15'),(3,'suyim22','Yiming','Su',0,18,'1234','1,1,1','123,123,123',1,'2020-07-10',NULL,NULL),(5,'utaha','utaha','kasumigao',1,17,'utaha','1,1,1','123,123,123',1,'2020-07-15',1,'2020-07-15'),(6,'1234','1234','1234',0,1234,'1234','1,1,1','1234,1234,1234',0,'2020-07-15',1,'2020-07-15'),(7,'21345','21345','21345',0,21345,'21345','1,1,1','21345,21345,21345',0,'2020-07-15',1,'2020-07-15'),(8,'234423','234423','234423',0,234423,'234423','1,1,1','234423,234423,234423',0,'2020-07-15',1,'2020-07-15'),(9,'123456','123456','123456',0,123456,'123456','1,1,1','123456,123456,123456',1,'2020-07-16',1,'2020-07-16'),(10,'123456','123456','123456',0,123456,'','1,1,1','123456,123456,123456',NULL,'2020-07-16',NULL,NULL),(11,'123456','123456','123456',0,123456,'12345','1,1,1','123456,123456,123456',NULL,'2020-07-16',NULL,NULL),(12,'123456','123456','123456',0,123456,'12345','1,1,1','123456,123456,123456',NULL,'2020-07-16',NULL,NULL),(13,'123456','123456','123456',0,123456,'12345','1,1,1','123456,123456,123456',NULL,'2020-07-16',NULL,NULL),(14,'123456','12345612','123456',0,123456,'31231234','1,1,1','123456,123456,123456',NULL,'2020-07-16',NULL,NULL),(15,'1234567','12345612','123456',0,123456,'12345','1,1,1','123456,123456,123456',NULL,'2020-07-16',NULL,NULL),(16,'yimingsu2','yimingsu','yimingsu',0,1234,'sakura','1,1,1','yimingsu,yimingsu,yimingsu',NULL,'2020-07-16',NULL,NULL),(17,'yimingsu3','yimingsu','yimingsu',0,1234,'12345','1,1,1','yimingsu,yimingsu,yimingsu',NULL,'2020-07-16',NULL,NULL),(18,'yimingsu4','yimingsu','yimingsu',0,1234,'12345','1,1,1','yimingsu,yimingsu,yimingsu',NULL,'2020-07-16',NULL,NULL),(19,'yimingsu6','yimingsu','yimingsu',0,1234,'12345','1,1,1','yimingsu,yimingsu,yimingsu',NULL,'2020-07-16',NULL,NULL),(20,'yimingsu6','1234','1234',0,123,'sakura','1,1,1','1234,1234,1234',NULL,'2020-07-16',NULL,NULL),(21,'yimin8gsu','1234','1234',0,1234,'sakura','1,1,1','1234,1234,1234',NULL,'2020-07-16',NULL,NULL),(22,'yimin9gsu','1234','1234',0,1234,'12345','1,1,1','1234,1234,1234',NULL,'2020-07-16',NULL,NULL),(23,'bingheyi','Binghe','Yi',0,17,'123','1,1,1','123,123,123',1,'2020-07-20',1,'2020-07-20');
/*!40000 ALTER TABLE `user_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_books`
--

DROP TABLE IF EXISTS `user_books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `days_of_borrow` double DEFAULT NULL,
  `status` varchar(128) DEFAULT NULL,
  `create_time` date DEFAULT NULL,
  `overtime` mediumtext DEFAULT NULL,
  `overtime_price` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_books_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  CONSTRAINT `user_books_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_books`
--

LOCK TABLES `user_books` WRITE;
/*!40000 ALTER TABLE `user_books` DISABLE KEYS */;
INSERT INTO `user_books` VALUES (1,1,1,2,'0','2020-07-17',NULL,NULL),(3,1,1,NULL,'0','2020-07-17',NULL,NULL),(4,1,1,2,'0','2020-07-17',NULL,NULL),(9,7,1,9,'0','2020-07-19',NULL,NULL),(10,7,1,10,'0','2020-07-19','1',1.5),(11,7,1,10,'0','2020-07-19',NULL,NULL),(12,7,1,10,'0','2020-07-19',NULL,NULL),(13,9,1,1,'3','2020-07-19',NULL,NULL),(14,9,1,12,'3','2020-07-19',NULL,NULL),(15,9,1,15,'3','2020-07-19',NULL,NULL),(16,9,1,15,'3','2020-07-19',NULL,NULL),(17,9,1,21,'3','2020-07-19',NULL,NULL),(18,9,1,23,'3','2020-07-19',NULL,NULL),(19,1,13,10,'3','2020-07-20',NULL,NULL),(20,1,13,1,'3','2020-07-20',NULL,NULL),(21,7,13,2,'0','2020-07-20',NULL,NULL),(22,7,1,10,'1','2020-07-20',NULL,NULL),(23,12,1,2,'1','2020-07-21',NULL,NULL);
/*!40000 ALTER TABLE `user_books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,'admin'),(2,'user'),(3,'VIP_user');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-21 20:05:30
