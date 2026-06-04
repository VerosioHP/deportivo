<!doctype html>

<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Nuestra Historia | DENIM EDITORIAL</title>
    <script src="../js/theme-init.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&amp;family=DM+Sans:wght@400;500;700&amp;display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
      rel="stylesheet"
    />
    <script src="../js/nosotros.js"></script>
    <link rel="stylesheet" href="../css/nosotros.css">
    <link rel="stylesheet" href="../css/theme.css">
  </head>
  <body
    class="bg-background dark:bg-on-background text-on-surface dark:text-inverse-on-surface selection:bg-secondary-fixed selection:text-on-secondary-fixed transition-colors duration-300"
  >
    <!-- TopNavBar -->
    <nav
      class="w-full top-0 sticky bg-surface dark:bg-on-background border-b border-outline-variant dark:border-outline z-50"
    >
      <div
        class="flex justify-between items-center px-margin-desktop py-4 max-w-container-max-width mx-auto"
      >
        <a
          class="font-headline-md text-headline-md font-semibold text-primary dark:text-primary-fixed no-underline hover:opacity-80 transition-opacity"
          href="../index.html"
          >DENIM EDITORIAL</a
        >
        <div class="hidden md:flex gap-8">
          <a
            class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300"
            href="catalogo.html"
            >Catalogo</a
          >
          <a
            class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300"
            href="producto.html"
            >Tops</a
          >
          <a
            class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300"
            href="../index.html"
            >Jackets</a
          >
          <a
            class="font-label-md text-label-md uppercase tracking-widest text-secondary dark:text-secondary-fixed-dim border-b-2 border-secondary pb-1 transition-colors duration-300"
            href="nosotros.html"
            >Nosotros</a
          >
        </div>
        <div
          class="flex items-center gap-6 text-primary dark:text-primary-fixed"
        >
          <button
            type="button"
            class="transition-opacity duration-200 active:opacity-70"
          >
            <span class="material-symbols-outlined">search</span>
          </button>
          <a
            class="transition-opacity duration-200 active:opacity-70 text-current no-underline"
            href="carrito_compras.html"
            aria-label="Carrito"
            ><span class="material-symbols-outlined">shopping_bag</span></a
          >
          <a
            class="transition-opacity duration-200 active:opacity-70 text-current no-underline"
            href="login.html"
            aria-label="Cuenta"
            ><span class="material-symbols-outlined">person</span></a
          >
          <button
            type="button"
            data-theme-toggle
            class="theme-toggle transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed"
            aria-label="Activar modo oscuro"
            aria-pressed="false"
          >
            <span class="material-symbols-outlined theme-toggle-icon"
              >dark_mode</span
            >
          </button>
        </div>
      </div>
    </nav>
    <main>
      <!-- Section 1: Hero -->
      <section
        class="relative h-[819px] flex items-center justify-center overflow-hidden"
      >
        <img
          class="absolute inset-0 w-full h-full object-cover"
          data-alt="A cinematic, high-fashion editorial shot of raw indigo denim craftsmanship. A skilled artisan's hands are shown working on a heavy-weight denim jacket in a sun-drenched, minimalist studio. The lighting is warm and natural, highlighting the tactile texture of the weave. The overall aesthetic is premium and grounded, using a palette of deep blues and warm wood tones to evoke a sense of heritage and modern luxury."
          src="https://lh3.googleusercontent.com/aida-public/AB6AXuDbBs5UNE00m6XPBN_E0D_m1DFkPl8pApwews115pYNwT1rVvnVpxW676ZEqFtOUmZJBjtNz8cOH8R46UhBDXbrXkDQviS5gfoV9FTPCLC_UJV_Ss4DAcUndVF2N6TKQ0z2RrFJCTCarifD9qEn5UcuX_EyffhOuyYJM8r1y6yJ8VQRi0HMd_5ESDGRBKVNt3IEOQAJemCSCwweWsuh4G7y1DP-LHYr7DZi5O27arkxsD3qsI4nI6ZBssLkTDoDhIdAL0PVZiHSezBV"
        />
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative z-10 text-center text-white">
          <h1
            class="font-display-lg text-display-lg md:text-[80px] leading-none mb-4 drop-shadow-lg"
          >
            Nuestra Historia
          </h1>
          <div class="w-16 h-[2px] bg-white mx-auto"></div>
        </div>
      </section>
      <!-- Section 2: Quiénes Somos -->
      <section
        class="max-w-container-max-width mx-auto px-margin-desktop py-24 editorial-reveal"
        id="reveal-1"
      >
        <div
          class="grid grid-cols-1 md:grid-cols-12 gap-gutter-desktop items-center"
        >
          <div class="md:col-span-5">
            <h2 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed mb-8">
              Quiénes Somos
            </h2>
            <p
              class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed"
            >
              En Denim Editorial, no solo creamos prendas; curamos experiencias
              textiles. Nacimos de una obsesión profunda por la autenticidad del
              denim índigo y el respeto por el tiempo. Creemos que la verdadera
              calidad no se grita, se siente en el peso de la tela y se ve en la
              forma en que el tejido evoluciona contigo.
            </p>
            <p class="mt-6 font-body-md text-body-md text-on-surface-variant">
              Nuestra pasión reside en el arte del envejecimiento. Cada par de
              jeans es un lienzo en blanco que espera ser transformado por tus
              movimientos, tus viajes y tu historia personal.
            </p>
          </div>
          <div class="md:col-start-7 md:col-span-6">
            <div
              class="aspect-[4/5] bg-surface-container-low dark:bg-tertiary-container relative overflow-hidden"
            >
              <img
                class="w-full h-full object-cover"
                data-alt="A macro close-up of premium Japanese selvedge denim, showing the intricate twill pattern and the iconic red line detail. The lighting is soft and directional, emphasizing the depth and tactile quality of the heavy indigo fabric. The composition is clean and minimalist, reflecting a sophisticated editorial style with a focus on textile integrity and craftsmanship."
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDEsq_4T4sL1C4a8MD7WYW_g55svtZNcYAuSgMQ_qNEvWi455BrKhkEalUJ_O29Cir5R_xTg3bkUzjwqY5uoit4d8KcXOfjbON883VQLwJxtfPiCYF4zqP27geI8mPdNZStwRWnGnH2fkzvg-3p8pddBJby9MzMgkT2kuRCU9bpYPrxkifWWXvtU5qtJ-sRVsVlejxO-QCf4YAYMtZ4MH9mqkvwOsfbmwjlGU0JDaYxnzPLOPb1wY1q8iEkmdJcUtu_xOunOdUN7iAM"
              />
            </div>
          </div>
        </div>
      </section>
      <!-- Section 3: Para Quién Trabajamos -->
      <section
        class="bg-surface-container-low dark:bg-tertiary-container py-24 editorial-reveal"
        id="reveal-2"
      >
        <div class="max-w-container-max-width mx-auto px-margin-desktop">
          <div class="flex flex-col items-center text-center max-w-3xl mx-auto">
            <span
              class="font-label-sm text-label-sm uppercase tracking-[0.2em] text-secondary mb-4"
              >El Individuo Moderno</span
            >
            <h2 class="font-display-lg text-display-lg text-primary dark:text-primary-fixed mb-8">
              Para Quién Trabajamos
            </h2>
            <p
              class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed mb-12"
            >
              Diseñamos para el individuo exigente que ha superado el ciclo
              efímero de la moda rápida. Aquellos que buscan una armadura diaria
              que combine la sofisticación arquitectónica con la durabilidad
              inquebrantable. Nuestra audiencia valora la historia detrás de la
              puntada y la honestidad de los materiales puros.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 w-full">
              <div class="space-y-2">
                <div class="text-headline-sm font-headline-sm text-primary dark:text-primary-fixed">
                  Consciente
                </div>
                <p class="text-body-md font-body-md text-on-surface-variant">
                  Valora el origen y el impacto de su consumo.
                </p>
              </div>
              <div class="space-y-2">
                <div class="text-headline-sm font-headline-sm text-primary dark:text-primary-fixed">
                  Atemporal
                </div>
                <p class="text-body-md font-body-md text-on-surface-variant">
                  Busca siluetas que trasciendan las tendencias.
                </p>
              </div>
              <div class="space-y-2">
                <div class="text-headline-sm font-headline-sm text-primary dark:text-primary-fixed">
                  Resistente
                </div>
                <p class="text-body-md font-body-md text-on-surface-variant">
                  Exige prendas que mejoren con el paso de los años.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Section 4: Por Qué Elegirnos -->
      <section
        class="max-w-container-max-width mx-auto px-margin-desktop py-24 editorial-reveal"
        id="reveal-3"
      >
        <h2
          class="font-headline-md text-headline-md text-primary dark:text-primary-fixed mb-16 text-center"
        >
          Por Qué Elegirnos
        </h2>
        <div
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter-desktop"
        >
          <!-- Pillar 1 -->
          <div
            class="p-8 border border-outline-variant dark:border-outline hover:border-secondary dark:hover:border-secondary-fixed transition-colors group bg-surface dark:bg-tertiary-container"
          >
            <div class="mb-6 text-secondary">
              <span
                class="material-symbols-outlined text-[40px]"
                data-icon="verified"
                >verified</span
              >
            </div>
            <h3 class="font-headline-sm text-headline-sm mb-4 text-primary dark:text-primary-fixed">Calidad</h3>
            <p class="font-body-md text-body-md text-on-surface-variant">
              Utilizamos exclusivamente denim japonés de primera calidad, tejido
              en telares antiguos para una densidad y carácter inigualables.
            </p>
          </div>
          <!-- Pillar 2 -->
          <div
            class="p-8 border border-outline-variant dark:border-outline hover:border-secondary dark:hover:border-secondary-fixed transition-colors group bg-surface dark:bg-tertiary-container"
          >
            <div class="mb-6 text-secondary">
              <span
                class="material-symbols-outlined text-[40px]"
                data-icon="eco"
                >eco</span
              >
            </div>
            <h3 class="font-headline-sm text-headline-sm mb-4 text-primary dark:text-primary-fixed">
              Sostenibilidad
            </h3>
            <p class="font-body-md text-body-md text-on-surface-variant">
              Producción consciente con ahorro de agua y procesos de teñido
              orgánicos que respetan el medio ambiente.
            </p>
          </div>
          <!-- Pillar 3 -->
          <div
            class="p-8 border border-outline-variant dark:border-outline hover:border-secondary dark:hover:border-secondary-fixed transition-colors group bg-surface dark:bg-tertiary-container"
          >
            <div class="mb-6 text-secondary">
              <span
                class="material-symbols-outlined text-[40px]"
                data-icon="architecture"
                >architecture</span
              >
            </div>
            <h3 class="font-headline-sm text-headline-sm mb-4 text-primary dark:text-primary-fixed">Ajuste</h3>
            <p class="font-body-md text-body-md text-on-surface-variant">
              Siluetas arquitectónicas diseñadas para complementar el movimiento
              humano y esculpir una presencia definida.
            </p>
          </div>
          <!-- Pillar 4 -->
          <div
            class="p-8 border border-outline-variant dark:border-outline hover:border-secondary dark:hover:border-secondary-fixed transition-colors group bg-surface dark:bg-tertiary-container"
          >
            <div class="mb-6 text-secondary">
              <span
                class="material-symbols-outlined text-[40px]"
                data-icon="all_inclusive"
                >all_inclusive</span
              >
            </div>
            <h3 class="font-headline-sm text-headline-sm mb-4 text-primary dark:text-primary-fixed">Longevidad</h3>
            <p class="font-body-md text-body-md text-on-surface-variant">
              Nuestras piezas no están diseñadas para durar una temporada, sino
              para ser heredadas por la siguiente generación.
            </p>
          </div>
        </div>
      </section>
      <!-- Section 5: Secondary Visual -->
      <section class="px-margin-desktop pb-24">
        <div
          class="max-w-container-max-width mx-auto overflow-hidden h-[614px] editorial-reveal"
          id="reveal-4"
        >
          <img
            class="w-full h-full object-cover"
            data-alt="An atmospheric wide shot of a modern, clean denim workshop. Sunlight filters through large industrial windows, illuminating rolls of indigo fabric and vintage sewing machines. The environment is serene and organized, emphasizing a 'slow-fashion' philosophy. The color palette features soft creams, deep indigo blues, and warm metallic accents, maintaining a premium editorial aesthetic."
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA6Pj8-q-CNDAO8BcrktUcoczIpFnlBk-4p1XrbTP-Dy-nttRQ7ZGs8fsQOwPN2PcvE19WP5BRicVrMU8Y9sIeoLD6kJ3iuO9yYPfhtjgefU-m_HMidBtABmJM1kpq2l3ki3WrU1v5eGqUEJpTtmD5AOw2q9BWl85xZeXkw-9yak_eNOlMCxtTbID35zML-9DYxlSv-dIJJHJZ-2-G35SkmlcQzp8hvkzw1-9sfATW_McGvfZAo9b2T2JXE7t-ZQhn4HClcIoZAzJSD"
          />
        </div>
      </section>
    </main>
    <!-- Footer -->
    <footer
      class="bg-surface-container-low dark:bg-tertiary-container w-full mt-20 border-t border-outline-variant dark:border-outline"
    >
      <div
        class="grid grid-cols-1 md:grid-cols-3 gap-gutter-desktop px-margin-desktop py-16 max-w-container-max-width mx-auto"
      >
        <div class="space-y-6">
          <a
            class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed uppercase no-underline hover:opacity-80 transition-opacity block"
            href="../index.html"
            >DENIM EDITORIAL</a
          >
          <p
            class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container max-w-xs"
          >
            Curando la cultura del denim con integridad y diseño atemporal desde
            nuestra fundación.
          </p>
        </div>
        <div class="flex flex-col gap-4">
          <div
            class="font-label-sm text-label-sm uppercase tracking-widest text-primary dark:text-primary-fixed mb-2"
          >
            Información
          </div>
          <a
            class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors"
            href="login.html"
            >Newsletter</a
          >
          <a
            class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors"
            href="catalogo.html"
            >Shipping</a
          >
          <a
            class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors"
            href="login.html"
            >Contact</a
          >
        </div>
        <div class="flex flex-col gap-4">
          <div
            class="font-label-sm text-label-sm uppercase tracking-widest text-primary dark:text-primary-fixed mb-2"
          >
            Legal
          </div>
          <a
            class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors"
            href="login.html"
            >Privacy</a
          >
          <a
            class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors"
            href="login.html"
            >Terms</a
          >
          <p
            class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container mt-4"
          >
            © 2024 DENIM EDITORIAL. ALL RIGHTS RESERVED.
          </p>
        </div>
      </div>
    </footer>
    <script>
      // Simple Intersection Observer for reveal animations
      const observerOptions = {
        threshold: 0.15,
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("visible");
          }
        });
      }, observerOptions);

      document
        .querySelectorAll(".editorial-reveal")
        .forEach((el) => observer.observe(el));

      // Smooth scroll implementation
      document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
          e.preventDefault();
          document.querySelector(this.getAttribute("href")).scrollIntoView({
            behavior: "smooth",
          });
        });
      });
    </script>
    <script src="../js/theme.js"></script>
  </body>
</html>
