<?php 

  include_once '../classes/models/searchbar-model.php';
  
  class SearchBarContr extends SearchBarModel{
    private $studentId;
    private $searchId;
    private $takenStudents = [];
    private $freeStudents = [];
    private $searchResults = [];
    
    public function __construct($studentId, $searchId){
      $this->studentId = $studentId;
      $this->searchId = $searchId['studentId'];
    }
    
    public function search(){
      $studentIds = $this->querySearch();
      
      if($studentIds == false){
        exit("4000");
      }
      
      $this->catergoriseStudents($studentIds);
      // $this->searchResults = $this->studentDetails($this->freeStudents);
      // exit(json_encode($this->searchResults));
      
      $this->searchResults = [ $this->freeStudents, $this->takenStudents ];
      exit(json_encode($this->searchResults));
      
    }
    
    private function studentDetails($studentId){

      return 
        $this->getStudentDetails($studentId) ?? $this->getStudentDetails($studentId);
  
    }
    
    private function catergoriseStudents($studentIds){
      foreach($studentIds as $student){
        $studentId = $student->studentId;
        $studentSex = $this->studentGender($studentId);
        
        switch($studentSex){
          case 'F':
            //checks if the student being searched requested a room before 
            if($this->requestRoomStatus($studentId, "requestRoomFemaleHostel")){
              $this->takenStudents[] = $this->studentDetails($studentId);
            }
            //check if the student being searched has confirmation of 1 
            elseif($this->confirmationStatus($studentId, "preferredRoomMatesFemaleHostel")){
              $this->takenStudents[] = $this->studentDetails($studentId);
            }
            else{
              $this->freeStudents[] = $this->studentDetails($studentId);
            }
        
            break;
                        
        case 'M':
          //checks if the student being searched requested a room before 
          if($this->requestRoomStatus($studentId, "requestRoomMaleHostel")){
            $this->takenStudents[] = $this->studentDetails($studentId);
            // echo "1";
          }
          //check if the student being searched has confirmation of 1 
          elseif($this->confirmationStatus($studentId, "preferredRoomMatesMaleHostel")){
            $this->takenStudents[] = $this->studentDetails($studentId);
            // echo "2";
          }
          else{
            $this->freeStudents[] = $this->studentDetails($studentId);
            //echo "3";
          }
        
          break;
        
        default:
          exit();
        
        }//endofswitch
        
      }//endofloop

    }

    private function querySearch(){
      return $this->pullSearchDetails($this->studentId, $this->searchId);
    }
    
    private function studentGender($studentId){
      return $this->getStudentGender($this->studentId);
    }
    
    public function checkInput(){
      if($this->checkPartialRegex()){
        exit("3001");
      }
      elseif($this->checkLength()){
        exit("991");
      }
    }
    
    private function checkPartialRegex(){
      if(!preg_match("/^L0\d*/", $this->searchId)){
        return true;
      }
      
      return false;
    }
    
    private function checkLength(){
      if(strlen($this->searchId) > 9){
        return true;
      }
      
      return false;
    }
    
  }//endofclass