<?php
/**
 * Diagnóstico privado de acceso, sin imprimir credenciales ni hash.
 *
 * En Raspberry:
 *   sudo -u www-data php tools/check_miniatures_access.php
 *   sudo -u www-data php tools/check_miniatures_access.php --verify
 */
declare(strict_types=1);
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
if ($argc > 2 || ($argc === 2 && ($argv[1] ?? '') !== '--verify')) {
    fwrite(STDERR, "Uso: php tools/check_miniatures_access.php [--verify]\n");
    exit(1);
}
require_once __DIR__ . '/../content/miniatures_admin_lib.php';

$path = dnd_mini_config_path();
if (is_link($path)) {
    fwrite(STDERR, "ERROR: la configuración es un enlace simbólico. No continuar.\n");
    exit(1);
}
if (!is_file($path)) {
    fwrite(STDERR, "ERROR: falta la cuenta privada. Ejecuta el instalador por SSH.\n");
    exit(1);
}
if (!is_readable($path)) {
    fwrite(STDERR, "ERROR: PHP no puede leer la cuenta privada. Revisa usuario y permisos.\n");
    exit(1);
}
try {
    $config = dnd_mini_admin_config();
} catch (Throwable $e) {
    $config = null;
}
if ($config === null || !preg_match('/\A[a-zA-Z0-9._-]{3,40}\z/', $config['persona'])
    || password_get_info($config['hash'])['algo'] === null) {
    fwrite(STDERR, "ERROR: el formato de la cuenta no es válido.\n");
    exit(1);
}

echo "OK: configuración fuera de la web, legible y con hash válido.\n";
if (($argv[1] ?? '') !== '--verify') {
    echo "Para verificar Persona y Llave sin revelarlas, añade --verify.\n";
    exit(0);
}

$mode = @shell_exec('stty -g 2>/dev/null');
if (!is_string($mode) || trim($mode) === '') {
    fwrite(STDERR, "ERROR: el modo verificación necesita una terminal interactiva.\n");
    exit(1);
}
echo "Persona: ";
$persona = trim((string)fgets(STDIN));
echo "Llave (oculta): ";
@system('stty -echo');
try {
    $llave = rtrim((string)fgets(STDIN), "\r\n");
} finally {
    @system('stty ' . escapeshellarg(trim($mode)));
    echo "\n";
}
$ok = hash_equals($config['persona'], $persona) && password_verify($llave, $config['hash']);
unset($llave);
if (!$ok) {
    fwrite(STDERR, "ERROR: la Persona y/o la Llave introducidas no coinciden con la cuenta guardada.\n");
    exit(1);
}
echo "OK: la Persona y la Llave coinciden. Si el navegador falla, revisar sesión/cookies y mensaje exacto.\n";
