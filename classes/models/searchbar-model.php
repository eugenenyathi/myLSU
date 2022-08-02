<?php 

  include_once '../classes/db/db.php';
  
  class SearchBarModel extends Db{
    
    protected function pullSearchDetails($studentId, $searchId){
      $sql = "call spGetStudentSearchDetails2(?, ?);";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId, $searchId]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : false;   
    }
    
    protected function getStudentDetails($studentId){
      $sql = " SELECT fullName, studentId 
               FROM studentDetails 
               WHERE studentId = '$studentId'; 
            ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data : false;   
    }
    
    protected function getStudentGender($studentId) : string {
      $sql = " SELECT sex FROM studentDetails WHERE studentId = ? ;";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);

      return $data->sex;
    }
    
    protected function requestRoomStatus($studentId, $table){
      $sql = " SELECT studentId FROM $table WHERE studentId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->studentId : false;
      
    }
    
    public function confirmationStatus($studentId, $table){
      $sql = " SELECT confirmStatus FROM $table WHERE roomMateId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);

      return $data ? $data->confirmStatus : false;
    }

      
    
  }//endofclass