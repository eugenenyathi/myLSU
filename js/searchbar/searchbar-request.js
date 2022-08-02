import View from '../views/view.js';
import * as storage from './localstorage.js';

export default class SearchbarRequest{

  constructor(){
    this.selectedRoomMates = {};
  }

  makeRequest(){
    const defaults = storage.getLocalStorage("defaults");
    this.allowedNoOfRoomMates = defaults.allowedNoOfRoomMates;
    
    if(storage.getLocalStorage("selectedStudents").length == 0 || 
      storage.getLocalStorage("selectedStudents").length !== this.allowedNoOfRoomMates)
      {
      console.log("Minimum room-mates selected should be ", this.allowedNoOfRoomMates);
      return;
    }
    // else{
    //   console.log(storage.getLocalStorage("selectedStudents"), this.allowedNoOfRoomMates);
    // }
    
    
    let len = 1;
    let name = "roomMate1";
    
    storage.getLocalStorage("selectedStudents").forEach((studentId) => {
      let newName = name.replace(name.charAt(name.length - 1), len);
      this.addRoomMate(this.selectedRoomMates, newName, `${studentId}`);
      len++;
    });
    
    const url = "./includes/request-room.inc.php";
    
    fetch(url, {
      method: "POST",
      headers: { "Content-type": "application/json"},
      body: JSON.stringify(this.selectedRoomMates)
    })
    .then((res) => res.json())
    .then((res) => this.responseHandler(res))
    // .then((res) => res.text())
    // .then((res) => console.log(res));
    // 
  }
  
  addRoomMate(object, key, value) {
    object[`${key}`] = value;
  }
  
  msg(text, target, color="red") {
    target.textContent = text;
    target.style.color = color;
  }
  
  responseHandler(res){
    
    const code = res.code;
    const studentFirstName = res.studentFirstName;
    const tuitionPaid = res.tuitionPaid;
    const tuitionOwing = res.tuitionOwing;
    const requestRoomDate = res.requestRoomDate;
    const studentsInfo = res.roomMates;
    
    let tuitionReminder = `
      Hie <span class="student-name"> ${studentFirstName},</span> 
      Thank you for paying $${tuitionPaid}. 
      We kindly remind you to clear the remainder of 
      <span class="amount-owing">$${tuitionOwing}.</span>
    `;
    
    let tuitionReminder2 = ` <span class="student-name"> ${studentFirstName} </span>
    Thank you for fully paying your tuition. `;
    
    let reminder = tuitionOwing ? tuitionReminder : tuitionReminder2;
    
    const view = new View();
    
    const searchResultsContainer = document.querySelector(
      ".search-results-container"
    );
    const selectedRoomMatesContainer = document.querySelector(
      ".selected-rm-ms-container"
    );
    const requestRoomBtn = document.querySelector(".request-room");
    const requestRoomNotif = document.querySelector("#request-room-notif-text");
      
    switch(code){
      case '5000':
        this.msg("Room Request Successful.", requestRoomNotif, "#000");
        
        //remove the selected room mates container
        const ctrPanel = document.querySelector(".center-panel-main-content");
        ctrPanel.style.display = "none";
        
        setTimeout(()=>{
          //makes changes to the dom
          let requestDateReminder = `You have a pending room request you made ${requestRoomDate}`;
          view.flushDom();
          view.reminderView([ reminder, requestDateReminder ]);
          view.preferredMateView(studentsInfo);
        }, 2000);
        
        break;
        
      default:
        console.log(code);
        this.msg("Room Request Failed. Please try again!", requestRoomNotif);
        selectedRoomMatesContainer.classList.remove("show-room-mates");
        storage.clearLocalStorage();
        break;
    }
  }
  
}//endofclass






















