<?php 

  include_once '../classes/db/db.php';
  
  class ResetPasswordModel extends Db{
    
    protected function getStudentId($studentId){
      $sql = " SELECT studentId FROM studentDetails WHERE studentId = ? ; ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? true : false;
    }
      
    protected function getIdentityDetails($studentId){
      $sql = " SELECT DOB, nationalId FROM studentDetails WHERE studentId = ? ; ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data : false;
    }
    
    protected function setNewPassword($studentId, $newPassword){
      $sql = " UPDATE studentLogInDetails SET password = ? WHERE studentId = ? ; ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$newPassword, $studentId]);
      
      return $stmt ? $stmt : false;      
    }
    
    protected function getLogInStatus($studentId){
      $sql = " SELECT status FROM studentLogInTimeStamps WHERE studentId = '$studentId' ; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->status : false;
    }
    
    
  }//endofclass

?>