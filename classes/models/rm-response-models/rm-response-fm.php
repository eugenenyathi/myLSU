<?php 
  
  require_once '../classes/db/db.php';
  include_once '../classes/interfaces/rm-response-interface.php';
  
  class RMResponseFM extends Db implements RMResponseInterface{
    public function setResponse($studentId, $res){          
      $sql = " UPDATE preferredRoomMatesFemaleHostel SET confirmStatus = ?
              WHERE roomMateId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $execute = $stmt->execute([$res, $studentId]);   
    }
    
    public function setRecordRequest($studentId){
      $sql = " INSERT INTO requestsFemaleHostel(studentId)
              VALUES (?); ";
      $stmt = $this->connect()->prepare($sql);
      $execute = $stmt->execute([$studentId]); 
    }
    
    public function deleteRoomMateAssoc($studentId){
      $sql = " DELETE FROM preferredRoomMatesFemaleHostel WHERE roomMateId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
    }
    
  }

  