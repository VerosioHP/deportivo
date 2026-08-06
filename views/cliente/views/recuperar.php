<?php

$authInViews = true;
require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/PasswordReset.php';
require_once __DIR__ . '/../includes/sport-images.php';

PasswordReset::ensureSchema();

$estado = $_SESSION['password_reset'] ?? null;
$pasoInicial = 1;
if (!empty($estado['verificado'])) {
    $pasoInicial = 3;
} elseif (!empty($estado['reset_id'])) {
    $pasoInicial = 2;
}

$navInViews = true;
$activePage = 'login';
$cartBasePath = $assetBase;
$cartUrl = 'carrito_compras.php';
$controllerUrl = '../controllers/recuperarController.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Recuperar contraseña | VEMA</title>
    <?php $pageCss = 'pages/login.css'; include __DIR__ . '/../includes/design-head.php'; ?>
</head>
<body class="auth-page bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface font-body-md antialiased overflow-x-hidden transition-colors duration-300<?= deportivo_admin_body_class() ?>">
    <?php include __DIR__ . '/../includes/site-nav.php'; ?>

    <main class="auth-main">
        <div class="auth-shell">
            <header class="auth-brand">
                <p class="auth-brand-mark">VEMA</p>
                
            </header>
            <div class="recover-card">
            <a href="login.php" class="recover-back inline-flex items-center gap-2 font-label-sm uppercase tracking-widest no-underline mb-8">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Volver al login
            </a>

            <div class="space-y-2 mb-8">
                <h1 class="recover-title">Recuperar acceso</h1>
                <p class="recover-lead" data-recover-lead>
                    Indica el correo o celular de tu cuenta VEMA para asociarla y enviarte un código.
                </p>
            </div>

            <div class="recover-steps mb-8" aria-hidden="true">
                <span class="recover-step is-active" data-step-dot="1">1</span>
                <span class="recover-step-line"></span>
                <span class="recover-step" data-step-dot="2">2</span>
                <span class="recover-step-line"></span>
                <span class="recover-step" data-step-dot="3">3</span>
            </div>

            <p class="recover-msg hidden" data-recover-msg role="status"></p>

            <!-- Paso 1: identificar cuenta registrada -->
            <form class="space-y-6" data-recover-step="1" <?= $pasoInicial === 1 ? '' : 'hidden' ?>>
                <p class="recover-identify-note">
                    Solo podemos recuperar contraseñas de cuentas ya registradas. Escribe el mismo dato con el que creaste tu cuenta.
                </p>

                <div class="recover-channels" role="radiogroup" aria-label="Cómo identificar tu cuenta">
                    <label class="recover-channel">
                        <input type="radio" name="canal" value="email" checked />
                        <span class="recover-channel-box">
                            <span class="material-symbols-outlined">mail</span>
                            <strong>Correo</strong>
                            <small>El email de tu cuenta VEMA</small>
                        </span>
                    </label>
                    <label class="recover-channel">
                        <input type="radio" name="canal" value="sms" />
                        <span class="recover-channel-box">
                            <span class="material-symbols-outlined">sms</span>
                            <strong>Celular</strong>
                            <small>El número que guardaste al registrarte</small>
                        </span>
                    </label>
                </div>

                <div data-field-email>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-1">Correo de tu cuenta</label>
                    <input name="email" type="email" autocomplete="email"
                           class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary transition-all font-body-md"
                           placeholder="nombre@ejemplo.com" />
                </div>
                <div data-field-sms hidden>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-1">Celular de tu cuenta</label>
                    <input name="telefono" type="tel" autocomplete="tel"
                           class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary transition-all font-body-md"
                           placeholder="300 123 4567" />
                </div>

                <button type="submit" class="w-full py-4 bg-primary text-on-primary font-label-md uppercase tracking-widest hover:opacity-90 transition-opacity">
                    Verificar cuenta y enviar código
                </button>
            </form>

            <!-- Paso 2 -->
            <form class="space-y-6" data-recover-step="2" <?= $pasoInicial === 2 ? '' : 'hidden' ?>>
                <p class="font-body-md text-on-surface-variant">
                    Cuenta asociada. Ingresa el código de 6 dígitos enviado a
                    <strong data-destino-mask><?= htmlspecialchars((string) ($estado['destino_mask'] ?? '')) ?></strong>.
                </p>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-1">Código</label>
                    <input name="codigo" type="text" inputmode="numeric" maxlength="6" pattern="\d{6}"
                           class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary tracking-[0.35em] text-center text-xl font-semibold"
                           placeholder="••••••" autocomplete="one-time-code" />
                </div>
                <button type="submit" class="w-full py-4 bg-primary text-on-primary font-label-md uppercase tracking-widest hover:opacity-90 transition-opacity">
                    Verificar código
                </button>
                <button type="button" class="w-full py-3 border border-outline-variant font-label-sm uppercase tracking-widest" data-recover-back>
                    Volver
                </button>
            </form>

            <!-- Paso 3 -->
            <form class="space-y-6" data-recover-step="3" <?= $pasoInicial === 3 ? '' : 'hidden' ?>>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-1">Nueva contraseña</label>
                    <input name="password" type="password" minlength="6"
                           class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary"
                           placeholder="Mín. 6 caracteres" required />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-1">Confirmar contraseña</label>
                    <input name="password2" type="password" minlength="6"
                           class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary"
                           placeholder="Repite la contraseña" required />
                </div>
                <button type="submit" class="w-full py-4 bg-primary text-on-primary font-label-md uppercase tracking-widest hover:opacity-90 transition-opacity">
                    Guardar contraseña
                </button>
            </form>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/site-footer.php'; ?>
    <script>
    (() => {
        const endpoint = <?= json_encode($controllerUrl) ?>;
        const pasoInicial = <?= (int) $pasoInicial ?>;
        const forms = {
            1: document.querySelector('[data-recover-step="1"]'),
            2: document.querySelector('[data-recover-step="2"]'),
            3: document.querySelector('[data-recover-step="3"]'),
        };
        const msgEl = document.querySelector('[data-recover-msg]');
        const leadEl = document.querySelector('[data-recover-lead]');
        const maskEl = document.querySelector('[data-destino-mask]');
        const fieldEmail = document.querySelector('[data-field-email]');
        const fieldSms = document.querySelector('[data-field-sms]');
        const leads = {
            1: 'Indica el correo o celular de tu cuenta VEMA para asociarla y enviarte un código.',
            2: 'Tu cuenta ya está asociada. Revisa el código e ingrésalo aquí.',
            3: 'Define una contraseña nueva para tu cuenta.',
        };

        function showMsg(text, ok) {
            if (!msgEl) return;
            msgEl.textContent = text || '';
            msgEl.classList.toggle('hidden', !text);
            msgEl.classList.toggle('is-ok', !!ok);
            msgEl.classList.toggle('is-error', !ok && !!text);
        }

        function setPaso(n) {
            Object.entries(forms).forEach(([k, form]) => {
                if (!form) return;
                form.hidden = Number(k) !== n;
            });
            document.querySelectorAll('[data-step-dot]').forEach((dot) => {
                const step = Number(dot.getAttribute('data-step-dot'));
                dot.classList.toggle('is-active', step === n);
                dot.classList.toggle('is-done', step < n);
            });
            if (leadEl) leadEl.textContent = leads[n] || '';
            showMsg('', true);
        }

        function syncCanal() {
            const canal = forms[1]?.querySelector('input[name="canal"]:checked')?.value || 'email';
            if (fieldEmail) fieldEmail.hidden = canal !== 'email';
            if (fieldSms) fieldSms.hidden = canal !== 'sms';
        }

        forms[1]?.querySelectorAll('input[name="canal"]').forEach((input) => {
            input.addEventListener('change', syncCanal);
        });
        syncCanal();

        forms[1]?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const canal = forms[1].querySelector('input[name="canal"]:checked')?.value || 'email';
            const destino = canal === 'email'
                ? forms[1].querySelector('[name="email"]')?.value.trim()
                : forms[1].querySelector('[name="telefono"]')?.value.trim();
            const body = new FormData();
            body.set('accion', 'solicitar');
            body.set('canal', canal);
            body.set('destino', destino || '');
            const res = await fetch(endpoint, { method: 'POST', body });
            const data = await res.json();
            if (!data.ok) {
                showMsg(data.error || 'No se pudo enviar el código.', false);
                return;
            }
            if (maskEl) maskEl.textContent = data.destino_mask || '';
            showMsg(data.mensaje || 'Código enviado.', true);
            setPaso(2);
        });

        forms[2]?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const body = new FormData();
            body.set('accion', 'verificar');
            body.set('codigo', forms[2].querySelector('[name="codigo"]')?.value.trim() || '');
            const res = await fetch(endpoint, { method: 'POST', body });
            const data = await res.json();
            if (!data.ok) {
                showMsg(data.error || 'Código inválido.', false);
                return;
            }
            showMsg(data.mensaje || 'Código verificado.', true);
            setPaso(3);
        });

        forms[2]?.querySelector('[data-recover-back]')?.addEventListener('click', () => setPaso(1));

        forms[3]?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const body = new FormData();
            body.set('accion', 'actualizar');
            body.set('password', forms[3].querySelector('[name="password"]')?.value || '');
            body.set('password2', forms[3].querySelector('[name="password2"]')?.value || '');
            const res = await fetch(endpoint, { method: 'POST', body });
            const data = await res.json();
            if (!data.ok) {
                showMsg(data.error || 'No se pudo guardar.', false);
                return;
            }
            showMsg(data.mensaje || 'Listo.', true);
            window.setTimeout(() => { window.location.href = 'login.php?recuperado=1'; }, 900);
        });

        setPaso(pasoInicial);
    })();
    </script>
    <?php $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>
</html>
