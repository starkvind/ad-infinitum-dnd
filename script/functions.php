<?php
// --------------------------------->
// Funciones PHP para Ad Infinitum
// --------------------------------->
// Quitar Tildes y Tema
function quitar_acentos($s) {
    return strtr($s, [
        'á'=>'a','à'=>'a','â'=>'a','ã'=>'a','ª'=>'a',
        'Á'=>'A','À'=>'A','Â'=>'A','Ã'=>'A',
        'í'=>'i','ì'=>'i','î'=>'i',
        'Í'=>'I','Ì'=>'I','Î'=>'I',
        'é'=>'e','è'=>'e','ê'=>'e',
        'É'=>'E','È'=>'E','Ê'=>'E',
        'ó'=>'o','ò'=>'o','ô'=>'o','õ'=>'o','º'=>'o',
        'Ó'=>'O','Ò'=>'O','Ô'=>'O','Õ'=>'O',
        'ú'=>'u','ù'=>'u','û'=>'u',
        'Ú'=>'U','Ù'=>'U','Û'=>'U',
        'ç'=>'c','Ç'=>'C',
        'ñ'=>'n','Ñ'=>'N',
    ]);
}


// Limpiar variables para las busquedas SQL
function limpiarCadena($valor) {
    $buscar = [
        "SELECT","COPY","DELETE","DROP","DUMP","TRUNCATE",
        " OR ","%","LIKE","--","^","[","]","\\","!","¡","?","=","&"
    ];
    return str_ireplace($buscar,"",$valor);
}

// Formatear fecha
function nuevaFecha($fecha) {
    $date = new DateTime($fecha);
    return $date->format('Y-m-d');
}

// Barras de vida para el combate
function hpbar($current, $max) {
    $percent = ($max > 0) ? round(($current/$max)*100) : 0;
    $color = color($current, $max);
    return "<div id='healthBar'><div style='width: " . $percent . "%; background-color: " . $color . "; border-radius: 0px; height: 15px; margin:0px;'></div></div>";
}

function color($current, $max) {
    $percent = ($max > 0) ? round(($current/$max)*100) : 0;
    $green = round(($percent*255)/100);
    $red = 255-$green;
    if ($percent < 0) {
        return "rgb(255, 0, 0)";
    }
    return "rgb(" . $red . ", " . $green . ", 0)";
}

// Preparar datos de la BDD
function sacaDatos($data, $typeOfDataToGet) {
    $dataCheckList = $data;
    $retrieveFrom = $typeOfDataToGet;
    include("content/sections/retrieve_origin.php");

    switch ($typeOfDataToGet) {
        case "music":
            $data = array($musicName, $musicYtLink);
            break;
        case "deity":
            $data = "<a href='".$deityLink."' target='_blank'>".$deityName."</a>";
            break;
        case "location":
            $data = "<a href='".$locLink."' target='_blank'>".$locName."</a>";
            break;
        case "player":
            $data = "<a href='".$playerLink."' target='_blank'>".$playerName." ".$playerSurname."</a>";
            break;
        case "npc":
            $data = "<a href='".$npcLink."' target='_blank'>".$npcName." ".$npcSurname."</a>";
            break;
        case "party":
            $data = "<a href='".$partyLink."' target='_blank'>".$partyName."</a>";
            break;
        case "race":
            $data = array($raceLink, $raceName);
            break;
        case "class":
            $data = array($classLink, $className);
            break;
        case "creatures":
            $data = array($creatID, $creatName, $creatRole, $creatLevel, $creatElite, $creatXP);
            break;
    }
    return $data;
}

// Comprobar si los valores son numéricos
function comprobarSiNumero($numero) {
    if (is_numeric($numero)) {
        return "WHERE id LIKE ".$numero;
    } else {
        return "WHERE url LIKE '".$numero."'";
    }
}
?>
