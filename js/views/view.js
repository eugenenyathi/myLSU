export default class View{
  constructor(){
    //define the html dom elements
  }
  
  flushDom(){
    const ctrPanel = document.querySelector(".center-panel");
    ctrPanel.style.display = "block";
    ctrPanel.innerHTML = '';
    
    const reminderContainer = document.createElement("div");
    reminderContainer.classList.add('reminder-container');
    
    const ctrPanelMainContent = document.createElement("div");
    ctrPanelMainContent.classList.add("center-panel-main-content");
    
    ctrPanel.appendChild(reminderContainer);
    ctrPanel.appendChild(ctrPanelMainContent);
    
  }
    
  reminderView(reminders){
    const reminderContainer = document.querySelector(".reminder-container");    
    
    reminders.forEach((reminder) => {
      const div = document.createElement("div");
      div.classList.add("reminder");
      
      div.innerHTML = `
        <p class="reminder-text">
          ${reminder}
       </p>
      `;
      
      reminderContainer.appendChild(div);
    })
    
  }
  
  defaultView(){
    
    const ctrPanelMainContent = document.querySelector(".center-panel-main-content");
    const searchRoomMatesContainer = document.createElement("div");
    const selectedRoomMatesContainer = document.createElement("div");
    const requestRoomBtn = document.createElement("button");
    
    searchRoomMatesContainer.classList.add("search-rm-ms-container");
    selectedRoomMatesContainer.classList.add("selected-rm-ms-container");
    requestRoomBtn.classList.add("request-room");
    
    requestRoomBtn.textContent = 'Request Room';
    
    searchRoomMatesContainer.innerHTML = `
      <form class="search-submit-container">
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
    `;
    
    selectedRoomMatesContainer.innerHTML = `
      <h2 class="selected-rm-ms-heading">Selected most preferred room-mates</h2>
      <div class="selected-rm-ms-content">
        <!-- Javascript generated data -->
      </div>
    `;
    
    ctrPanelMainContent.appendChild(searchRoomMatesContainer);
    ctrPanelMainContent.appendChild(selectedRoomMatesContainer);
    ctrPanelMainContent.appendChild(requestRoomBtn);
    
    //creating and loading a js file
    const scriptUrl = './js/searchbar.js';
    this.loadJS(scriptUrl, 'module');
  }

//displays to the who has confirmed the request 
  confirmedMateView(studentsInfo){
    const className = 'confirm';
    const headingText = 'The following are your preferred room mates.';
    
    this.clusterView(className, headingText, studentsInfo);
  }
  
  //displays to the room mates selected by the 
  //one who made the request
  selectedMateView(studentsInfo, requestRoomMateName){  
    const className = "confirm";
    const headingText = `Please confirm these room mates selected by <b>${requestRoomMateName}</b>.`;
    
    this.clusterView(className, headingText, studentsInfo);
    
    const confirmRoomMatesContent = document.querySelector('.confirm-rm-ms-content');
    const btnContainer = document.createElement('div');
    const confirmBtn = document.createElement('button');
    const declineBtn = document.createElement('button');
    
    btnContainer.classList.add('confirm-cancel-btn-container');
    confirmBtn.classList.add('confirm-room-mates');
    declineBtn.classList.add('cancel-room-mates');
    
    confirmBtn.textContent = 'Confirm';
    declineBtn.textContent = 'Decline';
    
    btnContainer.appendChild(confirmBtn);
    btnContainer.appendChild(declineBtn);
    confirmRoomMatesContent.appendChild(btnContainer);
    
    //creating and loading a js file
    const scriptUrl = './js/room-mate-response.js';
    this.loadJS(scriptUrl, 'module');
    
  }
  
  //displays to the one who made the request
  preferredMateView(studentsInfo){
    const className = 'preferred';
    const headingText = 'You selected the following as your preferred room mates.';
    
    this.clusterView(className, headingText, studentsInfo);
  }
    
  // requestMadeView(studentsInfo){
  //   const ctrPanelMainContent = document.querySelector(".center-panel-main-content");
  //   const preferredRoomMatesContainer = document.createElement("div");
  //   const preferredRoomMatesContent = document.createElement("div");
  //   const heading = document.createElement("h2");
  // 
  //   heading.classList.add("preferred-rm-ms-heading");
  //   preferredRoomMatesContainer.classList.add("preferred-rm-ms-container");
  //   preferredRoomMatesContent.classList.add("preferred-rm-ms-content");
  // 
  //   heading.innerHTML = "You selected the following as your preferred room mates.";
  // 
  //   studentsInfo.forEach((student) => {
  //     const studentNameLetter = student.fullName.substr(0, 1);
  //     const div = document.createElement("div");
  //     div.classList.add("preferred-rm-mt");
  // 
  //     div.innerHTML = `
  //       <div class="preferred-rm-mt-profile">
  //         <div class="preferred-letter-container">
  //           <span class="preferred-letter">${studentNameLetter}</span>
  //         </div>
  //         <div class="preferred-rm-mt-details">
  //           <h4 class="preferred-rm-mt-name">${student.fullName}</h4>
  //           <p>@<span class="preferred-rm-mt-st-number">${student.studentId}</span></p>
  //         </div>
  //       </div>
  //     `;
  // 
  //     preferredRoomMatesContent.appendChild(div);
  // 
  //   });
  // 
  //   preferredRoomMatesContainer.appendChild(heading);
  //   preferredRoomMatesContainer.appendChild(preferredRoomMatesContent);
  // 
  //   ctrPanelMainContent.innerHTML = '';
  //   ctrPanelMainContent.appendChild(preferredRoomMatesContainer);
  // 
  // }
  
  clusterView(className, headingText, studentsInfo){
    const ctrPanelMainContent = document.querySelector(".center-panel-main-content");
    const clusterContainer = document.createElement("div");
    const clusterContent = document.createElement("div");
    const heading = document.createElement("h2");
        
    heading.classList.add(`${className}-rm-ms-heading`);
    clusterContainer.classList.add(`${className}-rm-ms-container`);
    clusterContent.classList.add(`${className}-rm-ms-content`);
    
    heading.innerHTML = headingText;
    
    studentsInfo.forEach((student) => {
      const studentNameLetter = student.fullName.substr(0, 1);
      const div = document.createElement("div");
      div.classList.add(`${className}-rm-mt`);
      
      div.innerHTML = `
        <div class="${className}-rm-mt-profile">
          <div class="${className}-letter-container">
            <span class="${className}-letter">${studentNameLetter}</span>
          </div>
          <div class="${className}-rm-mt-details">
            <h4 class="${className}-rm-mt-name">${student.fullName}</h4>
            <p>@<span class="${className}-rm-mt-st-number">${student.studentId}</span></p>
          </div>
        </div>
      `;

      clusterContent.appendChild(div);
        
    });
    
    clusterContainer.appendChild(heading);
    clusterContainer.appendChild(clusterContent);
    
    ctrPanelMainContent.innerHTML = '';
    ctrPanelMainContent.appendChild(clusterContainer);    
  }
  
  loadJS(fileUrl, type = 'text/javascript'){
    const script = document.createElement('script');
    script.setAttribute('type', type);
    script.setAttribute('src', fileUrl);
    
    document.body.appendChild(script);
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
}//endofclass
