<?php 

 $requestMethod = $_SERVER['REQUEST_METHOD'] ?? trim($_SERVER['REQUEST_METHOD']);
 $contentType = $_SERVER['CONTENT_TYPE'] ?? trim($_SERVER['CONTENT_TYPE']);
 
 $content = trim(file_get_contents("php://input"));
 $selectedRoomMates = json_decode($content, true);
 
 session_start();
 $requestingStudentId = $_SESSION['studentId'];
 
 //including the univ-controller class
 include '../universal/universal-contr.php';

 //instatiating the univ-contr class 
 $universal = new UniversalContr($requestingStudentId);
 
 //validating and checking for potential errors in the data  
 $universal->validateData($requestMethod, $contentType, $selectedRoomMates);
 $universal->RequestRoomInput($selectedRoomMates);

 // exit("5000");

 include '../classes/controllers/rr-contr.php';
 include '../classes/models/rr-female.php';
 include '../classes/models/rr-male.php';
 
 //instatiating the requestroom-contr class 
 $roomRequestUser = new RequestRoomContr($requestingStudentId, $selectedRoomMates);
 $requestingStudentSex = $universal->getStudentGender();
 
 include '../classes/views/view-contr.php';
 include '../classes/views/view-fm.php';
 include '../classes/views/view-mm.php';
 
 //instatiating the view-contr class 
 $view = new ViewContr($requestingStudentId);

 // regestering the request for student;
 switch ($requestingStudentSex) {
   case 'F':
     $roomRequestUser->setRequestRoomModel(new RequestRoomFM);
     $view->setViewModel(new ViewFM);
     break;
 
   case 'M':
     $roomRequestUser->setRequestRoomModel(new RequestRoomMM);
     $view->setViewModel(new ViewMM);
     break;
 
   default:
     exit("Failed to determine gender");
     break;
 }
 
 //get if the current student already made a request
 $requestStatus = $roomRequestUser->requestRoomStatus();
 //request-room 
 $roomRequestUser->requestRoom($requestStatus);
 //when everything is ok then do this!
 $view->preferredMateView();
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 