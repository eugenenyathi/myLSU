<?php 

  $requestMethod = $_SERVER['REQUEST_METHOD'] ?? trim($_SERVER['REQUEST_METHOD']);
  $contentType = $_SERVER['CONTENT_TYPE'] ?? trim($_SERVER['CONTENT_TYPE']);
  
  $content = trim(file_get_contents("php://input"));
  $user_data = json_decode($content, true);
  
  session_start();
  $studentId = $_SESSION['studentId'];
  
  //link the universal-contr class file
  include_once '../universal/universal-contr.php';
  $universal = new UniversalContr($studentId);
  $universal->validateData($requestMethod, $contentType, $user_data);
  $studentSex = $universal->getStudentGender();
  
  $nationalId = $user_data['nationalId'];
  $newPassword = $user_data['newPassword'];
  $confirmNewPassword = $user_data['confirmNewPassword'];
  
  // $nationalId = '08-130567E82';
  // $newPassword = '12345678';
  // $confirmNewPassword = '12345678';
  
  //link the user-input-contr class file
  include_once '../classes/controllers/user-input-contr.php';
  $userInput = 
    new UserInputContr($nationalId, "nationalId", $newPassword, $confirmNewPassword);
  $userInput->sanitizeInputs();
  
    
  //link the change-password-contr class file
  include_once '../classes/controllers/change-password-contr.php';  
  $user = 
    new ChangePasswordContr($studentId, $nationalId, 1 , $confirmNewPassword);
    
  $user->changePassword();
  
  include '../classes/views/view-contr.php';
  include '../classes/views/view-fm.php';
  include '../classes/views/view-mm.php';
  
  //instatiating the view-contr class 
  $view = new ViewContr($studentId);
  
  // regestering the view for student;
  switch ($studentSex) {
    case 'F':
      $view->setViewModel(new ViewFM);
      break;
  
    case 'M':
      $view->setViewModel(new ViewMM);
      break;
  
    default:
      exit("Failed to determine gender");
      break;
  }
  
  //load the dom.
  $view->loadView();
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  