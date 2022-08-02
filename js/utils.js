function removeRedErrorBorder(target, color){
  target.addEventListener("input", (ev) => {
    ev.target.classList.remove("shake");
    ev.target.value = ev.target.value.toUpperCase();
    ev.target.style.border = `2px solid ${color}`;
  });
}


function removeRedErrorBorder2(target, color){
  target.addEventListener("input", (ev) => {
    ev.target.classList.remove("shake");
    target.style.border = `2px solid ${color}`;
  });
}


function shake(target) {
  target.style.border = "2px solid red";
  target.classList.add("shake");
}

function shakeTwo(targets){
  targets.forEach((target) => {
    target.style.border = "2px solid red";
    target.classList.add("shake");
  });
  
}

function msg(text, error) {
  error.style.display = "block";
  error.textContent = text;
  error.style.color = "red";
}

function togglePasswordView(eyes) {
  eyes.forEach((eye) => {
    eye.addEventListener("click", (ev) => {
      ev.preventDefault();
      const eyeCurrentTarget = ev.currentTarget;
      let oppositeEye = ev.currentTarget.previousElementSibling;
      const eyePasswordInput = eyeCurrentTarget.parentElement.childNodes[3];

      if (eyePasswordInput.type == "password") {
        eyePasswordInput.setAttribute("type", "text");
        eyeCurrentTarget.style.display = "none";
        oppositeEye.style.display = "block";
      } else if (eyePasswordInput.type == "text") {
        oppositeEye = ev.currentTarget.nextElementSibling;
        eyePasswordInput.setAttribute("type", "password");
        eyeCurrentTarget.style.display = "none";
        oppositeEye.style.display = "block";
      }
    });
  });
}

export { shake, shakeTwo, msg, togglePasswordView };
