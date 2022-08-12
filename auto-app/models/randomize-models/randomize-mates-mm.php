<?php 
  
  include_once '../interfaces/randomize-mates-interface.php';
  include_once '../db/db.php';
  
  class RandomizeMatesMM extends Db implements RandomizeMatesInterface{
    
    public function isFreeMate($studentId){
      $sql = " SELECT studentId FROM requestsMaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? false : true;
    }
    
    public function hasRoomRequest($studentId){
      $sql = " SELECT studentId FROM requestRoomMaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? false : true;
    }
    
    public function isFreeMateTwo($studentId){
      $sql = " SELECT studentId, roomMateId FROM preferredRoomMatesMaleHostel
               WHERE studentId = '$studentId' or roomMateId = '$studentId' ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? false : true;
    }
    
    
    public function registerRequest($studentId){
      $sql = " INSERT INTO requestRoomMaleHostel(studentId) VALUES('$studentId'); ";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    public function registerPreferredRoomMates($studentId, $roomMateId){
      $sql = " INSERT INTO preferredRoomMatesMaleHostel(studentId, roomMateId)
               VALUES ('$studentId', '$roomMateId'); ";
      $stmt = $this->connect()->query($sql);        

      return $stmt ? true : false;
    }
    
    public function registerRequests($studentId){
        $sql = " INSERT INTO requestsMaleHostel(studentId) VALUES ('$studentId'); ";
        $stmt = $this->connect()->query($sql);        

        return $stmt ? true : false;
    }
    
    public function registerResponses($studentId, $response){
      $sql = " UPDATE preferredRoomMatesMaleHostel 
               SET confirmStatus = $response 
               WHERE roomMateId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);        

      return $stmt ? true : false;
    }
    
    public function getRequestRoomTable(){
      $sql = " SELECT * FROM requestRoomMaleHostel LIMIT 3; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];
    }
    
    public function getPreferredRoomMates(){
      $sql = " SELECT * FROM preferredRoomMatesMaleHostel LIMIT 3; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);        

      return $data ? $data : [];
    }
    
    public function getRequestsTable(){
      $sql = " SELECT * FROM requestsMaleHostel LIMIT 3";
      $stmt = $this->connect()->query($sql); 
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];  
    }
    
    
  }//endofclass
  