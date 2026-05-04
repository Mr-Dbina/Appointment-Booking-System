<?php
$base = "http://localhost/appointment_booking_system";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Book Appointment – Happy Care Clinic</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= $base ?>/public/css/nav.css" />
  <link rel="stylesheet" href="<?= $base ?>/public/css/footer.css" />
  <link rel="stylesheet" href="<?= $base ?>/public/css/appointment.css" />
</head>
<body>

  <?php include __DIR__ . '/../shared/nav.html'; ?>

  <!-- PAGE HERO -->
  <div class="appt-hero">
    <h1><i class="fa-solid fa-calendar-heart" style="color:var(--pink);margin-right:10px;"></i>Book an Appointment</h1>
    <p>Schedule your visit in just a few easy steps — we're here for you.</p>
  </div>

  <!-- STEP INDICATORS -->
  <div class="steps-bar" id="stepsBar">
    <div class="step active" data-step="1">
      <div class="step-circle"><i class="fa-solid fa-stethoscope"></i></div>
      <div class="step-label">Service</div>
    </div>
    <div class="step" data-step="2">
      <div class="step-circle"><i class="fa-solid fa-user-doctor"></i></div>
      <div class="step-label">Doctor</div>
    </div>
    <div class="step" data-step="3">
      <div class="step-circle"><i class="fa-solid fa-calendar-days"></i></div>
      <div class="step-label">Date &amp; Time</div>
    </div>
    <div class="step" data-step="4">
      <div class="step-circle"><i class="fa-solid fa-user"></i></div>
      <div class="step-label">Your Info</div>
    </div>
    <div class="step" data-step="5">
      <div class="step-circle"><i class="fa-solid fa-circle-check"></i></div>
      <div class="step-label">Confirm</div>
    </div>
  </div>

  <!-- MAIN -->
  <div class="appt-main">

    <!-- FORM CARD -->
    <div class="form-card" id="formCard">

      <!-- STEP 1: Service -->
      <div class="step-content active" id="step1">
        <h2>Select a Service</h2>
        <p class="subtitle">Choose the type of medical consultation you need.</p>
        <div class="service-select-grid">
          <div class="service-tile" data-service="OB-GYN" onclick="selectService(this)">
            <div class="service-icon">🌸</div>
            <div class="service-tile-info">
              <h4>OB-GYN</h4>
              <p>Obstetrics &amp; Gynecology</p>
            </div>
          </div>
          <div class="service-tile" data-service="General Medicine" onclick="selectService(this)">
            <div class="service-icon">💊</div>
            <div class="service-tile-info">
              <h4>General Medicine</h4>
              <p>Internal Medicine &amp; Check-up</p>
            </div>
          </div>
          <div class="service-tile" data-service="Pediatrics" onclick="selectService(this)">
            <div class="service-icon">🧸</div>
            <div class="service-tile-info">
              <h4>Pediatrics</h4>
              <p>Child &amp; Adolescent Health</p>
            </div>
          </div>
          <div class="service-tile" data-service="Dermatology" onclick="selectService(this)">
            <div class="service-icon">✨</div>
            <div class="service-tile-info">
              <h4>Dermatology</h4>
              <p>Skin, Hair &amp; Nail Care</p>
            </div>
          </div>
          <div class="service-tile" data-service="Surgery" onclick="selectService(this)">
            <div class="service-icon">🔬</div>
            <div class="service-tile-info">
              <h4>Surgery</h4>
              <p>Surgical Consultation</p>
            </div>
          </div>
          <div class="service-tile" data-service="General Check-up" onclick="selectService(this)">
            <div class="service-icon">🩺</div>
            <div class="service-tile-info">
              <h4>General Check-up</h4>
              <p>Annual Physical Exam</p>
            </div>
          </div>
        </div>
        <div class="btn-group">
          <button class="btn-next" id="btnStep1" onclick="goStep(2)" disabled>
            Next <i class="fa-solid fa-arrow-right"></i>
          </button>
        </div>
      </div>

      <!-- STEP 2: Doctor -->
      <div class="step-content" id="step2">
        <h2>Choose Your Doctor</h2>
        <p class="subtitle">Select a physician for your appointment.</p>
        <div class="doctor-select-grid">
          <div class="doctor-tile" data-doctor="Dr. Puma" data-spec="M.D., DPCP (Internal Medicine)" onclick="selectDoctor(this)">
            <div class="doctor-avatar"><img src="<?= $base ?>/public/images/puma.png" alt="Dr. Puma" /></div>
            <div class="doctor-tile-info">
              <h4>Dr. Puma</h4>
              <p>Internal Medicine</p>
              <span class="avail">● Available</span>
            </div>
          </div>
          <div class="doctor-tile" data-doctor="Dr. Luca" data-spec="M.D., DPBS (Surgery)" onclick="selectDoctor(this)">
            <div class="doctor-avatar"><img src="<?= $base ?>/public/images/luca.png" alt="Dr. Luca" /></div>
            <div class="doctor-tile-info">
              <h4>Dr. Luca</h4>
              <p>Surgery</p>
              <span class="avail">● Available</span>
            </div>
          </div>
          <div class="doctor-tile" data-doctor="Dra. Babu" data-spec="M.D., DPOGS (OB-GYN)" onclick="selectDoctor(this)">
            <div class="doctor-avatar"><img src="<?= $base ?>/public/images/babu.png" alt="Dra. Babu" /></div>
            <div class="doctor-tile-info">
              <h4>Dra. Babu</h4>
              <p>Obstetrics &amp; Gynecology</p>
              <span class="avail">● Available</span>
            </div>
          </div>
          <div class="doctor-tile" data-doctor="Dra. Coli" data-spec="M.D., DPPS (Pediatrics)" onclick="selectDoctor(this)">
            <div class="doctor-avatar"><img src="<?= $base ?>/public/images/coli.png" alt="Dra. Coli" /></div>
            <div class="doctor-tile-info">
              <h4>Dra. Coli</h4>
              <p>Pediatrics</p>
              <span class="avail">● Available</span>
            </div>
          </div>
        </div>
        <div class="btn-group">
          <button class="btn-back" onclick="goStep(1)"><i class="fa-solid fa-arrow-left"></i> Back</button>
          <button class="btn-next" id="btnStep2" onclick="goStep(3)" disabled>
            Next <i class="fa-solid fa-arrow-right"></i>
          </button>
        </div>
      </div>

      <!-- STEP 3: Date & Time -->
      <div class="step-content" id="step3">
        <h2>Pick a Date &amp; Time</h2>
        <p class="subtitle">Select an available date and your preferred time slot.</p>

        <div class="calendar-wrap">
          <div class="cal-header">
            <button class="cal-nav" onclick="changeMonth(-1)"><i class="fa-solid fa-chevron-left"></i></button>
            <h3 id="calMonthYear"></h3>
            <button class="cal-nav" onclick="changeMonth(1)"><i class="fa-solid fa-chevron-right"></i></button>
          </div>
          <div class="cal-grid" id="calGrid"></div>
        </div>

        <div class="time-slots-wrap" id="timeSlotsWrap" style="display:none">
          <h4><i class="fa-regular fa-clock" style="color:var(--pink);margin-right:6px;"></i>Available Time Slots</h4>
          <div class="time-slots" id="timeSlots"></div>
        </div>

        <div class="btn-group">
          <button class="btn-back" onclick="goStep(2)"><i class="fa-solid fa-arrow-left"></i> Back</button>
          <button class="btn-next" id="btnStep3" onclick="goStep(4)" disabled>
            Next <i class="fa-solid fa-arrow-right"></i>
          </button>
        </div>
      </div>

      <!-- STEP 4: Patient Info -->
      <div class="step-content" id="step4">
        <h2>Your Information</h2>
        <p class="subtitle">Please fill in your details so we can reach you.</p>

        <div class="field-row">
          <div class="field-group">
            <label for="firstName">First Name *</label>
            <input type="text" id="firstName" placeholder="e.g. Maria" oninput="updateSummary()" />
          </div>
          <div class="field-group">
            <label for="lastName">Last Name *</label>
            <input type="text" id="lastName" placeholder="e.g. Santos" oninput="updateSummary()" />
          </div>
        </div>

        <div class="field-row">
          <div class="field-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" placeholder="you@email.com" oninput="updateSummary()" />
          </div>
          <div class="field-group">
            <label for="phone">Phone Number *</label>
            <input type="tel" id="phone" placeholder="+63 912 345 6789" oninput="updateSummary()" />
          </div>
        </div>

        <div class="field-row">
          <div class="field-group">
            <label for="dob">Date of Birth *</label>
            <input type="date" id="dob" />
          </div>
          <div class="field-group">
            <label for="sex">Sex *</label>
            <select id="sex">
              <option value="">Select…</option>
              <option>Male</option>
              <option>Female</option>
              <option>Prefer not to say</option>
            </select>
          </div>
        </div>

        <div class="field-group">
          <label for="concern">Chief Complaint / Reason for Visit</label>
          <textarea id="concern" placeholder="Briefly describe your symptoms or reason for visiting…"></textarea>
        </div>

        <div class="btn-group">
          <button class="btn-back" onclick="goStep(3)"><i class="fa-solid fa-arrow-left"></i> Back</button>
          <button class="btn-next" id="btnStep4" onclick="submitAppointment()">
            Confirm Appointment <i class="fa-solid fa-check"></i>
          </button>
        </div>
      </div>

      <!-- STEP 5: Confirmation -->
      <div class="step-content" id="step5">
        <div class="confirm-wrap">
          <div class="confirm-icon">🎉</div>
          <h2>Appointment Booked!</h2>
          <p>Your appointment has been successfully scheduled.<br>Please check your email for a confirmation message.</p>
          <div class="confirm-ref" id="confirmRef">Ref #HCC-000000</div>
          <div id="confirmDetails" style="text-align:left;background:#fafcff;border-radius:14px;padding:20px;margin-bottom:24px;font-size:0.88rem;line-height:2;border:2px solid #e8edf2;"></div>
          <div class="confirm-actions">
            <a href="<?= $base ?>/app/views/users/index.php" class="btn-home"><i class="fa-solid fa-house"></i> Home</a>
            <button class="btn-next" onclick="printConfirmation()">
              <i class="fa-solid fa-print"></i> Print
            </button>
          </div>
        </div>
      </div>

    </div><!-- /form-card -->

    <!-- SUMMARY SIDEBAR -->
    <div class="summary-card">
      <h3><i class="fa-solid fa-clipboard-list" style="color:var(--pink);margin-right:8px;"></i>Appointment Summary</h3>

      <div class="summary-row">
        <div class="summary-icon"><i class="fa-solid fa-stethoscope"></i></div>
        <div class="summary-info">
          <label>Service</label>
          <span id="sumService" class="summary-placeholder">Not selected</span>
        </div>
      </div>

      <div class="summary-row">
        <div class="summary-icon"><i class="fa-solid fa-user-doctor"></i></div>
        <div class="summary-info">
          <label>Doctor</label>
          <span id="sumDoctor" class="summary-placeholder">Not selected</span>
        </div>
      </div>

      <div class="summary-row">
        <div class="summary-icon"><i class="fa-solid fa-calendar-days"></i></div>
        <div class="summary-info">
          <label>Date</label>
          <span id="sumDate" class="summary-placeholder">Not selected</span>
        </div>
      </div>

      <div class="summary-row">
        <div class="summary-icon"><i class="fa-regular fa-clock"></i></div>
        <div class="summary-info">
          <label>Time</label>
          <span id="sumTime" class="summary-placeholder">Not selected</span>
        </div>
      </div>

      <div class="summary-row">
        <div class="summary-icon"><i class="fa-solid fa-user"></i></div>
        <div class="summary-info">
          <label>Patient</label>
          <span id="sumPatient" class="summary-placeholder">Not filled</span>
        </div>
      </div>

      <hr class="summary-divider" />

      <div class="policy-note">
        <i class="fa-solid fa-circle-info"></i>
        Please arrive <strong>15 minutes</strong> before your scheduled time. For cancellations, contact us at least <strong>24 hours</strong> in advance.
      </div>
    </div>

  </div><!-- /appt-main -->

  <?php include __DIR__ . '/../shared/footer.html'; ?>

<script>
/* ── STATE ─────────────────────────────────────────────────── */
const state = {
  currentStep: 1,
  service: null,
  doctor: null,
  doctorSpec: null,
  date: null,
  time: null,
};

let calYear, calMonth;
const today = new Date();

/* ── STEP NAVIGATION ───────────────────────────────────────── */
function goStep(n) {
  if (n < 1 || n > 5) return;
  document.getElementById('step' + state.currentStep).classList.remove('active');
  state.currentStep = n;
  document.getElementById('step' + n).classList.add('active');

  // Update step bar
  document.querySelectorAll('.step').forEach(el => {
    const s = parseInt(el.dataset.step);
    el.classList.remove('active', 'done');
    if (s < n)  el.classList.add('done');
    if (s === n) el.classList.add('active');
  });

  if (n === 3) renderCalendar();
}

/* ── SERVICE ───────────────────────────────────────────────── */
function selectService(el) {
  document.querySelectorAll('.service-tile').forEach(t => t.classList.remove('selected'));
  el.classList.add('selected');
  state.service = el.dataset.service;
  document.getElementById('btnStep1').disabled = false;
  document.getElementById('sumService').textContent = state.service;
  document.getElementById('sumService').classList.remove('summary-placeholder');
}

/* ── DOCTOR ────────────────────────────────────────────────── */
function selectDoctor(el) {
  document.querySelectorAll('.doctor-tile').forEach(t => t.classList.remove('selected'));
  el.classList.add('selected');
  state.doctor = el.dataset.doctor;
  state.doctorSpec = el.dataset.spec;
  document.getElementById('btnStep2').disabled = false;
  document.getElementById('sumDoctor').textContent = state.doctor;
  document.getElementById('sumDoctor').classList.remove('summary-placeholder');
}

/* ── CALENDAR ──────────────────────────────────────────────── */
function renderCalendar() {
  if (!calYear) { calYear = today.getFullYear(); calMonth = today.getMonth(); }
  const months = ['January','February','March','April','May','June',
                  'July','August','September','October','November','December'];
  document.getElementById('calMonthYear').textContent = months[calMonth] + ' ' + calYear;

  const grid = document.getElementById('calGrid');
  grid.innerHTML = '';

  ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].forEach(d => {
    const el = document.createElement('div');
    el.className = 'cal-day-name';
    el.textContent = d;
    grid.appendChild(el);
  });

  const first = new Date(calYear, calMonth, 1).getDay();
  const days  = new Date(calYear, calMonth + 1, 0).getDate();

  for (let i = 0; i < first; i++) {
    const el = document.createElement('div');
    el.className = 'cal-day empty';
    grid.appendChild(el);
  }

  for (let d = 1; d <= days; d++) {
    const el = document.createElement('div');
    el.className = 'cal-day';
    el.textContent = d;

    const date = new Date(calYear, calMonth, d);
    const isToday = date.toDateString() === today.toDateString();
    const isPast  = date < new Date(today.getFullYear(), today.getMonth(), today.getDate());
    const isSun   = date.getDay() === 0;

    if (isPast || isSun) {
      el.classList.add('disabled');
    } else {
      if (isToday) el.classList.add('today');
      const ds = date.toDateString();
      if (state.date === ds) el.classList.add('selected');
      el.onclick = () => selectDate(ds, d, months[calMonth], calYear, el);
    }

    grid.appendChild(el);
  }
}

function changeMonth(dir) {
  calMonth += dir;
  if (calMonth > 11) { calMonth = 0; calYear++; }
  if (calMonth < 0)  { calMonth = 11; calYear--; }
  renderCalendar();
}

function selectDate(ds, d, month, year, el) {
  document.querySelectorAll('.cal-day').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
  state.date = ds;
  state.time = null;
  document.getElementById('btnStep3').disabled = true;
  document.getElementById('sumDate').textContent = month + ' ' + d + ', ' + year;
  document.getElementById('sumDate').classList.remove('summary-placeholder');
  document.getElementById('sumTime').textContent = 'Not selected';
  document.getElementById('sumTime').classList.add('summary-placeholder');
  renderTimeSlots();
}

/* ── TIME SLOTS ────────────────────────────────────────────── */
function renderTimeSlots() {
  const slots = ['8:00 AM','8:30 AM','9:00 AM','9:30 AM',
                 '10:00 AM','10:30 AM','11:00 AM','11:30 AM',
                 '1:00 PM','1:30 PM','2:00 PM','2:30 PM',
                 '3:00 PM','3:30 PM','4:00 PM','4:30 PM'];
  // Randomly mark some as booked for demo
  const booked = ['9:00 AM','10:30 AM','1:30 PM','3:00 PM'];

  const wrap = document.getElementById('timeSlotsWrap');
  const grid = document.getElementById('timeSlots');
  grid.innerHTML = '';
  wrap.style.display = 'block';

  slots.forEach(t => {
    const el = document.createElement('div');
    el.className = 'time-slot' + (booked.includes(t) ? ' booked' : '');
    el.textContent = t;
    if (!booked.includes(t)) {
      if (state.time === t) el.classList.add('selected');
      el.onclick = () => selectTime(t, el);
    }
    grid.appendChild(el);
  });
}

function selectTime(t, el) {
  document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
  el.classList.add('selected');
  state.time = t;
  document.getElementById('btnStep3').disabled = false;
  document.getElementById('sumTime').textContent = t;
  document.getElementById('sumTime').classList.remove('summary-placeholder');
}

/* ── SUMMARY UPDATE ────────────────────────────────────────── */
function updateSummary() {
  const first = document.getElementById('firstName').value.trim();
  const last  = document.getElementById('lastName').value.trim();
  const full  = [first, last].filter(Boolean).join(' ');
  const el    = document.getElementById('sumPatient');
  if (full) {
    el.textContent = full;
    el.classList.remove('summary-placeholder');
  } else {
    el.textContent = 'Not filled';
    el.classList.add('summary-placeholder');
  }
}

/* ── SUBMIT ────────────────────────────────────────────────── */
function submitAppointment() {
  const first = document.getElementById('firstName').value.trim();
  const last  = document.getElementById('lastName').value.trim();
  const email = document.getElementById('email').value.trim();
  const phone = document.getElementById('phone').value.trim();

  if (!first || !last || !email || !phone) {
    alert('Please fill in all required fields.');
    return;
  }

  // Generate reference number
  const ref = 'HCC-' + String(Math.floor(Math.random() * 900000) + 100000);
  document.getElementById('confirmRef').textContent = 'Ref #' + ref;

  document.getElementById('confirmDetails').innerHTML = `
    <strong><i class="fa-solid fa-stethoscope" style="color:var(--pink);margin-right:6px;"></i>Service:</strong> ${state.service}<br>
    <strong><i class="fa-solid fa-user-doctor" style="color:var(--pink);margin-right:6px;"></i>Doctor:</strong> ${state.doctor} — <em style="font-size:0.8rem;color:var(--gray)">${state.doctorSpec}</em><br>
    <strong><i class="fa-solid fa-calendar-days" style="color:var(--pink);margin-right:6px;"></i>Date:</strong> ${state.date}<br>
    <strong><i class="fa-regular fa-clock" style="color:var(--pink);margin-right:6px;"></i>Time:</strong> ${state.time}<br>
    <strong><i class="fa-solid fa-user" style="color:var(--pink);margin-right:6px;"></i>Patient:</strong> ${first} ${last}<br>
    <strong><i class="fa-solid fa-envelope" style="color:var(--pink);margin-right:6px;"></i>Email:</strong> ${email}
  `;

  goStep(5);
}

function printConfirmation() { window.print(); }
</script>
</body>
</html>