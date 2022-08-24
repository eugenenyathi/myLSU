/*
=====================
Variable Declaration
=====================
*/
// Getting the input tags
const studentNumber = document.querySelector("#studentnumber");
// const studentValue = studentNumber.value
const password = document.querySelector("#password");
const passwordValue = password.value;
// const submitBtn = document.querySelector(".btn");
const form = document.querySelector("form");

/*
        ============================
        End of Variable Declaration
        ============================
        */
/*
    ============================
    Code to do with input tags
    ============================
    */

//Configuring uppercase letters for the student number
// And changing the red to the focus blue
studentNumber.addEventListener("input", (ev) => {
  ev.target.classList.remove("shake");
  ev.target.value = ev.target.value.toUpperCase();
  ev.target.style.border = "2px solid #5887ef";
});
// Changing the red to focus blue for the password
password.addEventListener("input", (ev) => {
  ev.target.classList.remove("shake");
  password.style.border = "2px solid #5887ef";
});

// Configuring the password view element
//Getting the eye icons on the password tag
const eyes = document.querySelectorAll(".eye-icon");

eyes.forEach((eye) => {
  eye.addEventListener("click", (ev) => {
    if (password.type == "password") {
      password.setAttribute("type", "text");
      eyes[0].style.display = "none";
      eyes[1].style.display = "block";
    } else if (password.type == "text") {
      password.setAttribute("type", "password");
      eyes[0].style.display = "block";
      eyes[1].style.display = "none";
    }
  });
});

// Configuring incorrect student number on click of the Submit btn
form.addEventListener("submit", (ev) => {
  ev.preventDefault();

  const studentNumberValue = studentNumber.value;
  const passwordValue = password.value;

  const stNoRegex = /^L0\d{6}[A-Z]$/;

  //Checking the validity of the student number
  if (!studentNumberValue || studentNumberValue.length < 8) {
    studentNumber.style.border = "2px solid red";
    studentNumber.classList.add("shake");
    console.log("student-number");
  }
  // else if (!stNoRegex.test(studentNumberValue)){
  //   studentNumber.style.border = "2px solid red";
  //   studentNumber.classList.add("shake")
  // }
  else if (!passwordValue || passwordValue.length < 8) {
    password.style.border = "2px solid red";
    password.classList.add("shake");
    console.log("password");
  } else {
    //Sending data for database confirmation
    const loginDetails = {
      studentId: studentNumberValue,
      password: passwordValue,
    };

    const url = "./includes/login.inc.php";
    // const errorMsg = document.querySelector('.error-msg');

    fetch(url, {
      method: "POST",
      headers: { "Content-type": "application/json" },
      body: JSON.stringify(loginDetails),
    })
      .then((res) => res.text())
      .then((res) => errorHandler(res));
  }
});

function errorHandler(res) {
  if (res == "800EF") {
    shakeTargets();
    console.log(res);
  } else if (res == "990") {
    studentNumber.style.border = "2px solid red";
    studentNumber.classList.add("shake");
    console.log(res);
  } else if (res == "992") {
    password.style.border = "2px solid red";
    password.classList.add("shake");
    console.log(res);
  } else if (res == "2000") {
    studentNumber.style.border = "2px solid red";
    studentNumber.classList.add("shake");
    console.log(res);
  } else if (res == "2002") {
    password.style.border = "2px solid red";
    password.classList.add("shake");
    console.log(res);
  } else if (res == "3000") {
    studentNumber.style.border = "2px solid red";
    studentNumber.classList.add("shake");
    console.log(res);
  } else if (res == "3001") {
    password.style.border = "2px solid red";
    password.classList.add("shake");
    console.log(res);
  } else if (res == "3002") {
    password.style.border = "2px solid red";
    password.classList.add("shake");
    console.log(res);
  } else if (res == "4000") {
    studentNumber.style.border = "2px solid red";
    studentNumber.classList.add("shake");
    console.log(res);
  } else if (res == "5000") {
    window.location.href = "./home.php";
    console.log(res);
  } else if (res == "5001") {
    console.log(res);
  } else if (res == "10000") {
    console.log("Db-error");
  } else {
    console.log(res);
  }
}

function shakeTargets() {
  studentNumber.style.border = "2px solid red";
  studentNumber.classList.add("shake");
  password.style.border = "2px solid red";
  password.classList.add("shake");
}
/*
====================================
End of Code to do with input tags
====================================

*/
