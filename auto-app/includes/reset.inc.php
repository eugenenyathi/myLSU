<?php 

  /*
  
    1. Reset studentLogInDetails table 
    2. Reset studentLogInTimeStamps table
  
  */
  
  include_once '../controllers/reset-contr.php';
  include_once '../models/reset-models/reset-fm.php';
  include_once '../models/reset-models/reset-mm.php';

  executionSeq();
  
  
  function executionSeq(){
    $gender = ['M'];
    
    foreach($gender as $singleSex){
      switch($singleSex){
        case 'M':
          $auto = new ResetContr(new ResetMM);
          $auto->reset();
          // $auto->showTables();
          break;
        case 'F':
          $auto = new ResetContr(new ResetFM);
          $auto->reset();
          // $auto->showTables();
          break;
        default:
          exit("Gender-selection error");
      }
    }
    
  }
  
  exit("Reset - successful.");