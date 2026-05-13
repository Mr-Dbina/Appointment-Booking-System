const tabLinks = document.querySelectorAll(".tab-link");
const tabPanes = document.querySelectorAll(".tab-pane");

function switchTab(id) {
  tabLinks.forEach((t) => t.classList.remove("active"));
  tabPanes.forEach((p) => p.classList.remove("active"));
  document.getElementById(id).classList.add("active");
  document.querySelector(`[data-tab="${id}"]`)?.classList.add("active");
}

tabLinks.forEach((tab) => {
  tab.addEventListener("click", () => switchTab(tab.getAttribute("data-tab")));
});

// Password toggle
document.querySelectorAll(".toggle-eye").forEach((eye) => {
  eye.addEventListener("click", () => {
    const input = document.getElementById(eye.dataset.target);
    const isText = input.type === "text";
    input.type = isText ? "password" : "text";
    eye.classList.toggle("fa-eye", isText);
    eye.classList.toggle("fa-eye-slash", !isText);
  });
});

// Toast
function showToast(msg) {
  const toast = document.getElementById("toast");
  document.getElementById("toast-msg").textContent = msg;
  toast.classList.add("show");
  setTimeout(() => toast.classList.remove("show"), 3000);
}
