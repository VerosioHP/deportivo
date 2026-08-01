<?php

$authInViews = true;
require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once __DIR__ . '/../includes/sport-images.php';

$navInViews = true;
$activePage = 'nosotros';
$cartBasePath = $assetBase;
$cartUrl = 'carrito_compras.php';
$catalogoUrl = 'catalogo.php?categoria=camisetas';

$medellinFotos = [
    ['key' => 'medellin_1', 'alt' => 'Vista de Medellín entre montañas', 'label' => 'Medellín'],
    ['key' => 'medellin_2', 'alt' => 'Calles y ritmo de la ciudad', 'label' => 'La ciudad'],
    ['key' => 'medellin_3', 'alt' => 'Paisaje urbano de Antioquia', 'label' => 'Antioquia'],
    ['key' => 'medellin_4', 'alt' => 'Montañas alrededor del valle', 'label' => 'El valle'],
    ['key' => 'medellin_5', 'alt' => 'Horizonte natural de la región', 'label' => 'Horizonte'],
    ['key' => 'medellin_6', 'alt' => 'Ambiente de ciudad viva', 'label' => 'Calle'],
];
?>
<!doctype html>

<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Nuestra Historia | VEMA</title>
    <?php $pageCss = 'pages/nosotros.css'; include __DIR__ . '/../includes/design-head.php'; ?>
</head>
<body class="bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface selection:bg-secondary-fixed selection:text-on-secondary-fixed transition-colors duration-300<?= deportivo_admin_body_class() ?>">

    <?php include __DIR__ . '/../includes/site-nav.php'; ?>
    <?php include dirname(__DIR__, 2) . '/administrador/includes/admin-panel.php'; ?>

    <main class="nosotros-page">
        <!-- Apertura tipográfica (sin imagen ancha) -->
        <section class="nosotros-intro editorial-reveal">
            <h1 class="nosotros-intro-title font-display-lg uppercase">
                Nacimos en una casa.<br/>
                <span class="text-secondary">Crecemos con la ciudad.</span>
            </h1>
            <p class="nosotros-intro-lead font-body-lg text-on-surface-variant">
                VEMA es una marca de camisetas deportivas con alma street. Esta es nuestra historia —por ahora simulada—
                inspirada en Medellín, en el entrenamiento diario y en la idea de conquistar el mundo juntos.
            </p>
        </section>

        <!-- Mosaico Medellín (imágenes desde admin) -->
        <section class="nosotros-mosaic editorial-reveal" aria-label="Medellín">
            <?php foreach ($medellinFotos as $i => $foto): ?>
            <?php
                $src = deportivo_img_ctx($foto['key'], $i < 2 ? 'lg' : 'md');
                $tieneImg = $src !== '';
            ?>
            <figure class="nosotros-mosaic-item nosotros-mosaic-item--<?= $i + 1 ?><?= $tieneImg ? '' : ' is-empty' ?>">
                <img
                    src="<?= $tieneImg ? htmlspecialchars($src) : '' ?>"
                    alt="<?= htmlspecialchars($foto['alt']) ?>"
                    loading="<?= $i < 2 ? 'eager' : 'lazy' ?>"
                    <?= deportivo_admin_site_img($foto['key']) ?>
                />
                <figcaption class="font-label-sm text-label-sm uppercase tracking-widest"><?= htmlspecialchars($foto['label']) ?></figcaption>
            </figure>
            <?php endforeach; ?>
        </section>

        <!-- Origen -->
        <section class="nosotros-story editorial-reveal">
            <div class="nosotros-story-grid">
                <div>
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-4">El origen</span>
                    <h2 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed uppercase mb-6 leading-tight">
                        Una idea en el<br/>sur de Medellín
                    </h2>
                </div>
                <div class="space-y-5 font-body-lg text-on-surface-variant leading-relaxed">
                    <p>
                        Todo empezó en una casa del sur de la ciudad: un espacio sencillo, conversaciones largas
                        y la certeza de que Medellín se mueve —entrena, camina, vive— con una energía propia.
                    </p>
                    <p>
                        Queríamos una camiseta que rindiera de verdad: tela Dry-Fit, corte atlético y un look
                        que se sintiera street, no de laboratorio. Así nació VEMA: una marca local con ambición global.
                    </p>
                    <p class="font-label-md text-label-md text-primary uppercase tracking-widest pt-2">
                        * Texto simulado · se reemplazará con la historia real
                    </p>
                </div>
            </div>
        </section>

        <!-- Línea de tiempo simulada
        <section class="nosotros-timeline editorial-reveal">
            <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-10 text-center">El camino</span>
            <ol class="nosotros-timeline-list">
                <li>
                    <span class="nosotros-timeline-year">01</span>
                    <h3 class="font-headline-sm text-headline-sm uppercase mb-2">La casa</h3>
                    <p class="font-body-md text-on-surface-variant">Bocetos, primeras pruebas de tela y la decisión de enfocarnos solo en camisetas.</p>
                </li>
                <li>
                    <span class="nosotros-timeline-year">02</span>
                    <h3 class="font-headline-sm text-headline-sm uppercase mb-2">La calle</h3>
                    <p class="font-body-md text-on-surface-variant">Salimos a entrenar con lo que fabricábamos. Medellín fue nuestro primer laboratorio.</p>
                </li>
                <li>
                    <span class="nosotros-timeline-year">03</span>
                    <h3 class="font-headline-sm text-headline-sm uppercase mb-2">La marca</h3>
                    <p class="font-body-md text-on-surface-variant">VEMA toma forma: identidad, catálogo y la promesa de calidad que se siente al usarla.</p>
                </li>
                <li>
                    <span class="nosotros-timeline-year">04</span>
                    <h3 class="font-headline-sm text-headline-sm uppercase mb-2">El mundo</h3>
                    <p class="font-body-md text-on-surface-variant">Hoy soñamos en grande: que una camiseta hecha aquí acompañe a quien se mueve en cualquier ciudad.</p>
                </li>
            </ol>
        </section> -->

        <!-- Pulso interactivo VEMA -->
        <section class="nosotros-timeline editorial-reveal" data-nosotros-pulse aria-label="El pulso de VEMA">
            <div class="nosotros-pulse-inner">
                <!-- <span class="nosotros-pulse-label font-label-sm text-label-sm uppercase tracking-[0.25em]">El pulso</span> -->
                <p class="nosotros-pulse-hint font-body-md text-on-surface-variant">Toca las casillas en orden numérico. Cada una es un pedazo de nosotros.</p>

                <div class="nosotros-pulse-stage" aria-live="polite">
                    <div class="nosotros-pulse-ring" data-pulse-ring aria-hidden="true"></div>
                    <p class="nosotros-pulse-kicker font-label-sm uppercase tracking-widest" data-pulse-kicker>Empieza aquí</p>
                    <h2 class="nosotros-pulse-title font-display-lg uppercase" data-pulse-title>¿Listo para conocernos de verdad?</h2>
                    <p class="nosotros-pulse-copy font-body-lg" data-pulse-copy>Cuatro casillas. Cero discursos aburridos. Solo actitud de Medellín.</p>
                </div>

                <div class="nosotros-pulse-pads" role="group" aria-label="Beats de VEMA">
                    <button type="button" class="nosotros-pulse-pad" data-pulse-pad="casa" aria-pressed="false">
                        <span class="nosotros-pulse-pad-num">01</span>
                        <span class="nosotros-pulse-pad-name">Casa</span>
                    </button>
                    <button type="button" class="nosotros-pulse-pad" data-pulse-pad="sudor" aria-pressed="false">
                        <span class="nosotros-pulse-pad-num">02</span>
                        <span class="nosotros-pulse-pad-name">Sudor</span>
                    </button>
                    <button type="button" class="nosotros-pulse-pad" data-pulse-pad="calle" aria-pressed="false">
                        <span class="nosotros-pulse-pad-num">03</span>
                        <span class="nosotros-pulse-pad-name">Calle</span>
                    </button>
                    <button type="button" class="nosotros-pulse-pad" data-pulse-pad="mundo" aria-pressed="false">
                        <span class="nosotros-pulse-pad-num">04</span>
                        <span class="nosotros-pulse-pad-name">Mundo</span>
                    </button>
                </div>

                <p class="nosotros-pulse-finale font-label-md uppercase tracking-widest" data-pulse-finale hidden>
                    Ya nos conoces. Ahora muévete.
                    <a href="<?= htmlspecialchars($catalogoUrl) ?>" class="nosotros-pulse-finale-link">Ver camisetas</a>
                </p>
            </div>
        </section>
        <br><br>
        <!-- Qué somos -->
        <!-- <section class="nosotros-values editorial-reveal">
            <div class="nosotros-values-head">
                <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-4">Hoy</span>
                <h2 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed uppercase mb-4">Lo que nos define</h2>
                <p class="font-body-md text-on-surface-variant max-w-xl">
                    No somos una marca de mil categorías. Somos camisetas hechas para entrenar, salir y sentirte bien.
                </p>
            </div>
            <ul class="nosotros-values-list">
                <li>
                    <span class="font-label-sm text-secondary uppercase tracking-widest">01</span>
                    <strong class="font-headline-sm uppercase">Medellín primero</strong>
                    <p class="font-body-md text-on-surface-variant">Nuestra identidad nace del valle, de sus montañas y de su gente activa.</p>
                </li>
                <li>
                    <span class="font-label-sm text-secondary uppercase tracking-widest">02</span>
                    <strong class="font-headline-sm uppercase">Tela que rinde</strong>
                    <p class="font-body-md text-on-surface-variant">Dry-Fit, secado rápido y corte pensado para moverte sin límites.</p>
                </li>
                <li>
                    <span class="font-label-sm text-secondary uppercase tracking-widest">03</span>
                    <strong class="font-headline-sm uppercase">Street con actitud</strong>
                    <p class="font-body-md text-on-surface-variant">Del gym a la calle: la misma prenda, el mismo carácter.</p>
                </li>
            </ul>
        </section> -->

        <!-- CTA -->


    
    </main>

    <?php $navInViews = true; include __DIR__ . '/../includes/site-footer.php'; ?>

    <script src="<?= htmlspecialchars($clienteJsPath) ?>nosotros-pulse.js"></script>
    <script>
        const obs = new IntersectionObserver((entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) e.target.classList.add('visible');
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('.editorial-reveal').forEach((el) => obs.observe(el));
    </script>
    <?php $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>
</html>
