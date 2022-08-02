<?php 

  include_once '../classes/db/db.php';
  
  class LogInModel extends Db{

    protected function getStudentFaculty($studentId){
      $sql = " SELECT sp.facultyCODE
               FROM studentProgramme sp 
               JOIN faculties f ON sp.facultyCODE = f.facultyCode 
               WHERE sp.studentId = ?;
             ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->facultyCODE : -1;      
    }
    
    protected function getFacultyAccStatus($studentId){
      $sql = " SELECT fas.accStatus 
               FROM facultyAccStatus fas 
               JOIN studentProgramme sp ON fas.facultyCode = sp.facultyCODE 
               WHERE sp.studentId = ? AND fas.part = ROUND(sp.part); 
             ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->accStatus : -1;      
    }
    
    protected function getlogInStatus($studentId){
        $sql = " SELECT status FROM studentLogInTimeStamps WHERE studentId = ?; ";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$studentId]);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $data ? $data->status : -1;
    }
      
    protected function getlogInDetails($studentId){
      $sql = " call spGetStudentLogInDetails(?); ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data : -1;
    }
    
    protected function getTimeStampsInfo($studentId){
      $sql = " SELECT status, currentTimeStamp FROM studentLogInTimeStamps
               WHERE studentId = ?; ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
               
      return $data ? $data : -1;      
    }
    
    protected function setPreviousTimeStamp($studentId, $currentTimeStamp){
      $sql = " UPDATE studentLogInTimeStamps
               SET previousTimeStamp = '$currentTimeStamp'
               WHERE studentId = '$studentId'
            ";
      $stmt =  $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
    
    protected function setCurrentTimeStamp($studentId){
      $sql = " UPDATE studentLogInTimeStamps
               SET currentTimeStamp = CURRENT_TIMESTAMP()
               WHERE studentId = '$studentId'
            ";
      $stmt =  $this->connect()->query($sql);
      
      return $stmt ? true : false;
    }
  
  }//end of class