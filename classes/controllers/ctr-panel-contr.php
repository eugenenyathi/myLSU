<?php 

  include_once './universal/universal-model.php';
  include_once './classes/interfaces/ctr-panel-interface.php';
  
  class CtrPanelContr extends UniversalModel{
    
    private $dataModel; //this is an object
    private $studentId; //current session student id
    private $requestRoomMateId; //student id for the student who made the initial room-request
    private $otherRoomMateId;
    
    public function __construct($studentId){
      $this->studentId = $studentId;
    }
    
    public function data(CtrPanelInterface $dataModel){
      $this->dataModel = $dataModel; 
      //making the local properties be-equal to the obj passed
    }
    
    public function studentGender(){
      return $this->selectGender($this->studentId);
    }
    
    public function roomAllocStatus(){
      return $this->dataModel->getRoomAllocStatus($this->studentId);
    }
    
    public function allocatedRoomNo(){
      return $this->dataModel->getAllocatedRoomNo($this->studentId);
    }
    
    public function roomAllocRoomMates(){
      $roomNo = $this->allocatedRoomNo();
      return $this->dataModel->getRoomAllocRoomMates($roomNo,$this->studentId);
    }
    
    public function requestRoomStatus(){
      return $this->dataModel->getRequestRoomStatus($this->studentId);
    }
    
    public function roomMates(){
      $roomMates = $this->dataModel->getRoomMates($this->studentId);
      $preferredRoomMates = [];
      
      foreach($roomMates as $student){
        $studentId = $student->roomMateId;
        $preferredRoomMates[] = $this->studentDetails($studentId);
      }
        
      return $preferredRoomMates;
    }
    
    public function studentDetails($studentId){
      return $this->getStudentDetails($studentId);
    }
    
    public function setDate(){
      
      if($this->requestRoomStatus()){
        $requestRoomDate = $this->requestRoomDate($this->studentId);
      }
      else{
        //set the requestRoomMateId
        $this->requestStudentId();
        $requestRoomDate = $this->requestRoomDate($this->requestRoomMateId);
        
      }
      
      $requestRoomDate = strtotime($requestRoomDate);
      
      $date = date('d-m-y', $requestRoomDate);
      $currentDate = date('d-m-y');
      
      if($date == $currentDate){
          return date('H:i:sA', $requestRoomDate);
      }else{
          return date("l d M Y H:i:sA", $requestRoomDate);          
      }
      
    }
    
    public function requestRoomDate($studentId){
      return $this->dataModel->getRoomRequestDate($studentId);
    }
    
    //checking if the current session student is listed
    // as a preferred-room-mate
    public function roomMateStatus(){
      return $this->dataModel->getRoomMateStatus($this->studentId);
    }
    
    public function requestRoomMateName(){
      $this->requestStudentId();
      return $this->getRequestRoomMateIdName($this->requestRoomMateId);
    }
    
    //getting the id of the student who made the request 
    //and selected the current student as a preferred room-mate
    //through the current session student's id
    public function requestStudentId(){
      $this->requestRoomMateId = $this->dataModel->getRequestStudentId($this->studentId);
    }
    
    public function getRequestRoomMateId(){
      return $this->requestRoomMateId;
    }
    
    public function myRoomMates(){
      $roomMates 
        = $this->dataModel->getMyRoomMates($this->requestRoomMateId, $this->studentId);
        
      $selectedRoomMates = [];  
      $selectedRoomMates[] = $this->dataModel->getRequestRoomMateData($this->requestRoomMateId);
        
      foreach($roomMates as $student){
        $studentId = $student->roomMateId;
        $selectedRoomMates[] = $this->getStudentDetails($studentId);
      }      
        
      return $selectedRoomMates;
    }
    
    public function confirmationStatus(){
      return $this->dataModel->getRoomMateConfirmStatus($this->studentId);
    }
    
    public function roomRequest(){
      return $this->dataModel->getRoomRequest($this->studentId);
    }
    
    public function countNumOfRoomMates(){
      $roomNo = $this->allocatedRoomNo();
      
      return $this->dataModel->getNumOfRoomMates($roomNo);
    }
    
  }//end of class
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  