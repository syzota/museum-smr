(function () {
  if (typeof anime === 'undefined') {
    console.warn('[scroll-fade-in] Anime.js belum dimuat.');
    return;
  }

  const DURATION = 820;
  const BASE_DELAY = 0;
  const STAGGER = 110;
  const EASING = 'easeOutExpo';
  const THRESHOLD = 0.05;

  const PRESETS = {
    'scroll-fade-in': {
      from: { opacity: 0, translateY: 30 },
      to:   { opacity: 1, translateY: 0 }
    },
    'scroll-fade-in-left': {
      from: { opacity: 0, translateX: -40 },
      to:   { opacity: 1, translateX: 0 }
    },
    'scroll-fade-in-right': {
      from: { opacity: 0, translateX: 40 },
      to:   { opacity: 1, translateX: 0 }
    },
    'scroll-fade-in-zoom': {
      from: { opacity: 0, scale: 0.82 },
      to:   { opacity: 1, scale: 1 }
    }
  };

  const selector = Object.keys(PRESETS).map(c => '.' + c).join(', ');
  const elements = document.querySelectorAll(selector);

  if (!elements.length) return;

  elements.forEach(el => {
    const preset = getPreset(el);
    if (!preset) return;

    el.style.opacity = preset.from.opacity ?? 0;
    el.style.willChange = 'transform, opacity';

    if (preset.from.translateY !== undefined) {
      el.style.transform = `translateY(${preset.from.translateY}px)`;
    } else if (preset.from.translateX !== undefined) {
      el.style.transform = `translateX(${preset.from.translateX}px)`;
    } else if (preset.from.scale !== undefined) {
      el.style.transform = `scale(${preset.from.scale})`;
    }
  });

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;

      const el = entry.target;
      const preset = getPreset(el);
      if (!preset) return;

      const delayN = getDelayMultiplier(el);
      const delay = BASE_DELAY + delayN * STAGGER;

      anime({
        targets: el,
        ...buildProps(preset),
        duration: DURATION,
        delay,
        easing: EASING,
        complete() {
          el.style.willChange = 'auto';
        }
      });

      observer.unobserve(el);
    });
  }, {
    threshold: THRESHOLD,
    rootMargin: '0px 0px -20px 0px'
  });

  elements.forEach(el => observer.observe(el));

  function getPreset(el) {
    for (const [cls, preset] of Object.entries(PRESETS)) {
      if (el.classList.contains(cls)) return preset;
    }
    return null;
  }

  function getDelayMultiplier(el) {
    for (let i = 1; i <= 8; i++) {
      if (el.classList.contains('delay-' + i)) return i;
    }
    return 0;
  }

  function buildProps(preset) {
    const props = {};
    for (const key of Object.keys(preset.to)) {
      props[key] = [preset.from[key], preset.to[key]];
    }
    return props;
  }
})();