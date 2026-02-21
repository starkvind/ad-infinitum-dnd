<?php
// levelchart.php (mysqli-compatible)
// Muestra la tabla de progreso (tabla de niveles)

// Aseguramos variables necesarias (por si se incluye desde otro contexto)
$dydTableLevelChart = $dydTableLevelChart ?? '';
$link = $link ?? null;

if (!$link || $dydTableLevelChart === '') {
    echo "<p>Ha habido un error. Falta configuración de la base de datos.</p>";
    return;
}

// Consultamos los niveles (ordenados por nivel para seguridad)
$orderData = "SELECT * FROM `" . mysqli_real_escape_string($link, $dydTableLevelChart) . "` ORDER BY `level` ASC";
$queryData = @mysqli_query($link, $orderData);

if (!$queryData) {
    echo "<p>Ha habido un error al consultar la tabla de niveles.</p>";
    // Si quieres ver el error para depuración, descomenta la siguiente línea:
    // echo "<p>Error SQL: " . mysqli_error($link) . "</p>";
    return;
}

$rowsData = mysqli_num_rows($queryData);

if ($rowsData > 0) {
    // Localización para pestañas (si existe)
    @include_once("contents_tabs.php");
?>
<!-- Inicio de la Tabla de progreso -->
<h3>Tabla de progreso para Dungeons &amp; Dragons 4.0</h3>
<table class="levelchart">
    <thead>
    <!-- Cabeceras -->
        <tr>
            <th>Nivel</th>
            <th>Experiencia</th>
            <th>Características</th>
            <th>Rasgos y beneficios</th>
            <th>Dotes</th>
            <th colspan="4">Poderes</th>
        </tr>
    </thead>
    <!-- Cuerpo de la tabla -->
    <tbody>
<?php
    // Recorremos los resultados
    while ($resultData = mysqli_fetch_assoc($queryData)) {
        // Valores (aseguramos existencia)
        $chartLevel  = $resultData["level"]  ?? '';
        $chartXP     = (string)($resultData["xp"] ?? '');
        $chartStats  = $resultData["stats"]  ?? '';
        $chartGains  = $resultData["gains"]  ?? '';
        $chartFeats  = $resultData["feats"]  ?? '';
        $chartPowers = $resultData["powers"] ?? '';

        // Par / impar para la fila
        $chartRow = (is_numeric($chartLevel) && $chartLevel % 2 == 0) ? 'even' : 'odd';

        // Formatear experiencia con puntos (similar a comportamiento original)
        $digitsXP = strlen($chartXP);
        switch ($digitsXP) {
            default:
                $chartNewXP = $chartXP;
            break;
            case 4:
                // 1.234
                $chartNewXP = substr($chartXP, 0, -3) . "." . substr($chartXP, 1);
            break;
            case 5:
                // 12.345
                $chartNewXP = substr($chartXP, 0, -3) . "." . substr($chartXP, 2);
            break;
            case 6:
                // 123.456
                $chartNewXP = substr($chartXP, 0, -3) . "." . substr($chartXP, 3);
            break;
            case 7:
                // 1.234.567
                $chartNewXP = substr($chartXP, 0, 1) . "." . substr($chartXP, 1, -3) . "." . substr($chartXP, 4);
            break;
        }

        // Separar poderes (evitar errores si no hay todos los campos)
        $chartPowSep = explode("/", $chartPowers);

        // Helper para procesar un item de poderes y marcar * final si corresponde
        $procPower = function($val) {
            $val = (string)($val ?? '');
            if ($val === '') return '';
            // Si el último carácter es '*' lo mostramos con la clase changePower (quitamos el asterisco)
            if (substr($val, -1) === '*') {
                return "<span class='changePower'>" . htmlentities(substr($val, 0, -1)) . "</span>";
            }
            return htmlentities($val);
        };

        $powAtWill  = $procPower($chartPowSep[0] ?? '');
        $powEncounter= $procPower($chartPowSep[1] ?? '');
        $powDiary   = $procPower($chartPowSep[2] ?? '');
        $powUtility = $procPower($chartPowSep[3] ?? '');
?>
        <tr class="<?php echo htmlspecialchars($chartRow); ?>">
            <td><?php echo htmlspecialchars($chartLevel); ?></td>
            <td><?php echo htmlspecialchars($chartNewXP); ?></td>
            <td><?php echo $chartStats !== '' ? htmlspecialchars($chartStats) : ''; ?></td>
            <td><?php echo $chartGains !== '' ? htmlspecialchars($chartGains) : ''; ?></td>
            <td><?php echo $chartFeats !== '' ? htmlspecialchars($chartFeats) : ''; ?></td>
            <td class="atwill" title="A voluntad"><?php echo $powAtWill; ?></td>
            <td class="encounter" title="Encuentro"><?php echo $powEncounter; ?></td>
            <td class="diary" title="Diario"><?php echo $powDiary; ?></td>
            <td class="utility" title="Utilidad"><?php echo $powUtility; ?></td>
        </tr>
<?php
    } // fin while
?>
    </tbody>
</table>

<div class="levelChartFootNote">
    <p><b>NOTA</b>: además de los beneficios resumidos en esta tabla, siempre recibes más puntos de golpe cuando ganas un nuevo nivel. Consulta la
    descripción de tu clase de personaje para los detalles.</p>
    <p><b>&#8226;</b> En los niveles en el que el número de poderes aparece en amarillo, reemplazas un poder conocido por un nuevo poder de tu nuevo nivel.</p>
    <p><b>&#8224;</b> Los humanos ganan una dote adicional a nivel 1. Algunas clases también conceden dotes adicionales.</p>
</div>
<!-- Fin de la Tabla de progreso -->
<?php
} else {
    // No hay datos
    echo "<p>Ha habido un error. Revisa lo que has hecho o la tabla de niveles está vacía.</p>";
}
?>
