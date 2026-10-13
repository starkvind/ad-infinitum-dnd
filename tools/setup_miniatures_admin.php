<?php
/**
 * Crear un único usuario de Miniaturas, sin utilizar main_users.
 * Se ejecuta únicamente por SSH: sudo php tools/setup_miniatures_admin.php
 */
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../content/miniatures_admin_lib.php';

$path = dnd_mini_config_path();
if (file_exists($path)) {
    fwrite(STDERR, "La cuenta ya existe. No se sobrescribe automáticamente.\n");
    exit(1);
}
if (function_exists('posix_geteuid') && posix_geteuid() !== 0) {
    fwrite(STDERR, "Ejecuta con sudo para guardar la llave fuera de la web con permisos de www-data.\n");
    exit(1);
}
if (!function_exists('shell_exec') || !function_exists('system')) {
    fwrite(STDERR, "El terminal no permite ocultar contraseñas. No se genera ningún fichero.\n");
    exit(1);
}
$ttyState = @shell_exec('stty -g 2>/dev/null');
if (!is_string($ttyState) || trim($ttyState) === '') {
    fwrite(STDERR, "Necesitas una terminal SSH interactiva.\n");
    exit(1);
}

echo "Nueva cuenta EXCLUSIVA de Miniaturas (sin usar main_users).\n";
echo "Persona (3-40 letras, números, puntos, guiones): ";
$persona = trim((string)fgets(STDIN));
if (!preg_match('/\A[a-zA-Z0-9._-]{3,40}\z/', $persona)) {
    fwrite(STDERR, "Persona inválida.\n");
    exit(1);
}

$readSecret = static function (string $label) use ($ttyState): string {
    echo $label;
    @system('stty -echo');
    try {
        $value = rtrim((string)fgets(STDIN), "\r\n");
    } finally {
        @system('stty ' . escapeshellarg(trim($ttyState)));
        echo "\n";
    }
    return $value;
};

$llave = $readSecret('Llave nueva (mínimo 14 caracteres): ');
$confirmacion = $readSecret('Repite la llave: ');
if (strlen($llave) < 14 || strlen($llave) > 256 || !hash_equals($llave, $confirmacion)) {
    fwrite(STDERR, "La llave debe tener 14-256 caracteres y coincidir.\n");
    exit(1);
}
$hash = password_hash($llave, PASSWORD_DEFAULT);
unset($llave, $confirmacion);
if (!is_string($hash)) {
    fwrite(STDERR, "No se pudo crear el hash.\n");
    exit(1);
}
$bytes = "<?php\n// Configuración privada: no subir a GitHub ni mover al directorio html.\nreturn "
    . var_export(['persona' => $persona, 'hash' => $hash], true) . ";\n";
$fd = @fopen($path, 'x');
if (!is_resource($fd)) {
    fwrite(STDERR, "No se puede crear configuración privada fuera del directorio web.\n");
    exit(1);
}
try {
    if (!fwrite($fd, $bytes) || !fflush($fd)) {
        throw new RuntimeException('write');
    }
} catch (Throwable $e) {
    fclose($fd);
    @unlink($path);
    fwrite(STDERR, "Error al escribir configuración.\n");
    exit(1);
}
fclose($fd);
if (!chmod($path, 0640) || !chgrp($path, 'www-data')) {
    @unlink($path);
    fwrite(STDERR, "No se pueden asignar permisos privados al fichero.\n");
    exit(1);
}
echo "Acceso creado en fichero privado fuera de la web. No se ha alterado main_users.\n";
