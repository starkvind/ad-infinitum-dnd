<?php
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableActions." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos la Acción en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
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
?>
