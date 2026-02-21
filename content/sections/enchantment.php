<?php
	if ($page != 0) {
	// ================================================================== //
		echo "<div id='powerItemLayout'>";
			$enchantId = $page; // Damos la id del dato.
			include ("enchantment_card.php");
			$pageTitle3 = $enchantName;
		echo "</div>";
	// ================================================================== //
	echo "<br/>";
	// Configuramos el enlace de vuelta
	switch ($enchantBdType) {
		case "Consumible": // Consumibles
			$returnBackSection = "consumables/";
			$titleName = "Consumible";
		break;
		case "Arma": // Armas
			$returnBackSection = "weapons/";
			$titleName = "Arma";
		break;
		case "Armadura": // Armaduras
			$returnBackSection = "armors/";
			$titleName = "Armadura";
		break;
		case "Accesorio": // Accesorios
			$returnBackSection = "trinkets/";
			$titleName = "Accesorio";
		break;
		case "Utensilio": // Utensilios
			$returnBackSection = "implements/";
			$titleName = "Utensilio";
		break;
	}
	// Finalizamos la configuración del enlace de vuelta
	if ($titleName != "") { $pageTitle2 = $titleName; }
		// Localización para pestañas
		include_once("contents_tabs.php");
		// ================================================================== //
	} else {
	// ------------------------------------------------------------------ //
	// Listado de Encantamientos:
			switch($typItem) {
				case "consumables":
					$dataSearchSQL = "WHERE bd_type LIKE 'Consumible'";
					$enchantTitle = "Consumibles";
					$changeTitle2 = TRUE;
				break;
				case "weapons":
					$dataSearchSQL = "WHERE bd_type LIKE 'Arma'";
					$enchantTitle = "Armas";
					$changeTitle2 = TRUE;
				break;
				case "armors":
					$dataSearchSQL = "WHERE bd_type LIKE 'Armadura'";
					$enchantTitle = "Armaduras";
					$changeTitle2 = TRUE;
				break;
				case "trinkets":
					$dataSearchSQL = "WHERE bd_type LIKE 'Accesorio'";
					$enchantTitle = "Accesorios";
					$changeTitle2 = TRUE;
				break;
				case "implements":
					$dataSearchSQL = "WHERE bd_type LIKE 'Utensilio'";
					$enchantTitle = "Utensilios";
					$changeTitle2 = TRUE;
				break;
				default:
					$dataSearchSQL = "WHERE name NOT LIKE ''";
					$enchantTitle = "Lista de encantamientos";
					$changeTitle2 = FALSE;
				break;
			}
		if ($changeTitle2 != FALSE) { $pageTitle3 = $enchantTitle; }
		// Localización para pestañas
		if ($enchantTitle != "Lista de encantamientos") {
			$locTab = "K"; // Le damos un valor para que no de la murga
			$tabName = $enchantTitle;
			include_once("contents_tabs.php");
		}
		// ---------->
		// Datos de sesión
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydEnchantsFields." FROM ".$dydTableEnchants." ".$dataSearchSQL; //
		// Mostramos los encantamientos
		echo "<h3>".$enchantTitle."</h3>";
			$dataSection	 = $dydSectionEnchants[0];
			include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>