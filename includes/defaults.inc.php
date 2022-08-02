<?php 

  $requestMethod = $_SERVER['REQUEST_METHOD'] ?? trim($_SERVER['REQUEST_METHOD']);
  $contentType =  $_SERVER['CONTENT_TYPE'] ?? trim($_SERVER['CONTENT_TYPE']);

  $content = trim(file_get_contents("php://input"));
  $user_data = json_decode($content, true);

  //link the universal-contr class file
  include_once '../universal/universal-contr.php';
  $universal = new UniversalContr(null);
  $universal->validateData($requestMethod, $contentType, $user_data);
  