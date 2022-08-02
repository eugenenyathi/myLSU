<?php 

  include_once '../models/set-roommates-model.php';

  class setRoommatesContr extends setRoommatesModel{
    private $studentIds = [];
    // private $studentNationalId;
    
    public function execute(){
      $studentIds = $this->studentIds('M');
      
      // echo '<pre>';
      //   print_r($this->studentIds);
      // echo '</pre>';
      // exit();
      // 
      foreach($studentIds as $student){
        $studentId = $student->studentId;
        
        if($this->loginStatus($studentId) === 1){
          //everything bho
        }else{
            
          //get the nationalId of the student
          // $nationalId = $this->nationalId($studentId); 
          // $this->changePassword($studentId, $nationalId);
          // $this->changeLogInStatus($studentId);         
         
          //first change the password 
          if($this->nationalId($studentId)){
            //get the nationalId of the student
            $nationalId = $this->nationalId($studentId);
                      
            if($this->changePassword($studentId, $nationalId)){
              //set the login status to 1
              $this->changeLogInStatus($studentId);
            }else{
              exit("change-password func failed");  
            }
          
          }else{
            exit("nationalld func failed");
          }
          
        }
      }
      
      
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
    
    public function changePassword($studentId, $nationalId){
      return $this->setPassword($studentId, $nationalId);
    }
    
    public function changeLogInStatus($studentId){
      return $this->setLogInStatus($studentId);
    }
  }