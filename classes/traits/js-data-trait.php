<?php 

  trait JSDataTrait{
    
    public function validateData($requestMethod, $contentType, $data){
      $this->requestMethod($requestMethod);
      $this->contentType($contentType);
      $this->dataFormat($data);
    }
    
    private function requestMethod($requestMethod){
      if($requestMethod != "POST"){
        exit("1000");
      }
    }
    
    private function contentType($contentType){
      if($contentType != "application/json"){
        exit("1100");
      }
    }
    
    private function dataFormat($data){
      if(!is_array($data)){
        exit("1110");
      }
    }
    
  }