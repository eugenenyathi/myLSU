<?php 

  include_once './classes/models/left-panel-model.php';

  class LeftPanelContr extends LeftPanelModel{
    private $studentId;
    
    public function __construct($studentId){
      $this->studentId = $studentId;
    }
    
    public function studentleftPanelDetails(){
      return $this->getLeftPanelDetails($this->studentId);
    }
    
    public function timeStampsInfo(){
      return $this->getTimeStampsInfo($this->studentId);
    }
    
  }//end of class