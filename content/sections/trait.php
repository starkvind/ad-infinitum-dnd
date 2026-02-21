<?php
	if ($page != 0) {
	// ================================================================== //
		echo "<div id='powerItemLayout'>";
			$traitId = $page; // Damos la id del dato.
			include (__DIR__ . "/trait_card.php");
			$pageTitle3 = $traitName;
		echo "</div>";
		// Localización para pestañas
			include_once(__DIR__ . "/contents_tabs.php");
		// Configuramos el enlace a la clase
			include_once(__DIR__ . "/content_classlink.php");
		echo "<br/>";
		// ================================================================== //
	} else {
	// ------------------------------------------------------------------ //
	// Listado de Rasgos:												  //
		switch($typItem) {
			case "race":	// Raciales
				$traitTitle = "Raciales";
				$traitSubti = "Rasgos";
				$searchTerms = array('Aura','Defensa','Origen','Pasiva','Racial','Salvaciones');
			break;
			case "class":	// Clases
				$traitTitle = "Cláseos";
				$traitSubti = "Rasgos";
				$searchTerms = array('Clase','Poder','Rasgo');
			break;
			case "paragon":	// Senda de Parangón
				$traitTitle = "Senda de parangón";
				$traitSubti = "Rasgos de la";
				$searchTerms = array('Parangón');
			break;
			case "epic":	// Destino épico
				$traitTitle = "Destino épico";
				$traitSubti = "Rasgos del";
				$searchTerms = array('Épico');
			break;
			case "theme":	// Temas de Personaje
				$traitTitle = "Tema de personaje";
				$traitSubti = "Rasgos del";
				$searchTerms = array('Tema');
			break;
			case "essentials":	// Temas de Personaje
				$traitTitle = "Essentials";
				$traitSubti = "Rasgos de";
				$searchTerms = array('Essentials');
			break;
			default:		// Listado de rasgos
				$traitTitle = "Rasgos";
				$traitSubti = "Listado de";
				$searchTerms = "";
			break;
		}
		// Si no tenemos sección, colocamos un SQL estándar
		if ($searchTerms != "") {
			$dataSearchSQL = "WHERE type IN('".implode("', '", $searchTerms)."')";
		} else {
			$dataSearchSQL = "WHERE name NOT LIKE ''";
		}
		// Localización para pestañas
		if ($traitTitle != "Rasgos") {
			$tabName = $traitTitle;
			if ($locTab == "") { $locTab = "K"; }
			include_once("contents_tabs.php");
		}
		// ------------------------->
		// ------------------------->
		echo "<h3>".$traitSubti." ".strtolower($traitTitle)."</h3>";
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydTraitsFields." FROM ".$dydTableTraits." ".$dataSearchSQL.""; //
			$dataSection	 = $dydSectionTraits[0];
			include(__DIR__ . "/contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>
