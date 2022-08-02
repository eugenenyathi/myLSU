<?php 

  class UserInputContr{
    private $unknown;
    private $newPassword;
    private $confirmNewPassword;
    private $collective;
    
    public function __construct($unknown, $type, $newPassword, $confirmNewPassword){
      $this->unknown = $unknown;
      $this->type = $type;
      $this->newPassword = $newPassword;
      $this->confirmNewPassword = $confirmNewPassword;
      $this->collective = [ $unknown, $newPassword, $confirmNewPassword ];
      
    }
    
    public function sanitizeInputs(){
      switch($this->type){
        case 'nationalId':
          if($this->emptyNationalId()){
            $response = ["code" => "801"];
            exit(json_encode($response));
          }
          elseif($this->invalidNationalIdLength()){
            $response = ["code" => "991"];
            exit(json_encode($response));
          }
          
          elseif($this->invalidNationalId()){
            $response = ["code" => "2001"];
            exit(json_encode($response));
          }
          else{
            $this->defaults();
          }
          
          break;
          
        case 'password':
          if($this->emptyCurrentPassword()){
            $response = ["code" => "992"];
            exit(json_encode($response));
          }
          elseif($this->invalidCurrentPasswordLength()){
            $response = ["code" => "2001"];
            exit(json_encode($response));
          }
          else{
            $this->defaults();
          }
          
          break;
        default:
          exit();
      }  
      
    }//endofsanitizefunction
    
    private function defaults(){
      if($this->invalidPasswordsLength()){
        $response = ["code" => "993"];
        exit(json_encode($response));
      }
      
      elseif($this->passwordsMatch()){
        $response = ["code" => "3002"];
        exit(json_encode($response));
      }
    }
    
    private function emptyNationalId(){
      if(empty($this->unknown)){
        return true;
      }

      return false;      
    }
    
    private function emptyStudentId(){
      if(empty($this->unknown)){
        return true;
      }

      return false;      
    }
    
    private function emptyCurrentPassword(){
      if(empty($this->unknown)){
        return true;
      }

      return false;      
    }
    
    private function emptyPasswords(){
      if(empty($this->newPassword) || empty($this->confirmNewPassword)){
        return true;
      }
      
      return false;
    }
    
    private function invalidNationalIdLength(){
      if(strlen($this->unknown) != 12){
        return true;
      }
      
      return false;
    }
    
    private function invalidStudentIdLength(){
      if(strlen($this->unknown) != 9){
        return true;
      }
      
      return false;
    }
    
    private function invalidCurrentPasswordLength(){
      if(strlen($this->unknown) < 8){
        return true;
      }
      
      return false;
    }
    
    private function invalidPasswordsLength(){
      if(strlen($this->newPassword) < 8 || strlen($this->confirmNewPassword) < 8){
        return true;
      }
      
      return false;
    }
    
    private function invalidStudentId(){
      if(preg_match("/^L0\d{6}[A-Z]$/", $this->unknown) == false){
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
    
    private function passwordsMatch(){
      if($this->newPassword != $this->confirmNewPassword){
        return true;
      }
      
      return false;
    }
    
  }//end of class