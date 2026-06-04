<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Jeans Collection | DENIM EDITORIAL</title>
    <script src="../js/theme-init.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&amp;family=Playfair+Display:wght@500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css/catalogo.css">
    <link rel="stylesheet" href="../css/theme.css">
    <script src="../js/catalogo.js"></script>
</head>

<body class="bg-background dark:bg-on-background text-on-surface dark:text-inverse-on-surface font-body-md selection:bg-secondary-container selection:text-on-secondary-container transition-colors duration-300">
    <!-- TopNavBar -->
    <header class="w-full top-0 sticky bg-surface dark:bg-on-background border-b border-outline-variant dark:border-outline z-50 transition-opacity duration-200 active:opacity-70">
        <nav class="flex justify-between items-center px-margin-desktop py-4 max-w-container-max-width mx-auto">
            <a class="font-headline-md text-headline-md font-semibold text-primary dark:text-primary-fixed no-underline hover:opacity-80 transition-opacity" href="../index.html">DENIM EDITORIAL</a>
            <div class="hidden md:flex items-center space-x-8">
                <a class="font-label-md text-label-md uppercase tracking-widest text-secondary dark:text-secondary-fixed-dim border-b-2 border-secondary pb-1 transition-colors duration-300" href="catalogo.html">Catalogo</a>
                <a class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300" href="producto.html">Tops</a>
                <a class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300" href="../index.html">Jackets</a>
                <a class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300" href="nosotros.html">Nosotros</a>
            </div>
            <div class="flex items-center space-x-6 text-primary dark:text-primary-fixed">
                <button type="button" class="material-symbols-outlined hover:text-secondary transition-colors" data-icon="search">search</button>
                <a class="material-symbols-outlined hover:text-secondary transition-colors text-current no-underline" href="carrito_compras.html" data-icon="shopping_bag" aria-label="Carrito">shopping_bag</a>
                <a class="material-symbols-outlined hover:text-secondary transition-colors text-current no-underline" href="login.html" data-icon="person" aria-label="Cuenta">person</a>
                <button type="button" data-theme-toggle class="theme-toggle transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed" aria-label="Activar modo oscuro" aria-pressed="false">
                    <span class="material-symbols-outlined theme-toggle-icon">dark_mode</span>
                </button>
            </div>
        </nav>
    </header>
    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-20">
        <!-- Editorial Header -->
        <header class="mb-16 md:mb-24">
            <h1 class="font-display-lg text-display-lg md:text-display-lg mb-4 text-primary dark:text-primary-fixed">Jeans</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl leading-relaxed">
                Explore our curated selection of premium denim. From heritage-inspired straight cuts to modern architectural silhouettes, each pair is crafted with traditional techniques and tactile quality.
            </p>
        </header>
        <div class="editorial-grid gap-gutter-desktop">
            <!-- Sidebar Filters -->
            <aside class="col-span-12 md:col-span-3 space-y-12 mb-12 md:mb-0">
                <div class="space-y-6">
                    <h3 class="font-label-sm text-label-sm uppercase text-on-surface-variant tracking-widest">Size</h3>
                    <div class="flex flex-wrap gap-2">
                        <button class="w-10 h-10 flex items-center justify-center border border-outline-variant font-label-md text-label-md hover:border-secondary transition-colors">34</button>
                        <button class="w-10 h-10 flex items-center justify-center bg-secondary text-on-primary font-label-md text-label-md">36</button>
                        <button class="w-10 h-10 flex items-center justify-center border border-outline-variant font-label-md text-label-md hover:border-secondary transition-colors">38</button>
                        <button class="w-10 h-10 flex items-center justify-center border border-outline-variant font-label-md text-label-md hover:border-secondary transition-colors">40</button>
                        <button class="w-10 h-10 flex items-center justify-center border border-outline-variant font-label-md text-label-md hover:border-secondary transition-colors">42</button>
                    </div>
                </div>
                <div class="space-y-6">
                    <h3 class="font-label-sm text-label-sm uppercase text-on-surface-variant tracking-widest">Wash</h3>
                    <ul class="space-y-3 font-body-md text-body-md">
                        <li><label class="flex items-center gap-3 cursor-pointer group"><div class="w-4 h-4 border border-outline-variant group-hover:border-secondary"></div> Raw Indigo</label></li>
                        <li><label class="flex items-center gap-3 cursor-pointer group"><div class="w-4 h-4 border border-outline-variant group-hover:border-secondary"></div> Vintage Wash</label></li>
                        <li><label class="flex items-center gap-3 cursor-pointer group"><div class="w-4 h-4 bg-primary"></div> Midnight Black</label></li>
                        <li><label class="flex items-center gap-3 cursor-pointer group"><div class="w-4 h-4 border border-outline-variant group-hover:border-secondary"></div> Bleached</label></li>
                    </ul>
                </div>
                <div class="space-y-6">
                    <h3 class="font-label-sm text-label-sm uppercase text-on-surface-variant tracking-widest">Fit</h3>
                    <ul class="space-y-3 font-body-md text-body-md">
                        <li><label class="flex items-center gap-3 cursor-pointer group"><div class="w-4 h-4 border border-outline-variant group-hover:border-secondary"></div> Heritage Straight</label></li>
                        <li><label class="flex items-center gap-3 cursor-pointer group"><div class="w-4 h-4 border border-outline-variant group-hover:border-secondary"></div> Relaxed Taper</label></li>
                        <li><label class="flex items-center gap-3 cursor-pointer group"><div class="w-4 h-4 border border-outline-variant group-hover:border-secondary"></div> Skinny Architectural</label></li>
                        <li><label class="flex items-center gap-3 cursor-pointer group"><div class="w-4 h-4 border border-outline-variant group-hover:border-secondary"></div> Wide Leg</label></li>
                    </ul>
                </div>
                <button class="w-full py-4 bg-primary text-on-primary font-label-md text-label-md uppercase tracking-widest hover:bg-opacity-90 transition-all">
                    Reset Filters
                </button>
            </aside>
            <!-- Product Grid -->
            <section class="col-span-12 md:col-span-9">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-16 gap-x-gutter-desktop">
                    <!-- Product 1: Featured Asymmetric Height -->
                    <article class="group lg:col-span-1">
                        <a href="producto.html" class="block text-inherit no-underline hover:opacity-95 transition-opacity">
                        <div class="aspect-[3/4] mb-6 overflow-hidden bg-surface-container relative">
                            <img alt="Heritage Jeans" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A detailed editorial close-up of premium raw denim jeans hanging against a neutral cream-colored textured wall. The lighting is soft and directional, highlighting the tactile twill weave and golden-orange stitching. The mood is sophisticated and minimalist, focusing on the high-quality craftsmanship of the indigo fabric in a bright, modern studio setting."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDxZZOft-DDm5baxPt-ZBTucRxF2sTLQ93cVop1v9oHO78dQajMfGCqIIQ3HXsHBgGG-CEPb6FQCrVpQT05ezXfuR6Frgl72e1p8-5xjwsDSh33VAv8E4nLps2LSWK0VhtFaw8643l_m3Ma8tBoILsicmN95k3WG-bTSeiu9bad2ekBl_hjZQKA2DIynio8K_A8Nu3HORlzq8rsLMnAVqtDhz-sfP3IuotY5Z8Wmb_LsdncpSpM1MV37N8I_DEPusOdA5cArbpgtLe4"
                            />
                            <span class="absolute top-4 left-4 bg-surface px-3 py-1 font-label-sm text-label-sm uppercase tracking-widest">Pocas unidades</span>
                        </div>
                        <div class="space-y-1">
                            <h2 class="font-headline-sm text-headline-sm">Jeans Rectos Heritage</h2>
                            <p class="font-body-md text-body-md text-secondary">$79.00</p>
                            <div class="pt-4 flex gap-2">
                                <span class="font-label-sm text-label-sm text-on-surface-variant">34, 36, 38, 40, 42</span>
                            </div>
                        </div>
                        </a>
                    </article>
                    <!-- Product 2 -->
                    <article class="group">
                        <a href="producto.html" class="block text-inherit no-underline hover:opacity-95 transition-opacity">
                        <div class="aspect-[3/4] mb-6 overflow-hidden bg-surface-container relative">
                            <img alt="Dark Wash Jeans" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="An editorial full-length shot of a model wearing dark charcoal slim-fit denim jeans, standing in a sun-drenched minimalist apartment with white floors. The lighting creates soft shadows that emphasize the architectural cut of the denim. The aesthetic is clean and premium, using a neutral color palette of off-whites and deep blues to convey quiet luxury."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAC6WNFTsmxXVr2s3BfaRjtDnwwFsJy9_Q-dgcdxh0VE0vCwN9qusIDalZxnQ1Xkg0z4hvMkW8lE3FuivIKmXAK-KyTFZtGrA1tWXeRqbQAObf04MPYczXySnkZCXK1MhpBSzc3EYMgCJCEW5GRN86B9vFNSS9nGwjdRd0P8CAlbD2aZceXJYcCy8KPXJvT6iEfI2Jjmll44-o2yfmAOTn_iEn5FZDTfC9flHPfyPbgS2J8mcJCr2P9tnYF9gQUI2cntH7FKKWOYMH2"
                            />
                            <span class="absolute top-4 left-4 bg-surface px-3 py-1 font-label-sm text-label-sm uppercase tracking-widest">Disponible</span>
                        </div>
                        <div class="space-y-1">
                            <h2 class="font-headline-sm text-headline-sm">Architectural Slim</h2>
                            <p class="font-body-md text-body-md text-secondary">$85.00</p>
                            <div class="pt-4 flex gap-2">
                                <span class="font-label-sm text-label-sm text-on-surface-variant">34, 36, 40</span>
                            </div>
                        </div>
                        </a>
                    </article>
                    <!-- Product 3 -->
                    <article class="group">
                        <a href="producto.html" class="block text-inherit no-underline hover:opacity-95 transition-opacity">
                        <div class="aspect-[3/4] mb-6 overflow-hidden bg-surface-container relative">
                            <img alt="Vintage Wash" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A stylish vertical photograph of a pair of vintage light-wash denim jeans folded neatly on a mid-century modern wooden chair. The setting is a warm, bright studio with natural light streaming through a large window. The color palette consists of soft blues, warm wood tones, and crisp white highlights, creating a tactile and nostalgic atmosphere of quality and durability."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAnwyA5PZWTfp4eqXp-Om6_0Ti0vrv1QCc02Qhg1n6shJNXPbMMuHrMEUL57wrdRgxbCQ7Q8Ayv7ciXiHBQkIKaeqfpQxUd1ZCtdReZRthwawXyMsAFoqziIESq3p66gmjOVBwul5tJxP27qatbMEpNWsG1vqBboZJmqXcxoaArmWJwEntVZWdMaVvv3xiXsRJ-D0uDBSIqQc0YyXo9cUSdcWUZAPqpiF2-DO-xArDNeejNNlpdKmG6-0skjBxUxbA5__lTs4Jhp5JC"
                            />
                            <span class="absolute top-4 left-4 bg-surface px-3 py-1 font-label-sm text-label-sm uppercase tracking-widest">Disponible</span>
                        </div>
                        <div class="space-y-1">
                            <h2 class="font-headline-sm text-headline-sm">Vintage Relaxed</h2>
                            <p class="font-body-md text-body-md text-secondary">$92.00</p>
                            <div class="pt-4 flex gap-2">
                                <span class="font-label-sm text-label-sm text-on-surface-variant">36, 38, 42</span>
                            </div>
                        </div>
                        </a>
                    </article>
                    <!-- Product 4 -->
                    <article class="group">
                        <a href="producto.html" class="block text-inherit no-underline hover:opacity-95 transition-opacity">
                        <div class="aspect-[3/4] mb-6 overflow-hidden bg-surface-container relative">
                            <img alt="Raw Edge" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A high-fashion editorial shot featuring the hem of raw-edge indigo denim jeans paired with minimalist leather boots. The camera angle is low, capturing the texture of the frayed denim against a polished concrete floor. Bright, clean lighting emphasizes the contrast between the deep blue fabric and the cool grey environment, embodying a contemporary and edgy aesthetic."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBKavW06t5c7F1rkmh0lSI8JpJgoTOqC2Z9-UvDVcttnntsV9PGcB1PKBmzaj6uq17jFtGOpqq6Za0yH89YK1o-tINhKnsnyMQpnt5uNV7os99Sk9P4XbYL6-xspJkIQn5kUwv5QrS3H9vQgjBWFmKiBUUCLFouO9VJtfbD4IJ_48mhlB9v3bgXVGm1V2YYx-ya4XVCAbdkBETqume78DOXOJ_5TKNqaCdnDzV-aKEwAAX35E1pcNZIQvEGeSMsDUIgOjnvUpyV6dbR"
                            />
                            <span class="absolute top-4 left-4 bg-surface px-3 py-1 font-label-sm text-label-sm uppercase tracking-widest">Pocas unidades</span>
                        </div>
                        <div class="space-y-1">
                            <h2 class="font-headline-sm text-headline-sm">Raw Edge Sculptor</h2>
                            <p class="font-body-md text-body-md text-secondary">$110.00</p>
                            <div class="pt-4 flex gap-2">
                                <span class="font-label-sm text-label-sm text-on-surface-variant">34, 38, 40</span>
                            </div>
                        </div>
                        </a>
                    </article>
                    <!-- Product 5 -->
                    <article class="group">
                        <a href="producto.html" class="block text-inherit no-underline hover:opacity-95 transition-opacity">
                        <div class="aspect-[3/4] mb-6 overflow-hidden bg-surface-container relative">
                            <img alt="Black Denim" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A moody yet bright editorial shot of midnight black denim jeans showcased on a minimalist white mannequin. The lighting is crisp and high-contrast, bringing out the subtle texture of the black twill. The surrounding space is vast and airy, utilizing a stark black-and-white color scheme that highlights the garment as a piece of art within a modern gallery-like setting."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCt5agxKJtBrVoNGUeghHzuJfAepBw9KlRQSH91km13ptrc-OU4OtsxGuZFXywO9pxaVAPXx-Hgi8INxyAxaS9CG2FX2JCz2VRMt0qQvrAMN6ZmZScNrQeleheQvdl4CsiZp-G1kYKHuNSAC-EFvxrG-41m8qE7Ze-vMGuz3WZGFz7YIFf4ChSAZhhfU7kLff4Y9UOvaBDSYwyazIqNtPPki3gLhXAufzEyAf-tGLigHvSrnUeHVqPyOt4K2Pm-a78RlmSiXO_38TC-"
                            />
                            <span class="absolute top-4 left-4 bg-surface px-3 py-1 font-label-sm text-label-sm uppercase tracking-widest">Disponible</span>
                        </div>
                        <div class="space-y-1">
                            <h2 class="font-headline-sm text-headline-sm">Noir Tapered</h2>
                            <p class="font-body-md text-body-md text-secondary">$89.00</p>
                            <div class="pt-4 flex gap-2">
                                <span class="font-label-sm text-label-sm text-on-surface-variant">34, 36, 38, 40, 42</span>
                            </div>
                        </div>
                        </a>
                    </article>
                    <!-- Product 6 -->
                    <article class="group">
                        <a href="producto.html" class="block text-inherit no-underline hover:opacity-95 transition-opacity">
                        <div class="aspect-[3/4] mb-6 overflow-hidden bg-surface-container relative">
                            <img alt="Wide Leg" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A serene editorial landscape shot featuring a model walking in wide-leg bleached denim jeans through a minimalist desert setting at dawn. The light is soft, ethereal, and golden, creating a warm and grounded mood. The pale blue of the denim harmonizes perfectly with the sandy neutral tones of the environment, evoking a sense of effortless confidence and slow-living luxury."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBVfxSAC79cziXcez5fLYArI0M66dytbddyrrBtw9sAAd85ZTeQIl-p5lhiJRicx6ZSHrSzUOEO6DKwzr-pZH2M07sUvLTx6G-PQm_2JjEnnoUwlAmgr3G-NXqgIj_QAGm69_fuFACxsLCMOvUHdfSLU4nWSWcVdL9tQXP0lDAZ2BeGhqOpW0QTiyuYo4lsqwpXwhOIgLTljw2vUpoGlAqUDDZlgHPrxMHzXcEN_2H90-UCKPx6vvGTghZ9D6S5FpCjZxRyq2vsu2fd"
                            />
                            <span class="absolute top-4 left-4 bg-surface px-3 py-1 font-label-sm text-label-sm uppercase tracking-widest">Disponible</span>
                        </div>
                        <div class="space-y-1">
                            <h2 class="font-headline-sm text-headline-sm">Bleached Wide Leg</h2>
                            <p class="font-body-md text-body-md text-secondary">$95.00</p>
                            <div class="pt-4 flex gap-2">
                                <span class="font-label-sm text-label-sm text-on-surface-variant">38, 40, 42</span>
                            </div>
                        </div>
                        </a>
                    </article>
                </div>
                <!-- Pagination -->
                <div class="mt-20 flex items-center justify-center space-x-4 border-t border-outline-variant pt-12">
                    <button class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant hover:text-primary">Prev</button>
                    <span class="font-label-md text-label-md px-4 py-2 bg-secondary-container text-on-secondary-container">01</span>
                    <button class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant hover:text-primary">02</button>
                    <button class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant hover:text-primary">03</button>
                    <button class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant hover:text-primary">Next</button>
                </div>
            </section>
        </div>
    </main>
    <!-- Footer -->
    <footer class="w-full mt-20 bg-surface-container-low dark:bg-tertiary-container border-t border-outline-variant transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter-desktop px-margin-desktop py-16 max-w-container-max-width mx-auto">
            <div class="space-y-6">
                <div class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed mb-6"><a class="text-current no-underline hover:opacity-80 transition-opacity" href="../index.html">DENIM EDITORIAL</a></div>
                <p class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container max-w-xs">
                    Curating timeless silhouettes and premium denim for the modern, discerning individual.
                </p>
            </div>
            <div class="flex flex-col space-y-4">
                <h4 class="font-label-sm text-label-sm uppercase tracking-widest text-primary dark:text-primary-fixed">Customer Care</h4>
                <div class="flex flex-col space-y-2">
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="catalogo.html">Shipping</a>
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="login.html">Contact</a>
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="login.html">Privacy</a>
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="login.html">Terms</a>
                </div>
            </div>
            <div class="space-y-6">
                <h4 class="font-label-sm text-label-sm uppercase tracking-widest text-primary dark:text-primary-fixed">Newsletter</h4>
                <p class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container">Join our inner circle for exclusive editorial drops.</p>
                <div class="flex border-b border-outline-variant pb-2">
                    <input class="bg-transparent border-none outline-none flex-grow font-body-md text-body-md py-1" placeholder="Email Address" type="email" />
                    <button class="material-symbols-outlined text-primary" data-icon="arrow_forward">arrow_forward</button>
                </div>
            </div>
        </div>
        <div class="px-margin-desktop py-8 border-t border-outline-variant max-w-container-max-width mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="font-label-md text-label-md text-on-surface-variant">© 2024 DENIM EDITORIAL. ALL RIGHTS RESERVED.</span>
            <div class="flex space-x-6 text-on-surface-variant">
                <span class="material-symbols-outlined hover:text-primary cursor-pointer" data-icon="share">share</span>
                <span class="material-symbols-outlined hover:text-primary cursor-pointer" data-icon="language">language</span>
            </div>
        </div>
    </footer>
    <script>
        // Simple micro-interactions for filters
        document.querySelectorAll('aside button').forEach(button => {
            button.addEventListener('click', function() {
                if (!this.classList.contains('bg-primary')) {
                    this.parentElement.querySelectorAll('button').forEach(b => {
                        b.classList.remove('bg-secondary', 'text-on-primary');
                        b.classList.add('border-outline-variant');
                    });
                    this.classList.add('bg-secondary', 'text-on-primary');
                    this.classList.remove('border-outline-variant');
                }
            });
        });
    </script>
    <script src="../js/theme.js"></script>
</body>

</html>