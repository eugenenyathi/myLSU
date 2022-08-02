<?php 

  /*
  
    1. Check the logIn-status 
    2. Change the password if necessary
    3. Randomize allocation if possible
    4. Randomize roommate response 
  
  */
  
  include_once '../controllers/set-roommates-contr.php';
  
  $auto = new setRoommatesContr();
  $auto->execute();
  $auto->showTables();
  
  exit("5000");