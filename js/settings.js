import * as util from './utils.js';

const openSettingsBtn = document.querySelector(".open-st-settings");
const closeSettingsBtn = document.querySelector(".close-settings-btn");
const closeSettingsBtnWrapper = document.querySelector(
  ".close-settings-btn-wrapper"
);
const settingsContainer = document.querySelector(".settings-container");

openSettingsBtn.addEventListener("click", (ev) => {
  settingsContainer.style.display = "block";
});

closeSettingsBtn.addEventListener("mouseenter", (ev) => {
  closeSettingsBtnWrapper.style.borderColor = "red";
});

closeSettingsBtn.addEventListener("mouseleave", (ev) => {
  closeSettingsBtnWrapper.style.borderColor = "#bfbfbf";
});

closeSettingsBtn.addEventListener("click", (ev) => {
  settingsContainer.style.display = "none";
});

const settingsEyes = document.querySelectorAll(".settings-eye-icon");
util.togglePasswordView(settingsEyes);

//change password
const currentPassword = document.querySelector("#st-current-password");
const newPassword = document.querySelector("#st-new-password");
const confirmNewPassword = document.querySelector("#st-confirm-password");
const settingsForm = document.querySelector("#settings-form");
const error = document.querySelector(".settings-msg");

settingsForm.addEventListener("submit", (ev) => {
  ev.preventDefault();
  verifyPassword(currentPassword, newPassword, confirmNewPassword);
});


[currentPassword, newPassword, confirmNewPassword].forEach((password) => {
  password.addEventListener("input", (ev) => {
    ev.target.classList.remove("shake");
    target.style.border = `2px solid null`;

    error.style.color = "null";
    error.textContent =
      " *Password should not have a length less than 8, it must have a mix of letters, numbers and symbols.";
  });
});

function verifyPassword(currentPassword, newPassword, confirmNewPassword) {
  const currentPasswordValue = currentPassword.value;
  const newPasswordValue = newPassword.value;
  const confirmNewPasswordValue = confirmNewPassword.value;

  if (!currentPasswordValue || !newPasswordValue || !confirmNewPasswordValue) {
    if (!currentPasswordValue) {
      util.shake(currentPassword);
      util.msg("current password field is empty!");
    } else if (!newPasswordValue) {
      util.shake(newPassword);
      util.msg("new password field is empty!");
    } else if (!currentPasswordValue) {
      util.shake(confirmNewPassword);
      util.msg("confirm password field is empty!");
    }
  } else if (
    currentPasswordValue.length < 8 ||
    newPasswordValue.length < 8 ||
    confirmNewPasswordValue.length < 8
  ) {
    if (currentPasswordValue.length < 8) {
      util.shake(currentPassword);
      util.msg("Current password field has a length less than  8");
    } else if (newPasswordValue.length < 8) {
      util.shake(newPassword);
      util.msg("New password field has a length less than  8");
    } else if (confirmNewPasswordValue.length < 8) {
      util.shake(confirmPassword);
      util.msg("Confirm password field has a length less than  8");
    }
  } else if (newPasswordValue !== confirmNewPasswordValue) {
    util.shake(confirmNewPassword);
    util.msg("Passwords do not match!");
  } else {
    postPasswords(currentPasswordValue, newPasswordValue, confirmNewPasswordValue);
  }
}

function postPasswords(currentPassword, newPassword, confirmNewPassword) {
  const passwords = {
    currentPassword: currentPassword,
    newPassword: newPassword,
    confirmNewPassword: confirmNewPassword
  };

  const url = "./includes/settings.inc.php";

  fetch(url, {
    method: "POST",
    headers: {
      "Content-type": "application/json",
    },
    body: JSON.stringify(passwords),
  })
    .then((res) => res.text())
    .then((res) =>  settingsErrorHandler(res));
}

function settingsErrorHandler(res){
  // console.log(msg);
  if(res == '1000'){
    console.log("request-type error");
  }
  else if(res == '1100'){
    console.log("content-type error");
  }
  else if(res == '900EF'){
    settingsShakeTargets();
  }
  else if(res == "990LN"){
    settingsShakeTargets();
  }
  else if(res == "2000RX"){
    settingsShakeTargets();;
  }
  else if(res == "3002"){
    newPassword.style.border = "2px solid red";
    confirmNewPassword.style.border = "2px solid red";
    newPassword.classList.add("shake");
    confirmNewPassword.classList.add("shake");
  }
  else if(res == '5000'){
    const settingsHeading = document.querySelector('.settings-heading');
    settingsHeading.textContent =  "Password successfully changed";
    // setTimeout(()=>{
    //   settingsHeading.textContent = "Change your password";
    // }, 3000);
  }else{
    console.log(res);
  }
}

function settingsShakeTargets(){
  currentPassword.style.border = "2px solid red";
  newPassword.style.border = "2px solid red";
  confirmNewPassword.style.border = "2px solid red";
  currentPassword.classList.add("shake");
  newPassword.classList.add("shake");
  confirmNewPassword.classList.add("shake");
}
