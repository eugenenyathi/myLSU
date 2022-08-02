<?php 

    include_once '../classes/models/change-password-model.php';
    
    class ChangePasswordContr extends ChangePasswordModel{
      
      private $studentId;
      private $unknown; //nationalId | current-password
      private $newPassword;
      private $opr;
      
      public function __construct($studentId, $unknown, $opr, $newPassword){
        $this->studentId = $studentId;
        $this->unknown = $unknown; 
        $this->opr = $opr;
        $this->newPassword = $newPassword;
        
      }
      
      public function changePassword(){
        switch($this->opr){
          case 1:
            $this->defaultPassword();
            break;
            
         case 2:
            $this->settingsPassword();
            break;
          default:
            exit();
        }
      }
      
      private function defaultPassword(){
        //check if the nationalId entered is correct
        if($this->nationalId() != $this->unknown){
        //  exit("3001-".$this->nationalId())."-".$this->unknown;
          $response = ["code" => "3001"];
          exit(json_encode($response));
        }
        
        $hashed_password = password_hash($this->newPassword, PASSWORD_DEFAULT);
        
        //change the password
        if($this->insertPassword($hashed_password) == false){
          $response = ["code" => "5001"];
          exit(json_encode($response));
        }
        //update the logInStatus 
        if($this->logInStatus() == false){
          $response = ["code" => "5001"];
          exit(json_encode($response));
        }
      
        // $response = ["code" => "5000"];
        // exit(json_encode($response));
      }
      
      private function settingsPassword(){
        //check if the current password matches with 
        //password in the db
        $dehashed_password = password_verify($this->unknown, $this->currentPassword());
        
        // exit($this->unknown . "---". $this->currentPassword());
        
        if($dehashed_password != 1){
          $response = ["code" => "3002"];
          exit(json_encode($response));
        }
        
        $hashed_password = password_hash($this->newPassword, PASSWORD_DEFAULT);
        
        if($this->updatePassword($hashed_password) == false){
          $response = ["code" => "5001"];
          exit(json_encode($response));
        }
        
        // $response = ["code" => "5000"];
        // exit(json_encode($response));
      }
      
      private function updatePassword($hashed_password){
        return $this->setNewPassword($this->studentId, $hashed_password);
      }
      
      private function insertPassword($hashed_password){
        return $this->setPassword($this->studentId, $hashed_password);
      }
      
      private function logInStatus(){
        return $this->updateLogInStatus($this->studentId);
      }
      
      private function currentPassword(){
        return $this->getCurrentPassword($this->studentId);
      }
      
      private function nationalId(){
          return $this->getNationalId($this->studentId);
      }
      
      
    }//endofclass