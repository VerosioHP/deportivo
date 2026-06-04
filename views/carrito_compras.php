<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Shopping Bag | DENIM EDITORIAL</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&amp;family=Playfair+Display:ital,wght@0,400..900;1,400..900&amp;display=swap" rel="stylesheet" />
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="../js/theme-init.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="../css/carrito_compras.css">
    <link rel="stylesheet" href="../css/theme.css">
    <script src="../js/carrito_compras.js"></script>
</head>

<body class="font-body-md text-on-background dark:bg-on-background dark:text-inverse-on-surface transition-colors duration-300">
    <!-- TopNavBar -->
    <header class="sticky top-0 w-full z-50 bg-surface dark:bg-surface-dim border-b border-outline-variant dark:border-outline">
        <nav class="flex justify-between items-center h-20 px-margin-desktop max-w-container-max-width mx-auto">
            <a class="text-headline-sm font-headline-sm tracking-tight text-primary dark:text-primary-fixed cursor-pointer no-underline hover:opacity-80 transition-opacity" href="../index.html">DENIM EDITORIAL</a>
            <div class="hidden md:flex items-center gap-10">
                <a class="font-label-md text-label-md text-on-surface-variant dark:text-on-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" href="catalogo.html">Catalogo</a>
                <a class="font-label-md text-label-md text-on-surface-variant dark:text-on-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" href="producto.html">Tops</a>
                <a class="font-label-md text-label-md text-on-surface-variant dark:text-on-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" href="../index.html">Jackets</a>
                <a class="font-label-md text-label-md text-on-surface-variant dark:text-on-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" href="nosotros.html">Nosotros</a>
            </div>
            <div class="flex items-center gap-6 text-primary dark:text-primary-fixed">
                <button type="button" class="cursor-pointer transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed">
                        <span class="material-symbols-outlined"
                            data-icon="search">search</span>
                    </button>
                <a class="relative cursor-pointer transition-opacity duration-200 active:opacity-70 text-secondary dark:text-secondary-fixed-dim border-b-2 border-secondary dark:border-secondary-fixed-dim pb-1" href="carrito_compras.html" aria-label="Carrito">
                        <span class="material-symbols-outlined"
                            data-icon="shopping_bag">shopping_bag</span>
                        <span
                            class="absolute -top-1 -right-2 text-[10px] bg-secondary text-white rounded-full w-4 h-4 flex items-center justify-center">2</span>
                    </a>
                <a class="cursor-pointer transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed no-underline" href="login.html" aria-label="Cuenta">
                    <span class="material-symbols-outlined" data-icon="person">person</span>
                </a>
                <button type="button" data-theme-toggle class="theme-toggle cursor-pointer transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed" aria-label="Activar modo oscuro" aria-pressed="false">
                    <span class="material-symbols-outlined theme-toggle-icon">dark_mode</span>
                </button>
            </div>
        </nav>
    </header>
    <main class="max-w-container-max-width mx-auto px-margin-desktop py-20">
        <h1 class="font-display-lg text-display-lg mb-12 text-primary dark:text-primary-fixed">Your Shopping Bag
        </h1>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            <!-- Items List -->
            <section class="lg:col-span-8 space-y-12">
                <!-- Item 1 -->
                <div class="flex flex-col md:flex-row gap-8 pb-12 border-b border-outline-variant">
                    <div class="w-full md:w-48 aspect-[3/4] bg-surface-container-low overflow-hidden">
                        <img class="w-full h-full object-cover" data-alt="A close-up, high-fashion editorial shot of premium raw denim jeans hanging in a bright, minimalist studio. The lighting is soft and natural, emphasizing the rich indigo texture and precise contrast stitching. The overall mood is sophisticated and quiet, reflecting a luxury slow-fashion brand aesthetic with a palette of deep blues and creamy off-whites."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPHPRpdtlbJddCqbYqdH-twoUM2PGzZxB8nEhIUkiqV6DMOSBku4D3OfxRTV71X8TxFDriOcD4hKWpRJvFmZJrfdujMd62WXm_4VPFDRaNehoFcXKPSCsoyN-nGkSwLhtxb0ZWm1utHjPz3Xn526sG06uywvos-gxT6BIkisgoIcCa2I83gdAVHZsjYMUCSc7595QA1x_BOq96wumMTRgrpbwtEWhF2IVpnMZ9vFN74Ubnpj0X2e5LdENejbpOJIP9nZOKB7G8MDtz"
                        />
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-headline-sm text-headline-sm">Jeans Rectos Heritage</h3>
                                <p class="font-body-lg text-body-lg">$185.00</p>
                            </div>
                            <p class="font-label-md text-label-md text-on-surface-variant mb-4 uppercase tracking-widest">Vintage Wash / Size 32</p>
                            <div class="flex items-center gap-6">
                                <div class="flex items-center border border-outline px-3 py-1">
                                    <button class="hover:text-secondary"><span
                                                class="material-symbols-outlined text-sm"
                                                data-icon="remove">remove</span></button>
                                    <span class="px-4 font-label-md">1</span>
                                    <button class="hover:text-secondary"><span
                                                class="material-symbols-outlined text-sm"
                                                data-icon="add">add</span></button>
                                </div>
                                <button class="text-label-sm font-label-sm text-on-surface-variant underline hover:text-error transition-colors">REMOVE</button>
                            </div>
                        </div>
                        <p class="text-label-sm font-label-sm text-on-surface-variant mt-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-xs" data-icon="check_circle">check_circle</span> In Stock &amp; ready to ship
                        </p>
                    </div>
                </div>
                <!-- Item 2 -->
                <div class="flex flex-col md:flex-row gap-8 pb-12 border-b border-outline-variant">
                    <div class="w-full md:w-48 aspect-[3/4] bg-surface-container-low overflow-hidden">
                        <img class="w-full h-full object-cover" data-alt="An editorial product photograph of a crisp, heavy-weight white cotton t-shirt neatly folded on a textured beige stone surface. Sharp, clean shadows are cast by bright morning light, creating a tactile and premium feel. The color story is strictly neutral with whites and warm grays, evoking a sense of timeless quality and minimalist design."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBoOhL3MS7eTxsw4A2w7YQryWlmsr0C0awp7H6h_QVnE8X1sikN13mdDo0t6sjUOBrofp-KovinmTjLpmXaiC1g5Lw6VXjGPMD71ISPKOpDMxXSSG7NlM5VrSiAE2AdaZ4S0UT4F7V9RV3HRz_MF72kCD-cAtFUf84vbI1CG6zoxpBsd95tFYqXHpoVJTOaNkLoJ2MCk-swV969FGACYj3GskX8ueunF5NEX8AOr4TY0q1fonOpFBUHR0d0f4_C6CdAFEKaoM5hPsks"
                        />
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-headline-sm text-headline-sm">Essential White Tee</h3>
                                <p class="font-body-lg text-body-lg">$65.00</p>
                            </div>
                            <p class="font-label-md text-label-md text-on-surface-variant mb-4 uppercase tracking-widest">Optic White / Size M</p>
                            <div class="flex items-center gap-6">
                                <div class="flex items-center border border-outline px-3 py-1">
                                    <button class="hover:text-secondary"><span
                                                class="material-symbols-outlined text-sm"
                                                data-icon="remove">remove</span></button>
                                    <span class="px-4 font-label-md">1</span>
                                    <button class="hover:text-secondary"><span
                                                class="material-symbols-outlined text-sm"
                                                data-icon="add">add</span></button>
                                </div>
                                <button class="text-label-sm font-label-sm text-on-surface-variant underline hover:text-error transition-colors">REMOVE</button>
                            </div>
                        </div>
                        <p class="text-label-sm font-label-sm text-on-surface-variant mt-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-xs" data-icon="check_circle">check_circle</span> In Stock &amp; ready to ship
                        </p>
                    </div>
                </div>
            </section>
            <!-- Summary Sidebar -->
            <aside class="lg:col-span-4 bg-surface-container-low dark:bg-tertiary-container p-10">
                <h2 class="font-headline-sm text-headline-sm mb-8">Summary</h2>
                <div class="space-y-4 mb-8 border-b border-outline-variant pb-8">
                    <div class="flex justify-between font-body-md text-body-md">
                        <span class="text-on-surface-variant">Subtotal</span>
                        <span>$250.00</span>
                    </div>
                    <div class="flex justify-between font-body-md text-body-md">
                        <span class="text-on-surface-variant">Estimated
                                Shipping</span>
                        <span>$12.00</span>
                    </div>
                    <div class="flex justify-between font-body-md text-body-md">
                        <span class="text-on-surface-variant">Tax</span>
                        <span>$0.00</span>
                    </div>
                </div>
                <div class="flex justify-between font-body-lg text-body-lg font-bold mb-10">
                    <span>Total</span>
                    <span>$262.00</span>
                </div>
                <button class="w-full bg-primary text-on-primary py-5 font-label-md text-label-md hover:bg-opacity-90 transition-all flex items-center justify-center gap-2">
                        PROCEED TO CHECKOUT
                        <span class="material-symbols-outlined text-sm"
                            data-icon="arrow_forward">arrow_forward</span>
                    </button>
                <div class="mt-8 flex flex-col gap-4">
                    <div class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined" data-icon="local_shipping">local_shipping</span>
                        <span class="text-label-sm">Free shipping on orders
                                over $300</span>
                    </div>
                    <div class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined" data-icon="reusable_bag">shopping_bag</span>
                        <span class="text-label-sm">Sustainable editorial
                                packaging</span>
                    </div>
                </div>
            </aside>
        </div>
        <!-- Recommendations -->
        <section class="mt-32">
            <div class="flex items-baseline justify-between mb-12">
                <h2 class="font-headline-md text-headline-md">You Might Also Like
                </h2>
                <a class="text-label-md font-label-md underline hover:text-secondary transition-colors" href="catalogo.html">VIEW ALL</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter-desktop">
                <!-- Rec Card 1 -->
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] bg-surface-container overflow-hidden mb-4 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A sophisticated lifestyle image of a charcoal denim jacket draped over a wooden chair in a sunlit, high-ceilinged loft. The lighting creates dramatic contrast and highlights the tactile quality of the heavy denim fabric. The setting is clean, airy, and upscale, perfectly capturing a modern editorial aesthetic with earthy tones and sharp minimalist details."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDICnFRkjppW4AwTaA-oHLdc4ad7Ng36fpUPhCn0twCpyrdBjyC0qGkxj2k7TfHzJm5dylojLPOxNWBX3VqjcMg8Jc-mWqVukxtI49nbHpUdg2yrz75Mj6dry8FrjJCH5zHk_kFp5FYPs6hYkNfWcEQp26bN6Phwt88cp864-3lw7m6RfUsC5t8MdZagr5FC1GqkXc1IP3Aa6bgaEMI_-qw9kRYzXKpoyQcWCqIy5vDgyBqbO0WPpdPQbCCmTxyk0pPrUi4Dbu5fRFW"
                        />
                        <button class="absolute bottom-4 right-4 bg-white/90 p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                <span
                                    class="material-symbols-outlined text-primary"
                                    data-icon="add">add</span>
                            </button>
                    </div>
                    <h4 class="font-headline-sm text-label-md mb-1">Trucker Jacket
                    </h4>
                    <p class="font-label-md text-secondary">$210.00</p>
                </div>
                <!-- Rec Card 2 -->
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] bg-surface-container overflow-hidden mb-4 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="An artistic flat-lay of dark-wash denim jeans and leather accessories on a neutral linen background. The composition is balanced and editorial, using warm, soft lighting that brings out the deep navy and rich brown tones. The aesthetic is curated and calm, reflecting premium craftsmanship and timeless fashion staples in a minimalist visual language."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDfaUfLFzTTQpHwR-cQ64PMtr08GFj4Cw3tq8Z8hKVANN25F-XewSUZQ6iOntT9X72s_ahsO6SXBkp0yYwaj50-s_rKT5tPZ9DhexP4rAH1x2kimbv71zVUhasLN2tRVOGUlJ-6MMC4toFGyoBbHZux2ndyhkc1J6K4Svg_mhpAebmKUdrXSMidRWWayuEhj-n0St5K09tzd2ryjUbk5UNreKIrilEEhmZ5LTtxOQM8iYJoGwFnw-p4SlA0S-o6LvE3f4-xBSYpZHXN"
                        />
                        <button class="absolute bottom-4 right-4 bg-white/90 p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                <span
                                    class="material-symbols-outlined text-primary"
                                    data-icon="add">add</span>
                            </button>
                    </div>
                    <h4 class="font-headline-sm text-label-md mb-1">Selvedge Tapered
                    </h4>
                    <p class="font-label-md text-secondary">$195.00</p>
                </div>
                <!-- Rec Card 3 -->
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] bg-surface-container overflow-hidden mb-4 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A clean, minimalist product shot of a black button-down denim shirt. The garment is photographed against a light gray concrete wall, with sharp side-lighting that emphasizes the fabric's weave and silver buttons. The mood is industrial yet elegant, adhering to a high-end editorial style with a focused palette of black and cool grays."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBY3oBGUuSBF8pMfN7ash9QMosaBfWSCroncGsSWU2Mo0nplbAeodkwAGrDatbVnX1grMTd0tbf9NgUHeDmrcBG5X5jowAyXssc-cXSOZhSPE-VSmCPqFrubJ-1enD4PInRLVLaIhNflfcZ6gU2tr7KukGDRmCyDZ_EsnDVDn-VoiDHzJAiHmCPC-a-0fpeBkk75H6g3FdywhXrYFg8IvW1e9mKKSuGskQuRVrZXgaDJFaHleTtvWTu_IpsX5dgJ_m_wwvcKFwgjrLE"
                        />
                        <button class="absolute bottom-4 right-4 bg-white/90 p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                <span
                                    class="material-symbols-outlined text-primary"
                                    data-icon="add">add</span>
                            </button>
                    </div>
                    <h4 class="font-headline-sm text-label-md mb-1">Midnight Workshirt
                    </h4>
                    <p class="font-label-md text-secondary">$120.00</p>
                </div>
                <!-- Rec Card 4 -->
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] bg-surface-container overflow-hidden mb-4 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A macro detail shot of high-quality denim fabric draped elegantly over a sculpted marble plinth. The lighting is theatrical but soft, highlighting the rugged yet luxurious nature of the material. The aesthetic is avant-garde editorial, utilizing a palette of deep indigo, pure white marble, and soft shadows to communicate a brand story of refined strength."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuC1MPU911noWK4Fw-PEm71-aOKByN5UIH_3nUPrgCnBisH0Sk0xWcW6XERIz07PdM1EXjNGpjWEqGG3kOBWmygIcEiBbrDlyJDeviOQhA5ZSsLg8oTCm4fw9PG0D7Gnpjv7x4-nYKd9hE84yilcH1rNQWqdj5xfIdXvSk-IRdYYZDEaCbi0-kZljqsJNnfLCclkXJWcPanpqm0D-I8VboLuqldguN6UVebsnb1jhrnTZu_0vbpNPAFLZI1pAi_mFJCgoX-4ryPxYogx"
                        />
                        <button class="absolute bottom-4 right-4 bg-white/90 p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                <span
                                    class="material-symbols-outlined text-primary"
                                    data-icon="add">add</span>
                            </button>
                    </div>
                    <h4 class="font-headline-sm text-label-md mb-1">Raw Indigo Jacket</h4>
                    <p class="font-label-md text-secondary">$240.00</p>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="w-full bg-surface-container dark:bg-surface-container-highest mt-32">
        <div class="flex flex-col md:flex-row justify-between items-start gap-gutter-desktop py-20 px-margin-desktop max-w-container-max-width mx-auto">
            <div class="max-w-xs">
                <a class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed mb-6 block no-underline hover:opacity-80 transition-opacity" href="../index.html">DENIM EDITORIAL</a>
                <p class="font-body-md text-body-md text-on-surface-variant">Curating timeless denim silhouettes for the modern wardrobe. Focused on quality, durability, and the beauty of the aging fabric.</p>
            </div>
            <div class="grid grid-cols-2 gap-20">
                <div class="flex flex-col gap-4">
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary">Information</span>
                    <a class="font-body-md text-body-md text-on-tertiary-fixed-variant dark:text-on-tertiary-container hover:text-primary transition-all" href="login.html">Sustainability</a>
                    <a class="font-body-md text-body-md text-on-tertiary-fixed-variant dark:text-on-tertiary-container hover:text-primary transition-all" href="catalogo.html">Shipping</a>
                    <a class="font-body-md text-body-md text-on-tertiary-fixed-variant dark:text-on-tertiary-container hover:text-primary transition-all" href="catalogo.html">Returns</a>
                </div>
                <div class="flex flex-col gap-4">
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary">Connect</span>
                    <a class="font-body-md text-body-md text-on-tertiary-fixed-variant dark:text-on-tertiary-container hover:text-primary transition-all" href="login.html">Contact</a>
                    <a class="font-body-md text-body-md text-on-tertiary-fixed-variant dark:text-on-tertiary-container hover:text-primary transition-all" href="login.html">Privacy</a>
                    <a class="font-body-md text-body-md text-on-tertiary-fixed-variant dark:text-on-tertiary-container hover:text-primary transition-all" href="../index.html">Instagram</a>
                </div>
            </div>
        </div>
        <div class="px-margin-desktop max-w-container-max-width mx-auto pb-10 border-t border-outline-variant/30 pt-10">
            <div class="font-label-sm text-label-sm text-on-tertiary-fixed-variant">© 2024 DENIM EDITORIAL. ALL RIGHTS RESERVED.</div>
        </div>
    </footer>
    <script>
        // Simple micro-interactions for quantities
        document.querySelectorAll('button').forEach(btn => {
            if (btn.hasAttribute('data-theme-toggle')) return;
            btn.addEventListener('click', function(e) {
                const icon = this.querySelector('.material-symbols-outlined:not(.theme-toggle-icon)');
                if (icon) {
                    const action = icon.innerText;
                    const container = this.closest('.flex.items-center.border');
                    if (container) {
                        let countElem = container.querySelector('span');
                        let count = parseInt(countElem.innerText);
                        if (action === 'add') {
                            countElem.innerText = count + 1;
                        } else if (action === 'remove' && count > 1) {
                            countElem.innerText = count - 1;
                        }
                    }
                }
            });
        });
    </script>
    <script src="../js/theme.js"></script>
</body>

</html>