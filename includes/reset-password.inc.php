<?php 

  //checking the data and all!
  include_once 'defaults.inc.php';
  
  $studentId = $user_data['studentId'];
  
  //link the reset-password-contr class file 
  include_once '../classes/controllers/reset-password-contr.php';
  
  $user = new ResetPasswordContr($studentId);
  
  $opr = $user_data['opr'];
  
  switch($opr){
    case 0:
      $nationalId = $user_data['nationalId'];
      $dob = $user_data['dob'];
      
      $user->sanitizeInputs($nationalId, $dob);
      $user->verifyIdentity();
      
      break;
    case 1:
      $newPassword = $user_data['newPassword'];
      $confirmNewPassword = $user_data['confirmNewPassword'];
      
      // $newPassword = '12345678';
      // $confirmNewPassword = '123456790';
      
      $user->sanitizePasswords($newPassword, $confirmNewPassword);
      $user->createNewPassword();
      
      break;
    default:
      exit("5001");
  }
  //$user->verifyDetails();
  