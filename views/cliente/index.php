<?php

require_once dirname(__DIR__, 2) . '/includes/auth.php';
require_once dirname(__DIR__, 2) . '/models/Producto.php';
require_once __DIR__ . '/includes/sport-images.php';

$navInViews = false;
$cartBasePath = $assetBase;
$cartUrl = $clienteViewsPath . 'carrito_compras.php';
$catalogoCamisetas = $clienteViewsPath . 'catalogo.php?categoria=camisetas';
$muestraCamisetas = array_slice(Producto::listarPorCategoria('camisetas'), 0, 4);

if (count($muestraCamisetas) < 4) {
    $ids = array_map('intval', array_column($muestraCamisetas, 'id'));
    foreach (Producto::obtenerSugerencias(4) as $extra) {
        $extraId = (int) $extra['id'];
        if (in_array($extraId, $ids, true)) {
            continue;
        }
        $muestraCamisetas[] = $extra;
        $ids[] = $extraId;
        if (count($muestraCamisetas) >= 4) {
            break;
        }
    }
}
?>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>VEMA</title>
    <?php $pageCss = 'pages/index.css'; include __DIR__ . '/includes/design-head.php'; ?>
</head>

<body class="bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface selection:bg-secondary-fixed selection:text-on-secondary-fixed transition-colors duration-300<?= deportivo_admin_body_class() ?>">

    <?php include __DIR__ . '/includes/site-nav.php'; ?>
    <?php $defaultCategoriaId = 0; include dirname(__DIR__) . '/administrador/includes/admin-panel.php'; ?>

    <main>
        <section class="hero-globe reveal" aria-label="El mundo VEMA">
            <div class="hero-globe-stage">
                <div class="hero-globe-canvas-wrap" data-globe-root>
                    <canvas data-globe-canvas></canvas>
                    <p class="hero-globe-hint font-label-sm text-label-sm uppercase tracking-widest">Desliza en cualquier dirección</p>
                </div>
            </div>

            <h1 class="hero-globe-title font-display-lg text-display-lg-mobile md:text-display-lg uppercase">
                ¿Y si conquistamos<br/>el mundo juntos?
            </h1>
        </section>

        <div class="marquee-wrap" aria-hidden="true">
            <div class="marquee-track">
                <?php
                $marquee = ['Dry-Fit', 'Secado rápido', 'Transpirable', 'Ligera', 'Compresión', 'Corte atlético', 'Estilo street', 'Envío a todo el país'];
                foreach (array_merge($marquee, $marquee) as $item) : ?>
                <span class="marquee-item"><span class="marquee-dot"></span><?= $item ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <section class="py-24 px-margin-mobile md:px-margin-desktop max-w-container-max-width mx-auto reveal">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
                <div>
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-3">Colección</span>
                    <h2 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed uppercase">Camisetas<br class="hidden md:block"/> hechas para rendir</h2>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-sm">Una muestra de lo que hay en el catálogo. Elige talla y lleva una prenda lista para entrenar o el día a día.</p>
            </div>
            <?php if (!empty($muestraCamisetas)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php foreach ($muestraCamisetas as $index => $camiseta): ?>
                <?php
                    $productoUrl = $clienteViewsPath . 'producto.php?id=' . (int) $camiseta['id'];
                    $imagenUrl = Producto::urlImagen($camiseta['imagen_principal'] ?? '', false);
                    $num = str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
                ?>
                <a href="<?= htmlspecialchars($productoUrl) ?>" class="sport-card text-white block no-underline hover:opacity-95 transition-opacity">
                    <span class="sport-card-num"><?= $num ?></span>
                    <img src="<?= htmlspecialchars($imagenUrl) ?>" alt="<?= htmlspecialchars($camiseta['nombre']) ?>" loading="lazy"<?= deportivo_admin_product_img((int) $camiseta['id']) ?> />
                    <div class="sport-card-overlay"></div>
                    <div class="sport-card-label">
                        <p class="font-label-sm text-label-sm uppercase tracking-widest opacity-80 mb-1"><?= Producto::formatearPrecio((float) $camiseta['precio']) ?></p>
                        <p class="font-headline-sm text-headline-sm uppercase"><?= htmlspecialchars($camiseta['nombre']) ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <br>
            <div class="mt-12 flex justify-center">
                <a href="<?= htmlspecialchars($catalogoCamisetas) ?>" class="inline-flex items-center gap-2 bg-secondary text-on-secondary px-10 py-4 font-label-md text-label-md uppercase tracking-widest hover:opacity-90 transition-all no-underline">
                    Ver catálogo
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>
        </section>

        <section class="coming-soon-band reveal">
            <div class="coming-soon-inner px-margin-mobile md:px-margin-desktop">
                <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg uppercase leading-none mb-6">
                    Nueva colección<br/>próximamente
                </h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-lg mx-auto mb-8">
                    Sé el primero en enterarte de nuestras próximas colecciones. Sigue los siguientes pasos y te mantendremos informados.
                </p>
                <a href="<?= htmlspecialchars($clienteViewsPath . 'login.php') ?>" class="inline-flex items-center gap-2 bg-secondary text-on-secondary px-10 py-4 font-label-md text-label-md uppercase tracking-widest hover:opacity-90 transition-all no-underline">
                    Registrarse
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>
        </section>

        <section class="py-24 px-margin-mobile md:px-margin-desktop max-w-container-max-width mx-auto reveal">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img class="w-full h-full object-cover" alt="Detalle de camiseta deportiva Dry-Fit"
                            src="<?= deportivo_img('crossfit', 'md') ?>" loading="lazy"<?= deportivo_admin_site_img('crossfit') ?> />
                    </div>
                </div>
                <div>
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-4">VEMA</span>
                    <h2 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed uppercase mb-6 leading-tight">
                        CONOCE NUESTRA<br/><span class="text-secondary">HISTORIA</span>
                    </h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant mb-8 leading-relaxed">
                        Conoce más a fondo esta linda iniciativa y como nació esta idea en una casa del sur de Medellín.
                    </p>
                    <a href="<?= htmlspecialchars($clienteViewsPath . 'nosotros.php') ?>" class="inline-flex items-center gap-2 font-label-md uppercase tracking-widest text-primary border-b-2 border-secondary pb-1 hover:gap-4 transition-all no-underline">
                        NOSOTROS <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </section>

    </main>

    <?php include __DIR__ . '/includes/site-footer.php'; ?>

    <script>
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
    </script>
    <script type="importmap">
    {
        "imports": {
            "three": "https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js",
            "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.160.0/examples/jsm/"
        }
    }
    </script>
    <script type="module" src="<?= htmlspecialchars($clienteJsPath) ?>globe-hero.js"></script>
    <?php $cartPart = 'modal'; include __DIR__ . '/includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>

</html>
