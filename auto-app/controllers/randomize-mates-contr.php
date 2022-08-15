<?php 

  include_once '../models/randomize-models/randomize-mates-model.php';
  include_once '../interfaces/randomize-mates-interface.php';

  class RandomizeMatesContr extends RandomizeMatesModel{
    
    private $allowedRoomMates;
    private $randomizeModel;
    private $sex; //the gender which we will be working with
    private $levels = [1.2, 2.1, 2.2, 4.1, 4.2];
    private $facultyCodes = ["AgricSciences", "Engineering", "Humanities"];
    private $countIndex = 0;
    
    public function __construct(RandomizeMatesInterface $randomizeModel, $sex){
      $this->allowedRoomMates = $this->getMaxNumOfMates() - 1;
      $this->randomizeModel = $randomizeModel;
      $this->sex = $sex;
    }
    
    public function randomize(){
      /*
        1. Get all students that of the same level and same faculty.
        2. Get all students that are free agents.
        3. call the requests function.
      */

      $students = [];
      $count = 0;
      
      foreach($this->levels as $level){
        foreach($this->facultyCodes as $facultyCode){
          //step 1:
          $students = $this->getLevelStudents($level, $facultyCode, $this->sex);

          if(count($students) !== 0){
            //step 2: 
            $students = $this->freeMates($students);       
            //step 3:  
            $this->requests($students);            
          }

        }
      }      
    }
    
    public function requests($students){
              
      $selectedMates = [];
      
      foreach($students as $studentId){
        /*
          1. Check if the current student is a free agent.
          2. Select room mates for the current student in the loop 
          3. Check if the selected room mates meet the required number
      
        */            
          //Step 1:                                
           if($this->hasRequest($studentId) && $this->freeMate($studentId)){
             //Step 2:
             $selectedMates = $this->selectMates($students, $studentId);
             // Step 3:
             if(count($selectedMates) === $this->allowedRoomMates){
             
               /*
                =>Now insert these roommates into the database
                1. Insert into the requestRoom table
                2. Insert into the preferred roommates table
                3. Insert responses[confirmStatus] in the preferred roommates table
                4. Insert into the requestsMaleHostel table             
                */
             
               //Step 1:
               if($this->bookRequest($studentId) === false){
                 exit("bookRequest -Error");
               }
                //Step 2:
               if($this->bookRoomMates($studentId, $selectedMates) === false){
                 exit("bookRoomMates -Error");
               }
                //Step 3:
               $this->bookResponses($selectedMates);
               //Step 4:
               $setOfRoomMates = array_merge($selectedMates, [$studentId]);
               $this->bookRequests($setOfRoomMates); 

             } 
           }
      }
      
    }
    
    //remove selected students from the array of matching students
    public function shiftStudents($students, $selectedMates){
      $newStudents = [];
      
      foreach($students as $studentId){
        if(in_array($studentId, $selectedMates) === false){
          $newStudents[] = $studentId;
        }
      }
      
      return $newStudents;
    }
    
    public function bookResponses($selectedMates){
      $responses = [ 1, 2, 3 ];
      //pass the count index to make sure its not out of index.
      $this->countIndex = $this->boundIndex($this->countIndex, count($responses));
      //pick the number of students that will make a positive confirmation status
      $pickedResponse = $responses[$this->countIndex];
      $this->setResponse($selectedMates, $pickedResponse);
      
      $this->countIndex++;
    }
    
    public function boundIndex($countIndex, $arrLength){
      if($countIndex > $arrLength - 1){
        return 0;
      }
      if($countIndex < 0){
        return $arrLength - 1;
      }
      
      return $countIndex;
    }
    
    // public function bookResponses($selectedMates){
    //   $responses = [ 0, 1, 2, 3 ];
    //   //will get a random number
    //   $random = $this->randomNumber($responses);
    //   //pick the number of students that will make a positive confirmation status
    //   $pickedResponse = $responses[$random];
    //   $this->setResponse($selectedMates, $pickedResponse);
    // }
        
    public function setResponse($selectedMates, $pickedResponse){
      $studentsThatConfirm = [];
          
      if($pickedResponse !== 0){
        for($i = 0; $i < $pickedResponse; $i++){
          $studentsThatConfirm[] = $selectedMates[$i];
        }
      }
      
      // echo "pickedResponse => ${pickedResponse}";
      // $this->printArr($studentsThatConfirm);
      
      foreach($selectedMates as $studentId){
        
        if(count($studentsThatConfirm) !== 0){
          if(in_array($studentId, $studentsThatConfirm)){
            // echo "1";
            $this->randomizeModel->registerResponses($studentId, 1);  
          }else{
            // echo "2";
            $this->randomizeModel->registerResponses($studentId, -1);  
          }          
        }else{
          $this->randomizeModel->registerResponses($studentId, -1);  
        }

      }
      
    }
    
    public function bookRequests($setOfRoomMates){
      foreach($setOfRoomMates as $studentId){
        if($this->randomizeModel->registerRequests($studentId) === false){
          exit("bookRequests --Error! --${studentId} ");
        }
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
    
    public function selectMates($students, $requestStudentId){
      $potentialMates = [];
    
      foreach($students as $studentId){
          
        if(count($potentialMates) !== $this->allowedRoomMates){
          if($studentId !== $requestStudentId && $this->freeMate($studentId)){
              $potentialMates[] = $studentId;
          }    
        }else{
            break;
        }
        
      }
      
            
      return $potentialMates;
    }
    
    public function hasRequest($studentId){
      return $this->randomizeModel->hasRoomRequest($studentId);
    }  
    
    public function freeMates($students){
      $freeMates = [];
      
      foreach($students as $student){
        $studentId = $student->studentId;
        
        if($this->freeMate($studentId)){
          $freeMates[] = $studentId;
        }
      }
      
      return $freeMates;
    }
    
    public function freeMateTwo($studentId){
      return $this->randomizeModel->isFreeMateTwo($studentId);
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
        exit("Exit -- Arr");
    }
    
  }//endofclass