<?php 

  $ctrPanel->requestStudentId();
  $myRoomMates = $ctrPanel->myRoomMates();
  $requestRoomMateName = '';
  $roomMates = '';

  foreach($myRoomMates as $student){
    
    if($student->studentId == $ctrPanel->getRequestRoomMateId()){
      $requestRoomMateName = substr($student->fullName, 0 , strpos($student->fullName, " "));
    }
        
    $profileLetter = substr($student->fullName, 0, 1);
    $roomMates .= 
      '
          <div data-id='.$student->studentId.' class="confirm-rm-mt">
              <div class="confirm-rm-mt-profile">
                  <div class="confirm-letter-container">
                    <span class="confirm-letter">'.$profileLetter.'</span>
                  </div>
                  <div class="confirm-rm-mt-details">
                    <h4 class="confirm-rm-mt-name">'.$student->fullName.' </h4>
                        <p>@<span class="confirm-rm-mt-st-number">'.$student->studentId.'</span></p>
                    </div>
                  </div>
            </div> 
      ';
    
  }
    
  echo '
    <section class="center-panel-main-content">
      <div class="confirm-rm-ms-container">
        <h2 class="confirm-rm-ms-heading">Please confirm these room-mates selected by <b>'.$requestRoomMateName.'</b>.</h2>
        <div class="confirm-rm-ms-content">
            '.$roomMates.'
        </div>
        <div class="confirm-cancel-btn-container">
          <button class="confirm-room-mates">Confirm</button>
          <button class="cancel-room-mates">Cancel</button>
        </div>
      </div>
    </section>
  ';

?>

  