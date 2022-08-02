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
        $this->level = levels[0];
        $this->requests();
      }
      
    }
    
    private function requests(){
      $this->requests_data = $this->allocateRoomModel->getRequests($this->level);
    
      if(count($this->requests_data) != 0){
        $this->processRequests();
        $this->auditRequests();
      }
      
      echo "Successfully allocated rooms";
      
    }
    
    public function refreshRequestsIndex(){
      $this->requests_data = $this->allocateRoomModel->getRequests($this->level);
    }
    
    private function processRequests(){
      foreach($this->requests_data as $student){
        /* Get the student id & check if the request has been processed. */
        $this->requestStudentId = $student->studentId;
        
        if($this->requestProcessMarker($this->requestStudentId) == 0){

          /*
            getting the room-mates with a positive confirmation status
            of the student who made the room-request
          */
          
          $this->roomMates = $this->studentRoomMates($this->requestStudentId);
          
          /*
            if everyone confirmed positively 
            -- StudentsPerRoom 4 : 3 people  confirmed  + you => 4
            -- StudentsPerRoom 3 : 2 people  confirmed + you  => 3
          */
          
          if($this->countPositiveStatus($this->requestStudentId) == $this->maxNoOfRoomMates){
            echo "1 <br/>";
            /* granting them a room! */
            $this->requestsStudents = [ $this->requestStudentId ];
            $this->grantRoom();
            
            /* Delete existing associations */
            $this->deleteAssoc([ $this->requestStudentId ]);
          }
          
          /*
            if the request is short of 1 positive confirmation
            -- StudentsPerRoom 4 : 2 people  confirmed  + you => 3 : 1 missing to make 4
            -- StudentsPerRoom 3 : 1 person confirmed + you  => 2: 1 missing to make 3
          */
          
          elseif($this->countPositiveStatus($this->requestStudentId) == $this->minConfirmStatus){
            echo "2 <br/>";
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
              /* Delete existing associations */
              $this->deleteAssoc([ $this->requestStudentId, $this->surrogateStudentId ]);
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
              
              /* Delete existing associations */
              $this->deleteAssoc([ $this->singleConfirmationStudentId ]);
            
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
              $this->singleStudentId = $this->studentRoomMate($this->setRequestStudentId);
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
          
        elseif($this->countPositiveStatus($this->requestStudentId) == 1){
          echo "3 <br/>";
          /* Look for another set with only 1 confirmation. */
          if( $this->setStatus($this->requestStudentId, $this->level)){
            $this->setRequestStudentId = $this->setStatus($this->requestStudentId, $this->level);
            /* Get the room-mate for this particular set */
            $this->setRequestRoomMates = $this->studentRoomMates($this->setRequestStudentId);
            /* Combine the single room-rates arrays to be one array */
            $this->roomMates = array_merge($this->roomMates, $this->setRequestRoomMates);
            /* Combine all those who made requests */
            $this->requestsStudents = [ $this->requestStudentId, $this->setRequestStudentId ];
          
            /*Now let's grant them a room*/
            $this->grantRoom();
          
            /* Delete existing associations */
            $this->deleteAssoc([ $this->requestStudentId, $this->setRequestStudentId ]);  
          }
        
        }
            
        /*
          if the request has zero-confirmations.
        */
        
        elseif($this->countPositiveStatus($this->requestStudentId) == 0){
            echo "4 <br/>";
        
            /* 1. Check for a set that has 2 confirmations .*/
            
            if($this->set(2)){
        
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
                    // $this->deleteAssoc($this->requestsStudents);
                    
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
    
    
    private function auditRequests(){
      $this->allRequests = $this->allocateRoomModel->getAllRequests($this->level);
      
      /*
        1. Check if the current student has been allocated a room.
        2. If not - allocate room 
      */
            
      foreach($this->allRequests as $student){        
        $requestStudentId = $student->studentId;
        
        if($this->auditRequestMarker($requestStudentId) == 0){
          if($this->confirmStudentRoomAllocation($requestStudentId) == false){
            /*Check if there is room that has students less than the required number */
            if($this->roomOccupants()){
              $roomNo = $this->roomOccupants();
              /* Add the student to the room */
              $this->addNewRoomOccupant($roomNo, $requestStudentId);
              /*Update room allocation status */
              $this->studentRoomAllocStatus($requestStudentId);
            }else{
              /* Get new room */
              $roomNo = $this->freeRoom();
              /* Add the student to the new room */
              $this->addNewRoomOccupant($roomNo, $requestStudentId);
              /* Update room availability */
              $this->updateRoomStatus();
              /*Update room allocation status */
              $this->studentRoomAllocStatus($requestStudentId);
            }
          }else{
            /*Update room allocation status */
            $this->studentRoomAllocStatus($requestStudentId);
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
    
    private function countPositiveStatus($studentId){
      return $this->allocateRoomModel->getCountPositiveStatus($studentId);
    }
    
    private function auditRequestMarker($studentId){
      return $this->allocateRoomModel->getAuditRequestMarker($studentId);
    }
    private function confirmStudentRoomAllocation($studentId){
      return $this->allocateRoomModel->getStudentRoomAllocStatus($studentId);
    }
    
    private function studentRoomAllocStatus($studentId){
      return $this->allocateRoomModel->setStudentRoomAllocStatus($studentId);
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
        $this->surrogateStudentId = $student->studentId;
        $returnValue = $this->allocateRoomModel->getNegativeStatus($this->surrogateStudentId);
        
        //if the current student has totally zero confirmation
        //3 / 2 zeros
        if($returnValue == $this->maxNoOfRoomMates){
          return $this->surrogateStudentId;
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
      $this->updateRoomStatus();
          
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
        
        if($setRequestStudentNo != $this->requestStudentId){
          if($this->countPositiveStatus($setRequestStudentNo) == $numberOfConfirmations){
            return $setRequestStudentNo;
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
  
  
    
  }//--end of class
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  