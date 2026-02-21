<?php
// soundtrack.php (mysqli-compatible)

// Aseguramos variables por si se incluye desde otro contexto
$page        = $page ?? "";
$typItem     = $typItem ?? "";
$link        = $link ?? null;
$tableOST    = $tableOST ?? "";
$pageField   = $pageField ?? "id"; // campo usado en las URL (puede ser 'id' o 'url')
$adZone      = $adZone ?? "dnd";
$sectionOST  = $sectionOST ?? array("soundtrack");

// Si no hay conexión, intentamos cargar la configuración (rosetta)
if (!$link) {
    @include_once("content/rosetta.php");
}

// Si sigue sin haber conexión, mostramos error y salimos
if (!$link) {
    echo "<p>Ha habido un error: no hay conexión a la base de datos.</p>";
    return;
}

// Cogemos el parámetro 'page' (viene de index/router)
$idGetData = $page;

// Si se solicita una canción concreta
if ($idGetData !== "") {
    // Protegemos el valor (usamos LIKE en la query original)
    $idEsc = mysqli_real_escape_string($link, $idGetData);
    $table  = mysqli_real_escape_string($link, $tableOST);
    $field  = mysqli_real_escape_string($link, $pageField);

    $orderData = "SELECT * FROM `$table` WHERE `$field` LIKE '$idEsc' LIMIT 1";
    $queryData = mysqli_query($link, $orderData);

    if (!$queryData) {
        echo "<p>Error en la consulta de la canción.</p>";
        // echo "<p>SQL Error: " . mysqli_error($link) . "</p>"; // descomenta para depuración
        return;
    }

    $rowsData = mysqli_num_rows($queryData);

    if ($rowsData > 0) {
        $dataResult = mysqli_fetch_assoc($queryData);

        // Datos básicos de la Canción
        $musicName     = $dataResult["name"] ?? "";
        $musicPlaylist = $dataResult["playlist"] ?? "";
        $musicLink     = $dataResult["yt_link"] ?? "";
        $musicTitle    = $dataResult["original_title"] ?? "";
        $musicArtist   = $dataResult["original_artist"] ?? "";
        $musicType     = $dataResult["type"] ?? "";
        $musicText     = $dataResult["infotext"] ?? "";
        $musicAuthor   = $dataResult["uploader"] ?? "";
        $musicDate     = $dataResult["date"] ?? "";

        // Localización para pestañas (si existe)
        @include_once("contents_tabs.php");

        $pageTitle3 = $musicName;
        echo "<h2>" . htmlspecialchars($musicName) . "</h2>";

        // Determinar título de tipo
        $musicTypeTitle = "";
        if ($musicType !== "") {
            switch ($musicType) {
                case "cha": $musicTypeTitle = "Tema de un personaje jugador"; break;
                case "npc": $musicTypeTitle = "Tema de un personaje no jugador"; break;
                case "loc": $musicTypeTitle = "Ambientación de un lugar"; break;
                case "btl": $musicTypeTitle = "Batallas y enfrentamientos"; break;
                case "eve": $musicTypeTitle = "Ambientación de un evento"; break;
            }
        }

        // Preparar la leyenda con la canción original.
        $musicLegend = "";
        if ($musicTitle !== "" && $musicArtist !== "") {
            $musicLegend = $musicArtist . " - " . $musicTitle;
        } elseif ($musicTitle !== "") {
            $musicLegend = $musicTitle;
        } elseif ($musicArtist !== "") {
            $musicLegend = $musicArtist;
        }

        // Preparar búsqueda YouTube (usamos urlencode)
        $youtubeSearch = "";
        if ($musicLegend !== "") {
            $prepare = trim($musicArtist . " " . $musicTitle);
            $youtubeSearch = "https://youtube.com/results?search_query=" . rawurlencode($prepare);
        }

        // Mostrar la info
        echo "<fieldset class='soundTrackInfo'>";
        if ($musicLegend !== "") {
            echo "<legend>&nbsp;" . htmlspecialchars($musicLegend) . "&nbsp;</legend>";
        }
        echo "<ul>";
        if ($musicTypeTitle !== "") { echo "<li><b>Tipo:</b> " . htmlspecialchars($musicTypeTitle) . "</li>"; }

        if ($musicAuthor !== "") {
            // Recuperar nombre del autor via retrieve_origin.php (usa $dataListAuthor y $retrieveFrom)
            $dataListAuthor = $musicAuthor;
            $retrieveFrom = "author";
            @include("retrieve_origin.php");
            $authorName = $authorName ?? "Invitado";
            echo "<li><b>Compartida por:</b> " . htmlspecialchars($authorName) . "</li>";
        }

        if ($musicDate !== "0000-00-00" && $musicDate !== "") { echo "<li><b>Fecha de subida:</b> " . htmlspecialchars($musicDate) . "</li>"; }
        if ($youtubeSearch !== "") { echo "<li><a href='" . htmlspecialchars($youtubeSearch) . "' target='_blank'>Buscar en YouTube</a></li>"; }
        echo "</ul>";
        echo "</fieldset>";

        // Incluir comprobación/preview de YouTube si existe el script
        @include_once("soundtrack_check_yt.php");

        if ($musicText !== "") {
            echo "<p class='soundTrackParagraph'>" . nl2br(htmlspecialchars($musicText)) . "</p>";
        }

        echo "<br/>";
        // fin de la vista individual

    } else {
        // No se encontró la canción solicitada
        echo "<p>No se ha encontrado la canción solicitada.</p>";
    }

} else {
    // Listado de canciones
    switch ($typItem) {
        case "erarasa":
            $musicTab     = "Era Rasa";
            $musicType    = "Banda sonora de " . $musicTab;
            $dataSearchSQL= "WHERE playlist LIKE '" . mysqli_real_escape_string($link, $musicTab) . "'";
        break;
        case "casusbelli":
            $musicTab     = "Casus Belli";
            $musicType    = "Banda sonora de " . $musicTab;
            $dataSearchSQL= "WHERE playlist LIKE '" . mysqli_real_escape_string($link, $musicTab) . "'";
        break;
        case "others":
            $musicTab     = "Otras campañas";
            $musicType    = "Banda sonora de otras campañas";
            $dataSearchSQL= "WHERE playlist LIKE ''";
        break;
        default:
            $dataSearchSQL = "WHERE type NOT LIKE ''";
            $musicTab      = "";
            $musicType     = "Banda sonora";
        break;
    }

    $pageTitle2 = $musicType;
    $dataListTitle = $musicType;

    // Localización para pestañas
    if ($musicType !== "Banda sonora") {
        $tabName = $musicTab;
        $locTab  = "K";
        @include_once("contents_tabs.php");
    }

    echo "<h3>" . htmlspecialchars($dataListTitle) . "</h3>";

    // Montar la consulta de listado: si el usuario no tiene nivel 5, filtramos visible=0
    if (isset($_SESSION['level']) && $_SESSION['level'] === 5) {
        $dataSearchTerms = "SELECT " . ($dydBasicFields ?? "*") . ", " . ($fieldsOST ?? "*") . " FROM " . mysqli_real_escape_string($link, $tableOST) . " " . $dataSearchSQL;
    } else {
        $dataSearchTerms = "SELECT " . ($dydBasicFields ?? "*") . ", " . ($fieldsOST ?? "*") . " FROM " . mysqli_real_escape_string($link, $tableOST) . " " . $dataSearchSQL . " AND game LIKE '" . mysqli_real_escape_string($link, $adZone) . "' AND visible LIKE 0";
    }

    $dataSection = $sectionOST[0] ?? "soundtrack";
    // Incluimos el listado (contents_list.php) — debe estar adaptado a mysqli también
    include("contents_list.php");
}
?>
