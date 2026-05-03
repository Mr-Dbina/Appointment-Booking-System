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
    if (searchInput.value.length > 0) {
      searchClear.classList.add("visible");
    } else {
      searchClear.classList.remove("visible");
    }
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
});

document.addEventListener("DOMContentLoaded", () => {
  window.addEventListener("scroll", () => {
    const nav = document.querySelector("nav");
    if (window.scrollY > 80) {
      nav.classList.add("scrolled");
    } else {
      nav.classList.remove("scrolled");
    }
  });
});
const userToggle = document.querySelector(".user-menu-toggle");
const userDropdown = document.querySelector(".user-dropdown");

userToggle.addEventListener("click", (e) => {
  e.stopPropagation();
  userDropdown.classList.toggle("open");
});

document.addEventListener("click", (e) => {
  if (!userToggle.contains(e.target)) {
    userDropdown.classList.remove("open");
  }
});
const bellToggle = document.querySelector(".bell-menu-toggle");
const bellDropdown = document.querySelector(".bell-dropdown");

bellToggle.addEventListener("click", (e) => {
  e.stopPropagation();
  bellDropdown.classList.toggle("open");
});

document.addEventListener("click", (e) => {
  if (!bellToggle.contains(e.target)) {
    bellDropdown.classList.remove("open");
  }
});
