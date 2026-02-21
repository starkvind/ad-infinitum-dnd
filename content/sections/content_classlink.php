<?php
$originCanon = $originCanon ?? 0;
$powerClass  = $powerClass  ?? "";
$featClass   = $featClass   ?? "";
$bgClass     = $bgClass     ?? "";
$buildClass  = $buildClass  ?? "";
$traitClass  = $traitClass  ?? "";
$powerType1  = isset($powerType1) ? (int)$powerType1 : -1;
$returnData  = $returnData  ?? "";
$locTab      = $locTab      ?? "";
$linkKind    = -1;
$linkClass   = 0;
$linkName    = "";
if ($originCanon != 0) {
	// Configuración de enlace a la Raza o Clase desde tarjeta de Poder
	// -->
	// ¿Poder o que?
	if ($powerClass != "") { $linkKind = 0; } // Poder
	elseif ($featClass  != "") { $linkKind = 1; } // Dote
	elseif ($bgClass	!= "") { $linkKind = 2; } // Trasfondo
	elseif ($buildClass	!= "") { $linkKind = 3; } // Diseño
	elseif ($traitClass	!= "") { $linkKind = 4; } // Rasgos
	// -->
	switch ($linkKind) {
		case 0: // Poderes
			$linkName = $powerClass;
			// Comprobamos qué tipo de poder es
			switch ($powerType1) {
				case 0:
				case 1:
					$linkClass = 1; // Raza
					$linkTable = $dydTableRaces;
					$linkSection = $dydSectionRaces[0];
				break;
				case 10:
				case 11:
				case 12:
					$linkClass = 2; // Clase
					$linkTable = $dydTableClasses;
					$linkSection = $dydSectionClasses[0];
				break;
				default:
					$linkClass = 0; // Poder no asociado a Raza o Clase
				break;
			}
		break;
		case 1: // Dotes
			$linkName = $featClass;
			// Comprobamos qué tipo de poder es
			switch ($returnData) {
				case "Racial":
					$linkClass = 1; // Raza
					$linkTable = $dydTableRaces;
					$linkSection = $dydSectionRaces[0];
				break;
				case "Clásea":
					$linkClass = 2; // Clase
					$linkTable = $dydTableClasses;
					$linkSection = $dydSectionClasses[0];
				break;
				default:
					$linkClass = 0; // Dote no asociada a Raza o Clase
				break;
			}
		break;
		case 2: // Trasfondos
			$linkName = $bgClass;
			// Comprobamos qué tipo de poder es
			switch ($locTab) {
				case "Raciales":
					$linkClass = 1; // Raza
					$linkTable = $dydTableRaces;
					$linkSection = $dydSectionRaces[0];
				break;
				default:
					$linkClass = 0; // Dote no asociada a Raza o Clase
				break;
			}
		break;
		case 3: // Diseños
			$linkName = $buildClass;
			// Asignamos datos al diseño
			$linkClass = 2; // Clase
			$linkTable = $dydTableClasses;
			$linkSection = $dydSectionClasses[0];
		break;
		case 4: // Rasgos
			$linkName = $traitClass;
			// Asignamos datos al diseño
			switch ($locTab) {
				case "Raciales":
					$linkClass = 1; // Raza
					$linkTable = $dydTableRaces;
					$linkSection = $dydSectionRaces[0];
				break;
				default:
					$linkClass = 2; // Clase
					$linkTable = $dydTableClasses;
					$linkSection = $dydSectionClasses[0];
				break;
			}
		break;
	}
	// Si tenemos datos sobre si es Raza o Clase, procedemos a configurar el enlace
	if ($linkClass != 0 && $linkName != "") {
		$orderLink ="SELECT id FROM ".$linkTable." WHERE name LIKE '".$linkName."' LIMIT 1;"; // Elegimos la Raza en la Base de Datos
		$queryLink = mysql_query ($orderLink, $link);
		$rowsLink = mysql_num_rows($queryLink);	
		if ($rowsLink != 0) { 
			$linkResult = mysql_fetch_array($queryLink);
			$linkId 	= $linkResult["id"]; // ID de la Raza o Clase.
			$powerLink = "<a href='".$pageRoot.$linkSection."/".$linkId."/'>".$linkName."</a>";
		}
	}
}
?>
