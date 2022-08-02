<?php 

  include_once '../classes/interfaces/rr-interface.php';
  require_once '../classes/db/db.php';

  class RequestRoomFM extends Db implements RequestRoomInterface{
    
    public function getRequestRoomStatus($studentId){
      $sql = " SELECT studentId FROM requestRoomFemaleHostel WHERE studentId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $stmt->fetch();
      
      return $stmt->rowCount() ?? $stmt->rowCount();
      
    }
    
    public function registerRequest($requestingStudentId){
      $sql = " INSERT INTO requestRoomFemaleHostel(studentId) VALUES(?); ";
      $stmt = $this->connect()->prepare($sql);
      $execute = $stmt->execute([$requestingStudentId]);
      
      return $execute ? true : false;
    }
        
    public function registerPreferredRoomMates($requestingStudentId, $roomMateId){
      $sql = " INSERT INTO preferredRoomMatesFemaleHostel(studentId, roomMateId)
              VALUES (?,?); ";
      $stmt = $this->connect()->prepare($sql);
      $execute = $stmt->execute([$requestingStudentId, $roomMateId]); 
      
      return $execute ? true : false;
    }
    
    public function setRecordRequest($requestingStudentId){
      $sql = " INSERT INTO requestsFemaleHostel(studentId)
              VALUES (?); ";
      $stmt = $this->connect()->prepare($sql);
      $execute = $stmt->execute([$requestingStudentId]); 
    }
    
    public function deleteRegisteredRequest($requestingStudentId){
      $sql = "DELETE FROM requestRoomFemaleHostel WHERE studentId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $execute = $stmt->execute([$requestingStudentId]);
      
      return $execute ? true : false;
    }
    
    public function getPreferredNumOfRoomMates($requestingStudentId){
      $sql = " SELECT * FROM preferredRoomMatesFemaleHostel WHERE studentId = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$requestingStudentId]);
      $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $stmt->rowCount() ? $stmt->rowCount() : 0;
      
    }
    
  } //end of class
