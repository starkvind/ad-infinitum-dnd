<?php
/**
 * Read-only compatibility contract for field access in legacy section controllers.
 * Checks PHP's $dataResult['column'] access against headers of the private 2026-11-08 CSV export.
 * Only column names are stored in this repository; no user records are distributed.
 */
declare(strict_types=1);

$root = dirname(__DIR__);
$schema = [];
foreach (glob($root . '/docs/db-schema-csv-20261108-*.json') ?: [] as $file) {
    $parsed = json_decode((string) file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
    foreach ($parsed['tables'] as $table => $columns) {
        $schema[$table] = $columns;
    }
}

$files = [
    'article' => 'dnd_articles',
    'background' => 'dnd_character_backgrounds',
    'builds' => 'dnd_class_builds',
    'race' => 'dnd_races',
    'class' => 'dnd_classes',
    'ritual' => 'dnd_rituals',
    'player' => 'dnd_player_characters',
    'npc' => 'dnd_npcs',
    'parties' => 'dnd_organizations',
    'timeline' => 'dnd_timeline',
    'ailment_card' => 'dnd_ailments',
    'enchantment_card' => 'dnd_magic_enchantments',
    'encounter_card' => 'dnd_battle_encounters',
    'enemy_card' => 'dnd_creatures',
    'feat_card' => 'dnd_feats',
    'item_card' => 'dnd_magic_items',
    'power_card' => 'dnd_powers',
    'thing_card' => 'dnd_items',
    'trait_card' => 'dnd_character_traits',
    'vehicle_card' => 'dnd_vehicles',
    'adventure' => 'dnd_adventures',
    'location' => 'dnd_map_locations',
    'action' => 'dnd_actions',
    'book' => 'dnd_bestiary',
    'shop' => 'dnd_shops',
    'news' => 'dnd_updates',
    'miniatures' => 'dnd_miniatures',
    'bibliography' => 'dnd_bibliography',
    'soundtrack' => 'main_soundtrack',
    'levelchart' => 'dnd_level_chart',
];

$errors = [];
$accesses = 0;
$optional = 0;
foreach ($files as $name => $table) {
    $path = $root . '/content/sections/' . $name . '.php';
    if (!is_file($path) || !isset($schema[$table])) {
        $errors[] = 'Missing source or table for ' . $name;
        continue;
    }
    $php = (string) file_get_contents($path);
    // Recognize literal string keys. Accesses to rows returned by other queries may
    // need an explicit mapping instead of being assumed to use the main table.
    preg_match_all('~\$dataResult\[\s*["\x27]([a-zA-Z_][a-zA-Z_0-9]*)["\x27]\s*\](\s*\?\?)?~', $php, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        ++$accesses;
        $field = $match[1];
        if (in_array($field, $schema[$table], true)) {
            continue;
        }
        if (!empty($match[2])) {
            ++$optional; // Explicitly optional fields are safe with PHP 8.
            continue;
        }
        $errors[] = $name . '.php accesses absent ' . $table . '.' . $field;
    }
}

if ($errors) {
    fwrite(STDERR, implode("\n", $errors) . "\n");
    exit(1);
}
echo 'OK: ' . count($files) . " section/card files, $accesses field reads, $optional explicitly optional historical fields.\n";
echo "Static contract only; it does not verify SQL, database contents or the live schema.\n";
