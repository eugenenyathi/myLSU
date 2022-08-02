import SearchbarQuery from './searchbar/searchbar-query.js';
import SearchbarSelect from './searchbar/searchbar-select.js';
import SearchbarRequest from './searchbar/searchbar-request.js';
import * as storage from './searchbar/localstorage.js';


function invalidStudentId(searchInput) {
  if (/^L0\d*/.test(searchInput.value) == false) {
    return true;
  }
  
  return false;
}

const searchInput = document.querySelector("#ctr-search-input"); 
const searchResultsContainer = document.querySelector(
  ".search-results-container"
);
const searchResultsList = document.querySelector(
  ".search-results-ul-container"
);

const requestRoomBtn = document.querySelector(".request-room");
const requestRoomNotif = document.querySelector("#request-room-notif-text");


window.addEventListener("DOMContentLoaded", (ev) => {
  storage.clearLocalStorage();
})

const query = 
  new SearchbarQuery(searchInput, searchResultsList, searchResultsContainer);  

const request = new SearchbarRequest();

searchInput.addEventListener("input", (ev) => {
  if (searchInput.value.toUpperCase().length >= 2) {
    if(invalidStudentId(searchInput)){
      console.log("Invalid Student Number!");
    }else{
      query.sendSearch(); 
    }
  }
});

// if (searchInput.value.toUpperCase().length >= 2) {
//   if(invalidStudentId(searchInput)){
//     console.log("Invalid Student Number!");
//   }else{
//     query.sendSearch(); 
//   }
// }

requestRoomBtn.addEventListener("click", (ev) => {
  request.makeRequest();
});























































