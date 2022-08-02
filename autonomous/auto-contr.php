<?php 
  
  include_once 'auto-model.php';
  include_once 'auto-interface.php';
  
  class AutoContr extends AutoModel {
    
    private $driveModel;
    
    public function __construct(AutoInterface $driveModel){
      $this->driveModel = $driveModel;
    }
    
    public function deleteRequest($studentId){
      $this->deleteThaRequest($studentId);
      $this->deleteRoomRequest($studentId);
      $this->deleteAssoc($studentId);
      
      exit("Success.");
    }
    
    public function resetLogInDetails($studentId){
      if($this->deleteLogInDetails($studentId) == false){
        exit("Delete LogIn Details Error!");
      }
      elseif($this->resetLogInStatus($studentId) == false){
        exit("Reset LogInStatus Error!");
      }
      elseif($this->requestRoomStatus($studentId)){
        //update the confirmation marker
        $this->confirmStatus($studentId);
        //update requestRoomMaker
        $this->deleteRoomRequest($studentId);
      }
      
      exit("Success.");
    }
    
    private function deleteThaRequest($studentId){
      return $this->driveModel->deleteMainRequest($studentId);
    }
    
    private function deleteAssoc($studentId){
      return $this->driveModel->deleteRoomMateAssoc($studentId);
    }
    
    private function deleteRoomRequest($studentId){
      return $this->driveModel->deleteRequest($studentId);
    }    
    
    private function confirmStatus($studentId, $value = 0){
      return $this->driveModel->setConfirmStatus($studentId, $value);
    }
    
    private function requestRoomStatus($studentId){
      return $this->driveModel->getRequestRoomStatus($studentId);
    }
    
    public function allocateDobs(){
      $studentIds = $this->getStudentIds();
      
      foreach ($studentIds as $student) {
        $studentId = $student->studentId;
      
        if($this->studentDob($studentId) == "0000-00-00"){
          $this->insertStudentDob($studentId, $this->generateDob());
        } 
        
      }
      
      exit("Done!");
      
    }
    
    private function generateDob(){
      $day = mt_rand(1,31);
      $month = mt_rand(1,12);
      $years = [ 2002, 2003, 2001 ];
      $year = $years[$this->getYear()];
      
      $dob = implode("-", [ $year, $month, $day ]);
      
      return $dob;
    }
    
    private function getYear(){
      return mt_rand(0,2);
    }
    
    private function insertStudentDob($studentId, $dob){
      return $this->setStudentDob($studentId, $dob);
    }
    
    private function studentDob($studentId){
      return $this->getStudentDob($studentId);
    }
    
    private function studentIds(){
      return $this->getStudentIds();
    }
    
    
  }//endofclass