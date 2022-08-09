<?php 

  include_once '../db/db.php';
  include_once '../interfaces/reset-interface.php';

  class ResetFM extends Db implements ResetInterface{
    public function resetRequestsTable(){
      $sql = " DELETE FROM requestsFemaleHostel;";
      $stmt = $this->connect()->query($sql);        

      return $stmt ? true : false;
    }
    
    public function resetRequestRoomTable(){
      $sql = " DELETE FROM requestRoomFemaleHostel;";
      $stmt = $this->connect()->query($sql);        

      return $stmt ? true : false;
    }
    
    public function resetPreferredRoomMates(){
      $sql = " DELETE FROM preferredRoomMatesFemaleHostel;";
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