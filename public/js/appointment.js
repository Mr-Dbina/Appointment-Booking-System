const serviceDropdown = document.getElementById("serviceDropdown");
const apptInput = document.getElementById("apptInput");
const clearBtn = document.getElementById("clearBtn");
const wordRotator = document.getElementById("wordRotator");
const words = document.querySelectorAll("#wordRotator .word");

let currentWord = 0;
let rotatorInterval = null;

function startRotator() {
  if (rotatorInterval) return;
  rotatorInterval = setInterval(() => {
    words[currentWord].classList.remove("active");
    currentWord = (currentWord + 1) % words.length;
    words[currentWord].classList.add("active");
  }, 2000);
}

function stopRotator() {
  clearInterval(rotatorInterval);
  rotatorInterval = null;
}

function showRotator() {
  wordRotator.classList.remove("hidden");
  currentWord = 0;
  words.forEach((w, i) => w.classList.toggle("active", i === 0));
  stopRotator();
  startRotator();
}

function hideRotator() {
  wordRotator.classList.add("hidden");
  stopRotator();
}

startRotator();

function openDropdown() {
  serviceDropdown.classList.add("open");
}

function clearService(e) {
  e.stopPropagation();
  apptInput.value = "";
  clearBtn.style.display = "none";
  filterServices("");
  showRotator();
  apptInput.focus();
  openDropdown();
}

function selectService(e, name) {
  if (e) e.stopPropagation();
  apptInput.value = name;
  clearBtn.style.display = "inline";
  hideRotator();
  filterServices(name);
  serviceDropdown.classList.remove("open");
}

function filterServices(query) {
  const items = document.querySelectorAll("#dropdownList .dropdown-item");
  const groups = document.querySelectorAll("#dropdownList .dropdown-group");
  const noResult = document.getElementById("noResultItem");
  const q = query.toLowerCase().trim();

  clearBtn.style.display = query.length > 0 ? "inline" : "none";
  query.length > 0 ? hideRotator() : showRotator();

  let anyVisible = false;

  items.forEach((item) => {
    if (item.id === "noResultItem") return;
    const serviceName = item
      .querySelector(".dropdown-name")
      .textContent.toLowerCase();
    const groupName =
      item.querySelector(".dropdown-sub")?.textContent.toLowerCase() || "";
    const match =
      !q ||
      serviceName.startsWith(q) ||
      serviceName.includes(q) ||
      groupName.includes(q);
    item.style.display = match ? "flex" : "none";
    if (match) anyVisible = true;
  });

  groups.forEach((group) => {
    let next = group.nextElementSibling;
    let hasVisible = false;
    while (next && !next.classList.contains("dropdown-group")) {
      if (next.id !== "noResultItem" && next.style.display !== "none")
        hasVisible = true;
      next = next.nextElementSibling;
    }
    group.style.display = hasVisible ? "block" : "none";
  });

  noResult.style.display = !anyVisible && q ? "flex" : "none";
}

document.addEventListener("click", (e) => {
  if (!document.getElementById("service-field").contains(e.target)) {
    serviceDropdown.classList.remove("open");
  }
});

// ============================================================
// DATE & TIME PANEL
// ============================================================

const TIME_SLOTS = [
  "9:00 AM – 9:30 AM",
  "9:30 AM – 10:00 AM",
  "10:00 AM – 10:30 AM",
  "10:30 AM – 11:00 AM",
  "11:00 AM – 11:30 AM",
  "1:00 PM – 1:30 PM",
  "1:30 PM – 2:00 PM",
  "2:00 PM – 2:30 PM",
  "3:00 PM – 3:30 PM",
];

const LIMITED_THRESHOLD = 3;

let dtpYear, dtpMonth;
let selectedDate = null;
let selectedSlot = null;

const todayDate = new Date();
todayDate.setHours(0, 0, 0, 0);

function isWeekend(y, m, d) {
  return [0, 6].includes(new Date(y, m - 1, d).getDay());
}

function getSlotStatus(dateStr, idx) {
  const [y, m, d] = dateStr.split("-").map(Number);
  if (isWeekend(y, m, d)) return "na";
  const seed = (y * 500 + m * 50 + d * 10 + idx * 3) % 7;
  return seed < 2 ? "booked" : "available";
}

function getDayStatus(y, m, d) {
  if (isWeekend(y, m, d)) return "na";
  const dateStr = `${y}-${String(m).padStart(2, "0")}-${String(d).padStart(2, "0")}`;
  const availCount = TIME_SLOTS.filter(
    (_, i) => getSlotStatus(dateStr, i) === "available",
  ).length;
  if (availCount === 0) return "booked";
  if (availCount < LIMITED_THRESHOLD) return "limited";
  return "available";
}

function statusCfg(dayStatus, availCount) {
  const map = {
    booked: {
      badge: "Fully Booked",
      badgeCls: "booked",
      count: "0",
      countCls: "booked",
      label: "slots available",
      icon: "fa-solid fa-circle-xmark",
      iconColor: "#ef4444",
      slotText: "Fully Booked",
      slotColor: "#ef4444",
    },
    limited: {
      badge: "Limited Slots",
      badgeCls: "limited",
      count: availCount,
      countCls: "limited",
      label: "slots left",
      icon: "fa-solid fa-circle-exclamation",
      iconColor: "#f59e0b",
      slotText: `${availCount} slots left`,
      slotColor: "#f59e0b",
    },
    na: {
      badge: "Not Available",
      badgeCls: "na",
      count: "",
      countCls: "",
      label: "",
      icon: "fa-solid fa-circle-minus",
      iconColor: "#9ca3af",
      slotText: "Not Available",
      slotColor: "#9ca3af",
    },
    available: {
      badge: "Available",
      badgeCls: "available",
      count: availCount,
      countCls: "available",
      label: "slots available",
      icon: "fa-solid fa-circle-check",
      iconColor: "#22c55e",
      slotText: `${availCount} slots available`,
      slotColor: "#16a34a",
    },
  };
  return map[dayStatus];
}

function openDatetimePanel() {
  dtpYear = todayDate.getFullYear();
  dtpMonth = todayDate.getMonth();
  selectedDate = null;
  selectedSlot = null;
  renderCalendar();
  resetSlotsPanel();
  document.getElementById("dtpOverlay").classList.add("open");
  document.getElementById("datetime-field").classList.add("active");
  document.body.style.overflow = "hidden";
}

function closeDatetimePanel() {
  document.getElementById("dtpOverlay").classList.remove("open");
  document.getElementById("datetime-field").classList.remove("active");
  document.body.style.overflow = "";
}

document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    closeDatetimePanel();
    closePayment();
  }
});

document
  .getElementById("dtpOverlay")
  .addEventListener("mousedown", function (e) {
    if (e.target === this) closeDatetimePanel();
  });

function changeMonth(dir) {
  dtpMonth += dir;
  if (dtpMonth > 11) {
    dtpMonth = 0;
    dtpYear++;
  }
  if (dtpMonth < 0) {
    dtpMonth = 11;
    dtpYear--;
  }
  renderCalendar();
}

function renderCalendar() {
  document.getElementById("calMonthLabel").textContent = new Date(
    dtpYear,
    dtpMonth,
  ).toLocaleString("default", { month: "long", year: "numeric" });

  const firstDay = new Date(dtpYear, dtpMonth, 1).getDay();
  const daysInMonth = new Date(dtpYear, dtpMonth + 1, 0).getDate();
  const startOffset = (firstDay + 6) % 7;

  let html = "";
  for (let i = 0; i < startOffset; i++)
    html += '<div class="cal-cell cal-empty"></div>';

  for (let d = 1; d <= daysInMonth; d++) {
    const m = dtpMonth + 1;
    const dateStr = `${dtpYear}-${String(m).padStart(2, "0")}-${String(d).padStart(2, "0")}`;
    const cellDate = new Date(dtpYear, dtpMonth, d);
    const isPast = cellDate < todayDate;
    const isToday = cellDate.getTime() === todayDate.getTime();
    const isSel = selectedDate === dateStr;
    const wknd = isWeekend(dtpYear, m, d);
    const status = wknd || isPast ? "na" : getDayStatus(dtpYear, m, d);

    let cls = "cal-cell";
    if (isPast) cls += " cal-past";
    if (isToday) cls += " cal-today";
    if (isSel) cls += " cal-selected";
    if (wknd) cls += " cal-na";

    const clickable = !isPast && !wknd && status !== "booked";
    const onclick = clickable ? `onclick="selectDate('${dateStr}')"` : "";
    const dotHtml = isPast ? "" : `<span class="cal-dot ${status}"></span>`;

    html += `<div class="${cls}" ${onclick}><span class="cal-num">${d}</span>${dotHtml}</div>`;
  }

  document.getElementById("calGrid").innerHTML = html;
}

function resetSlotsPanel() {
  document.getElementById("calSummary").style.display = "none";
  document.getElementById("slotsHeader").style.display = "none";
  document.getElementById("slotsFooter").style.display = "none";
  document.getElementById("slotList").innerHTML = `
    <div class="slots-empty">
      <i class="fa-regular fa-calendar"></i>
      <p>Select a date on the left to see available time slots.</p>
    </div>`;
}

function selectDate(dateStr) {
  selectedDate = dateStr;
  selectedSlot = null;
  renderCalendar();

  const [y, m, d] = dateStr.split("-").map(Number);
  const formatted = new Date(y, m - 1, d).toLocaleDateString("en-US", {
    month: "long",
    day: "numeric",
    year: "numeric",
  });
  const availCount = TIME_SLOTS.filter(
    (_, i) => getSlotStatus(dateStr, i) === "available",
  ).length;
  const dayStatus = getDayStatus(y, m, d);
  const cfg = statusCfg(dayStatus, availCount);

  document.getElementById("calSummary").style.display = "flex";
  document.getElementById("summaryDate").textContent = formatted;

  const badge = document.getElementById("summaryBadge");
  badge.textContent = cfg.badge;
  badge.className = `cal-summary-badge ${cfg.badgeCls}`;

  const countEl = document.getElementById("summaryCount");
  countEl.textContent = cfg.count;
  countEl.className = `cal-summary-count ${cfg.countCls}`;

  const labelEl = document.querySelector(".cal-summary-count-label");
  if (labelEl) {
    labelEl.innerHTML = cfg.label
      ? `${cfg.label}<br><small>You can book an appointment on this date.</small>`
      : "";
  }

  const iconWrap = document.querySelector(".cal-summary-icon");
  if (iconWrap) {
    iconWrap.style.color = cfg.iconColor;
    const iconEl = iconWrap.querySelector("i");
    if (iconEl) iconEl.className = cfg.icon;
  }

  renderSlots(dateStr, formatted, availCount, dayStatus);
}

function renderSlots(dateStr, formatted, availCount, dayStatus) {
  document.getElementById("slotsHeader").style.display = "flex";
  document.getElementById("slotsDate").textContent = formatted;

  const cfg = statusCfg(dayStatus, availCount);
  const countEl = document.getElementById("slotsCount");
  countEl.textContent = cfg.slotText;
  countEl.style.color = cfg.slotColor;

  let html = "";
  TIME_SLOTS.forEach((time, i) => {
    const slotSt = getSlotStatus(dateStr, i);
    const isBooked = slotSt === "booked";
    const isSel = selectedSlot === i;

    let rowCls = "slot-row";
    if (isBooked) rowCls += " slot-booked";
    if (isSel) rowCls += " slot-selected";

    const iconCls = isBooked ? "gray" : isSel ? "blue" : "green";
    const badgeCls = isBooked ? "booked" : "available";
    const badgeTxt = isBooked ? "Booked" : "Available";
    const click = isBooked ? "" : `onclick="selectSlot(${i})"`;

    html += `
      <div class="${rowCls}" id="slot-${i}" ${click}>
        <i class="fa-regular fa-clock slot-icon ${iconCls}"></i>
        <span class="slot-time">${time}</span>
        <span class="slot-badge ${badgeCls}">${badgeTxt}</span>
      </div>`;
  });

  document.getElementById("slotList").innerHTML = html;
  document.getElementById("slotsFooter").style.display = "none";
}

function selectSlot(idx) {
  selectedSlot = idx;

  const [y, m, d] = selectedDate.split("-").map(Number);
  const formatted = new Date(y, m - 1, d).toLocaleDateString("en-US", {
    month: "long",
    day: "numeric",
    year: "numeric",
  });
  const availCount = TIME_SLOTS.filter(
    (_, i) => getSlotStatus(selectedDate, i) === "available",
  ).length;
  const dayStatus = getDayStatus(y, m, d);

  renderSlots(selectedDate, formatted, availCount, dayStatus);

  document.getElementById("slotsFooter").style.display = "flex";
  document.getElementById("sfiValue").textContent =
    `${formatted} | ${TIME_SLOTS[idx]}`;
}

// ============================================================
// BOOKING & PAYMENT — only ONE confirmBooking function!
// ============================================================

function confirmBooking() {
  // Validate service
  if (!apptInput.value.trim()) {
    alert("Please select a service first.");
    return;
  }

  // If coming from calendar panel, update display then close
  if (selectedDate && selectedSlot !== null) {
    const [y, m, d] = selectedDate.split("-").map(Number);
    const formatted = new Date(y, m - 1, d).toLocaleDateString("en-US", {
      month: "long",
      day: "numeric",
      year: "numeric",
    });
    document.getElementById("datetimeDisplay").textContent =
      `${formatted} · ${TIME_SLOTS[selectedSlot]}`;
    closeDatetimePanel();
  }

  // Validate date & time
  if (!selectedDate || selectedSlot === null) {
    alert("Please select a date and time first.");
    return;
  }

  // Open payment modal
  document.getElementById("paymentOverlay").classList.add("active");
  document.body.style.overflow = "hidden";
  document.getElementById("payMain").classList.remove("hidden");
  document.getElementById("paySuccess").classList.remove("show");
  document.getElementById("btnPay").classList.remove("loading");
}

function closePayment() {
  document.getElementById("paymentOverlay").classList.remove("active");
  document.body.style.overflow = "";
}

function processPayment() {
  const btn = document.getElementById("btnPay");
  btn.classList.add("loading");

  setTimeout(() => {
    btn.classList.remove("loading");
    document.getElementById("payMain").classList.add("hidden");
    document.getElementById("paySuccess").classList.add("show");
  }, 1800);
}

function printReceipt() {
  const card = document.querySelector(".receipt-card").outerHTML;
  const win = window.open("", "_blank");
  win.document.write(`<!DOCTYPE html><html><head><meta charset="UTF-8">
        <title>Receipt – Happy Care Clinic</title>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet"/>
        <style>
          body { font-family: 'DM Sans', sans-serif; background: #fff; padding: 32px; max-width: 480px; margin: auto; }
          .receipt-card { border: 2px solid #6366f1; border-radius: 16px; overflow: hidden; }
          .receipt-header { padding: 20px 22px 16px; border-bottom: 1px solid #e5e7eb; }
          .receipt-brand { display: flex; align-items: center; gap: 12px; margin-bottom: 6px; }
          .receipt-logo { width: 44px; height: 44px; background: #fce7f3; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 2px solid #e5e7eb; }
          .receipt-clinic-name { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: #f472b6; }
          .receipt-tagline { font-size: .78rem; color: #9ca3af; }
          .receipt-section { padding: 14px 22px; border-bottom: 1px solid #f3f4f6; }
          .receipt-section-title { font-size: .68rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #1f2937; margin-bottom: 10px; }
          .receipt-row { display: flex; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #f3f4f6; }
          .receipt-row:last-child { border-bottom: none; }
          .receipt-label { font-size: .82rem; color: #4b5563; }
          .receipt-value { font-size: .82rem; font-weight: 600; color: #1f2937; text-align: right; }
          .receipt-value.amount { color: #f472b6; font-size: .95rem; font-weight: 700; }
          .receipt-vat-note { background: #f9fafb; padding: 12px 22px; text-align: center; border-top: 1px solid #e5e7eb; font-size: .78rem; font-weight: 700; color: #1f2937; }
        </style></head><body>${card}</body></html>`);
  win.document.close();
  win.print();
}

document
  .getElementById("paymentOverlay")
  .addEventListener("click", function (e) {
    if (e.target === this) closePayment();
  });

// ============================================================
// AUTO-SELECT SERVICE FROM URL PARAMETER
// ============================================================
document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const service = params.get("service");
  if (service) {
    selectService(null, decodeURIComponent(service));
  }
});
