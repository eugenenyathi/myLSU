<?php 

  include_once './classes/db/db.php';

  class LeftPanelModel extends Db{
    
    protected function getLeftPanelDetails($studentId){
      $sql = " call spGetStudentLeftPanelDetails('$studentId') ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data : -1;
    }
    
    protected function getTimeStampsInfo($studentId){
      $sql = " SELECT status, previousTimeStamp FROM studentLogInTimeStamps
               WHERE studentId = '$studentId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
               
      return $data ? $data : -1;      
    }
    
    
  }//end of class