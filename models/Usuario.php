<?php

require_once __DIR__ . '/../config/database.php';

class Usuario
{
    public static function listar(): array
    {
        global $conexion;

        $sql = '
            SELECT id, nombre, apellido, email, rol, fecha_creacion
            FROM usuarios
            ORDER BY fecha_creacion DESC, id DESC
        ';

        return $conexion->query($sql)->fetchAll();
    }

    public static function obtenerPorId(int $id): ?array
    {
        global $conexion;

        $stmt = $conexion->prepare(
            'SELECT id, nombre, apellido, email, rol, fecha_creacion FROM usuarios WHERE id = :id LIMIT 1'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $usuario = $stmt->fetch();

        return $usuario ?: null;
    }

    public static function emailExiste(string $email, ?int $excluirId = null): bool
    {
        global $conexion;

        $sql = 'SELECT id FROM usuarios WHERE email = :email';

        if ($excluirId) {
            $sql .= ' AND id != :id';
        }

        $stmt = $conexion->prepare($sql . ' LIMIT 1');
        $stmt->bindValue(':email', trim($email));

        if ($excluirId) {
            $stmt->bindValue(':id', $excluirId, PDO::PARAM_INT);
        }

        $stmt->execute();

        return (bool) $stmt->fetch();
    }

    public static function crear(
        string $nombre,
        string $email,
        string $password,
        string $rol = 'cliente',
        string $apellido = ''
    ): int {
        global $conexion;

        $nombre = trim($nombre);
        $apellido = trim($apellido);
        $email = trim($email);
        $password = trim($password);
        $rol = self::normalizarRol($rol);

        self::validarDatos($nombre, $email, $password, true);

        if (self::emailExiste($email)) {
            throw new InvalidArgumentException('Ya existe un usuario con ese correo.');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conexion->prepare(
            'INSERT INTO usuarios (nombre, apellido, email, password, rol)
             VALUES (:nombre, :apellido, :email, :password, :rol)'
        );
        $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido !== '' ? $apellido : null,
            ':email' => $email,
            ':password' => $passwordHash,
            ':rol' => $rol,
        ]);

        return (int) $conexion->lastInsertId();
    }

    public static function actualizar(
        int $id,
        string $nombre,
        string $email,
        string $rol,
        string $apellido = '',
        ?string $password = null
    ): bool {
        global $conexion;

        if ($id <= 0) {
            return false;
        }

        $usuario = self::obtenerPorId($id);

        if (!$usuario) {
            return false;
        }

        $nombre = trim($nombre);
        $apellido = trim($apellido);
        $email = trim($email);
        $rol = self::normalizarRol($rol);
        $password = $password !== null ? trim($password) : null;

        self::validarDatos($nombre, $email, $password ?? 'placeholder', $password !== null && $password !== '');

        if (self::emailExiste($email, $id)) {
            throw new InvalidArgumentException('Ya existe otro usuario con ese correo.');
        }

        if ($usuario['rol'] === 'admin' && $rol === 'cliente' && self::contarAdmins() <= 1) {
            throw new InvalidArgumentException('No puedes quitar el rol de administrador al único admin.');
        }

        $sql = '
            UPDATE usuarios
            SET nombre = :nombre,
                apellido = :apellido,
                email = :email,
                rol = :rol
        ';
        $params = [
            ':nombre' => $nombre,
            ':apellido' => $apellido !== '' ? $apellido : null,
            ':email' => $email,
            ':rol' => $rol,
            ':id' => $id,
        ];

        if ($password !== null && $password !== '') {
            $sql .= ', password = :password';
            $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= ' WHERE id = :id';

        $stmt = $conexion->prepare($sql);

        return $stmt->execute($params);
    }

    public static function eliminar(int $id, int $usuarioSesionId): array
    {
        global $conexion;

        if ($id <= 0) {
            return ['ok' => false, 'error' => 'ID de usuario inválido.'];
        }

        if ($id === $usuarioSesionId) {
            return ['ok' => false, 'error' => 'No puedes eliminar tu propia cuenta mientras tienes la sesión activa.'];
        }

        $usuario = self::obtenerPorId($id);

        if (!$usuario) {
            return ['ok' => false, 'error' => 'Usuario no encontrado.'];
        }

        if ($usuario['rol'] === 'admin' && self::contarAdmins() <= 1) {
            return ['ok' => false, 'error' => 'No se puede eliminar al único administrador.'];
        }

        $stmt = $conexion->prepare('DELETE FROM usuarios WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if (!$stmt->execute() || $stmt->rowCount() === 0) {
            return ['ok' => false, 'error' => 'No se pudo eliminar el usuario.'];
        }

        return ['ok' => true];
    }

    public static function contarAdmins(): int
    {
        global $conexion;

        return (int) $conexion->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'admin'")->fetchColumn();
    }

    private static function normalizarRol(string $rol): string
    {
        return $rol === 'admin' ? 'admin' : 'cliente';
    }

    private static function validarDatos(
        string $nombre,
        string $email,
        string $password,
        bool $requierePassword
    ): void {
        if ($nombre === '') {
            throw new InvalidArgumentException('El nombre es obligatorio.');
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('El correo electrónico no es válido.');
        }

        if ($requierePassword && strlen($password) < 6) {
            throw new InvalidArgumentException('La contraseña debe tener al menos 6 caracteres.');
        }
    }
}
