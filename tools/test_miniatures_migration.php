<?php
/** Pruebas estáticas y de carga (sin base real, ficheros ni SQL). */
declare(strict_types=1);
require_once __DIR__ . '/migrate_miniatures_id.php';
function mini_migration_ok(bool $ok, string $message): void
{
    if (!$ok) {
        throw new RuntimeException('FAIL: ' . $message);
    }
    echo "OK: {$message}\n";
}
mini_migration_ok(function_exists('mini_migrate_main'), 'Comando disponible');
mini_migration_ok(function_exists('mini_migrate_snapshot'), 'Validación previa disponible');
mini_migration_ok(function_exists('mini_migrate_dump'), 'Exportación SQL disponible');
mini_migration_ok(function_exists('mini_migrate_backup'), 'Respaldo privado disponible');
$src = file_get_contents(__DIR__ . '/migrate_miniatures_id.php');
mini_migration_ok(is_string($src), 'Script legible');
mini_migration_ok(!str_contains($src, 'DROP TABLE'), 'No elimina tablas');
mini_migration_ok(!str_contains($src, 'UPDATE dnd_miniatures'), 'No modifica filas individuales');
mini_migration_ok(str_contains($src, 'ADD PRIMARY KEY (id)'), 'Añade clave primaria únicamente al ID');
mini_migration_ok(str_contains($src, "SET SESSION sql_mode = 'NO_AUTO_VALUE_ON_ZERO'"), 'Compatibilidad con fechas históricas');
mini_migration_ok(str_contains($src, '$after['), 'Verificación de datos después de migrar');
mini_migration_ok(str_contains($src, 'dnd-backups'), 'Respaldo fuera del repositorio público');
