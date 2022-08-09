<?php 

  include_once '../models/set-roommates-model.php';

  class setRoommatesContr extends setRoommatesModel{
    private $studentIds = [];
    private $sex;
    // private $studentNationalId;
    
    public function __construct($sex){
      $this->sex = $sex;
    }
    
    public function setUpLogin(){
      $studentIds = $this->studentIds($this->sex);
      
      /*
        1. Check the logIn-status 
        1.1. If LogIn-status is not 1 change password 
        2. Convert the nationalId id to be the custom password 
        3. Update the Login-status
      */

      foreach($studentIds as $student){
        $studentId = $student->studentId;
        
        //Step 1 & 1.1:
        if($this->loginStatus($studentId) !== 1){
          //Step 2:
          //get the nationalId of the student
          $nationalId = $this->nationalId($studentId); 
          //hash the nationalId 
          $hashed_password = password_hash($nationalId, PASSWORD_DEFAULT);
          //finally change the password
          $this->changePassword($studentId, $hashed_password);
          
          //Step 3:
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