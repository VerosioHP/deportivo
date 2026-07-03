<?php

class SitioImagen
{
    private static function storagePath(): string
    {
        return __DIR__ . '/../data/site-images.json';
    }

    private static function leer(): array
    {
        $path = self::storagePath();

        if (!is_file($path)) {
            return [];
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        return is_array($data) ? $data : [];
    }

    private static function escribir(array $data): bool
    {
        $path = self::storagePath();
        $dir = dirname($path);

        if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
            return false;
        }

        return file_put_contents(
            $path,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        ) !== false;
    }

    public static function obtener(string $key): ?string
    {
        $data = self::leer();

        return isset($data[$key]) && $data[$key] !== '' ? (string) $data[$key] : null;
    }

    public static function guardar(string $key, string $valor): bool
    {
        $data = self::leer();
        $data[$key] = $valor;

        return self::escribir($data);
    }

    public static function listar(): array
    {
        return self::leer();
    }

    public static function urlPublica(string $ruta, bool $desdeVistas = false): string
    {
        if (preg_match('#^https?://#i', $ruta) || str_starts_with($ruta, '//')) {
            return $ruta;
        }

        if (function_exists('deportivo_upload_url')) {
            return deportivo_upload_url($ruta);
        }

        return ($desdeVistas ? '../' : '') . ltrim($ruta, '/');
    }
}
