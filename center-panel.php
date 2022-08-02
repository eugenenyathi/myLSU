<section class="center-panel">
  
  <?php
  
    date_default_timezone_set('Africa/Harare');

    $studentId = $_SESSION['studentId'];
    
    include_once './universal/universal-contr.php';
    include_once './classes/controllers/ctr-panel-contr.php';
    include_once './classes/models/ctr-panel-models/ctr-panel-fm.php';
    include_once './classes/models/ctr-panel-models/ctr-panel-mm.php';

    
    $universal = new UniversalContr($studentId);
    $loginStatus = $universal->logInStatus();
    $universal->studentTuitionDetails();
    $studentSex = $universal->getStudentGender();
    
    $ctrPanel = new CtrPanelContr($studentId);
    
    switch ($studentSex) {
      case 'F':
        $ctrPanel->data(new CtrPanelFM);
        break;
        
      case 'M':
        $ctrPanel->data(new CtrPanelMM);
        break;
      
      default:
        exit("Failed to determine gender");
        break;
    }
    
    //checks if the current session student has been allocated a room.
    $roomAllocationStatus = $ctrPanel->roomAllocStatus();
    //checks if the current session student requested a room before 
    $requestStatus = $ctrPanel->requestRoomStatus();
    //checks if the current session student has been selected 
    //as one of the preferred room-mates
    $roomMateStatus = $ctrPanel->roomMateStatus();
      
    if($universal->studentTuitionOwing){
      echo '
        <div class="reminder-container">
          <div class="reminder">
            <p class="reminder-text">
              Hie
              <span class="student-name">'.$universal->studentFirstName.',</span>
              Thank you for paying $'.$universal->studentClearedTuition.'. We kindly
              remind you to clear the remainder of
              <span class="amount-owing">$'.$universal->studentTuitionOwing.'.</span>
            </p>
          </div>
        </div>
        ';
    }else{
      echo '
        <div class="reminder-container">
          <div class="reminder">
            <p class="reminder-text">
              <span class="student-name">'.$universal->studentFirstName.' ,</span>
              Thank you for fully paying your tuition.
            </p>
          </div>
        </div>
        ';
    }

  ?>


  <?php

    //if its your first time to log-in
    if($loginStatus == false){
      include_once './center-panel/ctr-change-password.php';
      echo '<script type="module" src="./js/ctr-panel.js" defer></script>';
    }
    
    //if you have been allocated a room 
    elseif($roomAllocationStatus == 1){
      include_once './center-panel/allocated-room.php';
    }
    //if it's not your first time to log-in and you have already requested a room
    else if($loginStatus && $requestStatus){
      include_once './center-panel/preferred-room-mates.php';
    }
    //if it's not your first time to log-in and you have been selected as a preferred room-mate
    else if($loginStatus && $roomMateStatus){
      //check confirmation confirmStatus
      $roomMateConfirmStatus = $ctrPanel->confirmationStatus();  
      
      //check if the current-student has already confirmed the selection
      if($roomMateConfirmStatus == 1){
        include_once './center-panel/confirmed-room-mate.php';
      }
      //check if the current-student has already declined the selection
      else if($roomMateConfirmStatus == -1){
          include_once './center-panel/ctr-request-room.php';
          echo '<script type="module" src="./js/searchbar.js" defer></script>';
      }
      //check if the current-student has not responded to the selection
      else if($roomMateConfirmStatus == 0){
        include_once './center-panel/selected-room-mate.php';
        echo '<script type="module" src="./js/room-mate-response.js" defer></script>';
      }

    }
    //if you haven't made any room-requests
    else{
      include_once './center-panel/ctr-request-room.php';
      echo '<script type="module" src="./js/searchbar.js" defer></script>';
    }

  ?>

</section>
