<?php 

  include_once '../models/reset-models/reset-model.php';
  include_once '../interfaces/reset-interface.php';
  
  class ResetContr extends ResetModel{
    private $resetModel;
    
    public function __construct(ResetInterface $resetModel){
      $this->resetModel = $resetModel;
    }
    
    public function reset($reqs){
      foreach ($reqs as $req) {
        switch($req){
          case 0:
            $this->studentLogInDetails();
            $this->studentLogInTimeStamps();
            $this->requestsTable();
            $this->requestRoomTable();
            $this->preferredRoomMates();
            $this->roomOccupiersTable();
            $this->roomAvailabityStatusTable();
            break;
          case 1:
            $this->studentLogInDetails();
            $this->studentLogInTimeStamps();
            break;
          case 2:
            $this->requestsTable();
            $this->requestRoomTable();
            $this->preferredRoomMates();
            break;
          case 3:
            $this->roomOccupiersTable();
            $this->roomAvailabityStatusTable();
          case 4:
            $this->requestsTableTwo();
            $this->requestRoomTableTwo();
        }// code...
      }      
    }
    
    public function showTables(){
      $this->loopArr($this->showLogInDetails());
      $this->loopArr($this->showLogInTimeStamps());
      
      $this->loopArr($this->showRequestsTable());
      $this->loopArr($this->showRequestRoomTable());
      $this->loopArr($this->showPreferredRoomMates());
    }
    
    
    public function showRequestsTable(){
      return $this->resetModel->getRequestsTable();
    }
    
    public function showRequestRoomTable(){
      return $this->resetModel->getRequestRoomTable();
    }
    
    public function showPreferredRoomMates(){
      return $this->resetModel->getPreferredRoomMates();
    }
    
    public function roomAvailabityStatusTable(){
      return $this->resetModel->resetRoomAvailabityStatus();
    }
    
    public function roomOccupiersTable(){
      return $this->resetModel->resetRoomOccupiersTable();
    }
    
    public function requestsTableTwo(){
      return $this->resetModel->resetRequestsTableTwo();
    }
    
    public function requestRoomTableTwo(){
      return $this->resetModel->resetRequestRoomTableTwo();
    }
    
    public function requestsTable(){
      return $this->resetModel->resetRequestsTable();
    }
    
    public function requestRoomTable(){
      return $this->resetModel->resetRequestRoomTable();
    }
    
    public function preferredRoomMates(){
      return $this->resetModel->resetPreferredRoomMates();
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
    
    public function loopArr($arr){
      foreach($arr as $element){
          print_r($element);
      }
    }
    
    
  }//endofclass