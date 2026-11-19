/* Home page, bespoke choreography (the engine stays untouched).
   - Smoothing: the engine publishes --sc-p straight from scroll, so a mouse
     wheel moves it in 100px steps. Every plane on the hero and every file in
     the filing act reads --sp instead: the same progress, eased toward the
     engine value with a time-based exponential, so steps become glides.
   - Hero: the [data-hx-pointer] stage gets --mx / --my for pointer depth.
   - Signature move, "Dosyalama": the loose files fly into the folder from CSS
     alone; this script keeps the folder tab's count honest. */
(function () {
  'use strict';
  var on = document.documentElement.getAttribute('data-motion') !== 'off';
  var fine = matchMedia('(hover: hover) and (pointer: fine)').matches;

  // ---- smoothed progress, only while an act is near the viewport ----------
  var acts = [].map.call(document.querySelectorAll('.hx, .px'), function (el) {
    return { el: el, cur: -1, live: false };
  });
  var filing = document.querySelector('[data-filing]');
  var label = filing && filing.querySelector('[data-filing-count]');
  var total = filing ? +filing.getAttribute('data-filing-total') || 0 : 0;
  var starts = filing ? [].map.call(filing.querySelectorAll('.px-file'), function (f) {
    return parseFloat(f.style.getPropertyValue('--s')) || 0;
  }) : [];
  var FLIGHT = 0.16, lastCount = -1;

  function count(p) {
    if (!label) return;
    var n = 0;
    for (var i = 0; i < starts.length; i++) if (p >= starts[i] + FLIGHT * 0.9) n++;
    if (!on) n = total;
    if (n !== lastCount) {
      lastCount = n;
      label.textContent = n + ' / ' + total + ' dosya';
      filing.classList.toggle('is-filed', n === total);
    }
  }

  var raf = 0, prev = 0, lastScroll = 0;
  function frame(t) {
    var dt = prev ? Math.min(64, t - prev) : 16;
    prev = t;
    var k = 1 - Math.exp(-dt / 110);   // ~110ms time constant: soft, never laggy
    var busy = false;
    for (var i = 0; i < acts.length; i++) {
      var a = acts[i];
      if (!a.live) continue;
      var target = parseFloat(a.el.style.getPropertyValue('--sc-p')) || 0;
      if (a.cur < 0 || !on) a.cur = target;
      else a.cur += (target - a.cur) * k;
      if (Math.abs(target - a.cur) < 0.0004) a.cur = target; else busy = true;
      a.el.style.setProperty('--sp', a.cur.toFixed(4));
      if (a.el === filing) count(a.cur);
    }
    raf = 0;
    // keep running while gliding, and briefly after the last scroll so the
    // engine's fresh --sc-p is always picked up; then sleep.
    if (busy || t - lastScroll < 250) raf = requestAnimationFrame(frame);
    else prev = 0;
  }
  function wake() { if (!raf) { prev = 0; raf = requestAnimationFrame(frame); } }

  addEventListener('scroll', function () { lastScroll = performance.now(); wake(); }, { passive: true });
  addEventListener('resize', wake);

  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (e) {
        acts.forEach(function (a) { if (a.el === e.target) a.live = e.isIntersecting; });
      });
      wake();
    }, { rootMargin: '25% 0px' });
    acts.forEach(function (a) { io.observe(a.el); });
  } else {
    acts.forEach(function (a) { a.live = true; });
    wake();
  }
  if (!on) { acts.forEach(function (a) { a.live = true; }); count(1); }

  // ---- hero pointer depth --------------------------------------------------
  var hero = document.querySelector('[data-hx-pointer]');
  if (hero && on && fine) {
    var tx = 0, ty = 0, cx = 0, cy = 0, praf = 0, pprev = 0;
    var loop = function (t) {
      var dt = pprev ? Math.min(64, t - pprev) : 16;
      pprev = t;
      var k = 1 - Math.exp(-dt / 140);
      cx += (tx - cx) * k; cy += (ty - cy) * k;
      hero.style.setProperty('--mx', cx.toFixed(4));
      hero.style.setProperty('--my', cy.toFixed(4));
      praf = (Math.abs(tx - cx) + Math.abs(ty - cy) > 0.001) ? requestAnimationFrame(loop) : 0;
      if (!praf) pprev = 0;
    };
    hero.addEventListener('pointermove', function (e) {
      var r = hero.getBoundingClientRect();
      tx = (e.clientX - r.left) / r.width * 2 - 1;
      ty = (e.clientY - r.top) / r.height * 2 - 1;
      if (!praf) praf = requestAnimationFrame(loop);
    }, { passive: true });
    hero.addEventListener('pointerleave', function () { tx = ty = 0; if (!praf) praf = requestAnimationFrame(loop); });
  }
})();
