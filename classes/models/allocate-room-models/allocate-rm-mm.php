<?php 

  include_once '../classes/interfaces/allocate-room-interface.php';
  require_once '../classes/db/db.php';
  
  class AllocateRoomMM extends Db implements AllocateRoomInterface{
    public function getRequests($level){
      $sql = "call spGetRequestsMM($level);";
      $stmt = $this->connect()->query($sql);
      
      return $stmt->fetchAll(PDO::FETCH_OBJ);

    }
    
    public function getAllRequests($level){
      $sql = " SELECT rmh.studentId FROM requestsMaleHostel rmh 
               JOIN studentProgramme sp ON rmh.studentId = sp.studentId 
               WHERE sp.part = $level ;
            ";
      $stmt = $this->connect()->query($sql);
      
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getRequestProcessMarker($studentId){
      $sql = " SELECT marker FROM requestRoomMaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data->marker;
    }
    
    public function getRoomMates($studentId, $limit){
      $sql = " SELECT roomMateId FROM preferredRoomMatesMaleHostel 
               WHERE studentId = '$studentId' AND confirmStatus = 1
               LIMIT $limit ;
              ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];
    }
    
    public function getRoomMate($studentId){
      $sql = " SELECT roomMateId FROM preferredRoomMatesMaleHostel 
               WHERE studentId =  '$studentId' AND confirmStatus = 1 ;";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
    
      return $data->roomMateId;
    }
    
    public function deleteRoomMate($studentId){
      $sql = " DELETE from preferredRoomMatesMaleHostel WHERE roomMateId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      return $stmt ? true : false;
    }
    
    public function deleteRoomMates($studentId){
      $sql = " DELETE from preferredRoomMatesMaleHostel 
               WHERE studentId = '$studentId' OR roomMateId = '$studentId' ;
            ";
      $stmt = $this->connect()->query($sql);
      return $stmt ? true : false;
    }
    
    public function getCountPositiveStatus($studentId){
      $sql = " SELECT COUNT(*) AS count FROM preferredRoomMatesMaleHostel 
               WHERE confirmStatus = 1 AND studentId = '$studentId' ;
             ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data->count;
    }
    public function getNegativeProcessMarker($level){
      $sql = " SELECT rrmh.studentId FROM requestRoomMaleHostel rrmh 
               JOIN studentProgramme sp ON rrmh.studentId = sp.studentId 
               WHERE rrmh.marker = -1 AND sp.part = $level ;
              ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->studentId : false;
    }
    
    public function getSetStatus($studentId, $level){  
      $sql = "call spGetSetStatusMM('$studentId', $level)";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : false;
    }
    
    public function getRoomMateConfirmStatus($studentId){
      $sql = " SELECT confirmStatus FROM preferredRoomMatesMaleHostel WHERE roomMateId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
    
      return $data->confirmStatus;
    }
    
    public function getAuditRequestMarker($studentId){
      $sql = " SELECT marker FROM requestsMaleHostel WHERE studentId = '$studentId'; ";  
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->marker : false;
    }
    
    public function getStudentRoomAllocStatus($studentId){
      $sql = " SELECT roomNumber FROM roomOccupiersMaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? true : false;
    }
    
    public function setStudentRoomAllocStatus($studentId){
      $sql = " UPDATE requestsMaleHostel SET marker = 1 WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    public function getCountRoomOccupants($roomNo){
        $sql = " SELECT COUNT(*) AS count FROM roomOccupiersMaleHostel 
                 WHERE roomNumber = $roomNo; ";
        $stmt = $this->connect()->query($sql);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $data->count;
    }
    
    public function getAuditRooms(){
      $sql = " SELECT DISTINCT roomNumber FROM roomOccupiersMaleHostel; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data;
    }
    
    public function setNewRoomOccupant($roomNo, $studentId){
        $sql = " INSERT INTO roomOccupiersMaleHostel(roomNumber, studentId)
                 VALUES ($roomNo, '$studentId');
               ";
        $stmt = $this->connect()->query($sql);
        
        return $stmt ? true : false;
    }
    
    public function setGrantRoomRequest($roomNumber, $studentId){
      $sql = " INSERT INTO roomRequestGrantedMaleHostel (roomNumber, studentId) 
               VALUES($roomNumber, '$studentId'); 
              ";
      $stmt = $this->connect()->query($sql);
              
      return $stmt ? true : false;
    }
    
    public function getFreeRoom(){
      $sql = "call spGetFreeRoomMM();";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->roomNumber : false;
    }
    
    public function setGrantRoom($roomNumber, $studentId){
      $sql = " INSERT INTO roomOccupiersMaleHostel (roomNumber, studentId) 
               VALUES($roomNumber, '$studentId'); 
              ";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    public function setRoomAvaiStatus($roomNumber){
      $sql = " UPDATE roomAvailabityStatusMaleHostel 
               SET roomStatus = 1 WHERE roomNumber = $roomNumber ;";
      $stmt = $this->connect()->query($sql);
               
      return $stmt ? true : false;
    }
    
    public function setRequestProcessed($studentId, $marker){
      $sql = " UPDATE requestRoomMaleHostel SET marker = $marker WHERE studentId = '$studentId' ; ";
      $stmt = $this->connect()->query($sql);
               
      return $stmt ? true : false;
    }
    
    public function getNegativeStatus($studentId){
      $sql = " SELECT COUNT(*) AS count FROM preferredRoomMatesMaleHostel 
               WHERE studentId = '$studentId' AND confirmStatus = 0
               LIMIT 1 ;
             ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->count : false;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  }//--end of class