<?php
	if ($page != 0) {
	// ================================================================== //
		echo "<div id='powerItemLayout'>";
			$powerId = $page; // Damos la id del dato.
			include ("power_card.php");
			$pageTitle3 = $powerName;
		echo "</div>";
	// ================================================================== //
	echo "<br/>";
	// Configuramos el enlace de vuelta
	switch ($powerType1) {
		// Utilidad
		case 1:
		case 11:
			$returnBackSection = "utility/";
		break;
		// Resto de poderes
		default:
			switch ($powerType2) {
				case "A voluntad": // At will
					$returnBackSection = "atwill/";
				break;
				case "Encuentro": // Encounter
					$returnBackSection = "encounter/";
				break;
				case "Diario": // Diary
					$returnBackSection = "daily/";
				break;
			}
		break;
	}
	// Finalizamos la configuración del enlace de vuelta
		// Localización para pestañas
		if ($powerType1 == 1 OR $powerType1 == 11) { $locTab = "Utilidad"; } else { $locTab = $powerType2; if ($powerType2 == "Diario") { $locTab = $locTab."s"; } }
		include_once("contents_tabs.php");
		// Configuramos el enlace a la clase
		include_once("content_classlink.php");
	} else {
		// ------------------------------------------------------------------ //
			switch($typItem) {
				case "atwill":
					$powerTypeTitle = "A voluntad";
					$dataTypeTerms = "WHERE type LIKE 'A voluntad' AND powertype NOT LIKE 11 AND powertype NOT LIKE 1";
				break;
				case "encounter":
					$powerTypeTitle = "Encuentro";
					$dataTypeTerms = "WHERE type LIKE 'Encuentro' AND powertype NOT LIKE 11 AND powertype NOT LIKE 1";
				break;
				case "daily":
					$powerTypeTitle = "Diarios";
					$dataTypeTerms = "WHERE type LIKE 'Diario' AND powertype NOT LIKE 11 AND powertype NOT LIKE 1";
				break;
				case "utility":
					$powerTypeTitle = "Utilidad";
					$dataTypeTerms = "WHERE powertype LIKE 11 OR powertype LIKE 1";
				break;
				default:
					$powerTypeTitle = "Listado de poderes";
					$dataTypeTerms = "WHERE name NOT LIKE ''";
				break;
			}
		// Si tenemos subtipos, dividir las cosas
			//if ($typSubType != "") { $dataTypeTerms = $dataTypeTerms." AND class LIKE '$typSubType'"; }
		// Localización para pestañas
		if ($powerTypeTitle != "Listado de poderes") {
			$locTab = "K"; // Le damos un valor para que no de la murga
			$tabName = $powerTypeTitle;
			include_once("contents_tabs.php");
				switch($powerTypeTitle) {
					case "Encuentro":
					case "Utilidad":
						$powerTypeTitle = "de ".$powerTypeTitle;
					break;
				}
				$powerTypeTitle = "Poderes ".strtolower($powerTypeTitle);
		}
		// ---------->
		echo "<h3>".$powerTypeTitle."</h3>";
			$dataSearchTerms = "SELECT ".$dydBasicFields.", class, level, type, attack, origin FROM ".$dydTablePowers." ".$dataTypeTerms."";
			$dataSection	 = $dydSectionPowers[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>