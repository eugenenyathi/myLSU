<?php 

  require_once '../classes/db/db.php';

  class AutoModel extends Db {
    
    protected function getStudentIds(){
      $sql = " SELECT studentId FROM studentDetails; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : false;
    }
    
    protected function getStudentDob($studentId){
      $sql = " SELECT DOB FROM studentDetails WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->DOB : false;
    }
    
    protected function setStudentDob($studentId, $dob){
      $sql = " UPDATE studentDetails SET DOB = '$dob' WHERE studentId = '$studentId' ";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    protected function deleteLogInDetails($studentId){
      $sql = " DELETE FROM studentLogInDetails WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    protected function resetLogInStatus($studentId){
      $sql = " UPDATE studentLogInTimeStamps SET status = 0 WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);    
      
      return $stmt ? true : false;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  }//endofclass