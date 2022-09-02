<?php 

  
  include '../classes/controllers/allocate-room-contr.php';
  include '../classes/models/allocate-room-models/allocate-rm-fm.php';
  include '../classes/models/allocate-room-models/allocate-rm-mm.php';

  
  //including the univ-controller class
  include '../universal/universal-contr.php';
  //instatiating the univ-contr class 
  $universal = new UniversalContr(null);
  $studentsPerRoom = $universal->studentsPerRoom();

  //instatiating the allocate-room-contr class 
  $serveRoom = new AllocateRoomContr($studentsPerRoom);

  $models = [ new AllocateRoomFM,  new AllocateRoomMM ];
  
  allocateRooms($serveRoom, $models);
  exit("allocate-rooms successful.");
  
  function allocateRooms($serveRoom, $models){
    foreach($models as $model){
      $serveRoom->setAllocateRoomModel($model);
      $serveRoom->roomAllocDriver();
    }
  }

  
  
  