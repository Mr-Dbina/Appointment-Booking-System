if (typeof BASE_URL === "undefined") {
  var BASE_URL = window.location.origin;
}

const SEARCH_PAGES = [
  {
    name: "Home",
    url: BASE_URL + "/users/main.php",
    icon: "fa-house",
    keywords: ["home", "main", "dashboard", "welcome", "happy care", "clinic"],
  },
  {
    name: "Services",
    url: BASE_URL + "/users/service.php",
    icon: "fa-briefcase-medical",
    keywords: ["services", "service", "medical", "treatments", "all services"],
  },
  {
    name: "Dermatology",
    url: BASE_URL + "/users/derma_service.php",
    icon: "fa-hand-dots",
    keywords: [
      "dermatology",
      "derma",
      "skin",
      "acne",
      "rash",
      "facial",
      "eczema",
      "wart",
      "hair loss",
      "mole",
      "psoriasis",
      "chemical peel",
      "allergy",
    ],
  },
  {
    name: "General Medicine",
    url: BASE_URL + "/users/gen_service.php",
    icon: "fa-stethoscope",
    keywords: [
      "general",
      "medicine",
      "check-up",
      "checkup",
      "fever",
      "flu",
      "blood pressure",
      "diabetes",
      "medical certificate",
      "follow-up",
      "vaccination",
      "immunization",
    ],
  },
  {
    name: "OB-GYN",
    url: BASE_URL + "/users/ob_service.php",
    icon: "fa-heart",
    keywords: [
      "ob",
      "gyn",
      "obgyn",
      "ob-gyn",
      "prenatal",
      "ultrasound",
      "family planning",
      "menstrual",
      "pregnancy",
      "pap smear",
      "cervical",
      "maternity",
    ],
  },
  {
    name: "Pediatrics",
    url: BASE_URL + "/users/pedia_service.php",
    icon: "fa-child",
    keywords: [
      "pediatrics",
      "pedia",
      "child",
      "baby",
      "newborn",
      "kids",
      "growth",
      "nutrition",
      "vaccination",
      "cough",
      "infant",
    ],
  },
  {
    name: "About Us",
    url: BASE_URL + "/users/aboutus.php",
    icon: "fa-circle-info",
    keywords: [
      "about",
      "about us",
      "story",
      "clinic",
      "history",
      "mission",
      "vision",
      "doctors",
      "team",
    ],
  },
  {
    name: "Appointment",
    url: BASE_URL + "/users/appointment.php",
    icon: "fa-calendar-check",
    keywords: [
      "appointment",
      "book",
      "booking",
      "schedule",
      "reserve",
      "slot",
      "date",
      "time",
    ],
  },
  {
    name: "Profile",
    url: BASE_URL + "/users/profile.php",
    icon: "fa-user",
    keywords: [
      "profile",
      "account",
      "personal",
      "password",
      "settings",
      "my account",
      "edit profile",
    ],
  },
  {
    name: "Help",
    url: BASE_URL + "/users/help.php",
    icon: "fa-circle-question",
    keywords: [
      "help",
      "support",
      "faq",
      "question",
      "guide",
      "how to",
      "contact",
    ],
  },
];

document.addEventListener("DOMContentLoaded", () => {
  const nav = document.querySelector("nav");
  window.addEventListener("scroll", () => {
    nav.classList.toggle("scrolled", window.scrollY > 80);
  });

  const searchBox = document.querySelector(".search-box");
  const searchInput = document.querySelector(".search-input");
  const searchClear = document.querySelector(".search-clear");
  const searchIcon = document.querySelector(".search-icon");

  let searchDropdown = document.createElement("div");
  searchDropdown.className = "search-dropdown";
  searchBox.appendChild(searchDropdown);

  function getMatches(query) {
    const q = query.toLowerCase().trim();
    if (!q) return [];
    return SEARCH_PAGES.filter(
      (page) =>
        page.name.toLowerCase().includes(q) ||
        page.keywords.some((k) => k.includes(q) || q.includes(k)),
    );
  }

  function renderDropdown(query) {
    const matches = getMatches(query);
    searchDropdown.innerHTML = "";

    if (!query.trim()) {
      searchDropdown.classList.remove("open");
      return;
    }

    if (matches.length === 0) {
      searchDropdown.innerHTML = `
        <div class="search-no-result">
          <i class="fa-solid fa-circle-exclamation"></i>
          <span>No results found for "<strong>${query}</strong>"</span>
        </div>`;
    } else {
      matches.forEach((page) => {
        const item = document.createElement("div");
        item.className = "search-result-item";
        item.innerHTML = `<span>${page.name}</span>`;
        item.addEventListener("click", () => {
          window.location.href = page.url;
        });
        searchDropdown.appendChild(item);
      });
    }

    searchDropdown.classList.add("open");
  }

  searchInput.addEventListener("input", () => {
    const val = searchInput.value;
    searchClear.classList.toggle("visible", val.length > 0);
    renderDropdown(val);
  });

  searchInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      const matches = getMatches(searchInput.value);
      if (matches.length > 0) {
        window.location.href = matches[0].url;
      }
    }
  });

  searchIcon.addEventListener("click", (e) => {
    e.stopPropagation();
    if (searchBox.classList.contains("open")) {
      searchBox.classList.remove("open");
      searchDropdown.classList.remove("open");
    } else {
      searchBox.classList.add("open");
      searchInput.focus();
      if (searchInput.value.trim()) {
        renderDropdown(searchInput.value);
      }
    }
  });

  searchClear.addEventListener("click", () => {
    searchInput.value = "";
    searchClear.classList.remove("visible");
    searchDropdown.classList.remove("open");
    searchDropdown.innerHTML = "";
  });

  document.addEventListener("click", (e) => {
    if (!searchBox.contains(e.target)) {
      searchBox.classList.remove("open");
      searchDropdown.classList.remove("open");
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

    badge.style.display = "block";
    bellCount.textContent = notifications.length;

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
      const SUPA_URL =
        window.SUPABASE_URL || "https://alvgmydqyffyegcbtsyg.supabase.co";
      const SUPA_KEY =
        window.SUPABASE_ANON_KEY ||
        "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImFsdmdteWRxeWZmeWVnY2J0c3lnIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzgwNzA0MTcsImV4cCI6MjA5MzY0NjQxN30.7YGzh5EX569NXZhGvrZWh48RUNBYrSagINZQhCePX8k";

      if (typeof supabase === "undefined") {
        renderNotifications([]);
        return;
      }

      const _db = supabase.createClient(SUPA_URL, SUPA_KEY);
      const {
        data: { session },
      } = await _db.auth.getSession();
      const token = session?.access_token || "";

      if (!token) {
        renderNotifications([]);
        return;
      }

      const res = await fetch(
        `${BASE_URL}/api/get_notification.php?token=${encodeURIComponent(token)}`,
      );
      const data = await res.json();
      renderNotifications(data.notifications);
    } catch (err) {
      console.error("Notification fetch error:", err);
    }
  }

  fetchNotifications();
  setInterval(fetchNotifications, 2 * 60 * 1000);
});
