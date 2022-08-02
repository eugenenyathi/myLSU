<?php 
  
  include_once '../interfaces/randomize-mates-interface.php';
  require_once '../db/db.php';
  
  class RandomizeMatesMM extends Db implements RandomizeMatesInterface{
    public function isFreeMate($studentId){
      $sql = " SELECT studentId FROM requestsMaleHostel WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->studentId : false;
    }
    
    
  }//endofclass
  