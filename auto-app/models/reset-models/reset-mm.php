<?php 

  include_once '../db/db.php';
  include_once '../interfaces/reset-interface.php';

  class ResetMM extends Db implements ResetInterface{
    public function resetRequestsTable(){
      $sql = " DELETE FROM requestsMaleHostel;";
      $stmt = $this->connect()->query($sql);        

      return $stmt ? true : false;
    }
    
    public function resetRequestRoomTable(){
      $sql = " DELETE FROM requestRoomMaleHostel;";
      $stmt = $this->connect()->query($sql);        

      return $stmt ? true : false;
    }
    
    public function resetPreferredRoomMates(){
      $sql = " DELETE FROM preferredRoomMatesMaleHostel;";
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