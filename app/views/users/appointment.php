<?php
$base = "http://localhost/appointment_booking_system";
?>
<?php include __DIR__ . '/../shared/head.php'; ?>
    <link rel="stylesheet" href="<?= $base?>/public/css/appointment.css">
    <?php include __DIR__ . '/../shared/nav.php'; ?>
    <div class="appt-hero">
        <h1>Healthcare made simple</h1>
        <p>Find the right doctor and book in seconds</p>
        <div class="appointment-bar">
            <div class="appt-field" id="service-field">
                <i class="fa-solid fa-magnifying-glass appt-icon"></i>
                <div class="appt-field-text">
                    <span class="appt-label word-rotator" id="wordRotator">
                        <span class="word active">General Check-up</span>
                        <span class="word">Skin Consultation</span>
                        <span class="word">Prenatal Care</span>
                        <span class="word">Vaccination</span>
                        <span class="word">Skin Care</span>
                    </span>
                    <div class="appt-input-wrap">
                        <input
                            type="text"
                            id="apptInput"
                            class="appt-value"
                            placeholder="Book Appointment"
                            oninput="filterServices(this.value); openDropdown();"
                            onclick="event.stopPropagation(); openDropdown();"
                            autocomplete="off"
                        />
                        <i class="fa-solid fa-xmark clear-btn" id="clearBtn" onclick="clearService(event)" style="display:none;"></i>
                    </div>
                </div>
                <div class="service-dropdown" id="serviceDropdown">
                    <div class="dropdown-list" id="dropdownList">
                        <div class="dropdown-group">Dermatology</div>
                        <div class="dropdown-item" onclick="selectService(event, 'Acne Treatment')"><i class="fa-solid fa-face-sad-tear"></i><div><div class="dropdown-name">Acne Treatment</div><div class="dropdown-sub">Dermatology</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Skin Consultation')"><i class="fa-solid fa-hand-dots"></i><div><div class="dropdown-name">Skin Consultation</div><div class="dropdown-sub">Dermatology</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Allergy / Rash Treatment')"><i class="fa-solid fa-allergies"></i><div><div class="dropdown-name">Allergy / Rash Treatment</div><div class="dropdown-sub">Dermatology</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Eczema & Psoriasis Care')"><i class="fa-solid fa-disease"></i><div><div class="dropdown-name">Eczema & Psoriasis Care</div><div class="dropdown-sub">Dermatology</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Wart / Mole Removal')"><i class="fa-solid fa-scissors"></i><div><div class="dropdown-name">Wart / Mole Removal</div><div class="dropdown-sub">Dermatology</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Chemical Peel / Facial Treatments')"><i class="fa-solid fa-spa"></i><div><div class="dropdown-name">Chemical Peel / Facial Treatments</div><div class="dropdown-sub">Dermatology</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Hair Loss Treatment')"><i class="fa-solid fa-head-side-virus"></i><div><div class="dropdown-name">Hair Loss Treatment</div><div class="dropdown-sub">Dermatology</div></div></div>

                        <div class="dropdown-group">General Medicine</div>
                        <div class="dropdown-item" onclick="selectService(event, 'General Check-up')"><i class="fa-solid fa-stethoscope"></i><div><div class="dropdown-name">General Check-up</div><div class="dropdown-sub">General Medicine</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Vaccination / Immunization')"><i class="fa-solid fa-syringe"></i><div><div class="dropdown-name">Vaccination / Immunization</div><div class="dropdown-sub">General Medicine</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Fever / Flu Consultation')"><i class="fa-solid fa-temperature-high"></i><div><div class="dropdown-name">Fever / Flu Consultation</div><div class="dropdown-sub">General Medicine</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Blood Pressure Monitoring')"><i class="fa-solid fa-heart-pulse"></i><div><div class="dropdown-name">Blood Pressure Monitoring</div><div class="dropdown-sub">General Medicine</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Diabetes Screening')"><i class="fa-solid fa-droplet"></i><div><div class="dropdown-name">Diabetes Screening</div><div class="dropdown-sub">General Medicine</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Medical Certificate')"><i class="fa-solid fa-file-medical"></i><div><div class="dropdown-name">Medical Certificate</div><div class="dropdown-sub">General Medicine</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Follow-up Consultation')"><i class="fa-solid fa-rotate-right"></i><div><div class="dropdown-name">Follow-up Consultation</div><div class="dropdown-sub">General Medicine</div></div></div>

                        <div class="dropdown-group">Pediatrics</div>
                        <div class="dropdown-item" onclick="selectService(event, 'Growth & Development Monitoring')"><i class="fa-solid fa-child"></i><div><div class="dropdown-name">Growth & Development Monitoring</div><div class="dropdown-sub">Pediatrics</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Nutrition Consultation')"><i class="fa-solid fa-apple-whole"></i><div><div class="dropdown-name">Nutrition Consultation</div><div class="dropdown-sub">Pediatrics</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Newborn Care')"><i class="fa-solid fa-baby"></i><div><div class="dropdown-name">Newborn Care</div><div class="dropdown-sub">Pediatrics</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Fever / Cough Consultation')"><i class="fa-solid fa-head-side-cough"></i><div><div class="dropdown-name">Fever / Cough Consultation</div><div class="dropdown-sub">Pediatrics</div></div></div>

                        <div class="dropdown-group">OB-GYN</div>
                        <div class="dropdown-item" onclick="selectService(event, 'Prenatal Check-up')"><i class="fa-solid fa-heart"></i><div><div class="dropdown-name">Prenatal Check-up</div><div class="dropdown-sub">OB-GYN</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Ultrasound')"><i class="fa-solid fa-wave-square"></i><div><div class="dropdown-name">Ultrasound</div><div class="dropdown-sub">OB-GYN</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Family Planning')"><i class="fa-solid fa-people-roof"></i><div><div class="dropdown-name">Family Planning</div><div class="dropdown-sub">OB-GYN</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Menstrual Problems Consultation')"><i class="fa-solid fa-calendar-days"></i><div><div class="dropdown-name">Menstrual Problems Consultation</div><div class="dropdown-sub">OB-GYN</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Pregnancy Test & Monitoring')"><i class="fa-solid fa-baby-carriage"></i><div><div class="dropdown-name">Pregnancy Test & Monitoring</div><div class="dropdown-sub">OB-GYN</div></div></div>
                        <div class="dropdown-item" onclick="selectService(event, 'Pap Smear / Cervical Screening')"><i class="fa-solid fa-microscope"></i><div><div class="dropdown-name">Pap Smear / Cervical Screening</div><div class="dropdown-sub">OB-GYN</div></div></div>

                        <div class="dropdown-item" id="noResultItem" style="display:none; cursor:default; pointer-events:none;">
                            <i class="fa-solid fa-circle-exclamation" style="color:#aaa;"></i>
                            <div>
                                <div class="dropdown-name" style="color:#aaa; font-weight:500;">No service provided</div>
                                <div class="dropdown-sub">Try a different keyword</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="appt-divider"></div>
<div class="appt-field" id="datetime-field" onclick="openDatetimePanel()">
    <i class="fa-solid fa-calendar-days appt-icon"></i>
    <div class="appt-field-text">
        <span class="appt-label-static">Appointment</span>
        <span class="appt-value" id="datetimeDisplay">Select date &amp; time</span>
    </div>
</div>
            <div class="appt-divider"></div>
            <button class="appt-btn" onclick="confirmBooking()">Book Appointment</button>
            
  <div id="paymentOverlay" role="dialog" aria-modal="true" aria-labelledby="payModalTitle">
    <div class="pay-modal">
      <div class="pay-header">
        <div class="pay-brand">
        <img
           class="pay-brand-icon" src="<?= $base ?>/public/images/logo.png"
        />
          <div class="pay-brand-name">
            Happy Care Clinic
            <span>Medical &amp; Wellness Center</span>
          </div>
        </div>
        <div class="pay-secure">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          Secure Payment
        </div>
      </div>
      <div class="pay-main" id="payMain">
        <div class="pay-body">
          <p class="pay-section-title" id="payModalTitle">Appointment Details</p>
          <div class="pay-details">
            <div class="pay-row">
              <div class="pay-row-left">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Doctor
              </div>
              <div class="pay-row-right">Dr. Maria Santos</div>
            </div>
            <div class="pay-row">
              <div class="pay-row-left">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                Service
              </div>
              <div class="pay-row-right">General Check-up</div>
            </div>
            <div class="pay-row">
              <div class="pay-row-left">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Date &amp; Time
              </div>
              <div class="pay-row-right">May 15, 2025 &nbsp;·&nbsp; 9:00 AM – 9:30 AM</div>
            </div>
            <div class="pay-row">
              <div class="pay-row-left">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                Payment Reference
              </div>
              <div class="pay-row-right" style="font-size:.8rem;font-weight:600;letter-spacing:.03em;color:#6b7280">PAY-20250515-000123</div>
            </div>
            <div class="pay-row">
              <div class="pay-row-left">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Appointment No.
              </div>
              <div class="pay-row-right" style="font-size:.8rem;font-weight:600;letter-spacing:.03em;color:#6b7280">APT-20250515-0456</div>
            </div>
            <div class="pay-row">
              <div class="pay-row-left">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Amount
              </div>
              <div class="pay-row-right amount">₱500.00</div>
            </div>
          </div>
          <div class="pay-info-box">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <p><strong>You are about to complete your payment.</strong><br>A VAT invoice will be provided separately, if applicable.</p>
          </div>
        </div>
        <div class="pay-actions">
          <button class="btn-cancel" onclick="closePayment()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            Cancel
          </button>
          <button class="btn-pay" id="btnPay" onclick="processPayment()">
            <div class="spinner"></div>
            <svg class="btn-pay-label" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <span class="btn-pay-label">Proceed to Pay</span>
          </button>
        </div>
        <div class="pay-footer">
          <p>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Your information is secure and will not be shared with third parties.
          </p>
        </div>
      </div>
      <div class="pay-success" id="paySuccess">
        <div class="receipt-wrap">
          <div class="receipt-card">
            <div class="receipt-header">
              <div class="receipt-brand">
            <img
           class="receipt-logo" src="<?= $base ?>/public/images/logo.png"
        />
                <div>
                  <div class="receipt-clinic-name">Happy Care Clinic</div>
                </div>
              </div>
              <div class="receipt-tagline">This is your receipt</div>
            </div>
            <div class="receipt-section">
              <div class="receipt-section-title">Your Details</div>
              <div class="receipt-row">
                <span class="receipt-label">Name</span>
                <span class="receipt-value" id="rName">—</span>
              </div>
              <div class="receipt-row">
                <span class="receipt-label">Email address</span>
                <span class="receipt-value" id="rEmail">—</span>
              </div>
              <div class="receipt-row">
                <span class="receipt-label">Date</span>
                <span class="receipt-value" id="rDate">May 15, 2025</span>
              </div>
            </div>
            <div class="receipt-section">
              <div class="receipt-section-title">Appointment Details</div>
              <div class="receipt-row">
                <span class="receipt-label">Doctor</span>
                <span class="receipt-value">Dr. Maria Santos</span>
              </div>
              <div class="receipt-row">
                <span class="receipt-label">Service</span>
                <span class="receipt-value">General Check-up</span>
              </div>
              <div class="receipt-row">
                <span class="receipt-label">Date &amp; Time</span>
                <span class="receipt-value">May 15, 2025 · 9:00–9:30 AM</span>
              </div>
              <div class="receipt-row">
                <span class="receipt-label">Payment reference</span>
                <span class="receipt-value">PAY-20250515-000123</span>
              </div>
              <div class="receipt-row">
                <span class="receipt-label">Appointment no.</span>
                <span class="receipt-value">APT-20250515-0456</span>
              </div>
              <div class="receipt-row">
                <span class="receipt-label">Amount</span>
                <span class="receipt-value amount">₱500.00</span>
              </div>
            </div>
            <div class="receipt-vat-note">
              <p>This is your transaction — it can't be used to claim VAT</p>
            </div>
          </div>
        </div>
        <div class="receipt-actions">
          <button class="btn-print" onclick="printReceipt()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Print Receipt
          </button>
          <button class="btn-done" onclick="closePayment()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
            Done
          </button>
        </div>
      </div>
    </div>
  </div>
        </div>
    </div>
    <div class="dtp-overlay" id="dtpOverlay">
        <div class="dtp-panel" id="dtpPanel">
            <div class="dtp-panel-header">
                <div class="dtp-panel-header-left">
                    <div class="dtp-panel-icon">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <div class="dtp-panel-title">Appointment Calendar</div>
                        <div class="dtp-panel-sub">Choose a date to book your appointment</div>
                    </div>
                </div>
                <div class="dtp-panel-header-right">
                    <div class="dtp-legend">
                        <div class="legend-item"><span class="legend-dot available"></span>Available</div>
                        <div class="legend-item"><span class="legend-dot limited"></span>Limited Slot</div>
                        <div class="legend-item"><span class="legend-dot booked"></span>Fully Booked</div>
                        <div class="legend-item"><span class="legend-dot NA"></span>Not Available</div>
                    </div>
                    <button class="dtp-close-btn" onclick="closeDatetimePanel()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
            <div class="dtp-panel-body">
                <div class="dtp-cal">
                    <div class="cal-nav">
                        <button class="cal-nav-btn" onclick="changeMonth(-1)"><i class="fa-solid fa-chevron-left"></i></button>
                        <span class="cal-month-label" id="calMonthLabel"></span>
                        <button class="cal-nav-btn" onclick="changeMonth(1)"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                    <div class="cal-grid-wrap">
                        <div class="cal-day-headers">
                            <span>Mo</span><span>Tu</span><span>We</span>
                            <span>Th</span><span>Fr</span><span>Sa</span><span>Su</span>
                        </div>
                        <div class="cal-grid" id="calGrid"></div>
                    </div>
                    <div class="cal-summary" id="calSummary" style="display:none;">
                        <div class="cal-summary-left">
                            <div class="cal-summary-icon"><i class="fa-solid fa-circle-check"></i></div>
                            <div>
                                <div class="cal-summary-date" id="summaryDate"></div>
                                <span class="cal-summary-badge" id="summaryBadge"></span>
                            </div>
                        </div>
                        <div class="cal-summary-right">
                            <div class="cal-summary-count" id="summaryCount"></div>
                            <div class="cal-summary-count-label">slots available<br><small>You can book an appointment on this date.</small></div>
                        </div>
                    </div>
                    <p class="cal-hint">Click on a date to view available time slots.</p>
                </div>
                <div class="dtp-divider-v"></div>
                <div class="dtp-slots">
                    <div class="slots-header" id="slotsHeader" style="display:none;">
                        <div class="slots-header-icon"><i class="fa-solid fa-clock"></i></div>
                        <div>
                            <div class="slots-date" id="slotsDate"></div>
                            <div class="slots-count" id="slotsCount"></div>
                        </div>
                    </div>
                    <div class="slot-list" id="slotList">
                        <div class="slots-empty">
                            <i class="fa-regular fa-calendar"></i>
                            <p>Select a date on the left to see available time slots.</p>
                        </div>
                    </div>
                    <div class="slots-footer" id="slotsFooter" style="display:none;">
                        <div class="slots-footer-info">
                            <div class="sfi-label">Selected Date &amp; Time</div>
                            <div class="sfi-value" id="sfiValue"></div>
                        </div>
                        <button class="dtp-book-btn" onclick="confirmBooking()">Book Appointment</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../shared/footer.php'; ?>
    <script src="<?= $base ?>/public/js/appointment.js"></script>
