<?php

class ImagenProducto
{
    private const UPLOAD_DIRS = [
        'productos' => __DIR__ . '/../uploads/productos',
        'sitio' => __DIR__ . '/../uploads/sitio',
    ];
    private const MAX_BYTES = 5242880;
    private const ALLOWED_MIMES = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];

    public static function guardar(array $archivo, string $tipo = 'productos'): array
    {
        $error = $archivo['error'] ?? UPLOAD_ERR_NO_FILE;

        if ($error !== UPLOAD_ERR_OK) {
            return ['ok' => false, 'error' => self::mensajeErrorSubida($error)];
        }

        if (($archivo['size'] ?? 0) > self::MAX_BYTES) {
            return ['ok' => false, 'error' => 'La imagen no puede superar 5 MB.'];
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($archivo['tmp_name']);

        if (!isset(self::ALLOWED_MIMES[$mime])) {
            return ['ok' => false, 'error' => 'Formato no permitido. Usa JPG, PNG, WEBP o GIF.'];
        }

        $uploadDir = self::UPLOAD_DIRS[$tipo] ?? self::UPLOAD_DIRS['productos'];
        $prefix = $tipo === 'sitio' ? 'sitio_' : 'prod_';
        $folder = $tipo === 'sitio' ? 'uploads/sitio' : 'uploads/productos';

        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            return ['ok' => false, 'error' => 'No se pudo crear la carpeta de subidas.'];
        }

        $extension = self::ALLOWED_MIMES[$mime];
        $nombre = $prefix . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
        $destino = $uploadDir . '/' . $nombre;

        if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
            return ['ok' => false, 'error' => 'Error al guardar la imagen en el servidor.'];
        }

        return ['ok' => true, 'path' => $folder . '/' . $nombre];
    }

    public static function esRutaLocal(string $ruta): bool
    {
        return !preg_match('#^https?://#i', $ruta) && !str_starts_with($ruta, '//');
    }

    private static function mensajeErrorSubida(int $codigo): string
    {
        return match ($codigo) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'La imagen supera el tamaño máximo permitido (5 MB).',
            UPLOAD_ERR_PARTIAL => 'La imagen se subió solo parcialmente. Intenta de nuevo.',
            UPLOAD_ERR_NO_FILE => 'No se seleccionó ninguna imagen.',
            UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE => 'El servidor no pudo guardar la imagen temporal.',
            UPLOAD_ERR_EXTENSION => 'El servidor bloqueó este tipo de archivo.',
            default => 'No se pudo subir la imagen.',
        };
    }
}
