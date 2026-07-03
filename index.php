<?php

$authInViews = false;
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/sport-images.php';

$navInViews = false;
$cartBasePath = '';
$cartUrl = 'views/carrito_compras.php';
?>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>DEPORTIVO — Ropa deportiva</title>
    <script src="js/theme-init.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&amp;family=Oswald:wght@500;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/site.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/theme.css">
    <script src="js/tailwind-theme.js"></script>
</head>

<body class="bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface selection:bg-secondary-fixed selection:text-on-secondary-fixed transition-colors duration-300">

    <?php include __DIR__ . '/includes/site-nav.php'; ?>
    <?php include __DIR__ . '/includes/admin-bar.php'; ?>

    <main>
        <section class="hero-grid reveal">
            <div class="relative flex flex-col justify-center px-margin-mobile md:px-margin-desktop py-16 lg:py-0 lg:pl-margin-desktop lg:pr-8 order-2 lg:order-1">
                <div class="hero-accent-line hidden lg:block"></div>
                <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.3em] mb-6 block">Multideporte · 2026</span>
                <h1 class="font-display-lg text-[2.5rem] md:text-display-lg leading-[1.05] text-primary dark:text-primary-fixed uppercase mb-6">
                    Muévete<br/><span class="text-secondary">sin límites</span>
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-md mb-10 leading-relaxed">
                    Camisetas y pantalonetas para correr, entrenar, competir y vivir en movimiento. Un solo equipamiento, todos los deportes.
                </p>
                <div class="flex flex-wrap gap-4 mb-12">
                    <a class="inline-flex items-center gap-2 bg-secondary text-on-secondary px-8 py-4 font-label-md text-label-md uppercase tracking-widest hover:opacity-90 transition-all no-underline" href="views/catalogo.php?categoria=camisetas">
                        Explorar tienda
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                    <a class="inline-flex items-center gap-2 border border-primary text-primary px-8 py-4 font-label-md text-label-md uppercase tracking-widest hover:bg-surface-container transition-all no-underline" href="views/catalogo.php?categoria=pantalonetas">
                        Pantalonetas
                    </a>
                </div>
                <div class="flex gap-10">
                    <div class="hero-stat">
                        <p class="font-display-lg text-headline-md text-primary dark:text-primary-fixed leading-none">50+</p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest mt-1">Referencias</p>
                    </div>
                    <div class="hero-stat">
                        <p class="font-display-lg text-headline-md text-primary dark:text-primary-fixed leading-none">Dry-Fit</p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest mt-1">Tecnología</p>
                    </div>
                </div>
            </div>

            <div class="hero-visual order-1 lg:order-2">
                <img class="hero-img-main" alt="Corredor en carretera con ropa técnica deportiva"
                    src="<?= deportivo_img('hero_main', 'xl') ?>" />
                <div class="absolute inset-0 bg-gradient-to-r from-black/30 via-transparent to-transparent lg:bg-gradient-to-l lg:from-black/20 lg:via-transparent"></div>
                <div class="hero-img-stack">
                    <img alt="Entrenamiento de fuerza" src="<?= deportivo_img('gym', 'xs') ?>" />
                    <img alt="Atletismo en pista" src="<?= deportivo_img('cycling', 'xs') ?>" />
                    <img alt="Tenis en pista" src="<?= deportivo_img('tennis', 'xs') ?>" />
                    <img alt="Natación en piscina" src="<?= deportivo_img('swimming', 'xs') ?>" />
                </div>
            </div>
        </section>

        <div class="marquee-wrap" aria-hidden="true">
            <div class="marquee-track">
                <?php
                $deportes = ['Running', 'CrossFit', 'Ciclismo', 'Tenis', 'Básquet', 'Natación', 'Yoga', 'Boxeo', 'Atletismo', 'Gimnasio', 'Trail', 'Funcional'];
                foreach (array_merge($deportes, $deportes) as $dep) : ?>
                <span class="marquee-item"><span class="marquee-dot"></span><?= $dep ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <section class="py-24 px-margin-mobile md:px-margin-desktop max-w-container-max-width mx-auto reveal">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
                <div>
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-3">Para cada disciplina</span>
                    <h2 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed uppercase">Un deporte,<br class="hidden md:block"/> una energía</h2>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-sm">Ropa que se adapta a tu ritmo — en la pista, el gimnasio, la cancha o la carretera.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
                <?php foreach (deportivo_sport_cards() as $card) : ?>
                <a href="views/catalogo.php?categoria=camisetas" class="sport-card no-underline text-white block">
                    <span class="sport-card-num"><?= $card['num'] ?></span>
                    <img src="<?= deportivo_img($card['key'], 'sm') ?>" alt="<?= htmlspecialchars($card['alt']) ?>" loading="lazy" />
                    <div class="sport-card-overlay"></div>
                    <div class="sport-card-label">
                        <p class="font-label-sm text-label-sm uppercase tracking-widest opacity-80 mb-1">Deporte</p>
                        <p class="font-headline-sm text-headline-sm uppercase"><?= $card['name'] ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 reveal">
            <a href="views/catalogo.php?categoria=camisetas" class="cat-panel no-underline group">
                <img class="cat-panel-bg" alt="Camisetas deportivas técnicas" src="<?= deportivo_img('camisetas', 'lg') ?>" loading="lazy" />
                <div class="cat-panel-content text-white">
                    <span class="font-label-sm text-label-sm uppercase tracking-[0.25em] text-secondary mb-3 block">Categoría</span>
                    <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg uppercase leading-none mb-4">Camisetas</h2>
                    <p class="font-body-md opacity-80 max-w-xs mb-6">Dry-Fit, compresión y ventilación para cualquier intensidad.</p>
                    <span class="inline-flex items-center gap-2 font-label-md uppercase tracking-widest border-b border-secondary pb-1 group-hover:gap-4 transition-all">
                        Ver colección <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </span>
                </div>
            </a>
            <a href="views/catalogo.php?categoria=pantalonetas" class="cat-panel no-underline group">
                <img class="cat-panel-bg" alt="Pantalonetas deportivas" src="<?= deportivo_img('pantalonetas', 'lg') ?>" loading="lazy" />
                <div class="cat-panel-content text-white">
                    <span class="font-label-sm text-label-sm uppercase tracking-[0.25em] text-secondary mb-3 block">Categoría</span>
                    <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg uppercase leading-none mb-4">Pantalonetas</h2>
                    <p class="font-body-md opacity-80 max-w-xs mb-6">Ligeras, elásticas y diseñadas para no frenarte.</p>
                    <span class="inline-flex items-center gap-2 font-label-md uppercase tracking-widest border-b border-secondary pb-1 group-hover:gap-4 transition-all">
                        Explorar <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </span>
                </div>
            </a>
        </section>

        <section class="py-24 px-margin-mobile md:px-margin-desktop max-w-container-max-width mx-auto reveal">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img class="w-full h-full object-cover" alt="CrossFit y entrenamiento funcional"
                            src="<?= deportivo_img('crossfit', 'md') ?>" loading="lazy" />
                    </div>
                    <div class="absolute -bottom-6 -left-4 md:-left-8 bg-secondary text-on-secondary px-6 py-4 font-headline-sm text-headline-sm uppercase tracking-widest">Temporada 2026</div>
                </div>
                <div>
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-4">Innovación textil</span>
                    <h2 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed uppercase mb-6 leading-tight">
                        Diseñado para<br/><span class="text-secondary">cada movimiento</span>
                    </h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant mb-8 leading-relaxed">
                        Maratón, gym, tenis o básquet: nuestros tejidos regulan la temperatura, secan al instante y se estiran contigo.
                    </p>
                    <div class="flex flex-wrap gap-3 mb-10">
                        <span class="tech-pill"><span class="material-symbols-outlined text-secondary text-base">water_drop</span> Secado rápido</span>
                        <span class="tech-pill"><span class="material-symbols-outlined text-secondary text-base">air</span> Transpirable</span>
                        <span class="tech-pill"><span class="material-symbols-outlined text-secondary text-base">fitness_center</span> 4-way stretch</span>
                        <span class="tech-pill"><span class="material-symbols-outlined text-secondary text-base">eco</span> Reciclados</span>
                    </div>
                    <a href="views/nosotros.php" class="inline-flex items-center gap-2 font-label-md uppercase tracking-widest text-primary border-b-2 border-secondary pb-1 hover:gap-4 transition-all no-underline">
                        Nuestra historia <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </section>

        <section class="newsletter-band py-20 px-margin-mobile md:px-margin-desktop reveal">
            <div class="max-w-container-max-width mx-auto relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-10">
                <div>
                    <h3 class="font-headline-md text-headline-md text-white uppercase mb-3">Únete al equipo</h3>
                    <p class="font-body-md text-white/60 max-w-sm">Lanzamientos, ofertas y consejos de entrenamiento.</p>
                </div>
                <form class="flex flex-col sm:flex-row gap-0 w-full md:max-w-md border border-white/20">
                    <input class="flex-grow bg-transparent border-none py-4 px-5 focus:ring-0 placeholder:text-white/40 text-white font-body-md" placeholder="tu@email.com" type="email" />
                    <button type="button" class="py-4 px-8 bg-secondary text-on-secondary font-label-md uppercase tracking-widest hover:opacity-90 transition-opacity whitespace-nowrap">Suscribirse</button>
                </form>
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
    <?php $cartPart = 'modal'; include __DIR__ . '/includes/cart-widget.php'; ?>
    <?php include __DIR__ . '/includes/admin-modal.php'; ?>
    <script src="js/theme.js"></script>
</body>

</html>
