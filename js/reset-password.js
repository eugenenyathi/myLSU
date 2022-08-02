//importing the utils
import * as util from './utils.js';

const studentNumber = document.getElementById("studentNumber");
const nationalId = document.getElementById("nationalId");
const form = document.getElementById("form");
const formControls = document.querySelectorAll(".sign-in-input-wrapper");

const daySelector = document.getElementById("day");
const monthSelector = document.getElementById("month");
const yearSelector = document.getElementById("year");

const newPassword = document.getElementById("password");
const confirmNewPassword = document.getElementById("confirm-password");
const error = document.getElementById('reset-password-msg');

let counter = 0;

form.addEventListener("submit", (ev) => {
  ev.preventDefault();
  if (counter == 1) {
    sanitizePasswords(newPassword, confirmNewPassword);
  } else {
    sanitizeInputs(studentNumber, nationalId);
  }
});

[studentNumber, nationalId].forEach((inputField) => {
  inputField.addEventListener("input", (ev) => {
    ev.target.value = ev.target.value.toUpperCase();
    ev.currentTarget.style.borderColor = "#5996ff";
  });
});

[newPassword, confirmNewPassword].forEach((inputField) => {
  inputField.addEventListener("input", (ev) => {
    error.style.display = "none";
    ev.currentTarget.style.borderColor = "#5996ff";
  });  
});

[ daySelector, monthSelector, yearSelector].forEach((inputField) => {
  inputField.addEventListener("change", (ev) => {
    error.style.display = "none";
    ev.currentTarget.style.borderColor = "#5996ff";
    
    [ daySelector, monthSelector, yearSelector].forEach((inputField) => {
          inputField.style.borderColor = "#5996ff";
    });
    
  });
});



function sanitizeInputs(studentNumber, nationalId) {
  const studentNumberValue = studentNumber.value;
  const nationalIdValue = nationalId.value;

  const stNoRegex = /^L0\d{6}[A-Z]$/;
  const ntIdRegex = /\d{2}-\d{6}[A-Z]\d{2}/;

  if (empty(studentNumberValue) || empty(nationalIdValue)) {
    if (empty(studentNumberValue)) {
      util.shake(studentNumber);
    } else if (empty(nationalId.value)) {
      util.shake(nationalId);
    }
  } else if (studentNumberValue.length != 9 || nationalIdValue.length != 12) {
    if (studentNumberValue.length != 9) {
      util.shake(studentNumber);
    } else if (nationalIdValue.length != 12) {
      util.shake(nationalId);
    }
  } else if (
    stNoRegex.test(studentNumberValue) == false ||
    ntIdRegex.test(nationalIdValue) == false
  ) {
    if (stNoRegex.test(studentNumberValue) == false) {
      util.shake(studentNumber);
    } else if (ntIdRegex.test(nationalIdValue) == false) {
      util.shake(nationalId);
    }
  } else {
    postUserData(studentNumber, nationalId);
  }
}

function sanitizePasswords(newPassword, confirmNewPassword) {
  
  if (empty(newPassword.value) || empty(confirmNewPassword.value)) {
    if (empty(newPassword.value)) {
      util.shake(newPassword);
      util.msg("*Password field is empty", error);
    } else {
      util.shake(confirmNewPassword);
      util.msg("*Confirm-password field is empty", error);
    }
  } else if (newPassword.value.length < 8 || confirmNewPassword.value.length < 8) {
    [newPassword, confirmNewPassword].forEach((inputField) => {
      util.shake(inputField);
    });
    util.msg("*Password(s) length is less than 8!", error);
  } else if (newPassword.value !== confirmNewPassword.value) {
    [newPassword, confirmNewPassword].forEach((inputField) => {
      util.shake(inputField);
      util.msg("*Passwords do not match!", error);
    });
  } else {
    console.log("data-sent.");
    postUserPassword(studentNumber, newPassword, confirmNewPassword);
  }
  
}

function postUserPassword(studentNumber, newPassword, confirmNewPassword){
  
  const user_data = {
    opr: 1,
    studentId: studentNumber.value,
    newPassword: newPassword.value,
    confirmNewPassword: confirmNewPassword.value
  };
  
  const url = "./includes/reset-password.inc.php";
  
  fetch(url, {
    method: "POST",
    headers: { "Content-type":"application/json" },
    body: JSON.stringify(user_data)
  }).then((res) => res.text())
  .then((res) => pwdResponseHandler(res))
  
}

function pwdResponseHandler(res){
  switch(res){
    case '802':
      util.shakeTwo([newPassword, confirmNewPassword]);
      util.msg("*Empty Passwords", error);
      break;
    case '992':
      util.shakeTwo([newPassword, confirmNewPassword]);
      util.msg("*Invalid password(s) length", error);
      break;  
    case '3002':
      util.shakeTwo([newPassword, confirmNewPassword]);
      util.msg("*Passwords do not match.", error);
      break;
    case '5000':
      window.location.href = "./home.php";
      break;
    case '5001':
      util.shakeTwo([newPassword, confirmNewPassword]);
      util.msg("*Oops' something went wrong please try again.", error);
      break;
    default:
      console.log(res);  
  }
}

function postUserData(studentNumber, nationalId) {
  
  daySelector.value = '12';
  monthSelector.value = 'March';
  yearSelector.value = '2003';
  
  let month = months.indexOf(monthSelector.value) + 1;
  
  if(month < 10){
    month = "0"+month;
  }
  
  let dob = 
  [ yearSelector.value, month, daySelector.value ].join("-");
  
  const user_data = {
    opr: 0,
    studentId: studentNumber.value,
    nationalId: nationalId.value,
    dob: dob
  };

  const url = "./includes/reset-password.inc.php";

  fetch(url, {
    method: "POST",
    headers: { "Content-type": "application/json" },
    body: JSON.stringify(user_data),
  })
    .then((res) => res.text())
    .then((res) => identityErrHandler(res));
}

function identityErrHandler(res){
  
  console.log(res);
  
  switch(res){
    case '100':
      util.msg("*Unauthorised action!", error);
      break;
      
    case '3000':
      util.shake(studentNumber);
      util.msg("Student Number not found!", error);
      break;
      
    case '3001':
      let elements = [ nationalId, daySelector, monthSelector, yearSelector]; 
      elements.forEach((field) => {
        util.shake(field);
        util.msg("*Please enter valid details.", error);
      });
      break;
      
    case '5000':
      counter++;
      //  de-active and active different forms
      displayForms(formControls);
      document.getElementById("reset-btn").textContent = "Submit";
      break;
      
    default:
      console.log(res);
      return;
  }
  
}

function displayForms(formControls) {
  formControls.forEach((formControl) => {
    if (formControl.classList.contains("set-new-password")) {
      formControl.classList.add("active");
    } else {
      formControl.classList.add("de-active");
    }
  });
}

function empty(string) {
  if (string == "") {
    return true;
  }

  return false;
}

const months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];

const thirtyOne = [
  "January",
  "March",
  "May",
  "July",
  "August",
  "October",
  "December",
];

const thirty = ["April", "June", "September", "November"];

window.addEventListener("DOMContentLoaded", (ev) => {
  populateMonth();
  populateYears();
  yearSelector.value = "2005";
  populateDays(monthSelector.value);
});

monthSelector.addEventListener("change", (ev) => {
  populateDays(monthSelector.value);
});

let previousDay;

daySelector.addEventListener("change", (ev) => {
  previousDay = daySelector.value;
});

function populateYears() {
  const year = new Date().getFullYear() - 17;
  yearSelector.value = "Year";

  for (let i = 0; i <= 40; i++) {
    const option = document.createElement("option");
    option.textContent = year - i;
    yearSelector.appendChild(option);
  }
}

function populateMonth() {
  monthSelector.value = "Month";

  for (let i = 0; i < months.length; i++) {
    const option = document.createElement("option");
    option.textContent = months[i];
    monthSelector.appendChild(option);
  }
}

function populateDays(month) {
  daySelector.value = "day";

  let dayNum;
  let year = yearSelector.value;

  if (thirtyOne.includes(month)) {
    dayNum = 31;
  } else if (thirty.includes(month)) {
    dayNum = 30;
  } else {
    if (new Date(year, 1, 29).getMonth() === 1) {
      dayNum = 29;
    } else {
      dayNum = 28;
    }
  }

  for (let i = 1; i <= dayNum; i++) {
    const option = document.createElement("option");
    option.textContent = i;
    daySelector.appendChild(option);
  }

  if (previousDay) {
    daySelector.value = previousDay;
    if (daySelector.value === "") {
      daySelector.value = previousDay - 1;
    }
    if (daySelector.value === "") {
      daySelector.value = previousDay - 2;
    }
    if (daySelector.value === "") {
      daySelector.value = previousDay - 3;
    }
  }
}
