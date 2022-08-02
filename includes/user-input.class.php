<?php
class UserInput{

  public $nationalId;
  public $newPassword;
  public $confirmNewPassword;

  public $requestMethod;
  public $contentType;
  public $array;

  public function __construct($nationalId, $newPassword, $confirmNewPassword){
    $this->nationalId = $nationalId;
    $this->newPassword = $newPassword;
    $this->confirmNewPassword = $confirmNewPassword;
  }
  public function checkRequestMethod($requestMethod){
    $this->requestMethod = $requestMethod;

    if($this->requestMethod != 'POST'){
      exit("1000");
    }
  }

  public function checkContentType($contentType){
    $this->contentType = $contentType;

    if($this->contentType != 'application/json'){
      exit("1100");
    }
  }

  public function checkFormatting($array){
      $this->array = $array;
    if(!is_array($this->array)){
      exit("1110");
    }
  }

  public function checkEmptyThreeInputs(){
    if(empty($this->nationalId) || empty($this->newPassword) || empty($this->confirmNewPassword)){
       if(empty($this->nationalId)){
         exit("801");
       }else if( empty($this->newPassword) || empty($this->confirmNewPassword)){
         exit("802");
       }
    }
  }

  public function checkLengthThreeInputs(){
    if(strlen($this->nationalId) < 12 || strlen($this->newPassword) < 8 || strlen($this->confirmNewPassword) < 8){
       if(strlen($this->nationalId) < 12){
         exit("991");
       }else if(strlen($this->newPassword) < 8 || strlen($this->confirmNewPassword) < 8){
         exit("992");
       }
    }
  }

  public function Regex(){
    if(!preg_match("/\d{2}-\d{6}[A-Z]\d{2}/", $this->nationalId)){
      exit("2001");
    }
  }

  public function passwordsMatch(){
    if($this->newPassword != $this->confirmNewPassword){
      exit("3002");
    }
  }
}
