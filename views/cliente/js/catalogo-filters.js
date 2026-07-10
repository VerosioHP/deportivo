(function () {
    'use strict';

    const filters = { talla: null, lavados: new Set(), fits: new Set() };

    function stockMessage(cantidad, colorNombre) {
        const color = (colorNombre || '').trim();
        if (cantidad <= 0) return color ? `Agotado en color ${color}` : 'Agotado temporalmente';
        if (cantidad <= 5) return color ? `¡Solo quedan ${cantidad} en color ${color}!` : `¡Solo quedan ${cantidad} unidades!`;
        return color ? `Quedan ${cantidad} unidades en color ${color}` : `Quedan ${cantidad} unidades disponibles`;
    }

    function applySizeButtonStyles(container, activeBtn) {
        container.querySelectorAll('.card-size-btn').forEach((btn) => {
            btn.classList.remove('bg-secondary', 'text-on-secondary', 'border-secondary');
            btn.classList.add('border-outline-variant');
        });
        activeBtn.classList.add('bg-secondary', 'text-on-secondary', 'border-secondary');
        activeBtn.classList.remove('border-outline-variant');
    }

    function applyColorButtonStyles(container, activeBtn) {
        container.querySelectorAll('.card-color-btn').forEach((btn) => {
            btn.classList.remove('border-secondary');
            btn.setAttribute('aria-pressed', 'false');
        });
        activeBtn.classList.add('border-secondary');
        activeBtn.setAttribute('aria-pressed', 'true');
    }

    function updateColorSelection(colorBtn, targets) {
        const stock = Number(colorBtn.dataset.colorStock || 0);
        const nombre = colorBtn.dataset.colorNombre || '';

        targets.forEach((el) => {
            if (!el) return;
            if (el.dataset.productColor !== undefined) {
                el.dataset.productColor = nombre;
                el.dataset.productColorSlug = colorBtn.dataset.colorSlug || '';
                el.dataset.productColorId = colorBtn.dataset.colorId || '';
                el.dataset.productStockCantidad = String(stock);
            }
            if (el.hasAttribute('data-add-to-cart')) {
                el.disabled = stock <= 0;
                el.textContent = stock <= 0 ? 'Agotado' : 'Añadir al carrito';
            }
        });

        const stockText = document.getElementById('stock-message-text');
        if (stockText) stockText.textContent = stockMessage(stock, nombre);

        const cardStockText = colorBtn.closest('[data-product-card]')?.querySelector('[data-card-stock-text]');
        if (cardStockText) cardStockText.textContent = stockMessage(stock, nombre);
    }

    function syncCardState(card) {
        if (!card) return;
        const addBtn = card.querySelector('[data-add-to-cart]');
        const favBtn = card.querySelector('[data-toggle-favorite]');
        const selectedSize = card.querySelector('[data-card-size-selector] .card-size-btn.bg-secondary');
        const selectedColor = card.querySelector('[data-card-color-selector] .card-color-btn.border-secondary');

        if (selectedSize) {
            const talla = selectedSize.textContent.trim();
            if (addBtn) addBtn.dataset.productTalla = talla;
            if (favBtn) favBtn.dataset.productTalla = talla;
        }

        if (selectedColor) {
            updateColorSelection(selectedColor, [addBtn, favBtn]);
        }
    }

    function initCardSizeSelectors() {
        document.querySelectorAll('[data-card-size-selector]').forEach((container) => {
            container.querySelectorAll('.card-size-btn').forEach((btn) => {
                btn.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    applySizeButtonStyles(container, btn);
                    syncCardState(container.closest('[data-product-card]'));
                });
            });
        });
    }

    function initCardColorSelectors() {
        document.querySelectorAll('[data-card-color-selector]').forEach((container) => {
            container.querySelectorAll('.card-color-btn').forEach((btn) => {
                btn.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    applyColorButtonStyles(container, btn);
                    syncCardState(container.closest('[data-product-card]'));
                });
            });
        });
    }

    function initProductDetailColor() {
        const container = document.getElementById('color-selector');
        if (!container) return;

        const addBtn = document.querySelector('[data-add-to-cart][data-product-talla-from="selector"]');

        container.querySelectorAll('.card-color-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                applyColorButtonStyles(container, btn);
                updateColorSelection(btn, [addBtn]);
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
                    item.classList.remove('bg-secondary', 'text-on-secondary');
                    item.classList.add('border-outline-variant');
                });
                if (isActive) filters.talla = null;
                else {
                    filters.talla = value;
                    btn.classList.add('bg-secondary', 'text-on-secondary');
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
                document.querySelectorAll(selector + ':checked').forEach((c) => setRef.add(c.value));
                applyFilters();
            });
        });
    }

    function productMatches(card) {
        const tallas = (card.dataset.tallas || '').split(',').map((t) => t.trim()).filter(Boolean);
        if (filters.talla && !tallas.includes(filters.talla)) return false;
        if (filters.lavados.size > 0 && !filters.lavados.has(card.dataset.lavado || '')) return false;
        if (filters.fits.size > 0 && !filters.fits.has(card.dataset.fit || '')) return false;
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
        if (emptyMsg) emptyMsg.classList.toggle('hidden', visible > 0);
    }

    function resetFilters() {
        filters.talla = null;
        filters.lavados.clear();
        filters.fits.clear();
        document.querySelectorAll('#filter-tallas [data-filter-talla]').forEach((btn) => {
            btn.classList.remove('bg-secondary', 'text-on-secondary');
            btn.classList.add('border-outline-variant');
        });
        document.querySelectorAll('[data-filter-lavado], [data-filter-fit]').forEach((input) => {
            input.checked = false;
            const indicator = input.closest('label')?.querySelector('[data-filter-indicator]');
            if (indicator) { indicator.classList.remove('bg-primary'); indicator.classList.add('border-outline-variant'); }
        });
        applyFilters();
    }

    function initCheckboxVisuals() {
        document.querySelectorAll('[data-filter-lavado], [data-filter-fit]').forEach((input) => {
            input.addEventListener('change', () => {
                const indicator = input.closest('label')?.querySelector('[data-filter-indicator]');
                if (!indicator) return;
                indicator.classList.toggle('bg-primary', input.checked);
                indicator.classList.toggle('border-outline-variant', !input.checked);
            });
        });
    }

    function initCategoryDropdown() {
        const dropdown = document.querySelector('[data-category-dropdown]');
        const trigger = dropdown?.querySelector('[data-category-trigger]');
        const menu = dropdown?.querySelector('.catalog-category-menu');
        if (!dropdown || !trigger || !menu) return;

        const close = () => { dropdown.classList.remove('is-open'); trigger.setAttribute('aria-expanded', 'false'); menu.hidden = true; };
        const open = () => { dropdown.classList.add('is-open'); trigger.setAttribute('aria-expanded', 'true'); menu.hidden = false; };

        trigger.addEventListener('click', () => dropdown.classList.contains('is-open') ? close() : open());
        document.addEventListener('click', (e) => { if (!dropdown.contains(e.target)) close(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });
    }

    document.getElementById('reset-filters')?.addEventListener('click', resetFilters);

    initCardSizeSelectors();
    initCardColorSelectors();
    initProductDetailColor();
    initSidebarSizeFilters();
    initCheckboxFilters('[data-filter-lavado]', filters.lavados);
    initCheckboxFilters('[data-filter-fit]', filters.fits);
    initCheckboxVisuals();
    initCategoryDropdown();
})();
