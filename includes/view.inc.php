<?php 

  //including the univ-controller class
  include '../universal/universal-contr.php';

  $studentId = 'L0016954T';

  //instatiating the univ-contr class 
  $universal = new UniversalContr($studentId);

  include '../classes/views/view-contr.php';
  include '../classes/views/view-fm.php';
  include '../classes/views/view-mm.php';
  
  //instatiating the view-contr class 
  $view = new ViewContr($studentId);
  $requestingStudentSex = $universal->getStudentGender();
   
  // regestering the request for student;
  switch ($requestingStudentSex) {
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
  
  $view->loadView();
  