(function () {
  const PSGC = "https://psgc.gitlab.io/api";

  let step = 0;
  let selected = { region: null, province: null, city: null, barangay: null };
  let allItems = [];
  let isOpen = false;

  const STEPS = ["region", "province", "city", "barangay"];
  const LABELS = ["Region", "Province", "City / Municipality", "Barangay"];
  const ICONS = ["earth-asia", "map", "city", "house"];

  const wrapper = document.getElementById("addressWrapper");
  const pill = document.getElementById("addressPill");
  const pillText = document.getElementById("addressPillText");
  const dropdown = document.getElementById("addressDropdown");
  const searchInput = document.getElementById("addressSearch");
  const list = document.getElementById("addressList");
  const hidden = {
    region: document.getElementById("hiddenRegion"),
    province: document.getElementById("hiddenProvince"),
    city: document.getElementById("hiddenCity"),
    barangay: document.getElementById("hiddenBarangay"),
  };

  loadStep(0);

  async function fetchJSON(url) {
    const res = await fetch(url);
    return res.json();
  }

  async function loadStep(s) {
    step = s;
    allItems = [];
    searchInput.value = "";
    searchInput.placeholder = `Search ${LABELS[s].toLowerCase()}…`;
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
      list.innerHTML = `<div class="addr-no-result">
        <i class="fa-solid fa-circle-exclamation"></i> Failed to load. Try again.
      </div>`;
    }
  }

  function renderList(items) {
    list.innerHTML = "";

    const header = document.createElement("div");
    header.className = "addr-step-header";
    header.innerHTML = `<i class="fa-solid fa-${ICONS[step]}"></i> Select ${LABELS[step]}`;
    list.appendChild(header);

    if (items.length === 0) {
      const none = document.createElement("div");
      none.className = "addr-no-result";
      none.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i> No results found`;
      list.appendChild(none);
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
      list.appendChild(div);
    });
  }

  function showLoading() {
    list.innerHTML = `<div class="addr-loading">
      <i class="fa-solid fa-spinner fa-spin"></i> Loading ${LABELS[step].toLowerCase()}…
    </div>`;
  }

  async function pickItem(item) {
    selected[STEPS[step]] = item;
    hidden[STEPS[step]].value = item.name;
    searchInput.value = "";
    updatePillText();

    if (step < 3) {
      await loadStep(step + 1);
    } else {
      closeDropdown();
    }
  }

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

  pill.addEventListener("click", (e) => {
    e.stopPropagation();
    isOpen ? closeDropdown() : openDropdown();
  });

  function openDropdown() {
    dropdown.classList.add("open");
    wrapper.classList.add("focused");
    isOpen = true;
    searchInput.focus();
  }

  function closeDropdown() {
    dropdown.classList.remove("open");
    wrapper.classList.remove("focused");
    isOpen = false;
  }

  document.addEventListener("click", (e) => {
    if (!wrapper.contains(e.target)) closeDropdown();
  });

  searchInput.addEventListener("input", () => {
    const q = searchInput.value.toLowerCase().trim();
    const hits = q
      ? allItems.filter((i) => i.name.toLowerCase().includes(q))
      : allItems;
    renderList(hits);
  });

  searchInput.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeDropdown();
  });
})();
