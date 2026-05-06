const { createClient } = supabase;
const db = createClient(
  "https://alvgmydqyffyegcbtsyg.supabase.co", // your project URL
  "your-anon-public-key", // anon key only — NOT service role
);

document.querySelector(".btn-register").addEventListener("click", async () => {
  const firstName = document
    .querySelector('input[placeholder="First Name"]')
    .value.trim();
  const lastName = document
    .querySelector('input[placeholder="Last Name"]')
    .value.trim();
  const email = document.getElementById("email").value.trim();
  const phone = document
    .querySelector('input[placeholder="Phone Number"]')
    .value.trim();
  const dob = document.getElementById("dob").value;
  const sex = document.getElementById("sex").value;
  const password = document.getElementById("password").value;
  const terms = document.getElementById("terms").checked;

  if (!firstName || !lastName || !email || !password)
    return showMsg("Please fill in all required fields.", "error");
  if (password.length < 8)
    return showMsg("Password must be at least 8 characters.", "error");
  if (!terms)
    return showMsg("You must agree to the Terms of Service.", "error");

  setLoading(true);

  const { data: authData, error: authError } = await db.auth.signUp({
    email,
    password,
  });
  if (authError) {
    setLoading(false);
    return showMsg(authError.message, "error");
  }

  const token = crypto.randomUUID();
  const expiresAt = new Date(Date.now() + 86400000).toISOString();

  const res = await fetch("/appointment_booking_system/app/api/register.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      id: authData.user.id,
      email,
      firstName,
      lastName,
      phone,
      dob,
      sex,
      token,
      expiresAt,
    }),
  });

  const result = await res.json();
  setLoading(false);

  if (!result.success)
    return showMsg(result.message || "Registration failed.", "error");

  showMsg(
    "✅ Account created! Check your email to verify your account.",
    "success",
  );
  setTimeout(
    () =>
      (window.location.href =
        "/appointment_booking_system/app/views/auth/login.php"),
    3000,
  );
});

function showMsg(msg, type) {
  const el = document.getElementById("formMessage");
  el.textContent = msg;
  el.style.display = "block";
  el.style.padding = "10px 14px";
  el.style.borderRadius = "10px";
  el.style.marginBottom = "12px";
  el.style.fontSize = "0.88rem";
  el.style.background = type === "error" ? "#fee2e2" : "#dcfce7";
  el.style.color = type === "error" ? "#dc2626" : "#16a34a";
}

function setLoading(on) {
  const btn = document.querySelector(".btn-register");
  btn.querySelector("span").textContent = on
    ? "Creating account..."
    : "Register";
  btn.disabled = on;
}
