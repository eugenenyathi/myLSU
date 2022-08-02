export default class SearchbarContr{
  constructor(searchInput){
    this.searchInput = searchInput;
    this.maxNoOfRoomMates;
    this.allowedNoOfRoomMates;
    
    // this.studentQueryData = [];
    // this.selectedStudents = [];    
    // this.singleStudentInfo = [];
    // this.studentsInfo = [];
    // 
    this.getDefaults();
    
  }
  
  getDefaults(){
    //check the type of request - if this person 
    //is adding a new room-mate after another-one cancelled.
    fetch("./includes/modify-request.inc.php", {
    }).then((res) => res.json())
    .then((res) => {
      this.maxNoOfRoomMates = parseInt(res.studentsPerRoom) - 1;
      this.allowedNoOfRoomMates = parseInt(res.preferredNumOfRoomMates);
      
     console.log(this.maxNoOfRoomMates, this.allowedNoOfRoomMates);
    });
    // .then((res) => this.roomMatesNo = parseInt(res));
  }
  
  invalidStudentId() {
    if (/^L0\d*/.test(this.searchInput.value) == false) {
      return;
    }
  }
  

  
}//endofclass
