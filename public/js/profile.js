const { createClient } = supabase;

const db = createClient(
  window.SUPABASE_URL || "https://alvgmydqyffyegcbtsyg.supabase.co",
  window.SUPABASE_ANON_KEY ||
    "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImFsdmdteWRxeWZmeWVnY2J0c3lnIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzgwNzA0MTcsImV4cCI6MjA5MzY0NjQxN30.7YGzh5EX569NXZhGvrZWh48RUNBYrSagINZQhCePX8k",
);

const tabLinks = document.querySelectorAll(".tab-link");
const tabPanes = document.querySelectorAll(".tab-pane");

function switchTab(id) {
  tabLinks.forEach((t) => t.classList.remove("active"));
  tabPanes.forEach((p) => p.classList.remove("active"));
  document.getElementById(id).classList.add("active");
  document.querySelector(`[data-tab="${id}"]`)?.classList.add("active");
}

tabLinks.forEach((tab) => {
  tab.addEventListener("click", () => {
    const tabId = tab.getAttribute("data-tab");
    switchTab(tabId);
    if (tabId === "payment-tab") loadPayments();
    if (tabId === "appointment-tab") loadAppointments();
  });
});

const saveBtn = document.getElementById("profileSaveBtn");
const editBtn = document.getElementById("editProfileBtn");
let isEditing = false;

saveBtn.style.display = "none";

function getEditableInputs() {
  return [...document.querySelectorAll("#profile-tab .form-field")]
    .filter((field) => field.querySelector(".editable-tag"))
    .map((field) => field.querySelector("input"));
}

function enterEditMode() {
  isEditing = true;
  getEditableInputs().forEach((inp) => {
    inp.removeAttribute("readonly");
    inp.classList.add("editing");
  });
  saveBtn.style.display = "inline-flex";
  editBtn.innerHTML = '<i class="fa-solid fa-xmark"></i> Cancel';
  switchTab("profile-tab");
}

function exitEditMode() {
  isEditing = false;
  getEditableInputs().forEach((inp) => {
    inp.setAttribute("readonly", "");
    inp.classList.remove("editing");
  });
  saveBtn.style.display = "none";
  editBtn.innerHTML = '<i class="fa-solid fa-pen-to-square"></i> Edit Profile';
}

editBtn.addEventListener("click", () => {
  isEditing ? exitEditMode() : enterEditMode();
});

saveBtn.addEventListener("click", async () => {
  const {
    data: { session },
  } = await db.auth.getSession();
  if (!session) {
    window.location.href = `${BASE_URL}/auth/login.php`;
    return;
  }

  const user = session.user;
  const phone = document.getElementById("fieldPhone").value.trim();
  const address = document.getElementById("fieldAddress").value.trim();

  const { error } = await db
    .from("patients")
    .update({ phone, address })
    .eq("id", user.id);

  if (error) {
    showToast("Failed to save: " + error.message);
    return;
  }

  document.getElementById("sidebarPhone").textContent = phone || "—";
  document.getElementById("sidebarAddress").textContent = address || "—";

  showToast("Profile saved successfully!");
  exitEditMode();
});

document.querySelectorAll(".toggle-eye").forEach((eye) => {
  eye.addEventListener("click", () => {
    const input = document.getElementById(eye.dataset.target);
    const isText = input.type === "text";
    input.type = isText ? "password" : "text";
    eye.classList.toggle("fa-eye", isText);
    eye.classList.toggle("fa-eye-slash", !isText);
  });
});

const pwSaveBtn = document.getElementById("pwSaveBtn");
pwSaveBtn?.addEventListener("click", async () => {
  const newPw = document.getElementById("new-pw").value;
  const conPw = document.getElementById("con-pw").value;

  if (!newPw || newPw.length < 8)
    return showToast("Password must be at least 8 characters.");
  if (newPw !== conPw) return showToast("Passwords do not match.");

  const { error } = await db.auth.updateUser({ password: newPw });

  if (error) {
    showToast("Failed to update password: " + error.message);
  } else {
    showToast("Password updated!");
    document.getElementById("cur-pw").value = "";
    document.getElementById("new-pw").value = "";
    document.getElementById("con-pw").value = "";
  }
});

function showToast(msg) {
  const toast = document.getElementById("toast");
  document.getElementById("toast-msg").textContent = msg;
  toast.classList.add("show");
  setTimeout(() => toast.classList.remove("show"), 3000);
}

async function loadPayments() {
  const paymentBody = document.getElementById("payment-body");
  if (!paymentBody) return;

  paymentBody.innerHTML = `<tr><td colspan="5" class="pay-loading">Loading transactions...</td></tr>`;

  const {
    data: { session },
  } = await db.auth.getSession();
  if (!session) return;

  const { data: appointments, error: apptError } = await db
    .from("appointments")
    .select("id")
    .eq("patient_id", session.user.id);

  if (apptError || !appointments || appointments.length === 0) {
    paymentBody.innerHTML = `<tr><td colspan="5" class="pay-empty">No transactions found.</td></tr>`;
    return;
  }

  const apptIds = appointments.map((a) => a.id);

  const { data: payments, error: payError } = await db
    .from("payments")
    .select(
      `
      id,
      payment_ref,
      amount,
      status,
      payment_method,
      created_at,
      appointments(
        appointment_no,
        services(name),
        doctors(name),
        time_slots(slot_date, start_time, end_time)
      )
    `,
    )
    .in("appointment_id", apptIds)
    .order("created_at", { ascending: false });

  if (payError || !payments || payments.length === 0) {
    paymentBody.innerHTML = `<tr><td colspan="5" class="pay-empty">No transactions found.</td></tr>`;
    return;
  }

  paymentBody.innerHTML = payments
    .map((p) => {
      const appt = p.appointments;
      const slot = appt?.time_slots;
      const service = appt?.services?.name || "—";
      const doctor = appt?.doctors?.name || "—";
      const apptNo = appt?.appointment_no || "—";
      const date = slot?.slot_date
        ? new Date(slot.slot_date).toLocaleDateString("en-US", {
            month: "long",
            day: "numeric",
            year: "numeric",
          })
        : "—";
      const time = slot?.start_time
        ? new Date("1970-01-01T" + slot.start_time).toLocaleTimeString(
            "en-US",
            { hour: "numeric", minute: "2-digit" },
          )
        : "—";
      const amount = "₱" + parseFloat(p.amount).toFixed(2);
      const statusCls =
        p.status === "paid"
          ? "pay-status-paid"
          : p.status === "refunded"
            ? "pay-status-refunded"
            : "pay-status-pending";
      const createdAt = new Date(p.created_at).toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
      });

      return `
      <tr>
        <td>
          <div class="pay-ref">${p.payment_ref}</div>
          <div class="pay-date-small">${createdAt}</div>
        </td>
        <td>
          <div class="pay-service">${service}</div>
          <div class="pay-doctor">Dr. ${doctor}</div>
        </td>
        <td>
          <div>${date}</div>
          <div class="pay-date-small">${time}</div>
        </td>
        <td><span class="pay-amount">${amount}</span></td>
        <td><span class="pay-status ${statusCls}">${p.status.charAt(0).toUpperCase() + p.status.slice(1)}</span></td>
      </tr>
    `;
    })
    .join("");
}

async function loadAppointments() {
  const apptBody = document.getElementById("appointment-body");
  if (!apptBody) return;

  apptBody.innerHTML = `<div class="appt-loading">Loading appointments...</div>`;

  const {
    data: { session },
  } = await db.auth.getSession();
  if (!session) return;

  const { data: appointments, error } = await db
    .from("appointments")
    .select(
      `
      id,
      appointment_no,
      status,
      services(name),
      doctors(name),
      time_slots(slot_date, start_time, end_time)
    `,
    )
    .eq("patient_id", session.user.id)
    .order("created_at", { ascending: false });

  if (error || !appointments || appointments.length === 0) {
    apptBody.innerHTML = `
      <div class="empty-state">
        <div class="empty-icon"><i class="fa-solid fa-calendar-xmark"></i></div>
        <h3>No appointments yet</h3>
        <p>You haven't booked any appointments yet.</p>
        <button class="btn-primary" onclick="window.location.href='${BASE_URL}/users/appointment.php'">Book an Appointment</button>
      </div>`;
    return;
  }

  apptBody.innerHTML = appointments
    .map((a) => {
      const slot = a.time_slots;
      const service = a.services?.name || "—";
      const doctor = a.doctors?.name || "—";
      const date = slot?.slot_date
        ? new Date(slot.slot_date).toLocaleDateString("en-US", {
            month: "long",
            day: "numeric",
            year: "numeric",
          })
        : "—";
      const time = slot?.start_time
        ? new Date("1970-01-01T" + slot.start_time).toLocaleTimeString(
            "en-US",
            { hour: "numeric", minute: "2-digit" },
          )
        : "—";
      const statusCls =
        a.status === "confirmed"
          ? "appt-status-confirmed"
          : a.status === "cancelled"
            ? "appt-status-cancelled"
            : "appt-status-pending";

      return `
      <div class="appt-card">
        <div class="appt-card-header">
          <span class="appt-no">#${a.appointment_no}</span>
          <span class="appt-status ${statusCls}">${a.status.charAt(0).toUpperCase() + a.status.slice(1)}</span>
        </div>
        <div class="appt-card-body">
          <div class="appt-row"><i class="fa-solid fa-briefcase-medical"></i> ${service}</div>
          <div class="appt-row"><i class="fa-solid fa-user-doctor"></i> ${doctor}</div>
          <div class="appt-row"><i class="fa-solid fa-calendar-days"></i> ${date} · ${time}</div>
        </div>
      </div>
    `;
    })
    .join("");
}

async function loadProfile() {
  const {
    data: { session },
    error: sessionError,
  } = await db.auth.getSession();

  if (sessionError || !session) {
    window.location.href = `${BASE_URL}/auth/login.php`;
    return;
  }

  const user = session.user;

  const { data: patient, error: profileError } = await db
    .from("patients")
    .select(
      "first_name, last_name, phone, date_of_birth, sex, address, city, province",
    )
    .eq("id", user.id)
    .single();

  if (profileError || !patient) {
    console.error("Profile fetch error:", profileError);
    return;
  }

  const fullName = `${patient.first_name} ${patient.last_name}`;
  const displayAddress =
    patient.address ||
    [patient.city, patient.province].filter(Boolean).join(", ") ||
    "—";

  document.getElementById("sidebarName").textContent = fullName;
  document.getElementById("sidebarEmail").textContent = user.email;
  document.getElementById("sidebarPhone").textContent = patient.phone || "—";
  document.getElementById("sidebarAddress").textContent = displayAddress;

  document.getElementById("fieldFirstName").value = patient.first_name || "";
  document.getElementById("fieldLastName").value = patient.last_name || "";
  document.getElementById("fieldEmail").value = user.email;
  document.getElementById("fieldPhone").value = patient.phone || "";
  document.getElementById("fieldDob").value = patient.date_of_birth || "";
  document.getElementById("fieldSex").value = patient.sex
    ? patient.sex.charAt(0).toUpperCase() + patient.sex.slice(1)
    : "";
  document.getElementById("fieldAddress").value = displayAddress;
}

loadProfile();
