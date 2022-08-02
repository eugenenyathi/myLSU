<?php 
  
  include_once './classes/interfaces/ctr-panel-interface.php';
  require_once './classes/db/db.php';
  
  class CtrPanelMM extends Db implements CtrPanelInterface{
    
    public function getRoomAllocStatus($studentId){
      $sql = " SELECT marker FROM requestsMaleHostel WHERE studentId = ?; ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->marker : false;
    }
    
    public function getAllocatedRoomNo($studentId){
      $sql = " SELECT roomNumber FROM roomOccupiersMaleHostel WHERE studentId = ?; ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->roomNumber : false;
    }
    
    public function getRoomAllocRoomMates($roomNo, $studentId){
      $sql = " SELECT sd.fullName, sd.studentId 
               FROM studentDetails sd 
               JOIN roomOccupiersMaleHostel romh  ON sd.studentId =  romh.studentId 
               WHERE romh.roomNumber = $roomNo AND romh.studentId != ? ;
            ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : false;
    }
    
    public function getRequestRoomStatus($studentId){
      $sql = " SELECT studentId FROM requestRoomMaleHostel WHERE studentId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $stmt->fetch();
      
      return $stmt->rowCount() ?? $stmt->rowCount();
      
    }
    
    //getting the id of the student who made the request 
    //and selected the current student as a preferred room-mate
    public function getRequestStudentId($studentId){
      $sql = " SELECT studentId FROM preferredRoomMatesMaleHostel WHERE roomMateId = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);

      return $data->studentId;
    }
        
    public function getRoomMates($studentId){
      $sql = "SELECT roomMateId FROM preferredRoomMatesMaleHostel WHERE studentId  =  ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];      
    }
    
    public function getRoomRequestDate($studentId){
      
      $sql = " SELECT timeStamp FROM requestRoomMaleHostel WHERE studentId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->timeStamp : false;
    }
    
    public function getRoomMateStatus($studentId){
      $sql = " SELECT roomMateId FROM preferredRoomMatesMaleHostel WHERE roomMateId = ?  ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $stmt->fetch();
      
      return $stmt->rowCount() ?? $stmt->rowCount();
      
    }
    
    //getting the id of the student who made the request 
    //and selected the current student as a preferred room-mate
    public function getMyRoomMates($requestRoomMateId, $studentId){
      $sql = " SELECT studentId, roomMateId  FROM preferredRoomMatesMaleHostel 
               WHERE studentId = ? AND roomMateId != ?; ";           
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$requestRoomMateId, $studentId]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];      
    }
    
    public function getRequestRoomMateData($requestRoomMateId){
      $sql = " SELECT studentId, fullName FROM studentDetails 
               WHERE studentId = '{$requestRoomMateId}' ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$requestRoomMateId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data;
    }
    
    public function getRoomMateConfirmStatus($studentId){
      $sql = " SELECT confirmStatus FROM preferredRoomMatesMaleHostel WHERE roomMateId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);

      return $data->confirmStatus;
    }

    public function getNumOfRoomMates($roomNo){
      $sql = " SELECT COUNT(*) AS count FROM roomOccupiersMaleHostel 
                 WHERE roomNumber = $roomNo; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
        
      return $data ? $data->count : false;
    }
      
    public function getRoomRequest($studentId){
      $sql = " SELECT marker FROM requestsMaleHostel WHERE studentId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);

      return $data ? $data->marker : -1;
    }
      
  } //--end of class
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  