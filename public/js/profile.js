const { createClient } = supabase;

const SUPABASE_URL = "https://alvgmydqyffyegcbtsyg.supabase.co";
const SUPABASE_ANON_KEY =
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImFsdmdteWRxeWZmeWVnY2J0c3lnIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzgwNzA0MTcsImV4cCI6MjA5MzY0NjQxN30.7YGzh5EX569NXZhGvrZWh48RUNBYrSagINZQhCePX8k";

const db = createClient(SUPABASE_URL, SUPABASE_ANON_KEY);

const loginBtn = document.getElementById("loginBtn");
const loginBtnText = document.getElementById("loginBtnText");
const formMessage = document.getElementById("formMessage");

function showMsg(msg, type) {
  formMessage.textContent = msg;
  formMessage.className = "form-message " + type;
  formMessage.style.display = "block";
  formMessage.scrollIntoView({ behavior: "smooth", block: "nearest" });
}

function setLoading(on) {
  loginBtn.disabled = on;
  loginBtnText.textContent = on ? "Signing in…" : "Log in";
}

// Allow Enter key to submit
document.addEventListener("keydown", (e) => {
  if (e.key === "Enter") loginBtn.click();
});

loginBtn.addEventListener("click", async () => {
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value;

  // ── Validate ─────────────────────────────────────────────
  if (!email) return showMsg("Please enter your email address.", "error");
  if (!password) return showMsg("Please enter your password.", "error");

  setLoading(true);

  // ── Authenticate with Supabase ────────────────────────────
  const { data, error } = await db.auth.signInWithPassword({ email, password });

  if (error) {
    setLoading(false);
    if (error.message.toLowerCase().includes("invalid login credentials"))
      return showMsg("Incorrect email or password. Please try again.", "error");
    if (error.message.toLowerCase().includes("email not confirmed"))
      return showMsg("Please verify your email before logging in.", "error");
    return showMsg(error.message, "error");
  }

  // ── Redirect ─────────────────────────────────────────────
  setLoading(false);
  showMsg("✅ Login successful! Redirecting…", "success");

  setTimeout(() => {
    window.location.href =
      "http://localhost/appointment_booking_system/app/views/users/main.php";
  }, 1500);
});
