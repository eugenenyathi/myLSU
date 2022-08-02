import View from './views/view.js';
import * as util from './utils.js';

  class UserInput {
    constructor(nationalId, newPassword, confirmNewPassword) {
      //the input fields
      this.nationalId = nationalId;
      this.newPassword = newPassword;
      this.confirmNewPassword = confirmNewPassword;
    }
    empty(target) {
      if (!target.value) {
        shake(target);
        msg(target + " field is empty!");
      }
    }

    emptyThree() {
      if (
        !this.nationalId.value ||
        !this.newPassword.value ||
        !this.confirmNewPassword.value
      ) {
        if (!this.nationalId.value) {
          this.shake(this.nationalId);
          this.msg("National ID field is empty!", ctrError);
        } else if (!this.newPassword.value || !this.confirmNewPassword.value) {
          this.shakeTwo(this.newPassword, this.confirmNewPassword);
          this.msg("Password fields are empty!", ctrError);
        }
      } else {
        if (this.nationalId.value) {
          this.nationalIdLength();
        }
      }
    }

    nationalIdLength() {
      if (this.nationalId.value.length < 12) {
        this.shake(this.nationalId);
        this.msg("National ID field has a length less than  12", ctrError);
      } else if (!/\d{2}-\d{6}[A-Z]\d{2}/.test(this.nationalId.value)) {
        this.shake(this.nationalId);
        this.msg("Invalid National ID", ctrError);
      } else {
        //now continue with the code and
        //check the length of the two password fields
        this.lengthTwo();
      }
    }

    studentIdLength(target) {
      if (target.value.length < 8) {
        this.shake(target);
        this.msg("Student ID field has a length less than  12", ctrError);
      }
    }

    lengthTwo() {
      if (
        this.newPassword.value.length < 8 ||
        this.confirmNewPassword.value.length < 8
      ) {
        this.shakeTwo(this.newPassword, this.confirmNewPassword);
        this.msg("Password fields have a length less than 8 ", ctrError);
      } else {
        this.match();
      }
    }

    match() {
      if (this.newPassword.value !== this.confirmNewPassword.value) {
        this.shakeTwo(this.newPassword, this.confirmNewPassword);
        this.msg("Passwords do not match!", ctrError);
      } else {
        this.postPassword("./includes/ctr-change-password.inc.php");
      }
    }

    shake(target) {
      target.style.border = "2px solid red";
      target.classList.add("shake");
    }

    shakeTwo(target, target2) {
      [target, target2].forEach((input) => {
        input.style.borderColor = "red";
        input.classList.add("shake");
      });
    }

    msg(text, target, color="red") {
      target.textContent = text;
      target.style.color = color;
    }
    
    postPassword(url) {
      const passwords = {
        nationalId: this.nationalId.value,
        newPassword: this.newPassword.value,
        confirmNewPassword: this.confirmNewPassword.value,
      };

      fetch(url, {
        method: "POST",
        headers: { "Content-type": "application/json" },
        body: JSON.stringify(passwords),
      })
        .then((res) => res.json())
        .then((res) => this.errorHandler(res));
        // .then((res) => res.text())
        // .then((res) => console.log(res));
    }

    errorHandler(res){
      const code = res.code;
      
      switch(code){
        case '1000':
          console.log('Request-Method error');
          break;
        case '1100':
          console.log('Content-type error');
          break;
        case '1100':
          console.log("Formatting error");
          break;
        case '801':
          this.msg("National ID field is empty!", ctrError);
          this.shake(this.nationalId);
          break;
        case '802':
          this.msg("Password fields are empty!", ctrError);
          this.shakeTwo(this.newPassword, this.confirmNewPassword);
          break;
        case '991':
          this.msg("National ID is invalid!", ctrError);
          this.shake(this.nationalId);
          break;
          
        case '993':
          this.msg("Password fields are empty!", ctrError);
          this.shakeTwo(this.newPassword, this.confirmNewPassword);
          break;
                      
        case '2001':
          this.msg("National ID is invalid!", ctrError);
          this.shake(this.nationalId);
          break;
        case '3001':
          this.msg("National ID is incorrect!", ctrError);
          this.shake(this.nationalId);
          break;
        case '3002':
          this.msg("Password fields do not match!", ctrError);
          this.shakeTwo(this.newPassword, this.confirmNewPassword);
          break;
        case '5000':
          this.msg("Password successfully changed.", ctrPasswordNotif, "#000");
          
          const ctrPasswordContainer = document.querySelector(".ctr-password-container");
          ctrPasswordContainer.style.display = "none";
          
          setTimeout(()=>{
            //make changes to the dom.
            this.loadView(res);
          }, 2000);

          break;
       case '5001':
          this.msg("Failed to change password", ctrError);
          console.log("Failed to change password");
          break;
        default:
          console.log(code);
          break;

      }
    }
    
    loadView(res){
      const viewType = res.viewType;
      const studentFirstName = res.studentFirstName;
      const requestRoomMateName = res.requestRoomMateName;
      const tuitionPaid = res.tuitionPaid;
      const tuitionOwing = res.tuitionOwing;
      const studentsPerRoom = res.studentsPerRoom;
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
      
      const view = new View();
      view.flushDom();
      
      switch(viewType){
        case "defaultView":
          let generalReminder = `Use the search bar below to add ${studentsPerRoom} of your preferred room mates. `;
          view.reminderView([ reminder, generalReminder ]);
          view.defaultView();
          break;
        case "selectedMateView":
          view.reminderView([reminder]);
          view.selectedMateView(studentsInfo, requestRoomMateName);
          break;
        default:
          console.log("view-error.");
          //window.location.reload(true);
      }
    }
    
  }

  //toggle eyes
  const ctrEyes = document.querySelectorAll('.ctr-eye-icon');
  //function for toggling eyes
  util.togglePasswordView(ctrEyes);

  //change password
  const ctrNationalId = document.querySelector("#ctr-nationalId");
  const ctrNewPassword = document.querySelector("#ctr-new-password");
  const ctrConfirmNewPassword = document.querySelector("#ctr-confirm-password");
  const ctrPasswordForm = document.querySelector(".ctr-password-content");
  const ctrPasswordNotif = document.querySelector("#ctr-password-notif-text");
  const ctrError = document.querySelector(".ctr-msg");

  const ctrNationalIdValue = ctrNationalId.value;
  const ctrNewPasswordValue = ctrNewPassword.value;
  const ctrConfirmNewPasswordValue = ctrConfirmNewPassword.value;
  
  const ctrPanel = new UserInput(
    ctrNationalId,
    ctrNewPassword,
    ctrConfirmNewPassword
  );

  ctrPasswordForm.addEventListener("submit", (ev) => {
    ev.preventDefault();
    ctrPanel.emptyThree();
  });

  [ctrNationalId, ctrNewPassword, ctrConfirmNewPassword].forEach((inputField) => {
    inputField.addEventListener("input", (ev) => {

      if(ev.currentTarget == ctrNationalId){
        ev.currentTarget.value = ev.currentTarget.value.toUpperCase();
      }
      ev.target.style.borderColor = "#5996ff";
      ctrError.style.color = "null";
      ctrError.textContent =
        " *Password should not have a length less than 8, it must have a mix of letters, numbers and symbols.";
    });
  });

  function removePasswordContainer(){
    const ctrPasswordContainer = document.querySelector(".ctr-password-container");
    ctrPasswordContainer.style.display = "none";

    //trigger a page refresh
    setTimeout(()=>{
      window.location.reload(true);
    },3000);

  }


