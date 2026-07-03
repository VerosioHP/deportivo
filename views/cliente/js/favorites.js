(function () {
    'use strict';

    const STORAGE_KEY = 'deportivo_favorites';
    const config = window.FAVORITES_CONFIG || {
        favoritesUrl: 'favoritos.php',
        productUrlPrefix: 'producto.php?id=',
    };

    function getItems() {
        try {
            const data = localStorage.getItem(STORAGE_KEY);
            return data ? JSON.parse(data) : [];
        } catch {
            return [];
        }
    }

    function saveItems(items) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
        document.dispatchEvent(new CustomEvent('favorites:updated', { detail: { items } }));
    }

    function formatPrice(amount) {
        if (window.DEPORTIVO_MONEDA?.format) {
            return window.DEPORTIVO_MONEDA.format(amount);
        }

        const value = Math.round(Number(amount) || 0);
        return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function escapeAttr(text) {
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    function readProductFromButton(button) {
        return {
            id: Number(button.dataset.productId),
            nombre: button.dataset.productNombre || '',
            precio: Number(button.dataset.productPrecio || 0),
            imagen: button.dataset.productImagen || '',
            talla: button.dataset.productTalla || 'M',
            lavado: button.dataset.productLavado || '',
            fit: button.dataset.productFit || '',
            categoria: button.dataset.productCategoria || '',
            stock_estado: button.dataset.productStock || 'disponible',
        };
    }

    function isFavorite(productId) {
        return getItems().some((item) => item.id === Number(productId));
    }

    function addItem(product) {
        if (!product.id) {
            return false;
        }

        const items = getItems();

        if (items.some((item) => item.id === product.id)) {
            return false;
        }

        items.push(product);
        saveItems(items);
        return true;
    }

    function removeItem(productId) {
        const items = getItems().filter((item) => item.id !== Number(productId));
        saveItems(items);
    }

    function toggleItem(product) {
        if (isFavorite(product.id)) {
            removeItem(product.id);
            return false;
        }

        addItem(product);
        return true;
    }

    function updateBadge() {
        const count = getItems().length;
        document.querySelectorAll('[data-favorites-count]').forEach((badge) => {
            badge.textContent = String(count);
            badge.classList.toggle('hidden', count === 0);
        });
    }

    function syncFavoriteButtons() {
        const ids = new Set(getItems().map((item) => item.id));

        document.querySelectorAll('[data-toggle-favorite]').forEach((button) => {
            const id = Number(button.dataset.productId);
            const active = ids.has(id);
            const icon = button.querySelector('.material-symbols-outlined');

            button.classList.toggle('is-favorite', active);
            if (!button.closest('.product-card')) {
                button.classList.toggle('text-secondary', active);
                button.classList.toggle('text-on-surface-variant', !active);
            }
            button.setAttribute('aria-pressed', active ? 'true' : 'false');

            if (icon) {
                icon.style.fontVariationSettings = active ? "'FILL' 1" : "'FILL' 0";
            }

            if (button.dataset.favoriteLabel === '1') {
                button.textContent = active ? 'Quitar de favoritos' : 'Añadir a favoritos';
            }
        });
    }

    function renderFavoritesPage() {
        const grid = document.getElementById('favorites-page-grid');
        const empty = document.getElementById('favorites-page-empty');
        const content = document.getElementById('favorites-page-content');

        if (!grid) {
            return;
        }

        const items = getItems();
        grid.innerHTML = '';

        if (items.length === 0) {
            empty?.classList.remove('hidden');
            content?.classList.add('hidden');
            return;
        }

        empty?.classList.add('hidden');
        content?.classList.remove('hidden');

        items.forEach((item) => {
            const card = document.createElement('article');
            card.className = 'product-card group flex flex-col';
            card.dataset.productCard = '';
            card.innerHTML = `
                <div class="aspect-[3/4] mb-6 overflow-hidden bg-surface-container relative">
                    <a href="${escapeAttr(config.productUrlPrefix + item.id)}" class="block w-full h-full text-inherit no-underline hover:opacity-95 transition-opacity">
                        <img alt="${escapeAttr(item.nombre)}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="${escapeAttr(item.imagen)}" />
                    </a>
                    <button type="button"
                        class="absolute top-4 right-4 z-10 transition-colors"
                        data-toggle-favorite
                        data-product-id="${item.id}"
                        data-product-nombre="${escapeAttr(item.nombre)}"
                        data-product-precio="${item.precio}"
                        data-product-imagen="${escapeAttr(item.imagen)}"
                        data-product-talla="${escapeAttr(item.talla)}"
                        data-product-lavado="${escapeAttr(item.lavado)}"
                        data-product-fit="${escapeAttr(item.fit)}"
                        data-product-categoria="${escapeAttr(item.categoria)}"
                        data-product-stock="${escapeAttr(item.stock_estado)}"
                        aria-label="Quitar de favoritos">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">favorite</span>
                    </button>
                </div>
                <a href="${escapeAttr(config.productUrlPrefix + item.id)}" class="space-y-1 block text-inherit no-underline">
                    <h2 class="font-headline-sm text-headline-sm">${escapeHtml(item.nombre)}</h2>
                    <p class="font-body-md text-body-md text-secondary">${formatPrice(item.precio)}</p>
                </a>
                <button type="button"
                    class="mt-4 w-full py-3 border border-primary text-primary font-label-md text-label-md uppercase tracking-widest hover:bg-primary hover:text-on-primary transition-all"
                    data-add-to-cart
                    data-product-talla-from="card"
                    data-product-id="${item.id}"
                    data-product-nombre="${escapeAttr(item.nombre)}"
                    data-product-precio="${item.precio}"
                    data-product-imagen="${escapeAttr(item.imagen)}"
                    data-product-talla="${escapeAttr(item.talla)}"
                    data-product-lavado="${escapeAttr(item.lavado)}"
                    data-product-fit="${escapeAttr(item.fit)}"
                    data-product-categoria="${escapeAttr(item.categoria)}"
                    data-product-stock="${escapeAttr(item.stock_estado)}">
                    Añadir al carrito
                </button>
            `;
            grid.appendChild(card);
        });

        syncFavoriteButtons();
    }

    function bindEvents() {
        document.addEventListener('click', (event) => {
            const toggleBtn = event.target.closest('[data-toggle-favorite]');

            if (!toggleBtn) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            const product = readProductFromButton(toggleBtn);

            if (!product.id) {
                return;
            }

            const added = toggleItem(product);
            syncFavoriteButtons();
            updateBadge();
            renderFavoritesPage();

            toggleBtn.classList.add('scale-110');
            setTimeout(() => toggleBtn.classList.remove('scale-110'), 150);

            if (added && typeof window.MajesticCart !== 'undefined') {
                // Sin acción extra: solo guardar en favoritos.
            }
        });

        document.addEventListener('favorites:updated', () => {
            updateBadge();
            syncFavoriteButtons();
            renderFavoritesPage();
        });
    }

    function init() {
        updateBadge();
        syncFavoriteButtons();
        renderFavoritesPage();
        bindEvents();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    window.DeportivoFavorites = {
        getItems,
        addItem,
        removeItem,
        toggleItem,
        isFavorite,
    };
})();
