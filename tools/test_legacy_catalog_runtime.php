<?php
/**
 * Runtime regression for ten legacy direct-detail controllers.
 * Empty SQL results must render the historical catalog, not dereference false.
 * All queries and nested includes are isolated; no credentials/DB required.
 */
declare(strict_types=1);

final class EmptyLegacyQuery {}
$GLOBALS['__testQueries'] = [];
function mysql_query(string $sql, $link = null): EmptyLegacyQuery {
    $GLOBALS['__testQueries'][] = $sql;
    return new EmptyLegacyQuery();
}
function mysql_num_rows(EmptyLegacyQuery $result): int { return 0; }
function mysql_fetch_array(EmptyLegacyQuery $result): false { return false; }

$cases = [
    'article' => ['dnd_articles', 'dydTableArticles', 'dydArticlesFields', 'dydSectionArticles', 'articles'],
    'background' => ['dnd_character_backgrounds', 'dydTableBackgrounds', 'dydBackgroundsFields', 'dydSectionBackgrounds', 'backgrounds'],
    'builds' => ['dnd_class_builds', 'dydTableBuilds', 'dydBuildsFields', 'dydSectionBuilds', 'builds'],
    'race' => ['dnd_races', 'dydTableRaces', 'dydRacesFields', 'dydSectionRaces', 'races'],
    'class' => ['dnd_classes', 'dydTableClasses', 'dydClassesFields', 'dydSectionClasses', 'classes'],
    'ritual' => ['dnd_rituals', 'dydTableRituals', 'dydRitualsFields', 'dydSectionRituals', 'rituals'],
    'player' => ['dnd_player_characters', 'dydTablePlayers', 'dydPlayersFields', 'dydSectionPlayers', 'players'],
    'npc' => ['dnd_npcs', 'dydTableNPC', 'dydNPCFields', 'dydSectionNPC', 'npcs'],
    'parties' => ['dnd_organizations', 'dydTableParties', 'dydPartiesFields', 'dydSectionParties', 'parties'],
    'timeline' => ['dnd_timeline', 'dydTableTimeline', 'dydTimelineFields', 'dydSectionTimeline', 'timeline'],
];
$root = dirname(__DIR__);
$temp = sys_get_temp_dir() . '/ad-infinitum-legacy-' . bin2hex(random_bytes(6));
if (!mkdir($temp, 0700)) {
    throw new RuntimeException('Could not create temporary folder');
}
$oldCwd = getcwd();

function renderLegacyCatalog(string $name, array $spec, string $id): array {
    global $temp;
    $page = $id;
    $typItem = '';
    $typSubType = '';
    $pageField = 'id';
    $originCanon = 1;
    $phraseNoAuth = '[NO_AUTH]';
    $locTab = '';
    $pageRoot = '/dnd/';
    $pageTitle2 = '';
    $noAbilityRaces = [];
    $noTraitRaces = [];
    $dydBasicFields = 'id, url, name';
    $link = null;
    $dataSearchTerms = '';
    $dataSection = null;
    $GLOBALS['__testQueries'] = [];
    $tableVariable = $spec[1];
    $fieldsVariable = $spec[2];
    $sectionVariable = $spec[3];
    $$tableVariable = $spec[0];
    $$fieldsVariable = 'origin';
    $$sectionVariable = [$spec[4]];
    ob_start();
    try {
        include $temp . '/' . $name . '.php';
        $html = ob_get_clean();
    } catch (Throwable $error) {
        ob_end_clean();
        throw $error;
    }
    return [$html, $dataSearchTerms, $GLOBALS['__testQueries']];
}
try {
    foreach ($cases as $name => $spec) {
        if (!copy($root . '/content/sections/' . $name . '.php', $temp . '/' . $name . '.php')) {
            throw new RuntimeException('Missing controller ' . $name);
        }
    }
    file_put_contents($temp . '/contents_list.php', '<?php echo "[CATALOG]";');
    file_put_contents($temp . '/contents_tabs.php', '<?php echo "[TABS]";');
    file_put_contents($temp . '/content_origin.php', '<?php $originCanon = 1;');
    chdir($temp);

    $count = 0;
    foreach ($cases as $name => $spec) {
        foreach (['', '9999999', '0', '-7', '7 OR 1=1'] as $id) {
            [$html, $sql, $queries] = renderLegacyCatalog($name, $spec, $id);
            if (!str_contains($html, '[CATALOG]')) {
                throw new RuntimeException($name . ': missing catalog for id ' . json_encode($id));
            }
            if (!str_contains($sql, 'FROM ' . $spec[0])) {
                throw new RuntimeException($name . ': wrong listing table');
            }
            $expectedQueries = $id === '9999999' ? 1 : 0;
            if (count($queries) !== $expectedQueries) {
                throw new RuntimeException($name . ': unexpected SQL lookup for ID ' . json_encode($id));
            }
            ++$count;
        }
    }
    echo "OK: $count blank/missing-page runtime cases across " . count($cases) . " legacy controllers.\n";
} finally {
    chdir($oldCwd);
    foreach (glob($temp . '/*') ?: [] as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    rmdir($temp);
}
