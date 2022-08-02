<?php 

  include_once '../classes/views/view-interface.php';
  require_once '../classes/db/db.php';
  
  
  class ViewFM extends Db implements ViewInterface{
    
    public function getRequestRoomStatus($studentId){
      $sql = " SELECT studentId FROM requestRoomFemaleHostel WHERE studentId = ? ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$studentId]);
      $stmt->fetch();
      
      return $stmt->rowCount() ?? $stmt->rowCount();
      
    }


    public function getRoomRequestDate($studentId){
      $sql = " SELECT timeStamp FROM requestRoomFemaleHostel WHERE studentId = '$studentId' ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);

      return $data ? $data->timeStamp : false;
    }

    public function getRoomMates($studentId){
      $sql = "SELECT roomMateId FROM preferredRoomMatesFemaleHostel WHERE studentId  =  '$studentId' ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      
      return $data ? $data : false;
    }

    public function getStudentDetails($studentId){
      $sql = " SELECT fullName, studentId 
               FROM studentDetails 
               WHERE studentId = '$studentId'; 
            ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data : false;   
    }

    public function getRoomMateStatus($studentId){
    $sql = " SELECT roomMateId FROM preferredRoomMatesFemaleHostel WHERE roomMateId = '$studentId'  ";
    $stmt = $this->connect()->query($sql);
    $stmt->fetch();

    return $stmt->rowCount() ?? $stmt->rowCount();

    }

    //getting the id of the student who made the request 
    //and selected the current student as a preferred room-mate
    public function getRequestStudentId($studentId){
    $sql = " SELECT studentId FROM preferredRoomMatesFemaleHostel WHERE roomMateId = '$studentId' ";
    $stmt = $this->connect()->query($sql);
    $data = $stmt->fetch(PDO::FETCH_OBJ);

     return $data->studentId;
    }  

    //this function gets the room-mates of
    //current session student which were selected 
    //by the requesting student id
    public function getMyRoomMates($requestRoomMateId, $studentId){
    $sql = " SELECT studentId, roomMateId  FROM preferredRoomMatesFemaleHostel 
             WHERE studentId = '$requestRoomMateId' AND roomMateId != '$studentId'; ";           
    $stmt = $this->connect()->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data ? $data : [];    
    }

    public function getRequestRoomMateData($requestRoomMateId){
      $sql = " SELECT studentId, fullName FROM studentDetails 
               WHERE studentId = '$requestRoomMateId' ";
      $stmt = $this->connect()->query($sql);
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      
      return $data ? $data : false;   
    }


  }//endofclass
  