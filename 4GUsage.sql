-- MySQL dump 10.13  Distrib 5.6.31, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: 4GUsage
-- ------------------------------------------------------
-- Server version	5.6.31-0ubuntu0.15.10.1

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
-- Table structure for table `2017_12`
--

DROP TABLE IF EXISTS `2017_12`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `2017_12` (
  `day` varchar(20) DEFAULT NULL,
  `upload` varchar(128) DEFAULT NULL,
  `download` varchar(128) DEFAULT NULL,
  `total` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `2017_12`
--

LOCK TABLES `2017_12` WRITE;
/*!40000 ALTER TABLE `2017_12` DISABLE KEYS */;
INSERT INTO `2017_12` VALUES ('22','1945.66','20541.93278312683','22487.59593963623'),('23','','','9748.48'),('24','','','10240'),('25','153.54','5148.41','5304.32'),('27','648.3859195709229','5291.817707061768','5940.20362663269');
/*!40000 ALTER TABLE `2017_12` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `2018_01`
--

DROP TABLE IF EXISTS `2018_01`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `2018_01` (
  `one` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `2018_01`
--

LOCK TABLES `2018_01` WRITE;
/*!40000 ALTER TABLE `2018_01` DISABLE KEYS */;
/*!40000 ALTER TABLE `2018_01` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mainData`
--

DROP TABLE IF EXISTS `mainData`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mainData` (
  `upload` varchar(128) DEFAULT NULL,
  `download` varchar(128) DEFAULT NULL,
  `total` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mainData`
--

LOCK TABLES `mainData` WRITE;
/*!40000 ALTER TABLE `mainData` DISABLE KEYS */;
INSERT INTO `mainData` VALUES ('2747.252523422241','30975.197959899902','33722.45048332214');
/*!40000 ALTER TABLE `mainData` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-28 17:42:31
