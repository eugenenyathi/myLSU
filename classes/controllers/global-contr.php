<?php 
  
  include_once '../classes/traits/js-data-trait.php';
  include_once '../classes/models/universal-model.php';
  
  class UniversalContr extends UniversalModel{
    
    private $studentId; //current session studentId
    private $selectedRoomMates;
    
    public $studentFirstName;
    public $studentTuition;
    public $studentClearedTuition;
    public $studentTuitionOwing;
    
    public function __construct($currentSessionStudentId){
      $this->studentId = $currentSessionStudentId;
    }
    
    public function studentTuitionDetails(){
      $data = $this->pullStudentTuitionDetails($this->studentId);
      $this->studentFirstName = substr($data['fullname'], 0, strpos($data['fullname'], " "));
      $this->studentTuition =  $data['tuition'];
      $this->studentClearedTuition = $data['tuitionPaid'];
      $this->studentTuitionOwing = $this->studentTuition - $this->studentClearedTuition;
    }
    
    public function getStudentGender(){
      return $this->selectGender($this->studentId);
    }
    
    use JSDataTrait;
    
    public function RequestRoomInput($selectedRoomMates){
      $this->selectedRoomMates = $selectedRoomMates;
      
      if($this->invalidStudentId()){
        exit("2000");
      }
      else if($this->invalidLength()){
        exit("990");
      }
    }
        
    private function invalidStudentId(){
      
      foreach($this->selectedRoomMates as $studentId){
        if(!preg_match("/^L0\d{6}[A-Z]$/", $studentId)){
          return true;
        }
      }
      return false;
      
    }
    
    private function invalidLength(){   
         
      foreach($this->selectedRoomMates as $studentId){
        if(strlen($studentId) != 9){
           return true;
         }
      }   
      return false;
      
    }
    
  } //end of class