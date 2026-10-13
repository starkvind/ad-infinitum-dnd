<?php
	$idGetData = $page ?? ""; // Cogemos datos del GET "page"
	// Consultar la ficha solo si se ha pedido un ID entero positivo.
	$requestedId = filter_var($idGetData, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
	$dataResult = false;
	if ($requestedId !== false) {
		$orderData = "SELECT * FROM ".$dydTableActions." WHERE id = ".$requestedId." LIMIT 1";
		$queryData = mysql_query($orderData, $link);
		if ($queryData && mysql_num_rows($queryData) > 0) {
			$dataResult = mysql_fetch_array($queryData);
		}
	}
	if ($dataResult !== false) {
		// ================================================================== //
		// Datos básicos de la Acción
			$actionName	 	 = $dataResult["name"]; 		// Nombre de la Acción.
			$actionSkill	 = $dataResult["skill"];		// Habilidad de la Acción.
			$actionType		 = $dataResult["type"];			// Tipo de la Acción.
			$actionFlavor 	 = $dataResult["flavortext"];	// Texto de la Acción.
			$actionText		 = $dataResult["infotext"];		// Informacion de la Acción.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
		// Localización para pestañas
		include_once("contents_tabs.php");
		// Sección principal
		$pageTitle3 = $actionName;
		if ($originCanon != 0) {
		echo "<h2>".$actionName."</h2>"; // Título de la Acción
		echo "<fieldset>"; // Cuerpo de la Acción
			if ($actionSkill !="") { echo "<legend>".$actionSkill."</legend>"; }
			if ($actionFlavor != "") { echo "<p>".$actionFlavor."</p>"; }
			if ($actionText != "") { 
				echo "<h4>".$actionName.": ".$actionType."</h4>";
				echo "<ul>".$actionText."</ul>"; 
			}
		echo "</fieldset>";
		// Fin Hoja
		// ------------------------------------------------------------------ //
	echo "<br/>";
		} else {
		if ($idGetData !== "") {
			echo "<h3>Acciones</h3><p>No se ha encontrado la acción solicitada.</p>";
		} else {
			echo $phraseNoAuth;
		}
	} else {
		// ------------------------------------------------------------------ //
		echo "<h3>Lista de acciones</h3>";
			// Mostramos la lista de acciones 
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydActionsFields." FROM ".$dydTableActions."";
			$dataSection	 = $dydSectionActions[0];
			include("contents_list.php");
		// ------------------------------------------------------------------ //
		}
	}
?>
