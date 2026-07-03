<?php

require_once __DIR__ . '/../includes/sport-images.php';

$navInViews = true;
$activePage = 'nosotros';
$cartBasePath = '../';
$cartUrl = 'carrito_compras.php';
?>
<!doctype html>

<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Nuestra Historia | DEPORTIVO</title>
    <script src="../js/theme-init.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&amp;family=DM+Sans:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css/site.css">
    <link rel="stylesheet" href="../css/nosotros.css">
    <link rel="stylesheet" href="../css/theme.css">
    <script src="../js/tailwind-theme.js"></script>
</head>
<body class="bg-background dark:bg-on-background text-on-surface dark:text-inverse-on-surface selection:bg-secondary-fixed selection:text-on-secondary-fixed transition-colors duration-300">

    <?php include __DIR__ . '/../includes/site-nav.php'; ?>

    <main>
        <section class="page-hero min-h-[70vh]">
            <img src="<?= deportivo_img('nosotros_hero', 'xl') ?>" alt="Atletas en pista de atletismo" />
            <div class="absolute inset-0 bg-black/45"></div>
            <div class="page-hero-content text-white text-center flex flex-col items-center justify-end pb-20">
                <h1 class="font-display-lg text-display-lg md:text-[72px] leading-none mb-4 uppercase">Nuestra Historia</h1>
                <div class="w-16 h-1 bg-secondary"></div>
            </div>
        </section>

        <section class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-24 editorial-reveal">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter-desktop items-center">
                <div class="md:col-span-5">
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-4">Quiénes somos</span>
                    <h2 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed mb-8 uppercase">Pasión por el movimiento</h2>
                    <p class="font-body-lg text-on-surface-variant leading-relaxed">
                        En Deportivo equipamos a quienes viven el deporte con intensidad. Correr, nadar, jugar al tenis o levantar en el gym: cada prenda está pensada para acompañar tu esfuerzo.
                    </p>
                    <p class="mt-6 font-body-md text-on-surface-variant">
                        Tejidos técnicos que regulan la temperatura, absorben el sudor y se adaptan a cada movimiento del cuerpo.
                    </p>
                </div>
                <div class="md:col-start-7 md:col-span-6">
                    <div class="aspect-[4/5] overflow-hidden">
                        <img class="w-full h-full object-cover" alt="Entrenamiento de fuerza en gimnasio" src="<?= deportivo_img('nosotros_tejido', 'md') ?>" />
                    </div>
                </div>
            </div>
        </section>

        <div class="marquee-wrap" aria-hidden="true">
            <div class="marquee-track">
                <?php foreach (array_merge(['Running','Gym','Tenis','Básquet','Natación','Yoga'], ['Running','Gym','Tenis','Básquet','Natación','Yoga']) as $d) : ?>
                <span class="marquee-item"><span class="marquee-dot"></span><?= $d ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <section class="bg-surface-container-low dark:bg-tertiary-container py-24 editorial-reveal">
            <div class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop text-center">
                <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-4">Nuestra comunidad</span>
                <h2 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed mb-12 uppercase">Para quién trabajamos</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div><p class="font-headline-sm text-primary uppercase mb-2">Activo</p><p class="text-on-surface-variant">El deporte como estilo de vida.</p></div>
                    <div><p class="font-headline-sm text-primary uppercase mb-2">Competitivo</p><p class="text-on-surface-variant">Rendimiento que marca la diferencia.</p></div>
                    <div><p class="font-headline-sm text-primary uppercase mb-2">Exigente</p><p class="text-on-surface-variant">Calidad y durabilidad en cada sesión.</p></div>
                </div>
            </div>
        </section>

        <section class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-24 editorial-reveal">
            <h2 class="font-headline-md text-headline-md text-primary text-center mb-14 uppercase">Por qué elegirnos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                $pilares = [
                    ['icon' => 'verified', 'title' => 'Calidad', 'text' => 'Tejidos probados en condiciones reales de entrenamiento.'],
                    ['icon' => 'water_drop', 'title' => 'Dry-Fit', 'text' => 'Absorbe el sudor y se seca al instante.'],
                    ['icon' => 'fitness_center', 'title' => 'Ajuste atlético', 'text' => 'Libertad total de movimiento.'],
                    ['icon' => 'all_inclusive', 'title' => 'Durabilidad', 'text' => 'Costuras reforzadas para aguantar lavado tras lavado.'],
                ];
                foreach ($pilares as $p) : ?>
                <div class="pillar-card bg-surface dark:bg-tertiary-container">
                    <span class="material-symbols-outlined text-secondary text-4xl mb-4"><?= $p['icon'] ?></span>
                    <h3 class="font-headline-sm text-primary uppercase mb-3"><?= $p['title'] ?></h3>
                    <p class="font-body-md text-on-surface-variant"><?= $p['text'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="px-margin-mobile md:px-margin-desktop pb-24 editorial-reveal">
            <div class="max-w-container-max-width mx-auto overflow-hidden h-[480px] md:h-[560px]">
                <img class="w-full h-full object-cover" alt="Gimnasio con atletas entrenando" src="<?= deportivo_img('nosotros_gym', 'xl') ?>" />
            </div>
        </section>
    </main>

    <?php $navInViews = true; include __DIR__ . '/../includes/site-footer.php'; ?>

    <script>
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.15 });
        document.querySelectorAll('.editorial-reveal').forEach(el => obs.observe(el));
    </script>
    <?php $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="../js/theme.js"></script>
</body>
</html>
