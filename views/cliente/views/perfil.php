<?php

$authInViews = true;
require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Usuario.php';
require_once __DIR__ . '/../includes/sport-images.php';

if (!$usuarioLogueado || empty($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario = Usuario::obtenerPorId((int) $_SESSION['usuario_id']);
if (!$usuario) {
    header('Location: login.php');
    exit;
}

$navInViews = true;
$activePage = 'perfil';
$cartBasePath = $assetBase;
$cartUrl = 'carrito_compras.php';
$controllerUrl = '../controllers/perfilController.php';

$ok = isset($_GET['ok']);
$error = (string) ($_GET['error'] ?? '');
$errorMsg = match ($error) {
    'email' => 'Ese correo ya está en uso por otra cuenta.',
    'fecha' => 'Revisa la fecha de nacimiento.',
    'password' => 'La contraseña nueva no es válida o no coincide.',
    'datos' => 'Revisa los datos del formulario.',
    'servidor' => 'No se pudo guardar. Intenta de nuevo.',
    default => '',
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Editar perfil | VEMA</title>
    <?php $pageCss = 'pages/login.css'; include __DIR__ . '/../includes/design-head.php'; ?>
</head>
<body class="auth-page bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface font-body-md antialiased transition-colors duration-300<?= deportivo_admin_body_class() ?>">
    <?php include __DIR__ . '/../includes/site-nav.php'; ?>

    <main class="auth-main">
        <div class="auth-shell" style="max-width: 28rem;">
            <header class="auth-brand">
                <p class="auth-brand-mark">VEMA</p>
                <p class="auth-brand-tag">Tu cuenta</p>
            </header>

            <div class="auth-card">
                <div class="auth-intro">
                    <h1 class="auth-title">Editar perfil</h1>
                    <p class="auth-lead">Actualiza tus datos personales. La contraseña es opcional.</p>
                    <?php if ($ok): ?>
                    <p class="auth-flash is-ok">Perfil actualizado.</p>
                    <?php elseif ($errorMsg !== ''): ?>
                    <p class="auth-flash is-error"><?= htmlspecialchars($errorMsg) ?></p>
                    <?php endif; ?>
                </div>

                <form action="<?= htmlspecialchars($controllerUrl) ?>" method="post" class="auth-form">
                    <div class="auth-row">
                        <div class="auth-field">
                            <label for="perfil-nombre">Nombres</label>
                            <input id="perfil-nombre" name="nombre" type="text" required autocomplete="given-name"
                                   value="<?= htmlspecialchars((string) ($usuario['nombre'] ?? '')) ?>" />
                        </div>
                        <div class="auth-field">
                            <label for="perfil-apellido">Apellidos</label>
                            <input id="perfil-apellido" name="apellido" type="text" required autocomplete="family-name"
                                   value="<?= htmlspecialchars((string) ($usuario['apellido'] ?? '')) ?>" />
                        </div>
                    </div>
                    <div class="auth-field">
                        <label for="perfil-email">Correo electrónico</label>
                        <input id="perfil-email" name="email" type="email" required autocomplete="email"
                               value="<?= htmlspecialchars((string) ($usuario['email'] ?? '')) ?>" />
                    </div>
                    <div class="auth-field">
                        <label for="perfil-telefono">Celular <span class="auth-optional">(opcional)</span></label>
                        <input id="perfil-telefono" name="telefono" type="tel" autocomplete="tel"
                               placeholder="300 123 4567"
                               value="<?= htmlspecialchars((string) ($usuario['telefono'] ?? '')) ?>" />
                    </div>
                    <div class="auth-field">
                        <label for="perfil-nacimiento">Fecha de nacimiento</label>
                        <input id="perfil-nacimiento" name="fecha_nacimiento" type="date"
                               max="<?= date('Y-m-d', strtotime('-13 years')) ?>" min="1920-01-01"
                               value="<?= htmlspecialchars((string) ($usuario['fecha_nacimiento'] ?? '')) ?>" />
                    </div>
                    <div class="auth-field">
                        <label for="perfil-password">Nueva contraseña <span class="auth-optional">(opcional)</span></label>
                        <input id="perfil-password" name="password" type="password" minlength="6" autocomplete="new-password"
                               placeholder="Déjala vacía para no cambiarla" />
                    </div>
                    <div class="auth-field">
                        <label for="perfil-password2">Confirmar contraseña</label>
                        <input id="perfil-password2" name="password2" type="password" minlength="6" autocomplete="new-password"
                               placeholder="Repite la nueva contraseña" />
                    </div>
                    <button class="auth-submit" type="submit">Guardar cambios</button>
                </form>

                <p class="auth-switch" style="margin-top: 1.25rem;">
                    <a class="auth-link" href="mis_pedidos.php">Ver mis pedidos</a>
                </p>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/site-footer.php'; ?>
    <?php $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>
</html>
