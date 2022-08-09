<?php 

  include_once '../db/db.php';

  class ResetModel extends Db{
    protected function resetLogInDetails(){
      $sql = " DELETE FROM studentLogInDetails";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    protected function resetLogInTimeStamps(){
      $sql = "UPDATE studentLogInTimeStamps SET status = 0, 
              previousTimeStamp = null, currentTimeStamp = null;";
      $stmt = $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    public function getLogInTimeStamps(){
      $sql = " SELECT studentId, status FROM studentLogInTimeStamps LIMIT 3;";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];
    }
    
    public function getLogInDetails(){
      $sql = " SELECT * FROM studentLogInDetails LIMIT 3;";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];
    }
    
  }//endofclass