<?php 

  if(file_exists('./classes/db/db.php') == false){
    require_once '../classes/db/db.php';
  }else{
    require_once './classes/db/db.php';
  }
  
  class UniversalModel extends Db{
    
    protected function pullStudentTuitionDetails($studentId){
      $sql = "call spGetTuitionDetails(?);";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      return $stmt->fetch();
    }
    
    protected function getStudentDetails($studentId){
      $sql = " SELECT fullName, studentId 
               FROM studentDetails 
               WHERE studentId = '$studentId'; 
            ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data : false;   
    }
    
    protected function selectGender($studentId) : string {
      $sql = " SELECT sex FROM studentDetails WHERE studentId = ? ;";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);

      return $data->sex;
    }
    
    protected function getNumOfStudentsPerRoom(){
      $sql = " SELECT numPerRoom FROM numOfStudentsPerRoom ; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data->numPerRoom;
    }
    
    protected function getLogInStatus($studentId){
      $sql = " SELECT status FROM studentLogInTimeStamps WHERE studentId = '$studentId' ; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->status : -1;
    }
    
    public function getRequestRoomMateIdName($requestRoomMateId){
      $sql = " SELECT fullName FROM studentDetails WHERE studentId = '$requestRoomMateId'; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data->fullName;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
