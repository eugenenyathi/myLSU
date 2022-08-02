<?php 

  include_once 'auto-interface.php';
  require_once '../classes/db/db.php';
  
  class AutoFM extends Db implements AutoInterface {
    public function getRequestRoomStatus($studentId){
      $sql = " SELECT studentId FROM requestsFemaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? true : false;
    }
    
    public function setConfirmStatus($studentId, $value){
      $sql = " UPDATE preferredRoomMatesFemaleHostel SET confirmStatus = $value WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql); 
      
      return $stmt ? true : false; 
    }
    
    public function deleteMainRequest($studentId){
      $sql = " DELETE FROM requestRoomFemaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql); 
      
      return $stmt ? true : false; 
    }
    
    public function deleteRequest($studentId){
      $sql = " DELETE FROM requestsFemaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql); 
      
      return $stmt ? true : false; 
    }
    
    public function deleteRoomMateAssoc($studentId){
      $sql = " DELETE FROM preferredRoomMatesFemaleHostel WHERE studentId = '$studentId' ";
      $stmt = $this->connect()->query($sql); 
      
      return $stmt ? true : false; 
    }
    
  }//endofclass

 ?>