<?php
/**
 * Regresión PHP 8: las secciones públicas distinguen catálogo y ficha.
 * Ejecuta copias intactas de los controladores con sus includes secundarios
 * sustituidos por stubs en un directorio temporal. Sin BD ni configuración.
 */
declare(strict_types=1);

final class FakeMysqlResult {
    public int $offset = 0;
    public function __construct(public array $rows) {}
}

$GLOBALS['sqlQueries'] = [];
$GLOBALS['fixtureId'] = 7;
$GLOBALS['fixtureTable'] = '';
$GLOBALS['fixtureRecord'] = [];

function mysql_query(string $sql, $link = null): FakeMysqlResult {
    $GLOBALS['sqlQueries'][] = $sql;
    if (
        preg_match('/\\bWHERE id = ([0-9]+) LIMIT 1$/', $sql, $match)
        && str_contains($sql, 'FROM ' . $GLOBALS['fixtureTable'] . ' ')
        && (int)$match[1] === $GLOBALS['fixtureId']
    ) {
        return new FakeMysqlResult([$GLOBALS['fixtureRecord']]);
    }
    return new FakeMysqlResult([]);
}

function mysql_num_rows(FakeMysqlResult $result): int {
    return count($result->rows);
}

function mysql_fetch_array(FakeMysqlResult $result): array|false {
    return $result->rows[$result->offset++] ?? false;
}

function ensure(bool $condition, string $message): void {
    if (!$condition) {
        throw new RuntimeException('FALLO: ' . $message);
    }
    echo "OK: $message\n";
}

$root = dirname(__DIR__);
$cases = [
    'location' => [
        'table' => 'dnd_map_locations',
        'section' => 'locations',
        'heading' => 'Lugares de Ylat',
        'listFields' => 'class, kingdom, type, uploader',
        'missing' => 'No se ha encontrado la localización solicitada.',
        'record' => [
            'id' => 7, 'url' => 'test', 'name' => 'Localización de prueba',
            'class' => '', 'kingdom' => 'Shadaleen', 'type' => 'Bosque',
            'lat' => '', 'lng' => '', 'music' => '', 'infotext' => 'Un bosque',
            'uploader' => '',
        ],
    ],
    'action' => [
        'table' => 'dnd_actions',
        'section' => 'actions',
        'heading' => 'Lista de acciones',
        'listFields' => 'type, origin',
        'missing' => 'No se ha encontrado la acción solicitada.',
        'record' => [
            'id' => 7, 'name' => 'Acción de prueba',
            'skill' => '', 'type' => 'General', 'flavortext' => '',
            'infotext' => 'Efecto de prueba',
        ],
    ],
    'book' => [
        'table' => 'dnd_bestiary',
        'section' => 'bestiary',
        'heading' => 'Bestiario',
        'listFields' => 'skill, origin',
        'missing' => 'No se ha encontrado la familia de monstruos solicitada.',
        'record' => [
            'id' => 7, 'name' => 'Familia de prueba',
            'skill' => '', 'infotext' => 'Monstruos de prueba',
            'knowtext' => '',
        ],
    ],
];

$temp = sys_get_temp_dir() . '/ad-infinitum-sections-' . bin2hex(random_bytes(6));
if (!mkdir($temp, 0700)) {
    throw new RuntimeException('No se ha podido preparar la prueba');
}
$previousDirectory = getcwd();

function renderSection(string $name, array $spec, mixed $pageValue, string $type = ''): array {
    global $temp;
    $GLOBALS['sqlQueries'] = [];
    $GLOBALS['fixtureTable'] = $spec['table'];
    $GLOBALS['fixtureRecord'] = $spec['record'];

    $page = $pageValue;
    $pageField = 'id';
    $section = $spec['section'];
    $typItem = $type;
    $link = null;
    $phraseNoAuth = '[NO AUTORIZADO]';
    $originCanon = 1;
    $dydBasicFields = 'id, url, name';

    // Configuración mínima del controlador, no de la aplicación completa.
    $dydTableMap = 'dnd_map_locations';
    $dydMapFields = 'class, kingdom, type, uploader';
    $dydSectionMap = ['locations'];
    $dydTableActions = 'dnd_actions';
    $dydActionsFields = 'type, origin';
    $dydSectionActions = ['actions'];
    $dydTableBestiary = 'dnd_bestiary';
    $dydBestiaryFields = 'skill, origin';
    $dydSectionBestiary = ['bestiary'];
    $dydTableCreatures = 'dnd_creatures';
    $dydCreaturesFields = 'type, role, level';
    $dydSectionCreatures = ['creatures'];
    $dydTableEncounter = 'dnd_encounters';
    $dydEncounterFields = 'level';
    $dydSectionEncounter = ['encounters'];
    $dydTableAdventures = 'dnd_adventures';
    $dydAdventuresFields = 'type';
    $dydSectionAdventures = ['adventures'];
    $dydTableTimeline = 'dnd_timeline';
    $dydTimelineFields = 'type';
    $dydSectionTimeline = ['timeline'];
    $fieldsOST = 'name, yt_link';
    $tableOST = 'dnd_soundtrack';

    ob_start();
    try {
        include $temp . '/' . $name . '.php';
        $html = ob_get_clean();
    } catch (Throwable $error) {
        ob_end_clean();
        throw $error;
    }
    return [$html, $GLOBALS['sqlQueries'], $dataSearchTerms ?? null];
}

try {
    foreach (array_keys($cases) as $name) {
        $source = $root . '/content/sections/' . $name . '.php';
        ensure(is_file($source), 'Existe el controlador de ' . $name);
        copy($source, $temp . '/' . $name . '.php');
    }
    file_put_contents($temp . '/contents_list.php', '<?php echo "[LISTADO-EJECUTADO]";');
    file_put_contents($temp . '/contents_tabs.php', '<?php echo "[PESTANAS-EJECUTADAS]";');
    file_put_contents($temp . '/content_origin.php', '<?php $originCanon = 1;');
    file_put_contents($temp . '/book_getmonsters.php', '<?php $famHasMonsters = false;');
    chdir($temp);

    foreach ($cases as $name => $spec) {
        [$html, $queries, $sql] = renderSection($name, $spec, '');
        ensure(str_contains($html, $spec['heading']) && str_contains($html, '[LISTADO-EJECUTADO]'),
            "$name: sin ID se muestra el listado, no la ficha 0");
        ensure($queries === [], "$name: el catálogo no busca una ficha con ID vacío");
        ensure(str_contains((string)$sql, 'FROM ' . $spec['table']), "$name: conserva la consulta de listado");

        [$html, $queries] = renderSection($name, $spec, '7');
        ensure(str_contains($html, '<h2>' . $spec['record']['name'] . '</h2>'),
            "$name: un ID existente muestra la ficha correcta");
        ensure(count($queries) >= 1 && str_contains($queries[0], 'FROM ' . $spec['table'] . ' WHERE id = 7 LIMIT 1'),
            "$name: consulta la ficha con ID entero, sin interpolación");

        [$html, $queries] = renderSection($name, $spec, '987654');
        ensure(str_contains($html, $spec['missing']) && !str_contains($html, '[LISTADO-EJECUTADO]'),
            "$name: un ID inexistente no muestra ficha ni listado engañoso");
        ensure(count($queries) === 1 && str_contains($queries[0], 'WHERE id = 987654 LIMIT 1'),
            "$name: el ID inexistente se consulta de forma segura");

        foreach (['0', '7 OR 1=1', '-7', '7.5', '999999999999999999999999999'] as $invalid) {
            [$html, $queries] = renderSection($name, $spec, $invalid);
            ensure(str_contains($html, $spec['missing']) && $queries === [],
                "$name: identificador inválido " . $invalid . " sin consulta SQL");
        }
        [$html, $queries] = renderSection($name, $spec, ['7']);
        ensure(str_contains($html, $spec['missing']) && $queries === [],
            "$name: page[] tampoco puede llegar a SQL");
    }
    [$html, $queries, $sql] = renderSection('location', $cases['location'], '', 'shadaleen');
    ensure(str_contains($html, 'Lugares de Shadaleen')
        && str_contains((string)$sql, "WHERE kingdom LIKE 'Shadaleen'")
        && $queries === [], 'Lugares: el listado territorial conserva el filtro por tipo');

    // El renderer compartido conserva su estado vacío; aquí solo se prueba
    // que cada controlador llega a él, independientemente de sus filas.
    $listSource = file_get_contents($root . '/content/sections/contents_list.php');
    ensure(str_contains($listSource, 'No hay ningún dato asociado.'),
        'El listado histórico conserva el mensaje para tablas vacías');
    echo "Regresión de rutas públicas superada.\n";
} finally {
    chdir($previousDirectory);
    foreach (glob($temp . '/*') ?: [] as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    rmdir($temp);
}
