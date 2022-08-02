import SearchbarRemove from './searchbar-remove.js';
import * as storage from './localstorage.js';

export default class SearchbarSelect{
  constructor(){
    this.maxNoOfRoomMates = 0;
    this.allowedNoOfRoomMates = 0;
    this.preferredNumOfRoomMates = 0;
    
    this.studentQueryData = [];
    this.singleStudentInfo = {};
    
    this.getDefaults();
    // console.log("Defaults: ", this.allowedNoOfRoomMates, this.maxNoOfRoomMates);
  }
  
  getDefaults(){
    //check the type of request - if this person 
    //is adding a new room-mate after another-one cancelled.
    const url = "./includes/modify-request.inc.php";
    
    fetch(url, {
    }).then((res) => res.json())
    .then((res) => {
      this.maxNoOfRoomMates = res.studentsPerRoom - 1;
      this.preferredNumOfRoomMates = res.preferredNumOfRoomMates ? res.preferredNumOfRoomMates : 0 ;
      this.allowedNoOfRoomMates = this.maxNoOfRoomMates - this.preferredNumOfRoomMates;
      
      const defaults = {
        maxNoOfRoomMates: this.maxNoOfRoomMates,
        preferredNumOfRoomMates: this.preferredNumOfRoomMates,
        allowedNoOfRoomMates: this.allowedNoOfRoomMates
      }
      
      storage.addDefaultsToLS(defaults)
      // console.log("Defaults: ", this.preferredNumOfRoomMates, this.maxNoOfRoomMates);
    });
    
  }
  
  //handles the click on the student id
  selectStudent(studentQueryData) {
    this.studentQueryData = studentQueryData;
    
    const searchResultsContainer = document.querySelector(
      ".search-results-container"
    );    
    const searchResultListItems = searchResultsContainer.querySelectorAll(
      ".search-rlt-list-item"
    );
      
    searchResultListItems.forEach(resultItem => {
      resultItem.addEventListener("click", ev => {
        const selectedStudentId = ev.currentTarget.dataset.id;
        
        //adding the current student to the localStorage selectedStudents
        storage.addToLocalStorage(selectedStudentId, "selectedStudents");
        
        searchResultsContainer.classList.remove("show-results");
        this.selectedStudentInfo(selectedStudentId);
        
      });
    });
        
  }//endoffunc
  
//takes the selected student id and gets the info from the array
//that holds db result query and adds the selected student
// to an array of selected students info
selectedStudentInfo(selectedStudentId) {
  
  this.studentQueryData.forEach(student => {
    if(student.studentId == selectedStudentId){
      this.singleStudentInfo = student;
    }
  });
  
  //if the array already the maximum number of room-mates 
  //remove the first selected student and add the newly
  //selected
  
  this.shiftSelectedStudents(this.allowedNoOfRoomMates);
  
  //adding it to the studentsInfo Arr
  storage.addToLocalStorage(this.singleStudentInfo, "studentsInfo");
  
  //rendering the selected students info
  this.renderSelectedStudentInfo();
}
  
shiftSelectedStudents(maxNoOfRoomMates){
  if (storage.getLocalStorage("studentsInfo").length == maxNoOfRoomMates) {
    //removing it from the studentsInfo Arr & from the list of id's
    storage.shiftLocalStorage("studentsInfo");
    storage.shiftLocalStorage("selectedStudents");
  }
}

renderSelectedStudentInfo() {
  
  const selectedRoomMatesContainer = document.querySelector(
    ".selected-rm-ms-container"
  );
  const selectedRoomMatesContent = document.querySelector(
    ".selected-rm-ms-content"
  );
  
  selectedRoomMatesContent.innerHTML = "";

  storage.getLocalStorage("studentsInfo").forEach((student) => {
    const studentNameLetter = student.fullName.substr(0, 1);
    const div = document.createElement("div");
    div.classList.add("selected-rm-mt");
    div.dataset.id = student.studentId;
    
    div.innerHTML = `
      <div class="selected-rm-mt-profile">
        <div class="letter-container">
          <span class="selected-letter">${studentNameLetter}</span>
        </div>
        <div class="selected-rm-mt-details">
          <h4 class="selected-rm-mt-name">${student.fullName}</h4>
          <p>@<span class="selected-rm-mt-st-number">${student.studentId}</span></p>
        </div>
      </div>
      <button class="remove-rm-mate-icon">
        <i class="fas fa-times"></i>
      </button>
    `;

    selectedRoomMatesContainer.classList.add("show-room-mates");
    selectedRoomMatesContent.appendChild(div);
      
  });
  //getting the remove btns after being loaded
  const removeRoomMateBtns = selectedRoomMatesContent.querySelectorAll(".remove-rm-mate-icon");
    
  //instatiate the searchbar-remove class 
  const removeBtn = new SearchbarRemove();
  removeBtn.clickRemoveStudentBtn(removeRoomMateBtns);
  
}
  
}//endofclass























