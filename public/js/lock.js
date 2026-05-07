const togglePwd = document.getElementById("togglePwd");
const pwdInput = document.getElementById("password");

if (togglePwd) {
  togglePwd.addEventListener("click", () => {
    const isHidden = pwdInput.type === "password";
    pwdInput.type = isHidden ? "text" : "password";
    togglePwd.innerHTML = isHidden
      ? '<i class="fa-solid fa-lock-open"></i>'
      : '<i class="fa-solid fa-lock"></i>';
  });
}

const dobInput = document.getElementById("dob");
if (dobInput) {
  dobInput.addEventListener("focus", () => {
    if (!dobInput.value) dobInput.type = "date";
  });
}
