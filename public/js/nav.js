const BASE_URL = document.currentScript ? document.currentScript.src.substring(0, document.currentScript.src.indexOf('/public/')) : window.location.origin;
document.addEventListener("DOMContentLoaded", () => {
  // ── Scroll behaviour ──────────────────────────────────────────────
  const nav = document.querySelector("nav");
  window.addEventListener("scroll", () => {
    nav.classList.toggle("scrolled", window.scrollY > 80);
  });

  // ── Search ────────────────────────────────────────────────────────
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

  // ── Dropdowns ─────────────────────────────────────────────────────
  const userToggle = document.querySelector(".user-menu-toggle");
  const userDropdown = document.querySelector(".user-dropdown");
  const bellToggle = document.querySelector(".bell-menu-toggle");
  const bellDropdown = document.querySelector(".bell-dropdown");

  userToggle.addEventListener("click", (e) => {
    e.stopPropagation();
    const opening = !userDropdown.classList.contains("open");
    userDropdown.classList.toggle("open");
    if (opening) bellDropdown.classList.remove("open");
  });

  bellToggle.addEventListener("click", (e) => {
    e.stopPropagation();
    const opening = !bellDropdown.classList.contains("open");
    bellDropdown.classList.toggle("open");
    if (opening) userDropdown.classList.remove("open");
  });

  document.addEventListener("click", (e) => {
    if (!userToggle.contains(e.target)) userDropdown.classList.remove("open");
    if (!bellToggle.contains(e.target)) bellDropdown.classList.remove("open");
  });

  // ── Notifications ─────────────────────────────────────────────────
  const bellBody = document.getElementById("bell-body");
  const bellCount = document.getElementById("bell-count");
  const badge = document.getElementById("notif-badge");

  function getStatusClass(status) {
    switch (status.toLowerCase()) {
      case "confirmed":
        return "notif-status--confirmed";
      case "pending":
        return "notif-status--pending";
      case "cancelled":
        return "notif-status--cancelled";
      default:
        return "";
    }
  }

  function getStatusIcon(status) {
    switch (status.toLowerCase()) {
      case "confirmed":
        return "fa-circle-check";
      case "pending":
        return "fa-clock";
      case "cancelled":
        return "fa-circle-xmark";
      default:
        return "fa-calendar";
    }
  }

  function renderNotifications(notifications) {
    if (!notifications || notifications.length === 0) {
      bellBody.innerHTML = `
        <div class="bell-empty">
          <i class="fa-solid fa-bell-slash"></i>
          <p>No notifications</p>
        </div>`;
      badge.style.display = "none";
      bellCount.textContent = "";
      return;
    }

    // Show badge
    badge.style.display = "block";
    bellCount.textContent = notifications.length;

    // Render cards
    bellBody.innerHTML = notifications
      .map(
        (n) => `
      <div class="notif-card">
        <div class="notif-icon-wrap">
          <i class="fa-solid ${getStatusIcon(n.status)}"></i>
        </div>
        <div class="notif-content">
          <p class="notif-message">${n.message}</p>
          <div class="notif-meta">
            <span class="notif-appt-no">#${n.appointment_no}</span>
            <span class="notif-status ${getStatusClass(n.status)}">${n.status_label}</span>
          </div>
        </div>
      </div>
    `,
      )
      .join("");
  }

  async function fetchNotifications() {
    try {
      const res = await fetch(
        `${BASE_URL}/api/get_notification.php`,
      );
      const data = await res.json();
      renderNotifications(data.notifications);
    } catch (err) {
      console.error("Notification fetch error:", err);
    }
  }

  // Initial load + refresh every 2 minutes
  fetchNotifications();
  setInterval(fetchNotifications, 2 * 60 * 1000);
});
