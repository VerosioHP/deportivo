<?php

session_start();

require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Pedido.php';

$pedidoId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$pedido = $pedidoId > 0 ? Pedido::obtenerPorId($pedidoId) : null;

if (!$pedido) {
    header('Location: catalogo.php?categoria=camisetas');
    exit;
}

// Si ya eligió método de pago, ir al éxito.
if (!empty($pedido['metodo_pago'])) {
    header('Location: checkout_exito.php?id=' . $pedidoId);
    exit;
}

if (($pedido['estado'] ?? '') === 'cancelado') {
    header('Location: catalogo.php?categoria=camisetas');
    exit;
}

$pagoConfig = require dirname(__DIR__, 3) . '/config/pago.php';
$cuentas = $pagoConfig['cuentas'] ?? [];
$esMetropolitana = ($pedido['zona_envio'] ?? '') === 'metropolitana'
    || Pedido::esZonaMetropolitana((string) $pedido['ciudad']);
$numeroPedido = Pedido::numeroPublico($pedido);
$error = $_GET['error'] ?? '';

$mensajesError = [
    'metodo' => 'Selecciona una forma de pago para continuar.',
    'comprobante' => 'Debes subir la imagen del comprobante de transferencia.',
    'archivo' => 'No pudimos guardar el comprobante. Usa JPG, PNG o WEBP (máx. 5 MB).',
    'servidor' => 'No pudimos confirmar el pago. Inténtalo de nuevo.',
];
$mensajeError = $mensajesError[$error] ?? '';

$navInViews = true;
$cartBasePath = $assetBase;
$cartUrl = 'carrito_compras.php';

?>
<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Método de pago | DEPORTIVO</title>
    <?php include __DIR__ . '/../includes/design-head.php'; ?>
</head>

<body class="font-body-md text-on-background dark:bg-on-background dark:text-inverse-on-surface transition-colors duration-300">
    <?php include __DIR__ . '/../includes/site-nav.php'; ?>

    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-20">
        <nav class="flex items-center gap-2 font-label-sm text-label-sm text-on-surface-variant mb-8">
            <a href="carrito_compras.php" class="hover:text-secondary transition-colors no-underline text-current">Carrito</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a href="checkout.php" class="hover:text-secondary transition-colors no-underline text-current">Envío</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary dark:text-primary-fixed">Pago</span>
        </nav>

        <h1 class="font-display-lg text-display-lg mb-4 text-primary dark:text-primary-fixed uppercase">Método de pago</h1>

        <?php if ($esMetropolitana): ?>
        <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-3xl">
            Realizaste tu pedido dentro del área metropolitana. Tu forma de pago será
            <strong class="text-primary dark:text-primary-fixed">contraentrega</strong> o
            <strong class="text-primary dark:text-primary-fixed">transferencia</strong>.
        </p>
        <?php else: ?>
        <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-3xl">
            Realizaste tu pedido a la ciudad de
            <strong class="text-primary dark:text-primary-fixed"><?= htmlspecialchars($pedido['ciudad']) ?></strong>.
            Lee la siguiente información sobre nuestro método de pago.
        </p>
        <?php endif; ?>

        <?php if ($mensajeError): ?>
        <div class="mb-8 p-4 border border-error/30 bg-error-container/30 text-on-error-container font-body-md">
            <?= htmlspecialchars($mensajeError) ?>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            <section class="lg:col-span-7">
                <form id="pago-form" action="../controllers/pagoController.php" method="post" enctype="multipart/form-data" class="space-y-10">
                    <input type="hidden" name="pedido_id" value="<?= (int) $pedido['id'] ?>" />

                    <?php if ($esMetropolitana): ?>
                    <div class="pago-opciones space-y-4">
                        <h2 class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed">Elige cómo pagar</h2>
                        <label class="pago-opcion is-selected">
                            <input type="radio" name="metodo_pago" value="contraentrega" checked data-pago-opcion />
                            <span class="pago-opcion-check" aria-hidden="true"></span>
                            <span class="pago-opcion-texto">
                                <span class="pago-opcion-titulo">Contraentrega</span>
                                <span class="pago-opcion-desc">Pagas al recibir el pedido en tu dirección.</span>
                            </span>
                        </label>
                        <label class="pago-opcion">
                            <input type="radio" name="metodo_pago" value="transferencia" data-pago-opcion />
                            <span class="pago-opcion-check" aria-hidden="true"></span>
                            <span class="pago-opcion-texto">
                                <span class="pago-opcion-titulo">Transferencia</span>
                                <span class="pago-opcion-desc">Transfiere antes y sube el comprobante para verificar el pedido.</span>
                            </span>
                        </label>
                    </div>
                    <?php else: ?>
                    <input type="hidden" name="metodo_pago" value="transferencia" />
                    <?php endif; ?>

                    <div id="bloque-transferencia" class="<?= $esMetropolitana ? 'hidden' : '' ?> space-y-8">
                        <div class="pago-transferencia-card">
                            <p class="pago-transferencia-saludo">
                                Hola <strong><?= htmlspecialchars($pedido['nombre']) ?></strong>, tu número de pedido es
                                <strong class="pago-transferencia-pedido"><?= htmlspecialchars($numeroPedido) ?></strong>.
                            </p>
                            <p class="pago-transferencia-intro">
                                A las siguientes cuentas puedes realizar la transferencia de pago:
                            </p>
                            <ul class="pago-transferencia-cuentas">
                                <?php foreach ($cuentas as $cuenta): ?>
                                <li>
                                    <span class="pago-cuenta-banco"><?= htmlspecialchars($cuenta['banco'] ?? '') ?></span>
                                    <span class="pago-cuenta-numero select-all"><?= htmlspecialchars($cuenta['numero'] ?? '') ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="pago-transferencia-total">
                                <span class="pago-transferencia-total-label">Total a transferir</span>
                                <span class="pago-transferencia-total-valor"><?= deportivo_formatear_precio((float) $pedido['total']) ?></span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="block font-label-md text-label-md text-on-surface-variant uppercase tracking-widest" for="comprobante">
                                Sube la imagen del comprobante <?= $esMetropolitana ? '(si pagas por transferencia)' : '*' ?>
                            </label>
                            <input
                                class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-secondary file:text-on-secondary file:font-label-sm file:uppercase file:tracking-widest file:cursor-pointer"
                                id="comprobante"
                                name="comprobante"
                                type="file"
                                accept="image/jpeg,image/png,image/webp,image/gif"
                            />
                            <p class="font-body-sm text-on-surface-variant">Formatos: JPG, PNG, WEBP o GIF. Máximo 5 MB.</p>
                            <div id="comprobante-preview" class="pago-comprobante-preview hidden">
                                <button type="button" id="comprobante-preview-btn" class="pago-comprobante-thumb" title="Ampliar comprobante">
                                    <img src="" alt="Vista previa del comprobante" />
                                    <span class="pago-comprobante-hint">
                                        <span class="material-symbols-outlined">zoom_in</span>
                                        Ver
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 pt-4">
                        <button type="submit" name="accion" value="confirmar" class="w-full py-4 bg-secondary text-on-secondary font-label-md uppercase tracking-widest hover:opacity-90 transition-all">
                            Confirmar pedido
                        </button>
                        <button type="submit" name="accion" value="cancelar" formnovalidate class="w-full py-4 border border-outline-variant text-on-surface-variant font-label-md uppercase tracking-widest hover:border-error hover:text-error transition-all" data-cancelar-pedido>
                            Cancelar pedido
                        </button>
                    </div>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Al confirmar, tu pedido quedará pendiente de revisión por la tienda<?= $esMetropolitana ? ' según el método de pago elegido' : ' junto con el comprobante de transferencia' ?>.
                    </p>
                </form>
            </section>

            <aside class="lg:col-span-5 bg-surface-container-low dark:bg-tertiary-container p-10">
                <h2 class="font-headline-sm text-headline-sm mb-6">Resumen</h2>
                <p class="font-label-sm uppercase tracking-widest text-on-surface-variant mb-2">Pedido</p>
                <p class="font-body-lg mb-6"><?= htmlspecialchars($numeroPedido) ?></p>
                <p class="font-label-sm uppercase tracking-widest text-on-surface-variant mb-2">Envío a</p>
                <p class="font-body-md mb-1"><?= htmlspecialchars($pedido['ciudad'] . ', ' . $pedido['provincia']) ?></p>
                <p class="font-body-md text-on-surface-variant mb-6"><?= htmlspecialchars($pedido['direccion']) ?></p>
                <div class="border-t border-outline-variant pt-6 space-y-2">
                    <div class="flex justify-between font-body-md">
                        <span class="text-on-surface-variant">Subtotal</span>
                        <span><?= deportivo_formatear_precio((float) $pedido['subtotal']) ?></span>
                    </div>
                    <div class="flex justify-between font-body-md">
                        <span class="text-on-surface-variant">Envío</span>
                        <span><?= deportivo_formatear_precio((float) $pedido['envio']) ?></span>
                    </div>
                    <div class="flex justify-between font-body-lg font-bold pt-4 border-t border-outline-variant">
                        <span>Total</span>
                        <span><?= deportivo_formatear_precio((float) $pedido['total']) ?></span>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/site-footer.php'; ?>

    <div id="comprobante-lightbox" class="pago-comprobante-lightbox hidden" hidden>
        <button type="button" class="pago-comprobante-lightbox-cerrar" id="comprobante-lightbox-cerrar" aria-label="Cerrar">
            <span class="material-symbols-outlined">close</span>
        </button>
        <img src="" alt="Comprobante ampliado" id="comprobante-lightbox-img" />
    </div>

    <script>
        (function () {
            const opciones = document.querySelectorAll('[data-pago-opcion]');
            const bloqueTransferencia = document.getElementById('bloque-transferencia');
            const inputComprobante = document.getElementById('comprobante');
            const preview = document.getElementById('comprobante-preview');
            const previewBtn = document.getElementById('comprobante-preview-btn');
            const previewImg = preview ? preview.querySelector('img') : null;
            const lightbox = document.getElementById('comprobante-lightbox');
            const lightboxImg = document.getElementById('comprobante-lightbox-img');
            const lightboxCerrar = document.getElementById('comprobante-lightbox-cerrar');
            let previewObjectUrl = '';

            function abrirLightbox() {
                if (!lightbox || !lightboxImg || !previewObjectUrl) return;
                lightboxImg.src = previewObjectUrl;
                lightbox.hidden = false;
                lightbox.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function cerrarLightbox() {
                if (!lightbox || !lightboxImg) return;
                lightbox.classList.add('hidden');
                lightbox.hidden = true;
                lightboxImg.src = '';
                document.body.style.overflow = '';
            }

            function actualizarVista() {
                opciones.forEach((opcion) => {
                    const label = opcion.closest('.pago-opcion');
                    if (label) {
                        label.classList.toggle('is-selected', opcion.checked);
                    }
                });

                if (!bloqueTransferencia) return;
                const seleccion = document.querySelector('input[name="metodo_pago"]:checked');
                const esTransferencia = !seleccion || seleccion.value === 'transferencia';
                bloqueTransferencia.classList.toggle('hidden', !esTransferencia);
            }

            opciones.forEach((opcion) => {
                opcion.addEventListener('change', actualizarVista);
            });

            if (inputComprobante && preview && previewImg) {
                inputComprobante.addEventListener('change', () => {
                    const archivo = inputComprobante.files && inputComprobante.files[0];
                    if (previewObjectUrl) {
                        URL.revokeObjectURL(previewObjectUrl);
                        previewObjectUrl = '';
                    }
                    if (!archivo) {
                        preview.classList.add('hidden');
                        previewImg.src = '';
                        cerrarLightbox();
                        return;
                    }
                    previewObjectUrl = URL.createObjectURL(archivo);
                    previewImg.src = previewObjectUrl;
                    preview.classList.remove('hidden');
                });
            }

            if (previewBtn) {
                previewBtn.addEventListener('click', abrirLightbox);
            }

            const btnCancelar = document.querySelector('[data-cancelar-pedido]');
            if (btnCancelar) {
                btnCancelar.addEventListener('click', (event) => {
                    if (!window.confirm('¿Seguro que quieres cancelar este pedido?')) {
                        event.preventDefault();
                    }
                });
            }

            if (lightboxCerrar) {
                lightboxCerrar.addEventListener('click', cerrarLightbox);
            }

            if (lightbox) {
                lightbox.addEventListener('click', (event) => {
                    if (event.target === lightbox) {
                        cerrarLightbox();
                    }
                });
            }

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && lightbox && !lightbox.classList.contains('hidden')) {
                    cerrarLightbox();
                }
            });

            actualizarVista();
        })();
    </script>
    <?php $cartBasePath = $assetBase; $cartUrl = 'carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($clienteJsPath) ?>cart.js"></script>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>

</html>
