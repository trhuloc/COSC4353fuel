-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: cosc4353db.mysql.database.azure.com    Database: cosc4353
-- ------------------------------------------------------
-- Server version	8.0.35

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '16746f8a-cb70-11ee-b60c-000d3aa60a10:1-56';

--
-- Table structure for table `usercredentials`
--

DROP TABLE IF EXISTS `usercredentials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usercredentials` (
  `UserID` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ProfileUpdated` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usercredentials`
--

LOCK TABLES `usercredentials` WRITE;
/*!40000 ALTER TABLE `usercredentials` DISABLE KEYS */;
INSERT INTO `usercredentials` VALUES (1,'trhuloc','$2y$10$b5ko9m.OQLUDBVn95Gsu6.XIUJcPQWEeDPRL3y3zMii/.8iBx6YlW',0),(3,'tbq0201','$2y$10$ZTvRQgtosCvAlla7ABIWc.yHWPRASHvB6o5tDNp2AeuJkY2MkJN0G',0),(4,'tbq2001','$2y$10$/dMd3icPhAfq9iEsOe4z0ecpJfzKafOI2tS1XvExDMNu9BXJU16NS',0),(6,'test','$2y$10$Sin0HpKxag/UyXHeH9G3au7omizY0kAWpfGlqFeg4Hdj.URi6kVCW',0),(9,'tbq02012001','$2y$10$ZvOI5LfNFgsC8j98PiebP.bvLzFRvZzo4C4PSwzSChzImBvmtxKuO',0),(10,'new_user','hashed_password',0),(11,'loc','123',0),(12,'thinh2001','$2y$10$0TEJBDGOamq6EJ8tE3LrLOHa68Ck76pngrMYdMTxPYnPAsFQdgerC',0),(13,'thinh123','$2y$10$guIv49lPCXSCZNGZWbRzY.xK1dD6te3I6/A2RWmkI0MxAI25gi/Wm',0),(15,'locloc','12345678',0),(17,'trhuloc@gmail.com','$2y$10$3gRihXc0McI5KAEAUyzJQu8jWtwIRdYN3LYU8dMVPW60I.tG.Mir2',0),(18,'john','$2y$10$10ZsNK6IjBvH4qS5C/2j9ufV8dWIvRqUkag5V3zupbOPi.2lWX5CC',0),(19,'newuser','$2y$10$rz3vr5WhiQjm963MBa/2..C37MufJDHw/KEo8FKaK7LJNAjoGwPlW',0),(20,'huuu','$2y$10$.xvzz7GLHVznSELhn6tCbe8VxWDHq0zjVYrbEWX9JosMQbbB0A.c6',0),(21,'loc.trinh.payment@gmail.com','$2y$10$JUPSwtDlNurRyj5MahdrD.Fqs3kXbqEaYHjTK2bsZC4DevmrSODp.',1),(22,'loclocloc','$2y$10$sQ.fsJTd0nH2GkDANu6gt.2lexxKEWaGN70XFvQPmQe3xgOXgdBti',0);
/*!40000 ALTER TABLE `usercredentials` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-01 17:39:03
