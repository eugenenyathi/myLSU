-- MySQL dump 10.16  Distrib 10.1.38-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: lsu
-- ------------------------------------------------------
-- Server version	10.1.38-MariaDB
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping routines for database 'lsu'
--
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetFreeRoomFM`()
BEGIN
		SELECT roomNumber FROM roomAvailabityStatusFemaleHostel rasmh 
		WHERE roomStatus = 0 
		ORDER BY roomNumber ASC
		LIMIT 1;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetFreeRoomMM`()
BEGIN
		SELECT roomNumber FROM roomAvailabityStatusMaleHostel rasmh 
		WHERE roomStatus = 0 
		ORDER BY roomNumber ASC
		LIMIT 1;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetLevelStudents`(IN `inp_level` DECIMAL(2,1), IN `inp_facultyCode` VARCHAR(15), IN `inp_sex` VARCHAR(1))
BEGIN
			SELECT sd.studentId
			FROM studentDetails sd
			JOIN studentProgramme sp 
			ON sd.studentId = sp.studentId
			WHERE sp.part = inp_level
			AND sp.facultyCODE = inp_facultyCode
            AND sd.sex = inp_sex;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetMatchingStudents`(IN `inp_studentId` VARCHAR(9))
BEGIN
		DECLARE var_facultyCode VARCHAR(15) DEFAULT '';
		DECLARE var_sex VARCHAR(1) DEFAULT '';
		DECLARE var_part DECIMAL(2,1);
	
		SELECT facultyCode INTO var_facultyCode 
		FROM studentProgramme sp 
		WHERE studentId = inp_studentId;
	
		SELECT sex INTO var_sex 
		FROM studentDetails sd 
		WHERE studentId = inp_studentId;
	
		SELECT part INTO var_part
		FROM studentProgramme sp  
		WHERE studentId = inp_studentId;
	
	
		SELECT sd.studentId
		FROM studentDetails sd 
			JOIN studentProgramme sp 
			ON sd.studentId = sp.studentId 
			WHERE sp.facultyCODE = var_facultyCode
			AND sp.part = var_part
			AND sd.sex = var_sex
            AND sd.studentId != inp_studentId;	
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetRequestsFM`(IN inp_level DECIMAL(2,1))
BEGIN
		SELECT rrfh.studentId 
		FROM requestRoomFemaleHostel rrfh 
		JOIN studentProgramme sp ON rrfh.studentId  = sp.studentId 
		WHERE sp.part = inp_level AND rrfh.marker = 0 
		ORDER BY rrfh.`timeStamp` ;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetRequestsMM`(IN inp_level DECIMAL(2,1))
BEGIN
		SELECT rrfh.studentId 
		FROM requestRoomMaleHostel rrfh 
		JOIN studentProgramme sp ON rrfh.studentId  = sp.studentId 
		WHERE sp.part = inp_level AND rrfh.marker = 0 
		ORDER BY rrfh.`timeStamp` ;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetSetStatusFM`(IN inp_studentId VARCHAR(9) , IN inp_level DECIMAL(2,1))
BEGIN
		SELECT prmfh.studentId,
		COUNT(confirmStatus) as confirmStatus
		FROM preferredRoomMatesFemaleHostel as prmfh
		JOIN studentProgramme sp ON prmfh.studentId = sp.studentId
		WHERE sp.part = inp_level
		AND prmfh.studentId != inp_studentId
		AND prmfh.confirmStatus = 1 
		GROUP BY prmfh.studentId;

	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetSetStatusMM`(inp_studentId varchar(9), inp_level decimal(2,1))
BEGIN
		SELECT prmmh.studentId,
		COUNT(confirmStatus) as confirmStatus
		FROM preferredRoomMatesMaleHostel as prmmh
		JOIN studentProgramme sp ON prmmh.studentId = sp.studentId
		WHERE sp.part = inp_level
		AND prmmh.studentId != inp_studentId
		AND prmmh.confirmStatus = 1 
		GROUP BY prmmh.studentId;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetStudentLeftPanelDetails`(IN `inp_studentId` VARCHAR(9))
BEGIN
		SELECT sd.studentId, sd.fullname, lp.programmeName, sp.part
		FROM studentDetails sd 
		JOIN studentProgramme sp ON sd.studentId = sp.studentId 
        AND sd.studentId = inp_studentId
		JOIN lsuProgrammes lp ON sp.programmeCODE = lp.programmeCode;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetStudentLogInDetails`(IN `inp_studentId` VARCHAR(9))
BEGIN
		
		DECLARE getStatus INT DEFAULT 0;
	       
	    SELECT status INTO getStatus 
	    FROM studentLogInTimeStamps 
	    WHERE studentID = inp_studentId;
	        
	    IF getStatus = 0 THEN
	    	SELECT studentId, nationalId 
	        FROM studentDetails 
	        WHERE studentId = inp_studentId;
	            
	    ELSEIF getStatus = 1 THEN
	        SELECT studentId, password 
	        FROM studentLogInDetails 
	        WHERE studentId = inp_studentId;
	    END IF;
	
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetStudentSearchDetails`(IN `inp_studentId` VARCHAR(9))
BEGIN
		SELECT fullName, studentId
		FROM studentDetails WHERE studentId LIKE(CONCAT(inp_studentId, "", "%"));
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetStudentSearchDetails1`(IN `inp_studentId` VARCHAR(9), IN `inp_searchStudentId` VARCHAR(9))
BEGIN
		DECLARE var_sex VARCHAR(1) DEFAULT '';
		DECLARE var_facultyCode VARCHAR(15) DEFAULT '';
		DECLARE var_part DECIMAL(2,1);
		

		SELECT sex INTO var_sex
        FROM studentDetails 
        WHERE studentId = inp_studentId;
       
       	SELECT facultyCode INTO var_facultyCode
       	FROM studentProgramme 
       	WHERE studentId = inp_studentId;
       
        SELECT part INTO var_part
       	FROM studentProgramme 
       	WHERE studentId = inp_studentId;
        
        SELECT var_sex, var_facultyCode, var_part;
       
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetStudentSearchDetails2`(IN `inp_studentId` VARCHAR(9), IN `inp_searchStudentId` VARCHAR(9))
BEGIN
		DECLARE var_sex VARCHAR(1) DEFAULT '';
		DECLARE var_facultyCode VARCHAR(15) DEFAULT '';
		DECLARE var_part DECIMAL(2,1);
		

		SELECT sex INTO var_sex
        FROM studentDetails 
        WHERE studentId = inp_studentId;
       
       	SELECT facultyCode INTO var_facultyCode
       	FROM studentProgramme 
       	WHERE studentId = inp_studentId;
       
        SELECT part INTO var_part
       	FROM studentProgramme 
       	WHERE studentId = inp_studentId;
       
       	SELECT sd.fullName, sd.studentId
		FROM studentDetails sd
			JOIN studentProgramme sp ON sd.studentId = sp.studentId
			WHERE sd.studentId LIKE(CONCAT(inp_searchStudentId, "", "%"))
            AND NOT sd.studentId = inp_studentId
			AND sd.sex = var_sex
			AND sp.facultyCODE = var_facultyCode
			AND sp.part = var_part;
       
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetTuitionDetails`(IN inp_studentId VARCHAR(9))
BEGIN
		SELECT sd.fullname, std.tuitionPaid, lt.tuition
		FROM studentDetails sd
		JOIN studentTuitionDetails std ON sd.studentId = std.studentId 
		AND std.studentId = inp_studentId
		JOIN lsuTuition lt ON std.programmeCODE = lt.programmeCode ;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-05 20:06:48
