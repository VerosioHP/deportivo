(() => {
    const root = document.querySelector('[data-nosotros-pulse]');
    if (!root) return;

    const beats = {
        casa: {
            kicker: 'Casilla 01 · Origen',
            title: 'Empezamos sin oficina fancy',
            copy: 'Una casa en el sur, una mesa y terquedad paisa. VEMA nació entre conversaciones largas y tela a prueba.',
        },
        sudor: {
            kicker: 'Casilla 02 · Entrenar',
            title: 'Si no late, no es VEMA',
            copy: 'Dry-Fit, corte atlético y cero drama: la camiseta aguanta el gym… y el resto del día también.',
        },
        calle: {
            kicker: 'Casilla 03 · Street',
            title: 'Del gym a la esquina',
            copy: 'Misma prenda, misma actitud. Medellín se mueve y nosotros vamos con ella, sin cambiarte de look.',
        },
        mundo: {
            kicker: 'Casilla 04 · Ambición',
            title: 'Local primero. Global después',
            copy: 'Hecho aquí, pensado para cualquiera que camine, corra o conquiste su propia ciudad.',
        },
    };

    const kickerEl = root.querySelector('[data-pulse-kicker]');
    const titleEl = root.querySelector('[data-pulse-title]');
    const copyEl = root.querySelector('[data-pulse-copy]');
    const ringEl = root.querySelector('[data-pulse-ring]');
    const finaleEl = root.querySelector('[data-pulse-finale]');
    const pads = [...root.querySelectorAll('[data-pulse-pad]')];
    const seen = new Set();

    function flashRing() {
        if (!ringEl) return;
        ringEl.classList.remove('is-beat');
        // Force reflow so the animation can restart.
        void ringEl.offsetWidth;
        ringEl.classList.add('is-beat');
    }

    function setBeat(key) {
        const beat = beats[key];
        if (!beat) return;

        root.dataset.activeBeat = key;
        root.classList.add('is-playing');

        pads.forEach((pad) => {
            const on = pad.dataset.pulsePad === key;
            pad.classList.toggle('is-active', on);
            pad.setAttribute('aria-pressed', on ? 'true' : 'false');
        });

        [kickerEl, titleEl, copyEl].forEach((el) => el?.classList.add('is-swap'));

        window.setTimeout(() => {
            if (kickerEl) kickerEl.textContent = beat.kicker;
            if (titleEl) titleEl.textContent = beat.title;
            if (copyEl) copyEl.textContent = beat.copy;
            [kickerEl, titleEl, copyEl].forEach((el) => el?.classList.remove('is-swap'));
        }, 160);

        flashRing();
        seen.add(key);

        if (finaleEl && seen.size === pads.length) {
            finaleEl.hidden = false;
            finaleEl.classList.add('is-visible');
        }
    }

    pads.forEach((pad) => {
        pad.addEventListener('click', () => setBeat(pad.dataset.pulsePad));
    });
})();
