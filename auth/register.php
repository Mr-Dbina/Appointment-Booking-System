<?php
require_once __DIR__ . '/../config.php';
?>
<?php include __DIR__ . '/../shared/head.php'; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/register.css">
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/register_additions.css">

    <div class="page">
      <div class="left">
        <div class="card">
          <p class="welcome">Create Account</p>
          <h1>Patient Registration</h1>
          <p class="sub">Fill in your details to get started</p>
          <div id="formMessage" class="form-message"></div>
          <div class="field-row">
            <div class="field">
              <input type="text" id="firstName" placeholder="First Name" autocomplete="given-name" />
            </div>
            <div class="field">
              <input type="text" id="lastName" placeholder="Last Name" autocomplete="family-name" />
            </div>
          </div>
          <div class="field">
            <input type="email" id="email" placeholder="Email Address" autocomplete="email" />
          </div>
          <div class="field">
            <input type="tel" id="phone" placeholder="Phone Number" autocomplete="tel" />
          </div>
          <div class="field-row">
            <div class="field" id="dobField" style="position:relative;">
              <button type="button" class="dob-trigger placeholder" id="dobTrigger" onclick="toggleDobCal(event)">
                Date of Birth
              </button>
              <span class="icon"><i class="fa-solid fa-calendar-days"></i></span>
              <input type="hidden" id="dob" />
              <div class="dob-cal" id="dobCal">
                <!-- Header -->
                <div class="dob-header">
                  <div class="dob-header-label">Select date</div>
                  <div class="dob-header-date" id="dobHeaderDate">Select date</div>
                  <button type="button" class="dob-edit-btn" onclick="toggleDobEditMode()">
                    <i class="fa-solid fa-pen"></i>
                  </button>
                </div>

                <!-- Calendar Mode -->
                <div id="dobCalendarMode">
                  <div class="dob-nav">
                    <button type="button" class="dob-nav-btn" onclick="dobChangeMonth(-1)">
                      <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <span class="dob-month-label" id="dobMonthLabel"></span>
                    <button type="button" class="dob-nav-btn" onclick="dobChangeMonth(1)">
                      <i class="fa-solid fa-chevron-right"></i>
                    </button>
                  </div>
                  <div class="dob-day-headers">
                    <span>S</span><span>M</span><span>T</span>
                    <span>W</span><span>T</span><span>F</span><span>S</span>
                  </div>
                  <div class="dob-grid" id="dobGrid"></div>
                  <div class="dob-cal-footer">
                    <button type="button" class="dob-clear" onclick="dobClear()">Clear</button>
                    <button type="button" class="dob-today" onclick="dobSelectToday()">Today</button>
                  </div>
                </div>

                <!-- Edit Mode -->
                <div id="dobEditMode" style="display:none;">
                  <div class="dob-edit-wrap">
                    <p class="dob-edit-label">Enter Date</p>
                    <div class="dob-edit-fields">
                      <div class="dob-edit-group">
                        <label>Month</label>
                        <input type="number" id="dobEditMonth" min="1" max="12" placeholder="MM" />
                      </div>
                      <span class="dob-edit-sep">/</span>
                      <div class="dob-edit-group">
                        <label>Day</label>
                        <input type="number" id="dobEditDay" min="1" max="31" placeholder="DD" />
                      </div>
                      <span class="dob-edit-sep">/</span>
                      <div class="dob-edit-group">
                        <label>Year</label>
                        <input type="number" id="dobEditYear" min="1900" max="2099" placeholder="YYYY" />
                      </div>
                    </div>
                    <p class="dob-edit-format">Format: MM/DD/YYYY</p>
                  </div>
                  <div class="dob-cal-footer">
                    <button type="button" class="dob-clear" onclick="dobCancelEdit()">Cancel</button>
                    <button type="button" class="dob-today" onclick="dobConfirmEdit()">OK</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <select id="sex" class="unselected" onchange="this.classList.remove('unselected')">
                <option value="" disabled selected>Sex</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
              <span class="icon"><i class="fa-solid fa-chevron-down"></i></span>
            </div>
          </div>
          <div class="addr-wrapper" id="addressWrapper">
            <button type="button" class="addr-pill" id="addressPill">
              <i class="fa-solid fa-location-dot addr-icon"></i>
              <span id="addressPillText" class="placeholder">Region / Province / City / Barangay</span>
              <i class="fa-solid fa-chevron-down addr-chevron"></i>
            </button>
            <div class="addr-dropdown" id="addressDropdown">
              <input
                type="text"
                class="addr-search"
                id="addressSearch"
                placeholder="Search…"
                autocomplete="off"
              />
              <div class="addr-list" id="addressList"></div>
            </div>
            <input type="hidden" id="hiddenRegion" />
            <input type="hidden" id="hiddenProvince" />
            <input type="hidden" id="hiddenCity" />
            <input type="hidden" id="hiddenBarangay" />
          </div>
          <div class="field">
            <input type="password" id="password" placeholder="Password" autocomplete="new-password" />
            <span class="icon clickable" id="togglePwd">
              <i class="fa-solid fa-eye" id="eyeIcon"></i>
            </span>
          </div>
          <div class="terms-row">
            <input type="checkbox" id="terms" />
            <label for="terms">
              I agree to the <a href="#">Terms of Service</a> and
              <a href="#">Privacy Policy</a> of Happy Care Clinic.
            </label>
          </div>
          <div class="divider"></div>
          <button class="btn-register" id="registerBtn">
            <span id="registerBtnText">Register</span>
          </button>
          <p class="signin">
            Already have account?
            <a href="<?= BASE_URL ?>/auth/login.php">Sign in here</a>
          </p>
        </div>
      </div>
      <div class="right">
        <img class="bg" src="<?= BASE_URL ?>/public/images/background_login.png" alt="Medical background" />
        <div class="overlay"></div>
        <div class="content">
          <div class="brand">
            <div class="brand-text">
              <h2>Happy Care Clinic</h2>
              <span>TRUSTED MEDICAL CARE</span>
            </div>
            <img src="<?= BASE_URL ?>/public/images/logo.png" alt="Happy Care Clinic Logo" />
          </div>
          <div class="hero-text">
            <span class="line line-pink">HEALING WITH</span>
            <span class="line line-cyan">PRECISION,</span>
            <span class="line line-pink">CARING</span>
            <span class="line line-white">WITH HEART</span>
            <p class="hero-sub">
              Your health is our highest priority. Expert care delivered with
              warmth, compassion, and precision.
            </p>
          </div>
        </div>
      </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
<script>var BASE_URL = "<?= BASE_URL ?>";</script>
<script src="<?= BASE_URL ?>/public/js/lock.js"></script>
<script src="<?= BASE_URL ?>/public/js/dob.js"></script>
<script src="<?= BASE_URL ?>/public/js/address.js"></script>
<script src="<?= BASE_URL ?>/public/js/register.js"></script>