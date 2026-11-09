<?php
/**
 * PHP 8 regression: the shared list renders an empty catalog and handles a SQL
 * failure without throwing or leaking SQL. The DB is fully simulated.
 */
declare(strict_types=1);

final class EmptyListResult {
    public function __construct(public array $rows) {}
}
$GLOBALS['listTestMode'] = 'empty';
$GLOBALS['listQueries'] = [];
function mysql_query($sql, $link = null): EmptyListResult|false {
    $GLOBALS['listQueries'][] = $sql;
    return $GLOBALS['listTestMode'] === 'failure' ? false : new EmptyListResult([]);
}
function mysql_num_rows($result): int {
    if (!($result instanceof EmptyListResult)) {
        throw new RuntimeException('Unexpected SQL result');
    }
    return count($result->rows);
}
function mysql_fetch_array($result, $mode = 0): array|false {
    return false;
}

function renderSharedList(string $mode): string {
    $GLOBALS['listTestMode'] = $mode;
    $GLOBALS['listQueries'] = [];
    $link = null;
    $page = '';
    $dataSearchTerms = 'SELECT id, name FROM fake_catalog';
    $dataSection = '';
    $tableFromBiblio = false;
    ob_start();
    try {
        include dirname(__DIR__) . '/content/sections/contents_list.php';
        return ob_get_clean();
    } catch (Throwable $exception) {
        ob_end_clean();
        throw $exception;
    }
}

$empty = renderSharedList('empty');
if (!str_contains($empty, 'No hay ningún dato asociado.') ||
    str_contains($empty, 'No se ha podido cargar el listado.') ||
    count($GLOBALS['listQueries']) !== 1) {
    throw new RuntimeException('Empty result did not render the expected catalog state.');
}
echo "OK: empty query result renders normal empty catalog.\n";

$failed = renderSharedList('failure');
if (!str_contains($failed, 'No se ha podido cargar el listado.') ||
    str_contains($failed, 'SELECT id, name') ||
    str_contains($failed, 'No hay ningún dato asociado.') ||
    count($GLOBALS['listQueries']) !== 1) {
    throw new RuntimeException('SQL failure did not render a sanitized error state.');
}
echo "OK: simulated SQL failure shows a safe message without halting the page.\n";
