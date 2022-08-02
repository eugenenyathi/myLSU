<?php 

  $roomNo = $ctrPanel->allocatedRoomNo();
  $myRoomMates = $ctrPanel->roomAllocRoomMates();
  $currentSessionStudentName = $universal->studentFirstName;
  $roomMates = '';
  
  foreach($myRoomMates as $student){
      
    $profileLetter = substr($student->fullName, 0, 1);
    $roomMates .= 
      '
          <div class="preferred-rm-mt">
              <div class="preferred-rm-mt-profile">
                  <div class="preferred-letter-container">
                    <span class="preferred-letter">'.$profileLetter.'</span>
                  </div>
                  <div class="preferred-rm-mt-details">
                    <h4 class="preferred-rm-mt-name">'.$student->fullName.' </h4>
                        <p>@<span class="preferred-rm-mt-st-number">'.$student->studentId.'</span></p>
                    </div>
              </div>
            </div> 
      ';
    
  }
  
  echo '
    <div class="reminder-container">
      <div class="reminder">
        <p class="reminder-text">
          You have been allocated room number <b> '.$roomNo.'</b>.
        </p>
      </div>
    </div>
    ';
  
  echo '
    <section class="center-panel-main-content">
      <div class="preferred-rm-ms-container">
        <h2 class="preferred-rm-ms-heading">
          '.$currentSessionStudentName.', these are your room mates.
        </h2>
          <div class="preferred-rm-ms-content">
              '.$roomMates.'
          </div>
      </div>
    </section>
  ';
    
?>

  

  