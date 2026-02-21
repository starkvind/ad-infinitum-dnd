<?php
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableRaces." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos la Raza en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	$noAbilityRaces = array(11,22,34);
	$noTraitRaces = array(22);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del personaje
			$raceId 	 	 = $dataResult["id"]; 			// ID de la Raza.
			$raceName 	 	 = $dataResult["name"]; 		// Nombre de la Raza.
			$raceFlavor		 = $dataResult["flavortext"];	// Una línea que describe la Raza.
			$raceHeight	 	 = $dataResult["height"]; 		// Altura de la Raza.
			$raceWeight	 	 = $dataResult["weight"]; 		// Peso de la Raza.
			$raceAbilities	 = $dataResult["abilities"];	// Bonus.
			$raceSize		 = $dataResult["size"]; 		// Tamaño de la Raza.
			$raceSpeed		 = $dataResult["speed"]; 		// Velocidad del Raza.
			$raceVision		 = $dataResult["vision"];	 	// Visión (normal, en penumbra o en la oscuridad) de la Raza.
			$raceLanguages	 = $dataResult["languages"]; 	// Idiomas de base de la Raza.
			$raceSkillbonus	 = $dataResult["skillbonus"]; 	// Bonificadores de habilidad de la Raza.
			$raceMiscText	 = $dataResult["misctext"];	 	// Texto misceláneo. Utilizado en algunas razas para indicar información.
			$raceTraits		 = $dataResult["traits"];	 	// Rasgos adicionales de la Raza.
			$raceFeats		 = $dataResult["feats"];	 	// Dotes adicionales de la Raza.
			$raceInfo1		 = $dataResult["info1"];	 	// Introducción de la Raza.
			$raceInfo2		 = $dataResult["info2"]; 		// Características físicas de la Raza.
			$raceInfo3		 = $dataResult["info3"];	 	// Cómo jugar con la Raza.
			$raceCharacter	 = $dataResult["character"]; 	// Texto escrito que habla sobre el personaje.
			$raceMaleName	 = $dataResult["mname"];	 	// Nombres masculinos de la Raza.
			$raceFemName	 = $dataResult["fname"]; 		// Nombres femeninos de la Raza.
			$raceImage		 = $dataResult["image"];		// Imagen de la raza.
			$raceOriginText  = $dataResult["origintext"];	// Texto sobre el origen de la raza.
			$raceKind		 = $dataResult["kind"]; 		// Si la raza es canon o no.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
		if ($originCanon != 0) {
		$pageTitle2 = "Raza";
		$pageTitle3 = $raceName;
		// Localización para pestañas
		include_once("contents_tabs.php");
		// ================================================================== //
		echo "<h2>".$raceName."</h2>"; // Título de la Raza
		echo "<p style='font-style:italic;'>".$raceFlavor."</p>";
		echo "<div class='tab_container'>"; // <=== Inicio Div de Tabs
		// ------------------------------------------------------------------ //
		// TAB 01 - INFORMACION
		// ------------------------------------------------------------------ //
			echo "<div id='info' class='tab_content'>"; // <=== Contenido del TAB 1
			include_once("origin_icon.php");
			// Primer Fieldset - Rasgos Raciales
			// ------------------------------------------------------------------ //
			echo "<img src='".$dydRaceImgPath.$raceImage.$dydRaceImgExt."' />";
			echo "<fieldset style='text-align:left;'>"; 
				echo "<legend>Rasgos raciales</legend>";
				// Aspecto fisico
				if ($raceHeight != "" && $raceWeight != "") {
					echo "<ul>"; 
						echo "<li><b>Altura:</b> ".$raceHeight."</li>"; 
						echo "<li><b>Peso:</b> ".$raceWeight."</li>"; 
					echo "</ul>";
				}
				// Stats
				echo "<ul>";
				// Si no está en blanco, empezamos a cambiar los datos
				if ($raceAbilities != "") {
					$checkRaceBonus = explode("/", $raceAbilities);
					$raceAbilitiesArray = array($checkRaceBonus[0], $checkRaceBonus[1], $checkRaceBonus[2]);
					// -->
					// Cambiamos el nombre de HAB a Habilidad
					for($i=0;$i<count($raceAbilitiesArray);$i++) {
						switch($raceAbilitiesArray[$i]) {
							case "FUE":
								$raceAbilitieBonus[$i] = "Fuerza";
							break;
							case "CON":
								$raceAbilitieBonus[$i] = "Constitución";
							break;
							case "DES":
								$raceAbilitieBonus[$i] = "Destreza";
							break;
							case "INT":
								$raceAbilitieBonus[$i] = "Inteligencia";
							break;
							case "SAB":
								$raceAbilitieBonus[$i] = "Sabiduría";
							break;
							case "CAR":
								$raceAbilitieBonus[$i] = "Carisma";
							break;
						}
					}
					// Cerramos el FOR
					// ->
					if ($checkRaceBonus[2] != "") {
						$raceAbilities = "+2 a ".$raceAbilitieBonus[0].", a elegir entre +2 a ".$raceAbilitieBonus[1]." o +2 a ".$raceAbilitieBonus[2]."";
					} else if ($raceAbilities == "1HUMANO"){ 
						$raceAbilities = "+2 a una característica de tu elección";
					} else {
						$raceAbilities = "+2 a ".$raceAbilitieBonus[0].", +2 a ".$raceAbilitieBonus[1]."";
					}
					// Si el ID de la raza está en nuestro array de no mostrar nada, no le mostramos nada.
					if (!in_array($raceId, $noAbilityRaces)) { echo "<li><b>Puntuaciones de característica:</b> ".$raceAbilities."</li>"; }
				}
				// Fin de las puntuaciones de Característica.
					echo "<li><b>Tamaño:</b> ".$raceSize."</li>";
					echo "<li><b>Velocidad:</b> ".$raceSpeed." casillas</li>";
					echo "<li><b>Visión:</b> ".$raceVision."</li>";
				echo "</ul>";
				// Idiomas
				echo "<ul>"; 
					if ($raceLanguages != "") { echo "<li><b>Idiomas:</b> ".$raceLanguages."</li>"; }
					if ($raceSkillbonus != "") { echo "<li><b>Bonificadores de habilidad:</b> ".$raceSkillbonus."</li>"; }
				echo "</ul>";
				// Random info
				if ($raceMiscText != "") { echo $raceMiscText; }
				if (!in_array($raceId, $noTraitRaces)) { include_once("traits_list.php"); }
			echo "</fieldset>";
			// ------------------------------------------------------------------ //
			// Segundo Fieldset - Información de la clase
			// ------------------------------------------------------------------ //
			echo "<p>".$raceInfo1."</p>";
			// ------------------------------------------------------------------ //
			// Tercer Fieldset - Caracteristicas fisicas
			// ------------------------------------------------------------------ //
			echo "<fieldset>";
				echo "<legend>Características físicas</legend>";
				echo $raceInfo2;
			echo "</fieldset>";
			// ------------------------------------------------------------------ //
			echo "<br/>";
			// Cuarto Fieldset - Como jugar con la raza
			// ------------------------------------------------------------------ //
			echo "<fieldset>";
				echo "<legend>Cómo jugar con un ".$raceName."</legend>";
				echo $raceInfo3;
				// Ultimos datos
				if ($raceCharacter != "") { echo "<p><b>Características:</b> ".$raceCharacter.".</p>"; }
				if ($raceMaleName != "" && $raceFemName != "") {
					echo "<p><b>Nombres de varón:</b> ".$raceMaleName.".</p>";
					echo "<p><b>Nombres de mujer:</b> ".$raceFemName.".</p>";
				} else {
					echo "<p><b>Nombres sugeridos:</b> ".$raceMaleName.".</p>";
				}
			echo "</fieldset>";
			echo "</div>"; // <=== Fin del TAB 1
		// ------------------------------------------------------------------ //
		// TAB 02 - PODERES Y DOTES
		// ------------------------------------------------------------------ //
			echo "<div id='powers' class='tab_content'>"; // <=== Contenido del TAB 2
		// Quinto Fieldset - Poderes
			// Poderes de la raza
			$dataField = "id, name, class, level, type, attack, origin";
			$dataSearchTerms = "SELECT ".$dataField." FROM ".$dydTablePowers." WHERE class LIKE '".$raceName."'";
			$dataSection	 = $dydSectionPowers[0];
			// ------------------- >
			// Mostrar los Poderes de la Raza
			// ------------------- >
			include("race_class_content.php");
			if ($dataRows != 0) { 
				echo "<fieldset class='noInfoLink'>";
					echo "<h3 class='powerTitle'>Poderes de ".$raceName."</h3>";
					include("contents_list.php"); 
				echo "</fieldset>";
			}
			$powerRows = $dataRows; // Comprobar poderes
			// ------------------- >
			// Salto de línea 1
			if ($powerRows != 0) { echo "<br />"; }
		// Sexto Fieldset - Dotes
			// Dotes de la raza
			$dataField = "id, name, class, tier, origin";
			if ($raceFeats != "") {
				$raceHasFeats = "OR id IN (".$raceFeats.")";
			}
			$dataSearchTerms = "SELECT ".$dataField." FROM ".$dydTableFeats." WHERE class LIKE '".$raceName."' ".$raceHasFeats." AND type NOT LIKE 'Multiclase'";
			$dataSection	 = $dydSectionFeats[0];
			// ------------------- >
			// Mostrar las Dotes de la Raza
			// ------------------- >
			include("race_class_content.php");
			if ($dataRows != 0) {
			// Salto de línea 2
				if ($powerRows != 0) { echo "<br />"; }
				echo "<fieldset class='noInfoLink'>";
					echo "<h3 class='powerTitle'>Dotes de ".$raceName."</h3>";
					include("contents_list.php"); 
				echo "</fieldset>";
			}
			$featRows = $dataRows; // Comprobar dotes
			// ------------------- >
			echo "</div>"; // <=== Fin del TAB 2
		// ------------------------------------------------------------------ //
		// TAB 03 - TRASFONDOS
		// ------------------------------------------------------------------ //
			echo "<div id='backgrounds' class='tab_content'>"; // <=== Contenido del TAB 3
		// Séptimo Fieldset - Trasfondos
			// Trasfondos de la raza
			$dataField = "id, name, class, skills, origin";
			$dataSearchTerms = "SELECT ".$dataField." FROM ".$dydTableBackgrounds." WHERE class LIKE '".$raceName."'";
			$dataSection	 = $dydSectionBackgrounds[0];
			// ------------------- >
			// Mostrar los Trasfondos de la Raza
			// ------------------- >
			include("race_class_content.php");
			if ($dataRows != 0) { 
				echo "<fieldset class='noInfoLink'>";
					echo "<h3 class='powerTitle'>Trasfondos de ".$raceName."</h3>";
					include("contents_list.php"); 
				echo "</fieldset>";
			}
			$bgRows = $dataRows; // Comprobar trasfondos
			// ------------------- >
			echo "</div>"; // <=== Fin del TAB 3
		// ------------------------------------------------------------------ //
	// Fin Hoja
	echo "</div>";
	echo "<br />";
		// Texto del origen de la clase. Para dar los enlaces y eso.
		if ($raceOriginText != "") {
			echo "<p class='originFoot'>".$raceOriginText."</p>";
		}
	// ------------------- >
	} else {
		echo $phraseNoAuth;
	}
	// ------------------------------------------------------------------ //
	} else {
	// ------------------------------------------------------------------ //
	// Listado de Razas; Texto que aparece si no se elige Hoja			  //
			switch($typItem) {
				case "canon":
					$raceSectionTitle = "Oficiales";
					$dataSearchSQL = "WHERE kind LIKE 0";
				break;
				case "homebrew":
					$raceSectionTitle = "Homebrew";
					$dataSearchSQL = "WHERE kind LIKE 1";
				break;
				default:
					$raceSectionTitle = "Listado de razas";
					$dataSearchSQL = "WHERE name NOT LIKE ''";
				break;
			}
		// Localización para pestañas
		if ($raceSectionTitle != "Listado de razas") {
			$tabName = $raceSectionTitle;
			include_once("contents_tabs.php");
			$raceSectionTitle = "Razas ".strtolower($raceSectionTitle);
		}
		// ---------->
		echo "<h3>".$raceSectionTitle."</h3>";
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydRacesFields." FROM ".$dydTableRaces." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionRaces[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>
