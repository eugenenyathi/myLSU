<?php 

  session_start();
  
  $loginStatus = $_SESSION['status'];
  
  exit("".$loginStatus);