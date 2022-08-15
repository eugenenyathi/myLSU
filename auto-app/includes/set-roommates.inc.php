<?php 

  /*
  
    1. Check the logIn-status 
    2. Change the password if necessary
    3. Randomize allocation if possible
    4. Randomize roommate response 
  
  */
  
  include_once '../controllers/set-roommates-contr.php';
  include_once '../controllers/randomize-mates-contr.php';
  include_once '../models/randomize-models/randomize-mates-fm.php';
  include_once '../models/randomize-models/randomize-mates-mm.php';
  
  // $auto = new setRoommatesContr('M');
  // $auto->setUpLogin();
  
  // $user = new RandomizeMatesContr(new RandomizeMatesFM, 'F');
  // $user->randomize();
  
  executionSeq();
  exit("set-roommates successful.");
  
  
  function executionSeq(){
    $gender = [ 'M', 'F'];
    
    foreach($gender as $singleSex){
      switch($singleSex){
        case 'M':
          $auto = new setRoommatesContr('M');
          $auto->setUpLogin();
          // $auto->showTables();
          
          $user = new RandomizeMatesContr(new RandomizeMatesMM, 'M');
          $user->randomize();
          // $user->showTables();
          
          break;
       case 'F':
          $auto = new setRoommatesContr('F');
          $auto->setUpLogin();
          // $auto->showTables();
        
          $user = new RandomizeMatesContr(new RandomizeMatesFM, 'F');
          $user->randomize();
          // $user->showTables();
          
          break;
        default:
          exit("Gender-selection error");
      }
    }
    
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  