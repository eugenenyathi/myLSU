<?php 
  require_once './classes/db/db.php';
  
  class CtrPanelModel extends Db{
    
    protected function pullStudentTuitionDetails($studentId){
      $sql = "call spGetTuitionDetails(?);";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      return $stmt->fetch();
    }
    
    protected function selectGender($studentId) : string {
      $sql = " SELECT sex FROM studentDetails WHERE studentId = ? ;";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $row = $stmt->fetch();
      $studentSex = $row['sex'];
      
      return $studentSex;
    }
  } //--end of class
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  