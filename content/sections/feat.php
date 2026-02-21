<?php
	// INICIO RECOLECCION DATOS
	if ($page != 0) {
	// ================================================================== //
		echo "<div id='powerItemLayout'>";
			$featId = $page; // Damos la id del dato.
			include (__DIR__ . "/feat_card.php");
			$pageTitle3 = $featName;
		echo "</div>";
	// ================================================================== //
		if ($featPower > 0) { $powerId = $featPower; echo "<div id='powerItemLayout'>"; include ("power_card.php"); echo "</div>"; }
		// Finalizamos la configuración del enlace de vuelta
		switch ($returnData) {
			case "General":	// General
				$returnBackSection = "general/";
			break;
			case "Racial":	// Racial
				$returnBackSection = "racial/";
			break;
			case "Clásea":	// Dote de clase
				$returnBackSection = "class/";
			break;
			case "Multiclase":	// Dote multiclase
				$returnBackSection = "multiclass/";
			break;
			case "Divina":	// Dote divina
				$returnBackSection = "divine/";
			break;
		}
		// Localización para pestañas
			$locTab = $returnData;
			switch($locTab) {
				case "General":
				case "Racial":
					$locTab = $locTab."es";
				break;
				case "Clásea":
				case "Divina":
					$locTab = $locTab."s";
				break;
			}
			include_once("contents_tabs.php");
		// Configuramos el enlace a la clase
			include_once("content_classlink.php");
		// Fin Hoja
		// ------------------------------------------------------------------ //
	echo "<br/>";
	/*	} else {
			echo $phraseNoAuth;
		}*/
	} else {
		// ------------------------------------------------------------------ //
			switch($typItem) {
				case "general":
					$featWhereTerm = "General";
					$featTitle = "Dotes generales";
				break;
				case "multiclass":
					$featWhereTerm = "Multiclase";
					$featTitle = "Dotes multiclase";
				break;
				case "divine":
					$featWhereTerm = "Divina";
					$featTitle = "Dotes divinas";
				break;
				case "class":
					$featWhereTerm = "Clásea";
					$featTitle = "Dotes de clase";
				break;
				case "racial":
					$featWhereTerm = "Racial";
					$featTitle = "Dotes raciales";
				break;
				default:
					$featWhereTerm = "";
					$featTitle = "Listado de dotes";				
			}
			// Si tenemos datos del GET, hacemos cosas de SQL; si no, no hacemos nada
			if ($typItem !="") { 
				$featWhereOption = "WHERE type LIKE '".$featWhereTerm."'"; 
			} else {
				$featWhereOption = "WHERE name NOT LIKE ''";
			}
			// Datos de sesión
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydFeatsFields." FROM ".$dydTableFeats." ".$featWhereOption."";
			// Localización para pestañas
			if ($featWhereTerm != "") {
				$locTab = "K"; // Le damos un valor para que no de la murga
				$tabName = $featWhereTerm;
				switch($tabName) {
					case "General":
					case "Racial":
						$tabName = $tabName."es";
					break;
					case "Clásea":
					case "Divina":
						$tabName = $tabName."s";
					break;
				}
				include_once("contents_tabs.php");		
			}
			// ---------->
		echo "<h3>".$featTitle."</h3>";
			$dataSection = $dydSectionFeats[0];
			include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>
