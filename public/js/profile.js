/* ═══════════════════════════════════════════════
   DATA – All departments and their services
═══════════════════════════════════════════════ */
const departments = [
  {
    id: "obgyn",
    name: "OB-GYN",
    tag: "Women's Health",
    tagClass: "purple",
    iconClass: "fa-solid fa-venus",
    sectionIcon: "purple",
    desc: "Comprehensive care for women's reproductive health — from prenatal check-ups and ultrasounds to family planning and menstrual health consultations.",
    subtitle: "Specialized care for every stage of a woman's health journey",
    bannerBg:
      "https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?w=900&q=80",
    services: [
      {
        name: "Prenatal Check-up",
        icon: "fa-solid fa-heart-pulse",
        desc: "Regular monitoring of mother and baby's health throughout pregnancy to ensure a safe and healthy delivery.",
      },
      {
        name: "Ultrasound",
        icon: "fa-solid fa-wave-square",
        desc: "Diagnostic imaging to monitor fetal development, detect complications, and assess reproductive organ health.",
      },
      {
        name: "Family Planning",
        icon: "fa-solid fa-shield-heart",
        desc: "Personalized consultation on contraception options, spacing of pregnancies, and reproductive health planning.",
      },
      {
        name: "Menstrual Problems Consultation",
        icon: "fa-solid fa-notes-medical",
        desc: "Diagnosis and treatment of irregular periods, painful menstruation, PCOS, and other hormonal concerns.",
      },
      {
        name: "Pregnancy Test & Monitoring",
        icon: "fa-solid fa-vial",
        desc: "Confirmation of pregnancy and ongoing monitoring of early pregnancy health with clinical support.",
      },
      {
        name: "Pap Smear / Cervical Screening",
        icon: "fa-solid fa-microscope",
        desc: "Routine cervical cancer screening to detect abnormal cells early, recommended for women 21 years and older.",
      },
    ],
  },
  {
    id: "genmed",
    name: "General Medicine",
    tag: "Primary Care",
    tagClass: "teal",
    iconClass: "fa-solid fa-stethoscope",
    sectionIcon: "teal",
    desc: "Comprehensive adult healthcare covering routine check-ups, disease management, vaccinations, and more. Your first line of medical care.",
    subtitle: "Holistic care for your overall health and well-being",
    bannerBg:
      "https://images.unsplash.com/photo-1666214280391-8ff5bd3c0bf0?w=900&q=80",
    services: [
      {
        name: "General Check-up",
        icon: "fa-solid fa-user-doctor",
        desc: "Thorough physical examination to assess your overall health, identify risks, and establish baseline records.",
      },
      {
        name: "Vaccination / Immunization",
        icon: "fa-solid fa-syringe",
        desc: "Recommended vaccines for adults to protect against preventable diseases — flu, hepatitis, pneumonia, and more.",
      },
      {
        name: "Fever / Flu Consultation",
        icon: "fa-solid fa-temperature-high",
        desc: "Prompt diagnosis and treatment of fever, influenza, and upper respiratory infections with clinical care guidance.",
      },
      {
        name: "Blood Pressure Monitoring",
        icon: "fa-solid fa-heart",
        desc: "Regular blood pressure checks with lifestyle and medication guidance to prevent hypertension complications.",
      },
      {
        name: "Diabetes Screening",
        icon: "fa-solid fa-droplet",
        desc: "Blood glucose testing and risk assessment to detect and manage diabetes or prediabetes at the earliest stage.",
      },
      {
        name: "Medical Certificate",
        icon: "fa-solid fa-file-medical",
        desc: "Official medical certification for employment, school, travel, or legal purposes issued after a clinical assessment.",
      },
      {
        name: "Follow-up Consultation",
        icon: "fa-solid fa-rotate-left",
        desc: "Scheduled return visit to monitor progress, adjust treatment plans, and address any new or ongoing concerns.",
      },
    ],
  },
  {
    id: "peds",
    name: "Pediatrics",
    tag: "Children's Health",
    tagClass: "green",
    iconClass: "fa-solid fa-baby",
    sectionIcon: "green",
    desc: "Compassionate medical care for infants, children, and adolescents — from growth monitoring to illness consultations in a child-friendly environment.",
    subtitle:
      "Expert care to help your children grow healthy, strong, and developmentally on track",
    bannerBg:
      "https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=900&q=80",
    services: [
      {
        name: "Growth & Development Monitoring",
        icon: "fa-solid fa-chart-line",
        desc: "Regular assessments of your child's height, weight, motor skills, and developmental milestones to track healthy progress.",
      },
      {
        name: "Nutrition Consultation",
        icon: "fa-solid fa-bowl-food",
        desc: "Personalized dietary guidance for infants, toddlers, and school-age children to support optimal growth and immune health.",
      },
      {
        name: "Pediatric Consultation",
        icon: "fa-solid fa-child",
        desc: "Comprehensive well-child visits including vaccinations, developmental screening, and parent guidance for all ages.",
      },
      {
        name: "Fever / Cough Consultation",
        icon: "fa-solid fa-lungs-virus",
        desc: "Prompt evaluation and treatment of childhood fever, cough, colds, and respiratory conditions with gentle care.",
      },
    ],
  },
  {
    id: "derm",
    name: "Dermatology",
    tag: "Skin, Hair & Nails",
    tagClass: "pink",
    iconClass: "fa-solid fa-spa",
    sectionIcon: "pink",
    desc: "Expert skin care from medical to cosmetic concerns — acne, eczema, rashes, wart removal, chemical peels, and hair loss treatment.",
    subtitle:
      "Achieve healthy, clear, and confident skin with expert dermatologic care",
    bannerBg:
      "https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=900&q=80",
    services: [
      {
        name: "Acne Treatment",
        icon: "fa-solid fa-face-smile-wink",
        desc: "Comprehensive acne management including topical therapies, oral medications, and skincare regimen advice for all skin types.",
      },
      {
        name: "Skin Consultation",
        icon: "fa-solid fa-magnifying-glass",
        desc: "Thorough skin assessment and diagnosis of dermatological conditions with a personalized treatment plan tailored for you.",
      },
      {
        name: "Allergy / Rash Treatment",
        icon: "fa-solid fa-triangle-exclamation",
        desc: "Identification and management of allergic skin reactions, contact dermatitis, hives, and other rash conditions.",
      },
      {
        name: "Eczema & Psoriasis Care",
        icon: "fa-solid fa-shield-virus",
        desc: "Long-term management plans for chronic inflammatory skin conditions to reduce flare-ups and improve quality of life.",
      },
      {
        name: "Wart / Mole Removal",
        icon: "fa-solid fa-circle-minus",
        desc: "Safe clinical removal of warts, moles, skin tags, and other benign skin growths using approved dermatologic procedures.",
      },
      {
        name: "Chemical Peel / Facial Treatments",
        icon: "fa-solid fa-wand-magic-sparkles",
        desc: "Professional facial peels to exfoliate, brighten, and rejuvenate skin — reducing pigmentation, fine lines, and dullness.",
      },
      {
        name: "Hair Loss Treatment",
        icon: "fa-solid fa-person-rays",
        desc: "Diagnosis and treatment of alopecia, thinning hair, and scalp conditions with medical and cosmetic interventions.",
      },
    ],
  },
];

const allServices = departments.flatMap((d) =>
  d.services.map((s) => ({
    ...s,
    dept: d.name,
    deptId: d.id,
    tagClass: d.tagClass,
    sectionIcon: d.sectionIcon,
  })),
);

let activeFilter = "all";
let searchQuery = "";
let bookingTarget = null;

/* ═══════════════════════════════════════════════
   VIEW NAVIGATION LOGIC (SPA style)
═══════════════════════════════════════════════ */
function initNavigation() {
  const servicesView = document.getElementById("services-view");
  const profileView = document.getElementById("profile-view");
  const navServicesLink = document.getElementById("nav-services-link");
  const navProfileBtn = document.getElementById("nav-profile-btn");
  const jumpButtons = document.querySelectorAll(".jump-to-services");

  // Switch to Profile View
  navProfileBtn.addEventListener("click", () => {
    servicesView.style.display = "none";
    profileView.style.display = "block";
    navServicesLink.classList.remove("active");
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

  // Switch to Services View
  navServicesLink.addEventListener("click", (e) => {
    e.preventDefault();
    switchToServices();
  });

  // Jump from Profile empty state back to Services
  jumpButtons.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      switchToServices();
    });
  });

  function switchToServices() {
    profileView.style.display = "none";
    servicesView.style.display = "block";
    navServicesLink.classList.add("active");
    window.scrollTo({ top: 0, behavior: "smooth" });
  }
}

/* ═══════════════════════════════════════════════
   PROFILE TABS LOGIC
═══════════════════════════════════════════════ */
function initProfileTabs() {
  const tabs = document.querySelectorAll(".tab-link");
  const panes = document.querySelectorAll(".tab-pane");

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      tabs.forEach((t) => t.classList.remove("active"));
      panes.forEach((p) => p.classList.remove("active"));

      tab.classList.add("active");
      const targetPane = document.getElementById(tab.getAttribute("data-tab"));
      targetPane.classList.add("active");
    });
  });
}

/* ═══════════════════════════════════════════════
   RENDER SERVICES
═══════════════════════════════════════════════ */
function render() {
  const wrapper = document.getElementById("servicesWrapper");
  const q = searchQuery.trim().toLowerCase();

  if (q) {
    const results = allServices.filter(
      (s) =>
        s.name.toLowerCase().includes(q) ||
        s.dept.toLowerCase().includes(q) ||
        s.desc.toLowerCase().includes(q),
    );
    if (!results.length) {
      wrapper.innerHTML = `<div class="no-results">
        <i class="fa-solid fa-magnifying-glass"></i>
        <h3>No services found</h3>
        <p>Try a different keyword, like "acne", "prenatal", or "check-up".</p>
      </div>`;
      return;
    }
    wrapper.innerHTML = `<div class="services-grid" style="margin-top:1.5rem;" id="search-grid"></div>`;
    const grid = document.getElementById("search-grid");
    results.forEach((s, i) => {
      grid.insertAdjacentHTML(
        "beforeend",
        serviceCardHTML(
          s.name,
          s.icon,
          s.desc,
          s.sectionIcon,
          s.dept,
          s.tagClass,
          i,
        ),
      );
    });
    attachCardListeners();
    return;
  }

  const toShow =
    activeFilter === "all"
      ? departments
      : departments.filter((d) => d.id === activeFilter);

  wrapper.innerHTML = toShow
    .map((d) => {
      const cardHTML = d.services
        .map((s, i) =>
          serviceCardHTML(
            s.name,
            s.icon,
            s.desc,
            d.sectionIcon,
            d.name,
            d.tagClass,
            i,
          ),
        )
        .join("");
      return `
      <div class="section-block" id="section-${d.id}">
        <div class="service-banner" style="background-image:url('${d.bannerBg}');">
          <div class="banner-content">
            <span class="banner-tag">${d.tag}</span>
            <div class="banner-title">${d.name}</div>
            <div class="banner-desc">${d.desc}</div>
            <button class="btn-explore" data-dept="${d.id}">
              <i class="fa-regular fa-calendar-plus"></i> Book Appointment
            </button>
          </div>
        </div>
        <div class="section-header">
          <div class="section-icon ${d.sectionIcon}"><i class="${d.iconClass}"></i></div>
          <div class="section-title">
            <h2>${d.name} Services</h2>
            <p>${d.subtitle}</p>
          </div>
        </div>
        <div class="services-grid">${cardHTML}</div>
      </div>`;
    })
    .join("");

  attachCardListeners();
  attachBannerBookButtons();
}

function serviceCardHTML(name, icon, desc, colorClass, dept, tagClass, idx) {
  return `
    <div class="service-card card-anim" style="animation-delay:${idx * 50}ms"
         data-service="${name}" data-dept="${dept}" data-tag="${tagClass}">
      <div class="card-icon ${colorClass}"><i class="${icon}"></i></div>
      <div class="card-name">${name}</div>
      <div class="card-desc">${desc}</div>
      <button class="card-action ${colorClass}" data-service="${name}" data-dept="${dept}" data-tag="${tagClass}">
        <i class="fa-regular fa-calendar-plus"></i> Book Now
      </button>
    </div>`;
}

function attachCardListeners() {
  document.querySelectorAll(".card-action").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.stopPropagation();
      openBooking(btn.dataset.service, btn.dataset.dept, btn.dataset.tag);
    });
  });
  document.querySelectorAll(".service-card").forEach((card) => {
    card.addEventListener("click", () => {
      openBooking(card.dataset.service, card.dataset.dept, card.dataset.tag);
    });
  });
}

function attachBannerBookButtons() {
  document.querySelectorAll(".btn-explore[data-dept]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const d = departments.find((x) => x.id === btn.dataset.dept);
      if (d) openBooking(d.name + " – General", d.name, d.tagClass);
    });
  });
}

/* ═══════════════════════════════════════════════
   FILTER BUTTONS
═══════════════════════════════════════════════ */
function initFilters() {
  document.querySelectorAll(".filter-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      document
        .querySelectorAll(".filter-btn")
        .forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");
      activeFilter = btn.dataset.filter;
      searchQuery = "";
      document.getElementById("inlineSearch").value = "";
      render();
      if (activeFilter !== "all") {
        setTimeout(() => {
          const el = document.getElementById("section-" + activeFilter);
          if (el) el.scrollIntoView({ behavior: "smooth", block: "start" });
        }, 100);
      }
    });
  });
}

function initInlineSearch() {
  document
    .getElementById("inlineSearch")
    .addEventListener("input", function () {
      searchQuery = this.value;
      if (searchQuery) {
        document
          .querySelectorAll(".filter-btn")
          .forEach((b) => b.classList.remove("active"));
      } else {
        document
          .querySelector('.filter-btn[data-filter="all"]')
          .classList.add("active");
        activeFilter = "all";
      }
      render();
    });
}

/* ═══════════════════════════════════════════════
   OVERLAY SEARCH (nav button)
═══════════════════════════════════════════════ */
function initOverlaySearch() {
  document.getElementById("searchBtn").addEventListener("click", openSearch);
  document.getElementById("searchOverlay").addEventListener("click", (e) => {
    if (e.target === document.getElementById("searchOverlay")) closeSearch();
  });
  document
    .getElementById("overlaySearchInput")
    .addEventListener("input", function () {
      renderOverlayResults(this.value.trim().toLowerCase());
    });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeSearch();
  });
}

function openSearch() {
  document.getElementById("searchOverlay").classList.add("open");
  setTimeout(() => document.getElementById("overlaySearchInput").focus(), 100);
  renderOverlayResults("");
}
function closeSearch() {
  document.getElementById("searchOverlay").classList.remove("open");
  document.getElementById("overlaySearchInput").value = "";
}

function renderOverlayResults(q) {
  const container = document.getElementById("overlayResults");
  const colorMap = {
    pink: "#e8336d",
    teal: "#26c6da",
    green: "#43a047",
    purple: "#ab47bc",
  };
  const bgMap = {
    pink: "#fce4ec",
    teal: "#e0f7fa",
    green: "#e8f5e9",
    purple: "#f3e5f5",
  };

  const results = !q
    ? allServices.slice(0, 8)
    : allServices.filter(
        (s) =>
          s.name.toLowerCase().includes(q) || s.dept.toLowerCase().includes(q),
      );

  if (!results.length) {
    container.innerHTML =
      '<div class="search-no-result">No services matched your search.</div>';
    return;
  }

  container.innerHTML = results
    .map(
      (s) => `
    <div class="search-result-item" data-service="${s.name}" data-dept="${s.dept}" data-tag="${s.tagClass}">
      <div class="search-result-icon" style="background:${bgMap[s.tagClass]};color:${colorMap[s.tagClass]}">
        <i class="${s.icon}"></i>
      </div>
      <div>
        <div class="search-result-name">${s.name}</div>
        <div class="search-result-dept">${s.dept}</div>
      </div>
    </div>`,
    )
    .join("");

  container.querySelectorAll(".search-result-item").forEach((item) => {
    item.addEventListener("click", () => {
      closeSearch();
      openBooking(item.dataset.service, item.dataset.dept, item.dataset.tag);
    });
  });
}

/* ═══════════════════════════════════════════════
   BOOKING MODAL
═══════════════════════════════════════════════ */
function openBooking(serviceName, dept, tagClass) {
  bookingTarget = { serviceName, dept, tagClass };

  document.getElementById("modal-dept-tag").textContent = dept;
  document.getElementById("modal-dept-tag").className = `modal-tag ${tagClass}`;
  document.getElementById("modal-service-title").textContent = serviceName;

  const today = new Date().toISOString().split("T")[0];
  document.getElementById("bk-date").min = today;

  document.getElementById("bookingForm").style.display = "";
  document.getElementById("bookingSuccess").style.display = "none";
  ["bk-date", "bk-time", "bk-phone", "bk-notes"].forEach((id) => {
    const el = document.getElementById(id);
    if (el) {
      el.value = "";
      el.classList.remove("error");
    }
  });

  // Reset name error state but keep the value
  document.getElementById("bk-name").classList.remove("error");

  ["err-name", "err-date", "err-time", "err-phone"].forEach((id) => {
    document.getElementById(id).classList.remove("show");
  });

  document.getElementById("bookingModal").classList.add("open");
}

function closeModal() {
  document.getElementById("bookingModal").classList.remove("open");
}

function initBookingModal() {
  document.getElementById("bookingModal").addEventListener("click", (e) => {
    if (e.target === document.getElementById("bookingModal")) closeModal();
  });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeModal();
  });
  document
    .getElementById("submitBookingBtn")
    .addEventListener("click", submitBooking);
}

function submitBooking() {
  const name = document.getElementById("bk-name").value.trim();
  const date = document.getElementById("bk-date").value;
  const time = document.getElementById("bk-time").value;
  const phone = document.getElementById("bk-phone").value.trim();

  const phoneOk = phone.replace(/\D/, "").length >= 10;

  const errs = {
    "err-name": !name,
    "err-date": !date,
    "err-time": !time,
    "err-phone": !phoneOk,
  };
  const fields = {
    "err-name": "bk-name",
    "err-date": "bk-date",
    "err-time": "bk-time",
    "err-phone": "bk-phone",
  };

  let hasError = false;
  Object.entries(errs).forEach(([errId, bad]) => {
    document.getElementById(errId).classList.toggle("show", bad);
    document.getElementById(fields[errId]).classList.toggle("error", bad);
    if (bad) hasError = true;
  });
  if (hasError) return;

  const btn = document.getElementById("submitBookingBtn");
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting…';

  setTimeout(() => {
    const ref = "REF-" + Math.floor(1000000 + Math.random() * 9000000);
    document.getElementById("success-service").textContent =
      bookingTarget.serviceName;
    document.getElementById("success-ref").textContent = ref;
    document.getElementById("bookingForm").style.display = "none";
    document.getElementById("bookingSuccess").style.display = "block";
    btn.disabled = false;
    btn.innerHTML =
      '<i class="fa-regular fa-calendar-plus"></i> Confirm Appointment';
    showToast(`Appointment booked! Ref: ${ref}`, "success");
  }, 1500);
}

/* ═══════════════════════════════════════════════
   FOOTER LINKS & UTILS
═══════════════════════════════════════════════ */
function initFooterLinks() {
  document.querySelectorAll("[data-filter-link]").forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      document.getElementById("services-view").style.display = "block";
      document.getElementById("profile-view").style.display = "none";

      activeFilter = link.dataset.filterLink;
      searchQuery = "";
      document.getElementById("inlineSearch").value = "";
      document
        .querySelectorAll(".filter-btn")
        .forEach((b) => b.classList.remove("active"));
      const matchBtn = document.querySelector(
        `.filter-btn[data-filter="${activeFilter}"]`,
      );
      if (matchBtn) matchBtn.classList.add("active");
      render();
      window.scrollTo({ top: 0, behavior: "smooth" });
      setTimeout(() => {
        const el = document.getElementById("section-" + activeFilter);
        if (el) el.scrollIntoView({ behavior: "smooth", block: "start" });
      }, 200);
    });
  });
}

function animateCounters() {
  document.querySelectorAll("[data-count]").forEach((el) => {
    const target = +el.dataset.count;
    const suffix = el.dataset.count === "98" ? "%+" : "+";
    let current = 0;
    const step = Math.ceil(target / 60);
    const timer = setInterval(() => {
      current = Math.min(current + step, target);
      el.textContent = current + suffix;
      if (current >= target) clearInterval(timer);
    }, 20);
  });
}

function initBackToTop() {
  const btn = document.getElementById("backToTop");
  window.addEventListener("scroll", () => {
    btn.classList.toggle("show", window.scrollY > 400);
  });
  btn.addEventListener("click", () =>
    window.scrollTo({ top: 0, behavior: "smooth" }),
  );
}

function showToast(msg, type = "info") {
  const icons = {
    success: "fa-check",
    error: "fa-xmark",
    info: "fa-circle-info",
  };
  const t = document.createElement("div");
  t.className = `toast ${type}`;
  t.innerHTML = `<div class="toast-icon"><i class="fa-solid ${icons[type]}"></i></div><span>${msg}</span>`;
  document.getElementById("toast-container").appendChild(t);
  setTimeout(() => {
    t.classList.add("hide");
    setTimeout(() => t.remove(), 320);
  }, 3500);
}

/* ═══════════════════════════════════════════════
   INIT
═══════════════════════════════════════════════ */
document.addEventListener("DOMContentLoaded", () => {
  render();
  initNavigation();
  initProfileTabs();
  initFilters();
  initInlineSearch();
  initOverlaySearch();
  initBookingModal();
  initFooterLinks();
  initBackToTop();
  animateCounters();
});
