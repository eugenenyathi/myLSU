<?php 

  session_start();
  $requestingStudentId = $_SESSION['studentId'];
  
  include '../universal/universal-contr.php';

  //instatiating the univ-contr class 
  $universal = new UniversalContr($requestingStudentId);
  //getting the number of students per-room;
  $studentsPerRoom = $universal->studentsPerRoom();
  
  
  include '../classes/controllers/rr-contr.php';
  include '../classes/models/rr-female.php';
  include '../classes/models/rr-male.php';
  
  //instatiating the requestroom-contr class 
  $requestRoomUser = new RequestRoomContr($requestingStudentId, null);
  $requestingStudentSex = $universal->getStudentGender();
   
  // regestering the request for student;
  switch ($requestingStudentSex) {
    case 'F':
      $requestRoomUser->setRequestRoomModel(new RequestRoomFM);
      break;
  
    case 'M':
      $requestRoomUser->setRequestRoomModel(new RequestRoomMM);
      break;
  
    default:
      exit("Failed to determine gender");
      break;
  }
  
  //check the number of preferred room-mates 
  $preferredNumOfRoomMates = $requestRoomUser->preferredNumOfRoomMates();
  
  $res =  [ 
    "studentsPerRoom" => $studentsPerRoom,
    "preferredNumOfRoomMates" => $preferredNumOfRoomMates
  ];
  

  exit(json_encode($res));
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  