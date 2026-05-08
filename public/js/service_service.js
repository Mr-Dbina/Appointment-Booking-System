(function () {
  const GAP = 18;

  const track = document.getElementById("carouselTrack");
  const prevBtn = document.getElementById("prevBtn");
  const nextBtn = document.getElementById("nextBtn");
  const dotsWrap = document.getElementById("dotsContainer");

  if (!track || !prevBtn || !nextBtn || !dotsWrap) {
    console.error("Carousel: one or more required elements not found.");
    return;
  }

  const originals = Array.from(track.querySelectorAll(".service-card"));
  const TOTAL = originals.length;

  let current = 0;
  let busy = false;

  function getVis() {
    const w = track.parentElement.offsetWidth;
    return w < 601 ? 1 : w < 861 ? 2 : 3;
  }

  function cardWidth() {
    const real = track.querySelector(".service-card:not(.clone)");
    return real ? real.offsetWidth : 0;
  }

  function render() {
    track.innerHTML = "";
    const vis = getVis();

    originals.slice(-vis).forEach((c) => {
      const cl = c.cloneNode(true);
      cl.classList.add("clone");
      track.appendChild(cl);
    });

    originals.forEach((c) => track.appendChild(c.cloneNode(true)));

    originals.slice(0, vis).forEach((c) => {
      const cl = c.cloneNode(true);
      cl.classList.add("clone");
      track.appendChild(cl);
    });

    buildDots();
    setPos(current, false);
  }

  function setPos(idx, animate) {
    const vis = getVis();
    const cw = cardWidth();
    const offset = (idx + vis) * (cw + GAP);
    track.style.transition = animate
      ? "transform 0.42s cubic-bezier(0.4,0,0.2,1)"
      : "none";
    track.style.transform = `translateX(-${offset}px)`;
  }

  function buildDots() {
    dotsWrap.innerHTML = "";
    originals.forEach((_, i) => {
      const d = document.createElement("div");
      d.className = "dot" + (i === current ? " active" : "");
      d.addEventListener("click", () => {
        if (!busy) goTo(i);
      });
      dotsWrap.appendChild(d);
    });
  }

  function updateDots() {
    const idx = ((current % TOTAL) + TOTAL) % TOTAL;
    dotsWrap
      .querySelectorAll(".dot")
      .forEach((d, i) => d.classList.toggle("active", i === idx));
  }

  function goTo(idx) {
    current = ((idx % TOTAL) + TOTAL) % TOTAL;
    setPos(current, true);
    updateDots();
  }

  function step(dir) {
    if (busy) return;
    busy = true;

    current += dir;
    setPos(current, true);
    updateDots();

    track.addEventListener(
      "transitionend",
      function onEnd() {
        track.removeEventListener("transitionend", onEnd);
        if (current >= TOTAL) {
          current -= TOTAL;
          setPos(current, false);
        } else if (current < 0) {
          current += TOTAL;
          setPos(current, false);
        }
        updateDots();
        busy = false;
      },
      { once: true },
    );
  }

  let startX = 0;
  let startY = 0;
  let diffX = 0;
  let dragging = false;
  let scrollLock = false; 
  const THRESHOLD = 50;

  function onDragStart(x, y) {
    if (busy) return;
    startX = x;
    startY = y;
    diffX = 0;
    dragging = true;
    scrollLock = false;
    track.style.transition = "none";
  }

  function onDragMove(x, y) {
    if (!dragging) return;
    diffX = x - startX;
    const diffY = y - startY;

    if (!scrollLock && (Math.abs(diffX) > 8 || Math.abs(diffY) > 8)) {
      scrollLock = Math.abs(diffX) >= Math.abs(diffY);
      if (!scrollLock) {
        dragging = false;
        return;
      } 
    }
    if (!scrollLock) return;

    const vis = getVis();
    const cw = cardWidth();
    const base = (current + vis) * (cw + GAP);
    track.style.transform = `translateX(-${base - diffX}px)`;
  }

  function onDragEnd() {
    if (!dragging) return;
    dragging = false;
    if (!scrollLock) return;

    if (diffX < -THRESHOLD) step(1);
    else if (diffX > THRESHOLD) step(-1);
    else setPos(current, true); /* snap back */
  }

  track.addEventListener(
    "touchstart",
    (e) => onDragStart(e.touches[0].clientX, e.touches[0].clientY),
    { passive: true },
  );
  track.addEventListener(
    "touchmove",
    (e) => {
      onDragMove(e.touches[0].clientX, e.touches[0].clientY);
      if (scrollLock) e.preventDefault(); /* block page-scroll while swiping */
    },
    { passive: false },
  );
  track.addEventListener("touchend", onDragEnd);

  track.addEventListener("mousedown", (e) => {
    onDragStart(e.clientX, e.clientY);
    track.style.cursor = "grabbing";
  });
  window.addEventListener("mousemove", (e) => {
    if (dragging) onDragMove(e.clientX, e.clientY);
  });
  window.addEventListener("mouseup", () => {
    onDragEnd();
    track.style.cursor = "";
  });

  prevBtn.addEventListener("click", () => step(-1));
  nextBtn.addEventListener("click", () => step(1));

  let resizeTimer;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      const saved = current;
      render();
      current = saved;
      setPos(current, false);
      updateDots();
    }, 120);
  });

  render();
})();
