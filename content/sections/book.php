<?php
	$idGetData = $page ?? ""; // Cogemos datos del GET "page"
	// Consultar la ficha solo si se ha pedido un ID entero positivo.
	$requestedId = filter_var($idGetData, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
	$dataResult = false;
	if ($requestedId !== false) {
		$orderData = "SELECT * FROM ".$dydTableBestiary." WHERE id = ".$requestedId." LIMIT 1";
		$queryData = mysql_query($orderData, $link);
		if ($queryData && mysql_num_rows($queryData) > 0) {
			$dataResult = mysql_fetch_array($queryData);
		}
	}
	if ($dataResult !== false) {
		// ================================================================== //
		// Datos básicos de la Acción
			$monsterID		= $dataResult["id"]; 		// ID de la familia de Monstruos.
			$monsterName	= $dataResult["name"]; 		// Nombre de la familia de Monstruos.
			$monsterText	= $dataResult["infotext"];	// Informacion de la familia de monstruos.
			$monsterSkill	= $dataResult["skill"];		// Habilidad para conocer información.
			$monsterKnowl	= $dataResult["knowtext"];	// Tipo de la Acción.
		// ================================================================== //
		// Conseguimos datos del Origen
		include_once(__DIR__ . "/content_origin.php");
		// Conseguimos tarjetas de monstruo con la misma Familia
		include_once("book_getmonsters.php");
		// ================================================================== //
		// Localización para pestañas
		include_once("contents_tabs.php");
		// Sección principal
		$pageTitle3 = $monsterName;
		if ($originCanon != 0) {
		echo "<h2>".$monsterName."</h2>"; // Título de la Familia de Monstruos
		echo "<div id='info' class='tab_content'>";
			echo "<fieldset>"; // Cuerpo de la Información
				if ($monsterSkill !="") { echo "<legend>".$monsterSkill."</legend>"; }
				if ($monsterText != "") { echo "<p>".$monsterText."</p>"; }
				if ($monsterKnowl != "") { 
					echo "<h4>Conocimientos sobre ".$monsterName."</h4>";
					echo "<ul>".$monsterKnowl."</ul>"; 
				}
			echo "</fieldset>";
		echo "</div>";
		// Listado de Monstruos de esta Familia
		echo "<div id='monsters' class='tab_content'>";
			echo "<p>El bestiario contiene las siguientes criaturas de tipo <b>".$monsterName."</b>.</p>";
			$dataSearchSQL = "WHERE book LIKE ".$monsterID;
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydCreaturesFields." FROM ".$dydTableCreatures." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionCreatures[0];
			include("contents_list.php");
		echo "</div>"; 
		// Fin Hoja
		// ------------------------------------------------------------------ //
	echo "<br/>";
		} else {
			echo $phraseNoAuth;
		}
	} else {
		if ($idGetData !== "") {
			echo "<h3>Bestiario</h3><p>No se ha encontrado la familia de monstruos solicitada.</p>";
		} else {
		// ------------------------------------------------------------------ //
		echo "<h3>Bestiario</h3>";
			// Si tenemos datos del GET, hacemos cosas de SQL; si no, no hacemos nada
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydBestiaryFields." FROM ".$dydTableBestiary."";
				$dataSection	 = $dydSectionBestiary[0];
			include("contents_list.php");
		// ------------------------------------------------------------------ //
		}
	}
?>
