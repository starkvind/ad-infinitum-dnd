<?php
// main_status_op.php (conteos para main_status.php) - mysqli-safe

// Aseguramos variables
$dataTable = $dataTable ?? '';
$dataCountN = $dataCountN ?? 0;

// Intentamos incluir la configuración si no existe una conexión mysqli
if (!isset($link)) {
    @include_once("content/rosetta.php"); // debe definir $link y demás variables
}

// Si no hay tabla definida devolvemos ceros
if ($dataTable === "" || !isset($link) || !is_string($dataTable)) {
    $rowsData = [0, 0, 0];
    return;
}

// Normalizamos el nombre de la tabla (evitar inyecciones simples)
$dataTableEsc = mysqli_real_escape_string($link, $dataTable);

// Comprobamos si la tabla tiene columna 'canon' (para oficiales/homebrew)
$hasCanon = false;
$resShow = @mysqli_query($link, "SHOW COLUMNS FROM `{$dataTableEsc}` LIKE 'canon'");
if ($resShow !== false && mysqli_num_rows($resShow) > 0) {
    $hasCanon = true;
}
if ($resShow !== false) { mysqli_free_result($resShow); }

// Consultas principales (usamos COUNT(*) para obtener un número claro)
$sqlTotal   = "SELECT COUNT(*) AS cnt FROM `{$dataTableEsc}`";
$sqlCanon1  = "SELECT COUNT(*) AS cnt FROM `{$dataTableEsc}` WHERE `canon` = 1";
$sqlCanon0  = "SELECT COUNT(*) AS cnt FROM `{$dataTableEsc}` WHERE `canon` = 0";

$rowsData = [0, 0, 0];

// Total
if ($rq = @mysqli_query($link, $sqlTotal)) {
    $row = mysqli_fetch_assoc($rq);
    $rowsData[0] = isset($row['cnt']) ? (int)$row['cnt'] : 0;
    mysqli_free_result($rq);
} else {
    $rowsData[0] = 0;
}

// Si existe columna canon, obtenemos oficiales/homebrew, si no, quedan a 0
if ($hasCanon) {
    if ($rq = @mysqli_query($link, $sqlCanon1)) {
        $row = mysqli_fetch_assoc($rq);
        $rowsData[1] = isset($row['cnt']) ? (int)$row['cnt'] : 0;
        mysqli_free_result($rq);
    } else {
        $rowsData[1] = 0;
    }

    if ($rq = @mysqli_query($link, $sqlCanon0)) {
        $row = mysqli_fetch_assoc($rq);
        $rowsData[2] = isset($row['cnt']) ? (int)$row['cnt'] : 0;
        mysqli_free_result($rq);
    } else {
        $rowsData[2] = 0;
    }
} else {
    $rowsData[1] = 0;
    $rowsData[2] = 0;
}

// Actualizamos acumulador de totales (comportamiento original)
$dataCountN = (int)$dataCountN + (int)($rowsData[0] ?? 0);
?>
