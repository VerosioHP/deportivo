(function () {
    'use strict';

    const filters = {
        talla: null,
        lavados: new Set(),
        fits: new Set(),
    };

    function applySizeButtonStyles(container, activeBtn) {
        container.querySelectorAll('.card-size-btn').forEach((btn) => {
            btn.classList.remove('bg-secondary', 'text-on-primary', 'border-secondary');
            btn.classList.add('border-outline-variant');
        });
        activeBtn.classList.add('bg-secondary', 'text-on-primary', 'border-secondary');
        activeBtn.classList.remove('border-outline-variant');
    }

    function initCardSizeSelectors() {
        document.querySelectorAll('[data-card-size-selector]').forEach((container) => {
            container.querySelectorAll('.card-size-btn').forEach((btn) => {
                btn.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    applySizeButtonStyles(container, btn);

                    const card = container.closest('[data-product-card]');
                    const addBtn = card?.querySelector('[data-add-to-cart]');
                    if (addBtn) {
                        addBtn.dataset.productTalla = btn.textContent.trim();
                    }
                });
            });
        });
    }

    function initSidebarSizeFilters() {
        const container = document.getElementById('filter-tallas');
        if (!container) return;

        container.querySelectorAll('[data-filter-talla]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const value = btn.dataset.filterTalla;
                const isActive = btn.classList.contains('bg-secondary');

                container.querySelectorAll('[data-filter-talla]').forEach((item) => {
                    item.classList.remove('bg-secondary', 'text-on-primary');
                    item.classList.add('border-outline-variant');
                });

                if (isActive) {
                    filters.talla = null;
                } else {
                    filters.talla = value;
                    btn.classList.add('bg-secondary', 'text-on-primary');
                    btn.classList.remove('border-outline-variant');
                }

                applyFilters();
            });
        });
    }

    function initCheckboxFilters(selector, setRef) {
        document.querySelectorAll(selector).forEach((input) => {
            input.addEventListener('change', () => {
                setRef.clear();
                document.querySelectorAll(selector + ':checked').forEach((checked) => {
                    setRef.add(checked.value);
                });
                applyFilters();
            });
        });
    }

    function productMatches(card) {
        const tallas = (card.dataset.tallas || '').split(',').map((t) => t.trim()).filter(Boolean);
        const lavado = card.dataset.lavado || '';
        const fit = card.dataset.fit || '';

        if (filters.talla && !tallas.includes(filters.talla)) {
            return false;
        }

        if (filters.lavados.size > 0 && !filters.lavados.has(lavado)) {
            return false;
        }

        if (filters.fits.size > 0 && !filters.fits.has(fit)) {
            return false;
        }

        return true;
    }

    function applyFilters() {
        const cards = document.querySelectorAll('[data-product-card]');
        const emptyMsg = document.getElementById('catalog-empty-filters');
        let visible = 0;

        cards.forEach((card) => {
            const show = productMatches(card);
            card.classList.toggle('hidden', !show);
            if (show) visible += 1;
        });

        if (emptyMsg) {
            emptyMsg.classList.toggle('hidden', visible > 0);
        }
    }

    function resetFilters() {
        filters.talla = null;
        filters.lavados.clear();
        filters.fits.clear();

        document.querySelectorAll('#filter-tallas [data-filter-talla]').forEach((btn) => {
            btn.classList.remove('bg-secondary', 'text-on-primary');
            btn.classList.add('border-outline-variant');
        });

        document.querySelectorAll('[data-filter-lavado], [data-filter-fit]').forEach((input) => {
            input.checked = false;
            const indicator = input.closest('label')?.querySelector('[data-filter-indicator]');
            if (indicator) {
                indicator.classList.remove('bg-primary');
                indicator.classList.add('border-outline-variant');
            }
        });

        applyFilters();
    }

    function initCheckboxVisuals() {
        document.querySelectorAll('[data-filter-lavado], [data-filter-fit]').forEach((input) => {
            input.addEventListener('change', () => {
                const indicator = input.closest('label')?.querySelector('[data-filter-indicator]');
                if (!indicator) return;

                if (input.checked) {
                    indicator.classList.add('bg-primary');
                    indicator.classList.remove('border-outline-variant');
                } else {
                    indicator.classList.remove('bg-primary');
                    indicator.classList.add('border-outline-variant');
                }
            });
        });
    }

    document.getElementById('reset-filters')?.addEventListener('click', resetFilters);

    initCardSizeSelectors();
    initSidebarSizeFilters();
    initCheckboxFilters('[data-filter-lavado]', filters.lavados);
    initCheckboxFilters('[data-filter-fit]', filters.fits);
    initCheckboxVisuals();
})();
