<?php
 
  include_once '../classes/views/view-interface.php';
  include_once '../universal/universal-model.php';
 
  class ViewContr extends UniversalModel{
    
    private $studentId;
    private $requestRoomMateId;
    private $requestRoomMateName;
    
    private $viewModel;
    
    private $requestRoomDate;
    private $preferredRoomMates;
    private $selectedRoomMates;
    
    private $studentFirstName;
    private $studentTuition;
    private $studentClearedTuition;
    private $studentTuitionOwing;
    
    private $studentsPerRoom;
    
    public function __construct($studentId){
      $this->studentId = $studentId;
    }
    
    public function setViewModel(ViewInterface $viewModel){
      $this->viewModel = $viewModel;
    }
    
    public function loadView(){
      if($this->roomMateStatus()){
        $this->selectedMateView();
      }
      else{
        $this->defaultView();
      }
    }
    
    public function defaultView(){
      //set the name and tuition of the current session student 
      $this->studentTuitionDetails();
      //set the number of allowed roommates
      $this->studentsPerRoom = $this->getNumOfStudentsPerRoom() - 1;
      
      //prepare the response data-structure 
      $response = [
        "code" => "5000",
        "viewType" => "defaultView",
        "studentFirstName" => $this->studentFirstName,
        "tuitionPaid" => $this->studentClearedTuition,
        "tuitionOwing" => $this->studentTuitionOwing,
        "studentsPerRoom" => $this->studentsPerRoom
      ];
            
      exit(json_encode($response));
    }
    
    public function confirmedMateView(){
      //setting up defaults values
      $this->setUpDefaults();
      $roomMates = $this->myRoomMates();
      $this->preferredRoomMates = $this->selectedRoomMatesDetails($roomMates);
      
      $response = [
        "code" => "5000",
        "viewType" => "confirmedMateView",
        "studentFirstName" => $this->studentFirstName,
        "requestRoomDate" => $this->requestRoomDate,
        "requestRoomMateName" => $this->requestRoomMateName,
        "tuitionPaid" => $this->studentClearedTuition,
        "tuitionOwing" => $this->studentTuitionOwing,
        "roomMates" => $this->preferredRoomMates
      ];
        
      exit(json_encode($response));
    }
    
    public function selectedMateView(){
      //setting up defaults values
      $this->setUpDefaults();
      $roomMates = $this->myRoomMates();
      $this->selectedRoomMates = $this->selectedRoomMatesDetails($roomMates);
      
      $response = [
        "code" => "5000",
        "viewType" => "selectedMateView",
        "studentFirstName" => $this->studentFirstName,
        "requestRoomMateName" => $this->requestRoomMateName,
        "tuitionPaid" => $this->studentClearedTuition,
        "tuitionOwing" => $this->studentTuitionOwing,
        "roomMates" => $this->selectedRoomMates
      ];
        
      exit(json_encode($response));
    }
    
    public function preferredMateView(){
      //if the logInStatus is true and the student made a request.
      if($this->getLogInStatus($this->studentId) == -1 && $this->requestRoomStatus() == false){
        
        $response = [ "code" => "100"];
        exit(json_encode($response));
      }
      
      //get the roommates 
      $roomMateIds = $this->roomMates();
      //wrap students with their personal details 
      $this->preferredRoomMates = $this->roomMateDetails($roomMateIds);
      //set the name and tuition of the current session student 
      $this->studentTuitionDetails();
      //set the request - date
      $this->requestRoomDate = $this->setDate();
      //prepare the response data-structure 
      $response = [
        "code" => "5000",
        "studentFirstName" => $this->studentFirstName,
        "tuitionPaid" => $this->studentClearedTuition,
        "tuitionOwing" => $this->studentTuitionOwing,
        "requestRoomDate" => $this->requestRoomDate,
        "roomMates" => $this->preferredRoomMates
      ];
            
      exit(json_encode($response));
      
    }
    
    private function setUpDefaults(){
      $this->studentTuitionDetails();
      $this->requestRoomMateId = $this->requestStudentId();
      $this->requestRoomMateName = $this->getRequestRoomMateIdName($this->requestRoomMateId);
      $this->requestRoomMateName = substr($this->requestRoomMateName, 0 , strpos($this->requestRoomMateName, " "));
      $this->requestRoomDate = $this->setDate();
    }
    
    private function selectedRoomMatesDetails($roomMateIds){
      $roomMates = [];
      $roomMates[] = $this->requestRoomMateData();
      
      foreach($roomMateIds as $roomMate){
        $roomMateId = $roomMate->roomMateId;
        $roomMates[] = $this->studentDetails($roomMateId);
      }
      
      return $roomMates;
    }
    //clothe the raw id's with their personal details
    private function roomMateDetails($roomMateIds){
      $roomMates = [];
      
      foreach($roomMateIds as $roomMate){
        $roomMateId = $roomMate->roomMateId;
        $roomMates[] = $this->studentDetails($roomMateId);
      }
      
      return $roomMates;
    }
    
    private function studentTuitionDetails(){
      $data = $this->pullStudentTuitionDetails($this->studentId);
      $this->studentFirstName = substr($data['fullname'], 0, strpos($data['fullname'], " "));
      $this->studentTuition =  $data['tuition'];
      $this->studentClearedTuition = $data['tuitionPaid'];
      $this->studentTuitionOwing = $this->studentTuition - $this->studentClearedTuition;
    }
        
    private function studentDetails($studentId){
      return $this->viewModel->getStudentDetails($studentId);
    }
    
    // private function setDate(){
    //   $requestRoomDate = $this->requestRoomDate();
    //   $requestRoomDate = strtotime($requestRoomDate->timeStamp);
    // 
    //   $date = date('d-m-y', $requestRoomDate);
    //   $currentDate = date('d-m-y');
    // 
    //   if($date == $currentDate){
    //       return date('H:i:sA', $requestRoomDate);
    //   }else{
    //       return date("l d M Y H:i:sA", $requestRoomDate);          
    //   }
    // 
    // }
    
    private function setDate(){
      
      if($this->requestRoomStatus()){
        $requestRoomDate = $this->requestRoomDate($this->studentId);
      }
      else{
        //set the requestRoomMateId
        $this->requestRoomMateId = $this->requestStudentId();
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
    
    private function requestRoomMateData(){
      return $this->viewModel->getRequestRoomMateData($this->requestRoomMateId);
    }
    
    private function myRoomMates(){
      return $this->viewModel->getMyRoomMates($this->requestRoomMateId, $this->studentId);
    }
    
    //getting the id of the student who made the request 
    //and selected the current student as a preferred room-mate
    //through the current session student's id
    private function requestStudentId(){
      return $this->viewModel->getRequestStudentId($this->studentId);
    }
    
    //checking if the current session student is listed
    // as a preferred-room-mate
    private function roomMateStatus(){
      return $this->viewModel->getRoomMateStatus($this->studentId);
    }
    
    private function requestRoomDate($studentId){
      return $this->viewModel->getRoomRequestDate($studentId);
    }
    
    private function requestRoomStatus(){
      return $this->viewModel->getRequestRoomStatus($this->studentId);
    }
    
    private function roomMates(){
      return $this->viewModel->getRoomMates($this->studentId);
    }

    
  }//endofclass