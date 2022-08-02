<?php 
  
  include_once './classes/db/db.php';
  
  class RightPanelModel extends Db{
    
    protected function getAccFees($studentType){
      $sql = " SELECT fee FROM  accommodationFees WHERE studentType = '$studentType' ; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data->fee;
    }
    
    protected function getStudentType($studentId){
      $sql = " SELECT studentType FROM studentProgramme WHERE studentId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data->studentType;
    }
      
    protected function getCheckInOutDates($facultyCode, $level){
      $sql = " SELECT checkIn, checkOut FROM facultyCheckInOut 
               WHERE facultyCode = '$facultyCode' AND part = '$level'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
               
      return $data ? $data : false;
    }
    
    protected function getStudentProgrammeDetails($studentId){
      $sql = " SELECT facultyCode, part FROM studentProgramme WHERE studentId = ?; ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : false;
    }
    
  }//end of class