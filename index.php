<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="js/theme-init.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&amp;family=Playfair+Display:ital,wght@0,500;0,600;1,500&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/theme.css">
    <script src="js/app.js"></script>
</head>

<body class="bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface selection:bg-secondary-fixed selection:text-on-secondary-fixed transition-colors duration-300">
    <!-- TopNavBar -->
    <nav class="w-full top-0 sticky bg-surface dark:bg-on-background border-b border-outline-variant dark:border-outline z-50">
        <div class="flex justify-between items-center px-margin-desktop py-4 max-w-container-max-width mx-auto">
            <a class="font-headline-md text-headline-md font-semibold text-primary dark:text-primary-fixed no-underline hover:opacity-80 transition-opacity" href="index.php">DENIM EDITORIAL</a>

            <div class="hidden md:flex gap-8">
                <a class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300 transition-opacity duration-200 active:opacity-70" href="views/catalogo.php?categoria=jeans">Catálogo</a>

                <a class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300 transition-opacity duration-200 active:opacity-70" href="views/catalogo.php?categoria=camisetas">Camisetas</a>

                <a class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300 transition-opacity duration-200 active:opacity-70" href="views/catalogo.php?categoria=chaquetas">Chaquetas</a>

                <a class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300 transition-opacity duration-200 active:opacity-70" href="views/nosotros.php">Nosotros</a>
            </div>
            
            <div class="flex items-center gap-6 text-primary dark:text-primary-fixed">
                <button type="button" class="transition-opacity duration-200 active:opacity-70"><span class="material-symbols-outlined">search</span></button>
                <?php $cartBasePath = ''; $cartUrl = 'views/carrito_compras.php'; $cartPart = 'button'; include __DIR__ . '/includes/cart-widget.php'; ?>
                <a class="transition-opacity duration-200 active:opacity-70 text-current" href="views/login.php" aria-label="Cuenta"><span class="material-symbols-outlined">person</span></a>
                <button type="button" data-theme-toggle class="theme-toggle transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed" aria-label="Activar modo oscuro" aria-pressed="false">
                    <span class="material-symbols-outlined theme-toggle-icon">dark_mode</span>
                </button>
            </div>
        </div>
    </nav>
    <main>
        <!-- Hero Section -->
        <section class="relative h-[921px] flex items-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img class="w-full h-full object-cover" data-alt="A cinematic, high-fashion editorial shot of a woman wearing premium dark wash high-waisted jeans against a minimalist architectural background. The lighting is soft and directional, casting subtle shadows that highlight the texture and craftsmanship of the denim. The color palette is sophisticated with deep indigo, cream, and warm wood tones. The mood is confident, calm, and effortlessly elegant, reflecting a high-end fashion catalog aesthetic."
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDJwgtHx2_ojYrC_0IbCG0HS-rp26iFjcuims6zpSVhS-roJx6XCOKbkaqiz9U4SJDobxjmiz6oo-x1-EEhzdJ_OZO6DWSLkQTjIg2lgZz7AZMnkRoXYFS4NEixUOXYZ9yA_3CWCGGGBXp1sX-k6KvUbLyJ5UEjf32tKRYgw-Z5vhSk9jE7oKVguBO1yzcCqjXXGXUdW4noWpTbdBvputmsJvjL4UDhN1BryMJbhfKNRYtzQWa6anmYkZxFW4jSsfIjxpNR1cRohO2U"
                />
                <div class="absolute inset-0 bg-primary/10"></div>
            </div>
            <div class="relative z-10 px-margin-desktop max-w-container-max-width mx-auto w-full">
                <div class="max-w-2xl bg-surface/80 dark:bg-on-background/80 backdrop-blur-md p-10 md:p-16 border-l-4 border-secondary">
                    <h1 class="font-display-lg text-display-lg md:text-display-lg mb-6 text-primary dark:text-primary-fixed leading-tight">La Edición Denim: <br/><span class="italic font-normal">Tu Estilo, Tu Ajuste</span></h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-md">Una curaduría de siluetas atemporales diseñadas para la mujer moderna que valora la calidad y el diseño impecable.</p>
                    <a class="inline-block bg-primary text-on-primary px-10 py-4 font-label-md text-label-md uppercase tracking-widest hover:bg-secondary transition-all duration-300 no-underline text-center" href="views/catalogo.php">
                        Explorar Colección
                    </a>
                </div>
            </div>
        </section>
        <!-- Categories Bento Grid -->
        <section class="py-24 px-margin-desktop max-w-container-max-width mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div>
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.2em] block mb-2">Colección Permanente</span>
                    <h2 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed">Siluetas Escenciales</h2>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-xs border-l border-outline-variant pl-6">
                    Desde el talle más alto hasta la bota más ancha, cada pieza está construida con denim de origen premium.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter-desktop auto-rows-[300px] md:auto-rows-[400px]">
                <!-- High Rise -->
                <div class="md:col-span-8 group relative overflow-hidden bg-surface-container dark:bg-tertiary-container">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="A sophisticated editorial vertical shot focusing on a high-rise denim silhouette styled with a crisp white poplin shirt tucked in. The setting is a bright, sun-drenched studio with minimalist props. The lighting creates clean lines and a high-key airy feel. Palette focuses on bright whites and classic indigo blue. The aesthetic is clean, modern, and editorial."
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0WxyzEZiefFYR4-X6-KcIZc3htVqS5W-s1uYC_RrzA8S4h8bGcOxOrl_mJv7rCMMzOxwvmanB-VXX0xGUg0vBS_NPWka6V7PGESzxp0BmK73yx5cVyZXzcrXSS7sQgO1YsfpGTKhGpuTJPQ6fd5Ok--JBNjwZZg47M7gRmQ_LQSWAncySvlyErl0IQV4o4EfIuGN0tymD2bFA2_GrU0qel93-o9E3tlM1XsihjJoSBqAXyEOIVomQET_01fuAFQMePGmHarNOAyXo"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="absolute bottom-8 left-8 text-white">
                        <h3 class="font-headline-sm text-headline-sm mb-2">Talle alto</h3>
                        <a class="font-label-md text-label-md underline underline-offset-4 text-white" href="views/catalogo.php">Comprar Silueta</a>
                    </div>
                </div>
                <!-- Skinny -->
                <div class="md:col-span-4 group relative overflow-hidden bg-surface-container dark:bg-tertiary-container">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="A detailed lifestyle shot of slim-fit skinny jeans paired with minimalist leather loafers and a cashmere sweater. The perspective is from a low angle, emphasizing the clean lines of the tailoring. The environment is a sophisticated urban street with muted grey and beige tones. Soft daylight highlights the premium stretch fabric of the denim."
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuChQmDbzzbfw3XzDo4izDyf6zNYW4St6S9icw7cvrZ4d_ljlPyusV5n5Xs4YUAttEzw2NkxBnXBnCKbEH5uJ8YFHEGxaQN3k8xgrnfH78m7wYUrtoqIwc209Z5wOvHA-l4aiB_kCpqwUkBAIQRQcYY59Fmtz9TT6H-48_52XbnwUo0hayN50ZqsfeFGcIcTs5uq6NPIIO-XjT8_1w1IPFHS4sJFuQUQjl8SXKC2F6xnfYHnGYkt9ln62lZXoZiqTx7wdqD-aMPWkygW"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-8 left-8 text-white">
                        <h3 class="font-headline-sm text-headline-sm mb-2">Skinny</h3>
                        <a class="font-label-md text-label-md underline underline-offset-4 text-white" href="views/producto.php?id=7">Ver Detalles</a>
                    </div>
                </div>
                <!-- Wide Leg Featured -->
                <div class="md:col-span-4 group relative overflow-hidden bg-surface-container dark:bg-tertiary-container">
                    <div class="absolute inset-0 flex items-center justify-center p-8 bg-secondary/5 border-2 border-secondary/10">
                        <div class="text-center">
                            <h3 class="font-display-lg text-display-lg-mobile text-primary mb-4 italic">El Nuevo Clásico</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-6">Descubre la libertad de movimiento con nuestra línea de pierna ancha.</p>
                            <span class="material-symbols-outlined text-4xl text-secondary">expand</span>
                        </div>
                    </div>
                </div>
                <!-- Wide Leg Image -->
                <div class="md:col-span-8 group relative overflow-hidden bg-surface-container dark:bg-tertiary-container">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="A dynamic fashion photograph of a woman walking in wide-leg denim jeans, capturing the movement and drape of the fabric. The setting is a minimalist concrete architecture with dramatic sun shadows. The palette is neutral with emphasizes on the denim's rich texture. Editorial composition with lots of white space around the subject, creating a premium feel."
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCNanJRLOsAURKPm-HU8GAEeyPicU5WQuZsD0IPuI1RPkp51SOuogFcXUKFbWbIun_XkufDqUv2PF4ulPVLgRSmLwlPUvINXobORPtxRTuYYCle9onLf583RntLscvOOGC8CBUNi2OzpUtTyELZk3umIwpJPI0BnMhFzqi6_vkEaULxt7BiBPETbQk3NZpwajFgepyYqiVIuJZ1ght9dtyQRnYiwO4QnVXWzHgoG69k4OlyYnL2hF1iFjUtnlczTGq1IXXRLVHZ5-mK"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-8 left-8 text-white">
                        <h3 class="font-headline-sm text-headline-sm mb-2">Pierna ancha</h3>
                        <a class="font-label-md text-label-md underline underline-offset-4 text-white" href="views/catalogo.php">Explorar</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Editorial Lookbook Section -->
        <section class="bg-surface-container-low dark:bg-tertiary-container py-32">
            <div class="px-margin-desktop max-w-container-max-width mx-auto flex flex-col md:flex-row items-center gap-16">
                <div class="w-full md:w-1/2 relative">
                    <div class="aspect-[4/5] overflow-hidden">
                        <img class="w-full h-full object-cover" data-alt="A vertical editorial portrait of a fashion model in a monochromatic denim outfit. She is seated on a minimal stone bench against a beige wall. The lighting is diffused and warm, creating a soft, luxury feel. The palette is composed of various shades of blue and neutral earth tones. High-end fashion editorial style with an emphasis on craftsmanship and texture."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDxSli2Bqpd-_-Nz5Im0VbNYQTkaLnACYQzQENwUdjqjPZfCWvVPQ_scMUjVLoBIKA3HKZhUb9XG0fnmtR3RPctVTtjrp6fcnlUyzgZBhXZfNoyjjiKoNE2yhbklF4ZGu6MyEXAQiOSCbzwpsCLdF9BxepoSH04hqj25lcbXZqVaULojghAJXV53cTF1Fr7PDE5H2xjsLUv8KtOUyq1X_mVJeErc_KITPiox3lxNvYuGj40fBzM26yWolkUV-435wtcZ9vPy_Tj8DlJ"
                        />
                    </div>
                    <div class="absolute -bottom-8 -right-8 w-48 h-48 bg-secondary/10 backdrop-blur-sm p-4 hidden md:flex items-center justify-center border border-secondary/20">
                        <p class="font-label-sm text-label-sm text-secondary text-center leading-relaxed">COLECCIÓN OTOÑO / INVIERNO 2024</p>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-widest block mb-4">El Lookbook</span>
                    <blockquote class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary dark:text-primary-fixed leading-tight mb-8">
                        "El denim no es solo una prenda, es un lienzo de expresión personal y <span class="italic">comodidad eterna</span>."
                    </blockquote>
                    <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 leading-relaxed">
                        Nuestra visión editorial fusiona la rudeza histórica del denim con la sofisticación de la alta costura. Cada remache, cada costura y cada lavado ha sido perfeccionado para ofrecer una experiencia táctil sin precedentes.
                    </p>
                    <div class="flex gap-4">
                        <button class="bg-primary text-on-primary px-8 py-3 font-label-md text-label-md hover:bg-secondary transition-colors">Comprar el Look</button>
                        <button class="border border-primary text-primary px-8 py-3 font-label-md text-label-md hover:bg-primary hover:text-on-primary transition-colors">Ver Editorial</button>
                    </div>
                </div>
            </div>
        </section>
        <!-- Newsletter Minimal -->
        <section class="py-24 px-margin-desktop max-w-container-max-width mx-auto text-center">
            <div class="max-w-2xl mx-auto">
                <h3 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed mb-4">Únete a la Edición</h3>
                <p class="font-body-md text-body-md text-on-surface-variant mb-12">Recibe actualizaciones sobre nuevos lanzamientos, eventos exclusivos y consejos de estilo editorial directamente en tu correo.</p>
                <form class="flex flex-col md:flex-row gap-0 border-b border-outline">
                    <input class="flex-grow bg-transparent border-none py-4 px-0 focus:ring-0 placeholder:text-outline text-body-md" placeholder="Tu correo electrónico" type="email" />
                    <button class="py-4 px-8 font-label-md text-label-md uppercase tracking-widest text-primary hover:text-secondary transition-colors">Suscribirse</button>
                </form>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="w-full mt-20 bg-surface-container-low dark:bg-tertiary-container">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter-desktop px-margin-desktop py-16 max-w-container-max-width mx-auto">
            <div>
                <a class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed mb-6 block hover:opacity-80 transition-opacity no-underline" href="index.php">DENIM EDITORIAL</a>
                <p class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container max-w-xs">
                    Redefiniendo el lujo cotidiano a través de la maestría en denim. Calidad que perdura, estilo que trasciende.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div class="flex flex-col gap-4">
                    <h4 class="font-label-sm text-label-sm text-primary dark:text-primary-fixed uppercase tracking-widest">Tienda</h4>
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="views/catalogo.php">Nuevos Ingresos</a>
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="views/producto.php">Más Vendidos</a>
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="views/catalogo.php">Colecciones</a>
                </div>
                <div class="flex flex-col gap-4">
                    <h4 class="font-label-sm text-label-sm text-primary dark:text-primary-fixed uppercase tracking-widest">Soporte</h4>
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="views/login.php">Newsletter</a>
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="views/catalogo.php">Envíos</a>
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="views/login.php">Contacto</a>
                </div>
            </div>
            <div class="flex flex-col justify-between items-start md:items-end">
                <div class="flex gap-6 mb-8">
                    <a class="text-on-surface-variant hover:text-primary transition-colors" href="#"><span class="material-symbols-outlined">share</span></a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors" href="#"><span class="material-symbols-outlined">camera</span></a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors" href="#"><span class="material-symbols-outlined">mail</span></a>
                </div>
                <div class="text-left md:text-right">
                    <div class="flex flex-wrap gap-4 mb-4 justify-start md:justify-end">
                        <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary" href="views/login.php">Privacidad</a>
                        <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary" href="views/login.php">Términos</a>
                    </div>
                    <p class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container opacity-60">© 2024 DENIM EDITORIAL. TODOS LOS DERECHOS RESERVADOS.</p>
                </div>
            </div>
        </div>
    </footer>
    <script>
        // Simple reveal animation on scroll
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-8');
                }
            });
        }, observerOptions);

        document.querySelectorAll('section').forEach(section => {
            section.classList.add('transition-all', 'duration-1000', 'opacity-0', 'translate-y-8');
            observer.observe(section);
        });
    </script>
    <?php $cartBasePath = ''; $cartUrl = 'views/carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/includes/cart-widget.php'; ?>
    <script src="js/theme.js"></script>
</body>

</html>