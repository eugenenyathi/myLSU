<?php 
  
  include_once '../interfaces/randomize-mates-interface.php';
  include_once '../db/db.php';
  
  class RandomizeMatesFM extends Db implements RandomizeMatesInterface{
    public function isFreeMate($studentId){
      $sql = " SELECT studentId FROM requestsFemaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? false : true;
    }
    
    public function hasRoomRequest($studentId){
      $sql = " SELECT studentId FROM requestRoomFemaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? false : true;
    }
    
    public function isFreeMateTwo($studentId){
      $sql = " SELECT studentId, roomMateId FROM preferredRoomMatesFemaleHostel
               WHERE studentId = '$studentId' OR roomMateId = '$studentId' ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? false : true;
    }
    
    public function registerRequest($studentId){
      $sql = " INSERT INTO requestRoomFemaleHostel(studentId) VALUES('$studentId'); ";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    public function registerPreferredRoomMates($studentId, $roomMateId){
      $sql = " INSERT INTO preferredRoomMatesFemaleHostel(studentId, roomMateId)
               VALUES ('$studentId', '$roomMateId'); ";
      $stmt = $this->connect()->query($sql);        

      return $stmt ? true : false;
    }
    
    public function registerRequests($studentId){
        $sql = " INSERT INTO requestsFemaleHostel(studentId) VALUES ('$studentId'); ";
        $stmt = $this->connect()->query($sql);        

        return $stmt ? true : false;
    }
    
    public function registerResponses($studentId, $response){
      $sql = " UPDATE preferredRoomMatesFemaleHostel 
               SET confirmStatus = $response 
               WHERE roomMateId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);        

      return $stmt ? true : false;
    }
    
    public function getRequestRoomTable(){
      $sql = " SELECT * FROM requestRoomFemaleHostel LIMIT 3; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];
    }
    
    public function getPreferredRoomMates(){
      $sql = " SELECT * FROM preferredRoomMatesFemaleHostel LIMIT 3; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);        

      return $data ? $data : [];
    }
    
    public function getRequestsTable(){
      $sql = " SELECT * FROM requestsFemaleHostel LIMIT 3";
      $stmt = $this->connect()->query($sql); 
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];  
    }
    
  }//endofclass