<?php
/**
 * Prueba aislada de la pantalla de Miniaturas con PHP 8.x.
 * Ejecuta el archivo real, pero sustituye las consultas SQL y dos includes
 * por stubs locales. Nunca abre conexión MySQL ni lee la configuración.
 */
declare(strict_types=1);

$miniatures = realpath(__DIR__ . '/../content/sections/miniatures.php');
if (!$miniatures) {
    fwrite(STDERR, "No se encuentra miniatures.php\n");
    exit(1);
}
$workingDirectory = getcwd();
$tempDirectory = sys_get_temp_dir() . '/ad-infinitum-miniatures-' . bin2hex(random_bytes(8));
if (!mkdir($tempDirectory, 0700)) {
    throw new RuntimeException('No se puede preparar la prueba');
}
file_put_contents($tempDirectory . '/contents_list.php', '<?php echo "[CATALOGO-RENDERIZADO]";');
file_put_contents($tempDirectory . '/contents_tabs.php', '<?php echo "[FICHA-PESTANAS]";');

$GLOBALS['miniatures_queries'] = [];
$GLOBALS['miniatures_rows'] = 0;
$GLOBALS['miniatures_data'] = [];

function mysql_query($query, $link = null) {
    $GLOBALS['miniatures_queries'][] = $query;
    return true;
}
function mysql_num_rows($result): int {
    return $GLOBALS['miniatures_rows'];
}
function mysql_fetch_array($result) {
    return $GLOBALS['miniatures_data'];
}

function test_miniatures_screen(string $requestedPage, int $rowCount = 0, array $record = []): array {
    global $miniatures;
    $GLOBALS['miniatures_queries'] = [];
    $GLOBALS['miniatures_rows'] = $rowCount;
    $GLOBALS['miniatures_data'] = $record;

    $page = $requestedPage;
    $link = null;
    $dydTableMiniatures = 'dnd_miniatures';
    $dydBasicFields = 'id, url, name';
    $dydMiniaturesFields = 'id_mini, price, picture, collection, avatar';
    $dydSectionMiniatures = ['miniatures'];
    $dydMiniatureImgPath = '/dnd/media/figurine/';
    $dydMiniatureImgExt = '.jpg';
    ob_start();
    try {
        include $miniatures;
        $html = ob_get_clean();
    } catch (Throwable $error) {
        ob_end_clean();
        throw $error;
    }
    return [$html, $GLOBALS['miniatures_queries'], $dataSearchTerms ?? null];
}

function expect_true(bool $condition, string $message): void {
    if (!$condition) {
        throw new RuntimeException('FALLO: ' . $message);
    }
    echo "OK: $message\n";
}

try {
    // Los includes antiguos son relativos al directorio de ejecución.
    chdir($tempDirectory);

    [$html, $queries, $listSql] = test_miniatures_screen('');
    expect_true(str_contains($html, '[CATALOGO-RENDERIZADO]'), 'URL /miniatures/ sin ID muestra el catálogo');
    expect_true(str_contains($html, '<h3>Miniaturas</h3>'), 'Catálogo conserva su título');
    expect_true(count($queries) === 0, 'El listado no ejecuta WHERE id LIKE vacío');
    expect_true(str_contains((string)$listSql, 'ORDER BY name'), 'El catálogo se ordena por nombre');

    [$html, $queries] = test_miniatures_screen("' OR 1=1--");
    expect_true(str_contains($html, '[CATALOGO-RENDERIZADO]') && !$queries, 'Un ID inválido no se concatena al SQL');

    [$html, $queries] = test_miniatures_screen('1', 1, [
        'id_mini' => 77009,
        'name' => 'Werewolf <script>alert(1)</script>',
        'price' => 195,
        'collection' => 'Dark Heaven: Bones',
        'picture' => 'werewolf',
        'infotext' => 'Texto de ficha',
        'avatar' => 'Personaje',
    ]);
    expect_true(str_contains($html, '[FICHA-PESTANAS]'), 'La ficha existente se renderiza');
    expect_true(str_contains($html, '&lt;script&gt;') && !str_contains($html, '<script>'), 'El título de la ficha está escapado');
    expect_true(count($queries) === 1 && str_contains($queries[0], 'WHERE id = 1 LIMIT 1'), 'La búsqueda solo usa un ID entero');
    expect_true(str_contains($html, '1,95'), 'El precio se presenta en euros');
} finally {
    chdir($workingDirectory);
    @unlink($tempDirectory . '/contents_list.php');
    @unlink($tempDirectory . '/contents_tabs.php');
    @rmdir($tempDirectory);
}
