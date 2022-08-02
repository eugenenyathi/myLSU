<?php 
  
  include_once '../classes/interfaces/rr-interface.php';
  
  class RequestRoomContr{
    
    private $requestingStudentId;
    private $selectedRoomMates;
    private $requestRoomModel; //this is an object
    
    public function __construct($requestingStudentId, $selectedRoomMates){
      $this->requestingStudentId = $requestingStudentId;
      $this->selectedRoomMates = $selectedRoomMates;
    }
    
    public function getStudentGender(){
      return $this->selectGender($this->requestingStudentId);
    }
    
    public function setRequestRoomModel(RequestRoomInterface $requestRoomModel){
      $this->requestRoomModel = $requestRoomModel;
    }
    
    public function requestRoomStatus(){
      return $this->requestRoomModel ->getRequestRoomStatus($this->requestingStudentId);
    }
    
    public function requestRoom($requestStatus){
      
  //if the user has already made a request
      if($requestStatus){
        if($this->bookRoomMates() == false){  
          $response = ["code" => "5001"];
          exit(json_encode($response));
        }
      
        $response = ["code" => "5000"];
        exit(json_encode($response));
        
      }
      
  //if not -
      if($this->bookRequest() == false){
        // exit("5001 -bR");
        $response = ["code" => "5001"];
        exit(json_encode($response));
      }
      else if($this->bookRoomMates() == false){
        // exit("5001 -bookRoomMates");
        $response = ["code" => "5001"];
        exit(json_encode($response));
      }
      
      //record request
      $this->recordRequest();
      
      //continue in the request-room includes file
      
    }
    
    private function bookRequest(){
      return $this->requestRoomModel->registerRequest($this->requestingStudentId);
    }
    
    private function bookRoomMates(){
      
      foreach($this->selectedRoomMates as $roomMateId){
        $execute = 
          $this->requestRoomModel->registerPreferredRoomMates($this->requestingStudentId, $roomMateId);
          
        if($execute == false){
          return false;
        }
        
      }
      
      return true;
    }
    
    private function recordRequest(){
      $this->requestRoomModel->setRecordRequest($this->requestingStudentId);
    }
    
    public function preferredNumOfRoomMates(){
      $this->requestRoomModel->getPreferredNumOfRoomMates($this->requestingStudentId);
    }
    
  } //end of class
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  