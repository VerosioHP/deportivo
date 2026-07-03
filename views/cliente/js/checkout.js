(function () {
    'use strict';

    const form = document.getElementById('checkout-form');
    const cartDataInput = document.getElementById('cart-data');
    const emptyBlock = document.getElementById('checkout-empty');
    const contentBlock = document.getElementById('checkout-content');
    const itemsContainer = document.getElementById('checkout-items');

    function render() {
        if (!window.MajesticCart) {
            return;
        }

        const items = MajesticCart.getItems();

        if (!items.length) {
            emptyBlock?.classList.remove('hidden');
            contentBlock?.classList.add('hidden');
            return;
        }

        emptyBlock?.classList.add('hidden');
        contentBlock?.classList.remove('hidden');

        if (cartDataInput) {
            cartDataInput.value = JSON.stringify(items);
        }

        if (itemsContainer) {
            itemsContainer.innerHTML = '';

            items.forEach((item) => {
                const row = document.createElement('div');
                row.className = 'flex gap-4 pb-4 border-b border-outline-variant last:border-b-0';
                row.innerHTML = `
                    <div class="w-16 aspect-[3/4] bg-surface-container overflow-hidden flex-shrink-0">
                        <img src="${escapeAttr(item.imagen)}" alt="${escapeAttr(item.nombre)}" class="w-full h-full object-cover" />
                    </div>
                    <div class="flex-1 min-w-0 text-left">
                        <p class="font-headline-sm text-headline-sm truncate">${escapeHtml(item.nombre)}</p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest mt-1">Talla ${escapeHtml(item.talla)} · Cant. ${item.cantidad}</p>
                        <p class="font-body-md text-secondary mt-1">${MajesticCart.formatPrice(item.precio * item.cantidad)}</p>
                    </div>
                `;
                itemsContainer.appendChild(row);
            });
        }

        const subtotal = MajesticCart.getSubtotal();
        const shipping = MajesticCart.getShipping();
        const total = subtotal + shipping;

        document.getElementById('checkout-subtotal').textContent = MajesticCart.formatPrice(subtotal);
        document.getElementById('checkout-shipping').textContent = MajesticCart.formatPrice(shipping);
        document.getElementById('checkout-total').textContent = MajesticCart.formatPrice(total);
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

    form?.addEventListener('submit', () => {
        if (cartDataInput && window.MajesticCart) {
            cartDataInput.value = JSON.stringify(MajesticCart.getItems());
        }
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', render);
    } else {
        render();
    }
})();
