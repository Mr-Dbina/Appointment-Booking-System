// address.js — Philippine cascading address dropdowns using PSGC API

const PSGC = "https://psgc.gitlab.io/api";

// ── Helpers ───────────────────────────────────────────────
async function fetchJSON(url) {
  const res = await fetch(url);
  return res.json();
}

function populateSelect(id, items, labelKey, valueKey, placeholder) {
  const sel = document.getElementById(id);
  sel.innerHTML = `<option value="" disabled selected>${placeholder}</option>`;
  items
    .sort((a, b) => a[labelKey].localeCompare(b[labelKey]))
    .forEach((item) => {
      const opt = document.createElement("option");
      opt.value = item[valueKey];
      opt.textContent = item[labelKey];
      sel.appendChild(opt);
    });
  sel.disabled = false;
  sel.classList.add("unselected");
}

function resetSelect(id, placeholder) {
  const sel = document.getElementById(id);
  sel.innerHTML = `<option value="" disabled selected>${placeholder}</option>`;
  sel.disabled = true;
  sel.classList.add("unselected");
}

// ── Load Regions on page load ─────────────────────────────
(async function loadRegions() {
  try {
    const regions = await fetchJSON(`${PSGC}/regions/`);
    populateSelect("region", regions, "name", "code", "Region");
  } catch (e) {
    console.error("Failed to load regions", e);
  }
})();

// ── Region → Province ─────────────────────────────────────
window.onRegionChange = async function () {
  const code = document.getElementById("region").value;
  document.getElementById("region").classList.remove("unselected");
  resetSelect("province", "Province");
  resetSelect("city", "City / Municipality");
  resetSelect("barangay", "Barangay");

  try {
    const provinces = await fetchJSON(`${PSGC}/regions/${code}/provinces/`);
    if (provinces.length > 0) {
      populateSelect("province", provinces, "name", "code", "Province");
    } else {
      // Some regions have no provinces (e.g. NCR) — load cities directly
      const cities = await fetchJSON(
        `${PSGC}/regions/${code}/cities-municipalities/`,
      );
      populateSelect("city", cities, "name", "code", "City / Municipality");
      resetSelect("province", "No Province (NCR)");
      document.getElementById("province").disabled = true;
    }
  } catch (e) {
    console.error("Failed to load provinces", e);
  }
};

// ── Province → City/Municipality ──────────────────────────
window.onProvinceChange = async function () {
  const code = document.getElementById("province").value;
  document.getElementById("province").classList.remove("unselected");
  resetSelect("city", "City / Municipality");
  resetSelect("barangay", "Barangay");

  try {
    const cities = await fetchJSON(
      `${PSGC}/provinces/${code}/cities-municipalities/`,
    );
    populateSelect("city", cities, "name", "code", "City / Municipality");
  } catch (e) {
    console.error("Failed to load cities", e);
  }
};

// ── City → Barangay ───────────────────────────────────────
window.onCityChange = async function () {
  const code = document.getElementById("city").value;
  document.getElementById("city").classList.remove("unselected");
  resetSelect("barangay", "Barangay");

  try {
    const brgys = await fetchJSON(
      `${PSGC}/cities-municipalities/${code}/barangays/`,
    );
    populateSelect("barangay", brgys, "name", "code", "Barangay");
  } catch (e) {
    console.error("Failed to load barangays", e);
  }
};
