<?php 

  include_once '../classes/interfaces/allocate-room-interface.php';
  
  class AllocateRoomContr{
    
    private $allocateRoomModel;
    private $level;
    public $requests_data = [];
    private $allRequests = [];
    private $requestStudentId;
    
    private $surrogateStudentId;
    private $surrogateStudentRoomMate;
    private $surrogateRoomMates = [];
    
    private $setRequestStudentId;
    private $setRequestRoomMates;
    
    private $singleStudentId;
    private $singleConfirmationStudentId;
    
    private $roomMates;
    private $otherMates;
    private $roomMateId;
    private $roomMatesNo;
    
    private $requestsStudents = [];
    private $studentsPerRoom;
    private $maxNoOfRoomMates;
    private $minConfirmStatus;
    
    
    public function __construct($studentsPerRoom){
      $this->studentsPerRoom = $studentsPerRoom;
      $this->maxNoOfRoomMates = $studentsPerRoom - 1;
      $this->minConfirmStatus = $studentsPerRoom - 2;
    }
    
    public function setAllocateRoomModel(AllocateRoomInterface $allocateRoomModel){
      $this->allocateRoomModel = $allocateRoomModel;
    }
    
    public function roomAllocDriver(){
      define("levels", [ 1.2 , 2.1 , 2.2 , 4.1 , 4.2 ]);
      
      for($i = 0; $i < count(levels); $i++){
        $this->level = levels[$i];
        $this->requests();
      }
      
    }
    
    private function requests(){
      $this->requests_data = $this->allocateRoomModel->getRequests($this->level);
      
      $this->auditRequests();
    
      /*
      if(count($this->requests_data) !== 0){
        // $this->processRequests();
        // $this->auditRequests();
      }*/
      
      // echo "Successfully allocated rooms";
      
    }
    
    public function refreshRequestsIndex(){
      $this->requests_data = $this->allocateRoomModel->getRequests($this->level);
    }
    
    private function processRequests(){
      foreach($this->requests_data as $student){
        /* 
          Get the student id 
          -- check if the request has been processed. 
          -- check if the student has not been allocated a room in 
          * This double lock is too ensure no single individual gets 
          allocated more than one.
        */
        
        $this->requestStudentId = $student->studentId;
        $requestStatus = $this->requestProcessMarker($this->requestStudentId);
        $isFreeMate = $this->freeMate($this->requestStudentId);
        
        if($requestStatus === 0 && $isFreeMate){

          /*
            1. Get students with a positive comfirm status 
            2. Check if those students haven't be allocated a room.
          */
          
          //Step 1:
          $this->roomMates = $this->studentRoomMates($this->requestStudentId);
          //Step 2:
          $this->roomMates = $this->freeMates($this->roomMates);
          
          /*
            if everyone confirmed positively 
            -- StudentsPerRoom 4 : 3 people  confirmed  + you => 4
            -- StudentsPerRoom 3 : 2 people  confirmed + you  => 3
          */
          
          if(count($this->roomMates) === $this->maxNoOfRoomMates){
            // echo "1 <br/>";
            /* granting them a room! */
            $this->requestsStudents = [ $this->requestStudentId ];
            $this->grantRoom();

          }
          
          /*
            if the request is short of 1 positive confirmation
            -- StudentsPerRoom 4 : 2 people  confirmed  + you => 3 : 1 missing to make 4
            -- StudentsPerRoom 3 : 1 person confirmed + you  => 2: 1 missing to make 3
          */
          
          elseif(count($this->roomMates) === $this->minConfirmStatus){
            // echo "2 <br/>";
            /*
              check if there are any requests with zero-confirmation
              If we found such a person, take that person add 
              them to those that are 3 to make 4, or 2 to make 3.
            */
            if($this->negativeStatus()){
              $this->surrogateStudentId = $this->negativeStatus();
              /* Combine all those who made requests */
              $this->requestsStudents = [ $this->requestStudentId, $this->surrogateStudentId ];
              /*Let's grant them a room*/
              $this->grantRoom();
            } 
            
            /*
              if we couldn't find anyone 
              -- find those with one confirmation 
              -- and take the individual who confirmed.
            */
            
            elseif($this->set(1)){
              /* 
                Get the room-mate for the request with one confirmation
                -- add the room-mate to the existing room-mates 
              */  
              $this->setRequestStudentId = $this->set(1);
              /* student id for the only room mate who confirmed*/
              $this->singleConfirmationStudentId = $this->studentRoomMateId($this->setRequestStudentId);
              /* Get the room-mate -- this returns an array with a the student id */
              $this->setRequestRoomMates = $this->studentRoomMates($this->setRequestStudentId);
              /* add this student to the student's room-mate who is short of one confirmation */
              $this->roomMates = array_merge($this->roomMates, $this->setRequestRoomMates);
              
              $this->requestsStudents = [ $this->requestStudentId ];
              
              /* let's give them a room. */
              $this->grantRoom();
              
              /*
                Give the surrogateStudentId student a marker of -1 to reflect availability 
                to be randomly assigned to other places.
              */
              
              $this->requestProcessed($this->setRequestStudentId, -1);
              
            }
            
            /*
              if we couldn't find anyone 
              -- break-up those 1 short and add to another to make 4/3.
            */
            
            elseif($this->set(2)){
              /* 
                -- Get the room-mate for the request with two confirmations
                -- take one room-mate and add the room-mate to the existing room-mates 
              */
              $this->surrogateStudentId = $this->set(2);
              /* surrogate student room-mate id */
              $this->singleStudentId = $this->studentRoomMates($this->setRequestStudentId);
              /* Get one room-mate of the surrogate student -- this returns an array with a the student id */
              $this->surrogateStudentRoomMate = $this->studentRoomMates($this->surrogateStudentId, 1);
              /* add this student to the student's room-mate who is short of one confirmation */
              $this->roomMates = array_merge($this->roomMates, $this->surrogateStudentRoomMate);
              /* Combine all those who made requests */
              $this->requestsStudents = [ $this->requestStudentId ];
              
              $this->grantRoom();
              /* Delete existing association(s) */            
              $this->deleteAssoc([ $this->requestStudentId, $this->singleStudentId]);
              
              
            }
            
                   
          }
          
          
          /*
            if the request is short of 2 positive confirmations
            -- StudentsPerRoom 4 : 1 person  confirmed  + you => 2 : 2 missing to make 4
            -- StudentsPerRoom 3 : not available in this instance
          */
          
        elseif($this->countPositiveStatus($this->requestStudentId) === 1){
          // echo "3 <br/>";
          /* Look for another set with only 1 confirmation. */
          if($this->setStatus($this->requestStudentId, $this->level)){
            /*Extract the requesting student on the set that has one conifirmation*/
            $sets = $this->setStatus($this->requestStudentId, $this->level);      
            $this->setRequestStudentId = $this->getSetRequestStudentId($sets);
            /* Get the room-mate for this particular set */
            $this->setRequestRoomMates = $this->studentRoomMates($this->setRequestStudentId);
            /* Combine the single room-rates arrays to be one array */
            $this->roomMates = array_merge($this->roomMates, $this->setRequestRoomMates);
            /* Combine all those who made requests */
            $this->requestsStudents = [ $this->requestStudentId, $this->setRequestStudentId ];
            // $this->printArr($this->requestsStudents);
            /*Now let's grant them a room*/
            $this->grantRoom();
          
            /* Delete existing associations */
            $this->deleteAssoc([ $this->requestStudentId, $this->setRequestStudentId ]);  
          }
        
        }
            
        /*
          if the request has zero-confirmations.
        */
        
        elseif($this->countPositiveStatus($this->requestStudentId) === 0){
            // echo "4 <br/>";
        
            /* 1. Check for a set that has 2 confirmations .*/
            
            if($this->set(2)){
              // echo "==== 4.1 ====";
        
              $this->setRequestStudentId = $this->set(2);
              /* Get the room-mates of this set */
              $this->roomMates = $this->studentRoomMates($this->setRequestStudentId);
              /* Combine all those who made requests */
              $this->requestsStudents = [ $this->requestStudentId, $this->setRequestStudentId ];
        
              /*Now let's grant them a room*/
              $this->grantRoom();
        
              /* Delete existing associations */
              $this->deleteAssoc([ $this->requestStudentId, $this->setRequestStudentId ]);
        
            }
        
            /* 2. Check for request that only has 1 confirmation */
            
            elseif($this->set(1)){
              // echo "==== 4.2 ====";
              
              $this->setRequestStudentId = $this->set(1);
              $this->roomMates = $this->studentRoomMates($this->setRequestStudentId);
        
              /* 2.1 get student with a -1 request marker */    
              if($this->negativeProcessMarker($this->level)){
                $this->surrogateStudentId = $this->negativeProcessMarker($this->level);
        
                /* Combine all those who made requests */
                $this->requestsStudents 
                = [ $this->requestStudentId, $this->setRequestStudentId, $this->surrogateStudentId ];
        
                /*Now let's grant them a room*/
                $this->grantRoom();
        
                /* Delete existing associations */
                $this->deleteAssoc(
                [ $this->requestStudentId, $this->setRequestStudentId, $this->surrogateStudentId ]
                );
        
              }
        
              /* 2.2 get the student with zero confirmation */
              elseif($this->set(0)){
                $this->surrogateStudentId = $this->set(0);
        
                /* Combine all those who made requests */
                $this->requestsStudents 
                = [ $this->requestStudentId, $this->setRequestStudentId, $this->surrogateStudentId ];
        
                /*Now let's grant them a room*/
                $this->grantRoom();
        
                /* Delete existing associations */
                $this->deleteAssoc(
                [ $this->requestStudentId, $this->setRequestStudentId, $this->surrogateStudentId ]
                );
        
              }
        
            }
            
            /* 3. Else look for 2|3 students with zero confirmations  */
            
            else{
              // echo "==== 4.3 ====";
              /* First check for students with a -1 request marker */            
              while(true){

                if(count($this->roomMates) != $this->maxNoOfRoomMates){
                    $this->surrogateStudentId = $this->negativeProcessMarker($this->level);
                
                    if($this->surrogateStudentId == false){
                      break;
                    } 
                
                    /* if the id returned does not already exist add to the roomMates id */
                    if(in_array($this->surrogateStudentId, $this->roomMates) == false){
                        $this->surrogateRoomMates[] = $this->surrogateStudentId;
                        /* Update the database*/
                        $this->crowdRequestProcessing($this->surrogateRoomMates, 1);
                    }
                    
                  }
              
              }
              
              /* check for the number of room mates in the array */
              $this->roomMatesNo = $this->maxNoOfRoomMates - count($this->surrogateRoomMates);
              
              if($this->roomMatesNo == 0){
                /* Grant them a room */
                $this->grantRoom();
                $this->deleteAssoc($this->surrogateRoomMates);
                
              }else{
                // echo 'Do we all get here!';
                
                /* Get the remaining numbers of students with zero confirmations needed */
                if($this->zeroConfirmation($this->roomMatesNo)){
                  $this->otherMates = $this->zeroConfirmation($this->roomMatesNo);
                  /* Add the current request student id */
                  $this->requestsStudents = [ $this->requestStudentId ];
                  $this->requestsStudents = array_merge($this->requestsStudents, $this->surrogateRoomMates, $this->otherMates);

                  /*  check the number of roommates in the requestsStudents in the array */
                  if(count($this->requestsStudents) == ($this->maxNoOfRoomMates + 1) ){
                    /* grant them a room */
                    $this->grantRoom();
                    $this->deleteAssoc($this->requestsStudents);
                    
                  }else{
                    /* Update the database*/
                    $this->crowdRequestProcessing($this->surrogateRoomMates, -1);
                  }
                  
                }else{
                  /* Update the database*/
                  $this->crowdRequestProcessing($this->surrogateRoomMates, -1);
                }
                        
              }//end of else
                
            }//end of the whole else block
        
        }//end of condition
        
        $this->reset();
        
        
        }

      } //--end of loop
      
      // echo("Successfully allocated Rooms");
      
    }//--end of function
    
    
    private function getSetRequestStudentId($sets){
    
      foreach ($sets as $set) {
        $studentId = $set->studentId;
        $confirmStatus = $set->confirmStatus;
                
        if($confirmStatus === "1"){
          return $studentId;
        }
      }
      
    }
    
    public function auditRequests(){
      $this->allRequests = $this->allocateRoomModel->getAllRequests($this->level);
      /*
        1. Check if the current student has been allocated a room.
        2. If not - allocate room 
      */
            
      foreach($this->allRequests as $student){
    
        $requestStudentId = $student->studentId;
        $what = $this->auditRequestMarker($requestStudentId);
        $confirm = $this->confirmStudentRoomAllocation($requestStudentId);
        
        if($this->auditRequestMarker($requestStudentId)){
          if($this->confirmStudentRoomAllocation($requestStudentId) === false){
            // echo "1 -audit";
            /*Check if there is room that has students less than the required number */
            if($this->roomOccupants()){
              // echo "audit - 1.1";
              $roomNo = $this->roomOccupants();
              /* Add the student to the room */
              $this->addNewRoomOccupant($roomNo, $requestStudentId);
              /*Update room allocation status */
              $this->studentRoomAllocStatus($requestStudentId, 1);
            }else{
              // echo "audit - 1.2";
              /* Get new room */
              $roomNo = $this->freeRoom();
              /* Add the student to the new room */
              $this->addNewRoomOccupant($roomNo, $requestStudentId);
              /* Update room availability */
              $this->updateRoomStatus();
              /*Update room allocation status */
              $this->studentRoomAllocStatus($requestStudentId, 1);
            }
          }else if($this->confirmStudentRoomAllocation($requestStudentId)){
            /*Update room allocation status */
            $this->studentRoomAllocStatus($requestStudentId, 1);
          }
        
        }
      
      
      }
      // echo "Successfully allocated rooms -audit";
    }
    
    
    private function reset(){
      $this->requestsStudents = [];
      $this->surrogateStudentId = '';
      $this->surrogateRoomMates = [];
      $this->roomMates = [];
      $this->otherMates = [];
    }
    
    private function requestProcessMarker($studentId){
      return $this->allocateRoomModel->getRequestProcessMarker($studentId);
    }
          
    private function studentRoomMates($studentId, $limit = 4){
       return $this->allocateRoomModel->getRoomMates($studentId, $limit);
    }
    
    private function studentRoomMateId($studentId){
      return $this->allocateRoomModel->getRoomMate($studentId);
    }
    
    private function objectRoomMateId($studentId){
      return $this->allocateRoomModel->getObjectRoomMate($studentId);
    }
    
    private function countPositiveStatus($studentId){
      return $this->allocateRoomModel->getCountPositiveStatus($studentId);
    }
    
    private function auditRequestMarker($studentId){
      return $this->allocateRoomModel->getAuditRequestMarker($studentId);
    }
    private function confirmStudentRoomAllocation($studentId){
      return $this->allocateRoomModel->getStudentRoomAllocStatus($studentId);
    }
    
    private function freeMates($roomMates){
      $freeMates = [];
      
      foreach($roomMates as $roomMate){
        $roomMateId = $roomMate->roomMateId;
        
        if($this->freeMate($roomMateId)){
          $freeMates[] = $roomMate;
        }
      }
      
      return $freeMates;
    }
    
    private function freeMate($studentId){
      return $this->allocateRoomModel->isFreeMate($studentId);
    }
    
    private function studentRoomAllocStatus($studentId, $marker){
      return $this->allocateRoomModel->setStudentRoomAllocStatus($studentId, $marker);
    }
    private function addNewRoomOccupant($roomNo, $studentId){
      $this->allocateRoomModel->setNewRoomOccupant($roomNo, $studentId);
    }
    
    private function roomOccupants(){
      $rooms = $this->allocateRoomModel->getAuditRooms();
      
      foreach($rooms as $room){
        $roomNo = $room->roomNumber;
        
        if($this->countRoomOccupants($roomNo) < $this->studentsPerRoom){
          return $roomNo;
        }
      }
      
      return 0;
    }
    
    
    private function countRoomOccupants($roomNo){
      return $this->allocateRoomModel->getCountRoomOccupants($roomNo);
    }
    
    private function negativeStatus(){
      foreach($this->requests_data as $student){
        //getting the id of the student that made the initial room request
        $surrogateStudentId = $student->studentId;
        
        //check if the current student has not been already been given a room
        if($this->freeMate($surrogateStudentId)){
          $return = $this->allocateRoomModel->getNegativeStatus($surrogateStudentId);
          
          //if the current student has totally zero confirmation
          //3 / 2 zeros
          if($return === $this->maxNoOfRoomMates){
            return $surrogateStudentId;
          }  
        }
        
      }
      
      return false;
      
    }
    
    private function negativeProcessMarker($level){
      return $this->allocateRoomModel->getNegativeProcessMarker($level);
    }
    
    private function zeroConfirmation($number){
      $roomMates = [];
      
      foreach($this->requests_data as $student){
        $setRequestStudentNo = $student->studentId;
        
        if(count($roomMates) != $number){
          if($setRequestStudentNo != $this->requestStudentId){
            if($this->countPositiveStatus($setRequestStudentNo) == 0){
              $roomMates[] = $setRequestStudentNo;
            }
          }
        }

      }
      
      return $roomMates;
    }
    
    private function grantRoomRequest(){
      return $this->allocateRoomModel->setGrantRoomRequest($this->freeRoom(), $this->requestStudentId);
    }
    
    private function freeRoom(){
      return $this->allocateRoomModel->getFreeRoom();
    }
        
    private function grantRoom(){
      
      foreach($this->requestsStudents as $studentId){
        $this->allocateRoomModel->setGrantRoom($this->freeRoom(), $studentId);
        $this->requestProcessed($studentId, 1);
      }
      
      //granting the room-mates the room.
      foreach($this->roomMates as $student){
        $this->allocateRoomModel->setGrantRoom($this->freeRoom(), $student->roomMateId);      
      } 
      
      //update that the room is now occupied.
      if($this->updateRoomStatus() === false){
        exit("Error -updateRoomStatus");
      }
          
    }
    
    private function updateRoomStatus(){
      return $this->allocateRoomModel->setRoomAvaiStatus($this->freeRoom());
    }
    
  
    private function requestProcessed($studentId, $marker){
      return $this->allocateRoomModel->setRequestProcessed($studentId, $marker);
    }
    
    private function crowdRequestProcessing($array, $marker){
      foreach($array as $student){
        $this->allocateRoomModel->setRequestProcessed($student, $marker);
      }
    }
    
    private function set($numberOfConfirmations){
      foreach($this->requests_data as $student){
        $setRequestStudentNo = $student->studentId;
        
        if($setRequestStudentNo !== $this->requestStudentId && $this->freeMate($setRequestStudentNo)){
          if($this->countPositiveStatus($setRequestStudentNo) === $numberOfConfirmations){
            return $setRequestStudentNo;
            
            $singleConfirmationStudentId = $this->studentRoomMateId($this->setRequestStudentId);
            
            if($this->free($singleConfirmationStudentId)){
              //return the object-version of this studentId 
              return $this->objectRoomMateId(  $setRequestStudentNo);
            }
            
          }
        }

      }//--end of loop
    } //--end of of function

    private function setStatus($studentId, $level){
      return $this->allocateRoomModel->getSetStatus($studentId, $level);
    }
  
    private function deleteSingleAssoc($studentId){
      return $this->allocateRoomModel->deleteRoomMate($studentId);
    }
    
    private function deleteAssoc($array){
      foreach($array as $studentId){
        $this->allocateRoomModel->deleteRoomMates($studentId);
      }
    }
    
    private function printArr($array){
        print_r($array);
        exit("Exit -- Arr");
    }
  
    
  }//--end of class
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  