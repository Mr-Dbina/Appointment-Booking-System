var BASE_URL = window.location.origin + (window.location.pathname.split('/').slice(0, -2).join('/') || window.location.pathname.split('/').slice(0, -1).join('/'));
const { createClient } = supabase;

const SUPABASE_URL = "https://alvgmydqyffyegcbtsyg.supabase.co";
const SUPABASE_ANON_KEY =
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImFsdmdteWRxeWZmeWVnY2J0c3lnIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzgwNzA0MTcsImV4cCI6MjA5MzY0NjQxN30.7YGzh5EX569NXZhGvrZWh48RUNBYrSagINZQhCePX8k";

const db = createClient(SUPABASE_URL, SUPABASE_ANON_KEY);

const registerBtn = document.getElementById("registerBtn");
const registerBtnText = document.getElementById("registerBtnText");
const formMessage = document.getElementById("formMessage");
const passwordInput = document.getElementById("password");

function showMsg(msg, type) {
  formMessage.textContent = msg;
  formMessage.className = "form-message " + type;
  formMessage.style.display = "block";
  formMessage.scrollIntoView({ behavior: "smooth", block: "nearest" });
}

function setLoading(on) {
  registerBtn.disabled = on;
  registerBtnText.textContent = on ? "Creating account…" : "Register";
}

registerBtn.addEventListener("click", async () => {
  // ── Collect ────────────────────────────────────────────
  const firstName = document.getElementById("firstName").value.trim();
  const lastName = document.getElementById("lastName").value.trim();
  const email = document.getElementById("email").value.trim();
  const phone = document.getElementById("phone").value.trim();
  const dob = document.getElementById("dob").value;
  const sex = document.getElementById("sex").value;
  const password = passwordInput.value;
  const terms = document.getElementById("terms").checked;

  // ── Address (populated by address.js) ─────────────────
  const region = document.getElementById("hiddenRegion").value;
  const province = document.getElementById("hiddenProvince").value;
  const city = document.getElementById("hiddenCity").value;
  const barangay = document.getElementById("hiddenBarangay").value;

  // ── Validate ───────────────────────────────────────────
  if (!firstName || !lastName)
    return showMsg("Please enter your first and last name.", "error");
  if (!email) return showMsg("Please enter your email address.", "error");
  if (!phone) return showMsg("Please enter your phone number.", "error");
  if (!dob) return showMsg("Please select your date of birth.", "error");
  if (!sex) return showMsg("Please select your sex.", "error");
  if (!region) return showMsg("Please select your complete address.", "error");
  if (!password || password.length < 8)
    return showMsg("Password must be at least 8 characters.", "error");
  if (!terms)
    return showMsg("You must agree to the Terms of Service.", "error");

  setLoading(true);

  // ── Step 1: Create auth user ───────────────────────────
  const { data: authData, error: authError } = await db.auth.signUp({
    email,
    password,
  });

  if (authError) {
    setLoading(false);
    return showMsg(authError.message, "error");
  }

  // ── Step 2: Insert patient profile ────────────────────
  // DB trigger (trg_patient_address) will auto-build the address column
  const { error: profileError } = await db.from("patients").insert({
    id: authData.user.id,
    first_name: firstName,
    last_name: lastName,
    phone: phone,
    date_of_birth: dob,
    sex: sex,
    region: region,
    province: province,
    city: city,
    barangay: barangay,
  });

  if (profileError) {
    setLoading(false);
    return showMsg(profileError.message, "error");
  }

  // ── Step 3: Send welcome/verification email via PHP ───
  fetch(`${BASE_URL}/api/register_api.php`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ email, firstName }),
  });

  // ── Done ───────────────────────────────────────────────
  setLoading(false);
  showMsg("✅ Account created! Redirecting to login…", "success");
  setTimeout(() => {
    window.location.href =
      `${BASE_URL}/auth/login.php`;
  }, 2000);
});
