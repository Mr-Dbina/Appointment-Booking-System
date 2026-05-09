(function () {
  const GAP = 18;

  const track = document.getElementById("carouselTrack");
  const dotsWrap = document.getElementById("dotsContainer");

  if (!track || !dotsWrap) {
    console.error("Carousel: required elements not found.");
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

  function getBase() {
    return (current + getVis()) * (cardWidth() + GAP);
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
    const offset = (idx + getVis()) * (cardWidth() + GAP);
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

  function clampLoop() {
    if (current >= TOTAL) {
      current -= TOTAL;
      setPos(current, false);
    } else if (current < 0) {
      current += TOTAL;
      setPos(current, false);
    }
    updateDots();
    busy = false;
  }

  let startX = 0,
    startY = 0,
    curX = 0;
  let dragging = false,
    scrollLock = false;
  const THRESHOLD = 40;

  function onDragStart(x, y) {
    if (busy) return;
    startX = x;
    startY = y;
    curX = x;
    dragging = true;
    scrollLock = false;
    track.style.transition = "none";
  }

  function onDragMove(x, y) {
    if (!dragging) return;
    curX = x;
    const dx = x - startX,
      dy = y - startY;

    if (!scrollLock && (Math.abs(dx) > 6 || Math.abs(dy) > 6)) {
      if (Math.abs(dx) >= Math.abs(dy)) {
        scrollLock = true;
      } else {
        dragging = false;
        return;
      }
    }

    if (!scrollLock) return;
    track.style.transform = `translateX(-${getBase() - dx}px)`;
  }

  function onDragEnd() {
    if (!dragging) return;
    dragging = false;
    if (!scrollLock) return;

    const dx = curX - startX;

    if (Math.abs(dx) < THRESHOLD) {
      setPos(current, true);
      return;
    }

    busy = true;
    current += dx < 0 ? 1 : -1;
    setPos(current, true);
    updateDots();

    track.addEventListener("transitionend", clampLoop, { once: true });
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
      if (scrollLock) e.preventDefault();
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
