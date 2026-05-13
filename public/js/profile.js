var BASE_URL = window.location.origin + (window.location.pathname.split('/').slice(0, -2).join('/') || window.location.pathname.split('/').slice(0, -1).join('/'));
const { createClient } = supabase;

const SUPABASE_URL = "https://alvgmydqyffyegcbtsyg.supabase.co";
const SUPABASE_ANON_KEY =
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImFsdmdteWRxeWZmeWVnY2J0c3lnIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzgwNzA0MTcsImV4cCI6MjA5MzY0NjQxN30.7YGzh5EX569NXZhGvrZWh48RUNBYrSagINZQhCePX8k";

const db = createClient(SUPABASE_URL, SUPABASE_ANON_KEY);

// ── Tab switching ─────────────────────────────────────────
const tabLinks = document.querySelectorAll(".tab-link");
const tabPanes = document.querySelectorAll(".tab-pane");

function switchTab(id) {
  tabLinks.forEach((t) => t.classList.remove("active"));
  tabPanes.forEach((p) => p.classList.remove("active"));
  document.getElementById(id).classList.add("active");
  document.querySelector(`[data-tab="${id}"]`)?.classList.add("active");
}

tabLinks.forEach((tab) => {
  tab.addEventListener("click", () => switchTab(tab.getAttribute("data-tab")));
});

// ── Edit mode ─────────────────────────────────────────────
const saveBtn = document.querySelector("#profile-tab .save-btn");
const editBtn = document.querySelector(".btn-primary");
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

editBtn.removeAttribute("onclick");
editBtn.addEventListener("click", () => {
  isEditing ? exitEditMode() : enterEditMode();
});

// ── Save changes to Supabase ──────────────────────────────
saveBtn.addEventListener("click", async () => {
  const {
    data: { user },
  } = await db.auth.getUser();
  if (!user) return;

  const phone = document.getElementById("fieldPhone").value.trim();
  const address = document.getElementById("fieldAddress").value.trim();

  const { error } = await db
    .from("patients")
    .update({ phone, address })
    .eq("id", user.id);

  if (error) {
    showToast("❌ Failed to save: " + error.message);
    return;
  }

  // Update sidebar live
  document.getElementById("sidebarPhone").textContent = phone || "—";
  document.getElementById("sidebarAddress").textContent = address || "—";

  showToast("✅ Profile saved successfully!");
  exitEditMode();
});

// ── Password toggle ───────────────────────────────────────
document.querySelectorAll(".toggle-eye").forEach((eye) => {
  eye.addEventListener("click", () => {
    const input = document.getElementById(eye.dataset.target);
    const isText = input.type === "text";
    input.type = isText ? "password" : "text";
    eye.classList.toggle("fa-eye", isText);
    eye.classList.toggle("fa-eye-slash", !isText);
  });
});

// ── Change password ───────────────────────────────────────
const pwSaveBtn = document.querySelectorAll(".save-btn")[1];
pwSaveBtn?.addEventListener("click", async () => {
  const newPw = document.getElementById("new-pw").value;
  const conPw = document.getElementById("con-pw").value;

  if (!newPw || newPw.length < 8)
    return showToast("❌ Password must be at least 8 characters.");
  if (newPw !== conPw) return showToast("❌ Passwords do not match.");

  const { error } = await db.auth.updateUser({ password: newPw });

  if (error) {
    showToast("❌ " + error.message);
  } else {
    showToast("✅ Password updated!");
    document.getElementById("cur-pw").value = "";
    document.getElementById("new-pw").value = "";
    document.getElementById("con-pw").value = "";
  }
});

// ── Toast ─────────────────────────────────────────────────
function showToast(msg) {
  const toast = document.getElementById("toast");
  document.getElementById("toast-msg").textContent = msg;
  toast.classList.add("show");
  setTimeout(() => toast.classList.remove("show"), 3000);
}

// ── Load profile from Supabase ────────────────────────────
async function loadProfile() {
  const {
    data: { user },
    error: userError,
  } = await db.auth.getUser();

  if (userError || !user) {
    window.location.href =
      `${BASE_URL}/auth/login.php`;
    return;
  }

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

  // ── Sidebar ───────────────────────────────────────────
  document.getElementById("sidebarName").textContent = fullName;
  document.getElementById("sidebarEmail").textContent = user.email;
  document.getElementById("sidebarPhone").textContent = patient.phone || "—";
  document.getElementById("sidebarAddress").textContent = displayAddress;

  // ── Form fields ───────────────────────────────────────
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

// ── Init ──────────────────────────────────────────────────
loadProfile();
