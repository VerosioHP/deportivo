<?php

define('DEPORTIVO_JSON_API', true);

require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/includes/ImagenProducto.php';
require_once dirname(__DIR__, 3) . '/views/cliente/includes/sport-images.php';
require_once dirname(__DIR__, 3) . '/models/SitioImagen.php';

header('Content-Type: application/json; charset=utf-8');

requerirAdmin();

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'get':
            $key = trim($_GET['key'] ?? '');

            if ($key === '') {
                echo json_encode(['ok' => false, 'error' => 'Clave de imagen inválida.']);
                exit;
            }

            $override = SitioImagen::obtener($key);
            $desdeVistas = !empty($_GET['desde_vistas']);

            echo json_encode([
                'ok' => true,
                'key' => $key,
                'url' => deportivo_img($key, 'lg', $desdeVistas),
                'override' => $override,
            ]);
            break;

        case 'update':
            $key = trim($_POST['key'] ?? '');

            if ($key === '') {
                echo json_encode(['ok' => false, 'error' => 'Clave de imagen inválida.']);
                exit;
            }

            $resultado = resolverImagenSitio(trim($_POST['url'] ?? ''));

            if (!$resultado['ok']) {
                echo json_encode(['ok' => false, 'error' => $resultado['error']]);
                exit;
            }

            if (!SitioImagen::guardar($key, $resultado['path'])) {
                echo json_encode(['ok' => false, 'error' => 'No se pudo guardar la imagen.']);
                exit;
            }

            $desdeVistas = !empty($_POST['desde_vistas']);
            $url = SitioImagen::urlPublica($resultado['path'], $desdeVistas);

            echo json_encode([
                'ok' => true,
                'message' => 'Imagen del sitio actualizada.',
                'key' => $key,
                'url' => $url . (str_contains($url, '?') ? '&' : '?') . 't=' . time(),
            ]);
            break;

        default:
            echo json_encode(['ok' => false, 'error' => 'Acción no válida.']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error al procesar la solicitud.']);
}

function resolverImagenSitio(string $urlImagen): array
{
    $archivo = $_FILES['imagen_archivo'] ?? null;

    if ($archivo && ($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        return ImagenProducto::guardar($archivo, 'sitio');
    }

    if ($urlImagen !== '') {
        return ['ok' => true, 'path' => $urlImagen];
    }

    return ['ok' => false, 'error' => 'Sube una imagen o indica una URL.'];
}
