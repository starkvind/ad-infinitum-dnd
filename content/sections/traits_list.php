<?php
	// ----------------------------------->
	// Listado de rasgos para Raza o Clase
	// ----------------------------------->
	// Preparamos la "Clase"
	if ($raceName != "") { $sectionName = $raceName; }
	if ($className != "") { $sectionName = $className; }
	// Definimos los ID de los rasgos
	if ($raceTraits == "") { $raceTraits = 0; }
	// Sentencia SQL para los rasgos automáticos
	$traitTerms = "SELECT id, name, level, infotext, choosetext FROM ".$dydTableTraits." WHERE class LIKE '".$sectionName."' OR id IN (".$raceTraits.") ORDER BY type";
	$traitIdQuery = mysql_query($traitTerms, $link);
	$traitRows = mysql_num_rows($traitIdQuery);
	if ($traitRows != 0) {
		if ($pageTitle2 == "Raza") { 
			// Raza - Inicio de lista de rasgos
			echo "<ul>"; 
		}
		// Rasgos automáticos
		for($tr=0;$tr<$traitRows;$tr++) {
			$traitResult = mysql_fetch_array($traitIdQuery);
			$traitName = $traitResult["name"];
			$traitText1 = $traitResult["infotext"];
			$traitText2 = $traitResult["choosetext"];
			switch($pageTitle2) {
				case "Raza":
					echo "<li><b>".$traitName.":</b> ".$traitText1."</li>";
					if ($traitText2 != "") { echo "<li class='raceChooseText'>".$traitText2."</li>"; }
				break;
			}
		}
		if ($pageTitle2 == "Raza") {
			// Poderes de utilidad
			$utilityPowers = "SELECT id, name, level FROM ".$dydTablePowers." WHERE class LIKE '".$sectionName."' AND powertype LIKE 1";
			$utilityIdQuery = mysql_query($utilityPowers, $link);
			$utilityRows = mysql_num_rows($utilityIdQuery);
			if ($utilityRows > 0) {
				echo "<li><b>Poderes de utilidad:</b> ";
					echo "desde el nivel 2, siempre que ganes algún poder de utilidad de tu clase, puedes escoger no obtenerlo y elegir un poder de utilidad de ".strtolower($sectionName)." en su lugar.";
				echo "</li>";
			}
			// Raza - Fin de lista de rasgos
			echo "</ul>"; 
		}
	}
?>