<?php
$authInViews = true;
require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once __DIR__ . '/../includes/sport-images.php';

$showRegister = isset($_GET['error']) || (isset($_GET['registro']) && $_GET['registro'] !== 'ok');
$registroOk = isset($_GET['registro']) && $_GET['registro'] === 'ok';
$emailExiste = isset($_GET['error']) && $_GET['error'] === 'email_existe';
$fechaInvalida = isset($_GET['error']) && $_GET['error'] === 'fecha_invalida';
$datosIncompletos = isset($_GET['error']) && in_array($_GET['error'], ['datos_incompletos', 'password_corta'], true);
$recuperado = !empty($_GET['recuperado']);
if ($registroOk) {
    $showRegister = false;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Iniciar sesión | VEMA</title>
    <?php $pageCss = 'pages/login.css'; include __DIR__ . '/../includes/design-head.php'; ?>
</head>
<body class="auth-page bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface font-body-md antialiased overflow-x-hidden transition-colors duration-300<?= deportivo_admin_body_class() ?>">
<?php
$navInViews = true;
$activePage = 'login';
$cartBasePath = $assetBase;
$cartUrl = 'carrito_compras.php';
?>
    <?php include __DIR__ . '/../includes/site-nav.php'; ?>
    <?php include dirname(__DIR__, 2) . '/administrador/includes/admin-panel.php'; ?>

    <main class="auth-main">
        <div class="auth-shell">
            <header class="auth-brand">
                <p class="auth-brand-mark">VEMA</p>
                
            </header>

            <div class="auth-card" id="auth-container">
                <!-- Login -->
                <section class="auth-panel<?= $showRegister ? ' hidden' : '' ?>" id="login-section"<?= $showRegister ? ' hidden' : '' ?>>
                    <div class="auth-intro">
                        <h1 class="auth-title">Bienvenido</h1>
                        <p class="auth-lead">Entra a tu cuenta para seguir comprando.</p>
                        <?php if ($recuperado): ?>
                        <p class="auth-flash is-ok">Contraseña actualizada. Ya puedes iniciar sesión.</p>
                        <?php endif; ?>
                        <?php if ($registroOk): ?>
                        <p class="auth-flash is-ok">Cuenta creada. Inicia sesión con tu correo.</p>
                        <?php endif; ?>
                    </div>

                    <form action="../controllers/loginController.php" method="post" class="auth-form">
                        <div class="auth-field">
                            <label for="login-email">Correo electrónico</label>
                            <input id="login-email" name="email" type="email" placeholder="nombre@ejemplo.com" autocomplete="email" required />
                        </div>
                        <div class="auth-field">
                            <div class="auth-field-head">
                                <label for="login-password">Contraseña</label>
                                <a class="auth-link" href="recuperar.php">¿Olvidaste tu contraseña?</a>
                            </div>
                            <input id="login-password" name="password" type="password" placeholder="••••••••" autocomplete="current-password" required />
                        </div>
                        <button class="auth-submit" type="submit">Iniciar sesión</button>
                    </form>

                    <div class="auth-divider" aria-hidden="true"><span>o continúa con</span></div>

                    <div class="auth-social">
                        <button type="button" class="auth-social-btn" disabled title="Próximamente">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                            Google
                        </button>
                        <button type="button" class="auth-social-btn" disabled title="Próximamente">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.559-1.701z"/></svg>
                            Apple
                        </button>
                    </div>

                    <p class="auth-switch">
                        ¿Nuevo en VEMA?
                        <button type="button" class="auth-link" onclick="toggleAuth('register')">Crear cuenta</button>
                    </p>
                </section>

                <!-- Register -->
                <section class="auth-panel<?= $showRegister ? '' : ' hidden' ?>" id="register-section"<?= $showRegister ? '' : ' hidden' ?>>
                    <div class="auth-intro">
                        <h1 class="auth-title">Crea tu cuenta</h1>
                        <p class="auth-lead">Tus datos son tuyos. No los compartimos con terceros.</p>
                        <?php if ($emailExiste): ?>
                        <p class="auth-flash is-error">Ese correo ya está registrado. Inicia sesión o recupera tu acceso.</p>
                        <?php elseif ($fechaInvalida): ?>
                        <p class="auth-flash is-error">Revisa la fecha de nacimiento. Debes tener al menos 13 años.</p>
                        <?php elseif ($datosIncompletos): ?>
                        <p class="auth-flash is-error">Completa todos los campos. La contraseña debe tener al menos 8 caracteres.</p>
                        <?php endif; ?>
                    </div>

                    <form action="../controllers/registerController.php" method="post" class="auth-form">
                        <div class="auth-row">
                            <div class="auth-field">
                                <label for="reg-nombre">Nombres</label>
                                <input id="reg-nombre" name="nombre" type="text" placeholder="María" autocomplete="given-name" required />
                            </div>
                            <div class="auth-field">
                                <label for="reg-apellido">Apellidos</label>
                                <input id="reg-apellido" name="apellido" type="text" placeholder="García" autocomplete="family-name" required />
                            </div>
                        </div>
                        <div class="auth-field">
                            <label for="reg-email">Correo electrónico</label>
                            <input id="reg-email" name="email" type="email" placeholder="nombre@ejemplo.com" autocomplete="email" required />
                        </div>
                        <div class="auth-field">
                            <label for="reg-nacimiento">Fecha de nacimiento</label>
                            <input id="reg-nacimiento" name="fecha_nacimiento" type="date" required max="<?= date('Y-m-d', strtotime('-13 years')) ?>" min="1920-01-01" />
                            <span class="auth-hint">La usamos para cumpleaños VEMA y para conocernos mejor como comunidad.</span>
                        </div>
                        <div class="auth-field">
                            <label for="reg-telefono">Celular <span class="auth-optional">(opcional)</span></label>
                            <input id="reg-telefono" name="telefono" type="tel" placeholder="300 123 4567" autocomplete="tel" />
                        </div>
                        <div class="auth-field">
                            <label for="reg-password">Contraseña</label>
                            <input id="reg-password" name="password" type="password" placeholder="Mín. 8 caracteres" autocomplete="new-password" minlength="8" required />
                        </div>
                        <div class="auth-check">
                            <input id="reg-terms" type="checkbox" required />
                            <label for="reg-terms">Acepto los <a href="login.php">Términos de servicio</a> y la <a href="login.php">Política de privacidad</a>.</label>
                        </div>
                        <button class="auth-submit" type="submit">Crear cuenta</button>
                    </form>

                    <div class="auth-divider" aria-hidden="true"><span>o regístrate con</span></div>

                    <div class="auth-social">
                        <button type="button" class="auth-social-btn" disabled title="Próximamente">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                            Google
                        </button>
                        <button type="button" class="auth-social-btn" disabled title="Próximamente">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.559-1.701z"/></svg>
                            Apple
                        </button>
                    </div>

                    <p class="auth-switch">
                        ¿Ya tienes cuenta?
                        <button type="button" class="auth-link" onclick="toggleAuth('login')">Iniciar sesión</button>
                    </p>
                </section>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/site-footer.php'; ?>
    <script>
        function toggleAuth(type) {
            const container = document.getElementById('auth-container');
            const loginSection = document.getElementById('login-section');
            const registerSection = document.getElementById('register-section');
            container.classList.add('is-switching');
            window.setTimeout(() => {
                const toRegister = type === 'register';
                loginSection.classList.toggle('hidden', toRegister);
                registerSection.classList.toggle('hidden', !toRegister);
                loginSection.hidden = toRegister;
                registerSection.hidden = !toRegister;
                container.classList.remove('is-switching');
            }, 220);
        }
    </script>
    <?php $cartBasePath = $assetBase; $cartUrl = 'carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>
</html>
