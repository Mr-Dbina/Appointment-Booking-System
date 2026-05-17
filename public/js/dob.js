(function () {
  const today = new Date();
  let dobYear = today.getFullYear() - 25;
  let dobMonth = today.getMonth();
  let dobSelected = null;
  let editMode = false;

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
      editMode = false;
      showCalendarMode();
      renderDobGrid();
      setTimeout(() => document.addEventListener("click", outsideClose), 0);
    }
  };

  function outsideClose(e) {
    const cal = document.getElementById("dobCal");
    const field = document.getElementById("dobField");
    if (!field.contains(e.target)) closeDobCal();
  }

  function closeDobCal() {
    document.getElementById("dobCal").classList.remove("active");
    document.getElementById("dobTrigger").classList.remove("open");
    document.removeEventListener("click", outsideClose);
  }

  window.dobChangeMonth = function (dir) {
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

  function showCalendarMode() {
    editMode = false;
    document.getElementById("dobCalendarMode").style.display = "block";
    document.getElementById("dobEditMode").style.display = "none";
    updateDateHeader();
  }

  function showEditMode() {
    editMode = true;
    document.getElementById("dobCalendarMode").style.display = "none";
    document.getElementById("dobEditMode").style.display = "block";

    const d = dobSelected || today;
    document.getElementById("dobEditMonth").value = String(
      d.getMonth() + 1,
    ).padStart(2, "0");
    document.getElementById("dobEditDay").value = String(d.getDate()).padStart(
      2,
      "0",
    );
    document.getElementById("dobEditYear").value = d.getFullYear();
    updateDateHeader();
  }

  window.toggleDobEditMode = function () {
    if (editMode) showCalendarMode();
    else showEditMode();
  };

  window.dobConfirmEdit = function () {
    const m = parseInt(document.getElementById("dobEditMonth").value) - 1;
    const d = parseInt(document.getElementById("dobEditDay").value);
    const y = parseInt(document.getElementById("dobEditYear").value);
    if (isNaN(m) || isNaN(d) || isNaN(y)) return;
    const date = new Date(y, m, d);
    if (date > today) return;
    selectDob(date);
    showCalendarMode();
  };

  window.dobCancelEdit = function () {
    showCalendarMode();
  };

  function updateDateHeader() {
    const headerEl = document.getElementById("dobHeaderDate");
    if (!headerEl) return;
    const d = dobSelected || null;
    if (d) {
      const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
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
      headerEl.textContent = `${days[d.getDay()]}, ${months[d.getMonth()]} ${d.getDate()}`;
    } else {
      headerEl.textContent = "Select date";
    }
  }

  function renderDobGrid() {
    updateMonthLabel();
    updateDateHeader();
    const grid = document.getElementById("dobGrid");
    grid.innerHTML = "";

    const firstDay = new Date(dobYear, dobMonth, 1).getDay();
    const daysInMonth = new Date(dobYear, dobMonth + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
      const empty = document.createElement("div");
      empty.className = "dob-day empty";
      grid.appendChild(empty);
    }

    for (let d = 1; d <= daysInMonth; d++) {
      const btn = document.createElement("button");
      btn.type = "button";
      const thisDate = new Date(dobYear, dobMonth, d);
      const isFuture = thisDate > today;
      const isToday = sameDay(thisDate, today);
      const isSel = dobSelected && sameDay(thisDate, dobSelected);

      btn.className =
        "dob-day" +
        (isFuture ? " disabled" : "") +
        (isToday ? " today" : "") +
        (isSel ? " selected" : "");
      btn.textContent = d;

      if (!isFuture) btn.onclick = () => selectDob(thisDate);
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
    const el = document.getElementById("dobMonthLabel");
    if (el) el.textContent = months[dobMonth] + " " + dobYear;
  }

  function selectDob(date) {
    dobSelected = date;
    dobYear = date.getFullYear();
    dobMonth = date.getMonth();

    document.getElementById("dob").value = formatISO(date);
    const trigger = document.getElementById("dobTrigger");
    trigger.textContent = formatDisplay(date);
    trigger.classList.remove("placeholder");

    renderDobGrid();
    updateDateHeader();
    setTimeout(closeDobCal, 150);
  }

  window.dobClear = function () {
    dobSelected = null;
    document.getElementById("dob").value = "";
    const trigger = document.getElementById("dobTrigger");
    trigger.textContent = "Date of Birth";
    trigger.classList.add("placeholder");
    renderDobGrid();
    updateDateHeader();
  };

  window.dobSelectToday = function () {
    selectDob(new Date());
  };

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

  renderDobGrid();
})();
