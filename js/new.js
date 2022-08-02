import View from './views/view.js';

const confirmCancelBtns = document.querySelectorAll(".confirm-cancel-btn-container button");

confirmCancelBtns.forEach((btn) => {
  btn.addEventListener("click", (ev) => {
    if(ev.currentTarget.classList.contains("confirm-room-mates")){
      sendResponse(1);
    }else{
      sendResponse(-1);
    }
  });
});

function sendResponse(res){
  const url = "./includes/room-mate-response.inc.php";
  
  const roomMateResponse = {
    response: res
  };
  
  fetch(url, {
    method: "POST",
    headers: { "Content-type": "application/json"},
    body: JSON.stringify(roomMateResponse)
  })
  .then((res) => res.json())
  .then((res) => responseHandler(res));
  // .then((res) => res.text())
  // .then((res) => console.log(res));
  
}

function responseHandler(res){
  
  const code = res.code;
  
  switch(code){
    
    case '5000':
    //make changes to the dom
      setTimeout(()=>{
        loadView(res);
      }, 1500);
      
      break;
      
    case '5001':
      console.log("Db-error!");
      break;
      
    default: 
      console.log("Error => " + code);
      
  }
}

function loadView(res){
  const viewType = res.viewType;
  const studentFirstName = res.studentFirstName;
  const requestRoomDate = res.requestRoomDate;
  const requestRoomMateName = res.requestRoomMateName;
  const tuitionPaid = res.tuitionPaid;
  const tuitionOwing = res.tuitionOwing;
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
  
  let dateEnglish = requestRoomDate.length > 10 ? "on" : "at";
  
  const view = new View();
  view.flushDom();
  
  switch(viewType){

    case 'confirmedMateView':
      let requestDateReminder =
      `You have a pending room request made by 
      <b>${requestRoomMateName}</b> ${dateEnglish} ${requestRoomDate}
      `;
      view.reminderView([reminder, requestDateReminder]);
      view.confirmedMateView(studentsInfo);
      break;
      
    default:
      console.log(viewType);
  }
  
}


















































