<?php 
  include_once '../classes/interfaces/rm-response-interface.php';
  
  class RMResponseContr {
    
    private $studentId; //current session student id
    private $studentResponse; //reoom-mate response
    private $responseModel;
    
    public function __construct($currentSessionStudentId, $response_data){
      $this->studentId = $currentSessionStudentId;
      $this->studentResponse = $response_data['response'];
    }
    
    public function responseInterface(RMResponseInterface $dataModel){
      $this->responseModel = $dataModel;
    }
    
    public function response(){
      $this->responseModel->setResponse($this->studentId, $this->studentResponse);
      
      if($this->studentResponse == 1){
        $this->recordRequest();
      }elseif($this->studentResponse == -1){
        $this->deleteAssoc();
      }
      
      //load the ViewContr

    }
    
    public function recordRequest(){
      $this->responseModel->setRecordRequest($this->studentId);
    }
    
    public function deleteAssoc(){
      $this->responseModel->deleteRoomMateAssoc($this->studentId);
    }
    
    
  }//end of class