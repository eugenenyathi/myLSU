<?php 

  include_once '../classes/db/db.php';

  class ChangePasswordModel extends Db{
    protected function getNationalId($studentId){
      $sql = " SELECT nationalId FROM studentDetails WHERE studentId = ? ; ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->nationalId : false;
    }
    
    protected function updateLogInStatus($studentId){
      $sql = " UPDATE studentLogInTimeStamps SET status = 1 WHERE studentId = '$studentId' ; ";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    protected function setPassword($studentId, $password){
      $sql = " INSERT INTO studentLogInDetails(studentId, password)
               VALUES(?, ?) ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId, $password]);

      return $stmt ? true : false;         
    }
    
    protected function getCurrentPassword($studentId){
      $sql = " SELECT password FROM studentLogInDetails WHERE studentId = ? ; ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->password : false;
    }
    
    protected function setNewPassword($studentId, $newPassword){
      $sql = " UPDATE studentLogInDetails SET password = ? WHERE studentId = ? ; ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$newPassword, $studentId]);
      
      return $stmt ? true : false;         
    }
    
  }//endofclass