<section class="left-panel">
  <?php 
    
    $studentId = $_SESSION['studentId'];
    $studentData = [];
    
    //link the left-panel contr class file
    include_once './classes/controllers/left-panel-contr.php';
    
    $leftPanel = new LeftPanelContr($studentId);
    $studentData = $leftPanel->studentleftPanelDetails();
    
    /*
      this status variable helps us to inset last login datetime in
      the lastlogin section in the leftpanel.
    */
    
    $timeStampsData = $leftPanel->timeStampsInfo();
    
    $_SESSION['status'] = $timeStampsData->status;
    $loginStatus = $timeStampsData->status;
    $previousLoginTimeStamp = $timeStampsData->previousTimeStamp;
    
    /*
      this determines the text that will be displayed
      as last login time
    */
    
    if($loginStatus == 0){
      $loginTimeStampText = "First time login!";
    }
    elseif($loginStatus == 1){
      
      if(empty($previousLoginTimeStamp)){
        $loginTimeStampText = "First time login!";
      }else{
        //Set time zone
        date_default_timezone_set('Africa/Harare');
        $previousLoginTimeStamp = strtotime($previousLoginTimeStamp);

        $lastLoginDate = date('d-m-y', $previousLoginTimeStamp);
        $currentDate  = date('d-m-y');
        
        //display only the time when the user logged-in earlier in the day
        if($lastLoginDate == $currentDate){
          $loginTimeStampText = date('H:i:sA', $previousLoginTimeStamp);
        }else{
          $loginTimeStampText = date('l d M Y H:i:sA', $previousLoginTimeStamp);
        }
      }
      
    }
    
    //student details that will be plugged in the left-panel
    $profileLetter = substr($studentData->fullname, 0, 1);
    $studentName = $studentData->fullname;
    $program = $studentData->programmeName;
    $part = $studentData->part;
    
  ?>
  
  <?php
      echo '
      <div class="profile-container">
        <div class="profile-img-container">
          <span class="profile-letter">'.$profileLetter.'</span>
        </div>
        <p class="st-name">'.$studentName.'</p>
      </div>
      <div class="user-details">
        <ul class="usr-d-ul-container">
        <!--
          <li class="ls-item">
            <button class="st-user-icon usr-d-icons">
              <i class="fas fa-user"></i>
            </button>
             <p class="st-name">'.$studentName.'</p>
          </li>
          -->
          <li class="ls-item">
            <button class="st-number-icon usr-d-icons">
              <i class="fas fa-hashtag"></i>
            </button>
            <p class="st-number">'.$studentId.'</p>
          </li>
          <li class="ls-item">
            <button class="st-progam-icon usr-d-icons">
              <i class="fas fa-graduation-cap"></i>
            </button>
            <p class="st-program">'.$program.'</p>
          </li>
          <li class="ls-item">
            <button class="st-level-icon usr-d-icons">
              <i class="fas fa-book-reader"></i>
            </button>
            <p class="st-level">Part <span class="st-level">'.$part.'</span></p>
          </li>
          <li class="ls-item open-st-settings">
            <button class="open-st-settings-icon usr-d-icons">
              <i class="fas fa-cogs"></i>
            </button>
            <p class="st-settings">Settings</p>
          </li>
          <li class="ls-item">
              <button class="st-logout-time-icon usr-d-icons">
                <i class="fas fa-clock"></i>
              </button>
            <p class="st-logout">Last login @'.$loginTimeStampText.'</p>
          </li>
          <li class="ls-item st-logout-icon">
            <form action="./includes/logout.inc.php" method="post">
              <button class="st-logout-icon usr-d-icons">
                <i class="fas fa-sign-out-alt"></i>
                <p class="st-logout-text">Logout</p>
              </button>
            </form>
          </li>
        </ul>
        <button class="comment-btn">post</button>
      </div>
      ';
  ?>
</section>





















































































































































































































































































