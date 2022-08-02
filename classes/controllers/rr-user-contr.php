<?php 

  class RequestRoomUser{
    
    private $requestingStudentId;
    private $roomMate1;
    private $roomMate2;
    
    
    public function __construct($requestingStudentId ,$selectedRoomMates){
      $this->requestingStudentId = $requestingStudentId;
      $this->roomMate1 = $selectedRoomMates['roomMate1'];
      $this->roomMate2 = $selectedRoomMates['roomMate2'];
    }
    
    public function validateData($requestMethod, $contentType, $selectedRoomMates){
      $this->requestMethod($requestMethod);
      $this->contentType($contentType);
      $this->dataFormat($selectedRoomMates);
    }
    
    public function checkUserInput(){
      if($this->invalidStudentId()){
        exit("2000");
      }
      else if($this->invalidLength()){
        exit("990");
      }
    }
    
    private function requestMethod($requestMethod){
      if($requestMethod != "POST"){
        exit("1000");
      }
    }
    
    private function contentType($contentType){
      if($contentType != "application/json"){
        exit("1100");
      }
    }
    
    private function dataFormat($selectedRoomMates){
      if(!is_array($selectedRoomMates)){
        exit("1110");
      }
    }
    
    private function invalidStudentId(){
      if(!preg_match("/^L0\d{6}[A-Z]$/",$this->roomMate1) ||
       !preg_match("/^L0\d{6}[A-Z]$/",$this->roomMate2)){
         return true;
       }
       
       return false;
    }
    
    private function invalidLength(){
      if(strlen($this->roomMate1) != 9 || strlen($this->roomMate2) != 9){
        return true;
      }
      
      return false;
    }
    
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  