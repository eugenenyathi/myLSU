<?php 

  include_once '../models/reset-model.php';
  
  class ResetContr extends ResetModel{
    
    
    public function reset(){
      $this->studentLogInDetails();
      $this->studentLogInTimeStamps();
      
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
    
    public function studentLogInDetails(){
      return $this->resetLogInDetails();
    }
    
    public function studentLogInTimeStamps(){
      return $this->resetLogInTimeStamps();
    }
    
    
  }//endofclass