<?php 

  $requestRoomDate = $ctrPanel->setDate();
  $dateEnglish = strlen($requestRoomDate) > 10 ? "on" : "at";
    
  $preferredRoomMates = $ctrPanel->roomMates();
  $roomMates = '';

  
  echo '
    <div class="reminder-container">
      <div class="reminder">
        <p class="reminder-text">
          You have a pending room request you made '.$dateEnglish.' '.$requestRoomDate.'.
        </p>
      </div>
    </div>
  ';
    
    
  if(count($preferredRoomMates) == 1){
    echo '
      <div class="reminder-container">
        <div class="reminder">
          <p class="reminder-text">
            Please add 1 more room mate.
          </p>
        </div>
      </div>
      ';
  }

//displaying the data

  foreach($preferredRoomMates as $student){
        
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

  
  if(count($preferredRoomMates) == 1){
    echo '
      <div class="reminder" style="display:none">
        <p class="reminder-text" id="request-room-notif-text">
          Room Request successful.
        </p>
      </div>
    
      <section class="center-panel-main-content">
        <div class="search-rm-ms-container">
          <form action="" class="search-submit-container">
            <input
              type="text"
              class="search-rm-ms-input"
              placeholder="Search by student number"
              id="ctr-search-input"
            />
            <button class="ctr-search-icon">
              <i class="fas fa-search"></i>
            </button>
          </form>
          <div class="search-results-container">
            <ul class="search-results-ul-container">
                <!-- Javascript generated data -->
            </ul>
          </div>
        </div>
        <div class="selected-rm-ms-container">
          <h2 class="selected-rm-ms-heading">Selected most preferred room-mates</h2>
            <div class="selected-rm-ms-content">
              <!-- Javascript generated data -->
            </div>
        </div>
        <button class="request-room" id="add-rm-mt-btn">Add</button>
        <div class="preferred-rm-ms-container">
          <h2 class="preferred-rm-ms-heading">You selected the following as your preferred room mates.</h2>
            <div class="preferred-rm-ms-content">
                '.$roomMates.'
            </div>
        </div>
      </section>
    ';
  }else{
    echo '
      <section class="center-panel-main-content">
        <div class="preferred-rm-ms-container">
          <h2 class="preferred-rm-ms-heading">You selected the following as your preferred room mates.</h2>
            <div class="preferred-rm-ms-content">
                '.$roomMates.'
            </div>
        </div>
      </section>
    ';
  }


  