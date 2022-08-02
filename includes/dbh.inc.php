<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  // $database = "lsuhostels";
  $database = "mylsu";

  $conn = mysqli_connect($servername, $username, $password, $database);

  if(!$conn){
    exit("10000");
  }
