// address.js — Cascading address dropdowns (Region › Province › City › Barangay)

(function () {
  const PSGC = "https://psgc.gitlab.io/api";

  // ── State ─────────────────────────────────────────────────
  let selected = { region: null, province: null, city: null, barangay: null };
  let allItems = [];
  let activeStep = null; // 'region' | 'province' | 'city' | 'barangay'

  const STEPS = ["region", "province", "city", "barangay"];
  const STEP_LABELS = {
    region: "Region",
    province: "Province",
    city: "City / Municipality",
    barangay: "Barangay",
  };

  // ── DOM ───────────────────────────────────────────────────
  const wrapper = document.getElementById("addressWrapper");
  const pill = document.getElementById("addressPill");
  const pillText = document.getElementById("addressPillText");
  const dropdown = document.getElementById("addressDropdown");
  const searchBox = document.getElementById("addressSearch");
  const listEl = document.getElementById("addressList");

  // ── Init ──────────────────────────────────────────────────
  updatePillText();

  // ── Pill click → open current step ───────────────────────
  pill.addEventListener("click", () => {
    const step = getActiveStep();
    openStep(step);
  });

  function getActiveStep() {
    if (!selected.region) return "region";
    if (!selected.province) return "province";
    if (!selected.city) return "city";
    if (!selected.barangay) return "barangay";
    return "region"; // all done, clicking reopens region to change
  }

  // ── Open a step ───────────────────────────────────────────
  async function openStep(step) {
    activeStep = step;
    searchBox.value = "";
    searchBox.placeholder = `Search ${STEP_LABELS[step].toLowerCase()}…`;
    listEl.innerHTML = `<div class="addr-loading"><i class="fa-solid fa-spinner fa-spin"></i> Loading…</div>`;
    showDropdown();

    try {
      let data = [];

      if (step === "region") {
        data = await fetchJSON(`${PSGC}/regions/`);
      } else if (step === "province") {
        const provinces = await fetchJSON(
          `${PSGC}/regions/${selected.region.code}/provinces/`,
        );
        if (provinces.length > 0) {
          data = provinces;
        } else {
          // NCR — skip province, go to city
          selected.province = { code: selected.region.code, name: null };
          await openStep("city");
          return;
        }
      } else if (step === "city") {
        const base = selected.province?.name
          ? `${PSGC}/provinces/${selected.province.code}/cities-municipalities/`
          : `${PSGC}/regions/${selected.region.code}/cities-municipalities/`;
        data = await fetchJSON(base);
      } else if (step === "barangay") {
        data = await fetchJSON(
          `${PSGC}/cities-municipalities/${selected.city.code}/barangays/`,
        );
      }

      allItems = data.sort((a, b) => a.name.localeCompare(b.name));
      renderList(allItems);
    } catch (e) {
      listEl.innerHTML = `<div class="addr-no-result"><i class="fa-solid fa-circle-exclamation"></i> Failed to load. Try again.</div>`;
    }
  }

  // ── Render list ───────────────────────────────────────────
  function renderList(items) {
    listEl.innerHTML = "";

    if (items.length === 0) {
      listEl.innerHTML = `<div class="addr-no-result"><i class="fa-solid fa-circle-exclamation"></i> No results found</div>`;
      return;
    }

    items.forEach((item) => {
      const div = document.createElement("div");
      div.className = "addr-item";
      div.textContent = item.name;
      div.addEventListener("mousedown", (e) => {
        e.preventDefault();
        pickItem(item);
      });
      listEl.appendChild(div);
    });
  }

  // ── Pick item ─────────────────────────────────────────────
  async function pickItem(item) {
    selected[activeStep] = item;

    // Reset downstream
    const idx = STEPS.indexOf(activeStep);
    for (let i = idx + 1; i < STEPS.length; i++) {
      selected[STEPS[i]] = null;
    }

    updatePillText();

    // Advance to next step
    const next = STEPS[idx + 1];
    if (next) {
      await openStep(next);
    } else {
      hideDropdown();
    }
  }

  // ── Update pill text ──────────────────────────────────────
  function updatePillText() {
    const parts = STEPS.map((k) => selected[k]?.name).filter(Boolean);
    if (parts.length === 0) {
      pillText.textContent = "Region / Province / City / Barangay";
      pillText.classList.add("placeholder");
    } else {
      pillText.textContent = parts.join(" / ");
      pillText.classList.remove("placeholder");
    }
  }

  // ── Search filter ─────────────────────────────────────────
  searchBox.addEventListener("input", () => {
    const q = searchBox.value.toLowerCase().trim();
    renderList(
      q ? allItems.filter((i) => i.name.toLowerCase().includes(q)) : allItems,
    );
  });

  // ── Show / hide dropdown ──────────────────────────────────
  function showDropdown() {
    dropdown.classList.add("open");
    pill.classList.add("active");
    setTimeout(() => searchBox.focus(), 50);
  }

  function hideDropdown() {
    dropdown.classList.remove("open");
    pill.classList.remove("active");
    activeStep = null;
  }

  document.addEventListener("click", (e) => {
    if (!wrapper.contains(e.target)) hideDropdown();
  });

  searchBox.addEventListener("keydown", (e) => {
    if (e.key === "Escape") hideDropdown();
  });

  // ── Fetch helper ──────────────────────────────────────────
  async function fetchJSON(url) {
    const res = await fetch(url);
    return res.json();
  }
})();
