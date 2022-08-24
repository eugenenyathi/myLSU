<?php 

  include_once '../classes/interfaces/allocate-room-interface.php';
  require_once '../classes/db/db.php';

  class AllocateRoomFM extends Db implements AllocateRoomInterface{
    public function getRequests($level){
      $sql = "call spGetRequestsFM($level);";
      $stmt = $this->connect()->query($sql);
      
      return $stmt->fetchAll(PDO::FETCH_OBJ);

    }
    
    public function getAllRequests($level){
      $sql = " SELECT rfh.studentId FROM requestsFemaleHostel rfh 
               JOIN studentProgramme sp ON rfh.studentId = sp.studentId 
               WHERE sp.part = $level ;
            ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : false; 
    }
    
    public function getRequestProcessMarker($studentId){
      $sql = " SELECT marker FROM requestRoomFemaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data->marker;
    }
    
    public function getRoomMates($studentId, $limit){
      $sql = " SELECT roomMateId FROM preferredRoomMatesFemaleHostel 
               WHERE studentId = '$studentId' AND confirmStatus = 1
               LIMIT $limit ;
              ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : false;
    }
    
    public function getRoomMate($studentId){
      $sql = " SELECT roomMateId FROM preferredRoomMatesFemaleHostel 
               WHERE studentId =  '$studentId' AND confirmStatus = 1 ;";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
    
      return $data->roomMateId;
    }
    
    public function getObjectRoomMate($studentId){
      $sql = " SELECT roomMateId FROM preferredRoomMatesFemaleHostel 
               WHERE studentId = '$studentId' AND confirmStatus = 1 ;";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
    
      return $data;
    }
    
    public function deleteRoomMate($studentId){
      $sql = " DELETE from preferredRoomMatesFemaleHostel WHERE roomMateId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      return $stmt ? true : false;
    }
    
    public function deleteRoomMates($studentId){
      $sql = " DELETE FROM preferredRoomMatesFemaleHostel 
               WHERE studentId = '$studentId' OR roomMateId = '$studentId' ;
            ";
      $stmt = $this->connect()->query($sql);
      return $stmt ? true : false;
    }
    
    public function getCountPositiveStatus($studentId){
      $sql = " SELECT COUNT(*) AS count FROM preferredRoomMatesFemaleHostel 
               WHERE confirmStatus = 1 AND studentId = '$studentId' ;
             ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data->count;
    }
    public function getNegativeProcessMarker($level){
      $sql = " SELECT rrmh.studentId FROM requestRoomFemaleHostel rrmh 
               JOIN studentProgramme sp ON rrmh.studentId = sp.studentId 
               WHERE rrmh.marker = -1 AND sp.part = $level ;
              ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->studentId : false;
    }
    
    public function getSetStatus($studentId, $level){ 
      $sql = "call spGetSetStatusFM('$studentId', $level)";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    
      return $data ? $data : false;
    }
    
    public function getRoomMateConfirmStatus($studentId){
      $sql = " SELECT confirmStatus FROM preferredRoomMatesFemaleHostel WHERE roomMateId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
    
      return $data->confirmStatus;
    }
    
    public function getAuditRequestMarker($studentId){
      $sql = " SELECT marker FROM requestsFemaleHostel WHERE studentId = '$studentId'; ";  
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? true : false;
    }
    
    public function getStudentRoomAllocStatus($studentId){
      $sql = " SELECT roomNumber FROM roomOccupiersFemaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? true : false;
    }
    
    public function isFreeMate($studentId){
      $sql = " SELECT studentId FROM roomOccupiersFemaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? false : true;
    }
    
    public function setStudentRoomAllocStatus($studentId, $marker){
      $sql = " UPDATE requestsFemaleHostel SET marker = $marker WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    public function getCountRoomOccupants($roomNo){
        $sql = " SELECT COUNT(*) AS count FROM roomOccupiersFemaleHostel 
                 WHERE roomNumber = $roomNo; ";
        $stmt = $this->connect()->query($sql);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $data->count;
    }
    
    public function getAuditRooms(){
      $sql = " SELECT DISTINCT roomNumber FROM roomOccupiersFemaleHostel; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data;
    }
    
    public function setNewRoomOccupant($roomNo, $studentId){
        $sql = " INSERT INTO roomOccupiersFemaleHostel(roomNumber, studentId)
                 VALUES ($roomNo, '$studentId');
               ";
        $stmt = $this->connect()->query($sql);
        
        return $stmt ? true : false;
    }
    
    public function setGrantRoomRequest($roomNumber, $studentId){
      $sql = " INSERT INTO roomRequestGrantedFemaleHostel (roomNumber, studentId) 
               VALUES($roomNumber, '$studentId'); 
              ";
      $stmt = $this->connect()->query($sql);
              
      return $stmt ? true : false;
    }
    
    public function getFreeRoom(){
      $sql = "call spGetFreeRoomFM();";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->roomNumber : false;
    }
    
    public function setGrantRoom($roomNumber, $studentId){
      $sql = " INSERT INTO roomOccupiersFemaleHostel (roomNumber, studentId) 
               VALUES($roomNumber, '$studentId'); 
              ";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    public function setRoomAvaiStatus($roomNumber){
      $sql = " UPDATE roomAvailabityStatusFemaleHostel
               SET roomStatus = 1 WHERE roomNumber = $roomNumber ;";
      $stmt = $this->connect()->query($sql);
               
      return $stmt ? true : false;
    }
    
    public function setRequestProcessed($studentId, $marker){
      $sql = " UPDATE requestRoomFemaleHostel SET marker = $marker WHERE studentId = '$studentId' ; ";
      $stmt = $this->connect()->query($sql);
               
      return $stmt ? true : false;
    }
    
    public function getNegativeStatus($studentId){
      $sql = " SELECT COUNT(*) AS count FROM preferredRoomMatesFemaleHostel 
               WHERE studentId = '$studentId' AND confirmStatus = 0
               LIMIT 1 ;
             ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->count : false;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  }//--end of class