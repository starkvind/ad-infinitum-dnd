<?php
/**
 * Read-only contract check for historical Ad Infinitum CSV headers.
 * No CSV rows, credentials, database connection or private data are required.
 */
declare(strict_types=1);

$root = dirname(__DIR__);
$files = glob($root . '/docs/db-schema-csv-20261108-*.json') ?: [];
sort($files);
$errors = [];
$schema = [];

if (count($files) !== 3) {
    $errors[] = 'Expected three header-only schema snapshots.';
}
foreach ($files as $file) {
    $data = json_decode((string) file_get_contents($file), true);
    if (!is_array($data) || !isset($data['tables']) || !is_array($data['tables'])) {
        $errors[] = 'Invalid schema snapshot: ' . basename($file);
        continue;
    }
    foreach ($data['tables'] as $table => $columns) {
        if (!preg_match('/^(?:dnd|main)_[a-z0-9_]+$/', (string) $table) ||
            !is_array($columns) || count($columns) === 0 ||
            count($columns) !== count(array_unique($columns))) {
            $errors[] = 'Invalid table or duplicate column: ' . $table;
            continue;
        }
        if (isset($schema[$table])) {
            $errors[] = 'Duplicate table: ' . $table;
        }
        $schema[$table] = $columns;
    }
}
if (count($schema) !== 45) {
    $errors[] = 'Expected 45 historical CSV tables, found ' . count($schema);
}

$source = file_get_contents($root . '/content/stone.php');
if ($source === false) {
    fwrite(STDERR, "Cannot read content/stone.php\n");
    exit(1);
}
preg_match_all('/\$(\w+)\s*=\s*"(dnd_[A-Za-z0-9_]+|main_[A-Za-z0-9_]+)"\s*;/', $source, $tableMatches, PREG_SET_ORDER);
$variables = [];
foreach ($tableMatches as $match) {
    $variables[$match[1]] = $match[2];
}

// The export intentionally excludes private legacy accounts and visitor records.
$excludedSensitiveTables = ['main_users', 'main_visitors'];
foreach ($variables as $tableName) {
    if (!isset($schema[$tableName]) && !in_array($tableName, $excludedSensitiveTables, true)) {
        $errors[] = 'Missing exported table: ' . $tableName;
    }
}

preg_match_all('/\$(dyd[A-Za-z0-9_]+Fields|fieldsOST)\s*=\s*"([^"]*)"\s*;/', $source, $fieldMatches, PREG_SET_ORDER);
$checked = 0;
foreach ($fieldMatches as $match) {
    $fieldVariable = $match[1];
    if ($fieldVariable === 'dydBasicFields') {
        continue; // Shared fields are not a single-table declaration.
    }
    $tableVariable = $fieldVariable === 'fieldsOST'
        ? 'tableOST'
        : 'dydTable' . substr($fieldVariable, 3, -strlen('Fields'));

    if (!isset($variables[$tableVariable])) {
        // e.g. a non-D&D section's field declarations.
        if (str_starts_with($fieldVariable, 'dyd')) {
            $errors[] = 'Unmapped field declaration: ' . $fieldVariable;
        }
        continue;
    }
    $table = $variables[$tableVariable];
    if (!isset($schema[$table])) {
        continue;
    }
    foreach (array_filter(array_map('trim', explode(',', $match[2]))) as $column) {
        ++$checked;
        if (!in_array($column, $schema[$table], true)) {
            $errors[] = 'Unknown column ' . $table . '.' . $column . ' referenced by $' . $fieldVariable;
        }
    }
}
if ($errors) {
    fwrite(STDERR, implode("\n", $errors) . "\n");
    exit(1);
}
$columns = array_sum(array_map('count', $schema));
echo "OK: " . count($schema) . " historical tables, $columns column headers, $checked configured list fields.\n";
echo "NOT CHECKED (not exported): main_users and main_visitors; no MariaDB runtime check performed.\n";
