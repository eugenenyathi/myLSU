<?php 
  
  include_once '../db/db.php';
  
  
  class setRoommatesModel extends Db{
    
    protected function getStudentIds($sex){
      $sql = " SELECT studentId FROM studentDetails WHERE sex = '$sex' LIMIT 40 ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : 0;
    }
    
    protected function getLogInStatus($studentId){
      $sql = " SELECT status FROM studentLogInTimeStamps WHERE studentId = '$studentId' ; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->status : -1;
    }
    
    protected function getNationalId($studentId){
      $sql = " SELECT nationalId FROM studentDetails WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->nationalId : 0; 
    }
    
    
    protected function setPassword($studentId, $newPassword){
      $sql = " INSERT INTO studentLogInDetails(studentId, password) VALUES ('$studentId', '$newPassword'); ";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    protected function setLogInStatus($studentId){
      $sql = " UPDATE studentLogInTimeStamps SET status = 1 WHERE studentId= '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    public function getLogInTimeStamps(){
      $sql = " SELECT studentId, status FROM studentLogInTimeStamps LIMIT 3;";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];
    }
    
    public function getLogInDetails(){
      $sql = " SELECT * FROM studentLogInDetails LIMIT 3;";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];
    }
  }