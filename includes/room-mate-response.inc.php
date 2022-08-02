<?php 

  $requestMethod = $_SERVER['REQUEST_METHOD'] ?? trim($_SERVER['REQUEST_METHOD']);
  $contentType = $_SERVER['CONTENT_TYPE'] ?? trim($_SERVER['CONTENT_TYPE']);
  
  $content = trim(file_get_contents("php://input"));
  $response_data = json_decode($content, true);
  
  //current session studentId 
  session_start();
  $studentId = $_SESSION['studentId'];
  
  //linking to the controller class
  include_once '../universal/universal-contr.php';
  include_once '../classes/controllers/rm-response-contr.php';
  
  $universal = new UniversalContr($studentId);
  $universal->validateData($requestMethod, $contentType, $response_data);
  $studentSex = $universal->getStudentGender();
  
  //link to the ctr interface models
  include_once '../classes/models/rm-response-models/rm-response-mm.php';
  include_once '../classes/models/rm-response-models/rm-response-fm.php';
  
  $roomMateResponse = new RMResponseContr($studentId, $response_data);
  
  include '../classes/views/view-contr.php';
  include '../classes/views/view-fm.php';
  include '../classes/views/view-mm.php';
  
  //instatiating the view-contr class 
  $view = new ViewContr($studentId);
  
  //regestering the response for student
  switch ($studentSex) {
    case 'F':
      $roomMateResponse->responseInterface(new RMResponseFM);
      $view->setViewModel(new ViewFM);
      break;
    case 'M':
      $roomMateResponse->responseInterface(new RMResponseMM);
      $view->setViewModel(new ViewMM);
      break;    
    default:
      break;
  }
  
  //record response
  $roomMateResponse->response();
  $studentResponse = $response_data['response'];
  
  switch($studentResponse){
    case 1:
      $view->confirmedMateView();
      break;
    case -1:
      $view->defaultView();
      break;
    default:
      exit("Invalid response");
  }

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  