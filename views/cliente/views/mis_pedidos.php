<?php

$authInViews = true;
require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Pedido.php';
require_once __DIR__ . '/../includes/sport-images.php';

if (!$usuarioLogueado || empty($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$pedidos = Pedido::listarPorUsuario((int) $_SESSION['usuario_id']);

$navInViews = true;
$activePage = 'pedidos';
$cartBasePath = $assetBase;
$cartUrl = 'carrito_compras.php';

$estadoLabel = static function (string $estado): string {
    return match ($estado) {
        'pendiente' => 'Pendiente',
        'confirmado' => 'Confirmado',
        'enviado' => 'Enviado',
        'cancelado' => 'Cancelado',
        default => ucfirst($estado),
    };
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Mis pedidos | VEMA</title>
    <?php $pageCss = 'pages/login.css'; include __DIR__ . '/../includes/design-head.php'; ?>
    <style>
        .orders-list { display: grid; gap: 1rem; margin-top: 1.5rem; }
        .order-card {
            border: 1px solid var(--color-outline-variant);
            padding: 1.15rem 1.1rem;
            background: color-mix(in srgb, var(--color-surface) 92%, transparent);
        }
        .order-card-top {
            display: flex; flex-wrap: wrap; justify-content: space-between; gap: 0.5rem 1rem;
            margin-bottom: 0.75rem;
        }
        .order-id {
            margin: 0;
            font-family: Anybody, sans-serif;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            font-size: 0.95rem;
        }
        .order-meta { margin: 0.2rem 0 0; font-size: 0.82rem; opacity: 0.65; }
        .order-status {
            font-family: "JetBrains Mono", monospace;
            font-size: 0.68rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 0.35rem 0.55rem;
            border: 1px solid currentColor;
            height: fit-content;
        }
        .order-items { margin: 0; padding: 0; list-style: none; display: grid; gap: 0.35rem; }
        .order-items li { font-size: 0.9rem; opacity: 0.85; }
        .order-total {
            margin: 0.9rem 0 0;
            font-family: Anybody, sans-serif;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        .orders-empty { text-align: center; padding: 2rem 0 0.5rem; opacity: 0.7; }
    </style>
</head>
<body class="auth-page bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface font-body-md antialiased transition-colors duration-300<?= deportivo_admin_body_class() ?>">
    <?php include __DIR__ . '/../includes/site-nav.php'; ?>

    <main class="auth-main">
        <div class="auth-shell" style="max-width: 36rem;">
            <header class="auth-brand">
                <p class="auth-brand-mark">VEMA</p>
                
            </header>

            <div class="auth-card">
                <div class="auth-intro">
                    <h1 class="auth-title">Mis pedidos</h1>
                    <p class="auth-lead">Consulta el estado y detalle de tus compras.</p>
                </div>

                <?php if (!$pedidos): ?>
                <div class="orders-empty">
                    <p>Aún no tienes pedidos.</p>
                    
                </div>
                <?php else: ?>
                <div class="orders-list">
                    <?php foreach ($pedidos as $pedido): ?>
                    <?php
                        $fecha = !empty($pedido['fecha_creacion'])
                            ? date('d/m/Y H:i', strtotime((string) $pedido['fecha_creacion']))
                            : '';
                        $items = $pedido['items'] ?? [];
                    ?>
                    <article class="order-card">
                        <div class="order-card-top">
                            <div>
                                <h2 class="order-id"><?= htmlspecialchars(Pedido::numeroPublico($pedido)) ?></h2>
                                <?php if ($fecha !== ''): ?>
                                <p class="order-meta"><?= htmlspecialchars($fecha) ?></p>
                                <?php endif; ?>
                            </div>
                            <span class="order-status"><?= htmlspecialchars($estadoLabel((string) ($pedido['estado'] ?? ''))) ?></span>
                        </div>
                        <?php if ($items): ?>
                        <ul class="order-items">
                            <?php foreach ($items as $item): ?>
                            <li>
                                <?= htmlspecialchars((string) ($item['nombre'] ?? 'Producto')) ?>
                                <?php if (!empty($item['talla'])): ?>
                                    · Talla <?= htmlspecialchars((string) $item['talla']) ?>
                                <?php endif; ?>
                                × <?= (int) ($item['cantidad'] ?? 1) ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                        <p class="order-total">
                            Total <?= htmlspecialchars(deportivo_formatear_precio((float) ($pedido['total'] ?? 0))) ?>
                        </p>
                    </article>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/site-footer.php'; ?>
    <?php $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>
</html>
