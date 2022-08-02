<?php 

  /*
  
    1. Check the logIn-status 
    2. Change the password if necessary
    3. Randomize allocation if possible
    4. Randomize roommate response 
  
  */
  
  /*
  include_once '../controllers/set-roommates-contr.php';
  
  $auto = new setRoommatesContr();
  $auto->execute();
  $auto->showTables();
  
  */
  
  include_once '../controllers/randomize-mates-contr.php';
  include_once '../models/randomize-models/randomize-mates-fm.php';
  include_once '../models/randomize-models/randomize-mates-mm.php';
  
  executionSeq();
  
  
  function executionSeq(){
    $gender = [ 'M'];
    
    foreach($gender as $singleSex){
      switch($singleSex){
        case 'M':
          $user = new RandomizeMatesContr(new RandomizeMatesMM, 'M');
          $user->randomize();
        case 'F':
          $user = new RandomizeMatesContr(new RandomizeMatesFM, 'F');
          $user->randomize();
        default:
          exit("Gender-selection error");
      }
    }
    
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  