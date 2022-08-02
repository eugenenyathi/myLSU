<?php 

  class InputContr{
    
    private function invalidNationalId(){
      if(preg_match("/\d{2}-\d{6}[A-Z]\d{2}/", $this->unknown) == false){
        return true;
      }
      
      return false;
    }

    public function invalidStudentId(){
      if(preg_match("/^L0\d{6}[A-Z]$/", $this->studentId) == false){
        return true;
      }
      
      return false;
    }
  }