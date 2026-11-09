<?php
/**
 * Regression for catalog routes of the ten card-based sections.
 * Executes each historical controller unchanged, with only its includes stubbed.
 * Never connects to MariaDB or loads real application configuration.
 */
declare(strict_types=1);

$sections = [
    'enemy' => ['table' => 'dnd_creatures', 'tableVar' => 'dydTableCreatures', 'fieldsVar' => 'dydCreaturesFields', 'sectionVar' => 'dydSectionCreatures', 'section' => 'creatures'],
    'vehicle' => ['table' => 'dnd_vehicles', 'tableVar' => 'dydTableVehicles', 'fieldsVar' => 'dydVehiclesFields', 'sectionVar' => 'dydSectionVehicles', 'section' => 'vehicles'],
    'trait' => ['table' => 'dnd_character_traits', 'tableVar' => 'dydTableTraits', 'fieldsVar' => 'dydTraitsFields', 'sectionVar' => 'dydSectionTraits', 'section' => 'traits'],
    'thing' => ['table' => 'dnd_items', 'tableVar' => 'dydTableItems', 'fieldsVar' => 'dydItemsFields', 'sectionVar' => 'dydSectionItems', 'section' => 'items'],
    'power' => ['table' => 'dnd_powers', 'tableVar' => 'dydTablePowers', 'fieldsVar' => 'dydPowersFields', 'sectionVar' => 'dydSectionPowers', 'section' => 'powers'],
    'feat' => ['table' => 'dnd_feats', 'tableVar' => 'dydTableFeats', 'fieldsVar' => 'dydFeatsFields', 'sectionVar' => 'dydSectionFeats', 'section' => 'feats'],
    'item' => ['table' => 'dnd_magic_items', 'tableVar' => 'dydTableMagicItems', 'fieldsVar' => 'dydMagicItemsFields', 'sectionVar' => 'dydSectionMagicItems', 'section' => 'magicitems'],
    'enchantment' => ['table' => 'dnd_magic_enchantments', 'tableVar' => 'dydTableEnchants', 'fieldsVar' => 'dydEnchantsFields', 'sectionVar' => 'dydSectionEnchants', 'section' => 'enchantments'],
    'encounter' => ['table' => 'dnd_battle_encounters', 'tableVar' => 'dydTableEncounter', 'fieldsVar' => 'dydEncounterFields', 'sectionVar' => 'dydSectionEncounter', 'section' => 'encounters'],
    'ailment' => ['table' => 'dnd_ailments', 'tableVar' => 'dydTableAilments', 'fieldsVar' => 'dydAilmentsFields', 'sectionVar' => 'dydSectionAilments', 'section' => 'ailments'],
];

$root = dirname(__DIR__);
$temp = sys_get_temp_dir() . '/ad-infinitum-catalog-' . bin2hex(random_bytes(6));
if (!mkdir($temp, 0700)) {
    throw new RuntimeException('Cannot create temporary test folder');
}
$oldCwd = getcwd();

function catalogTestRender(string $name, array $config, mixed $pageValue, string $type = ''): array
{
    global $temp;
    $page = $pageValue;
    $pageField = 'id';
    $typItem = $type;
    $typSubType = '';
    $locTab = '';
    $pageTitle2 = '';
    $powerBazaar = '';
    $userLevelCheck = 'AND visible <= 0';
    $dydBasicFields = 'id, url, name';
    $dataSelectSQL = '';
    $dataSearchSQL = '';
    $link = null;
    $section = $config['section'];
    ${$config['tableVar']} = $config['table'];
    ${$config['fieldsVar']} = 'origin';
    ${$config['sectionVar']} = [$config['section']];
    $dataSearchTerms = null;
    $dataSection = null;
    ob_start();
    try {
        include $temp . '/' . $name . '.php';
        $rendered = ob_get_clean();
    } catch (Throwable $error) {
        ob_end_clean();
        throw $error;
    }
    return [$rendered, $dataSearchTerms, $dataSection];
}

try {
    foreach ($sections as $name => $config) {
        $source = $root . '/content/sections/' . $name . '.php';
        if (!copy($source, $temp . '/' . $name . '.php')) {
            throw new RuntimeException('Could not copy ' . $name);
        }
    }
    file_put_contents($temp . '/contents_tabs.php', '<?php echo "[TABS]";');
    file_put_contents($temp . '/contents_list.php', '<?php echo "[CATALOG]";');
    chdir($temp);

    $checked = 0;
    foreach ($sections as $name => $config) {
        foreach (['', '0', '-7', '7 OR 1=1', ['7']] as $pageValue) {
            [$html, $query, $sectionName] = catalogTestRender($name, $config, $pageValue);
            if (!str_contains($html, '[CATALOG]')) {
                throw new RuntimeException("$name: catalog was not rendered with " . json_encode($pageValue));
            }
            if (!str_contains((string) $query, 'FROM ' . $config['table'])) {
                throw new RuntimeException("$name: wrong table with " . json_encode($pageValue));
            }
            if ($sectionName !== $config['section']) {
                throw new RuntimeException("$name: wrong section with " . json_encode($pageValue));
            }
            ++$checked;
        }
    }
    echo "OK: $checked catalog-route cases across " . count($sections) . " controllers, no database required.\n";
} finally {
    chdir($oldCwd);
    foreach (glob($temp . '/*') ?: [] as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    rmdir($temp);
}
