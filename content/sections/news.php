<?php
    $idGetData = $page; // Cogemos datos del GET "page"

    // Elegimos el Objeto en la Base de Datos
    $orderData = "SELECT * FROM $dydTableUpdates WHERE $pageField LIKE ? LIMIT 1";

    // Ejecutar consulta preparada
    $stmt = mysqli_prepare($link, $orderData);
    mysqli_stmt_bind_param($stmt, "s", $idGetData);
    mysqli_stmt_execute($stmt);
    $queryData = mysqli_stmt_get_result($stmt);

    $rowsData = mysqli_num_rows($queryData);

    if ($rowsData > 0) { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
        $dataResult = mysqli_fetch_assoc($queryData); // Recolectamos los datos
        // ================================================================== //
        // Datos básicos del Objeto
        $newsName   = $dataResult["name"];      // Nombre de la actualización.
        $newsDate   = $dataResult["date"];      // Fecha de la actualización.
        $newsText   = $dataResult["infotext"];  // Contenido de la noticia.
        $newsAuthor = $dataResult["uploader"];  // Autor de la noticia.
        // ================================================================== //
        // Sección principal
        $pageTitle3 = $newsName;
        // Localización para pestañas
        include_once("contents_tabs.php");
        // Preparar el nombre del Autor
        $dataListAuthor = $newsAuthor;
        $retrieveFrom   = "author";
        include_once("retrieve_origin.php");
        // ================================================================== //
        echo "<h2>".$newsName."</h2>"; // Título del Rasgo
        echo "<div class='newsBlock'>";
            echo "<fieldset>";
                echo "<legend>".$authorName."</legend>";
                if (!empty($newsDate)) { echo "<p style='float:right;font-style:italic;margin-right:6px;'>".$newsDate."</p>"; }
                if (!empty($newsText)) { echo "<p>".$newsText."</p>"; }
            echo "</fieldset>";
        echo "</div>";
        echo "<br/>";
        // ================================================================== //
    } else {
        // ------------------------------------------------------------------ //
        // Listado de Noticias
        include_once("contents_tabs.php");
        // Datos de sesión
        $dataSearchTerms = "SELECT $dydBasicFields, $dydUpdatesFields FROM $dydTableUpdates";
        // Mostramos las actualizaciones
        echo "<h3>Actualizaciones de Ad Infinitum</h3>";
        $dataSection = $dydSectionUpdates[0];
        include("contents_list.php");
        // ------------------------------------------------------------------ //
    }

    // Liberar recursos
    mysqli_stmt_close($stmt);
?>
