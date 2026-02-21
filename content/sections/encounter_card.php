<?php
	$idGetData = $encounterID; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableEncounter." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Encuentro en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos de la Acción
			$encounterID 	 	= $dataResult["id"]; 		// Nombre del Encuentro.
			$encounterName 	 	= $dataResult["name"]; 		// Nombre del Encuentro.
			$encounterLevel	 	= $dataResult["level"];		// Nivel del Encuentro.
			$encounterPlace 	= $dataResult["location_id"];// Localización del Encuentro.
			$encounterCreatures = $dataResult["creatures"];	// Criaturas del Encuentro.
			$encounterLoot		= $dataResult["loot"];		// Tesoro del Encuentro.
			$encounterText		= $dataResult["infotext"];	// Informacion del Encuentro.
			$encounterXP 		= 0;						// EXP del Encuentro.
			$encounterGold 		= 0;						// Oro del Encuentro.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
		// Sección principal
		if ($originCanon != 0) {
		//echo "<h3>".$encounterName."</h3>"; // Título del Encuentro
		echo "<br />";
		echo "<fieldset style='padding-bottom:14px;'>"; // Cuerpo del Encuentro
			if ($encounterLevel != 0) { echo "<legend>".$encounterName."</legend>"; }
			if ($encounterLevel != 0) { echo "<p style='margin-left:14px;margin-right:22px;'><span style='font-weight:bold;'>Nivel recomendado:</span> ".$encounterLevel."</p>"; }
			if ($encounterPlace != 0) { 
				// Cogemos el ID del lugar
				$dataListLoc = $encounterPlace;
				$retrieveFrom = "location";
				include (__DIR__ . "/retrieve_origin.php");
				// Mostramos el nombre del Lugar
				echo "<p style='margin-left:14px;margin-right:22px;'><span style='font-weight:bold;'>Lugar:</span> <a href='".$locLink."' target='_blank'>".$locName."</a></p>"; 
				// Añadimos datos a la variable de URLS
				$encounterLocationUrls[$locID] = "'".$locURL."'";
			}
			if ($encounterText != "") { echo "<p style='margin-left:14px;margin-right:22px;'>".nl2br($encounterText)."</p>"; }
			// ----------------------------------------------------------------------- //
			// Preparamos las criaturas [002]
			// ----------------------------------------------------------------------- //
			if ($encounterCreatures != "") {
				$encounterCreatures = preg_replace("/[\r\n]+/", "", $encounterCreatures); // Quitamos los saltos de linea.
				echo "<hr class='encounterLine' />";
				// Enemigos del encuentro.
				$arrayCreatures = array_filter(array_map('trim', explode(",", $encounterCreatures)), 'strlen');
				if (count($arrayCreatures) > 0) {
					echo "<div style='margin-left: 20px;'>";
					echo "<span style='font-weight:bold;'>Criaturas</span>";
					echo "<ul style='list-style-type:square;'>";
					for($countCreature=0;$countCreature<count($arrayCreatures);$countCreature++) {
						// Comprobamos si hemos puesto un nombre especial a los monstruos.
						$creatureSpName = explode(":", $arrayCreatures[$countCreature], 2);
						// Definimos en que variable están los datos.
						if (($creatureSpName[1] ?? "") != "") {
							$specialName = trim($creatureSpName[0]);
							$creatureMoreData = trim($creatureSpName[1]);
						} else {
							$specialName = "";
							$creatureMoreData = trim($creatureSpName[0] ?? "");
						}
						// Continuamos modo normal
						$creatureQty = explode("x", $creatureMoreData, 2);
						$dataListCreature = trim($creatureQty[0] ?? "");
						if ($dataListCreature == "") { continue; }
						$retrieveFrom = "creatures";
						include (__DIR__ . "/retrieve_origin.php");
						// ---------------------------------- //
						// Colocamos el texto del rol; si es un esbirro, élite, etc.
						//echo $creatElite;
						switch ($creatElite) {
							case 1:
								$creatText = " solitario";
							break;
							case 2:
								$creatText = " de élite";
							break;
							case 3:
								$creatText = ", jefe";
							break;
							case 7:
								$creatText = " esbirro";
							break;
							default:
								$creatText = "";
							break;							
						}
						// ---------------------------------- //
						// Si no hemos puesto cantidad, ponemos 1
						$creatureAmount = (int)trim($creatureQty[1] ?? "1");
						if ($creatureAmount <= 0) { $creatureAmount = 1; }
						// Si tenemos un nombre especial, lo definimos
						if ($specialName != "") {
							$creatureFinalName = $specialName;
						} else {
							$creatureFinalName = $creatName;
						}
						// ---------------------------------- //
						// Vamos sumando la experiencia.
						// ---------------------------------- //
						$encounterXP = $encounterXP + ((int)$creatXP * $creatureAmount);
						// ---------------------------------- //
						// Mostramos todo el contenido.
						echo "<li class='encounterCreature'>";
							echo "<div class='enemyAmount'>".$creatureAmount."&times; "."</div>";
							echo "<div class='enemyName'>";
								echo "<a href='".$pageRoot.$dydSectionCreatures[0]."/".$dataListCreature."/' target='_blank'>".$creatureFinalName."</a>";
							echo "</div>";
							echo "<div class='enemyLevel'>".$creatRole."".$creatText." nivel ".$creatLevel."</div>";
							echo "<div class='enemyXP'>".$creatXP." px</div>";
						echo "</li>";
					}
				// Finalizamos cerrando el UL
				echo "</ul>";
				echo "</div>";
				}
			}
			// ----------------------------------------------------------------------- //
			// Preparamos el tesoro [003]
			// ----------------------------------------------------------------------- //			
			if ($encounterLoot != "") {
				echo "<hr class='encounterLine' />";
				// Tesoro del encuentro.
				$arrayLoot = array_filter(array_map('trim', explode(",", $encounterLoot)), 'strlen');
				if (count($arrayLoot) > 0) {
					echo "<div style='margin-left: 20px;'>";
					echo "<span style='font-weight:bold;'>Tesoro</span>";
					echo "<ul style='list-style-type:square;'>";
					for($countLoot=0;$countLoot<count($arrayLoot);$countLoot++) {
						$lootText = trim($arrayLoot[$countLoot]);
						$lootQty = explode("x", $lootText, 2);
						$lootType = explode(":", trim($lootQty[0] ?? ""), 2);
						$lootKind = trim($lootType[0] ?? "");
						$lootId = trim($lootType[1] ?? "");
						$magicName = "";
						$thingName = "";
						$objectType = "";
						if ($lootKind == "") { continue; }
						if ($lootKind != "G") {
							switch ($lootKind) {
								// Objeto mágico
								case "M":
									$dataListMagic = $lootId;
									$retrieveFrom = "magic";
									$lootSection = $dydSectionMagicItems[0];
									$thingName = "";
								break;
								// Objeto mundano
								case "I":
									$dataListThing = $lootId;
									$retrieveFrom = "thing";
									$lootSection = $dydSectionItems[0];
									$magicName = "";
								break;
								// No tenemos nada
								default:
									$magicName = "";
									$thingName = "";
									$retrieveFrom = "";
									$lootSection = "";
									// Loot Section
									$lootText = str_replace("T:", "", $lootText);
									$lootText = str_replace("G:", "", $lootText);
									$lootQty[1] = "1";
								break;
							}
							if ($retrieveFrom != "") {
								include (__DIR__ . "/retrieve_origin.php");
							}
							// ---------------------------------- //
							// Si no hemos puesto cantidad, ponemos 1
							$lootAmount = (int)trim($lootQty[1] ?? "1");
							if ($lootAmount <= 0) { $lootAmount = 1; }
							if ($magicName == "" AND $thingName == "") {
								$lootName = $lootText;
							} else if ($thingName == "") {
								$lootName = $magicName;
							} else {
								$lootName = $thingName;
							}
							// ---------------------------------- //
							echo "<li class='encounterCreature'>";
								echo "<div class='enemyAmount'>".$lootAmount."&times; "."</div>";
								echo "<div class='lootName'>";
									if ($lootSection != "") {
										echo "<a href='".$pageRoot.$lootSection."/".$lootId."/' target='_blank'>".$lootName."</a>";
									} else {
										echo $lootName;
									}
								echo "</div>";
									if ($lootSection != "") {
									echo "<div class='lootType'>".$objectType."</div>";
									}
							echo "</li>";
						} else {
							// Si el objeto no es un item de trama ni está en la BDD, será dinero (G)
							$encounterGold = $encounterGold + (int)$lootId;
						}
					}
			// Finalizamos cerrando el UL
					echo "</ul>";
					echo "</div>";
				}
				
			}
			// ----------------------------------------------------------------------- //
			// Mostramos ORO y EXP [004]
			// ----------------------------------------------------------------------- //
			echo "<hr class='encounterLine' />";
			echo "<div style='margin-left: 20px;'>";
				// Mostramos la experiencia total.
				if ($encounterXP > 0) {
					echo "<div class='rewardTitle'>Experiencia:</div>";
					echo "<div class='rewardQty'>".$encounterXP." px</div>";
				}
				// Ponemos un salto de línea.
				if ($encounterXP > 0 AND $encounterGold > 0) {
					echo "<br />";
				}
				// Mostramos el oro total.
				if ($encounterGold > 0) {
					echo "<div class='rewardTitle'>Recompensa:</div>";
					echo "<div class='rewardQty'>".$encounterGold." piezas de oro</div>";
				}
			echo "</div>";
		echo "</fieldset>";
		// ================================================================== //
		// Acabamos
		// ================================================================== //
		} else {
			echo "<div class='errorImg'>".$phraseNoAuth."</div>";
		}
	}
?>

