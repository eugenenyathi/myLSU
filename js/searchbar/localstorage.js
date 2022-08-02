
/*creating the localStorages*/
// function createStorageItem(name){
//     localStorage.setItem(name, JSON.stringify([]));
// }

function addDefaultsToLS(object){
  localStorage.setItem("defaults", JSON.stringify(object));
}

function getLocalStorage(targetArr){
  return localStorage.getItem(targetArr) ? JSON.parse(localStorage.getItem(targetArr)) : [];
}

function addToLocalStorage(studentData, targetArr){
  const storage = getLocalStorage(targetArr);
  storage.push(studentData);
  localStorage.setItem(targetArr, JSON.stringify(storage));
}

function shiftLocalStorage(targetArr){
  const storage = getLocalStorage(targetArr);
  storage.shift();
  localStorage.setItem(targetArr, JSON.stringify(storage));
}

function removeFromSelectedStudents(studentId){
  const storageLS = getLocalStorage("selectedStudents");
  const storage = storageLS.filter((id) => {
    return id != studentId;
  });
  
  localStorage.setItem("selectedStudents",  JSON.stringify(storage));
}

function removeFromStudentsInfo(studentId){
  const storageLS = getLocalStorage("studentsInfo");
  let newStudentsInfo = [];
      
  storageLS.forEach((student) => {
    if(student.studentId != studentId){
        newStudentsInfo.push(student);
    }
  });
  
  localStorage.setItem("studentsInfo", JSON.stringify(newStudentsInfo));
  
}

function clearLocalStorage(){
  localStorage.clear();
}

export { getLocalStorage,  addDefaultsToLS, addToLocalStorage, shiftLocalStorage,
         removeFromSelectedStudents, removeFromStudentsInfo, clearLocalStorage 
       };