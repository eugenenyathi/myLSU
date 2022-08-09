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
    
    public function seqDriver(){
      define("levels", [1.2, 2.1, 2.2, 4.1, 4.2]);
      define("facultyCodes", ["AgriSciences", "Engineering", "Humanities"]);
      
      $matchingStudentIds = [];
      
      foreach(levels as $key => $level){
        // $matchingStudentIds = $this->getLevelStudents($level, facultyCodes[$key]);
        foreach(facultyCodes as $facultyCode){
           $matchingStudentIds = $this->getLevelStudents($level, $facultyCode, $this->sex);
           $this->randomize($matchingStudentIds);
        }
      }      
      
    }
    
    public function randomize($matchingStudentIds){

      // $students = $this->studentIds($this->sex);
      
      /*
        Loop through and for each student get all 
        students that match the faculty & part
      */    
      $matchingStudentIds = [];
      $selectedMates = [];
      
      foreach($students as $student){
        //this is the student that will make the request
        $studentId = $student->studentId;
        
        //check if the current student has made a room request.
        if($this->freeMate($studentId) === false){
          //these are the students that fit the criteria of the current student
          $matchingStudentIds = $this->matchingStudents($studentId);
          $selectedMates = $this->selectMates($matchingStudentIds);
          
          /*
           =>Now insert these roommates into the database
           1. Insert into the requestRoom table
           2. Insert into the preferred roommates table
           3. Insert responses[confirmStatus] in the preferred roommates table
           3. Insert into the requestsMaleHostel table
           
           */
           
           //Step 1:
           $this->bookRequest($studentId);
           //Step 2:
           $this->bookRoomMates($studentId, $selectedMates);
           //Step 3:
           $this->bookResponses($selectedMates);
           //Step 4:
           $bookRequestsIds = $selectedMates;
           $bookRequestsIds[] = $studentId;
           $this->bookRequests($bookRequestsIds); 
           
           //update matchingStudentIds   
          //$matchingStudentIds = $this->shiftStudents($matchingStudentIds, $selectedMates);      
        }
        
        //$this->loopArr($this->randomizeModel->getPreferredRoomMates());
        // exit();
  
      }
      
      // $this->printArr($selectedMates);
    }
    
    //remove selected students from the array of matching students
    public function shiftStudents($matchingStudentIds, $selectedMates){
      $newMatchingStudentIds = [];
      
      foreach($matchingStudentIds as $student){
        $studentId = $student->studentId;
        if(in_array($studentId, $selectedMates) === false){
          $newMatchingStudentIds[] = $studentId;
        }
      }
      
      return $newMatchingStudentIds;
    }
    
    public function bookResponses($selectedMates){
      $this->randomizeResponses($selectedMates);
    }
    
    public function randomizeResponses($selectedMates){
      $responses = [ 0, 1, 2, 3 ];
      //will get a random number
      $random = $this->randomNumber($responses);
      //pick the number of students that will make a positive confirmation status
      $pickedResponse = $responses[$random];
      
      switch($pickedResponse){
        case 0:
          $this->setResponse($selectedMates, 0);
          break;
        case 1:
          $this->setResponse($selectedMates, 1);
          break;
        case 2:
          $this->setResponse($selectedMates, 2);
          break;
        case 3:
          $this->setResponse($selectedMates, 3);
          break;
        default:
          break;
      }
    }
    
    
    public function setResponse($selectedMates, $pickedResponse){
      $studentsThatConfirm = [];
      
      if($pickedResponse !== 0){
        for($i = 0; $i < $pickedResponse; $i++){
          $studentsThatConfirm[] = $selectedMates[$i];
        }
      }
      
      // $this->printArr($studentsThatConfirm);
      
      foreach($selectedMates as $studentId){
        if(in_array($studentId, $studentsThatConfirm)){
          // echo "1";
          $this->randomizeModel->registerResponses($studentId, 1);  
        }else{
          // echo "2";
          $this->randomizeModel->registerResponses($studentId, -1);  
        }
      }
      
    }
    
    public function bookRequests($students){
      foreach($students as $studentId){
        $this->randomizeModel->registerRequests($studentId);
      }
    }
    
    public function bookRoomMates($studentId, $selectedMates){
      foreach($selectedMates as $roomMateId){
        $this->randomizeModel->registerPreferredRoomMates($studentId, $roomMateId);
      }
    }
    
    public function bookRequest($studentId){
      return $this->randomizeModel->registerRequest($studentId);
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
            //eliminates posibility of duplicate student id's
            if(in_array($potentialMate->studentId, $potentialMates) === false){
              $potentialMates[] = $potentialMate->studentId;  
            }
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
    
    
    public function levelStudents($level, $facultyCode){
      return $this->getLevelStudents($level, $facultyCode, $this->sex);
    }
    
    public function studentIds($sex){
      return $this->getStudentIds($sex);
    }
    
    public function showTables(){
      $this->loopArr($this->randomizeModel->getRequestRoomTable());
      $this->loopArr($this->randomizeModel->getPreferredRoomMates());
      $this->loopArr($this->randomizeModel->getRequestsTable());
      
    }
    
    public function loopArr($arr){
      foreach($arr as $element){
          print_r($element);
      }
    }
    
    public function printArr($array){
        print_r($array);
        exit("5000");
    }
    
  }//endofclass