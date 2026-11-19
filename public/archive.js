(() => {
    const story = document.querySelector('.archive-story');
    if (!story) return;
    const stage = story.querySelector('.archive-stage');
    const button = story.querySelector('button');
    const desktop = matchMedia('(min-width:841px) and (min-height:540px) and (prefers-reduced-motion:no-preference)');
    let value = 0, target = 0, frame = 0, previous = 0, start = 0, distance = 1;
    function paint() {
        stage.style.setProperty('--open', value.toFixed(4));
        const expanded = value > .5;
        if (button.getAttribute('aria-expanded') !== String(expanded)) {
            button.setAttribute('aria-expanded', String(expanded));
            button.firstChild.nodeValue = expanded ? 'Klasörü kapat ' : 'Klasörü aç ';
        }
    }
    function tick(time) {
        value += (target - value) * -Math.expm1(-(time - previous) / 72);
        previous = time;
        if (Math.abs(target - value) < .001) value = target;
        paint();
        frame = value === target ? 0 : requestAnimationFrame(tick);
    }
    function scroll() {
        if (!desktop.matches) return;
        target = Math.max(0, Math.min(1, (scrollY - start) / distance));
        if (!frame && value !== target) {
            previous = performance.now();
            frame = requestAnimationFrame(tick);
        }
    }
    function measure() {
        const rect = story.getBoundingClientRect();
        start = rect.top + scrollY - document.querySelector('header.site').offsetHeight;
        distance = Math.max(1, rect.height - stage.offsetHeight);
        scroll();
    }
    function configure() {
        cancelAnimationFrame(frame);
        frame = 0;
        story.classList.toggle('tracking', desktop.matches);
        if (!desktop.matches) { target = value = 0; paint(); }
        measure();
    }
    button.hidden = false;
    button.addEventListener('click', () => {
        const open = target < .5;
        if (desktop.matches) window.scrollTo({ top: start + (open ? distance : 0), behavior: 'smooth' });
        else { value = target = Number(open); paint(); }
    });
    window.addEventListener('scroll', scroll, { passive: true });
    desktop.addEventListener('change', configure);
    new ResizeObserver(measure).observe(stage);
    configure();
})();
