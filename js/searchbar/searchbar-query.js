import SearchbarSelect from './searchbar-select.js';

export default class SearchbarQuery{
  
  constructor(searchInput, searchResultsList, searchResultsContainer){
    this.searchInput = searchInput;
    this.searchResultsList = searchResultsList;
    this.searchResultsContainer = searchResultsContainer;
    this.studentQueryData = [];
    this.selectedStudents = [];

  }
  
  sendSearch() {
    const url = "./includes/searchbar.inc.php";  
        
    const UserInput = {
      studentId: this.searchInput.value
    };
    
    fetch(url, {
      method: "POST",
      headers: {"Content-type": "application/json"},
      body: JSON.stringify(UserInput)
    })
      .then(res => res.json())
      .then(data => {
        if(data == "4000"){
          console.log("Zero records found!.");
          this.studentQueryData = [];
          this.searchResultsList.innerHTML = "";
          this.searchResultsContainer.classList.remove("show-results");
        }else{
          this.studentQueryData = [];
          this.studentQueryData.push(data);
          this.studentQueryData = this.studentQueryData.flat(Infinity); 
          
          this.renderResults(data); 
        }
      });
    // .then(res => res.text())
    // .then(data => console.log(data));
  
  }
  
  renderResults(data) {
    
    if (data.length == 0) {
      this.searchResultsList.innerHTML = "";
      this.searchResultsContainer.classList.remove("show-results");
      return;
    }
    
    let freeStudents;
    let takenStudents;
    
    data.forEach((array, counter) => {
      
      if(array.length != 0){
        if(counter == 0){
          freeStudents = array.map(student => {
              return `
            <li data-id=${student.studentId} class="search-rlt-list-item">
              <div class="mini-st-details">
                <span class="search-rlt-st-name">${student.fullName}</span>
              </div>
            </li>
            `;
            })
            .join("");  
        }
        else if(counter == 1){
          takenStudents = array.map(student => {
              return `
            <li data-id=${student.studentId} class="search-rlt-list-item">
              <div class="mini-st-details">
                <span class="search-rlt-st-name grey">${student.fullName}</span>
              </div>
            </li>
            `;
            })
            .join("");
        }
        
        freeStudents = freeStudents ? freeStudents : '';
        takenStudents = takenStudents ? takenStudents : '';
        
        const userResult = freeStudents + takenStudents;
        
        if(userResult != ''){
          this.searchResultsContainer.classList.add("show-results");
          this.searchResultsList.innerHTML = "";
          this.searchResultsList.innerHTML = userResult;
              
          const select = new SearchbarSelect();
          select.selectStudent(this.studentQueryData);

        }  

      }//endofarraylengthcheckingifstatement
    
    });//endofloop    
  
  }//endoffunction
  
}//endofclass

  








