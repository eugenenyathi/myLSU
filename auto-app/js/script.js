
const resetBtn = document.getElementById('reset-btn');
const setRoommates = document.getElementById('set-roommates');
const allocateRooms = document.getElementById('allocate-rooms');


resetBtn.addEventListener('click', (ev) => {
  const url = "./includes/reset.inc.php";
  fetchReq(url);
})

setRoommates.addEventListener('click', (ev) => {
  const url = "./includes/set-roommates.inc.php";
  fetchReq(url);
})

allocateRooms.addEventListener('click', (ev) => {
  const url = "../includes/allocate-room.inc.php";
  fetchReq(url);
})


function fetchReq(url){
  fetch(url)
  .then((res) => res.text())
  .then((res) => console.log(res))
}

// switch(res){
//   case '5000':
//     console.log("operation-successful.");
//     break;
//   default:
//     console.log("Error -", res);
// }