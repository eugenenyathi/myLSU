<?php 

  //auto class file
  include_once 'auto-contr.php';
  include_once 'auto-fm.php';
  include_once 'auto-mm.php';
  
  $studentId = 'L0098731R';
  
  //including the univ-controller class
  include '../universal/universal-contr.php';
  
  //instatiating the univ-contr class 
  $universal = new UniversalContr($studentId);
  $requestingStudentSex = $universal->getStudentGender();
   
  // regestering the request for student;
  switch ($requestingStudentSex) {
    case 'F':
      $user = new AutoContr(new AutoFM);
      break;

    case 'M':
        $user = new AutoContr(new AutoMM);
      break;

    default:
      exit("Failed to determine gender");
      break;
  }

  // $user->allocateDobs();
  // $user->resetLogInDetails($studentId);
  $user->deleteRequest($studentId);

  