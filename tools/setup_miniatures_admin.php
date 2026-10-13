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
$reset = ($argc === 2 && ($argv[1] ?? '') === '--reset');
if ($argc > 1 && !$reset) {
    fwrite(STDERR, "Uso: sudo php tools/setup_miniatures_admin.php [--reset]\n");
    exit(1);
}
if (is_link($path)) {
    fwrite(STDERR, "La configuración no debe ser un enlace simbólico.\n");
    exit(1);
}
if (file_exists($path) && !$reset) {
    fwrite(STDERR, "La cuenta ya existe. Usa --reset para establecer otra Llave sin borrar el respaldo.\n");
    exit(1);
}
if (!file_exists($path) && $reset) {
    fwrite(STDERR, "La cuenta no existe. Ejecuta sin --reset para crearla.\n");
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

echo ($reset ? "Restablecer cuenta EXCLUSIVA de Miniaturas.\n" : "Nueva cuenta EXCLUSIVA de Miniaturas.\n");
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
// Escribir en fichero temporal con creación exclusiva y sustitución atómica.
$tmp = $path . '.new-' . bin2hex(random_bytes(8));
$previousUmask = umask(0077);
$fd = @fopen($tmp, 'x');
umask($previousUmask);
if (!is_resource($fd)) {
    fwrite(STDERR, "No se puede preparar la configuración privada.\n");
    exit(1);
}
try {
    if (fwrite($fd, $bytes) !== strlen($bytes) || !fflush($fd)) {
        throw new RuntimeException('write');
    }
} catch (Throwable $e) {
    fclose($fd);
    @unlink($tmp);
    fwrite(STDERR, "No se pudo escribir el nuevo hash.\n");
    exit(1);
}
fclose($fd);
if (!chmod($tmp, 0640) || !chgrp($tmp, 'www-data')) {
    @unlink($tmp);
    fwrite(STDERR, "No se pudieron asignar permisos privados.\n");
    exit(1);
}

$backup = null;
if ($reset) {
    // La copia previa es legible solo por root, no se publica en /html.
    $backup = $path . '.bak-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4));
    if (!rename($path, $backup)) {
        @unlink($tmp);
        fwrite(STDERR, "No se pudo conservar la configuración anterior.\n");
        exit(1);
    }
    @chmod($backup, 0600);
}
if (!rename($tmp, $path)) {
    @unlink($tmp);
    if ($backup !== null) {
        @rename($backup, $path);
        @chmod($path, 0640);
        @chgrp($path, 'www-data');
    }
    fwrite(STDERR, "No se pudo activar la nueva configuración.\n");
    exit(1);
}
echo ($reset ? "Acceso restablecido. El hash antiguo quedó respaldado fuera de la web.\n" :
    "Acceso creado en fichero privado fuera de la web.\n");
echo "No se ha alterado main_users ni la base de datos.\n";
