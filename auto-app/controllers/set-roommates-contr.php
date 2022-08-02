<?php 

  include_once '../models/set-roommates-model.php';

  class setRoommatesContr extends setRoommatesModel{
    private $studentIds = [];
    // private $studentNationalId;
    
    public function execute(){
      $studentIds = $this->studentIds('M');

      foreach($studentIds as $student){
        $studentId = $student->studentId;
        
        if($this->loginStatus($studentId) === 1){
          //everything bho
        }else{
            
          //get the nationalId of the student
          $nationalId = $this->nationalId($studentId); 
          //hased the nationalId type password 
          $hashed_password = password_hash($nationalId, PASSWORD_DEFAULT);
          //finally change the password
          $this->changePassword($studentId, $hashed_password);
          $this->changeLogInStatus($studentId);         
        
        }
      }
                  // exit("5000");  
    }
    
    public function showTables(){
      $this->loopArr($this->showLogInDetails());
      $this->loopArr($this->showLogInTimeStamps());
    }
    
    public function loopArr($arr){
      foreach($arr as $element){
          print_r($element);
      }
    }
    
    public function showLogInDetails(){
      return $this->getLogInDetails();
    }
    
    public function showLogInTimeStamps(){
      return $this->getLogInTimeStamps();
    }
    
    
    public function studentIds($sex){
      return $this->getStudentIds($sex);
    }
    
    public function loginStatus($studentId){
      return $this->getLogInStatus($studentId);
    }
    
    public function nationalId($studentId){
      return $this->getNationalId($studentId);
    }
    
    public function changePassword($studentId, $newPassword){
      return $this->setPassword($studentId, $newPassword);
    }
    
    public function changeLogInStatus($studentId){
      return $this->setLogInStatus($studentId);
    }
  }