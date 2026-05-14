const hamburger = document.getElementById("hamburger");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");

function openSidebar() {
  sidebar.classList.add("open");
  overlay.classList.add("open");
}
function closeSidebar() {
  sidebar.classList.remove("open");
  overlay.classList.remove("open");
}

if (hamburger) hamburger.addEventListener("click", openSidebar);
if (overlay) overlay.addEventListener("click", closeSidebar);

document.querySelectorAll(".nav-item").forEach((item) => {
  item.addEventListener("click", () => {
    if (window.innerWidth <= 768) closeSidebar();
  });
});

document.querySelectorAll(".search-input").forEach((input) => {
  input.addEventListener("input", function () {
    const tableId = this.dataset.table;
    const q = this.value.toLowerCase();
    document.querySelectorAll(`#${tableId} tbody tr`).forEach((row) => {
      row.style.display = row.textContent.toLowerCase().includes(q)
        ? ""
        : "none";
    });
  });
});
