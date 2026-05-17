document.addEventListener("DOMContentLoaded", () => {
  const togglePwd = document.getElementById("togglePwd");
  const eyeIcon = document.getElementById("eyeIcon");
  const pwdInput = document.getElementById("password");

  if (togglePwd && eyeIcon && pwdInput) {
    togglePwd.addEventListener("click", () => {
      const isHidden = pwdInput.type === "password";
      pwdInput.type = isHidden ? "text" : "password";
      eyeIcon.className = isHidden
        ? "fa-solid fa-eye-slash"
        : "fa-solid fa-eye";
    });
  }
});

const dobInput = document.getElementById("dob");
if (dobInput) {
  dobInput.addEventListener("focus", () => {
    if (!dobInput.value) dobInput.type = "date";
  });
}
