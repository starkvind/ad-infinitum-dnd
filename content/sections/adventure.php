<?php
// adventure.php (mysqli-ready)
// ---------------------------------

// Evitar notices si no llegan variables desde el include llamante
$page         = $page ?? "";
$pageField    = $pageField ?? "id";
$link         = $link ?? null;

// Aseguramos que exista la conexión (por si llaman este archivo fuera del flujo habitual)
if (!isset($link) || !$link) {
    @include_once("content/rosetta.php");
}

// Recolectamos el slug/id solicitado
$idGetData = $page;
$newInstanceLoot = "";
$newInstanceMobs = "";
$encounterLocationUrls = array();
$encounterData = array();

// Escapar el valor recibido para usar en la consulta
$idGetDataEsc = mysqli_real_escape_string($link, $idGetData);

// Preparamos consulta de la aventura
$orderData = "SELECT * FROM ".$dydTableAdventures." WHERE ".$pageField." LIKE '".$idGetDataEsc."' LIMIT 1;";
$queryData = mysqli_query($link, $orderData);
$rowsData  = $queryData ? mysqli_num_rows($queryData) : 0;

if ($rowsData > 0) { // Si hemos encontrado la aventura
    $dataResult = mysqli_fetch_assoc($queryData);

    // ================================================================== //
    // Datos básicos del Artículo
    $instanceID        = $dataResult["id"] ?? "";
    $instanceName      = $dataResult["name"] ?? "";
    $instanceNumber    = $dataResult["number"] ?? "";
    $instanceCampaign  = $dataResult["campaign"] ?? "";
    $instanceLoot      = $dataResult["loot"] ?? "";
    $instanceLevels    = $dataResult["levels"] ?? "";
    $instanceXP        = $dataResult["xp"] ?? "";
    $instancePlayers   = $dataResult["players"] ?? "";
    $instanceNPCS      = $dataResult["npcs"] ?? "";
    $instanceEncounters= $dataResult["encounters"] ?? "";
    $instanceLocations = $dataResult["locations"] ?? "";
    $instanceText      = $dataResult["infotext"] ?? "";
    $instanceDate      = $dataResult["date"] ?? "";
    $instanceMaster    = $dataResult["uploader"] ?? "";
    // ================================================================== //

    // Conseguimos datos del Origen (si tienes otro nombre de fichero, ajusta)
    if (file_exists(__DIR__ . "/content_origin.php")) {
        include_once(__DIR__ . "/content_origin.php");
    } else {
        // Si usas retrieve_origin.php:
        if (file_exists(__DIR__ . "/retrieve_origin.php")) {
            $dataListOrigin = $dataResult["origin"] ?? "";
            $retrieveFrom = "origin";
            include_once(__DIR__ . "/retrieve_origin.php");
        }
    }

    // Comprobación de sesión / permisos: usamos originCanon si existe (definimos por defecto 0)
    $originCanon = $originCanon ?? 0;
    $mainUserLevel = $mainUserLevel ?? 0;
    if ($originCanon == 0 && empty($dataResult["origin"])) {
        $originCanon = 1;
    }
    if ($originCanon == 0 && $mainUserLevel > 0) {
        $originCanon = 1;
    }

    if ($originCanon != 0) {
        // Localización para pestañas
        include_once(__DIR__ . "/contents_tabs.php");

        $pageTitle2 = $titleName ?? "";
        $pageTitle3 = $instanceName;
        echo "<h2>".htmlspecialchars($instanceName, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8")."</h2>";

        // ------------------------------------------------------------------ //
        // Información de la Aventura (TAB 1)
        echo "<div id='info' class='tab_content'>";
            echo "<fieldset class='articleBody'>";
                if ($instanceNumber != "") {
                    echo "<legend>Nº #".htmlspecialchars($instanceNumber, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8")."</legend>";
                }

                echo "<ul>";
                    echo "<li><span style='font-weight:bold;'>Fecha de juego:</span> ".htmlspecialchars($instanceDate, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8")."</li>";
                    echo "<li><span style='font-weight:bold;'>Experiencia:</span> ".htmlspecialchars($instanceXP, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8")." px</li>";
                    echo "<li><span style='font-weight:bold;'>Nivel recomendado:</span> ".htmlspecialchars($instanceLevels, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8")."</li>";

                    // Averiguamos el máster
                    if (!empty($instanceMaster)) {
                        $dataListAuthor = $instanceMaster;
                        $retrieveFrom = "author";
                        // include retrieve_origin (asegúrate de que existe ese archivo)
                        if (file_exists(__DIR__ . "/retrieve_origin.php")) {
                            include(__DIR__ . "/retrieve_origin.php");
                        } elseif (file_exists("content/sections/retrieve_origin.php")) {
                            include("content/sections/retrieve_origin.php");
                        }
                        $authorName = $authorName ?? "Invitado";
                        echo "<li><span style='font-weight:bold;'>Máster:</span> ".htmlspecialchars($authorName, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8")."</li>";
                    }
                echo "</ul>";

                if ($instanceText == "") {
                    $instanceText = "Esta aventura no dispone de descripción.";
                }
                echo "<p>".nl2br(htmlspecialchars($instanceText, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8"))."</p>";

                // Comprobamos eventos en la línea temporal (timeline)
                $timelineTerms = "SELECT id, url, name FROM ".$dydTableTimeline." WHERE adventure_id LIKE ".(int)$instanceID;
                $timelineIdQuery = mysqli_query($link, $timelineTerms);
                $timelineRows = $timelineIdQuery ? mysqli_num_rows($timelineIdQuery) : 0;

            // Sección de los encuentros
            if (!empty($instanceEncounters)) {
                $newInstanceEXP = 0;
                $newInstanceLoot = array();
                $newInstanceMobs = array();
                $encounterTerms = "SELECT * FROM ".$dydTableEncounter." WHERE id IN (".$instanceEncounters.")";
                $encounterIdQuery = mysqli_query($link, $encounterTerms);
                $encounterRows = $encounterIdQuery ? mysqli_num_rows($encounterIdQuery) : 0;

                if ($encounterRows > 0) {
                    echo "<span style='font-weight:bold;'>Encuentros</span>";
                    echo "<ol>";

                    // Recorremos resultados
                    while ($encounterQueryResult = mysqli_fetch_assoc($encounterIdQuery)) {
                        echo "<li><a href='#".$encounterQueryResult["id"]."'>".htmlspecialchars($encounterQueryResult["name"], ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8")."</a></li>";

                        // Preparamos array de criaturas (creatures)
                        $newCreaturesArray = array();
                        if (!empty($encounterQueryResult["creatures"])) {
                            $newCreaturesArray = explode(",", $encounterQueryResult["creatures"]);
                        }
                        foreach ($newCreaturesArray as $nc) {
                            $stripMobQty = explode("x", $nc);
                            $stripMobSpn = explode(":", $stripMobQty[0]);
                            if (!empty($stripMobSpn[1])) {
                                $newInstanceMobs[] = $stripMobSpn[1];
                            } else {
                                $newInstanceMobs[] = $stripMobSpn[0];
                            }
                        }

                        // Preparamos el array de nuevo loot
                        if (!empty($encounterQueryResult["loot"])) {
                            $newLootArray = explode(",", $encounterQueryResult["loot"]);
                            foreach ($newLootArray as $lootItem) {
                                $whatKindOfLoot = explode(":", $lootItem);
                                if (isset($whatKindOfLoot[0]) && $whatKindOfLoot[0] == "M") {
                                    $strippingQty = explode("x", $whatKindOfLoot[1] ?? "");
                                    $newInstanceLoot[] = $strippingQty[0] ?? "";
                                }
                            }
                        }

                        // XP del encuentro (defensiva: si existe)
                        $encounterXP = isset($encounterQueryResult["xp"]) ? (int)$encounterQueryResult["xp"] : 0;
                        $newInstanceEXP += $encounterXP;

                        // Guardamos el dato (para después mostrar detalle)
                        $encounterData[] = $encounterQueryResult;
                    } // end while

                    echo "</ol>";
                    echo "</fieldset>";
                    echo "<br />";
                    echo "<hr class='encounterLine' />";

                    // Mostrar encuentros individualmente
                    foreach ($encounterData as $encounterSlot => $encounterRow) {
                        $encounterID = $encounterRow["id"];
                        echo "<a name='".$encounterID."'></a>";
                        // Include de tarjeta de encuentro (asegúrate de que existe)
                        if (file_exists(__DIR__ . "/encounter_card.php")) {
                            include(__DIR__ . "/encounter_card.php");
                        }
                        echo "<br />";
                        if ($encounterSlot + 1 != count($encounterData)) {
                            echo "<hr class='encounterLine' />";
                        }
                    }
                } else {
                    echo "</fieldset>";
                }

                // Quitamos duplicados
                $newInstanceLoot = array_unique($newInstanceLoot);
                $newInstanceMobs = array_unique($newInstanceMobs);
                // Validamos y convertimos a string para IN (...)
                $newInstanceLoot = implode(",", array_filter($newInstanceLoot, 'strlen'));
                $newInstanceMobs = implode(",", array_filter($newInstanceMobs, 'strlen'));
            } // end if encounters
            // Si no hubo encuentros, mantenemos antiguo loot
            if ($newInstanceLoot == "") { $newInstanceLoot = $instanceLoot; }

            // Localizaciones
            if (!empty($instanceLocations)) {
                $locArray = explode(",", $instanceLocations);
                $locArray2 = array();
                foreach ($locArray as $la) {
                    $locArray2[] = "'".str_replace(" ", "", mysqli_real_escape_string($link, $la))."'";
                }
                if (empty($encounterLocationUrls)) {
                    $instanceLocationArray = $locArray2;
                } else {
                    $instanceLocationArray = array_merge($encounterLocationUrls, $locArray2);
                }
            } else {
                $instanceLocationArray = $encounterLocationUrls ?? array();
            }

        echo "</div>"; // Fin TAB 1

        // ------------------------------------------------------------------ //
        // Asistentes a la Aventura (TAB 2)
        echo '<div id="players" class="tab_content">';
            // Jugadores
            if (!empty($instancePlayers)) {
                $playerArray = explode(",", $instancePlayers);
                $playerArray2 = array();
                foreach ($playerArray as $p) {
                    $playerArray2[] = "'".str_replace(" ", "", mysqli_real_escape_string($link, $p))."'";
                }
                $dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydPlayersFields." FROM ".$dydTablePlayers." WHERE url IN (".implode(",",$playerArray2).")";
                $dataSection = $dydSectionPlayers[0];
                echo "<fieldset class='noInfoLink'>";
                    echo "<h3 class='powerTitle'>Personajes</h3>";
                    include(__DIR__ . "/contents_list.php");
                echo "</fieldset>";
            }

            if (!empty($instancePlayers) && !empty($instanceNPCS)) { echo "<br />"; }

            // PNJ
            if (!empty($instanceNPCS)) {
                $npcsArray = explode(",", $instanceNPCS);
                $npcsArray2 = array();
                foreach ($npcsArray as $n) {
                    $npcsArray2[] = "'".str_replace(" ", "", mysqli_real_escape_string($link, $n))."'";
                }
                $dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydNPCFields." FROM ".$dydTableNPC." WHERE url IN (".implode(",",$npcsArray2).")";
                $dataSection = $dydSectionNPC[0];
                echo "<fieldset class='noInfoLink'>";
                    echo "<h3 class='powerTitle'>Personajes no jugadores</h3>";
                    include(__DIR__ . "/contents_list.php");
                echo "</fieldset>";
            }
        echo "</div>"; // Fin TAB 2

        // ------------------------------------------------------------------ //
        // Tesoro de la Aventura (TAB 3)
        if (!empty($newInstanceLoot)) {
            echo '<div id="loot" class="tab_content">';
                $dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydMagicItemsFields." FROM ".$dydTableMagicItems." WHERE id IN (".$newInstanceLoot.")";
                $dataSection = $dydSectionMagicItems[0];
                echo "<fieldset class='noInfoLink'>";
                    echo "<h3 class='powerTitle'>Tesoros</h3>";
                    include(__DIR__ . "/contents_list.php");
                echo "</fieldset>";
            echo "</div>";
        }

        // ------------------------------------------------------------------ //
        // Criaturas (TAB X)
        if (!empty($newInstanceMobs)) {
            echo '<div id="creatures" class="tab_content">';
                $dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydCreaturesFields." FROM ".$dydTableCreatures." WHERE id IN (".$newInstanceMobs.")";
                $dataSection = $dydSectionCreatures[0];
                echo "<fieldset class='noInfoLink'>";
                    echo "<h3 class='powerTitle'>Criaturas</h3>";
                    include(__DIR__ . "/contents_list.php");
                echo "</fieldset>";
            echo "</div>";
        }

        // ------------------------------------------------------------------ //
        // Lugares visitados
        if (!empty($instanceLocationArray) && count($instanceLocationArray) > 0) {
            echo '<div id="places" class="tab_content">';
                $dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydMapFields." FROM ".$dydTableMap." WHERE url IN (".implode(",",$instanceLocationArray).")";
                $dataSection = $dydSectionMap[0];
                echo "<fieldset class='noInfoLink'>";
                    echo "<h3 class='powerTitle'>Lugares visitados</h3>";
                    include(__DIR__ . "/contents_list.php");
                echo "</fieldset>";
            echo "</div>";
        }

        // ------------------------------------------------------------------ //
        // Eventos en la aventura
        if ($timelineRows > 0) {
            echo '<div id="events" class="tab_content">';
                $hideAdventureColumn = TRUE;
                $dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydTimelineFields." FROM ".$dydTableTimeline." WHERE adventure_id LIKE ".(int)$instanceID;
                $dataSection = $dydSectionTimeline[0];
                echo "<fieldset class='noInfoLink'>";
                    echo "<h3 class='powerTitle'>Eventos ocurridos</h3>";
                    include(__DIR__ . "/contents_list.php");
                echo "</fieldset>";
            echo "</div>";
        }

        echo "<br/>";
    } else {
        // No autorizado
        echo $phraseNoAuth ?? "No autorizado";
    }

} else {
    // Listado de Aventuras (sin seleccionar una aventura)
    switch($typItem ?? "") {
        case "erarasa":
            $instCampaign  = "Era Rasa";
            $dataSearchSQL = "WHERE campaign LIKE '".$instCampaign."'";
        break;
        case "casusbelli":
            $instCampaign  = "Casus Belli";
            $dataSearchSQL = "WHERE campaign LIKE '".$instCampaign."'";
        break;
        case "parvumiter":
            $instCampaign  = "Parvum Iter";
            $dataSearchSQL = "WHERE campaign LIKE '".$instCampaign."'";
        break;
        case "tales":
            $instCampaign  = "Historias personales";
            $dataSearchSQL = "WHERE campaign LIKE '".$instCampaign."'";
        break;
        case "nocampaign":
            $dataSearchSQL = "WHERE campaign LIKE ''";
            $instCampaign  = "Sin campaña";
        break;
        case "incomplete":
            $dataSearchSQL = "WHERE complete LIKE 1";
            $instCampaign  = "Aventuras pendientes";
        break;
        default:
            $dataSearchSQL = "WHERE name NOT LIKE ''";
            $instCampaign  = "Aventuras";
        break;
    }

    $pageTitle2 = $instCampaign;
    $dataListTitle = $instCampaign;

    if ($instCampaign != "Aventuras") {
        $tabName = $instCampaign;
        $locTab = "FK";
        include_once(__DIR__ . "/contents_tabs.php");
    }

    echo "<h3>".htmlspecialchars($dataListTitle, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8")."</h3>";
    $userLevelCheck = $userLevelCheck ?? "";
    $dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydAdventuresFields." FROM ".$dydTableAdventures." ".$dataSearchSQL." ".$userLevelCheck."";
    $dataSection = $dydSectionAdventures[0];
    include(__DIR__ . "/contents_list.php");
}
?>

