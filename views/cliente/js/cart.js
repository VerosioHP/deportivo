(function () {
    'use strict';

    const STORAGE_KEY = 'majestic_cart';
    const config = window.CART_CONFIG || {
        basePath: '',
        cartUrl: 'carrito_compras.php',
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
        document.dispatchEvent(new CustomEvent('cart:updated', { detail: { items } }));
    }

    function makeKey(id, talla) {
        return `${id}-${talla}`;
    }

    function formatPrice(amount) {
        if (window.DEPORTIVO_MONEDA?.format) {
            return window.DEPORTIVO_MONEDA.format(amount);
        }

        const value = Math.round(Number(amount) || 0);
        return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function variantLabel(item) {
        const lavado = translateLavado(item.lavado);
        const fit = translateFit(item.fit);
        const parts = [lavado, fit].filter(Boolean);
        const variant = parts.length ? parts.join(' / ') : item.categoria || 'Estándar';
        return `${variant} / Talla ${item.talla}`;
    }

    function translateLavado(value) {
        const map = {
            'Raw Indigo': 'Índigo crudo',
            'Vintage Wash': 'Lavado vintage',
            'Midnight Black': 'Negro medianoche',
            'Bleached': 'Decolorado',
        };
        return map[value] || value || '';
    }

    function translateFit(value) {
        const map = {
            'Heritage Straight': 'Recto heritage',
            'Relaxed Taper': 'Taper relajado',
            'Skinny Architectural': 'Skinny arquitectónico',
            'Wide Leg': 'Pierna ancha',
            'Regular': 'Regular',
            'Relaxed': 'Relajado',
            'Oversized': 'Oversize',
            'Longline': 'Largo',
        };
        return map[value] || value || '';
    }

    function stockMessage(estado) {
        if (estado === 'agotado') {
            return 'Agotado temporalmente';
        }
        if (estado === 'pocas_unidades') {
            return 'Pocas unidades - Envío inmediato';
        }
        return 'En stock - Listo para enviar';
    }

    function getSelectedTalla(button) {
        if (button.dataset.productTallaFrom === 'selector') {
            const selected = document.querySelector('#size-selector button.border-secondary');
            return selected?.textContent.trim() || button.dataset.productTalla;
        }

        if (button.dataset.productTallaFrom === 'card') {
            const card = button.closest('[data-product-card]');
            const selected = card?.querySelector('[data-card-size-selector] .card-size-btn.bg-secondary');
            return selected?.textContent.trim() || button.dataset.productTalla;
        }

        return button.dataset.productTalla;
    }

    function getCount(items) {
        return items.reduce((sum, item) => sum + item.cantidad, 0);
    }

    function getSubtotal(items) {
        return items.reduce((sum, item) => sum + item.precio * item.cantidad, 0);
    }

    function getShipping(subtotal) {
        const moneda = window.DEPORTIVO_MONEDA || {};
        const minGratis = moneda.envioGratisMin ?? 350000;
        const costo = moneda.envioCosto ?? 15000;

        return subtotal >= minGratis ? 0 : subtotal > 0 ? costo : 0;
    }

    function addItem(product) {
        const items = getItems();
        const key = makeKey(product.id, product.talla);
        const existing = items.find((item) => item.key === key);

        if (existing) {
            existing.cantidad += product.cantidad || 1;
        } else {
            items.push({
                key,
                id: product.id,
                nombre: product.nombre,
                precio: Number(product.precio),
                imagen: product.imagen,
                talla: product.talla,
                lavado: product.lavado || '',
                fit: product.fit || '',
                categoria: product.categoria || '',
                stock_estado: product.stock_estado || 'disponible',
                cantidad: product.cantidad || 1,
            });
        }

        saveItems(items);
    }

    function removeItem(key) {
        saveItems(getItems().filter((item) => item.key !== key));
    }

    function updateQuantity(key, cantidad) {
        const items = getItems();
        const item = items.find((entry) => entry.key === key);

        if (!item) {
            return;
        }

        if (cantidad <= 0) {
            removeItem(key);
            return;
        }

        item.cantidad = cantidad;
        saveItems(items);
    }

    function updateBadge() {
        const count = getCount(getItems());
        document.querySelectorAll('[data-cart-count]').forEach((badge) => {
            badge.textContent = count;
            badge.classList.toggle('hidden', count === 0);
        });
    }

    function renderModalItems() {
        const container = document.getElementById('cart-modal-items');
        const emptyState = document.getElementById('cart-modal-empty');
        const footer = document.getElementById('cart-modal-footer');
        const subtotalEl = document.getElementById('cart-modal-subtotal');

        if (!container) {
            return;
        }

        const items = getItems();
        container.innerHTML = '';

        if (items.length === 0) {
            emptyState?.classList.remove('hidden');
            footer?.classList.add('hidden');
            return;
        }

        emptyState?.classList.add('hidden');
        footer?.classList.remove('hidden');

        items.forEach((item) => {
            const row = document.createElement('div');
            row.className = 'flex gap-4 py-4 border-b border-outline-variant last:border-b-0';
            row.innerHTML = `
                <div class="w-20 aspect-[3/4] bg-surface-container-low overflow-hidden flex-shrink-0">
                    <img class="w-full h-full object-cover" src="${escapeAttr(item.imagen)}" alt="${escapeAttr(item.nombre)}" />
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between gap-2 mb-1">
                        <h4 class="font-headline-sm text-headline-sm truncate">${escapeHtml(item.nombre)}</h4>
                        <p class="font-body-md text-body-md text-secondary flex-shrink-0">${formatPrice(item.precio * item.cantidad)}</p>
                    </div>
                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest mb-2">${escapeHtml(variantLabel(item))}</p>
                    <p class="font-label-sm text-label-sm text-on-surface-variant">Cantidad: ${item.cantidad}</p>
                </div>
            `;
            container.appendChild(row);
        });

        if (subtotalEl) {
            subtotalEl.textContent = formatPrice(getSubtotal(items));
        }
    }

    function renderCartPage() {
        const list = document.getElementById('cart-page-items');
        const empty = document.getElementById('cart-page-empty');
        const content = document.getElementById('cart-page-content');

        if (!list) {
            return;
        }

        const items = getItems();
        list.innerHTML = '';

        if (items.length === 0) {
            empty?.classList.remove('hidden');
            content?.classList.add('hidden');
            updateSummary(0);
            return;
        }

        empty?.classList.add('hidden');
        content?.classList.remove('hidden');

        items.forEach((item) => {
            const row = document.createElement('div');
            row.className = 'flex flex-col md:flex-row gap-8 pb-12 border-b border-outline-variant';
            row.dataset.cartKey = item.key;
            row.innerHTML = `
                <div class="w-full md:w-48 aspect-[3/4] bg-surface-container-low overflow-hidden">
                    <img class="w-full h-full object-cover" src="${escapeAttr(item.imagen)}" alt="${escapeAttr(item.nombre)}" />
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-headline-sm text-headline-sm">${escapeHtml(item.nombre)}</h3>
                            <p class="font-body-lg text-body-lg cart-item-line-total">${formatPrice(item.precio * item.cantidad)}</p>
                        </div>
                        <p class="font-label-md text-label-md text-on-surface-variant mb-4 uppercase tracking-widest">${escapeHtml(variantLabel(item))}</p>
                        <div class="flex items-center gap-6">
                            <div class="flex items-center border border-outline px-3 py-1">
                                <button type="button" class="hover:text-secondary" data-cart-qty="decrease" data-cart-key="${escapeAttr(item.key)}" aria-label="Reducir cantidad">
                                    <span class="material-symbols-outlined text-sm">remove</span>
                                </button>
                                <span class="px-4 font-label-md cart-item-qty">${item.cantidad}</span>
                                <button type="button" class="hover:text-secondary" data-cart-qty="increase" data-cart-key="${escapeAttr(item.key)}" aria-label="Aumentar cantidad">
                                    <span class="material-symbols-outlined text-sm">add</span>
                                </button>
                            </div>
                            <button type="button" class="text-label-sm font-label-sm text-on-surface-variant underline hover:text-error transition-colors" data-cart-remove="${escapeAttr(item.key)}">ELIMINAR</button>
                        </div>
                    </div>
                    <p class="text-label-sm font-label-sm text-on-surface-variant mt-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-xs">check_circle</span> ${escapeHtml(stockMessage(item.stock_estado))}
                    </p>
                </div>
            `;
            list.appendChild(row);
        });

        updateSummary(getSubtotal(items));
    }

    function updateSummary(subtotal) {
        const shipping = getShipping(subtotal);
        const total = subtotal + shipping;

        const subtotalEl = document.getElementById('cart-summary-subtotal');
        const shippingEl = document.getElementById('cart-summary-shipping');
        const totalEl = document.getElementById('cart-summary-total');
        const checkoutBtn = document.getElementById('checkout-btn');

        if (subtotalEl) subtotalEl.textContent = formatPrice(subtotal);
        if (shippingEl) shippingEl.textContent = formatPrice(shipping);
        if (totalEl) totalEl.textContent = formatPrice(total);

        if (checkoutBtn) {
            const hasItems = subtotal > 0;
            checkoutBtn.classList.toggle('opacity-50', !hasItems);
            checkoutBtn.classList.toggle('pointer-events-none', !hasItems);
        }
    }

    function openModal() {
        renderModalItems();
        const modal = document.getElementById('cart-modal');
        const backdrop = document.getElementById('cart-modal-backdrop');

        modal?.classList.remove('translate-x-full');
        backdrop?.classList.remove('opacity-0', 'pointer-events-none');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        const modal = document.getElementById('cart-modal');
        const backdrop = document.getElementById('cart-modal-backdrop');

        modal?.classList.add('translate-x-full');
        backdrop?.classList.add('opacity-0', 'pointer-events-none');
        document.body.classList.remove('overflow-hidden');
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
            nombre: button.dataset.productNombre,
            precio: Number(button.dataset.productPrecio),
            imagen: button.dataset.productImagen,
            talla: button.dataset.productTalla,
            lavado: button.dataset.productLavado || '',
            fit: button.dataset.productFit || '',
            categoria: button.dataset.productCategoria || '',
            stock_estado: button.dataset.productStock || 'disponible',
            cantidad: 1,
        };
    }

    function bindEvents() {
        document.querySelectorAll('[data-cart-toggle]').forEach((trigger) => {
            trigger.addEventListener('click', (event) => {
                event.preventDefault();
                openModal();
            });
        });

        document.getElementById('cart-modal-close')?.addEventListener('click', closeModal);
        document.getElementById('cart-modal-backdrop')?.addEventListener('click', closeModal);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        document.addEventListener('click', (event) => {
            const addButton = event.target.closest('[data-add-to-cart]');
            if (addButton) {
                event.preventDefault();
                event.stopPropagation();

                const product = readProductFromButton(addButton);
                product.talla = getSelectedTalla(addButton);

                if (!product.id || !product.talla) {
                    return;
                }

                addItem(product);
                openModal();
            }

            const removeBtn = event.target.closest('[data-cart-remove]');
            if (removeBtn) {
                removeItem(removeBtn.dataset.cartRemove);
            }

            const qtyBtn = event.target.closest('[data-cart-qty]');
            if (qtyBtn) {
                const key = qtyBtn.dataset.cartKey;
                const item = getItems().find((entry) => entry.key === key);
                if (!item) return;

                const delta = qtyBtn.dataset.cartQty === 'increase' ? 1 : -1;
                updateQuantity(key, item.cantidad + delta);
            }
        });

        document.addEventListener('cart:updated', () => {
            updateBadge();
            renderModalItems();
            renderCartPage();
        });
    }

    function init() {
        updateBadge();
        renderModalItems();
        renderCartPage();
        bindEvents();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    window.MajesticCart = {
        addItem,
        removeItem,
        updateQuantity,
        getItems,
        openModal,
        closeModal,
        formatPrice,
        getSubtotal: () => getSubtotal(getItems()),
        getShipping: () => getShipping(getSubtotal(getItems())),
        getTotal: () => getSubtotal(getItems()) + getShipping(getSubtotal(getItems())),
    };
})();
