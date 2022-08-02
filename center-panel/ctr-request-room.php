<?php 

  include_once './universal/universal-contr.php';
  
  $universal = new UniversalContr(null);
  $studentsPerRoom = $universal->studentsPerRoom() - 1;
  
  echo '
    <div class="reminder-container">
      <div class="reminder" id="request-room-notif-text">
        <p class="reminder-text">
          Use the search bar below to add '.$studentsPerRoom.' of your preferred room mates.
        </p>
      </div>
    </div>
    '
  ;
    
  echo '
  
    <section class="center-panel-main-content">
      <div class="search-rm-ms-container">
        <form action="" class="search-submit-container">
          <input
            type="text"
            class="search-rm-ms-input"
            placeholder="Search by student number"
            value="L02"
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
      <button class="request-room" name="request-room">Request Room</button>
    </section>
  ';