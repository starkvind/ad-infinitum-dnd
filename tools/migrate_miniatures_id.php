<?php
/**
 * Migración puntual dnd_miniatures.id: backup privado + PRIMARY KEY AUTO_INCREMENT.
 * php tools/migrate_miniatures_id.php            -> preflight (solo lectura)
 * sudo php tools/migrate_miniatures_id.php --apply -> backup y ALTER
 */
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }

function mini_migrate_fail(string $text): never
{
    fwrite(STDERR, "ERROR: {$text}\n");
    exit(1);
}

function mini_migrate_snapshot(mysqli $db): array
{
    $expected = ['id','url','id_mini','name','price','collection','picture','infotext','avatar','date'];
    $colRes = @mysqli_query($db, 'SHOW FULL COLUMNS FROM dnd_miniatures');
    if (!$colRes instanceof mysqli_result) { throw new RuntimeException('No se pudo leer la estructura'); }
    $cols = [];
    while ($col = mysqli_fetch_assoc($colRes)) { $cols[$col['Field']] = $col; }
    mysqli_free_result($colRes);
    if (array_keys($cols) !== $expected
        || !preg_match('/^int(?:\(\d+\))?$/i', (string)$cols['id']['Type'])
        || $cols['id']['Null'] !== 'NO') {
        throw new RuntimeException('Estructura distinta de la prevista; no modificar');
    }
    $ddlRes = @mysqli_query($db, 'SHOW CREATE TABLE dnd_miniatures');
    if (!$ddlRes instanceof mysqli_result) { throw new RuntimeException('No se pudo leer el DDL'); }
    $def = mysqli_fetch_assoc($ddlRes);
    mysqli_free_result($ddlRes);
    $ddl = (string)($def['Create Table'] ?? '');
    if (!preg_match('/ENGINE=InnoDB\b/i', $ddl)) {
        throw new RuntimeException('El motor no es InnoDB; detener');
    }
    $select = @mysqli_query($db, 'SELECT * FROM dnd_miniatures ORDER BY id');
    if (!$select instanceof mysqli_result) { throw new RuntimeException('No se pudo leer la tabla'); }
    $data = [];
    $ids = [];
    $maximum = 0;
    while ($row = mysqli_fetch_assoc($select)) {
        $id = (string)$row['id'];
        if (!preg_match('/^[1-9][0-9]*$/', $id) || (float)$id > 2147483647 || isset($ids[$id])) {
            mysqli_free_result($select);
            throw new RuntimeException('IDs duplicados o inválidos; detener');
        }
        $ids[$id] = true;
        $maximum = max($maximum, (int)$id);
        $data[] = $row;
    }
    mysqli_free_result($select);
    return [
        'fields' => $expected, 'cols' => $cols, 'ddl' => $ddl,
        'rows' => $data, 'count' => count($data), 'max' => $maximum,
        'hash' => hash('sha256', serialize($data)),
        'ready' => (($cols['id']['Key'] ?? '') === 'PRI'
            && str_contains(strtolower((string)($cols['id']['Extra'] ?? '')), 'auto_increment')),
    ];
}

function mini_migrate_dump(mysqli $db, array $before): string
{
    $charset = mysqli_character_set_name($db);
    if (!preg_match('/^[A-Za-z0-9_]+$/', $charset)) { throw new RuntimeException('Charset inválido'); }
    $q = chr(96);
    $fields = implode(', ', array_map(static fn(string $f): string => $q . $f . $q, $before['fields']));
    $sql = "-- Copia PRIVADA de dnd_miniatures. Restaurar solo en base aislada.\n"
        . '-- Filas: ' . $before['count'] . '; huella: ' . $before['hash'] . "\n"
        . 'SET NAMES ' . $charset . ";\n"
        . "SET SESSION sql_mode = 'NO_AUTO_VALUE_ON_ZERO';\n"
        . $before['ddl'] . ";\n";
    foreach ($before['rows'] as $row) {
        $literals = [];
        foreach ($before['fields'] as $field) {
            $value = $row[$field];
            $literals[] = $value === null ? 'NULL' : "'" . mysqli_real_escape_string($db, $value) . "'";
        }
        $sql .= 'INSERT INTO ' . $q . 'dnd_miniatures' . $q . ' (' . $fields . ') VALUES ('
            . implode(', ', $literals) . ");\n";
    }
    return $sql;
}

function mini_migrate_backup(string $sql): string
{
    $dir = dirname(__DIR__, 3) . '/dnd-backups';
    if (!is_dir($dir) && !@mkdir($dir, 0700, true) && !is_dir($dir)) {
        throw new RuntimeException('No se pudo crear directorio de respaldo');
    }
    if (is_link($dir)) { throw new RuntimeException('Directorio de backup no debe ser enlace'); }
    @chmod($dir, 0700);
    $path = $dir . '/miniatures-before-id-' . date('Ymd-His')
        . '-' . bin2hex(random_bytes(4)) . '.sql';
    $mask = umask(0077);
    try { $written = @file_put_contents($path, $sql, LOCK_EX); }
    finally { umask($mask); }
    if ($written !== strlen($sql) || !@chmod($path, 0600) || @file_get_contents($path) !== $sql) {
        @unlink($path);
        throw new RuntimeException('La copia no pudo escribirse o verificarse');
    }
    return $path;
}

function mini_migrate_main(array $args): int
{
    if (count($args) > 1 || (isset($args[0]) && $args[0] !== '--apply')) {
        fwrite(STDERR, "Uso: php tools/migrate_miniatures_id.php [--apply]\n");
        return 2;
    }
    $apply = ($args[0] ?? '') === '--apply';
    $adZone = 'dnd';
    $_SERVER['HTTP_HOST'] = 'localhost';
    $_SERVER['REQUEST_URI'] = '/dnd/miniatures/';
    mysqli_report(MYSQLI_REPORT_OFF);
    try {
        ob_start();
        require __DIR__ . '/../content/rosetta.php';
        ob_end_clean();
        if (!isset($link, $bdd) || !($link instanceof mysqli)
            || !@mysqli_select_db($link, (string)$bdd)) {
            throw new RuntimeException('No se pudo establecer la conexión');
        }
        $before = mini_migrate_snapshot($link);
    } catch (Throwable $error) {
        if (ob_get_level() > 0) { ob_end_clean(); }
        mini_migrate_fail('Preflight: ' . $error->getMessage() . '. No se ha escrito nada.');
    }
    echo "dnd_miniatures: {$before['count']} filas; ID máximo {$before['max']}.\n";
    if ($before['ready']) { echo "OK: ya tiene PRIMARY KEY AUTO_INCREMENT.\n"; return 0; }
    if (($before['cols']['id']['Key'] ?? '') !== ''
        || str_contains(strtolower((string)($before['cols']['id']['Extra'] ?? '')), 'auto_increment')) {
        mini_migrate_fail('ID con restricciones inesperadas; no modificar.');
    }
    if (!$apply) {
        echo "PRECHECK OK (solo lectura). Ejecuta con --apply para guardar backup y alterar exclusivamente el ID.\n";
        return 0;
    }
    if (function_exists('posix_geteuid') && posix_geteuid() !== 0) {
        mini_migrate_fail('Ejecuta --apply con sudo para proteger el respaldo.');
    }
    try {
        $backup = mini_migrate_dump($link, $before);
        $path = mini_migrate_backup($backup);
    } catch (Throwable $error) {
        mini_migrate_fail('No se verificó el backup: ' . $error->getMessage() . '. ALTER NO ejecutado.');
    }
    echo "BACKUP VERIFICADO: {$path}\n";
    echo 'SHA256: ' . hash('sha256', $backup) . "\n";
    try {
        $immediatelyBefore = mini_migrate_snapshot($link);
        if ($immediatelyBefore['hash'] !== $before['hash']
            || $immediatelyBefore['ddl'] !== $before['ddl']) {
            throw new RuntimeException('La tabla cambió mientras se respaldaba');
        }
        $modeRes = @mysqli_query($link, 'SELECT @@SESSION.sql_mode AS mode');
        if (!$modeRes instanceof mysqli_result) { throw new RuntimeException('Sin SQL_MODE'); }
        $modeRow = mysqli_fetch_assoc($modeRes);
        mysqli_free_result($modeRes);
        $originalMode = (string)($modeRow['mode'] ?? '');
        if (!@mysqli_query($link, "SET SESSION sql_mode = 'NO_AUTO_VALUE_ON_ZERO'")) {
            throw new RuntimeException('No se pudo preparar el modo SQL para fechas 0000-00-00');
        }
        try {
            $ok = @mysqli_query($link, 'ALTER TABLE dnd_miniatures MODIFY COLUMN id INT NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (id)');
            if (!$ok) {
                // Leer el diagnóstico antes de cualquier otra consulta: otra sentencia lo sobrescribe.
                $alterErrno = mysqli_errno($link);
                $alterSqlstate = mysqli_sqlstate($link);
                $alterError = mysqli_error($link);
            }
        } finally {
            @mysqli_query($link, "SET SESSION sql_mode = '" . mysqli_real_escape_string($link, $originalMode) . "'");
        }
        if (!$ok) {
            throw new RuntimeException(sprintf(
                'MariaDB rechazó ALTER TABLE: errno=%d; sqlstate=%s; error=%s',
                $alterErrno,
                $alterSqlstate,
                $alterError
            ));
        }
        $after = mini_migrate_snapshot($link);
        if (!$after['ready'] || $after['hash'] !== $before['hash']
            || $after['count'] !== $before['count'] || $after['max'] !== $before['max']) {
            throw new RuntimeException('La verificación posterior no coincide');
        }
        echo "OK: clave primaria y AUTO_INCREMENT activados.\n";
        echo "OK: {$after['count']} filas intactas; IDs anteriores conservados.\n";
        echo 'Próximo ID automático: al menos ' . ($after['max'] + 1) . ".\n";
        return 0;
    } catch (Throwable $error) {
        mini_migrate_fail($error->getMessage() . '. Guarda el backup en ' . $path
            . ' y NO repitas ni restaures automáticamente; revisar antes.');
    }
}

if (realpath((string)($_SERVER['SCRIPT_FILENAME'] ?? '')) === __FILE__) {
    exit(mini_migrate_main(array_slice($argv, 1)));
}
