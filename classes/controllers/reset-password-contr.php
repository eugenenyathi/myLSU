<?php 

  include_once '../classes/models/reset-password-model.php';
  
  class ResetPasswordContr extends ResetPasswordModel{
    private $studentId;
    private $nationalId;
    private $dob;
    private $newPassword;
    private $confirmNewPassword;
    
    public function __construct($studentId){
      $this->studentId = $studentId;
    }
    
    public function createNewPassword(){
      $hashed_password = password_hash($this->confirmNewPassword, PASSWORD_DEFAULT);
      $returnValue = $this->setNewPassword($this->studentId, $hashed_password);
      
      $returnValue ? exit("5000") : exit("5001");
    }
    
    public function verifyIdentity(){
      
      $studentId = $this->getStudentId($this->studentId);
      $logInStatus = $this->getLogInStatus($this->studentId);
      
      if($studentId == false || $logInStatus == false){
        if($studentId == false){
            exit("3000");
        }
        else{
          exit("100");
        }
      
      }
      
      $data = $this->identityDetails();
      
      if($this->nationalId === $data->nationalId && $this->dob === $data->DOB){    
        exit("5000");
      }
      
      exit("3001");
    }
    
    private function identityDetails(){
      return $this->getIdentityDetails($this->studentId);
    }    
    
    public function sanitizeInputs($nationalId, $dob){
      $this->nationalId = $nationalId;
      $this->dob = $dob;
      
      if($this->emptyInput()){
        if(empty($this->studentId)){
          exit("800");
        }
        elseif(empty($this->nationalId)){
          exit("801");
        }
        elseif(empty($this->dob)){
          exit("803");
        }
      }
      
      elseif($this->invalidLength()){
        if(strlen($this->studentId)){
          exit("990");
        }
        elseif(strlen($this->nationalId)){
          exit("991");
        }
        elseif(strlen($this->dob)){
          exit("994");
        }
      }
      
      elseif($this->invalidStudentId()){
        exit("2000");
      }
      
      elseif($this->invalidNationalId()) {
        exit("2001");
      }
      
      // elseif($this->invalidDob()){
      //   exit("2002");
      // }
    }
    
    public function sanitizePasswords($newPassword, $confirmNewPassword){
      $this->newPassword = $newPassword;
      $this->confirmNewPassword = $confirmNewPassword;
      
      if($this->emptyPassword()){
        exit("802");
      }
      
      elseif($this->invalidPasswordLength()) {
        exit("992");
      }
      
      elseif($this->passwordMatch()){
        exit("3002");
      }
      
    }
    
    private function emptyPassword(){
      if(empty($this->newPassword) || empty($this->confirmNewPassword)){
        return true;
      }
      
      return false;
    }
    
    private function invalidPasswordLength(){
      if(strlen($this->newPassword) < 8 || strlen($this->confirmNewPassword) < 8 ){
        return true;
      }
      
      return false;
    }
    
    private function passwordMatch(){
      if($this->newPassword !== $this->confirmNewPassword){
        return true;
      }
      
      return false;
    }
    
    private function emptyInput(){
      if(empty($this->studentId) || empty($this->nationalid) || empty($this->dob)){
        return true;
      }
      
      return false;
    }
    
    private function invalidLength(){
      if(strlen($this->studentId) != 9 || strlen($this->nationalId) || strlen($this->dob)){
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
    
    private function invalidNationalId(){
      if(preg_match("/\d{2}-\d{6}[A-Z]\d{2}/", $this->unknown) == false){
        return true;
      }
      
      return false;
    }
    
    // private function invalidDob(){
    //   if(preg_match("/\d{2}/"))
    // }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  }//endofclass