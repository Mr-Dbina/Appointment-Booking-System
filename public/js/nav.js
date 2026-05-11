document.addEventListener("DOMContentLoaded", () => {
  const nav = document.querySelector("nav");

  window.addEventListener("scroll", () => {
    if (window.scrollY > 80) {
      nav.classList.add("scrolled");
    } else {
      nav.classList.remove("scrolled");
    }
  });

  const searchBox = document.querySelector(".search-box");
  const searchInput = document.querySelector(".search-input");
  const searchClear = document.querySelector(".search-clear");
  const searchIcon = document.querySelector(".search-icon");

  searchIcon.addEventListener("click", (e) => {
    e.stopPropagation();
    if (searchBox.classList.contains("open")) {
      searchBox.classList.remove("open");
      searchInput.value = "";
      searchClear.classList.remove("visible");
    } else {
      searchBox.classList.add("open");
      searchInput.focus();
    }
  });

  searchInput.addEventListener("input", () => {
    searchClear.classList.toggle("visible", searchInput.value.length > 0);
  });

  searchClear.addEventListener("click", () => {
    searchInput.value = "";
    searchClear.classList.remove("visible");
    searchBox.classList.remove("open");
  });

  document.addEventListener("click", (e) => {
    if (!searchBox.contains(e.target)) {
      searchBox.classList.remove("open");
      searchClear.classList.remove("visible");
    }
  });

  const userToggle = document.querySelector(".user-menu-toggle");
  const userDropdown = document.querySelector(".user-dropdown");
  const bellToggle = document.querySelector(".bell-menu-toggle");
  const bellDropdown = document.querySelector(".bell-dropdown");

  userToggle.addEventListener("click", (e) => {
    e.stopPropagation();
    const opening = !userDropdown.classList.contains("open");
    userDropdown.classList.toggle("open");
    if (opening) bellDropdown.classList.remove("open"); // close bell
  });

  bellToggle.addEventListener("click", (e) => {
    e.stopPropagation();
    const opening = !bellDropdown.classList.contains("open");
    bellDropdown.classList.toggle("open");
    if (opening) userDropdown.classList.remove("open"); // close profile
  });

  // outside click — check the dropdown itself, not the toggle
  // because dropdowns are nested inside the toggle div
  document.addEventListener("click", (e) => {
    if (!userToggle.contains(e.target)) userDropdown.classList.remove("open");
    if (!bellToggle.contains(e.target)) bellDropdown.classList.remove("open");
  });
});
