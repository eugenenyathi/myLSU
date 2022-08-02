<?php 

  include_once './classes/models/right-panel-model.php';
  
  class RightPanelContr extends RightPanelModel{
    private $studentId;
    
    public function __construct($studentId){
      $this->studentId = $studentId;
    }
    
    public function accommodationFees(){
      $studentType = $this->studentType();
      
      return $this->getAccFees($studentType);
    }
    
    public function studentType(){
      return $this->getStudentType($this->studentId);
    } 
    
    public function checkInOutDates(){
      $details = $this->studentProgrammeDetails();
      $facultyCode = $details[0]->facultyCode;
      $level = floor($details[0]->part);
      
      return $this->getCheckInOutDates($facultyCode, $level);
    }
    
    public function formatDate($date){
      date_default_timezone_set('Africa/Harare');
      $formatted = strtotime($date);
      
      return date('d M Y', $formatted);
      
    }
    
    public function studentProgrammeDetails(){
      return $this->getStudentProgrammeDetails($this->studentId);
    }
    
  }//endofclass