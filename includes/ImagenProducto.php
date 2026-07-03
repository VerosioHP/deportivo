<?php

class ImagenProducto
{
    private const UPLOAD_DIR = __DIR__ . '/../uploads/productos';
    private const MAX_BYTES = 5242880;
    private const ALLOWED_MIMES = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];

    public static function guardar(array $archivo): array
    {
        if (($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return ['ok' => false, 'error' => 'No se pudo subir la imagen.'];
        }

        if (($archivo['size'] ?? 0) > self::MAX_BYTES) {
            return ['ok' => false, 'error' => 'La imagen no puede superar 5 MB.'];
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($archivo['tmp_name']);

        if (!isset(self::ALLOWED_MIMES[$mime])) {
            return ['ok' => false, 'error' => 'Formato no permitido. Usa JPG, PNG, WEBP o GIF.'];
        }

        if (!is_dir(self::UPLOAD_DIR) && !mkdir(self::UPLOAD_DIR, 0755, true)) {
            return ['ok' => false, 'error' => 'No se pudo crear la carpeta de subidas.'];
        }

        $extension = self::ALLOWED_MIMES[$mime];
        $nombre = 'prod_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
        $destino = self::UPLOAD_DIR . '/' . $nombre;

        if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
            return ['ok' => false, 'error' => 'Error al guardar la imagen en el servidor.'];
        }

        return ['ok' => true, 'path' => 'uploads/productos/' . $nombre];
    }

    public static function esRutaLocal(string $ruta): bool
    {
        return !preg_match('#^https?://#i', $ruta) && !str_starts_with($ruta, '//');
    }
}
