(function () {
    'use strict';

    const filters = {
        talla: null,
        colores: new Set(),
        precioMin: null,
        precioMax: null,
    };

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

    function readPriceInputs() {
        const minInput = document.querySelector('[data-filter-precio-min]');
        const maxInput = document.querySelector('[data-filter-precio-max]');
        const minRaw = minInput?.value.trim();
        const maxRaw = maxInput?.value.trim();
        filters.precioMin = minRaw === '' || minRaw == null ? null : Number(minRaw);
        filters.precioMax = maxRaw === '' || maxRaw == null ? null : Number(maxRaw);
        if (Number.isNaN(filters.precioMin)) filters.precioMin = null;
        if (Number.isNaN(filters.precioMax)) filters.precioMax = null;
    }

    function initSidebarSizeFilters() {
        const container = document.getElementById('filter-tallas');
        if (!container) return;

        container.querySelectorAll('[data-filter-talla]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const value = btn.dataset.filterTalla;
                const isActive = btn.classList.contains('is-active');
                container.querySelectorAll('[data-filter-talla]').forEach((item) => {
                    item.classList.remove('is-active');
                });
                if (isActive) {
                    filters.talla = null;
                } else {
                    filters.talla = value;
                    btn.classList.add('is-active');
                }
                applyFilters();
            });
        });
    }

    function initColorFilters() {
        document.querySelectorAll('[data-filter-color]').forEach((input) => {
            input.addEventListener('change', () => {
                filters.colores.clear();
                document.querySelectorAll('[data-filter-color]:checked').forEach((c) => {
                    filters.colores.add(c.value);
                });
                applyFilters();
            });
        });
    }

    function initPriceFilters() {
        document.querySelectorAll('[data-filter-precio-min], [data-filter-precio-max]').forEach((input) => {
            input.addEventListener('change', () => {
                readPriceInputs();
                applyFilters();
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    readPriceInputs();
                    applyFilters();
                }
            });
        });
    }

    function productMatches(card) {
        const tallas = (card.dataset.tallas || '').split(',').map((t) => t.trim()).filter(Boolean);
        const colores = (card.dataset.colores || '').split(',').map((c) => c.trim()).filter(Boolean);
        const precio = Number(card.dataset.precio || 0);

        if (filters.talla && !tallas.includes(filters.talla)) return false;

        if (filters.colores.size > 0) {
            const hit = colores.some((c) => filters.colores.has(c));
            if (!hit) return false;
        }

        if (filters.precioMin != null && precio < filters.precioMin) return false;
        if (filters.precioMax != null && precio > filters.precioMax) return false;

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
        if (emptyMsg) emptyMsg.classList.toggle('hidden', visible > 0 || cards.length === 0);
    }

    function resetFilters() {
        filters.talla = null;
        filters.colores.clear();
        filters.precioMin = null;
        filters.precioMax = null;

        document.querySelectorAll('#filter-tallas [data-filter-talla]').forEach((btn) => {
            btn.classList.remove('is-active');
        });
        document.querySelectorAll('[data-filter-color]').forEach((input) => {
            input.checked = false;
        });

        const minInput = document.querySelector('[data-filter-precio-min]');
        const maxInput = document.querySelector('[data-filter-precio-max]');
        if (minInput) minInput.value = minInput.getAttribute('placeholder') || '';
        if (maxInput) maxInput.value = maxInput.getAttribute('placeholder') || '';

        readPriceInputs();
        applyFilters();
    }

    function initSideFilters() {
        const root = document.querySelector('[data-side-filters]');
        const toggle = root?.querySelector('[data-filter-toggle]');
        const panel = root?.querySelector('[data-side-panel]');
        if (!root || !toggle || !panel) return;

        toggle.addEventListener('click', () => {
            const open = root.classList.toggle('is-open');
            panel.hidden = !open;
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    function parseGalleryUrls(raw) {
        if (!raw) return [];
        try {
            const urls = JSON.parse(raw);
            return Array.isArray(urls) ? urls.filter(Boolean) : [];
        } catch (_) {
            return [];
        }
    }

    function initCardGalleries() {
        document.querySelectorAll('[data-card-gallery]').forEach((root) => {
            const urls = parseGalleryUrls(root.getAttribute('data-gallery-urls'));
            const img = root.querySelector('[data-card-gallery-img]');
            if (!img || urls.length < 2) return;

            let index = 0;
            let swiped = false;
            const show = (i) => {
                index = (i + urls.length) % urls.length;
                img.src = urls[index];
            };

            root.querySelector('[data-card-gallery-prev]')?.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                show(index - 1);
            });
            root.querySelector('[data-card-gallery-next]')?.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                show(index + 1);
            });

            let touchStartX = 0;
            root.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0]?.clientX || 0;
                swiped = false;
            }, { passive: true });
            root.addEventListener('touchend', (e) => {
                const dx = (e.changedTouches[0]?.clientX || 0) - touchStartX;
                if (Math.abs(dx) < 40) return;
                swiped = true;
                show(index + (dx < 0 ? 1 : -1));
            }, { passive: true });
            root.querySelector('a.admin-product-link')?.addEventListener('click', (e) => {
                if (!swiped) return;
                e.preventDefault();
                swiped = false;
            });
        });
    }

    document.getElementById('reset-filters')?.addEventListener('click', resetFilters);

    initCardSizeSelectors();
    initCardColorSelectors();
    initProductDetailColor();
    initSideFilters();
    initSidebarSizeFilters();
    initColorFilters();
    initPriceFilters();
    readPriceInputs();
    initCardGalleries();
})();
