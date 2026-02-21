<?php
	// HOJA DE PERSONAJE - El archivo más grande de Ad Infinitum
	/* 
	PRIMERA PARTE
		> [X] Información Biologica
		> [?] Atributos
		> [?] Rasgos
		> Habilidades
		> [?] Desglose
	SEGUNDA PARTE
		> [X] Dotes
	TERCERA PARTE
		> [X] Equipo
		> [X] Mochila
		> [X] Riqueza
	CUARTA PARTE
		> [X] Poderes activos
		> [N] Libro de conjuros
	*/
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTablePlayers." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Objeto en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	
	if ($rowsData != "") {
	$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		$playerID		 = $dataResult["id"]; 			// ID del personaje para los favoritos.
		$playerURL		 = $dataResult["url"]; 			// ID texto del personaje.
		$playerName  	 = $dataResult["name"]; 		// Nombre del Personaje.
		$playerSurname 	 = $dataResult["surname"]; 		// Apellidos del Personaje.
		$playerRace		 = $dataResult["race"];			// Raza del Personaje.
		$playerClass	 = $dataResult["class"];		// Clase del Personaje.
		// ---------->
		$playerAttr		 = $dataResult["attributes"];	// Atributos del Personaje.
		$playerSkills	 = $dataResult["skills"];		// Habilidades del Personaje.
		// ---------->
		$playerTraits 	 = $dataResult["traits"]; 		// Rasgos del Personaje. Utilizamos este campo para apoyarnos en los rasgos a elegir.
		$playerFeats 	 = $dataResult["feats"]; 		// Dotes del Personaje.
		$playerPowers	 = $dataResult["powers"];		// Poderes en posesión del Personaje.
		// ---------->
		$playerCampaign	 = $dataResult["campaign"]; 	// Campaña del Personaje.
		$playerOwner 	 = $dataResult["uploader"]; 	// Jugador del Personaje.
		$playerGender 	 = $dataResult["gender"]; 		// Sexo del Personaje.
		$playerImg		 = $dataResult["portrait"];		// Retrato del Personaje.
		$playerDetails	 = $dataResult["details"];		// Detalles de la historia del Personaje.
		$playerMusic 	 = $dataResult["music"]; 		// Tema musical del Personaje.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
	// ================================================================== //
	// Preparamos los datos que ya tenemos
	// Jugador
		if ($playerOwner == "") { $playerOwner = "infinitum"; } // Si no tiene nadie asignado, le ponemos el invitado.
		$dataListAuthor = $playerOwner;
		$retrieveFrom = "author";
		include(__DIR__ . "/retrieve_origin.php");
	// ------------------------------------->
	// Sexo
	// ------------------------------------->
		switch($playerGender) {
			case 1:
				$playerSex = "Femenino";
			break;
			case 0:
				$playerSex = "Masculino";
			break;
			default:
				$playerSex = "Desconocido";
			break;
		}
	// ------------------------------------->
	// Raza
	// ------------------------------------->
		$retrieveFrom = "race";
		$dataListRace = $playerRace;
			include (__DIR__ . "/retrieve_origin.php");
		$raceLink = $pageRoot.$dydSectionRaces[0]."/".$playerRace."/";
	// ------------------------------------->
	// Clase
	// ------------------------------------->
		$retrieveFrom = "class";
		$dataListClass = $playerClass;
			include (__DIR__ . "/retrieve_origin.php");
		$classLink = $pageRoot.$dydSectionClasses[0]."/".$playerClass."/";
	// ------------------------------------->
	// Aventuras
	// ------------------------------------->
		/*$retrieveFrom = "instances";
		include (__DIR__ . "/retrieve_origin.php");*/
		include ("player_get_exp.php");
		//echo "Experiencia por asistencia: ".$adventTotalXP;
	// ------------------------------------->
	// Nivel
	// ------------------------------------->
		$levelQuery = "SELECT ".$dydLevelChartFields." FROM ".$dydTableLevelChart." WHERE xp BETWEEN 0 AND ".$adventTotalXP.";"; // Pillamos la info de la XP
		$levelData = mysql_query ($levelQuery, $link);
		$levelRows = mysql_num_rows($levelData);
		if ($levelRows != 0) {
			for($plv=0;$plv<$levelRows;$plv++) {
				$levelResult 	= mysql_fetch_array($levelData);
				$levelFeats 	= $levelResult["feats"];
				$levelPowers 	= $levelResult["powers"];
				$playerMaxFeats[$plv] = $levelFeats;
			}
			// Nivel del PJ
			$playerLevel = $levelRows;
			$playerNextLevel = $playerLevel+1;
			// Número máximo de Dotes
			$playerMaxFeats = $playerMaxFeats[$levelRows-1];
		}
		// Cogemos la experiencia para el siguiente nivel
		$nextLevelQuery = "SELECT xp FROM ".$dydTableLevelChart." WHERE level LIKE ".$playerNextLevel." LIMIT 1;"; // la EXP del siguiente nivel
		$nextLevelData = mysql_query ($nextLevelQuery, $link);
		$nextLevelRows = mysql_num_rows($nextLevelData);
		if ($nextLevelRows != 0) {
			$maxPlayerLevel = FALSE;
			$nextLevelResult = mysql_fetch_array($nextLevelData);
			$nextLevelXp = $nextLevelResult["xp"];
		} else {
			$maxPlayerLevel = TRUE;
		}
	// ------------------------------------->
	// Atributos
	// ------------------------------------->
		$playerStats  = explode("|", $playerAttr);
		$playerQstats = count($playerStats);
			for($st=0;$st<$playerQstats;$st++) {
				$playerCheckAttribute = explode(":", $playerStats[$st], 2);
					$playerCharan[$st] = trim($playerCheckAttribute[0] ?? ""); // Stats
					$playerCharac[$st] = trim($playerCheckAttribute[1] ?? ""); // Basicos
					if ($playerCharan[$st] == "") { continue; }
					// Recogemos el bonificador de la raza Humana
					if (!is_numeric($playerCharac[$st]) AND trim($playerCharan[$st]) == "RACE") { $humanBonus = $playerCharac[$st]; }
					// Bonificadores de otras Razas
					if (is_numeric($playerCharac[$st]) AND trim($playerCharan[$st]) == "RACE") { $racialBonus = $playerCharac[$st]; }
					// Bonificador de Nivel 4
					if (trim($playerCharan[$st]) == "NV4") { $lvl4Bonus = $playerCharac[$st]; }
					// Bonificador de Nivel 8
					if (trim($playerCharan[$st]) == "NV8") { $lvl8Bonus = $playerCharac[$st]; }
					// Bonificador de Nivel 14
					if (trim($playerCharan[$st]) == "NV14") { $lvl14Bonus = $playerCharac[$st]; }
					// Bonificador de Nivel 18
					if (trim($playerCharan[$st]) == "NV18") { $lvl18Bonus = $playerCharac[$st]; }
					// Bonificador de Nivel 24
					if (trim($playerCharan[$st]) == "NV24") { $lvl24Bonus = $playerCharac[$st]; }
					// Bonificador de Nivel 28
					if (trim($playerCharan[$st]) == "NV28") { $lvl28Bonus = $playerCharac[$st]; }
					// Bonificador por Destino épico
					if (trim($playerCharan[$st]) == "EPIC") { $epicBonus = $playerCharac[$st]; }					
					// Bonificador por Equipo [Guarrada Manual]
					if (trim($playerCharan[$st]) == "EQUIP") { $statEquipBonus = $playerCharac[$st]; }
			}
	// Poderes
		$playerPowers = preg_replace("/[\\r\\n]+/", "", $playerPowers); // Quitamos los saltos de línea cojoneros.
	// ------------------------------------->
	// Inventario del PJ
	// ------------------------------------->	
		include_once("player_get_equipment.php");
	// ------------------------------------->
	// Retrato del PJ; si no tiene, ponemos la imagen de la raza
	// ------------------------------------->
		if ($playerImg != "") {
			// Tiene foto: la mostramos.
			$portraitUrl = $dydPlayerImgPath.$playerImg.$dydPlayerImgExt; 
		} else {
			// Ponemos la imagen de la raza.
			$portraitUrl = $dydRaceImgPath.$raceImg.$dydRaceImgExt;
		}
	// ------------------------------------->
	// Descripciones y frase
	// ------------------------------------->
		$playerInfo = explode("|", $playerDetails);
		$playerQtyInfo = count($playerInfo);
			for($pk=0;$pk<$playerQtyInfo;$pk++) {
				include("player_get_info.php");
			}
	// Colocamos datos genéricos si no existen
		if ($playerMotto == "") { $playerMotto = $classMotto; } // <-- Si el pj no tiene frase, ponemos la de la clase.
	// Comprobamos si tiene el nivel necesario para una Senda de Parangón o un Destino épico:
		// Senda de Parangón
		if ($playerLevel < 11 AND $paragonName != "") {
			$paragonName = "";
		}
		// Destino épico
		if ($playerLevel < 21 AND $epicName != "") {
			$epicName = "";
		}
	// Datos de origen para el Icono
		$dataOrigin = $playerOrigin;
	// Datos de Rol
		$roleIconPath = "media/role/";
		$roleIconExts = ".png";
		switch($classRole) {
			case "Defensor":
				$roleImg = "role_defender";
			break;
			case "Líder":
				$roleImg = "role_leader";
			break;		
			case "Pegador":
				$roleImg = "role_striker";
			break;		
			case "Controlador":
				$roleImg = "role_controller";
			break;				
			default:
				$roleImg = "role_mix";
			break;
		}
		$roleIconImg = $pageRoot.$roleIconPath.$roleImg.$roleIconExts;
	// -----
	// Comprobamos si el personaje tiene Banda sonora
		$ostTerms 		= "SELECT ".$dydBasicFields.", ".$fieldsOST." FROM ".$tableOST." WHERE url LIKE '".$playerURL."' OR url LIKE '".$playerMusic."' LIMIT 1";
		$ostIdQuery		= mysql_query($ostTerms, $link);
		$ostRows 		= mysql_num_rows($ostIdQuery);
		if ($ostRows > 0) { 
			$ostQueryResult	= mysql_fetch_array($ostIdQuery);
			$ostName		= $ostQueryResult["name"];
			$ostYtLink		= $ostQueryResult["yt_link"];
		}
	// Localización para pestañas
		include_once("contents_tabs.php");
	// ================================================================== //
		$pageTitle3 = $playerName." ".$playerSurname;
		echo "<h2>".$playerName." ".$playerSurname."</h2>"; // Título del Personaje
		echo "<p style='font-style:italic;'>".$playerMotto."</p>";
		echo "<div class='tab_container'>"; // <=== Inicio Div de Tabs
		echo "<div id='sheet' class='tab_content'>"; // <=== Contenido del TAB 1
			echo "<div class='playerBioTop'>";
			include_once("origin_icon.php");
			echo "<img src='".$portraitUrl."' style='width:184px;height:300px;' title='".$playerName."' />";
			echo "<fieldset style='text-align:left;'>"; 
				// Información de $playerName
				echo "<legend>Información de ".$playerName."</legend>";
				// ------------------------------------->
				// Sección superior de la Hoja de Personaje [001]
				// ------------------------------------->
				echo "<table class='playerBioData'>";
					// Primera Linea
					echo "<tr>";
						echo "<td class='playerBioDataName'>Nivel:</td>";
						echo "<td class='playerBioDataInfo'>".$playerLevel."</td>";
						echo "<td class='playerBioDataName'>Experiencia:</td>";
						if ($maxPlayerLevel != TRUE) {
							echo "<td class='playerBioDataInfo'>".$adventTotalXP." / ".$nextLevelXp."</td>";
						} else {
							echo "<td class='playerBioDataInfo'>".$adventTotalXP."</td>";
						}
					echo "</tr>";
					// Segunda Linea
					echo "<tr>";
						echo "<td class='playerBioDataName'>Raza:</td>";
						echo "<td class='playerBioDataInfo'><a href='".$raceLink."' target='_blank'>".$raceName."</a></td>";
						echo "<td class='playerBioDataName'>Clase:</td>";
						echo "<td class='playerBioDataInfo'><a href='".$classLink."' target='_blank'>".$className."</a></td>";
					echo "</tr>";
					// Tercera Linea
					echo "<tr>";
						if ($paragonName != "") {
							echo "<td class='playerBioDataName'>Senda de parangón:</td>";
							echo "<td class='playerBioDataInfo'><a href='".$paragonLink."' target='_blank'>".$paragonName."</a></td>";
						}
						if ($epicName != "") {
							echo "<td class='playerBioDataName'>Destino épico:</td>";
							echo "<td class='playerBioDataInfo'><a href='".$epicLink."' target='_blank'>".$epicName."</a></td>";
						}
					echo "</tr>";
					// Cuarta Linea
					echo "<tr>";
						if ($themeName != "") {
							echo "<td class='playerBioDataName'>Tema de personaje:</td>";
							echo "<td class='playerBioDataInfo'><a href='".$themeLink."' target='_blank'>".$themeName."</a></td>";
						}
						if ($bgName != "") {
							echo "<td class='playerBioDataName'>Trasfondo:</td>";
							echo "<td class='playerBioDataInfo'><a href='".$bgLink."' target='_blank'>".$bgName."</a></td>";
						}
					echo "</tr>";
					// Quinta Linea
					echo "<tr>";
						if ($playerAlignment != "") {
							echo "<td class='playerBioDataName'>Alineamiento:</td>";
							echo "<td class='playerBioDataInfo'>".$playerAlignment."</td>";
						}
						if ($deityName != "") {
							echo "<td class='playerBioDataName'>Deidad:</td>";
							echo "<td class='playerBioDataInfo'><a href='".$deityLink."' target='_blank'>".$deityName."</a></td>";
						}
					echo "</tr>";
					// Sexta Linea
					echo "<tr>";
						if ($playerAge != "") {
							echo "<td class='playerBioDataName'>Edad:</td>";
							echo "<td class='playerBioDataInfo'>".$playerAge."</td>";
						}
						echo "<td class='playerBioDataName'>Sexo:</td>";
						echo "<td class='playerBioDataInfo'>".$playerSex."</td>";
					echo "</tr>";
					// Séptima Linea
					echo "<tr>";
						if ($playerHeight != "") {
							echo "<td class='playerBioDataName'>Altura:</td>";
							echo "<td class='playerBioDataInfo'>".$playerHeight."</td>";
						}
						if ($playerWeight != "") {
							echo "<td class='playerBioDataName'>Peso:</td>";
							echo "<td class='playerBioDataInfo'>".$playerWeight."</td>";
						}
					echo "</tr>";
					// Octava Linea
					echo "<tr>";
						echo "<td class='playerBioDataName'>Tamaño:</td>";
						echo "<td class='playerBioDataInfo'>".$raceSize."</td>";
						if ($authorName == "Invitado") { $authorName = "-"; }
						if ($authorName != "") {
							echo "<td class='playerBioDataName'>Jugador:</td>";
							echo "<td class='playerBioDataInfo'>".$authorName."</td>";
						}
					echo "</tr>";
				echo "</table>";
			echo "</fieldset>";

			if ($playerText != "") { echo "<p>".$playerText."</p>"; } else { echo "<br />"; }
			echo "<p><b>Atención:</b> la sección de estadísticas del personaje aún está en desarrollo y no refleja por completo la hoja de personaje.</p>";
			echo "</div>";
			// ------------------------------------->
			// Sección de Estadísticas del Personaje [002]
			// ------------------------------------->
			echo "<fieldset style='text-align:left;'>"; 
				echo "<legend>Atributos</legend>";
				include_once("player_get_stats.php");
			echo "</fieldset>";
			// ------------------------------------->
			// Fin sección de atributos.
			// ------------------------------------->
			echo "<br />";
			// ------------------------------------->
			// Habilidades del personaje
			// ------------------------------------->
			echo "<fieldset style='text-align:left;'>"; 
				echo "<legend>Habilidades</legend>";
				include_once("player_show_skills.php");
			echo "</fieldset>";
			echo "<br />";
			// ------------------------------------->
			// Rasgos de raza, clase y demás
			echo "<fieldset style='text-align:left;'>"; 
				echo "<legend>Rasgos</legend>";
				include_once("player_get_traits.php");
			// Idiomas conocidos
				include_once("player_get_languages.php");
			echo "</fieldset>";
			// ------------------------------------->
			echo "<br />";
			// ------------------------------------->
			// Detalles de los atributos del personaje
			// ------------------------------------->
			if ($humanStatTitle != "" OR $raceAbBonus1[0] != "") {
				echo "<fieldset style='text-align:left;'>"; 
					echo "<legend>Desglose de estado</legend>";
					include_once("player_stat_proration.php");
				echo "</fieldset>";
			}
			// ------------------------------------->
			// Fin desglose de atributos.
		echo "</div>"; // <=== Fin del TAB 1
		echo "<div id='feats' class='tab_content'>"; // <=== Contenido del TAB 2
			// ------------------------------------->
			// Sección de Dotes del Personaje [003]
			// ------------------------------------->
			echo "<fieldset style='text-align:left;'>"; 
				echo "<legend>Dotes aprendidas por ".$playerName."</legend>";
				// Preparamos listado de Dotes
				$featList = explode("|", $playerFeats);
				$powerInPlayer = TRUE;
				// Preparamos las tarjetas de Dotes
				for($featSlot=0;$featSlot<count($featList);$featSlot++) {
					// ================================================================== //
					if (trim($featList[$featSlot]) != "") {
						if ($featSlot % 2 == 0) { echo "<div id='powerPlayerLayout'>"; }
							$featData = explode (":", trim($featList[$featSlot]));
							// Damos la id del dato.
							$featId = $featData[0];
							// Damos el nivel al que se ha aprendido la dote
							$featLevelLearned = $featData[1];
							// Damos algun dato especifico de la dote
							$featSpecific = $featData[2];
							// Enlace a la dote
							$playerFeatLink = $pageRoot.$dydSectionFeats[0]."/".$featId."/"; // Link a la página individual del poder
							include (__DIR__ . "/feat_card.php");
							$playerFeatBonus[$featId] = $featBDBonus; // Añadimos el bonificador a la lista de bonificadores.
						if ($featSlot % 2 == 1) { echo "</div>"; }
					}
					// ================================================================== //
				}
			echo "</fieldset>";
			// ------------------------------------->
			// Fin sección de Dotes.
			// ------------------------------------->
		echo "</div>"; // <=== Fin del TAB 2
		echo "<div id='equipment' class='tab_content'>"; // <=== Contenido del TAB 3
			// ------------------------------------->
			// Sección de Equipo del Personaje [004]
			// ------------------------------------->
			echo "<fieldset>";
				echo "<legend>Equipo de ".$playerName."</legend>";
				// Listado!
				echo "<div class='playerEquipCol'>";
				// Columna 1: Armas y Orbes
				if ($equipName["WEAPON"] != "" OR $equipName["SECONDARY"] != "" OR $equipName["OFFHAND"] != "" OR $equipName["IMPLEMENT"] != "")  {
				echo "<div class='playerEquipIzq'>";
					echo "<table class='playerEquipList'>";
						// Arma principal
						if ($equipName["WEAPON"] != "") {
						echo "<tr>";
							echo "<td class='equipSlot'>Arma:</td><td><a href='".$equipLink["WEAPON"]."' target='_blank'>".$equipName["WEAPON"]."</a></td>";
						echo "</tr>";
						}
						// Arma secundaria
						if ($equipName["SECONDARY"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Arma secundaria:</td><td><a href='".$equipLink["SECONDARY"]."' target='_blank'>".$equipName["SECONDARY"]."</a></td>"; 
						echo "</tr>";
						}
						// Mano torpe
						if ($equipName["OFFHAND"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Mano torpe:</td><td><a href='".$equipLink["OFFHAND"]."' target='_blank'>".$equipName["OFFHAND"]."</a></td>"; 
						echo "</tr>";
						}
						// Utensilio
						if ($equipName["IMPLEMENT"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Utensilio:</td><td><a href='".$equipLink["IMPLEMENT"]."' target='_blank'>".$equipName["IMPLEMENT"]."</a></td>"; 
						echo "</tr>";
						}
					echo "</table>";
				echo "</div>";
				}
				// Columna 2: Piezas de armadura
				if ($equipName["HEAD"] != "" OR $equipName["BODY"] != "" OR $equipName["BACK"] != "" OR $equipName["WAIST"] != "")  {
				echo "<div class='playerEquipDer'>";
					echo "<table class='playerEquipList'>";
						// Cabeza
						if ($equipName["HEAD"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Cabeza:</td><td><a href='".$equipLink["HEAD"]."' target='_blank'>".$equipName["HEAD"]."</a></td>"; 
						echo "</tr>";
						}
						// Cuerpo
						if ($equipName["BODY"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Cuerpo:</td><td><a href='".$equipLink["BODY"]."' target='_blank'>".$equipName["BODY"]."</a></td>"; 
						echo "</tr>";						
						}
						// Espalda
						if ($equipName["BACK"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Espalda:</td><td><a href='".$equipLink["BACK"]."' target='_blank'>".$equipName["BACK"]."</a></td>"; 
						echo "</tr>";						
						}
						// Cintura
						if ($equipName["WAIST"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Cintura:</td><td><a href='".$equipLink["WAIST"]."' target='_blank'>".$equipName["WAIST"]."</a></td>"; 
						echo "</tr>";						
						}
					echo "</table>";
				echo "</div>";
				}
				echo "</div>";
				echo "<div class='playerEquipCol'>";
				// Columna 3: Amuletos, anillos y demás
				if ($equipName["ARMS"] != "" OR $equipName["HAND"] != "" OR $equipName["FEET"] != "" OR $equipName["TATOO"] != "")  {
				echo "<div class='playerEquipIzq'>";
					echo "<table class='playerEquipList'>";
						// Brazos
						if ($equipName["ARMS"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Brazos:</td><td><a href='".$equipLink["ARMS"]."' target='_blank'>".$equipName["ARMS"]."</a></td>"; 
						echo "</tr>";
						}
						// Manos
						if ($equipName["HAND"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Manos:</td><td><a href='".$equipLink["HAND"]."' target='_blank'>".$equipName["HAND"]."</a></td>"; 
						echo "</tr>";
						}
						// Pies
						if ($equipName["FEET"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Pies:</td><td><a href='".$equipLink["FEET"]."' target='_blank'>".$equipName["FEET"]."</a></td>"; 
						echo "</tr>";
						}
						// Tatuaje
						if ($equipName["TATOO"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Tatuaje:</td><td><a href='".$equipLink["TATOO"]."' target='_blank'>".$equipName["TATOO"]."</a></td>"; 
						echo "</tr>";
						}
					echo "</table>";
				echo "</div>";
				}
				// Columna 4: Amuletos, anillos y demás
				if ($equipName["NECK"] != "" OR $equipName["RING1"] != "" OR $equipName["RING2"] != "" OR $equipName["REWARD"] != "")  {
				echo "<div class='playerEquipDer'>";
					echo "<table class='playerEquipList'>";
						// Cuello
						if ($equipName["NECK"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Cuello:</td><td><a href='".$equipLink["NECK"]."' target='_blank'>".$equipName["NECK"]."</a></td>"; 
						echo "</tr>";
						}
						// Anillo 1
						if ($equipName["RING1"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Anillo izquierdo:</td><td><a href='".$equipLink["RING1"]."' target='_blank'>".$equipName["RING1"]."</a></td>"; 
						echo "</tr>";
						}
						// Anillo 2
						if ($equipName["RING2"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Anillo derecho:</td><td><a href='".$equipLink["RING2"]."' target='_blank'>".$equipName["RING2"]."</a></td>"; 
						echo "</tr>";
						}
						// Recompensa alternativa
						if ($equipName["REWARD"] != "") { 
						echo "<tr>";
							echo "<td class='equipSlot'>Recompensa:</td><td><a href='".$equipLink["REWARD"]."' target='_blank'>".$equipName["REWARD"]."</a></td>"; 
						echo "</tr>";
						}
					echo "</table>";
				echo "</div>";
				}
				echo "</div>";
			echo "</fieldset>";
			// ------------------------------------->
			// Fin sección de Equipo.
			// ------------------------------------->
			// Preparamos la cartera del personaje
			include_once("player_get_gold.php");
			if ($goldRows != "") { echo "<br />"; }
			// ------------------------------------->
			// Sección de Riqueza del Personaje [005]
			// ------------------------------------->
			if ($goldRows != "") {
				// Preparamos los iconos de oro y tal
				$iconDirectory = $pageRoot."media/icon/";
				$iconExtension = ".png";
				// Diamantes astrales
				$asdiImg = $iconDirectory."coin_ad".$iconExtension;
				// Monedas de platino
				$platImg = $iconDirectory."coin_platinum".$iconExtension;
				// Monedas de oro
				$goldImg = $iconDirectory."coin".$iconExtension;
				// Monedas de plata
				$silvImg = $iconDirectory."coin_silver".$iconExtension;
				// Monedas de cobre
				$coppImg = $iconDirectory."coin_copper".$iconExtension;
				// Monedas de cobre
				$resiImg = $iconDirectory."coin_residuum".$iconExtension;
			// Mostramos la información
			echo "<fieldset>";
				echo "<legend>Riqueza</legend>";
				echo "<table class='playerGold'>";
					echo "<tr>";
						echo "<td class='playerCoin'><img class='iconBank' title='Diamantes astrales' src='".$asdiImg."' /></td>";
						echo "<td>".$playerDiamonds."</td>";
						echo "<td class='playerCoin'><img class='iconBank' title='Monedas de platino'src='".$platImg."' /></td>";
						echo "<td>".$playerPlatinums."</td>";
						echo "<td class='playerCoin'><img class='iconBank' title='Monedas de oro'src='".$goldImg."' /></td>";
						echo "<td>".$playerGolds."</td>";
						echo "<td class='playerCoin'><img class='iconBank' title='Monedas de plata'src='".$silvImg."' /></td>";
						echo "<td>".$playerSilvers."</td>";
						echo "<td class='playerCoin'><img class='iconBank' title='Monedas de cobre'src='".$coppImg."' /></td>";
						echo "<td>".$playerCoppers."</td>";
						echo "<td class='playerCoin'><img class='iconBank' title='Residuum'src='".$resiImg."' /></td>";
						echo "<td>".$playerResiduum."</td>";
					echo "</tr>";
				echo "</table>";
			echo "</fieldset>";	
			}
			//
			// ------------------------------------->
			// Fin sección de Riqueza.
			// ------------------------------------->
			if ($playerBank != "") { echo "<br />"; }
			// ------------------------------------->
			// Sección de Banco del Personaje [004]
			// ------------------------------------->
			if ($playerBank != "") {
			echo "<fieldset>";
				echo "<legend>Objetos en la mochila</legend>";
				include_once("player_get_bank.php");
			echo "</fieldset>";
			}
			// ------------------------------------->
			// Fin sección de Banco.
			// ------------------------------------->
			if ($playerRituals != "") { echo "<br />"; }
			// ------------------------------------->
			// Sección de Rituales del Personaje [006]
			// ------------------------------------->
			if ($playerRituals != "") {
			echo "<fieldset>";
				echo "<legend>Libro de rituales</legend>";	
				include_once("player_get_rituals.php");
			echo "</fieldset>";	
			}
		echo "</div>"; // <=== Fin del TAB 3
		echo "<div id='powers' class='tab_content'>"; // <=== Contenido del TAB 4
		if ($playerPowers !="") {
			$powerInPlayer = TRUE;
			//$playerPowers = array(-2=>119,-1=>120)+$playerPowers;
			//array_unshift($playerPowers, "119", "120");
		// Tabla de contenidos de poderes del personaje
			/*echo "<fieldset style='text-align:left;'>"; 
				echo "<legend>Poderes de ".$playerName."</legend>";
			echo "</fieldset>";
		echo "<br />";*/
		// Listado de poderes del Personaje
			echo "<fieldset style='text-align:left;'>"; 
				echo "<legend>Listado de poderes conocidos por ".$playerName."</legend>";
				// Preparamos listado de Poderes
				$powerList = explode(",", $playerPowers);
				// Preparamos las tarjetas de Poderes
				for($powerSlot=0;$powerSlot<count($powerList);$powerSlot++) {
					/* 
					//253,29,10,101,15
					[RAC]118|
					[ATW]403,405|
					[ENC]408|
					[DAI]411|
					[UTI]68|
					118,403,405,408,411,68,418,422
					*/
					//echo $powerList[$powerSlot];
					//echo $powerInPlayer;
					// ================================================================== //
					if ($powerSlot % 2 == 0) { echo "<div id='powerPlayerLayout'>"; }
						$powerId = $powerList[$powerSlot]; // Damos la id del dato.
						$playerPowerLink = $pageRoot."powers/".$powerId."/"; // Link a la página individual del poder
						include ("power_card.php");
					if ($powerSlot % 2 == 1) { echo "</div>"; }
					// ================================================================== //
				}
			echo "</fieldset>";
			} else { 
				$powerInPlayer = FALSE; 
			}
			// ------------------------------------->
			// Fin sección de Poderes.
			// ------------------------------------->
		echo "</div>"; // <=== Fin del TAB 4
		// ------------------------------------------------------------------ //
		// Aventuras del PJ
		// ------------------------------------------------------------------ //
		if ($playerAdventures != 0) {
			echo '<div id="adventures" class="tab_content">'; // <=== Contenido del TAB 5
				// Aventuras.
				$dataSearchTerms = $adventOrder;
				$dataSection = $dydSectionAdventures[0];
				// ------------------- >
				// Mostrar Aventuras
				// ------------------- >
				echo "<fieldset class='noInfoLink'>";
					echo "<h3 class='powerTitle'>Aventuras</h3>";
					include("contents_list.php");
				echo "</fieldset>";
			echo "</div>"; // <=== Fin del TAB 3
		}
		// ------------------------------------------------------------------ //
		// Música del PJ
		// ------------------------------------------------------------------ //
		echo "<div id='music' class='tab_content' style='text-align:center;'>"; // <=== Contenido del TAB 6
			// ------------------- >
			// Mostrar Música
			// ------------------- >
			if ($ostYtLink != "") {
				echo "<h3>".$ostName."</h3>";
				$musicLink = $ostYtLink;
				include_once("soundtrack_check_yt.php");
			}
		echo "</div>"; // <=== Fin del TAB 6
		echo "</div>"; // <=== Fin Div de Tabs
		$pageTitle2 = "Personaje";
	// ================================================================== //
	echo "<br/>";
	} else {
		// ------------------------------------------------------------------ //
		// Listado de Personajes; Texto que aparece si no se elige Hoja		  //
		// Configuramos el enlace de vuelta y título
			switch($typItem) {
				case "erarasa":
					$instCampaign  = "Era Rasa";
				break;
				case "casusbelli":
					$instCampaign  = "Casus Belli";
				break;
				case "parvumiter":
					$instCampaign  = "Parvum Iter";
				break;
				case "others":
					$instCampaign  = "";
				break;
				default:
					$instCampaign  = "Lista de personajes";
				break;
			}
		// Finalizamos la configuración del enlace de vuelta y título
		// Localización para pestañas
		if ($instCampaign != "Lista de personajes") {
			$dataSearchSQL = "WHERE campaign LIKE '".$instCampaign."'";
			// Si no tenemos nada porque es "others", mostramos un texto.
			if ($instCampaign == "") { 
				$instCampaign = "Otras campañas";
				$tabName = $instCampaign;
				// Y ahora lo ponemos en minúsculas.
				$instCampaign = "Personajes de ".strtolower($instCampaign);
			} else {
			// Si tenemos algo, mostramos "Personajes de CAMPAÑA"
				$tabName = $instCampaign;
				$instCampaign = "Personajes de ".$instCampaign;
			}
			$pageTitle2 = $instCampaign;	
			$dataListTitle = $instCampaign;
			$locTab = "FK";
			include_once("contents_tabs.php");
		}
		// ------------------------------------------------------------------ //
		echo "<h3>".$instCampaign."</h3>";
			// Datos de sesión
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydPlayersFields." FROM ".$dydTablePlayers." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionPlayers[0];
			include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
	// ---------------------------- //
	// Mostramos listas de Bonificaciones
	$showThePreList = FALSE;
	if ($showThePreList == TRUE) {	
		echo "Bonus Equipo: <pre>"; print_r($equipBonus); echo "</pre>";
		echo "Bonus Rasgos: <pre>"; print_r($traitListBonus); echo "</pre>";
		echo "Bonus Dotes: <pre>"; print_r($playerFeatBonus); echo "</pre>";
	}
	// ---------------------------- //
?>



