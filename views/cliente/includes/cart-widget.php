<?php

$cartBasePath = $cartBasePath ?? '';
$cartUrl = $cartUrl ?? 'carrito_compras.php';
$cartPart = $cartPart ?? 'all';

if ($cartPart === 'button' || $cartPart === 'all') :
?>
<script>
    window.CART_CONFIG = window.CART_CONFIG || {
        basePath: <?= json_encode($cartBasePath) ?>,
        cartUrl: <?= json_encode($cartUrl) ?>
    };
</script>
<button type="button" data-cart-toggle class="relative transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed cursor-pointer bg-transparent border-0 p-0" aria-label="Ver carrito">
    <span class="material-symbols-outlined">shopping_bag</span>
    <span data-cart-count class="absolute -top-1 -right-2 text-[10px] bg-secondary text-on-secondary rounded-full min-w-4 h-4 px-1 flex items-center justify-center hidden">0</span>
</button>
<?php endif; ?>

<?php if ($cartPart === 'modal' || $cartPart === 'all') : ?>
<div id="cart-modal-backdrop" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300" aria-hidden="true"></div>

<aside id="cart-modal" class="fixed top-0 right-0 h-full w-full max-w-md bg-surface dark:bg-on-background border-l border-outline-variant dark:border-outline z-[70] flex flex-col shadow-2xl translate-x-full transition-transform duration-300 ease-out" aria-label="Carrito de compras" role="dialog">
    <div class="flex items-center justify-between px-margin-mobile md:px-8 py-6 border-b border-outline-variant">
        <h2 class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed">Tu bolsa</h2>
        <button type="button" id="cart-modal-close" class="text-on-surface-variant hover:text-secondary transition-colors" aria-label="Cerrar carrito">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto px-margin-mobile md:px-8">
        <p id="cart-modal-empty" class="font-body-md text-body-md text-on-surface-variant py-12 text-center hidden">
            Tu bolsa está vacía. Explora el catálogo y equípate para tu próximo entrenamiento.
        </p>
        <div id="cart-modal-items"></div>
    </div>

    <div id="cart-modal-footer" class="px-margin-mobile md:px-8 py-6 border-t border-outline-variant bg-surface-container-low dark:bg-tertiary-container hidden">
        <div class="flex justify-between items-center mb-6 font-body-md text-body-md">
            <span class="text-on-surface-variant">Subtotal</span>
            <span id="cart-modal-subtotal" class="font-body-lg text-body-lg text-primary dark:text-primary-fixed">$0.00</span>
        </div>
        <a href="<?= htmlspecialchars($cartUrl) ?>" class="w-full bg-primary text-on-primary py-4 font-label-md text-label-md uppercase tracking-widest hover:bg-secondary hover:text-on-secondary transition-all text-center no-underline block">
            Ir al carrito
        </a>
    </div>
</aside>

<script src="<?= htmlspecialchars($clienteJsPath ?? $cartBasePath . 'views/cliente/js/') ?>cart.js"></script>
<?php endif; ?>
