<?php
// ---------------------------------------------------------->
// Selecciones principales
$section    = $_GET["section"] ?? "";   // Cogemos la sección de la página
$page       = $_GET["page"] ?? "";      // Número de ID de la sección
$pageField  = "id";                     // Campo que vamos a buscar

// Si el usuario está logueado y estilo de menú es 2, incluimos extra
if (isset($_SESSION['player_name']) && $menuStyle == 2) { 
    include_once("main/main_active_player.php"); 
}

// ---------------------------------------------------------->
// Secciones individuales
$typItem    = $_GET["type"]    ?? "";   // Tipo de Objetos
$typSubType = $_GET["subtype"] ?? "";   // Subtipo del tema

// ---------------------------------------------------------->
$mainWork = FALSE; // <- Muy importante: evitar "Undefined variable"

if (!empty($section)) { 
    switch ($section) {
        // ---------------------------------------------------------->
        // Gestión de usuario
        case $sectionUser[0]: $mainWork = $sectionUser; break;
        case $sectionFavs[0]: $mainWork = $sectionFavs; break;
        case $sectionSearch[0]: $mainWork = $sectionSearch; break;
        case $sectionOST[0]: $mainWork = $sectionOST; break;

        // =====================>
        // DUNGEONS & DRAGONS
        // =====================>
        case $dydSectionUpdates[0]:      $mainWork = $dydSectionUpdates; break;
        case $dydSectionBibliography[0]: $mainWork = $dydSectionBibliography; break;
        case $dydSectionStatus[0]:       $mainWork = $dydSectionStatus; break;
        case $dydSectionProjects[0]:     $mainWork = $dydSectionProjects; break;
        case $dydSectionAdventures[0]:   $mainWork = $dydSectionAdventures; break;
        case $dydSectionShops[0]:        $mainWork = $dydSectionShops; break;
        case $dydSectionPlayers[0]:      $mainWork = $dydSectionPlayers; break;
        case $dydSectionNPC[0]:          $mainWork = $dydSectionNPC; break;
        case $dydSectionParties[0]:      $mainWork = $dydSectionParties; break;
        case $dydSectionMap[0]:          $mainWork = $dydSectionMap; break;
        case $dydSectionTimeline[0]:     $mainWork = $dydSectionTimeline; break;
        case $dydSectionMiniatures[0]:   $mainWork = $dydSectionMiniatures; break;
        case $dydSectionArticles[0]:     $mainWork = $dydSectionArticles; break;
        case $dydSectionActions[0]:      $mainWork = $dydSectionActions; break;
        case $dydSectionAilments[0]:     $mainWork = $dydSectionAilments; break;
        case $dydSectionLevelChart[0]:   $mainWork = $dydSectionLevelChart; break;
        case $dydSectionRaces[0]:        $mainWork = $dydSectionRaces; break;
        case $dydSectionClasses[0]:      $mainWork = $dydSectionClasses; break;
        case $dydSectionBuilds[0]:       $mainWork = $dydSectionBuilds; break;
        case $dydSectionTraits[0]:       $mainWork = $dydSectionTraits; break;
        case $dydSectionBackgrounds[0]:  $mainWork = $dydSectionBackgrounds; break;
        case $dydSectionSkills[0]:       $mainWork = $dydSectionSkills; break;
        case $dydSectionPowers[0]:       $mainWork = $dydSectionPowers; break;
        case $dydSectionFeats[0]:        $mainWork = $dydSectionFeats; break;
        case $dydSectionItems[0]:        $mainWork = $dydSectionItems; break;
        case $dydSectionVehicles[0]:     $mainWork = $dydSectionVehicles; break;
        case $dydSectionMagicItems[0]:   $mainWork = $dydSectionMagicItems; break;
        case $dydSectionEnchants[0]:     $mainWork = $dydSectionEnchants; break;
        case $dydSectionRituals[0]:      $mainWork = $dydSectionRituals; break;
        case $dydSectionEncounter[0]:    $mainWork = $dydSectionEncounter; break;
        case $dydSectionBestiary[0]:     $mainWork = $dydSectionBestiary; break;
        case $dydSectionCreatures[0]:    $mainWork = $dydSectionCreatures; break;

        // =====================>
        // POKEMON
        // =====================>
        case $pkmnContact[0]:       $mainWork = $pkmnContact; break;
        case $pkmnBuilds[0]:        $mainWork = $pkmnBuilds; break;
        case $pkmnRoles[0]:         $mainWork = $pkmnRoles; break;        
        case $pkmnBreed[0]:         $mainWork = $pkmnBreed; break;        
        case $pkmnMoves[0]:         $mainWork = $pkmnMoves; break;            
        case $pkmnPals[0]:          $mainWork = $pkmnPals; break;    
        case $pkmnPalsSkills[0]:    $mainWork = $pkmnPalsSkills; break;

        // ---------------------------------------------------------->
        default: $mainWork = FALSE; break;
    }
}

// Mostramos los datos dependiendo de lo que tenemos:
switch($mainWork) {
    case FALSE: 
        switch($adZone) {
            case "dnd":  include($dydBasicSection); break;
            case "pkmn": include($pkmnBasicSection); break;
        }
    break;

    default: 
        $pageTitle2 = $mainWork[1] ?? "";
        include($mainWork[2]);
    break;
}

// ---------------------------------------------------------->
// Títulos de página
if (!empty($pageTitle3)) {
    $finalTitle = $pageTitle3." - ".$pageTitle2." - ".$pageTitle;
} elseif (!empty($pageTitle2)) {
    $finalTitle = $pageTitle2." - ".$pageTitle;
} else {
    $finalTitle = $pageTitle;
}
?>
