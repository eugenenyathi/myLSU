<?php 

  /*
  
    1. Reset studentLogInDetails table 
    2. Reset studentLogInTimeStamps table
  
  */
  
  include_once '../controllers/reset-contr.php';
  
  $auto = new ResetContr();
  $auto->reset();
  $auto->showTables();
  exit("5000");