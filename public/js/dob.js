// dob.js — Custom Date of Birth calendar picker

(function () {
  const today = new Date();
  let dobYear = today.getFullYear() - 25; // sensible default start
  let dobMonth = today.getMonth();
  let dobSelected = null; // Date object
  let ymMode = false; // year/month picker mode
  let ymType = "month"; // 'month' or 'year'

  // ── Open / Close ──────────────────────────────────────────
  window.toggleDobCal = function (e) {
    e.stopPropagation();
    const cal = document.getElementById("dobCal");
    const trigger = document.getElementById("dobTrigger");
    const isOpen = cal.classList.contains("active");
    if (isOpen) {
      closeDobCal();
    } else {
      cal.classList.add("active");
      trigger.classList.add("open");
      renderDobGrid();
      // click outside to close
      setTimeout(() => document.addEventListener("click", outsideClose), 0);
    }
  };

  function outsideClose(e) {
    const cal = document.getElementById("dobCal");
    const field = document.getElementById("dobField");
    if (!field.contains(e.target)) {
      closeDobCal();
    }
  }

  function closeDobCal() {
    document.getElementById("dobCal").classList.remove("active");
    document.getElementById("dobTrigger").classList.remove("open");
    document.removeEventListener("click", outsideClose);
  }

  // ── Navigation ────────────────────────────────────────────
  window.dobChangeMonth = function (dir) {
    if (ymMode) return;
    dobMonth += dir;
    if (dobMonth > 11) {
      dobMonth = 0;
      dobYear++;
    }
    if (dobMonth < 0) {
      dobMonth = 11;
      dobYear--;
    }
    renderDobGrid();
  };

  // ── Month label click → toggle year/month picker ──────────
  window.toggleYMPicker = function () {
    ymMode = !ymMode;
    ymType = "year";
    document.getElementById("dobDayMode").style.display = ymMode
      ? "none"
      : "block";
    document.getElementById("dobYMMode").style.display = ymMode
      ? "block"
      : "none";
    if (ymMode) renderYMGrid();
    updateMonthLabel();
  };

  // ── Render year grid ──────────────────────────────────────
  function renderYMGrid() {
    const grid = document.getElementById("dobYMGrid");
    grid.innerHTML = "";
    const startYear = dobYear - 60;
    const endYear = today.getFullYear();
    for (let y = endYear; y >= startYear; y--) {
      const btn = document.createElement("button");
      btn.type = "button";
      btn.className = "dob-ym-item" + (y === dobYear ? " selected" : "");
      btn.textContent = y;
      btn.onclick = function () {
        dobYear = y;
        ymType = "month";
        renderMonthGrid();
      };
      grid.appendChild(btn);
    }
  }

  function renderMonthGrid() {
    const months = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ];
    const grid = document.getElementById("dobYMGrid");
    grid.innerHTML = "";
    months.forEach((m, i) => {
      const btn = document.createElement("button");
      btn.type = "button";
      btn.className = "dob-ym-item" + (i === dobMonth ? " selected" : "");
      btn.textContent = m;
      btn.onclick = function () {
        dobMonth = i;
        ymMode = false;
        document.getElementById("dobDayMode").style.display = "block";
        document.getElementById("dobYMMode").style.display = "none";
        renderDobGrid();
      };
      grid.appendChild(btn);
    });
  }

  // ── Render day grid ───────────────────────────────────────
  function renderDobGrid() {
    updateMonthLabel();
    const grid = document.getElementById("dobGrid");
    grid.innerHTML = "";

    const firstDay = new Date(dobYear, dobMonth, 1).getDay();
    const daysInMonth = new Date(dobYear, dobMonth + 1, 0).getDate();

    // Empty cells
    for (let i = 0; i < firstDay; i++) {
      const empty = document.createElement("button");
      empty.type = "button";
      empty.className = "dob-day empty";
      grid.appendChild(empty);
    }

    for (let d = 1; d <= daysInMonth; d++) {
      const btn = document.createElement("button");
      btn.type = "button";
      const thisDate = new Date(dobYear, dobMonth, d);

      // Future dates disabled for DOB
      const isFuture = thisDate > today;
      const isToday = sameDay(thisDate, today);
      const isSel = dobSelected && sameDay(thisDate, dobSelected);

      btn.className =
        "dob-day" +
        (isFuture ? " disabled" : "") +
        (isToday ? " today" : "") +
        (isSel ? " selected" : "");
      btn.textContent = d;

      if (!isFuture) {
        btn.onclick = function () {
          selectDob(thisDate);
        };
      }
      grid.appendChild(btn);
    }
  }

  function updateMonthLabel() {
    const months = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    document.getElementById("dobMonthLabel").textContent =
      months[dobMonth] + " " + dobYear;
  }

  // ── Select a date ─────────────────────────────────────────
  function selectDob(date) {
    dobSelected = date;
    dobYear = date.getFullYear();
    dobMonth = date.getMonth();

    // Update hidden input (YYYY-MM-DD for Supabase)
    const iso = formatISO(date);
    document.getElementById("dob").value = iso;

    // Update trigger display
    const trigger = document.getElementById("dobTrigger");
    trigger.textContent = formatDisplay(date);
    trigger.classList.remove("placeholder");

    renderDobGrid();
    setTimeout(closeDobCal, 150);
  }

  window.dobClear = function () {
    dobSelected = null;
    document.getElementById("dob").value = "";
    const trigger = document.getElementById("dobTrigger");
    trigger.textContent = "Date of Birth";
    trigger.classList.add("placeholder");
    renderDobGrid();
  };

  window.dobSelectToday = function () {
    selectDob(new Date());
  };

  // ── Helpers ───────────────────────────────────────────────
  function sameDay(a, b) {
    return (
      a.getFullYear() === b.getFullYear() &&
      a.getMonth() === b.getMonth() &&
      a.getDate() === b.getDate()
    );
  }

  function formatISO(date) {
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, "0");
    const d = String(date.getDate()).padStart(2, "0");
    return `${y}-${m}-${d}`;
  }

  function formatDisplay(date) {
    const months = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ];
    return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
  }

  // Initial render
  renderDobGrid();
})();
