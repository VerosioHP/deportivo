(function () {
    'use strict';

    const backdrop = document.getElementById('size-guide-backdrop');
    const modal = document.getElementById('size-guide-modal');
    const titleEl = document.getElementById('size-guide-title');
    const unitEl = document.getElementById('size-guide-unit');
    const headEl = document.getElementById('size-guide-head');
    const bodyEl = document.getElementById('size-guide-body');
    const tipsEl = document.getElementById('size-guide-tips');
    const closeBtn = document.getElementById('size-guide-close');

    if (!modal || !backdrop) {
        return;
    }

    function openModal(guide) {
        if (!guide) {
            return;
        }

        titleEl.textContent = guide.titulo || 'Guía de tallas';
        unitEl.textContent = guide.unidad || '';

        headEl.innerHTML = (guide.columnas || []).map((col) =>
            `<th class="font-label-sm text-label-sm uppercase tracking-widest text-primary px-4 py-3 text-left bg-surface-container-low">${col}</th>`
        ).join('');

        bodyEl.innerHTML = (guide.filas || []).map((fila, index) => {
            const cells = fila.map((cell) =>
                `<td class="font-body-md text-body-md px-4 py-3 border-t border-outline-variant">${cell}</td>`
            ).join('');

            return `<tr class="${index % 2 === 0 ? 'bg-surface' : 'bg-surface-container-lowest'}">${cells}</tr>`;
        }).join('');

        tipsEl.innerHTML = (guide.consejos || []).map((tip) =>
            `<li>${tip}</li>`
        ).join('');

        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        backdrop.setAttribute('aria-hidden', 'false');
        modal.classList.remove('translate-x-full');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        backdrop.setAttribute('aria-hidden', 'true');
        modal.classList.add('translate-x-full');
        document.body.classList.remove('overflow-hidden');
    }

    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-size-guide]');

        if (!trigger) {
            return;
        }

        event.preventDefault();

        let guide = window.SIZE_GUIDE;

        if (trigger.dataset.sizeGuide) {
            try {
                guide = JSON.parse(trigger.dataset.sizeGuide);
            } catch {
                guide = window.SIZE_GUIDE;
            }
        }

        openModal(guide);
    });

    closeBtn?.addEventListener('click', closeModal);
    backdrop?.addEventListener('click', closeModal);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('translate-x-full')) {
            closeModal();
        }
    });
})();
