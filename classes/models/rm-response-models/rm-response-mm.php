<?php 
  
  require_once '../classes/db/db.php';
  include_once '../classes/interfaces/rm-response-interface.php';
  
  class RMResponseMM extends Db implements RMResponseInterface{
    public function setResponse($studentId, $res){          
      $sql = " UPDATE preferredRoomMatesMaleHostel SET confirmStatus = ?
              WHERE roomMateId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $execute = $stmt->execute([$res, $studentId]);
    }
    
    public function setRecordRequest($studentId){
      $sql = " INSERT INTO requestsMaleHostel(studentId)
              VALUES (?); ";
      $stmt = $this->connect()->prepare($sql);
      $execute = $stmt->execute([$studentId]); 
    }
    
    public function deleteRoomMateAssoc($studentId){
      $sql = " DELETE FROM preferredRoomMatesMaleHostel WHERE roomMateId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
    }
    
  }//--end of class
  

  
  