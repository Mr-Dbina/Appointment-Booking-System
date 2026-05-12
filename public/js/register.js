// address.js — Fused single-input cascading address picker (Region › Province › City › Barangay)

(function () {
  const PSGC = "https://psgc.gitlab.io/api";

  // ── State ─────────────────────────────────────────────────
  let step = 0; // 0=region, 1=province, 2=city, 3=barangay
  let selected = { region: null, province: null, city: null, barangay: null };
  let allItems = [];
  let isOpen = false;

  const STEPS = ["region", "province", "city", "barangay"];
  const LABELS = ["Region", "Province", "City / Municipality", "Barangay"];
  const ICONS = ["earth-asia", "map", "city", "house"];

  // ── DOM refs ──────────────────────────────────────────────
  const wrapper = document.getElementById("addressWrapper");
  const display = document.getElementById("addressDisplay");
  const input = document.getElementById("addressInput");
  const dropdown = document.getElementById("addressDropdown");
  const clearBtn = document.getElementById("addressClear");
  const hidden = {
    region: document.getElementById("hiddenRegion"),
    province: document.getElementById("hiddenProvince"),
    city: document.getElementById("hiddenCity"),
    barangay: document.getElementById("hiddenBarangay"),
  };

  // ── Bootstrap ─────────────────────────────────────────────
  loadStep(0);

  // ── Fetch helper ─────────────────────────────────────────
  async function fetchJSON(url) {
    const res = await fetch(url);
    return res.json();
  }

  // ── Load data for current step ────────────────────────────
  async function loadStep(s) {
    step = s;
    allItems = [];
    input.placeholder = `Search ${LABELS[s].toLowerCase()}…`;
    showLoading();

    try {
      let data = [];

      if (s === 0) {
        data = await fetchJSON(`${PSGC}/regions/`);
      } else if (s === 1) {
        const provinces = await fetchJSON(
          `${PSGC}/regions/${selected.region.code}/provinces/`,
        );
        if (provinces.length > 0) {
          data = provinces;
        } else {
          // NCR: no provinces — skip straight to cities
          selected.province = { code: selected.region.code, name: null };
          hidden.province.value = "";
          await loadStep(2);
          return;
        }
      } else if (s === 2) {
        const base = selected.province?.name
          ? `${PSGC}/provinces/${selected.province.code}/cities-municipalities/`
          : `${PSGC}/regions/${selected.region.code}/cities-municipalities/`;
        data = await fetchJSON(base);
      } else if (s === 3) {
        data = await fetchJSON(
          `${PSGC}/cities-municipalities/${selected.city.code}/barangays/`,
        );
      }

      allItems = data.sort((a, b) => a.name.localeCompare(b.name));
      renderList(allItems);
    } catch (e) {
      console.error("PSGC error", e);
      dropdown.innerHTML = `<div class="addr-no-result"><i class="fa-solid fa-circle-exclamation"></i> Failed to load. Try again.</div>`;
    }
  }

  // ── Render dropdown list ──────────────────────────────────
  function renderList(items) {
    dropdown.innerHTML = "";

    const header = document.createElement("div");
    header.className = "addr-step-header";
    header.innerHTML = `<i class="fa-solid fa-${ICONS[step]}"></i> Select ${LABELS[step]}`;
    dropdown.appendChild(header);

    if (items.length === 0) {
      const none = document.createElement("div");
      none.className = "addr-no-result";
      none.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i> No results found`;
      dropdown.appendChild(none);
      openDropdown();
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
      dropdown.appendChild(div);
    });

    openDropdown();
  }

  function showLoading() {
    dropdown.innerHTML = `<div class="addr-loading"><i class="fa-solid fa-spinner fa-spin"></i> Loading ${LABELS[step].toLowerCase()}…</div>`;
    openDropdown();
  }

  // ── Pick an item ──────────────────────────────────────────
  async function pickItem(item) {
    selected[STEPS[step]] = item;
    hidden[STEPS[step]].value = item.name;
    input.value = "";
    updateChips();

    if (step < 3) {
      await loadStep(step + 1);
    } else {
      // Complete
      hideDropdown();
      input.blur();
      input.placeholder = "";
    }
  }

  // ── Chips display ─────────────────────────────────────────
  function updateChips() {
    const parts = STEPS.map((k) => selected[k]?.name).filter(Boolean);

    if (parts.length === 0) {
      display.style.display = "none";
      clearBtn.style.display = "none";
      return;
    }

    display.style.display = "flex";
    clearBtn.style.display = "flex";
    display.innerHTML = parts
      .map((p, i) => {
        const isLast = i === parts.length - 1;
        return (
          `<span class="addr-chip${isLast ? " addr-chip-active" : ""}" data-idx="${i}">${p}</span>` +
          (!isLast ? `<i class="fa-solid fa-chevron-right addr-sep"></i>` : "")
        );
      })
      .join("");
  }

  // Click a chip to jump back to that step
  display.addEventListener("click", (e) => {
    const chip = e.target.closest(".addr-chip");
    if (!chip) return;
    const idx = parseInt(chip.dataset.idx);
    for (let i = idx; i < STEPS.length; i++) {
      selected[STEPS[i]] = null;
      hidden[STEPS[i]].value = "";
    }
    updateChips();
    input.value = "";
    loadStep(idx);
    input.focus();
  });

  // ── Input typing filter ───────────────────────────────────
  input.addEventListener("input", () => {
    const q = input.value.toLowerCase().trim();
    const list = q
      ? allItems.filter((i) => i.name.toLowerCase().includes(q))
      : allItems;
    renderList(list);
  });

  input.addEventListener("focus", () => {
    if (allItems.length) renderList(allItems);
  });

  input.addEventListener("keydown", (e) => {
    if (e.key === "Escape") hideDropdown();
  });

  // Click anywhere on wrapper to focus
  wrapper.addEventListener("click", (e) => {
    if (clearBtn.contains(e.target)) return;
    input.focus();
    if (allItems.length && !isOpen) renderList(allItems);
  });

  // ── Clear all ─────────────────────────────────────────────
  clearBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    selected = { region: null, province: null, city: null, barangay: null };
    Object.values(hidden).forEach((h) => (h.value = ""));
    input.value = "";
    updateChips();
    loadStep(0);
    input.focus();
  });

  // ── Open / hide ───────────────────────────────────────────
  function openDropdown() {
    dropdown.classList.add("open");
    isOpen = true;
    wrapper.classList.add("focused");
  }

  function hideDropdown() {
    dropdown.classList.remove("open");
    isOpen = false;
    wrapper.classList.remove("focused");
  }

  document.addEventListener("click", (e) => {
    if (!wrapper.contains(e.target)) hideDropdown();
  });
})();
