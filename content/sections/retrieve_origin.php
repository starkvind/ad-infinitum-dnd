<?php
// ---------------------------------------->
// retrieve_origin.php (mysqli)
// ---------------------------------------->

// Evitar notices si no llegan variables desde el include llamante
$typeOfDataToGet = $typeOfDataToGet ?? "";
$retrieveFrom    = $retrieveFrom    ?? "";
$dataSection     = $dataSection     ?? "";
$originCanon     = $originCanon     ?? 0;

// Aseguramos conexión disponible
if (!isset($link)) {
    @include_once("content/rosetta.php");
}

// Si viene de sacaDatos() puede requerir estas piedras
if ($typeOfDataToGet !== "") {
    @include_once("content/stone.php");
    @include_once("content/rosetta.php");
}

// Helper para ejecutar queries (evita redeclaración si se incluye varias veces)
if (!function_exists('_q')) {
    function _q($link, $sql) {
        $res = mysqli_query($link, $sql);
        return $res ?: false;
    }
}

// ---------------------------------------->
switch ($retrieveFrom) {

    // ======================================================
    // ORIGEN (bibliografía)
    // ======================================================
    case "origin":
        if (!($dataSection == $dydSectionUpdates[0] || $dataSection == $dydSectionBibliography[0])) {
            $originOrder = "SELECT name, icon, canon
                            FROM $dydTableBibliography
                            WHERE id LIKE $dataListOrigin
                            LIMIT 1";
            if ($rq = _q($link, $originOrder)) {
                if (mysqli_num_rows($rq) > 0) {
                    $row         = mysqli_fetch_assoc($rq);
                    $originName  = $row["name"] ?? "";
                    $originIcon  = $row["icon"] ?? "";
                    $originCanon = 1; // Libre acceso (forzamos visibilidad)
                }
            }
        }
    break;

    // ======================================================
    // AUTOR (usuarios)
    // ======================================================
    case "author":
        $user = isset($dataListAuthor) ? mysqli_real_escape_string($link, $dataListAuthor) : "";
        $authorOrder = "SELECT nick
                        FROM $tableUsers
                        WHERE $mainUserNameRow LIKE '$user'
                        LIMIT 1";
        if ($rq = _q($link, $authorOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row        = mysqli_fetch_assoc($rq);
                $authorName = $row["nick"] ?? "Invitado";
            } else {
                $authorName = "Invitado";
            }
        }
    break;

    // ======================================================
    // MÚSICA
    // ======================================================
    case "music":
        $searchListQuery = comprobarSiNumero($dataCheckList);
        $musicOrder = "SELECT id, name, yt_link
                       FROM $tableOST
                       $searchListQuery
                       LIMIT 1";
        if ($rq = _q($link, $musicOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row         = mysqli_fetch_assoc($rq);
                $musicID     = $row["id"] ?? 0;
                $musicName   = $row["name"] ?? "";
                $musicYtLink = $row["yt_link"] ?? "";
            }
        }
    break;

    // ======================================================
    // DEIDAD (artículos)
    // ======================================================
    case "deity":
        if ($typeOfDataToGet == "") { $dataCheckList = $dataListDeity; }
        $searchListQuery = comprobarSiNumero($dataCheckList);
        $deityOrder = "SELECT id, name
                       FROM $dydTableArticles
                       $searchListQuery
                       LIMIT 1";
        if ($rq = _q($link, $deityOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row       = mysqli_fetch_assoc($rq);
                $deityID   = $row["id"] ?? 0;
                $deityName = $row["name"] ?? "";
                $deityLink = $pathArti.$deityID."/";
            }
        }
    break;

    // ======================================================
    // AVENTURA
    // ======================================================
    case "adventure":
        $advenOrder = "SELECT id, url, name, campaign
                       FROM $dydTableAdventures
                       WHERE id LIKE $dataListAdven
                       LIMIT 1";
        if ($rq = _q($link, $advenOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row           = mysqli_fetch_assoc($rq);
                $advenID       = $row["id"] ?? 0;
                $advenName     = $row["name"] ?? "";
                $advenCampaign = $row["campaign"] ?? "";
                $advenLink     = $pageRoot.$dydSectionAdventures[0]."/".$advenID."/";
            } else {
                $advenName = "";
            }
        }
    break;

    // ======================================================
    // PERSONAJE JUGADOR
    // ======================================================
    case "player":
        $searchListQuery = comprobarSiNumero($dataCheckList);
        $playerOrder = "SELECT id, url, name, surname
                        FROM $dydTablePlayers
                        $searchListQuery
                        LIMIT 1";
        if ($rq = _q($link, $playerOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row           = mysqli_fetch_assoc($rq);
                $playerID      = $row["id"] ?? 0;
                $playerName    = $row["name"] ?? "";
                $playerSurname = $row["surname"] ?? "";
                $playerURL     = $row["url"] ?? "";
                $playerLink    = $pathPlay.$playerID."/";
            }
        }
    break;

    // ======================================================
    // PERSONAJE NO JUGADOR
    // ======================================================
    case "npc":
        $searchListQuery = comprobarSiNumero($dataCheckList);
        $npcOrder = "SELECT id, url, name, surname
                     FROM $dydTableNPC
                     $searchListQuery
                     LIMIT 1";
        if ($rq = _q($link, $npcOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row        = mysqli_fetch_assoc($rq);
                $npcID      = $row["id"] ?? 0;
                $npcName    = $row["name"] ?? "";
                $npcSurname = $row["surname"] ?? "";
                $npcURL     = $row["url"] ?? "";
                $npcLink    = $pathNPCS.$npcID."/";
            }
        }
    break;

    // ======================================================
    // GRUPO DE AVENTUREROS
    // ======================================================
    case "party":
        $searchListQuery = comprobarSiNumero($dataCheckList);
        $partyOrder = "SELECT id, url, name
                       FROM $dydTableParties
                       $searchListQuery
                       LIMIT 1";
        if ($rq = _q($link, $partyOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row       = mysqli_fetch_assoc($rq);
                $partyID   = $row["id"] ?? 0;
                $partyName = $row["name"] ?? "";
                $partyURL  = $row["url"] ?? "";
                $partyLink = $pathPrty.$partyID."/";
            }
        }
    break;

    // ======================================================
    // LOCALIZACIÓN (MAPA)
    // ======================================================
    case "location":
        if ($typeOfDataToGet == "") { $dataCheckList = $dataListLoc; }
        $searchListQuery = comprobarSiNumero($dataCheckList);
        $locOrder = "SELECT id, url, name
                     FROM $dydTableMap
                     $searchListQuery
                     LIMIT 1";
        if ($rq = _q($link, $locOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row     = mysqli_fetch_assoc($rq);
                $locID   = $row["id"] ?? 0;
                $locName = $row["name"] ?? "";
                $locURL  = $row["url"] ?? "";
                $locLink = $pathYMap.$locID."/";
            } else {
                $locName = "";
            }
        }
    break;

    // ======================================================
    // RAZA
    // ======================================================
    case "race":
        if ($typeOfDataToGet == "") { $dataCheckList = $dataListRace; }
        $searchListQuery = comprobarSiNumero($dataCheckList);
        $raceOrder = "SELECT id, name, size, abilities, skillbonus, speed, vision, traits, image
                      FROM $dydTableRaces
                      $searchListQuery
                      LIMIT 1";
        if ($rq = _q($link, $raceOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row           = mysqli_fetch_assoc($rq);
                $raceID        = $row["id"] ?? 0;
                $raceName      = $row["name"] ?? "";
                $raceSize      = $row["size"] ?? "";
                $raceAbilities = $row["abilities"] ?? "";
                $raceSkills    = $row["skillbonus"] ?? "";
                $raceSpeed     = $row["speed"] ?? "";
                $raceVision    = $row["vision"] ?? "";
                $raceTraits    = $row["traits"] ?? "";
                $raceImg       = $row["image"] ?? "";
                $raceLink      = $pathRace.$raceID."/";
            }
        }
    break;

    // ======================================================
    // CLASE
    // ======================================================
    case "class":
        if ($typeOfDataToGet == "") { $dataCheckList = $dataListClass; }
        $searchListQuery = comprobarSiNumero($dataCheckList);
        $classOrder = "SELECT id, name, flavortext, role, bonusdefense, hp1stlvl, hpperllvl, healingsurges, class_features, image
                       FROM $dydTableClasses
                       $searchListQuery
                       LIMIT 1";
        if ($rq = _q($link, $classOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row         = mysqli_fetch_assoc($rq);
                $classID     = $row["id"] ?? 0;
                $className   = $row["name"] ?? "";
                $classMotto  = $row["flavortext"] ?? "";
                $classDefense= $row["bonusdefense"] ?? "";
                $classRole   = $row["role"] ?? "";
                $classTraits = $row["class_features"] ?? "";
                $classHp1st  = $row["hp1stlvl"] ?? 0;
                $classHpLvl  = $row["hpperllvl"] ?? 0;
                $classSurges = $row["healingsurges"] ?? 0;
                $classImg    = $row["image"] ?? "";
                $classLink   = $pathClas.$classID."/";
            }
        }
    break;

    // ======================================================
    // PARANGÓN
    // ======================================================
    case "paragon":
        $paragonOrder = "SELECT name, class_features
                         FROM $dydTableClasses
                         WHERE id LIKE $dataListParagon
                         LIMIT 1";
        if ($rq = _q($link, $paragonOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row           = mysqli_fetch_assoc($rq);
                $paragonName   = $row["name"] ?? "";
                $paragonTraits = $row["class_features"] ?? "";
            }
        }
    break;

    // ======================================================
    // ÉPICO
    // ======================================================
    case "epic":
        $epicOrder = "SELECT name, class_features
                      FROM $dydTableClasses
                      WHERE id LIKE $dataListEpic
                      LIMIT 1";
        if ($rq = _q($link, $epicOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row        = mysqli_fetch_assoc($rq);
                $epicName   = $row["name"] ?? "";
                $epicTraits = $row["class_features"] ?? "";
            }
        }
    break;

    // ======================================================
    // TEMA DE PERSONAJE
    // ======================================================
    case "theme":
        $themeOrder = "SELECT name, class_features
                       FROM $dydTableClasses
                       WHERE id LIKE $dataListTheme
                       LIMIT 1";
        if ($rq = _q($link, $themeOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row         = mysqli_fetch_assoc($rq);
                $themeName   = $row["name"] ?? "";
                $themeTraits = $row["class_features"] ?? "";
            }
        }
    break;

    // ======================================================
    // TRASFONDO
    // ======================================================
    case "background":
        $bgOrder = "SELECT name
                    FROM $dydTableBackgrounds
                    WHERE id LIKE $dataListBackground
                    LIMIT 1";
        if ($rq = _q($link, $bgOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row   = mysqli_fetch_assoc($rq);
                $bgName= $row["name"] ?? "";
            }
        }
    break;

    // ======================================================
    // DOTES
    // ======================================================
    case "feats":
        $featOrder = "SELECT name, tier, type, class, bonus, special
                      FROM $dydTableFeats
                      WHERE id LIKE $dataListFeat
                      LIMIT 1";
        if ($rq = _q($link, $featOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row         = mysqli_fetch_assoc($rq);
                $featName    = $row["name"] ?? "";
                $featTier    = $row["tier"] ?? "";
                $featType    = $row["type"] ?? "";
                $featClass   = $row["class"] ?? "";
                $featBonus   = $row["bonus"] ?? "";
                $featSpecial = $row["special"] ?? "";
            }
        }
    break;

    // ======================================================
    // OBJETOS MUNDANOS
    // ======================================================
    case "thing":
        $thingOrder = "SELECT name, type, bd_type, icon
                       FROM $dydTableItems
                       WHERE id LIKE $dataListThing
                       LIMIT 1";
        if ($rq = _q($link, $thingOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row           = mysqli_fetch_assoc($rq);
                $thingName     = $row["name"] ?? "";
                $armorType     = $row["name"] ?? "";
                $equipIconType = $row["bd_type"] ?? "";
                $objectType    = $row["type"] ?? "";
                $objectIcon    = $row["icon"] ?? "";
            }
        }
    break;

    // ======================================================
    // OBJETOS MÁGICOS
    // ======================================================
    case "magic":
        $magicOrder = "SELECT name, type, bd_bonus, bd_type, icon
                       FROM $dydTableMagicItems
                       WHERE id LIKE $dataListMagic
                       LIMIT 1";
        if ($rq = _q($link, $magicOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row           = mysqli_fetch_assoc($rq);
                $magicName     = $row["name"] ?? "";
                $magicBonus    = $row["bd_bonus"] ?? "";
                $armorType     = $row["type"] ?? "";
                $equipIconType = $row["bd_type"] ?? "";
                $objectType    = $row["type"] ?? "";
                $objectIcon    = $row["icon"] ?? "";
            }
        }
    break;

    // ======================================================
    // RITUALES
    // ======================================================
    case "rituals":
        $ritualOrder = "SELECT name, category
                        FROM $dydTableRituals
                        WHERE id LIKE $dataListRitual
                        LIMIT 1";
        if ($rq = _q($link, $ritualOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row            = mysqli_fetch_assoc($rq);
                $ritualName     = $row["name"] ?? "";
                $ritualCategory = $row["category"] ?? "";
            }
        }
    break;

    // ======================================================
    // CRIATURAS
    // ======================================================
    case "creatures":
        if ($typeOfDataToGet == "") { $dataCheckList = $dataListCreature; }
        $creatOrder = "SELECT $dydBasicFields, $dydCreaturesFields
                       FROM $dydTableCreatures
                       WHERE id LIKE $dataCheckList";
        if ($rq = _q($link, $creatOrder)) {
            if (mysqli_num_rows($rq) > 0) {
                $row        = mysqli_fetch_assoc($rq);
                $creatID    = $row["id"] ?? 0;
                $creatName  = $row["name"] ?? "";
                $creatRole  = $row["role"] ?? "";
                $creatLevel = $row["level"] ?? "";
                $creatElite = $row["elite"] ?? "";
                $creatXP    = $row["xp"] ?? "";
            }
        }
    break;
}
// ---------------------------------------->
// Fin del archivo
// ---------------------------------------->
?>
