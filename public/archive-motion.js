/* Bulutla motion layer.
   1. Applies the motion preference to every stylesheet: when motion is ON the
      `prefers-reduced-motion: reduce` blocks are dropped and the
      `no-preference` blocks always apply; when it is OFF the opposite. This is
      page code: the scrollcraft engine files stay untouched.
   2. Wires the footer switch (remembered in localStorage, reload to apply).
   3. Mounts the scrollcraft engine.
   4. Small Livewire-safe extras for working surfaces: count-up on real
      numbers. Entrances on Livewire pages are CSS keyframes, so a morph never
      re-hides content. */
(function () {
  'use strict';
  var docEl = document.documentElement;
  var on = docEl.getAttribute('data-motion') !== 'off';
  var RM = /\(\s*prefers-reduced-motion\s*:\s*(reduce|no-preference)\s*\)/i;

  function rewrite(sheet) {
    var rules;
    try { rules = sheet.cssRules; } catch (e) { return; }
    if (!rules) return;
    for (var i = rules.length - 1; i >= 0; i--) {
      var r = rules[i];
      if (!r.media || !r.cssRules) continue;
      var text = r.media.mediaText;
      var m = text.match(RM);
      if (!m) continue;
      var applies = m[1].toLowerCase() === 'reduce' ? !on : on;
      var rest = text.replace(RM, '').replace(/^\s*and\s+|\s+and\s*$/gi, '').replace(/\s+and\s+and\s+/gi, ' and ').trim();
      var inner = '';
      for (var j = 0; j < r.cssRules.length; j++) inner += r.cssRules[j].cssText;
      sheet.deleteRule(i);
      if (applies) {
        try { sheet.insertRule('@media ' + (rest || 'all') + '{' + inner + '}', i); } catch (e) {}
      }
    }
  }
  for (var s = 0; s < document.styleSheets.length; s++) rewrite(document.styleSheets[s]);

  var sw = document.querySelector('[data-motion-switch]');
  if (sw) {
    sw.setAttribute('aria-pressed', String(on));
    sw.querySelector('b').textContent = on ? 'Açık' : 'Kapalı';
    sw.addEventListener('click', function () {
      try { localStorage.setItem('bulutla-motion', on ? 'off' : 'on'); } catch (e) {}
      location.reload();
    });
  }

  if (window.ScrollCraft) window.ScrollCraft.mount(document.body);

  // Count-up for real numbers on working surfaces: <span data-tick>123</span>.
  // Uses the number already rendered by the server, so the final value is
  // always the true one and a Livewire morph simply re-writes it.
  // The number sits at 0 from first paint and ticks up to the real value once,
  // in a fixed time, when it comes into view. Scroll position never drives it.
  function prepare(el) {
    var raw = el.textContent.trim();
    var m = raw.match(/^([^\d-]*)(-?[\d.,]+)(.*)$/);
    if (!m) return null;
    var src = m[2];
    var trDecimal = /,\d{1,2}$/.test(src);
    var num = parseFloat(trDecimal ? src.replace(/\./g, '').replace(',', '.') : src.replace(/,/g, ''));
    if (!isFinite(num) || num === 0) return null;
    var dec = (trDecimal ? src.split(',')[1] : (src.split('.')[1] || '')).length;
    var fmt = function (v) {
      var s = v.toFixed(dec);
      if (trDecimal) { var p = s.split('.'); s = p[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.') + (p[1] ? ',' + p[1] : ''); }
      return m[1] + s + m[3];
    };
    el.textContent = fmt(0);
    return function run() {
      var t0 = 0, dur = 1400, done = false;
      function step(t) {
        if (done) return;
        if (!t0) t0 = t;
        var k = Math.min(1, (t - t0) / dur);
        var e = 1 - Math.pow(1 - k, 3);
        el.textContent = k < 1 ? fmt(num * e) : raw;
        if (k < 1) requestAnimationFrame(step);
      }
      requestAnimationFrame(step);
      // If frames are paused (background tab), still land on the true value.
      setTimeout(function () { done = true; el.textContent = raw; }, dur + 120);
    };
  }
  if (on && 'IntersectionObserver' in window) {
    var runs = new Map();
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (e) {
        if (e.intersectionRatio >= 0.5 && runs.has(e.target)) {
          io.unobserve(e.target);
          runs.get(e.target)();
          runs.delete(e.target);
        }
      });
    }, { threshold: [0.5] });
    document.querySelectorAll('[data-tick]').forEach(function (el) {
      var run = prepare(el);
      if (run) { runs.set(el, run); io.observe(el); }
    });
    // Safety net: if the observer never reports (some embedded or throttled
    // views), any counter already on screen still reaches its real value.
    setTimeout(function () {
      runs.forEach(function (run, el) {
        var r = el.getBoundingClientRect();
        if (r.bottom > 0 && r.top < innerHeight) { io.unobserve(el); run(); runs.delete(el); }
      });
    }, 3000);
  }

  // Header: a pill slides to the hovered link and rests on the current page;
  // the bar slips away while scrolling down and returns on any scroll up.
  var header = document.querySelector('[data-site-header]');
  var links = document.querySelector('[data-nav-links]');
  if (links) {
    var ind = links.querySelector('.nav-ind');
    var current = links.querySelector('a.active');
    var place = function (a) {
      if (!a) { ind.classList.remove('is-ready'); return; }
      // Measure the <li>, not the link: while the entrance animation runs the
      // <li> carries a transform, becomes the link's offsetParent, and the
      // link's own offsetLeft reads 0, parking the pill on the first item.
      var li = a.parentElement;
      ind.style.setProperty('--x', li.offsetLeft + 'px');
      ind.style.setProperty('--w', li.offsetWidth + 'px');
      // First placement lands without a slide; only later moves glide.
      if (!ind.classList.contains('is-ready')) {
        ind.getBoundingClientRect();   // flush styles so the first position is not transitioned
        ind.classList.add('is-ready');
      }
    };
    var rest = function () { place(current); };
    links.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('pointerenter', function () { place(a); });
      a.addEventListener('focus', function () { place(a); });
    });
    links.addEventListener('pointerleave', rest);
    links.addEventListener('focusout', function (e) { if (!links.contains(e.relatedTarget)) rest(); });
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(rest);
    window.addEventListener('load', rest);
    if ('ResizeObserver' in window) new ResizeObserver(rest).observe(links);
    else window.addEventListener('resize', rest);
    rest();
  }
  if (header) {
    var lastY = scrollY, ticking = false;
    var update = function () {
      ticking = false;
      var y = scrollY, dy = y - lastY;
      header.classList.toggle('is-scrolled', y > 8);
      if (y < 120 || dy < -4) header.classList.remove('is-hidden');
      else if (dy > 6 && !header.contains(document.activeElement)) header.classList.add('is-hidden');
      if (Math.abs(dy) > 4) lastY = y;
    };
    window.addEventListener('scroll', function () {
      if (!ticking) { ticking = true; requestAnimationFrame(update); }
    }, { passive: true });
    header.addEventListener('focusin', function () { header.classList.remove('is-hidden'); });
    update();
  }

  var up = document.querySelector('[data-to-top]');
  if (up) up.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: on ? 'smooth' : 'auto' });
  });

  // Auth folder and other pointer-depth stages: publish --mx / --my (-1..1),
  // interpolated so the planes carry momentum instead of tracking the cursor.
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  document.querySelectorAll('[data-depth]').forEach(function (stage) {
    if (!on || !fine) return;
    var tx = 0, ty = 0, cx = 0, cy = 0, raf = 0;
    function loop() {
      cx += (tx - cx) * 0.08; cy += (ty - cy) * 0.08;
      stage.style.setProperty('--mx', cx.toFixed(4));
      stage.style.setProperty('--my', cy.toFixed(4));
      raf = (Math.abs(tx - cx) + Math.abs(ty - cy) > 0.001) ? requestAnimationFrame(loop) : 0;
    }
    window.addEventListener('pointermove', function (ev) {
      tx = ev.clientX / innerWidth * 2 - 1;
      ty = ev.clientY / innerHeight * 2 - 1;
      if (!raf) raf = requestAnimationFrame(loop);
    }, { passive: true });
  });
})();
