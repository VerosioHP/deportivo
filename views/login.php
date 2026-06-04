<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Login &amp; Registration | DENIM EDITORIAL</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&amp;family=Playfair+Display:ital,wght@0,400..900;1,400..900&amp;display=swap" rel="stylesheet" />
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="../js/theme-init.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="../js/login.js"></script>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/theme.css">
</head>

<body class="bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface font-body-md antialiased overflow-x-hidden transition-colors duration-300">
    <!-- Top Navigation (Reduced Shell for Transactional Focus) -->
    <header class="sticky top-0 w-full bg-surface dark:bg-on-background border-b border-outline-variant dark:border-outline z-50">
        <div class="flex justify-between items-center h-20 px-margin-mobile md:px-margin-desktop max-w-container-max-width mx-auto">
            <a class="text-headline-sm font-headline-sm tracking-tight text-primary dark:text-primary-fixed no-underline hover:opacity-80 transition-opacity" href="../index.php">DENIM EDITORIAL</a>
            
            <div class="flex gap-4 items-center text-primary dark:text-primary-fixed">
                <span class="material-symbols-outlined cursor-pointer hover:text-secondary dark:hover:text-secondary-fixed transition-colors" data-icon="search">search</span>
                <a class="material-symbols-outlined cursor-pointer hover:text-secondary dark:hover:text-secondary-fixed transition-colors text-current no-underline" href="carrito_compras.php" data-icon="shopping_bag" aria-label="Carrito">shopping_bag</a>
                <a class="material-symbols-outlined cursor-pointer hover:text-secondary dark:hover:text-secondary-fixed transition-colors text-current no-underline" href="login.php" data-icon="person" aria-label="Cuenta">person</a>
                <button type="button" data-theme-toggle class="theme-toggle cursor-pointer transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed" aria-label="Activar modo oscuro" aria-pressed="false">
                    <span class="material-symbols-outlined theme-toggle-icon">dark_mode</span>
                </button>
            </div>
        </div>
    </header>
    <main class="min-h-[calc(100vh-80px)] flex items-center justify-center py-10 md:py-20 px-margin-mobile md:px-margin-desktop">
        <div class="w-full max-w-[1100px] grid grid-cols-1 md:grid-cols-2 bg-surface-container-low dark:bg-tertiary-container rounded-lg overflow-hidden editorial-shadow">
            <!-- Visual Editorial Side -->
            <div class="relative hidden md:block overflow-hidden">
                <img class="absolute inset-0 w-full h-full object-cover" data-alt="A cinematic, high-fashion editorial photograph of a person wearing premium raw selvedge denim jeans leaning against a weathered stone wall. The lighting is soft and golden, characteristic of a late afternoon glow, highlighting the tactile texture of the fabric and the precision of the stitching. The color palette is composed of deep indigo blues, warm creams, and earthy ochre tones, creating a sophisticated and grounded atmosphere that reflects a slow-living aesthetic."
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCEWRxzOiPh0v3pNEu4UXvLwlzaY92PRu7Ik5yC_xqfqFu9GOKiRVbYuX5keLNXf20mKYuCVRigVdE3soDo5PtN20E7R_JHoSK72AAO33W5CbZeXM_8X1YyXNBJTrbh57vc1tFTk8Y41dg38dUqqLDAfr_QaV-iruP5zlPiHaFhq5DNtYOyU3Zyrdc34uDGNNeW5uh1hNbs0Zk3I49PKBwpQuOrEUicJKa3mOlsU3jZP9DBZ_ya31uYjigugByLFKad_NoYgk72B9Pg"
                />
                <div class="absolute inset-0 bg-primary/20 mix-blend-multiply"></div>
                <div class="absolute bottom-12 left-12 right-12 text-white">
                    <p class="font-label-sm text-label-sm tracking-[0.2em] mb-4 opacity-80 uppercase">The Craft of Denim</p>
                    <h2 class="font-headline-md text-headline-md mb-6 leading-tight italic">"True style is an investment in quality that matures with time."</h2>
                    <div class="h-px w-24 bg-white/40"></div>
                </div>
            </div>
            <!-- Form Side -->
            <div class="p-8 md:p-16 flex flex-col justify-center bg-white dark:bg-tertiary-container">
                <div class="auth-transition" id="auth-container">
                    <!-- Login Form -->
                    <div class="space-y-8" id="login-section">
                        <div class="space-y-2">
                            <h1 class="font-headline-sm text-headline-sm text-primary">Welcome Back
                            </h1>
                            <p class="font-body-md text-on-surface-variant">Sign in to access your curated wardrobe.</p>
                        </div>
                        <form action="../controllers/loginController.php" method="post" class="space-y-6">
                            <div class="space-y-4">
                                <div class="relative group">
                                    <label class="block font-label-md text-label-md text-on-surface-variant mb-1">Email
                                            Address</label>
                                            <input
                                                name="email"
                                                class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary transition-all font-body-md text-on-surface placeholder:text-outline-variant/60"
                                                placeholder="name@example.com"
                                                type="email"
                                                required
                                            />
                                </div>
                                <div class="relative group">
                                    <div class="flex justify-between items-center mb-1">
                                        <label class="block font-label-md text-label-md text-on-surface-variant">Password</label>
                                        <a class="font-label-sm text-label-sm text-secondary hover:underline" href="login.php">Forgot?</a>
                                    </div>
                                    <input
                                        name="password"
                                        class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary transition-all font-body-md text-on-surface placeholder:text-outline-variant/60"
                                        placeholder="••••••••"
                                        type="password"
                                        required
                                    />
                                </div>
                            </div>
                            <button class="w-full py-4 bg-primary text-white font-label-md text-label-md hover:bg-primary-container transition-all active:scale-[0.98] duration-200" type="submit">
                                    SIGN IN
                                </button>
                        </form>
                        <div class="relative flex items-center py-4">
                            <div class="flex-grow border-t border-outline-variant"></div>
                            <span class="flex-shrink mx-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Or
                                    continue with</span>
                            <div class="flex-grow border-t border-outline-variant"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="flex items-center justify-center gap-3 py-3 px-4 border border-outline-variant hover:bg-surface-container-low transition-colors duration-300">
                                    <svg class="w-5 h-5"
                                        viewbox="0 0 24 24"><path
                                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                            fill="#4285F4"></path><path
                                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                            fill="#34A853"></path><path
                                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"
                                            fill="#FBBC05"></path><path
                                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                            fill="#EA4335"></path></svg>
                                    <span
                                        class="font-label-md text-label-md">Google</span>
                                </button>
                            <button class="flex items-center justify-center gap-3 py-3 px-4 border border-outline-variant hover:bg-surface-container-low transition-colors duration-300">
                                    <svg class="w-5 h-5"
                                        viewbox="0 0 24 24"><path
                                            d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.559-1.701z"></path></svg>
                                    <span
                                        class="font-label-md text-label-md">Apple</span>
                                </button>
                        </div>
                        <p class="text-center font-body-md text-on-surface-variant">
                            New to Denim Editorial?
                            <button class="text-secondary font-label-md text-label-md hover:underline ml-1" onclick="toggleAuth('register')">Create
                                    Account</button>
                        </p>
                    </div>
                    <!-- Register Form (Hidden Initially) -->
                    <div class="hidden space-y-8" id="register-section">
                        <div class="space-y-2">
                            <h1 class="font-headline-sm text-headline-sm text-primary">Join the Editorial</h1>
                            <p class="font-body-md text-on-surface-variant">Craft your personal style profile.</p>
                        </div>
                        <form action="../controllers/registerController.php" method="post" class="space-y-6">
                            <div class="space-y-4">
                                <div class="relative group">
                                    <label class="block font-label-md text-label-md text-on-surface-variant mb-1">Full
                                            Name</label>
                                    <input
                                        name="nombre"
                                        class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary transition-all font-body-md text-on-surface placeholder:text-outline-variant/60"
                                        placeholder="Jane Doe"
                                        type="text"
                                        required
                                    />
                                </div>
                                <div class="relative group">
                                    <label class="block font-label-md text-label-md text-on-surface-variant mb-1">Email
                                            Address</label>
                                    <input
                                        name="email"
                                        class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary transition-all font-body-md text-on-surface placeholder:text-outline-variant/60"
                                        placeholder="jane@example.com"
                                        type="email"
                                        required
                                    />
                                </div>
                                <div class="relative group">
                                    <label class="block font-label-md text-label-md text-on-surface-variant mb-1">Password</label>
                                        <input
                                        name="password"
                                        class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary transition-all font-body-md text-on-surface placeholder:text-outline-variant/60"
                                        placeholder="Min. 8 characters"
                                        type="password"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <input class="mt-1 h-4 w-4 rounded border-outline-variant text-secondary focus:ring-secondary" type="checkbox" />
                                <label class="font-label-sm text-label-sm text-on-surface-variant">I
                                        agree to the <a class="underline"
                                            href="login.php">Terms of Service</a> and <a
                                            class="underline" href="login.php">Privacy
                                            Policy</a>.</label>
                            </div>
                            <button class="w-full py-4 bg-primary text-white font-label-md text-label-md hover:bg-primary-container transition-all active:scale-[0.98] duration-200" type="submit">
                                    CREATE ACCOUNT
                                </button>
                        </form>
                        <div class="relative flex items-center py-4">
                            <div class="flex-grow border-t border-outline-variant"></div>
                            <span class="flex-shrink mx-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Or
                                    sign up with</span>
                            <div class="flex-grow border-t border-outline-variant"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="flex items-center justify-center gap-3 py-3 px-4 border border-outline-variant hover:bg-surface-container-low transition-colors duration-300">
                                    <svg class="w-5 h-5"
                                        viewbox="0 0 24 24"><path
                                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                            fill="#4285F4"></path><path
                                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                            fill="#34A853"></path><path
                                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"
                                            fill="#FBBC05"></path><path
                                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                            fill="#EA4335"></path></svg>
                                    <span
                                        class="font-label-md text-label-md">Google</span>
                                </button>
                            <button class="flex items-center justify-center gap-3 py-3 px-4 border border-outline-variant hover:bg-surface-container-low transition-colors duration-300">
                                    <svg class="w-5 h-5"
                                        viewbox="0 0 24 24"><path
                                            d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.559-1.701z"></path></svg>
                                    <span
                                        class="font-label-md text-label-md">Apple</span>
                                </button>
                        </div>
                        <p class="text-center font-body-md text-on-surface-variant">
                            Already have an account?
                            <button class="text-secondary font-label-md text-label-md hover:underline ml-1" onclick="toggleAuth('login')">Sign
                                    In</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Simple Minimal Footer -->
    <footer class="bg-surface-container-low dark:bg-tertiary-container w-full border-t border-outline-variant dark:border-outline">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 py-10 px-margin-mobile md:px-margin-desktop max-w-container-max-width mx-auto border-t border-outline-variant/30">
            <span class="font-label-sm text-label-sm text-on-tertiary-fixed-variant uppercase">©
                    2024 DENIM EDITORIAL. ALL RIGHTS RESERVED.</span>
            <div class="flex gap-6">
                <a class="font-label-sm text-label-sm text-on-tertiary-fixed-variant hover:text-primary transition-all" href="login.php">Contact</a>
                <a class="font-label-sm text-label-sm text-on-tertiary-fixed-variant hover:text-primary transition-all" href="login.php">Privacy</a>
            </div>
        </div>
    </footer>
    <script>
        function toggleAuth(type) {
            const container = document.getElementById('auth-container');
            const loginSection = document.getElementById('login-section');
            const registerSection = document.getElementById('register-section');

            // Initial fade out
            container.classList.add('opacity-0', 'translate-y-4');

            setTimeout(() => {
                if (type === 'register') {
                    loginSection.classList.add('hidden');
                    registerSection.classList.remove('hidden');
                } else {
                    registerSection.classList.add('hidden');
                    loginSection.classList.remove('hidden');
                }

                // Fade back in
                container.classList.remove('opacity-0', 'translate-y-4');
            }, 300);
        }

        // Simple parallax effect for the visual side
        document.addEventListener('mousemove', (e) => {
            const img = document.querySelector('img[data-alt]');
            if (img && window.innerWidth >= 768) {
                const moveX = (e.clientX - window.innerWidth / 2) * 0.01;
                const moveY = (e.clientY - window.innerHeight / 2) * 0.01;
                img.style.transform = `scale(1.1) translate(${moveX}px, ${moveY}px)`;
            }
        });
    </script>
    <script src="../js/theme.js"></script>
</body>

</html>