<?php 

  include_once '../classes/interfaces/rr-interface.php';
  require_once '../classes/db/db.php';
  
  class RequestRoomMM extends Db implements RequestRoomInterface{
    
    public function getRequestRoomStatus($studentId){
      $sql = " SELECT studentId FROM requestRoomMaleHostel WHERE studentId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $stmt->fetch();
      
      return $stmt->rowCount() ?? $stmt->rowCount();
      
    }
    
    public function registerRequest($requestingStudentId){
      $sql = " INSERT INTO requestRoomMaleHostel(studentId) VALUES(?); ";
      $stmt = $this->connect()->prepare($sql);
      $execute = $stmt->execute([$requestingStudentId]);
      
      return $execute ? true : false;
    }
    
    public function registerPreferredRoomMates($requestingStudentId, $roomMateId){
      $sql = " INSERT INTO preferredRoomMatesMaleHostel(studentId, roomMateId)
              VALUES (?,?); ";
      $stmt = $this->connect()->prepare($sql);
      $execute = $stmt->execute([$requestingStudentId, $roomMateId]); 
      
      return $execute ? true : false;
    }
        
    
    public function setRecordRequest($requestingStudentId){
      $sql = " INSERT INTO requestsMaleHostel(studentId)
              VALUES (?); ";
      $stmt = $this->connect()->prepare($sql);
      $execute = $stmt->execute([$requestingStudentId]); 
    }
    
    public function deleteRegisteredRequest($requestingStudentId){
      $sql = "DELETE FROM  requestRoomMaleHostel WHERE studentId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $execute = $stmt->execute([$requestingStudentId]);
      
      return $execute ? true : false;
    }
    
    public function getPreferredNumOfRoomMates($requestingStudentId){
      $sql = " SELECT * FROM preferredRoomMatesMaleHostel WHERE studentId = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$requestingStudentId]);
      $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $stmt->rowCount() ? $stmt->rowCount() : 0;
      
    }
    
  } //--end of class
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  