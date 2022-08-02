import SearchbarSelect from './searchbar-select.js';
import * as storage from './localstorage.js';

export default class SearchbarRemove{
  constructor(){
  }
  
  clickRemoveStudentBtn(removeRoomMateBtns){
    //remove room-mate btn
    removeRoomMateBtns.forEach((btn) => {
      btn.addEventListener("click", (ev) => {
        const removeStudentId = ev.currentTarget.parentElement.dataset.id;
        this.removeStudent(removeStudentId);
      });
    });
    
  }
  
  removeStudent(removeStudentId){
    const selectedRoomMatesContainer = document.querySelector(
      ".selected-rm-ms-container"
    );
    
    //removing it from the list of id's that will be sent to the server
    storage.removeFromSelectedStudents(removeStudentId);

    //removing it from the dom
    storage.removeFromStudentsInfo(removeStudentId);
    
    //instatiate SearchbarSelect class 
    const select = new SearchbarSelect(null);
    //calling the render method to make the changes in the dom
    select.renderSelectedStudentInfo();
    
    if(storage.getLocalStorage("selectedStudents").length == 0){
      selectedRoomMatesContainer.classList.remove("show-room-mates");
    }
    
  } // -- end of the removeStudent method
  
  
}//endofclass