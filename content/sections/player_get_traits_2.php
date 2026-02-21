<?php
	$traitQuery 	= "SELECT ".$dydBasicFields.", infotext, choosetext, level, bd_bonus FROM ".$dydTableTraits." ".$traitTerms."";
	$traitIdQuery 	= mysql_query($traitQuery, $link);
	$traitRows 		= mysql_num_rows($traitIdQuery);
	// Si tenemos alguna columna, procedemos.
	if ($traitRows > 0) {
		for($ptl=0;$ptl<$traitRows;$ptl++) {
			$showChoiceTrait 		= ""; // Quitamos la elección por si acaso.
			$traitQueryResult 		= mysql_fetch_array($traitIdQuery);
			$traitListID 			= $traitQueryResult["id"];
			$traitListName 			= $traitQueryResult["name"];
			$traitListText 			= $traitQueryResult["infotext"];
			$traitListLevel 		= $traitQueryResult["level"];
			$traitListBonus[$ptl] 	= $traitQueryResult["bd_bonus"];	// Añadimos la bonificación a la lista de bonus
			$traitListChoText 		= $traitQueryResult["choosetext"];
			// Comparamos si nuestra variable está en el array
			if (count($playerTraitChoice) > 1) {
				for($arrayTraitCounter=0;$arrayTraitCounter<count($playerTraitChoice);$arrayTraitCounter++) {
					$checkArrayTrait = explode(":", $playerTraitChoice[$arrayTraitCounter]);
					// Si la ID que hemos metido en el campo Traits del Personaje coincide con una de las IDs que tenemos, mostraremos el campo adecuado.
					if ($checkArrayTrait[0] == $traitListID) {
						//echo "Aquí hay algo! (".$traitListName.")";
						$showChoiceTrait = $checkArrayTrait[1];
						// Si tenemos más para enseñar (como lo del Artifice), lo preparamos.
						if ($checkArrayTrait[2] != "") {
							$showChoiceMore = $checkArrayTrait[2];
						}
					}
				}
			}
			// Comparamos si tenemos el mismo nivel o más que el rasgo 
			if ($playerLevel < $traitListLevel) {
				$showChoiceTrait = "no"; // Si no tenemos nivel suficiente, no lo enseñamos.
			}
			// Si hemos colocado que tal rasgo no se muestre, no se mostrará.
			if ($showChoiceTrait != "no") {
				echo "<p>";
				// Preparamos el paréntesis.
				if ($showChoiceTrait != "" AND !is_numeric($showChoiceTrait)) { $extraTraitName = " (".$showChoiceTrait.")"; } else { $extraTraitName = ""; }
				// Preparamos el título.
				$traitNameLink = "<a href='".$pageRoot.$dydSectionTraits[0]."/".$traitListID."/' target='_blank'><b>".$traitListName."".$extraTraitName.":</b></a>";
				if ($showChoiceTrait != "" AND is_numeric($showChoiceTrait)) {
					$traitTextToShow = explode("<br />", $traitListChoText);
					// Si tenemos más para enseñar (como lo del Artifice), lo enseñamos.
					if ($showChoiceMore != "") {
						// Primero colocamos el título.
						echo $traitNameLink;
						// Luego la descripción.
						echo " ".$traitListText;
						// La primera parte para elegir (que ya la tenemos)
						echo $traitTextToShow[$showChoiceTrait];
						// Un salto de línea
						echo "<br />";
						// La segunda parte para elegir (que ya la tenemos)
						echo $traitTextToShow[$showChoiceMore];
					} else {
						// Mostramos solo la elección que tenemos.
						echo $traitTextToShow[$showChoiceTrait];
					}
				// Si no tenemos texto de elección a poner, ponemos el texto estándar.
				} else {
					// Primero colocamos el título.
					echo $traitNameLink;
					// Si tenemos texto de elección pero no es un valor numérico (para elegir entre rasgos de clase), suponemos que es texto decorativo.
					echo " ".$traitListText;
				}
				echo "</p>";
			}
		}
	}
?>