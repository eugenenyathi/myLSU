 <?php 

  $ctrPanel->requestStudentId();
  $requestRoomDate = $ctrPanel->setDate();
  $dateEnglish = strlen($requestRoomDate) > 10 ? "on" : "at";
  
  $myRoomMates = $ctrPanel->myRoomMates();
  $requestRoomMateName = $ctrPanel->requestRoomMateName();
  $requestRoomMateName = substr($requestRoomMateName, 0 , strpos($requestRoomMateName, " "));
  $roomMates = '';

  echo '
    <div class="reminder-container">
      <div class="reminder">
        <p class="reminder-text">
         You have a pending room request made by <b>'.$requestRoomMateName.'</b>
         '.$dateEnglish.' '.$requestRoomDate.'
        </p>
      </div>
    </div>
    ';


  foreach($myRoomMates as $student){
    
    // if($student->studentId == $ctrPanel->getRequestRoomMateId()){
    //   $requestRoomMateName = substr($student->fullName, 0 , strpos($student->fullName, " "));
    // }
    // 
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
        <h2 class="confirm-rm-ms-heading">The following are your preferred room mates</b>.</h2>
        <div class="confirm-rm-ms-content">
            '.$roomMates.'
        </div>
      </div>
    </section>
  ';

?>

  