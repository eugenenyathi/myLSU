-- MySQL dump 10.16  Distrib 10.1.38-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: lsu
-- ------------------------------------------------------
-- Server version	10.1.38-MariaDB

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
-- Table structure for table `accommodationFees`
--

DROP TABLE IF EXISTS `accommodationFees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accommodationFees` (
  `studentType` varchar(15) NOT NULL,
  `fee` decimal(10,0) NOT NULL,
  PRIMARY KEY (`studentType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accommodationFees`
--

LOCK TABLES `accommodationFees` WRITE;
/*!40000 ALTER TABLE `accommodationFees` DISABLE KEYS */;
INSERT INTO `accommodationFees` VALUES ('Block',8000),('Conventional',15000);
/*!40000 ALTER TABLE `accommodationFees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `excludedProgrammes`
--

DROP TABLE IF EXISTS `excludedProgrammes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `excludedProgrammes` (
  `programmeCode` varchar(15) NOT NULL,
  `part` decimal(2,1) NOT NULL,
  PRIMARY KEY (`programmeCode`),
  CONSTRAINT `excludedProgrammes_ibfk_1` FOREIGN KEY (`programmeCode`) REFERENCES `lsuProgrammes` (`programmeCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `excludedProgrammes`
--

LOCK TABLES `excludedProgrammes` WRITE;
/*!40000 ALTER TABLE `excludedProgrammes` DISABLE KEYS */;
/*!40000 ALTER TABLE `excludedProgrammes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculties`
--

DROP TABLE IF EXISTS `faculties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faculties` (
  `facultyCode` varchar(15) NOT NULL,
  `facultyName` longtext,
  PRIMARY KEY (`facultyCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculties`
--

LOCK TABLES `faculties` WRITE;
/*!40000 ALTER TABLE `faculties` DISABLE KEYS */;
INSERT INTO `faculties` VALUES ('AgricSciences','Agricultural Sciences'),('Engineering','Engineering and Applied Sciences'),('Humanities','Humanities and Social Sciences');
/*!40000 ALTER TABLE `faculties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facultyAccStatus`
--

DROP TABLE IF EXISTS `facultyAccStatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facultyAccStatus` (
  `facultyCode` varchar(15) NOT NULL,
  `part` decimal(2,1) NOT NULL,
  `accStatus` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`facultyCode`,`part`),
  CONSTRAINT `facultyAccStatus_ibfk_1` FOREIGN KEY (`facultyCode`) REFERENCES `faculties` (`facultyCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facultyAccStatus`
--

LOCK TABLES `facultyAccStatus` WRITE;
/*!40000 ALTER TABLE `facultyAccStatus` DISABLE KEYS */;
INSERT INTO `facultyAccStatus` VALUES ('AgricSciences',1.0,1),('AgricSciences',2.0,1),('AgricSciences',4.0,1),('Engineering',1.0,1),('Engineering',2.0,1),('Engineering',4.0,1),('Humanities',1.0,1),('Humanities',2.0,1),('Humanities',4.0,1);
/*!40000 ALTER TABLE `facultyAccStatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facultyCheckInOut`
--

DROP TABLE IF EXISTS `facultyCheckInOut`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facultyCheckInOut` (
  `facultyCode` varchar(15) NOT NULL,
  `part` decimal(2,1) NOT NULL,
  `checkIn` date DEFAULT NULL,
  `checkOut` date DEFAULT NULL,
  PRIMARY KEY (`facultyCode`,`part`),
  CONSTRAINT `facultyCheckInOut_ibfk_1` FOREIGN KEY (`facultyCode`) REFERENCES `faculties` (`facultyCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facultyCheckInOut`
--

LOCK TABLES `facultyCheckInOut` WRITE;
/*!40000 ALTER TABLE `facultyCheckInOut` DISABLE KEYS */;
INSERT INTO `facultyCheckInOut` VALUES ('AgricSciences',1.0,'2022-05-16','2022-07-26'),('AgricSciences',2.0,'2022-05-16','2022-07-26'),('AgricSciences',4.0,'2022-05-16','2022-07-26'),('Engineering',1.0,'2022-05-16','2022-07-26'),('Engineering',2.0,'2022-05-16','2022-07-26'),('Engineering',4.0,'2022-05-16','2022-07-26'),('Humanities',1.0,NULL,NULL),('Humanities',2.0,NULL,NULL),('Humanities',4.0,NULL,NULL);
/*!40000 ALTER TABLE `facultyCheckInOut` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lsuProgrammes`
--

DROP TABLE IF EXISTS `lsuProgrammes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lsuProgrammes` (
  `programmeCode` varchar(10) NOT NULL,
  `programmeName` tinytext NOT NULL,
  `facultyCODE` varchar(15) NOT NULL,
  PRIMARY KEY (`programmeCode`),
  KEY `facultyCODE` (`facultyCODE`),
  CONSTRAINT `lsuProgrammes_ibfk_1` FOREIGN KEY (`facultyCODE`) REFERENCES `faculties` (`facultyCode`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lsuProgrammes`
--

LOCK TABLES `lsuProgrammes` WRITE;
/*!40000 ALTER TABLE `lsuProgrammes` DISABLE KEYS */;
INSERT INTO `lsuProgrammes` VALUES ('CropScie','Crop Science','AgricSciences'),('Dev','Development Studies','Humanities'),('ProdEng','Production Engineering','Engineering');
/*!40000 ALTER TABLE `lsuProgrammes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lsuTuition`
--

DROP TABLE IF EXISTS `lsuTuition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lsuTuition` (
  `programmeCODE` varchar(10) NOT NULL,
  `tuition` int(11) DEFAULT NULL,
  `facultyCODE` varchar(15) NOT NULL,
  PRIMARY KEY (`programmeCODE`),
  KEY `facultyCODE` (`facultyCODE`),
  CONSTRAINT `lsuTuition_ibfk_1` FOREIGN KEY (`programmeCODE`) REFERENCES `lsuProgrammes` (`programmeCode`) ON DELETE CASCADE,
  CONSTRAINT `lsuTuition_ibfk_2` FOREIGN KEY (`facultyCODE`) REFERENCES `faculties` (`facultyCode`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lsuTuition`
--

LOCK TABLES `lsuTuition` WRITE;
/*!40000 ALTER TABLE `lsuTuition` DISABLE KEYS */;
INSERT INTO `lsuTuition` VALUES ('CropScie',69510,'AgricSciences'),('Dev',61110,'Humanities'),('ProdEng',69510,'Engineering');
/*!40000 ALTER TABLE `lsuTuition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `numOfStudentsPerRoom`
--

DROP TABLE IF EXISTS `numOfStudentsPerRoom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `numOfStudentsPerRoom` (
  `numPerRoom` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `numOfStudentsPerRoom`
--

LOCK TABLES `numOfStudentsPerRoom` WRITE;
/*!40000 ALTER TABLE `numOfStudentsPerRoom` DISABLE KEYS */;
INSERT INTO `numOfStudentsPerRoom` VALUES (4);
/*!40000 ALTER TABLE `numOfStudentsPerRoom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preferredRoomMatesFemaleHostel`
--

DROP TABLE IF EXISTS `preferredRoomMatesFemaleHostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preferredRoomMatesFemaleHostel` (
  `studentId` varchar(9) NOT NULL,
  `roomMateId` varchar(9) NOT NULL,
  `confirmStatus` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`studentId`,`roomMateId`),
  KEY `roomMateId` (`roomMateId`),
  CONSTRAINT `preferredRoomMatesFemaleHostel_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`),
  CONSTRAINT `preferredRoomMatesFemaleHostel_ibfk_2` FOREIGN KEY (`roomMateId`) REFERENCES `studentDetails_bck` (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preferredRoomMatesFemaleHostel`
--

LOCK TABLES `preferredRoomMatesFemaleHostel` WRITE;
/*!40000 ALTER TABLE `preferredRoomMatesFemaleHostel` DISABLE KEYS */;
INSERT INTO `preferredRoomMatesFemaleHostel` VALUES ('L0021935D','L0062813M',1),('L0021935D','L0150498S',-1),('L0021935D','L0196382F',-1),('L0024381N','L0041652V',1),('L0024381N','L0160457U',-1),('L0024381N','L0164329M',-1),('L0084657Y','L0098731R',1),('L0084657Y','L0124705N',-1),('L0084657Y','L0128067H',-1),('L0238946K','L0382509V',1),('L0238946K','L0382769I',1),('L0238946K','L0415376Z',-1),('L0267019G','L0301968X',1),('L0267019G','L0342608W',1),('L0267019G','L0350791H',-1),('L0293046S','L0356791F',1),('L0293046S','L0387694E',1),('L0293046S','L0497523Q',-1),('L0385264E','L0407529Y',1),('L0385264E','L0479231D',1),('L0385264E','L0492513Q',1),('L0497538U','L0519327B',1),('L0497538U','L0519347C',1),('L0497538U','L0532407S',1),('L0572806O','L0574209T',1),('L0572806O','L0583671M',-1),('L0572806O','L0650731O',-1),('L0576912I','L0605278W',1),('L0576912I','L0712965C',1),('L0576912I','L0716358L',1),('L0680479K','L0743258W',1),('L0680479K','L0758162U',1),('L0680479K','L0758209M',-1),('L0759206O','L0796048X',1),('L0759206O','L0807321Z',1),('L0759206O','L0875341V',1);
/*!40000 ALTER TABLE `preferredRoomMatesFemaleHostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preferredRoomMatesMaleHostel`
--

DROP TABLE IF EXISTS `preferredRoomMatesMaleHostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preferredRoomMatesMaleHostel` (
  `studentId` varchar(9) NOT NULL,
  `roomMateId` varchar(9) NOT NULL,
  `confirmStatus` int(11) DEFAULT '0',
  PRIMARY KEY (`studentId`,`roomMateId`),
  KEY `roomMateId` (`roomMateId`),
  CONSTRAINT `preferredRoomMatesMaleHostel_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`),
  CONSTRAINT `preferredRoomMatesMaleHostel_ibfk_2` FOREIGN KEY (`roomMateId`) REFERENCES `studentDetails_bck` (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preferredRoomMatesMaleHostel`
--

LOCK TABLES `preferredRoomMatesMaleHostel` WRITE;
/*!40000 ALTER TABLE `preferredRoomMatesMaleHostel` DISABLE KEYS */;
INSERT INTO `preferredRoomMatesMaleHostel` VALUES ('L0016954T','L0019562A',1),('L0016954T','L0084659W',-1),('L0016954T','L0095384A',-1),('L0046971D','L0061375H',1),('L0046971D','L0083146Q',-1),('L0046971D','L0094327C',-1),('L0126058Z','L0327815F',1),('L0126058Z','L0367529G',1),('L0126058Z','L0397452K',1),('L0217509D','L0251986L',1),('L0217509D','L0350218S',1),('L0217509D','L0439751O',-1),('L0260974N','L0267539V',1),('L0260974N','L0278694B',1),('L0260974N','L0341578Y',-1),('L0397021G','L0403762S',1),('L0397021G','L0430169Q',1),('L0397021G','L0564093V',1),('L0467301A','L0497105N',1),('L0467301A','L0518320J',1),('L0467301A','L0519872I',1),('L0560743V','L0572690R',1),('L0560743V','L0586192Q',-1),('L0560743V','L0593472J',-1),('L0586170U','L0615408W',1),('L0586170U','L0658273B',-1),('L0586170U','L0739015J',-1),('L0648105E','L0657942G',1),('L0648105E','L0751286W',1),('L0648105E','L0804597Z',-1),('L0758361U','L0869402O',1),('L0758361U','L0935610G',1),('L0758361U','L0980635X',-1),('L0816294G','L0865491T',1),('L0816294G','L0905164N',1),('L0816294G','L0935806W',1);
/*!40000 ALTER TABLE `preferredRoomMatesMaleHostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requestRoomFemaleHostel`
--

DROP TABLE IF EXISTS `requestRoomFemaleHostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requestRoomFemaleHostel` (
  `studentId` varchar(9) NOT NULL,
  `timeStamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `marker` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`studentId`),
  CONSTRAINT `requestRoomFemaleHostel_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requestRoomFemaleHostel`
--

LOCK TABLES `requestRoomFemaleHostel` WRITE;
/*!40000 ALTER TABLE `requestRoomFemaleHostel` DISABLE KEYS */;
INSERT INTO `requestRoomFemaleHostel` VALUES ('L0021935D','2022-08-18 20:40:50',0),('L0024381N','2022-08-18 20:40:52',0),('L0084657Y','2022-08-18 20:40:48',0),('L0238946K','2022-08-18 20:40:51',0),('L0267019G','2022-08-18 20:40:49',0),('L0293046S','2022-08-18 20:40:53',0),('L0385264E','2022-08-18 20:40:50',0),('L0497538U','2022-08-18 20:40:54',0),('L0572806O','2022-08-18 20:40:55',0),('L0576912I','2022-08-18 20:40:52',0),('L0680479K','2022-08-18 20:40:55',0),('L0759206O','2022-08-18 20:40:56',0);
/*!40000 ALTER TABLE `requestRoomFemaleHostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requestRoomMaleHostel`
--

DROP TABLE IF EXISTS `requestRoomMaleHostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requestRoomMaleHostel` (
  `studentId` varchar(9) NOT NULL,
  `timeStamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `marker` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`studentId`),
  CONSTRAINT `requestRoomMaleHostel_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requestRoomMaleHostel`
--

LOCK TABLES `requestRoomMaleHostel` WRITE;
/*!40000 ALTER TABLE `requestRoomMaleHostel` DISABLE KEYS */;
INSERT INTO `requestRoomMaleHostel` VALUES ('L0016954T','2022-08-18 20:40:31',0),('L0046971D','2022-08-18 20:40:35',0),('L0126058Z','2022-08-18 20:40:34',0),('L0217509D','2022-08-18 20:40:36',0),('L0260974N','2022-08-18 20:40:32',0),('L0397021G','2022-08-18 20:40:33',0),('L0467301A','2022-08-18 20:40:37',0),('L0560743V','2022-08-18 20:40:37',0),('L0586170U','2022-08-18 20:40:33',0),('L0648105E','2022-08-18 20:40:38',0),('L0758361U','2022-08-18 20:40:34',0),('L0816294G','2022-08-18 20:40:38',0);
/*!40000 ALTER TABLE `requestRoomMaleHostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requestTemp`
--

DROP TABLE IF EXISTS `requestTemp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requestTemp` (
  `studentId` varchar(9) NOT NULL,
  `timeStamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `marker` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requestTemp`
--

LOCK TABLES `requestTemp` WRITE;
/*!40000 ALTER TABLE `requestTemp` DISABLE KEYS */;
INSERT INTO `requestTemp` VALUES ('L0084659W','2022-05-09 10:31:46',0),('L0095384A','2022-05-09 10:31:46',0),('L0403762S','2022-05-09 10:31:46',0),('L0430169Q','2022-05-09 10:31:46',0);
/*!40000 ALTER TABLE `requestTemp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requestsFemaleHostel`
--

DROP TABLE IF EXISTS `requestsFemaleHostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requestsFemaleHostel` (
  `studentId` varchar(9) NOT NULL,
  `marker` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`studentId`),
  CONSTRAINT `requestsFemaleHostel_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requestsFemaleHostel`
--

LOCK TABLES `requestsFemaleHostel` WRITE;
/*!40000 ALTER TABLE `requestsFemaleHostel` DISABLE KEYS */;
INSERT INTO `requestsFemaleHostel` VALUES ('L0021935D',1),('L0024381N',1),('L0041652V',1),('L0062813M',1),('L0084657Y',1),('L0098731R',1),('L0124705N',1),('L0128067H',1),('L0150498S',1),('L0160457U',1),('L0164329M',1),('L0196382F',1),('L0238946K',1),('L0267019G',1),('L0293046S',1),('L0301968X',1),('L0342608W',1),('L0350791H',1),('L0356791F',1),('L0382509V',1),('L0382769I',1),('L0385264E',1),('L0387694E',1),('L0407529Y',1),('L0415376Z',1),('L0479231D',1),('L0492513Q',1),('L0497523Q',1),('L0497538U',1),('L0519327B',1),('L0519347C',1),('L0532407S',1),('L0572806O',1),('L0574209T',1),('L0576912I',1),('L0583671M',1),('L0605278W',1),('L0650731O',1),('L0680479K',1),('L0712965C',1),('L0716358L',1),('L0743258W',1),('L0758162U',1),('L0758209M',1),('L0759206O',1),('L0796048X',1),('L0807321Z',1),('L0875341V',1);
/*!40000 ALTER TABLE `requestsFemaleHostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requestsMaleHostel`
--

DROP TABLE IF EXISTS `requestsMaleHostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requestsMaleHostel` (
  `studentId` varchar(9) NOT NULL,
  `marker` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`studentId`),
  CONSTRAINT `requestsMaleHostel_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requestsMaleHostel`
--

LOCK TABLES `requestsMaleHostel` WRITE;
/*!40000 ALTER TABLE `requestsMaleHostel` DISABLE KEYS */;
INSERT INTO `requestsMaleHostel` VALUES ('L0016954T',1),('L0019562A',1),('L0046971D',1),('L0061375H',1),('L0083146Q',1),('L0084659W',1),('L0094327C',1),('L0095384A',1),('L0126058Z',1),('L0217509D',1),('L0251986L',1),('L0260974N',1),('L0267539V',1),('L0278694B',1),('L0327815F',1),('L0341578Y',1),('L0350218S',1),('L0367529G',1),('L0397021G',1),('L0397452K',1),('L0403762S',1),('L0430169Q',1),('L0439751O',1),('L0467301A',1),('L0497105N',1),('L0518320J',1),('L0519872I',1),('L0560743V',1),('L0564093V',1),('L0572690R',1),('L0586170U',1),('L0586192Q',1),('L0593472J',1),('L0615408W',1),('L0648105E',1),('L0657942G',1),('L0658273B',1),('L0739015J',1),('L0751286W',1),('L0758361U',1),('L0804597Z',1),('L0816294G',1),('L0865491T',1),('L0869402O',1),('L0905164N',1),('L0935610G',1),('L0935806W',1),('L0980635X',1);
/*!40000 ALTER TABLE `requestsMaleHostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomAvailabityStatusFemaleHostel`
--

DROP TABLE IF EXISTS `roomAvailabityStatusFemaleHostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomAvailabityStatusFemaleHostel` (
  `roomNumber` int(11) NOT NULL,
  `roomStatus` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`roomNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomAvailabityStatusFemaleHostel`
--

LOCK TABLES `roomAvailabityStatusFemaleHostel` WRITE;
/*!40000 ALTER TABLE `roomAvailabityStatusFemaleHostel` DISABLE KEYS */;
INSERT INTO `roomAvailabityStatusFemaleHostel` VALUES (101,1),(102,1),(103,1),(104,1),(105,1),(106,1),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(113,0),(114,0),(115,0),(116,0),(117,0),(118,0),(119,0),(120,0),(121,0),(122,0),(123,0),(124,0),(125,0),(126,0),(127,0),(128,0),(129,0),(130,0);
/*!40000 ALTER TABLE `roomAvailabityStatusFemaleHostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomAvailabityStatusMaleHostel`
--

DROP TABLE IF EXISTS `roomAvailabityStatusMaleHostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomAvailabityStatusMaleHostel` (
  `roomNumber` int(11) NOT NULL,
  `roomStatus` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`roomNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomAvailabityStatusMaleHostel`
--

LOCK TABLES `roomAvailabityStatusMaleHostel` WRITE;
/*!40000 ALTER TABLE `roomAvailabityStatusMaleHostel` DISABLE KEYS */;
INSERT INTO `roomAvailabityStatusMaleHostel` VALUES (101,1),(102,1),(103,1),(104,1),(105,1),(106,1),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(113,0),(114,0),(115,0),(116,0),(117,0),(118,0),(119,0),(120,0),(121,0),(122,0),(123,0),(124,0),(125,0),(126,0),(127,0),(128,0),(129,0),(130,0);
/*!40000 ALTER TABLE `roomAvailabityStatusMaleHostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomOccupiersFemaleHostel`
--

DROP TABLE IF EXISTS `roomOccupiersFemaleHostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomOccupiersFemaleHostel` (
  `roomNumber` int(11) NOT NULL,
  `studentId` varchar(9) NOT NULL,
  PRIMARY KEY (`roomNumber`,`studentId`),
  KEY `studentId` (`studentId`),
  CONSTRAINT `roomOccupiersFemaleHostel_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomOccupiersFemaleHostel`
--

LOCK TABLES `roomOccupiersFemaleHostel` WRITE;
/*!40000 ALTER TABLE `roomOccupiersFemaleHostel` DISABLE KEYS */;
INSERT INTO `roomOccupiersFemaleHostel` VALUES (101,'L0021935D'),(101,'L0024381N'),(101,'L0041652V'),(101,'L0062813M'),(102,'L0084657Y'),(102,'L0098731R'),(102,'L0124705N'),(102,'L0128067H'),(103,'L0150498S'),(103,'L0160457U'),(103,'L0164329M'),(103,'L0196382F'),(104,'L0238946K'),(104,'L0267019G'),(104,'L0293046S'),(104,'L0301968X'),(105,'L0342608W'),(105,'L0350791H'),(105,'L0356791F'),(105,'L0382509V'),(106,'L0382769I'),(106,'L0385264E'),(106,'L0387694E'),(106,'L0407529Y'),(107,'L0415376Z'),(107,'L0479231D'),(107,'L0492513Q'),(107,'L0497523Q'),(108,'L0497538U'),(108,'L0519327B'),(108,'L0519347C'),(108,'L0532407S'),(109,'L0572806O'),(109,'L0574209T'),(109,'L0576912I'),(109,'L0583671M'),(110,'L0605278W'),(110,'L0650731O'),(110,'L0680479K'),(110,'L0712965C'),(111,'L0716358L'),(111,'L0743258W'),(111,'L0758162U'),(111,'L0758209M'),(112,'L0759206O'),(112,'L0796048X'),(112,'L0807321Z'),(112,'L0875341V');
/*!40000 ALTER TABLE `roomOccupiersFemaleHostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomOccupiersMaleHostel`
--

DROP TABLE IF EXISTS `roomOccupiersMaleHostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomOccupiersMaleHostel` (
  `roomNumber` int(11) NOT NULL,
  `studentId` varchar(9) NOT NULL,
  PRIMARY KEY (`roomNumber`,`studentId`),
  KEY `studentId` (`studentId`),
  CONSTRAINT `roomOccupiersMaleHostel_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomOccupiersMaleHostel`
--

LOCK TABLES `roomOccupiersMaleHostel` WRITE;
/*!40000 ALTER TABLE `roomOccupiersMaleHostel` DISABLE KEYS */;
INSERT INTO `roomOccupiersMaleHostel` VALUES (101,'L0016954T'),(101,'L0019562A'),(101,'L0046971D'),(101,'L0061375H'),(102,'L0083146Q'),(102,'L0084659W'),(102,'L0094327C'),(102,'L0095384A'),(103,'L0126058Z'),(103,'L0217509D'),(103,'L0251986L'),(103,'L0260974N'),(104,'L0267539V'),(104,'L0278694B'),(104,'L0327815F'),(104,'L0341578Y'),(105,'L0350218S'),(105,'L0367529G'),(105,'L0397021G'),(105,'L0397452K'),(106,'L0403762S'),(106,'L0430169Q'),(106,'L0439751O'),(106,'L0467301A'),(107,'L0497105N'),(107,'L0518320J'),(107,'L0519872I'),(107,'L0560743V'),(108,'L0564093V'),(108,'L0572690R'),(108,'L0586170U'),(108,'L0586192Q'),(109,'L0593472J'),(109,'L0615408W'),(109,'L0648105E'),(109,'L0657942G'),(110,'L0658273B'),(110,'L0739015J'),(110,'L0751286W'),(110,'L0758361U'),(111,'L0804597Z'),(111,'L0816294G'),(111,'L0865491T'),(111,'L0869402O'),(112,'L0905164N'),(112,'L0935610G'),(112,'L0935806W'),(112,'L0980635X');
/*!40000 ALTER TABLE `roomOccupiersMaleHostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomRequestGrantedFemaleHostel`
--

DROP TABLE IF EXISTS `roomRequestGrantedFemaleHostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomRequestGrantedFemaleHostel` (
  `roomNumber` int(11) NOT NULL,
  `studentId` varchar(9) NOT NULL,
  PRIMARY KEY (`roomNumber`,`studentId`),
  KEY `studentId` (`studentId`),
  CONSTRAINT `roomRequestGrantedFemaleHostel_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomRequestGrantedFemaleHostel`
--

LOCK TABLES `roomRequestGrantedFemaleHostel` WRITE;
/*!40000 ALTER TABLE `roomRequestGrantedFemaleHostel` DISABLE KEYS */;
/*!40000 ALTER TABLE `roomRequestGrantedFemaleHostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomRequestGrantedMaleHostel`
--

DROP TABLE IF EXISTS `roomRequestGrantedMaleHostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomRequestGrantedMaleHostel` (
  `roomNumber` int(11) NOT NULL,
  `studentId` varchar(9) NOT NULL,
  PRIMARY KEY (`roomNumber`,`studentId`),
  KEY `studentId` (`studentId`),
  CONSTRAINT `roomRequestGrantedMaleHostel_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomRequestGrantedMaleHostel`
--

LOCK TABLES `roomRequestGrantedMaleHostel` WRITE;
/*!40000 ALTER TABLE `roomRequestGrantedMaleHostel` DISABLE KEYS */;
/*!40000 ALTER TABLE `roomRequestGrantedMaleHostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `startRoomNumber`
--

DROP TABLE IF EXISTS `startRoomNumber`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `startRoomNumber` (
  `gender` varchar(5) NOT NULL,
  `roomNumber` int(11) DEFAULT '101',
  PRIMARY KEY (`gender`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `startRoomNumber`
--

LOCK TABLES `startRoomNumber` WRITE;
/*!40000 ALTER TABLE `startRoomNumber` DISABLE KEYS */;
INSERT INTO `startRoomNumber` VALUES ('boys',101),('girls',101);
/*!40000 ALTER TABLE `startRoomNumber` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studentDetails`
--

DROP TABLE IF EXISTS `studentDetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studentDetails` (
  `studentId` varchar(9) NOT NULL,
  `nationalId` varchar(12) NOT NULL,
  `fullName` varchar(40) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `DOB` date DEFAULT NULL,
  PRIMARY KEY (`studentId`),
  UNIQUE KEY `nationalId` (`nationalId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studentDetails`
--

LOCK TABLES `studentDetails` WRITE;
/*!40000 ALTER TABLE `studentDetails` DISABLE KEYS */;
INSERT INTO `studentDetails` VALUES ('L0016954T','08-354217A90','Kgalima Mdlongwa','M','2003-03-12'),('L0019562A','08-608935E47','Mumuzi Mtanga','M','2002-09-28'),('L0021935D','08-761402D93','Gillian Sibanda','F','2003-04-24'),('L0024381N','08-310658B24','Gugulethu Dube','F','2002-05-28'),('L0041652V','08-126879D40','Sibongile Ndebele','F','2002-03-07'),('L0046971D','08-470231G95','Wishly Mureyani','M','2002-06-08'),('L0061375H','08-560243D71','Arnold Magaya','M','2003-10-15'),('L0062813M','08-483012J59','Pamela Sibanda','F','2003-11-13'),('L0083146Q','08-436172J89','Irvin Mudenda','M','2003-11-28'),('L0084657Y','08-130567E82','Rumbidzai Mache','F','2002-07-30'),('L0084659W','08-790328D54','Honest Ndlovu','M','2002-08-21'),('L0094327C','08-360519H47','Dumisani Tshuma','M','2001-11-10'),('L0095384A','08-043278B15','Aesan Nyoni','M','2002-02-20'),('L0098731R','08-503726D19','Sisasenkosi Mabhena','F','2003-05-24'),('L0124705N','08-502368E94','Pinky Mtyambizi','F','2003-05-03'),('L0126058Z','08-641028I79','Blessmore Ncube','M','2003-07-21'),('L0128067H','08-416270I39','Lorraine Mpanduki','F','2003-05-10'),('L0150498S','08-653948H12','Sharon Takayedza','F','2003-05-25'),('L0160457U','08-841092K65','El-shamma Nkomo','F','2002-10-30'),('L0164329M','08-801925I63','Trinna Nyathi','F','2002-08-14'),('L0196382F','08-329617D04','Noeleen Nkomo','F','2003-05-26'),('L0217509D','08-152469B70','Anesu Kuvhengurwa','M','2003-12-21'),('L0238946K','08-514670B93','Celeste Munemo','F','2002-03-21'),('L0251986L','08-539761F42','Takudzwa Chisango','M','2003-03-29'),('L0260974N','08-498517D63','Brian Moyo','M','2003-11-07'),('L0267019G','08-683197G45','Angel Alufasi','F','2003-04-20'),('L0267539V','08-172490K68','Handukani Moyo','M','2002-08-01'),('L0278694B','08-410985C73','Hillary Monga','M','2002-09-06'),('L0293046S','08-476095L21','Blessings Sibanda','F','2003-12-10'),('L0301968X','08-874503D92','Memory Nyoni','F','2003-05-20'),('L0327815F','08-261403J78','Quincy Sibanda','M','2002-04-23'),('L0341578Y','08-480179D32','Prince Nyoni','M','2002-12-25'),('L0342608W','08-816529F37','Nomsa Msonza','F','2002-12-02'),('L0350218S','08-385092C41','Evidence Khanye','M','2002-10-09'),('L0350791H','08-439570D62','Nosikelelo Tshuma','F','2003-03-20'),('L0356791F','08-513709F28','Amanda Dube','F','2002-09-12'),('L0367529G','08-152349B70','Blessing Siwela','M','2002-06-13'),('L0382509V','08-674183G05','Petition Sialubange','F','2002-10-08'),('L0382769I','08-821069D53','Hazel Mwale','F','2003-08-31'),('L0385264E','08-947208D36','Mellisah Matutu','F','2002-08-26'),('L0387694E','08-850721A93','Alisha Moyo','F','2003-05-08'),('L0397021G','08-925706F34','Thalamas Nyoni','M','2002-12-21'),('L0397452K','08-903452J81','Lolyd Ngwenya','M','2002-07-10'),('L0403762S','08-143560C29','Beaven Lunga','M','2003-12-28'),('L0407529Y','08-392684E51','Zvikomborero Fani','F','2002-09-12'),('L0415376Z','08-837401D29','Simelinkosi Nyathi','F','2002-02-10'),('L0430169Q','08-236158B07','Munashe Sumani','M','2002-07-25'),('L0439751O','08-716429C58','Nkosiyethu Ndlovu','M','2003-08-12'),('L0452978O','08-970281D46','Nesisa Ncube','M','2003-04-27'),('L0467301A','08-045182G97','Admire Skinner','M','2002-07-25'),('L0479231D','08-198732D40','Mendy Mudenda','F','2002-10-16'),('L0492513Q','08-978065C34','Vallencia Mpofu','F','2002-11-25'),('L0497105N','08-984017A23','Tadiwanashe Chizhande','M','2002-06-03'),('L0497523Q','08-932185D07','Shanice Nyakusvora','F','2002-08-28'),('L0497538U','08-378942C61','Clarita Ngwenya','F','2002-03-01'),('L0518320J','08-082493H56','Craig Mondoro','M','2003-05-15'),('L0519327B','08-324057G81','Mpho Ncube','F','2002-04-10'),('L0519347C','08-472915J86','Deborah Mumpande','F','2002-10-15'),('L0519872I','08-502341C76','Leeroy Mzimzi','M','2002-12-22'),('L0532407S','08-854069E17','Patience Mpofu','F','2003-06-14'),('L0560743V','08-136927I58','Prosper Mabika','M','2002-08-02'),('L0564093V','08-620341I95','Mbongeni Ngwenya','M','2003-10-20'),('L0572690R','08-278935C06','Mayibongwe Dube','M','2003-04-11'),('L0572806O','08-194028J63','Panashe Shoko','F','2003-09-06'),('L0574209T','08-706921K53','Zanie Musodziwa','F','2003-12-08'),('L0576912I','08-796415K20','Thandekile Ndlovu','F','2003-07-26'),('L0583671M','08-103754D68','Barbra Deke','F','2003-11-19'),('L0586170U','08-902513B74','Birthwell Mwazira','M','2002-02-08'),('L0586192Q','08-568902K34','Prince Diwura','M','2002-10-04'),('L0593472J','08-461830F92','Adonis Ngwenya','M','2003-07-06'),('L0605278W','08-216039L47','Rusike Nicolyn','F','2002-02-07'),('L0615408W','08-915603C82','Usher Munkuli','M','2003-04-02'),('L0648105E','08-127654D08','Brandon Ndlovu','M','2003-08-27'),('L0650731O','08-483106B57','Sinokubonga Nowake','F','2003-10-18'),('L0657942G','08-587439E60','Jayte J Mupawaenda','M','2003-06-14'),('L0658273B','08-470925G81','Edify Mumpande','M','2002-01-04'),('L0680479K','08-241937J58','Sholdean Ndhlovu','F','2002-06-17'),('L0712965C','08-165834C97','Anacleta Ngwenya','F','2003-10-13'),('L0716235Y','08-258163K04','Vongai Sithole','M','2002-01-06'),('L0716358L','08-453071C28','Adriel Ncube','F','2003-07-31'),('L0739015J','08-602789F31','Tatenda Gwara','M','2002-09-02'),('L0743258W','08-324196J75','Cremonia Ncube','F','2003-11-09'),('L0751286W','08-530478F91','Iphithule Sibanda','M','2002-11-16'),('L0758162U','08-783465D91','Sicelokuhle Sibanda','F','2003-04-18'),('L0758209M','08-239547C08','Tendai Murambadare','F','2002-04-24'),('L0758361U','08-061295E43','Takudzwa Mutisi','M','2002-03-07'),('L0759206O','08-457809C61','Shylet Ncube','F','2002-03-23'),('L0796048X','08-782093I45','Shine Ncube','F','2003-08-16'),('L0804597Z','08-045213K69','Brian Chibasa','M','2003-01-26'),('L0807321Z','08-968703G25','Thabolwenkosi Ndlovu','F','2002-08-12'),('L0816294G','08-763049A28','Mdumiseni Ndlovu','M','2003-03-18'),('L0865491T','08-369548F01','Lucky Dlodla','M','2003-02-25'),('L0869402O','08-538029D67','Brandon Ndlovu','M','2003-06-25'),('L0875341V','08-758243B16','Anna Ngwenya','F','2003-08-18'),('L0905164N','08-968174G5','Nyasha Chamnogwa','M','2003-11-03'),('L0917426Q','08-957280J13','Perfect Shava','F','2002-06-19'),('L0924508H','08-921438H50','Nozibele Tshili','F','2003-11-23'),('L0926035U','08-526401E78','Mitchell Marozva','F','2003-08-18'),('L0934508M','08-856921G30','Precious Chimanyi','F','2003-09-06'),('L0935610G','08-168204A95','Willard Mapfumo','M','2003-12-13'),('L0935806W','08-421570J8','Tinashe Chisenwa','M','2003-08-28'),('L0942381M','08-129675D43','Chantel Mapira','F','2002-08-10'),('L0948675Z','08-163078K25','Siphesihle Ndlovu','M','2002-11-16'),('L0953186J','08-281537C06','Takudzwa Karipache','F','2002-07-21'),('L0962850Y','08-790618A34','Lizzles Kasina','F','2002-12-25'),('L0980635X','08-508769L24','Blessed Kavisa','M','2002-12-07'),('L0981573D','08-361025I98','Mike Lupondo','M','2003-05-27');
/*!40000 ALTER TABLE `studentDetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studentDetails_bck`
--

DROP TABLE IF EXISTS `studentDetails_bck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studentDetails_bck` (
  `studentId` varchar(9) NOT NULL,
  `nationalId` varchar(12) NOT NULL,
  `fullName` varchar(40) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `DOB` date DEFAULT NULL,
  PRIMARY KEY (`studentId`),
  UNIQUE KEY `nationalId` (`nationalId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studentDetails_bck`
--

LOCK TABLES `studentDetails_bck` WRITE;
/*!40000 ALTER TABLE `studentDetails_bck` DISABLE KEYS */;
INSERT INTO `studentDetails_bck` VALUES ('L0016954T','08-354217A90','Kgalima Mdlongwa','M','2003-03-12'),('L0019562A','08-608935E47','Mumuzi Mtanga','M','2002-09-28'),('L0021935D','08-761402D93','Gillian Sibanda','F','2003-04-24'),('L0023978R','08-897603E41','Ashely Bhurati','M','2003-09-12'),('L0024381N','08-310658B24','Gugulethu Dube','F','2002-05-28'),('L0041652V','08-126879D40','Sibongile Ndebele','F','2002-03-07'),('L0046971D','08-470231G95','Wishly Mureyani','M','2002-06-08'),('L0053214T','08-069418A27','Thomas Mugadzi','M','2002-03-28'),('L0061375H','08-560243D71','Arnold Magaya','M','2003-10-15'),('L0062813M','08-483012J59','Pamela Sibanda','F','2003-11-13'),('L0072165M','08-520316L87','Morcell Ndlovu','F','2003-12-21'),('L0074291J','08-956103A84','Patricia Nyandoro','F','2003-09-09'),('L0083146Q','08-436172J89','Irvin Mudenda','M','2003-11-28'),('L0084657Y','08-130567E82','Rumbidzai Mache','F','2002-07-30'),('L0084659W','08-790328D54','Honest Ndlovu','M','2002-08-21'),('L0094327C','08-360519H47','Dumisani Tshuma','M','2001-11-10'),('L0095384A','08-043278B15','Aesan Nyoni','M','2002-02-20'),('L0095432B','08-963578C01','Denmore Chuma','M','2002-04-29'),('L0098731R','08-503726D19','Sisasenkosi Mabhena','F','2003-05-24'),('L0124705N','08-502368E94','Pinky Mtyambizi','F','2003-05-03'),('L0126058Z','08-641028I79','Blessmore Ncube','M','2003-07-21'),('L0128067H','08-416270I39','Lorraine Mpanduki','F','2003-05-10'),('L0150498S','08-653948H12','Sharon Takayedza','F','2003-05-25'),('L0158706R','08-456093G12','Faith Malunga','F','2003-07-21'),('L0160457U','08-841092K65','El-shamma Nkomo','F','2002-10-30'),('L0164329M','08-801925I63','Trinna Nyathi','F','2002-08-14'),('L0180654V','08-287513C64','Rodney Zindi','M','2003-11-04'),('L0183920U','08-480623E91','Sainty Mudimba','F','2003-02-10'),('L0190476F','08-698723G41','Meliqiniso Sibanda','F','2003-02-07'),('L0196382F','08-329617D04','Noeleen Nkomo','F','2003-05-26'),('L0208547K','08-257184C93','Wayne Moyo','M','2002-08-11'),('L0217509D','08-152469B70','Anesu Kuvhengurwa','M','2003-12-21'),('L0238946K','08-514670B93','Celeste Munemo','F','2002-03-21'),('L0249378C','08-160438E95','Tanyaradzwa Jack','F','2003-04-01'),('L0251986L','08-539761F42','Takudzwa Chisango','M','2003-03-29'),('L0260974N','08-498517D63','Brian Moyo','M','2003-11-07'),('L0267019G','08-683197G45','Angel Alufasi','F','2003-04-20'),('L0267539V','08-172490K68','Handukani Moyo','M','2002-08-01'),('L0278694B','08-410985C73','Hillary Monga','M','2002-09-06'),('L0293046S','08-476095L21','Blessings Sibanda','F','2003-12-10'),('L0295483U','08-409751C32','Tamia Muyambo','F','2002-10-23'),('L0301968X','08-874503D92','Memory Nyoni','F','2003-05-20'),('L0304961J','08-824630G51','Tinokunda Mautsi','M','2002-06-14'),('L0308759I','08-749350G18','Charlotte Ganda','F','2003-11-28'),('L0327815F','08-261403J78','Quincy Sibanda','M','2002-04-23'),('L0341578Y','08-480179D32','Prince Nyoni','M','2002-12-25'),('L0342608W','08-816529F37','Nomsa Msonza','F','2002-12-02'),('L0350218S','08-385092C41','Evidence Khanye','M','2002-10-09'),('L0350791H','08-439570D62','Nosikelelo Tshuma','F','2003-03-20'),('L0356791F','08-513709F28','Amanda Dube','F','2002-09-12'),('L0367529G','08-152349B70','Blessing Siwela','M','2002-06-13'),('L0378059W','08-850916E42','Michael Nyathi','M','2003-12-25'),('L0382509V','08-674183G05','Petition Sialubange','F','2002-10-08'),('L0382769I','08-821069D53','Hazel Mwale','F','2003-08-31'),('L0385264E','08-947208D36','Mellisah Matutu','F','2002-08-26'),('L0386752F','08-641875B23','Odette Makumere','F','2002-05-14'),('L0387694E','08-850721A93','Alisha Moyo','F','2003-05-08'),('L0397021G','08-925706F34','Thalamas Nyoni','M','2002-12-21'),('L0397452K','08-903452J81','Lolyd Ngwenya','M','2002-07-10'),('L0403762S','08-143560C29','Beaven Lunga','M','2003-12-28'),('L0407529Y','08-392684E51','Zvikomborero Fani','F','2002-09-12'),('L0415376Z','08-837401D29','Simelinkosi Nyathi','F','2002-02-10'),('L0429083L','08-278901G56','Quince Manganya','F','2003-03-28'),('L0430169Q','08-236158B07','Munashe Sumani','M','2002-07-25'),('L0437016H','08-348026J17','Veronica Phuthi','F','2002-06-01'),('L0439705W','08-671894D02','Malgas Dube','M','2003-11-05'),('L0439751O','08-716429C58','Nkosiyethu Ndlovu','M','2003-08-12'),('L0452978O','08-970281D46','Nesisa Ncube','M','2003-04-27'),('L0462579D','08-098651C73','Nicholas Phiri','M','2002-09-01'),('L0465173Q','08-320958B46','Sekani Chuma','F','2003-01-21'),('L0467301A','08-045182G97','Admire Skinner','M','2002-07-25'),('L0473015U','08-813709C54','Glenda Ndlovu','F','2002-02-05'),('L0473628I','08-356810F47','Blessing Chuma','M','2003-04-14'),('L0479082J','08-507291C64','Calista Bakari','F','2002-09-16'),('L0479231D','08-198732D40','Mendy Mudenda','F','2002-10-16'),('L0491503C','08-430968C15','Eliezer Dube','M','2002-04-23'),('L0492513Q','08-978065C34','Vallencia Mpofu','F','2002-11-25'),('L0497105N','08-984017A23','Tadiwanashe Chizhande','M','2002-06-03'),('L0497523Q','08-932185D07','Shanice Nyakusvora','F','2002-08-28'),('L0497538U','08-378942C61','Clarita Ngwenya','F','2002-03-01'),('L0514396U','08-537491L02','Prinsla Gava','F','2002-05-30'),('L0518320J','08-082493H56','Craig Mondoro','M','2003-05-15'),('L0519327B','08-324057G81','Mpho Ncube','F','2002-04-10'),('L0519347C','08-472915J86','Deborah Mumpande','F','2002-10-15'),('L0519872I','08-502341C76','Leeroy Mzimzi','M','2002-12-22'),('L0532407S','08-854069E17','Patience Mpofu','F','2003-06-14'),('L0534108A','08-130598D72','Samantha Moyo','F','2003-07-24'),('L0560743V','08-136927I58','Prosper Mabika','M','2002-08-02'),('L0561072W','08-128736H09','Allen Makuvira','M','2003-10-20'),('L0564093V','08-620341I95','Mbongeni Ngwenya','M','2003-10-20'),('L0572690R','08-278935C06','Mayibongwe Dube','M','2003-04-11'),('L0572806O','08-194028J63','Panashe Shoko','F','2003-09-06'),('L0574209T','08-706921K53','Zanie Musodziwa','F','2003-12-08'),('L0576912I','08-796415K20','Thandekile Ndlovu','F','2003-07-26'),('L0583671M','08-103754D68','Barbra Deke','F','2003-11-19'),('L0586170U','08-902513B74','Birthwell Mwazira','M','2002-02-08'),('L0586192Q','08-568902K34','Prince Diwura','M','2002-10-04'),('L0593472J','08-461830F92','Adonis Ngwenya','M','2003-07-06'),('L0605278W','08-216039L47','Rusike Nicolyn','F','2002-02-07'),('L0615408W','08-915603C82','Usher Munkuli','M','2003-04-02'),('L0627015H','08-078396C21','Brightness Dube','F','2003-09-06'),('L0634572A','08-325678F04','Eldrine Maphosa','M','2003-02-13'),('L0637149N','08-529760C48','Ludo Mlauzi','F','2002-05-04'),('L0648105E','08-127654D08','Brandon Ndlovu','M','2003-08-27'),('L0650731O','08-483106B57','Sinokubonga Nowake','F','2003-10-18'),('L0657942G','08-587439E60','Jayte J Mupawaenda','M','2003-06-14'),('L0658273B','08-470925G81','Edify Mumpande','M','2002-01-04'),('L0680479K','08-241937J58','Sholdean Ndhlovu','F','2002-06-17'),('L0701394R','08-579068B42','Talent Madaka','F','2002-09-04'),('L0712965C','08-165834C97','Anacleta Ngwenya','F','2003-10-13'),('L0716235Y','08-258163K04','Vongai Sithole','M','2002-01-06'),('L0716358L','08-453071C28','Adriel Ncube','F','2003-07-31'),('L0729316U','08-832190D64','Precious Bhani','F','2003-10-28'),('L0738659H','08-206589I71','Wayne Ncube','M','2002-07-19'),('L0738920D','08-621357J08','Perfect Sibanda','M','2003-01-17'),('L0739015J','08-602789F31','Tatenda Gwara','M','2002-09-02'),('L0743258W','08-324196J75','Cremonia Ncube','F','2003-11-09'),('L0748510X','08-038657C42','Praise Machaya','F','2002-05-20'),('L0751286W','08-530478F91','Iphithule Sibanda','M','2002-11-16'),('L0758162U','08-783465D91','Sicelokuhle Sibanda','F','2003-04-18'),('L0758209M','08-239547C08','Tendai Murambadare','F','2002-04-24'),('L0758361U','08-061295E43','Takudzwa Mutisi','M','2002-03-07'),('L0759206O','08-457809C61','Shylet Ncube','F','2002-03-23'),('L0780432D','08-651784G02','Delma Mathe','M','2002-02-11'),('L0796048X','08-782093I45','Shine Ncube','F','2003-08-16'),('L0796342V','08-507314K62','Keith Machayinsimbi','M','2002-08-21'),('L0801453W','08-761903K42','Nyashadzashe Siziba','M','2002-03-05'),('L0804597Z','08-045213K69','Brian Chibasa','M','2003-01-26'),('L0807321Z','08-968703G25','Thabolwenkosi Ndlovu','F','2002-08-12'),('L0816294G','08-763049A28','Mdumiseni Ndlovu','M','2003-03-18'),('L0865491T','08-369548F01','Lucky Dlodla','M','2003-02-25'),('L0869402O','08-538029D67','Brandon Ndlovu','M','2003-06-25'),('L0875341V','08-758243B16','Anna Ngwenya','F','2003-08-18'),('L0895731O','08-021647A85','Prosper Chihwai','M','2003-12-06'),('L0905164N','08-968174G5','Nyasha Chamnogwa','M','2003-11-03'),('L0910482A','08-716902I85','Nompilo Moyo','F','2002-11-01'),('L0917426Q','08-957280J13','Perfect Shava','F','2002-06-19'),('L0923168N','08-639240K58','David Gambiza','M','2002-07-30'),('L0924508H','08-921438H50','Nozibele Tshili','F','2003-11-23'),('L0926035U','08-526401E78','Mitchell Marozva','F','2003-08-18'),('L0934508M','08-856921G30','Precious Chimanyi','F','2003-09-06'),('L0935610G','08-168204A95','Willard Mapfumo','M','2003-12-13'),('L0935806W','08-421570J8','Tinashe Chisenwa','M','2003-08-28'),('L0942381M','08-129675D43','Chantel Mapira','F','2002-08-10'),('L0943816U','08-468530L21','Forgiveus Shoko','M','2003-07-04'),('L0948675Z','08-163078K25','Siphesihle Ndlovu','M','2002-11-16'),('L0952318C','08-163845H79','Kelly Phiri','F','2003-07-28'),('L0953186J','08-281537C06','Takudzwa Karipache','F','2002-07-21'),('L0962850Y','08-790618A34','Lizzles Kasina','F','2002-12-25'),('L0965702S','08-386205B17','Mitchel Mlilo','F','2003-12-15'),('L0980635X','08-508769L24','Blessed Kavisa','M','2002-12-07'),('L0981573D','08-361025I98','Mike Lupondo','M','2003-05-27');
/*!40000 ALTER TABLE `studentDetails_bck` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studentLogInDetails`
--

DROP TABLE IF EXISTS `studentLogInDetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studentLogInDetails` (
  `studentId` varchar(9) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`studentId`),
  CONSTRAINT `studentLogInDetails_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studentLogInDetails`
--

LOCK TABLES `studentLogInDetails` WRITE;
/*!40000 ALTER TABLE `studentLogInDetails` DISABLE KEYS */;
INSERT INTO `studentLogInDetails` VALUES ('L0016954T','$2y$10$qA6aanqCx0IUIiVtU/D/D.82ZrPLPIPhW0pacL3a1PZd8nAVswiVi'),('L0019562A','$2y$10$nzw18g2/QmhtJof29PXQUO0r1BLT5lm4sTmN6oltli/Rqm5S6MWLO'),('L0021935D','$2y$10$IccIPy8fCh.oMhyKmMqyv.xPLgVuXg4mueMNslzD8fZXwD0k9qKSG'),('L0024381N','$2y$10$Ot6O7y9Lqp7xAfIL7aECAOemVtxempJPqy3mMblIQBrtaSvU.hsWu'),('L0041652V','$2y$10$Nj2uAUQk1SgiH/AM2K6fvufrtN7DYz5z.ruC9kJ2NM2uunkOB0r4y'),('L0046971D','$2y$10$ETRlObkEoWSLHc1nGw1IK.yXoNxTeSUzRDx3x.Hu8C5HHSpMkQSCG'),('L0061375H','$2y$10$gUFkaJoG5ShpHx4rVRQTVun2ZG3dYp/yTEOHVjwvXMkzRALbYc73y'),('L0062813M','$2y$10$D8hykYASP8vX32FJZOZxROMKlCL9yHBNuc2YsmKDJW4Z2Hoq04W3G'),('L0083146Q','$2y$10$1/FvkWkrDqPAZNx4Sff4OeFVlxezNCahA0uIgWbcI/rLEZRoPUFB6'),('L0084657Y','$2y$10$T9..RxiYStAQx6xH1Ow9yOROb3ocqXvpw6U7/HWOzxeeBfjZb258e'),('L0084659W','$2y$10$vvRonEfLozk.Iv4xdS2QE.Fu0VrXf6pXmeQ2RsGD/eGuFUmJZpNEW'),('L0094327C','$2y$10$XYExhGeIe42oVGgRGVbeT.tr6BR9Z8iSHq9mx4hTy/XByosrByPQO'),('L0095384A','$2y$10$iehrfzKiemLKaE8Ou8SdQOHDvou9.DH29y4AGE.xby/NVrMCbafCq'),('L0098731R','$2y$10$NYkEIm8DNxTs96gEvWzt7e1zND1cjrKMVYbXSXSjQ6LMlNDWMxPSS'),('L0124705N','$2y$10$95RT6Gwf5LUgbogGsThzfO1viyRUoLS3HEHC.bTe9jgv0ZjXS6LF.'),('L0126058Z','$2y$10$MShVu7bO97omyhCuC9FiiuZIZkt76Vwc9MjfY5qF7UGaeCaW0u4HW'),('L0128067H','$2y$10$32WXrGFBe2.ZNXC1umOWYO.IOHKnYMSEmoJl/prt/OSTIJsUUhzI.'),('L0150498S','$2y$10$gWHtK/e3aGQP7Phe.kCtJeOBP3yFOXQIgi1dAC9mjDWA58iRBop82'),('L0160457U','$2y$10$EH.HF6tx2SPi53d12Nhz/ufb20RuyYdxXNSjG.4TnVreBPB01/3zW'),('L0164329M','$2y$10$iylAq4GlGIjdJxIZJG9iAOOjHhZyJprxRubjnUJFPkYVP2uuKeSbS'),('L0196382F','$2y$10$B6Y02vYFADG7TIU6GZuKYOt4alQr7.Rm8eF2wXD8Eyy3QWvH0uSRy'),('L0217509D','$2y$10$E9JKpbJ/P6e/V64J7/sdCeoMckRyOyNcy6Ek3Yh2yw5YSSnQ70neW'),('L0238946K','$2y$10$gxU/ica00n0Lk7Nbld29JuM272/idU5rlVZm/QYrbxWGA/wlt9M7O'),('L0251986L','$2y$10$m90wgcs8xABfNVdvUPp9Z.ZgyUIB7YX3/jY/RMGXPFPZrWdIyN7jq'),('L0260974N','$2y$10$Jcd9WLpip/UjPCXB/H3l6.2K8juzxlcW4qCu5cw9yRXQW2z9KYfoy'),('L0267019G','$2y$10$RoEslSXlA/hjCCbkfdXHYOLxjFjsOHwdY9hRMUWCt6quYBru1eCLK'),('L0267539V','$2y$10$xdA0RwLA.G9Uj6UPing41OREZ4UZAKV31LqDpGo.jHGhlghuCEXoy'),('L0278694B','$2y$10$4XCV8k2tuPuiTicima8f4OpjTD8AQ1bAs0m2Rz30gS39L/mslsd8i'),('L0293046S','$2y$10$vj2FJt6EsG1hSRK4gxrEV.A6OtVeOTYPv9xgemunF8u1Oe61jzciq'),('L0301968X','$2y$10$Kvx7R5IwzdV4hS1LMbt5r.QyYr71s78ef08QpMTIyBk0gtM6leDxy'),('L0327815F','$2y$10$GqEAeZf/LHWChFxUu9AX7uF7zFnz/31NSjUjFV1a4cUxX/Uaf6o76'),('L0341578Y','$2y$10$AnA8q4KI0OtZkzv9khj2U.TIjI4t5zgcEMeD/nNfVgUDCfNvvspye'),('L0342608W','$2y$10$YQGy6JiuYKDVcuX.bGgqG.HGjGW4bMfNJOodilBJGyhB0Qh7mGBp6'),('L0350218S','$2y$10$3q/BC5oAJalhl.ZTzocno.DBI2nvDtsOsXAe5rV3yede/TacUdeD.'),('L0350791H','$2y$10$.R33uDIx/GWSb5ehZjKcf.qxsvkj1YWijxBxioejqfYyY1TJssZNK'),('L0356791F','$2y$10$YSaqvh8Q2SSs2sESzv0p/eusfRZN7cR0.dxCtKxWmqa7lwl0gW4f2'),('L0367529G','$2y$10$J3JheFJhlUf4BOOzxDfAd.bkQGGmpz.X8xVD0u5pJEDM5blcWNufW'),('L0382509V','$2y$10$jjuorSouHfuxKs.INg1ICuOYqld.osOFvxr97uj6a516C7PuCGlcC'),('L0382769I','$2y$10$wgDMigc.SLDFeZ2FV4k.yOBxk8jPXcWfQZS02lm6Icbc2oTwhElqu'),('L0385264E','$2y$10$SBJRbzCx.m3lDYNeEn0p6OMUKXPs79y49150ojFAIR6F7J6jneFtS'),('L0387694E','$2y$10$tEcPrcxOqGGIjC/3KmnbfODCvHQ42L2hVubxISMSO5Uhjye8RTinC'),('L0397021G','$2y$10$PihgqugkFJBeRlDOSA9Zg.K.X.E6oas0XCigbD9nus1t/H3JtdVmi'),('L0397452K','$2y$10$ii7KhRTJH.bq5U7rMDyRd.FjrS5OiSDawX2PKflSEhHq3T2ii3NPy'),('L0403762S','$2y$10$MVHGReKqDMFLOqJduYewW.Xp97O1ww23Yzu6a1RO6orFfW5Y7VR4e'),('L0407529Y','$2y$10$9kyaBnbl1leQ8StYanYJGe4a9hYON8BT9K9YZiJLW1riHKTxZYV/6'),('L0415376Z','$2y$10$dZTaKLjfysq4vJb2h5XgfuKJHXKSoit6QQY8.r2HH24CjYvv4VTSu'),('L0430169Q','$2y$10$0zFIHscrsUJzcGHKHrg0/.sCp7uBrXwCTCKqVp5ldhGIv3iXcDH/y'),('L0439751O','$2y$10$qM4b3uOqMfLT53rxRwpzVeC/1U5p3hPscJMOtoDVcICGLRglL1fVi'),('L0452978O','$2y$10$h/NA5gl/IkPPWxXffXWRjeArHzzAkPCKpAtyrvfy7Ri4eieWISJZO'),('L0467301A','$2y$10$Oldg6ZyWGtuyszbLp7TDxOErn0LOUjg7LMeGWz/B3ZQJqQYhoSzZ2'),('L0479231D','$2y$10$b0.LiXaoQPJ8Oqdjc13ykulp5/FdgsuULaSetbbMTxzR4HBhMLJc6'),('L0492513Q','$2y$10$Q1nLA9X4zPF7FbpE0R104ewcVA9EH3tqyf//a2d2QYJeQuT5srIXe'),('L0497105N','$2y$10$d.emKg/2Yfvn1ZhjlZX7qePP7b.aB0g/wfQL20Ppu6Yjl.XfWESvC'),('L0497523Q','$2y$10$4tbjjXUWEtTJFdq5DakEDOD21.YnGxSlf7IYnW1lPIwO0mYxvS1zy'),('L0497538U','$2y$10$PKVeG6sUovYZqlWpiwpNAOvOt0OsXi.uO.4D.vVqv5Pqn7w0xcVzi'),('L0518320J','$2y$10$dRmcodGbnfq8k5kUcwPtB.Vyx5Dyf99xrIknCJOPJCLOeixzY74yW'),('L0519327B','$2y$10$pPvhOicTWNklpEXo6pyDaeaN6ROdcHy4vs3bABCEv5xoV/anI4YgW'),('L0519347C','$2y$10$tsQ2UZkFzcgCVW6iA0Txv.zCN2M2bVMCGofT1bOzgxCL8/.wXBzF.'),('L0519872I','$2y$10$j/8Nia1n5lZs6Wzk6z0Iv.1E2X2dqlnHRKN5S6gA6EdJXz34fM2ua'),('L0532407S','$2y$10$rBUlPZkNLlagN2zRmtYtmOQXTqMClE9Sv00npBw9jC.v3lTO.QIlu'),('L0560743V','$2y$10$r9A/wCATj2G4PL13fvHjgu7qmc.w.e4WBGEyWDkTWUfLgcg2xAgam'),('L0564093V','$2y$10$.j5avsSR8y8GQlvpBVOB2eZ/SPpNnO2VP//9N/QwYAurcgL7bUOX2'),('L0572690R','$2y$10$W5wCcb8dCObCXOYKvAFctORKlWghgzHDDOkH0mZ/UKaLcZsFlXplK'),('L0572806O','$2y$10$AHzoWEiPMPP7PivXp1gB6Ox0B0y5j3v6qZ3EPxNOdhyapZLhTZMsK'),('L0574209T','$2y$10$s8cwfrVJFkMv/m9IuvhDS.MnYkgfyVB4NJYsq5mInlUn4uq4HzmTK'),('L0576912I','$2y$10$hVvcNsDQxIaKq0VBaOzxce4AbWKroE/t7gc8pH6RBS7ZnOLC/2ovK'),('L0583671M','$2y$10$W74CYIXhERq3IRyHTnXEcOFBd9yLhdGe9wccgQLzXp51C733RUJwG'),('L0586170U','$2y$10$6U8nksPdXHjkjbwxKvDF9uwmPmSbwKZvqsMkuGxCnH4RMrnqi44Ie'),('L0586192Q','$2y$10$z8hgBNgwOXOMM5FMO.TqwO6givkIlXCLbHgMTG4kUB/TJPR2pRSxa'),('L0593472J','$2y$10$gAmoHenA52a4fK9PriUzjukRQfx5Rt96T1d2.ed.A4WB/qUTCIv6.'),('L0605278W','$2y$10$f7rKR40FhgQFCbgk0HqkvewBaSUlgjzGKlfVsUtPGRNGEu7g/pBW6'),('L0615408W','$2y$10$qeJuQYWkalHByr3zLsHzlevZpnTs3v9rnM43cFvXM6wkYSdIRNsf6'),('L0648105E','$2y$10$xfT8S1gY1NbRrXyORJA3d.DWJotq2Dybcmfj5iyVaAuax3VfHcQMG'),('L0650731O','$2y$10$s3H0eV2wBvyr.74.xNJ.POsLaWaS5BqhQFhdOfJenkF3AyGwW9D7u'),('L0657942G','$2y$10$vgfN6kxIY94dAbnw1tJofenEt2BFmxTlGWs5ddIHDwxrprszXVU3y'),('L0658273B','$2y$10$h6NjwHmP5KyTZ0d/0JTG3eBiL4J8aRHF24ZEukVBnYW0K14lTHcGC'),('L0680479K','$2y$10$bId3rnHNMPX8WryjsXWpbeySZbxuIH8LsC8RqO06oFZMmcLapjMOC'),('L0712965C','$2y$10$EvxTnLuHL2nIePWyUf4k8u51xLo4VjZvqPczCSbJaWfLa5tSyvTc6'),('L0716235Y','$2y$10$agGjvmWn3qNIK/RENCPkwuwm8R9lNlzWhL.q52dYmIGWezaZCJpF6'),('L0739015J','$2y$10$llE5yz.jPxBAe8.BhmrnlOB361l4J2t0CbzncqHoLOzxf6SG/2PFq');
/*!40000 ALTER TABLE `studentLogInDetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studentLogInTimeStamps`
--

DROP TABLE IF EXISTS `studentLogInTimeStamps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studentLogInTimeStamps` (
  `studentId` varchar(9) NOT NULL,
  `status` bit(1) DEFAULT b'0',
  `previousTimeStamp` datetime DEFAULT NULL,
  `currentTimeStamp` datetime DEFAULT NULL,
  PRIMARY KEY (`studentId`),
  CONSTRAINT `studentLogInTimeStamps_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studentLogInTimeStamps`
--

LOCK TABLES `studentLogInTimeStamps` WRITE;
/*!40000 ALTER TABLE `studentLogInTimeStamps` DISABLE KEYS */;
INSERT INTO `studentLogInTimeStamps` VALUES ('L0016954T','',NULL,NULL),('L0019562A','',NULL,NULL),('L0021935D','',NULL,NULL),('L0024381N','',NULL,NULL),('L0041652V','',NULL,NULL),('L0046971D','',NULL,NULL),('L0061375H','',NULL,NULL),('L0062813M','',NULL,NULL),('L0083146Q','',NULL,NULL),('L0084657Y','',NULL,NULL),('L0084659W','',NULL,NULL),('L0094327C','',NULL,NULL),('L0095384A','',NULL,NULL),('L0098731R','',NULL,NULL),('L0124705N','',NULL,NULL),('L0126058Z','',NULL,NULL),('L0128067H','',NULL,NULL),('L0150498S','',NULL,NULL),('L0160457U','',NULL,NULL),('L0164329M','',NULL,NULL),('L0196382F','',NULL,NULL),('L0217509D','',NULL,NULL),('L0238946K','',NULL,NULL),('L0251986L','',NULL,NULL),('L0260974N','',NULL,NULL),('L0267019G','',NULL,NULL),('L0267539V','',NULL,NULL),('L0278694B','',NULL,NULL),('L0293046S','',NULL,NULL),('L0301968X','',NULL,NULL),('L0327815F','',NULL,NULL),('L0341578Y','',NULL,NULL),('L0342608W','',NULL,NULL),('L0350218S','',NULL,NULL),('L0350791H','',NULL,NULL),('L0356791F','',NULL,NULL),('L0367529G','',NULL,NULL),('L0382509V','',NULL,NULL),('L0382769I','',NULL,NULL),('L0385264E','',NULL,NULL),('L0387694E','',NULL,NULL),('L0397021G','',NULL,NULL),('L0397452K','',NULL,NULL),('L0403762S','',NULL,NULL),('L0407529Y','',NULL,NULL),('L0415376Z','',NULL,NULL),('L0430169Q','',NULL,NULL),('L0439751O','',NULL,NULL),('L0452978O','',NULL,NULL),('L0467301A','',NULL,NULL),('L0479231D','',NULL,NULL),('L0492513Q','',NULL,NULL),('L0497105N','',NULL,NULL),('L0497523Q','',NULL,NULL),('L0497538U','',NULL,NULL),('L0518320J','',NULL,NULL),('L0519327B','',NULL,NULL),('L0519347C','',NULL,NULL),('L0519872I','',NULL,NULL),('L0532407S','',NULL,NULL),('L0560743V','',NULL,NULL),('L0564093V','',NULL,NULL),('L0572690R','',NULL,NULL),('L0572806O','',NULL,NULL),('L0574209T','',NULL,NULL),('L0576912I','',NULL,NULL),('L0583671M','',NULL,NULL),('L0586170U','',NULL,NULL),('L0586192Q','',NULL,NULL),('L0593472J','',NULL,NULL),('L0605278W','',NULL,NULL),('L0615408W','',NULL,NULL),('L0648105E','',NULL,NULL),('L0650731O','',NULL,NULL),('L0657942G','',NULL,NULL),('L0658273B','',NULL,NULL),('L0680479K','',NULL,NULL),('L0712965C','',NULL,NULL),('L0716235Y','',NULL,NULL),('L0716358L','\0',NULL,NULL),('L0739015J','',NULL,NULL),('L0743258W','\0',NULL,NULL),('L0751286W','\0',NULL,NULL),('L0758162U','\0',NULL,NULL),('L0758209M','\0',NULL,NULL),('L0758361U','\0',NULL,NULL),('L0759206O','\0',NULL,NULL),('L0796048X','\0',NULL,NULL),('L0804597Z','\0',NULL,NULL),('L0807321Z','\0',NULL,NULL),('L0816294G','\0',NULL,NULL),('L0865491T','\0',NULL,NULL),('L0869402O','\0',NULL,NULL),('L0875341V','\0',NULL,NULL),('L0905164N','\0',NULL,NULL),('L0917426Q','\0',NULL,NULL),('L0924508H','\0',NULL,NULL),('L0926035U','\0',NULL,NULL),('L0934508M','\0',NULL,NULL),('L0935610G','\0',NULL,NULL),('L0935806W','\0',NULL,NULL),('L0942381M','\0',NULL,NULL),('L0948675Z','\0',NULL,NULL),('L0953186J','\0',NULL,NULL),('L0962850Y','\0',NULL,NULL),('L0980635X','\0',NULL,NULL),('L0981573D','\0',NULL,NULL);
/*!40000 ALTER TABLE `studentLogInTimeStamps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studentProgramme`
--

DROP TABLE IF EXISTS `studentProgramme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studentProgramme` (
  `studentId` varchar(9) NOT NULL,
  `programmeCODE` varchar(10) NOT NULL,
  `part` decimal(2,1) NOT NULL,
  `facultyCODE` varchar(15) NOT NULL,
  `studentType` varchar(15) NOT NULL,
  PRIMARY KEY (`studentId`),
  KEY `programmeCODE` (`programmeCODE`),
  KEY `facultyCODE` (`facultyCODE`),
  KEY `studentType` (`studentType`),
  CONSTRAINT `studentProgramme_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`) ON DELETE CASCADE,
  CONSTRAINT `studentProgramme_ibfk_2` FOREIGN KEY (`programmeCODE`) REFERENCES `lsuProgrammes` (`programmeCode`) ON DELETE CASCADE,
  CONSTRAINT `studentProgramme_ibfk_3` FOREIGN KEY (`facultyCODE`) REFERENCES `faculties` (`facultyCode`) ON DELETE CASCADE,
  CONSTRAINT `studentProgramme_ibfk_4` FOREIGN KEY (`studentType`) REFERENCES `accommodationFees` (`studentType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studentProgramme`
--

LOCK TABLES `studentProgramme` WRITE;
/*!40000 ALTER TABLE `studentProgramme` DISABLE KEYS */;
INSERT INTO `studentProgramme` VALUES ('L0016954T','CropScie',1.2,'AgricSciences','Conventional'),('L0019562A','CropScie',1.2,'AgricSciences','Conventional'),('L0021935D','ProdEng',1.2,'Engineering','Conventional'),('L0024381N','Dev',1.2,'Humanities','Conventional'),('L0041652V','Dev',1.2,'Humanities','Conventional'),('L0046971D','Dev',1.2,'Humanities','Conventional'),('L0061375H','Dev',1.2,'Humanities','Conventional'),('L0062813M','ProdEng',1.2,'Engineering','Conventional'),('L0083146Q','Dev',1.2,'Humanities','Conventional'),('L0084657Y','CropScie',1.2,'AgricSciences','Conventional'),('L0084659W','CropScie',1.2,'AgricSciences','Conventional'),('L0094327C','Dev',1.2,'Humanities','Conventional'),('L0095384A','CropScie',1.2,'AgricSciences','Conventional'),('L0098731R','CropScie',1.2,'AgricSciences','Conventional'),('L0124705N','CropScie',1.2,'AgricSciences','Conventional'),('L0126058Z','ProdEng',1.2,'Engineering','Conventional'),('L0128067H','CropScie',1.2,'AgricSciences','Conventional'),('L0150498S','ProdEng',1.2,'Engineering','Conventional'),('L0160457U','Dev',1.2,'Humanities','Conventional'),('L0164329M','Dev',1.2,'Humanities','Conventional'),('L0196382F','ProdEng',1.2,'Engineering','Conventional'),('L0217509D','Dev',1.2,'Humanities','Conventional'),('L0238946K','ProdEng',1.2,'Engineering','Conventional'),('L0251986L','Dev',1.2,'Humanities','Conventional'),('L0260974N','CropScie',1.2,'AgricSciences','Conventional'),('L0267019G','CropScie',1.2,'AgricSciences','Conventional'),('L0267539V','CropScie',1.2,'AgricSciences','Conventional'),('L0278694B','CropScie',1.2,'AgricSciences','Conventional'),('L0293046S','Dev',1.2,'Humanities','Conventional'),('L0301968X','CropScie',1.2,'AgricSciences','Conventional'),('L0327815F','ProdEng',1.2,'Engineering','Conventional'),('L0341578Y','CropScie',1.2,'AgricSciences','Conventional'),('L0342608W','CropScie',1.2,'AgricSciences','Conventional'),('L0350218S','Dev',1.2,'Humanities','Conventional'),('L0350791H','CropScie',1.2,'AgricSciences','Conventional'),('L0356791F','Dev',1.2,'Humanities','Conventional'),('L0367529G','ProdEng',1.2,'Engineering','Conventional'),('L0382509V','ProdEng',1.2,'Engineering','Conventional'),('L0382769I','ProdEng',1.2,'Engineering','Conventional'),('L0385264E','CropScie',1.2,'AgricSciences','Conventional'),('L0387694E','Dev',1.2,'Humanities','Conventional'),('L0397021G','CropScie',1.2,'AgricSciences','Conventional'),('L0397452K','ProdEng',1.2,'Engineering','Conventional'),('L0403762S','CropScie',1.2,'AgricSciences','Conventional'),('L0407529Y','CropScie',1.2,'AgricSciences','Conventional'),('L0415376Z','ProdEng',1.2,'Engineering','Conventional'),('L0430169Q','CropScie',1.2,'AgricSciences','Conventional'),('L0439751O','Dev',1.2,'Humanities','Conventional'),('L0452978O','ProdEng',1.2,'Engineering','Conventional'),('L0467301A','Dev',1.2,'Humanities','Conventional'),('L0479231D','CropScie',1.2,'AgricSciences','Conventional'),('L0492513Q','CropScie',1.2,'AgricSciences','Conventional'),('L0497105N','Dev',1.2,'Humanities','Conventional'),('L0497523Q','Dev',1.2,'Humanities','Conventional'),('L0497538U','Dev',1.2,'Humanities','Conventional'),('L0518320J','Dev',1.2,'Humanities','Conventional'),('L0519327B','Dev',1.2,'Humanities','Conventional'),('L0519347C','Dev',1.2,'Humanities','Conventional'),('L0519872I','Dev',1.2,'Humanities','Conventional'),('L0532407S','Dev',1.2,'Humanities','Conventional'),('L0560743V','Dev',1.2,'Humanities','Conventional'),('L0564093V','CropScie',1.2,'AgricSciences','Conventional'),('L0572690R','Dev',1.2,'Humanities','Conventional'),('L0572806O','Dev',1.2,'Humanities','Conventional'),('L0574209T','Dev',1.2,'Humanities','Conventional'),('L0576912I','ProdEng',1.2,'Engineering','Conventional'),('L0583671M','Dev',1.2,'Humanities','Conventional'),('L0586170U','CropScie',1.2,'AgricSciences','Conventional'),('L0586192Q','Dev',1.2,'Humanities','Conventional'),('L0593472J','Dev',1.2,'Humanities','Conventional'),('L0605278W','ProdEng',1.2,'Engineering','Conventional'),('L0615408W','CropScie',1.2,'AgricSciences','Conventional'),('L0648105E','Dev',1.2,'Humanities','Conventional'),('L0650731O','Dev',1.2,'Humanities','Conventional'),('L0657942G','Dev',1.2,'Humanities','Conventional'),('L0658273B','CropScie',1.2,'AgricSciences','Conventional'),('L0680479K','Dev',1.2,'Humanities','Conventional'),('L0712965C','ProdEng',1.2,'Engineering','Conventional'),('L0716235Y','ProdEng',1.2,'Engineering','Conventional'),('L0716358L','ProdEng',1.2,'Engineering','Conventional'),('L0739015J','CropScie',1.2,'AgricSciences','Conventional'),('L0743258W','Dev',1.2,'Humanities','Conventional'),('L0751286W','Dev',1.2,'Humanities','Conventional'),('L0758162U','Dev',1.2,'Humanities','Conventional'),('L0758209M','Dev',1.2,'Humanities','Conventional'),('L0758361U','CropScie',1.2,'AgricSciences','Conventional'),('L0759206O','Dev',1.2,'Humanities','Conventional'),('L0796048X','Dev',1.2,'Humanities','Conventional'),('L0804597Z','Dev',1.2,'Humanities','Conventional'),('L0807321Z','Dev',1.2,'Humanities','Conventional'),('L0816294G','Dev',1.2,'Humanities','Conventional'),('L0865491T','Dev',1.2,'Humanities','Conventional'),('L0869402O','CropScie',1.2,'AgricSciences','Conventional'),('L0875341V','Dev',1.2,'Humanities','Conventional'),('L0905164N','Dev',1.2,'Humanities','Conventional'),('L0917426Q','ProdEng',1.2,'Engineering','Conventional'),('L0924508H','CropScie',1.2,'AgricSciences','Conventional'),('L0926035U','Dev',1.2,'Humanities','Conventional'),('L0934508M','CropScie',1.2,'AgricSciences','Conventional'),('L0935610G','CropScie',1.2,'AgricSciences','Conventional'),('L0935806W','Dev',1.2,'Humanities','Conventional'),('L0942381M','Dev',1.2,'Humanities','Conventional'),('L0948675Z','Dev',1.2,'Humanities','Conventional'),('L0953186J','Dev',1.2,'Humanities','Conventional'),('L0962850Y','CropScie',1.2,'AgricSciences','Conventional'),('L0980635X','CropScie',1.2,'AgricSciences','Conventional'),('L0981573D','Dev',1.2,'Humanities','Conventional');
/*!40000 ALTER TABLE `studentProgramme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studentTuitionDetails`
--

DROP TABLE IF EXISTS `studentTuitionDetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studentTuitionDetails` (
  `studentId` varchar(9) NOT NULL,
  `registrationStatus` int(11) DEFAULT '0',
  `tuitionPaid` decimal(10,0) DEFAULT NULL,
  `programmeCODE` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`studentId`),
  KEY `programmeCODE` (`programmeCODE`),
  CONSTRAINT `studentTuitionDetails_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `studentDetails_bck` (`studentId`) ON DELETE CASCADE,
  CONSTRAINT `studentTuitionDetails_ibfk_2` FOREIGN KEY (`programmeCODE`) REFERENCES `lsuProgrammes` (`programmeCode`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studentTuitionDetails`
--

LOCK TABLES `studentTuitionDetails` WRITE;
/*!40000 ALTER TABLE `studentTuitionDetails` DISABLE KEYS */;
INSERT INTO `studentTuitionDetails` VALUES ('L0016954T',1,35000,'CropScie'),('L0019562A',1,35000,'CropScie'),('L0021935D',1,35000,'ProdEng'),('L0024381N',1,31000,'Dev'),('L0041652V',1,31000,'Dev'),('L0046971D',1,32000,'Dev'),('L0061375H',1,31000,'Dev'),('L0062813M',1,64000,'ProdEng'),('L0083146Q',0,19000,'Dev'),('L0084657Y',0,35000,'CropScie'),('L0084659W',0,25000,'CropScie'),('L0094327C',1,31000,'Dev'),('L0095384A',0,55000,'CropScie'),('L0098731R',1,35000,'CropScie'),('L0124705N',0,51000,'CropScie'),('L0126058Z',1,32000,'ProdEng'),('L0128067H',1,44000,'CropScie'),('L0150498S',0,35000,'ProdEng'),('L0160457U',0,43000,'Dev'),('L0164329M',1,31000,'Dev'),('L0196382F',0,35000,'ProdEng'),('L0217509D',1,40000,'Dev'),('L0238946K',1,35000,'ProdEng'),('L0251986L',1,31000,'Dev'),('L0260974N',1,35000,'CropScie'),('L0267019G',0,40000,'CropScie'),('L0267539V',1,35000,'CropScie'),('L0278694B',1,69510,'CropScie'),('L0293046S',1,31000,'Dev'),('L0301968X',1,69510,'CropScie'),('L0327815F',0,27000,'ProdEng'),('L0341578Y',1,41000,'CropScie'),('L0342608W',1,25000,'CropScie'),('L0350218S',0,31000,'Dev'),('L0350791H',1,35000,'CropScie'),('L0356791F',1,41000,'Dev'),('L0367529G',1,35000,'ProdEng'),('L0382509V',1,35000,'ProdEng'),('L0382769I',0,42000,'ProdEng'),('L0385264E',1,35000,'CropScie'),('L0387694E',0,31000,'Dev'),('L0397021G',1,35000,'CropScie'),('L0397452K',1,35000,'ProdEng'),('L0403762S',1,35000,'CropScie'),('L0407529Y',1,35000,'CropScie'),('L0415376Z',1,35000,'ProdEng'),('L0430169Q',1,35000,'CropScie'),('L0439751O',0,31000,'Dev'),('L0452978O',1,40000,'ProdEng'),('L0467301A',0,31000,'Dev'),('L0479231D',1,35000,'CropScie'),('L0492513Q',1,35000,'CropScie'),('L0497105N',0,31000,'Dev'),('L0497523Q',1,31000,'Dev'),('L0497538U',1,31000,'Dev'),('L0518320J',1,31000,'Dev'),('L0519327B',0,51000,'Dev'),('L0519347C',1,31000,'Dev'),('L0519872I',1,31000,'Dev'),('L0532407S',1,35000,'Dev'),('L0560743V',1,21000,'Dev'),('L0564093V',1,65000,'CropScie'),('L0572690R',1,31000,'Dev'),('L0572806O',0,31000,'Dev'),('L0574209T',1,31000,'Dev'),('L0576912I',1,35000,'ProdEng'),('L0583671M',1,31000,'Dev'),('L0586170U',1,35000,'CropScie'),('L0586192Q',1,21000,'Dev'),('L0593472J',1,61110,'Dev'),('L0605278W',1,38000,'ProdEng'),('L0615408W',1,35000,'CropScie'),('L0648105E',1,51000,'Dev'),('L0650731O',1,31000,'Dev'),('L0657942G',0,31000,'Dev'),('L0658273B',0,66000,'CropScie'),('L0680479K',1,21000,'Dev'),('L0712965C',1,25000,'ProdEng'),('L0716235Y',1,38000,'ProdEng'),('L0716358L',1,35000,'ProdEng'),('L0739015J',1,35000,'CropScie'),('L0743258W',1,31000,'Dev'),('L0751286W',1,21000,'Dev'),('L0758162U',0,31000,'Dev'),('L0758209M',0,31000,'Dev'),('L0758361U',1,61000,'CropScie'),('L0759206O',0,41000,'Dev'),('L0796048X',1,61110,'Dev'),('L0804597Z',1,15000,'Dev'),('L0807321Z',1,31000,'Dev'),('L0816294G',1,31000,'Dev'),('L0865491T',1,25000,'Dev'),('L0869402O',1,35000,'CropScie'),('L0875341V',1,31000,'Dev'),('L0905164N',1,31000,'Dev'),('L0917426Q',1,69510,'ProdEng'),('L0924508H',1,35000,'CropScie'),('L0926035U',1,31000,'Dev'),('L0934508M',1,35000,'CropScie'),('L0935610G',0,35000,'CropScie'),('L0935806W',1,33000,'Dev'),('L0942381M',0,31000,'Dev'),('L0948675Z',1,31000,'Dev'),('L0953186J',1,56000,'Dev'),('L0962850Y',1,31000,'CropScie'),('L0980635X',1,45000,'CropScie'),('L0981573D',1,27000,'Dev');
/*!40000 ALTER TABLE `studentTuitionDetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp`
--

DROP TABLE IF EXISTS `temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp` (
  `studentId` varchar(9) NOT NULL,
  `roomMateId` varchar(9) NOT NULL,
  `confirmStatus` int(11) DEFAULT '0',
  PRIMARY KEY (`studentId`,`roomMateId`),
  KEY `roomMateId` (`roomMateId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp`
--

LOCK TABLES `temp` WRITE;
/*!40000 ALTER TABLE `temp` DISABLE KEYS */;
INSERT INTO `temp` VALUES ('L0084659W','L0016954T',0),('L0084659W','L0019562A',0),('L0084659W','L0341578Y',0),('L0095384A','L0260974N',0),('L0095384A','L0267539V',0),('L0095384A','L0278694B',0),('L0403762S','L0564093V',0),('L0403762S','L0586170U',0),('L0403762S','L0615408W',0),('L0430169Q','L0869402O',0),('L0430169Q','L0935610G',0),('L0430169Q','L0980635X',0);
/*!40000 ALTER TABLE `temp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-05 20:04:42
