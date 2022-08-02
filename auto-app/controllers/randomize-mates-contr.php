<?php 

  include_once '../models/randomize-models/randomize-mates-model.php';
  include_once '../interfaces/randomize-mates-interface.php';

  class RandomizeMatesContr extends RandomizeMatesModel{
    
    private $allowedRoomMates;
    private $randomizeModel;
    private $sex; //the gender which we will be working with
    
    public function __construct(RandomizeMatesInterface $randomizeModel, $sex){
      $this->allowedRoomMates = $this->getMaxNumOfMates() - 1;
      $this->randomizeModel = $randomizeModel;
      $this->sex = $sex;
    }
    
    public function randomize(){

      $students = $this->studentIds($this->sex);
      
      /*
        Loop through and for each student get all 
        students that match the faculty & part
      */
      
      $matchingStudentIds = [];
      $selectedMates = [];
      
      foreach($students as $student){
        $studentId = $student->studentId;
        //these are the students that fit the criteria of the current
        //student
        $matchingStudentIds = $this->matchingStudents($studentId);
        $selectedMates = $this->selectMates($matchingStudentIds);

      }
      
      $this->printArr($selectedMates);
    }
    
    public function selectMates($matchingStudentIds){
      /*
        => Get 3 potential students
        1. Randomize selection 
        2. Take note of the available number of matching students
        3. Check if selected potential student is not already selected
      */
      $potentialMates = [];
      
      while(true){
          //step 1.
          $potentialMate = $matchingStudentIds[$this->randomNumber($matchingStudentIds)];
          //step 3.
          if($this->freeMate($potentialMate->studentId) === false){
            $potentialMates[] = $potentialMate->studentId;
          }
          
          if(count($potentialMates) === $this->allowedRoomMates){
            break;
          } 
      }
      
      return $potentialMates;
    }
    
    public function freeMate($studentId){
      return $this->randomizeModel->isFreeMate($studentId);
    }
    
    public function randomNumber($array){
      $arr_length = count($array) - 1;
      return mt_rand(0, $arr_length);
    }
    
    public function matchingStudents($studentId){
      return $this->getMatchingStudents($studentId);
    }
    
    public function studentIds($sex){
      return $this->getStudentIds($sex);
    }
    
    public function printArr($array){
        print_r($array);
        exit("5000");
    }
    
  }//endofclass