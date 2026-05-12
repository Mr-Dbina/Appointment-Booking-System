const BASE_URL = "http://localhost/appointment_booking_system";

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
  selectedServiceId = null;
  clearBtn.style.display = "none";
  filterServices("");
  showRotator();
  apptInput.focus();
  openDropdown();
}

async function selectService(e, name) {
  if (e) e.stopPropagation();
  apptInput.value = name;
  selectedServiceId = null;
  clearBtn.style.display = "inline";
  hideRotator();
  filterServices(name);
  serviceDropdown.classList.remove("open");

  try {
    const res = await fetch(
      `${BASE_URL}/app/api/get_service.php?name=${encodeURIComponent(name)}`,
    );
    const json = await res.json();
    selectedServiceId = json.id ?? null;
  } catch (err) {
    selectedServiceId = null;
  }
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

const LIMITED_THRESHOLD = 3;

let dtpYear, dtpMonth;
let selectedDate = null;
let selectedSlot = null;
let selectedServiceId = null;
let slotsCache = {};

const todayDate = new Date();
todayDate.setHours(0, 0, 0, 0);

function isWeekend(y, m, d) {
  return [0, 6].includes(new Date(y, m - 1, d).getDay());
}

function openDatetimePanel() {
  dtpYear = todayDate.getFullYear();
  dtpMonth = todayDate.getMonth();
  selectedDate = null;
  selectedSlot = null;
  slotsCache = {};
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

    let cls = "cal-cell";
    if (isPast) cls += " cal-past";
    if (isToday) cls += " cal-today";
    if (isSel) cls += " cal-selected";
    if (wknd) cls += " cal-na";

    const clickable = !isPast && !wknd;
    const onclick = clickable ? `onclick="selectDate('${dateStr}')"` : "";
    const dotHtml =
      isPast || wknd ? "" : `<span class="cal-dot available"></span>`;

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

async function selectDate(dateStr) {
  selectedDate = dateStr;
  selectedSlot = null;
  renderCalendar();

  const [y, m, d] = dateStr.split("-").map(Number);
  const formatted = new Date(y, m - 1, d).toLocaleDateString("en-US", {
    month: "long",
    day: "numeric",
    year: "numeric",
  });

  document.getElementById("slotsHeader").style.display = "flex";
  document.getElementById("slotsDate").textContent = formatted;
  document.getElementById("slotsCount").textContent = "Loading slots...";
  document.getElementById("slotsCount").style.color = "#6b7280";
  document.getElementById("slotList").innerHTML =
    `<div class="slots-empty"><i class="fa-solid fa-spinner fa-spin"></i><p>Fetching available slots...</p></div>`;
  document.getElementById("slotsFooter").style.display = "none";

  let slots = slotsCache[dateStr];
  if (!slots) {
    try {
      const res = await fetch(
        `${BASE_URL}/app/api/get_slots.php?date=${dateStr}`,
      );
      const json = await res.json();
      slots = json.slots || [];
      slotsCache[dateStr] = slots;
    } catch (err) {
      document.getElementById("slotList").innerHTML =
        `<div class="slots-empty"><i class="fa-solid fa-circle-exclamation" style="color:#ef4444"></i><p>Failed to load slots. Please try again.</p></div>`;
      return;
    }
  }

  const availCount = slots.filter((s) => s.status !== "booked").length;
  const dayStatus =
    availCount === 0
      ? "booked"
      : availCount < LIMITED_THRESHOLD
        ? "limited"
        : "available";
  const statusMap = {
    available: {
      badge: "Available",
      cls: "available",
      color: "#16a34a",
      text: `${availCount} slots available`,
      icon: "fa-solid fa-circle-check",
      iconColor: "#22c55e",
    },
    limited: {
      badge: "Limited Slots",
      cls: "limited",
      color: "#f59e0b",
      text: `${availCount} slots left`,
      icon: "fa-solid fa-circle-exclamation",
      iconColor: "#f59e0b",
    },
    booked: {
      badge: "Fully Booked",
      cls: "booked",
      color: "#ef4444",
      text: "Fully Booked",
      icon: "fa-solid fa-circle-xmark",
      iconColor: "#ef4444",
    },
  };
  const cfg = statusMap[dayStatus];

  document.getElementById("calSummary").style.display = "flex";
  document.getElementById("summaryDate").textContent = formatted;

  const badge = document.getElementById("summaryBadge");
  badge.textContent = cfg.badge;
  badge.className = `cal-summary-badge ${cfg.cls}`;

  const countEl = document.getElementById("summaryCount");
  countEl.textContent = availCount > 0 ? availCount : "0";
  countEl.className = `cal-summary-count ${cfg.cls}`;

  const labelEl = document.querySelector(".cal-summary-count-label");
  if (labelEl) {
    labelEl.innerHTML =
      availCount > 0
        ? `slots available<br><small>You can book an appointment on this date.</small>`
        : "";
  }

  const iconWrap = document.querySelector(".cal-summary-icon");
  if (iconWrap) {
    iconWrap.style.color = cfg.iconColor;
    const iconEl = iconWrap.querySelector("i");
    if (iconEl) iconEl.className = cfg.icon;
  }

  document.getElementById("slotsCount").textContent = cfg.text;
  document.getElementById("slotsCount").style.color = cfg.color;

  window._currentSlots = slots;
  renderSlots(slots);
}

function renderSlots(slots) {
  if (!slots.length) {
    document.getElementById("slotList").innerHTML =
      `<div class="slots-empty"><i class="fa-regular fa-calendar"></i><p>No slots available for this date.</p></div>`;
    return;
  }

  let html = "";
  slots.forEach((slot, i) => {
    const isBooked = slot.status === "booked";
    const isSel = selectedSlot && selectedSlot.id === slot.id;

    let rowCls = "slot-row";
    if (isBooked) rowCls += " slot-booked";
    if (isSel) rowCls += " slot-selected";

    const iconCls = isBooked ? "gray" : isSel ? "blue" : "green";
    const badgeCls = isBooked
      ? "booked"
      : slot.status === "limited"
        ? "limited"
        : "available";
    const badgeTxt = isBooked
      ? "Booked"
      : slot.status === "limited"
        ? "Limited"
        : "Available";
    const click = isBooked ? "" : `onclick="selectSlot(${i})"`;

    html += `
      <div class="${rowCls}" id="slot-${i}" ${click}>
        <i class="fa-regular fa-clock slot-icon ${iconCls}"></i>
        <span class="slot-time">${slot.label}</span>
        <span class="slot-badge ${badgeCls}">${badgeTxt}</span>
      </div>`;
  });

  document.getElementById("slotList").innerHTML = html;
  document.getElementById("slotsFooter").style.display = "none";
}

function selectSlot(idx) {
  selectedSlot = window._currentSlots[idx];
  renderSlots(window._currentSlots);

  const [y, m, d] = selectedDate.split("-").map(Number);
  const formatted = new Date(y, m - 1, d).toLocaleDateString("en-US", {
    month: "long",
    day: "numeric",
    year: "numeric",
  });

  document.getElementById("slotsFooter").style.display = "flex";
  document.getElementById("sfiValue").textContent =
    `${formatted} | ${selectedSlot.label}`;
}

async function confirmBooking() {
  if (!apptInput.value.trim()) {
    alert("Please select a service first.");
    return;
  }

  if (selectedDate && selectedSlot) {
    const [y, m, d] = selectedDate.split("-").map(Number);
    const formatted = new Date(y, m - 1, d).toLocaleDateString("en-US", {
      month: "long",
      day: "numeric",
      year: "numeric",
    });
    document.getElementById("datetimeDisplay").textContent =
      `${formatted} · ${selectedSlot.label}`;
    closeDatetimePanel();
  }

  if (!selectedDate || !selectedSlot) {
    alert("Please select a date and time first.");
    return;
  }

  // Pre-fill modal with what we already know before API call
  document.getElementById("payService").textContent = apptInput.value;
  document.getElementById("payDateTime").textContent =
    document.getElementById("datetimeDisplay").textContent;

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

async function processPayment() {
  const btn = document.getElementById("btnPay");
  btn.classList.add("loading");

  // Get Supabase auth token from localStorage
  const sessionKey = Object.keys(localStorage).find(
    (k) => k.startsWith("sb-") && k.endsWith("-auth-token"),
  );
  const session = sessionKey
    ? JSON.parse(localStorage.getItem(sessionKey))
    : null;
  const authToken = session?.access_token || "";

  if (!authToken) {
    btn.classList.remove("loading");
    alert("You must be logged in to book an appointment.");
    return;
  }

  if (!selectedServiceId) {
    btn.classList.remove("loading");
    alert("Please select a valid service from the dropdown.");
    return;
  }

  try {
    const res = await fetch(`${BASE_URL}/app/api/process_appointment.php`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        service_id: selectedServiceId,
        time_slot_id: selectedSlot.id,
        auth_token: authToken,
      }),
    });

    const json = await res.json();

    if (!json.success) {
      btn.classList.remove("loading");
      alert("Booking failed: " + (json.error || "Unknown error"));
      return;
    }

    const apptDate = new Date(json.slot_date).toLocaleDateString("en-US", {
      month: "long",
      day: "numeric",
      year: "numeric",
    });
    const start = new Date("1970-01-01T" + json.start_time).toLocaleTimeString(
      "en-US",
      { hour: "numeric", minute: "2-digit" },
    );
    const end = new Date("1970-01-01T" + json.end_time).toLocaleTimeString(
      "en-US",
      { hour: "numeric", minute: "2-digit" },
    );
    const dateTimeStr = `${apptDate} · ${start} – ${end}`;
    const today = new Date().toLocaleDateString("en-US", {
      month: "long",
      day: "numeric",
      year: "numeric",
    });

    document.getElementById("payDoctor").textContent = json.doctor_name || "—";
    document.getElementById("payService").textContent = apptInput.value;
    document.getElementById("payDateTime").textContent = dateTimeStr;
    document.getElementById("payRef").textContent = json.payment_ref;
    document.getElementById("payApptNo").textContent = json.appointment_no;
    document.getElementById("payAmount").textContent =
      "₱" + parseFloat(json.amount).toFixed(2);

    document.getElementById("rDate").textContent = today;
    document.getElementById("rName").textContent = json.patient_name || "—"; // ← add
    document.getElementById("rEmail").textContent = json.patient_email || "—"; // ← add
    document.getElementById("rDoctor").textContent = json.doctor_name || "—";
    document.getElementById("rService").textContent = apptInput.value;
    document.getElementById("rDateTime").textContent = dateTimeStr;
    document.getElementById("rPayRef").textContent = json.payment_ref;
    document.getElementById("rApptNo").textContent = json.appointment_no;
    document.getElementById("rAmount").textContent =
      "₱" + parseFloat(json.amount).toFixed(2);

    setTimeout(() => {
      btn.classList.remove("loading");
      document.getElementById("payMain").classList.add("hidden");
      document.getElementById("paySuccess").classList.add("show");
    }, 1800);
  } catch (err) {
    btn.classList.remove("loading");
    alert("Network error. Please try again.");
  }
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

document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const service = params.get("service");
  if (service) {
    selectService(null, decodeURIComponent(service));
  }
});
