<?php 

  include_once '../db/db.php';
  
  class RandomizeMatesModel extends Db{
    
    protected function getStudentIds($sex){
      $sql = " SELECT studentId FROM studentDetails WHERE sex = '$sex' LIMIT 40 ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : 0;
    }
    
    protected function getMaxNumOfMates(){
      $sql = " SELECT numPerRoom FROM numOfStudentsPerRoom; ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data->numPerRoom : false;
    }
    
    protected function getMatchingStudents($studentId){
      $sql = " call spGetMatchingStudents('$studentId')";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];
    }
    
    protected function getLevelStudents($level, $facultyCode, $sex){
      $sql = " call spGetLevelStudents($level, '$facultyCode', '$sex') ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : [];
    }
  }//endofclass