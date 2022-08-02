<section class="right-panel-alt">
    
  <?php 
    
    $studentId = $_SESSION['studentId'];
        
    //link the right-panel contr class file
    include_once './classes/controllers/right-panel-contr.php';
    $rightPanel = new RightPanelContr($studentId);
    
    $accFee = $rightPanel->accommodationFees();
    $dates = $rightPanel->checkInOutDates();

    /*
      Only get these when the current session student 
      has been allocated a room
    */
    if($roomAllocationStatus == 1){
      $roomNo = $ctrPanel->allocatedRoomNo();
      $noOfRoomMates = $ctrPanel->countNumOfRoomMates() - 1;
    }

    $checkInDate = $rightPanel->formatDate($dates[0]->checkIn);
    $checkOutDate = $rightPanel->formatDate($dates[0]->checkOut);
  
  ?>
  
  <!-- ################## Main-right panel ################### -->
  <div class="main-right-panel-alt">
    <div class="acc-details">
      <ul class="acc-ul-container">
        <li class="ls-item">
          <button class="acc-room-number-icon acc-icons">
            <i class="fas fa-bed"></i>
          </button>
          <p> Accommodation fee 
            <?php
              echo '
                <span> 
                  <b>$'.$accFee.'</b>
                </span> 
              ';
            ?>
         </p>
        </li>
        
        <?php 
          
          if($ctrPanel->roomRequest() == 1){
            echo '
              <li class="ls-item">
                <button class="acc-room-number-icon acc-icons">
                  <i class="fas fa-bed"></i>
                </button>
                <p>
                  Room Granted
                  <button class="room-check acc-icons">
                    <i class="fas fa-check-circle"></i>
                  </button>
                </p>
              </li>
              
              <li class="ls-item">
                <button class="acc-room-number-icon acc-icons">
                  <i class="fas fa-bed"></i>
                </button>
                <p> 
                  Room mates
                    <span> 
                      - <b>'.$noOfRoomMates.'</b>
                    </span>
                </p>
              </li>
              <li class="ls-item">
                <button class="acc-room-number-icon acc-icons">
                  <i class="fas fa-bed"></i>
                </button>
                <p> 
                  Room Number
                    <span> 
                      <b>'.$roomNo.'</b>
                    </span>
                </p>
              </li>
            ';
          }elseif($ctrPanel->roomRequest() == 0){
            echo '
              <li class="ls-item">
                <button class="acc-room-number-icon acc-icons">
                  <i class="fas fa-bed"></i>
                </button>
                <p>
                  Room Requested
                  <button class="room-x acc-icons">
                    <i class="fas fa-check-circle"></i>
                  </button>
                </p>
              </li>
            ';
          }else{
            echo '
              <li class="ls-item">
                <button class="acc-room-number-icon acc-icons">
                  <i class="fas fa-bed"></i>
                </button>
                <p>
                  Room Requested
                  <button class="room-x acc-icons">
                    <i class="fas fa-times-circle"></i>
                  </button>
                </p>
              </li>
            ';
          }
          
        ?>
        
        <li class="ls-item">
          <button class="acc-check-in-icon acc-icons">
            <i class="fas fa-door-closed"></i>
          </button>
          <p>Check In
            <?php 
              echo '
                <span class="check-out-date">
                  '.$checkInDate.'
                </span>
              ';
            ?>
          </p>
        </li>
        <li class="ls-item">
          <button class="acc-check-out-icon acc-icons">
            <i class="fas fa-door-open"></i>
          </button>
          <p>
            Check Out 
            <?php 
              echo '
                <span class="check-out-date">
                  '.$checkOutDate.'
                </span>
              ';
            ?>
          </p>
        </li>
      </ul>
    </div>
  </div>
  <!-- ############ Copy-right panel ################## -->
  <div class="copyright-info-container">
    <p class="copyright-text">&copy; LSU 
      <span id="copyright-year">2022</span>. Study your books.</p>
    <p class="copyright-text">Made by Vessel &copy; For LSU.</p>
  </div>
</section>
