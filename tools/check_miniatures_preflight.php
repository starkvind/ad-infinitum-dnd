<?php
/**
 * Preflight local y de solo lectura para futuras altas de Miniaturas.
 *
 * Ejecutar por SSH desde la raíz del repositorio:
 *     php tools/check_miniatures_preflight.php
 *
 * No imprime secretos, credenciales, filas individuales ni SQL del usuario.
 * Este fichero no es un endpoint web.
 */
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$adZone = 'dnd';
$_SERVER['HTTP_HOST'] = $_SERVER['HTTP_HOST'] ?? 'localhost';
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/dnd/miniatures/';
mysqli_report(MYSQLI_REPORT_OFF);

function preflight_fail(string $message): never
{
    fwrite(STDERR, "ERROR: {$message}\n");
    exit(1);
}

try {
    ob_start();
    require_once __DIR__ . '/../content/rosetta.php';
    ob_end_clean();
} catch (Throwable $e) {
    if (ob_get_level() > 0) {
        ob_end_clean();
    }
    preflight_fail('No se ha podido cargar la conexión existente. Revisa la configuración local.');
}

if (!isset($link) || !($link instanceof mysqli) || !isset($bdd)) {
    preflight_fail('Conexión de MySQL no disponible.');
}

if (!mysqli_select_db($link, (string) $bdd)) {
    preflight_fail('No se puede seleccionar la base configurada.');
}

$columnResult = @mysqli_query($link, 'SHOW COLUMNS FROM `dnd_miniatures`');
if (!($columnResult instanceof mysqli_result)) {
    preflight_fail('No se puede leer el esquema de dnd_miniatures.');
}

$columns = [];
while ($row = mysqli_fetch_assoc($columnResult)) {
    $columns[(string) $row['Field']] = $row;
}
mysqli_free_result($columnResult);

$required = [
    'id', 'url', 'id_mini', 'name', 'price',
    'collection', 'picture', 'infotext', 'avatar', 'date',
];
$missing = array_values(array_diff($required, array_keys($columns)));

$stats = @mysqli_query(
    $link,
    'SELECT COUNT(*) AS total, COALESCE(MAX(`id`), 0) AS last_id FROM `dnd_miniatures`'
);
if (!($stats instanceof mysqli_result)) {
    preflight_fail('No se puede consultar el recuento de miniaturas.');
}
$counts = mysqli_fetch_assoc($stats);
mysqli_free_result($stats);

$directory = __DIR__ . '/../media/figurine';

echo "PREFLIGHT DE MINIATURAS (solo lectura)\n";
echo "Tabla: dnd_miniatures\n";
echo 'Filas: ' . (int) ($counts['total'] ?? 0) . "\n";
echo 'Mayor ID: ' . (int) ($counts['last_id'] ?? 0) . "\n";
echo 'Columnas esperadas: ' . (count($missing) === 0 ? 'OK' : 'INCOMPLETAS') . "\n";

$id = $columns['id'] ?? null;
echo 'id AUTO_INCREMENT: ' . (
    $id && str_contains(strtolower((string)($id['Extra'] ?? '')), 'auto_increment')
        ? 'Sí'
        : 'No'
) . "\n";
echo 'id KEY: ' . ($id['Key'] ?? 'ausente') . "\n";

echo 'Directorio de imágenes: ' . (is_dir($directory) ? 'EXISTE' : 'FALTA') . "\n";
echo 'Escritura de imágenes desde este usuario SSH: ' . (
    is_dir($directory) && is_writable($directory) ? 'Sí' : 'No'
) . "\n";
echo 'Columnas ausentes: ' . ($missing ? implode(', ', $missing) : 'ninguna') . "\n";
echo "No se ha escrito ni modificado ningún registro.\n";

mysqli_close($link);
if ($missing || !is_dir($directory)) {
    exit(1);
}
