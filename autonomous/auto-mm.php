<?php 

  include_once 'auto-interface.php';
  require_once '../classes/db/db.php';
  
  class AutoMM extends Db implements AutoInterface {
    public function getRequestRoomStatus($studentId){
      $sql = " SELECT studentId FROM requestsMaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? true : false;
    }
    
    public function setConfirmStatus($studentId, $value){
      $sql = " UPDATE preferredRoomMatesMaleHostel SET confirmStatus = $value WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql); 
      
      return $stmt ? true : false; 
    }
    
    public function deleteMainRequest($studentId){
      $sql = " DELETE FROM requestRoomMaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql); 
      
      return $stmt ? true : false; 
    }
    
    public function deleteRequest($studentId){
      $sql = " DELETE FROM requestsMaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql); 
      
      return $stmt ? true : false; 
    }
    
    public function deleteRoomMateAssoc($studentId){
      $sql = " DELETE FROM preferredRoomMatesMaleHostel WHERE studentId = '$studentId' ";
      $stmt = $this->connect()->query($sql); 
      
      return $stmt ? true : false; 
    }
    
  }//endofclass
  

 ?>