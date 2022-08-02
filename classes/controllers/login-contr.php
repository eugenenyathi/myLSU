<?php 

  include_once '../classes/models/login-model.php';
  
  class LogInContr extends LogInModel{
    private $studentId;
    private $studentPassword;
    private $studentPasswordType;
    private $studentDetails = [];
    private $currentTimeStamp;
    
    public function __construct($user_data){
      $this->studentId = $user_data['studentId'];
      $this->studentPassword = $user_data['password'];
    }
    
    public function verifyUser(){
      //check validity of student faculty
      if($this->studentFaculty() == -1){
        exit("100");
      }
      //check if the student faculty is allowed to make room requests
      if($this->facultyAccStatus() == 0 || $this->facultyAccStatus() == -1){
        exit("101");
      }
      //set password type 
      $this->setPasswordType();
      //fetch student data
      $this->studentDetails = $this->logInDetails($this->studentId);
            
      switch($this->studentPasswordType){
        case 'password':
          $this->verifyUsingPassword();
          break;
        case 'nationalId':
          $this->verifyUsingNationalId();
          break;
        default:
          exit();
      }
      
    }
    
    private function facultyAccStatus(){
      return $this->getFacultyAccStatus($this->studentId);
    }
    
    private function verifyUsingPassword(){
      
      $dehashed_password = password_verify($this->studentPassword, $this->studentDetails->password);
      
      if($this->studentId == $this->studentDetails->studentId 
      && $dehashed_password == true){
        //function to update the currentLoginTimeStamp
        $this->updateLoginTimeStamp();
        //creating a student id session
        session_start();
        $_SESSION['studentId'] = $this->studentDetails->studentId;
        //sending response to allow the user-to-login
        exit("5000");
      }else{
        //sending error-messages to the user
        if($this->studentId != $this->studentDetails->studentId){
          exit("3000");
        }else if($dehashed_password == false){
          exit("3002");
        }        
      }
      
    }
    
    private function verifyUsingNationalId(){
      
      if($this->studentId == $this->studentDetails->studentId 
      && $this->studentPassword == $this->studentDetails->nationalId){
        $this->updateLoginTimeStamp();
        session_start();
        $_SESSION['studentId'] = $this->studentDetails->studentId;
        exit("5000");
      }else{
        if($this->studentId != $this->studentDetails->studentId){
          exit("3000");
        }else if($this->studentPassword != $this->studentDetails->nationalId){
          exit("3001");
        }  
      }
      
    }
    
    private function updateLoginTimeStamp(){
      $data = $this->timeStampsInfo();
      $status = $data->status;
      $this->currentTimeStamp = $data->currentTimeStamp;
      
      if($status == 1){
        $this->updatePreviousTimeStamp();
        $this->updateCurrentTimeStamp();
      }
      elseif($status == 0){
        $this->updateCurrentTimeStamp();
      }
      
    }
    
    private function updateCurrentTimeStamp(){
      return $this->setCurrentTimeStamp($this->studentId);
    }
    
    private function updatePreviousTimeStamp(){
      return $this->setPreviousTimeStamp($this->studentId, $this->currentTimeStamp);
    }
    
    private function timeStampsInfo(){
      return $this->getTimeStampsInfo($this->studentId);
    }
    
    private function setPasswordType(){
      if($this->logInStatus() == 0){
        $this->studentPasswordType = "nationalId";
      }elseif($this->logInStatus() == 1){
        $this->studentPasswordType = "password";
      }else{
        exit("5001 - setPasswordType");
      }
    }
    
    private function logInStatus(){
      return $this->getlogInStatus($this->studentId);
    }
    
    private function logInDetails(){
      return $this->getlogInDetails($this->studentId);
    }
    
    private function studentFaculty(){
      return $this->getStudentFaculty($this->studentId);
    }
    
    public function checkInput(){
      if($this->emptyInput()){
        if(empty($this->studentId)){
          exit("800");
        }
        elseif(empty($this->studentPassword)){
          exit("802");
        }
      }
      elseif($this->invalidLength()){
        if(strlen($this->studentId) != 9){
          exit("990");
        }
        elseif(strlen($this->studentPassword) < 8){
          exit("992");
        }
      }
      elseif($this->invalidStudentId()){
        exit("2000");
      }
      
    }
    
    private function emptyInput(){
      if(empty($this->studentId) || empty($this->studentPassword)){
        return true;
      }
      
      return false;
    }
    
    private function invalidLength(){
      if(strlen($this->studentId) != 9 || strlen($this->studentPassword) < 8){
        return true;
      }
      
      return false;
    }
    
    private function invalidStudentId(){
      if(preg_match("/^L0\d{6}[A-Z]$/", $this->studentId) == false){
        return true;
      }
      
      return false;
    }
    
    
  }//end of class