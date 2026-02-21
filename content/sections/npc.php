<?php
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableNPC." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el NPC en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del NPC
			$npcURL		 	 = $dataResult["url"];	 		// URL del NPC.
			$npcName	 	 = $dataResult["name"]; 		// Nombre del NPC.
			$npcSurname		 = $dataResult["surname"];		// Apellidos del NPC.
			$npcGender		 = $dataResult["gender"];		// Sexo del NPC.
			$npcPortrait	 = $dataResult["portrait"];		// Retrato del NPC.
			$npcCampaign	 = $dataResult["campaign"];		// Campaña del NPC.
			$npcRace		 = $dataResult["race"];			// Raza del NPC.
			$npcClass		 = $dataResult["class"];		// Clase del NPC.
			$npcCreature	 = $dataResult["creature_id"];	// ID de la criatura del NPC.
			$npcData		 = $dataResult["personal_data"];// Datos personales del NPC.
			$npcDetails		 = $dataResult["details"];		// Detalles del NPC.
			$npcStatus		 = $dataResult["status"];		// Estado del NPC.
			$npcMusic		 = $dataResult["music"];		// Música del NPC.
		// ================================================================== //
		// Preparamos la información personal
		// ------------------------------------->
		// Comprobamos si la tarjeta de Criatura existe.
		if ($npcCreature != 0) { $npcCheckCreature = sacaDatos($npcCreature, "creatures"); }
		// ------------------------------------->
		// Comprobamos el NPC tiene música.
		switch($npcMusic) {
			case "":
				$npcCheckMusic = sacaDatos($npcURL, "music");
			break;
			default:
				$npcCheckMusic = sacaDatos($npcMusic, "music");
			break;
		}
		// ------------------------------------->
		// Sexo
		// ------------------------------------->
		switch($npcGender) {
			case 1:
				$npcGender 	= "Femenino";
				$npcNoPhoto = "no_photo_female";
				$npcIsAlive = "Viva";
				$npcIsDead 	= "Muerta";
			break;
			case 0:
				$npcGender 	= "Masculino";
				$npcNoPhoto = "no_photo_male";
				$npcIsAlive = "Vivo";
				$npcIsDead 	= "Muerto";
			break;
			default:
				$npcGender 	= "Desconocido";
				$npcNoPhoto = "no_photo_male";
				$npcIsAlive = "Vivo";
				$npcIsDead 	= "Muerto";
			break;
		}
		// ------------------------------------->
		// Estado
		// ------------------------------------->
		// Datos de Rol
			$statIconPath = "media/role/";
			$statIconExts = ".png";
		// Preparamos los iconos
			switch($npcStatus) {
				case 1:
					$npcStatusT = $npcIsDead;
					$npcStatusI = "status_dead";
				break;
				case 2:
					$npcStatusT = "Desconocido";
					$npcStatusI = "status_unknown";
				break;
				default:
					$npcStatusT = $npcIsAlive;
					$npcStatusI = "status_alive";
				break;
			}
			$statIconImg = $pageRoot.$statIconPath.$npcStatusI.$statIconExts;
		// ------------------------------------->
		// Raza
		// ------------------------------------->
		$npcRace = explode("|", $npcRace);
		$npcOrigRace = $npcRace[0]; // Guardamos la primera parte de la raza por si la necesitamos
		if ($npcRace[1] != "") { 
			$npcRace = sacaDatos($npcRace[1], "race"); 
			if ($npcOrigRace != "") { $npcRace[1] = $npcOrigRace; }
			// Creamos el enlace en lugar de depender del retrieve_origin.php
			$npcRace = "<a href='".$npcRace[0]."' target='_blank'>".$npcRace[1]."</a>";
		} else { 
			$npcRace = $npcRace[0]; 
		}
		// ------------------------------------->
		// Clase
		// ------------------------------------->
		$npcClass = explode("|", $npcClass);
		$npcOrigClass = $npcClass[0]; // Guardamos la primera parte de la clase por si la necesitamos
		if ($npcClass[1] != "") { 
			$npcClass = sacaDatos($npcClass[1], "class"); 
			if ($npcOrigClass != "") { $npcClass[1] = $npcOrigClass; }
			// Creamos el enlace en lugar de depender del retrieve_origin.php
			$npcClass = "<a href='".$npcClass[0]."' target='_blank'>".$npcClass[1]."</a>";
		} else { 
			$npcClass = $npcClass[0]; 
		}
		// ------------------------------------->
		// Retrato del NPC; si no tiene, ponemos uno genérico
		// ------------------------------------->
		switch($npcPortrait){
			case 1:
				// Tiene foto especifica: la mostramos.
				$portraitUrl = $dydNpcImgPath.$npcURL.$dydNpcImgExt; 
			break;
			default:
				// Ponemos una imagen por defecto.
				$portraitUrl = $dydNpcImgPath.$npcNoPhoto.$dydNpcImgExt;
			break;
		}
		// ------------------------------------->
		// Listado de datos del personaje
		// ------------------------------------->		
		$npcDataArray = explode("|", $npcData);
		$npcDataCount = 0;
		while($npcDataCount < count($npcDataArray)) {
			// --------------->
			// Vamos comprobando si los datos están en el array y los colocamos
			// --------------->
			// CITA DEL NPC
			if (strpos($npcDataArray[$npcDataCount],"MOTTO") !== false) {
				$npcMotto = str_replace("MOTTO:", "", $npcDataArray[$npcDataCount]);
			}
			// ALTURA DEL NPC
			if (strpos($npcDataArray[$npcDataCount],"HEIGHT") !== false) {
				$npcHeight = str_replace("HEIGHT:", "", $npcDataArray[$npcDataCount]);
			}
			// PESO DEL NPC
			if (strpos($npcDataArray[$npcDataCount],"WEIGHT") !== false) {
				$npcWeight = str_replace("WEIGHT:", "", $npcDataArray[$npcDataCount]);
			}
			// EDAD DEL NPC
			if (strpos($npcDataArray[$npcDataCount],"AGE") !== false) {
				$npcAge = str_replace("AGE:", "", $npcDataArray[$npcDataCount]);
			}
			// NACIMIENTO DEL NPC
			if (strpos($npcDataArray[$npcDataCount],"BIRTH") !== false) {
				$npcBirthplace = str_replace("BIRTH:", "", $npcDataArray[$npcDataCount]);
			}
			// ALINEAMIENTO DEL NPC
			if (strpos($npcDataArray[$npcDataCount],"ALIGNMENT") !== false) {
				$npcAlignment = str_replace("ALIGNMENT:", "", $npcDataArray[$npcDataCount]);
			}
			// DEIDAD DEL NPC
			if (strpos($npcDataArray[$npcDataCount],"DEITY") !== false) {
				$npcDeity = str_replace("DEITY:", "", $npcDataArray[$npcDataCount]);
			}			
			// ALIANZAS DEL NPC
			if (strpos($npcDataArray[$npcDataCount],"ALLEGIANCE") !== false) {
				$npcAllegiance = str_replace("ALLEGIANCE:", "", $npcDataArray[$npcDataCount]);
			}			
			// CAUSA DE LA MUERTE DEL NPC
			if (strpos($npcDataArray[$npcDataCount],"DEATH") !== false) {
				$npcCauseOfDeath = str_replace("DEATH:", "", $npcDataArray[$npcDataCount]);
			}
			$npcDataCount++;
		}
		// ------------------------------------->
		// Alianzas del NPC
		// ------------------------------------->	
		if ($npcAllegiance != "") {
			// Buscamos un personaje jugador?
			if (strpos($npcAllegiance,"{PLAYER}") !== false) {
				$npcAllegiance = str_replace("{PLAYER}", "", $npcAllegiance);
				$npcAllegiance = sacaDatos(trim($npcAllegiance), "player");
			}
			// Buscamos un personaje no jugador?
			if (strpos($npcAllegiance,"{NPC}") !== false) {
				$npcAllegiance = str_replace("{NPC}", "", $npcAllegiance);
				$npcAllegiance = sacaDatos(trim($npcAllegiance), "npc");
			}
			// Buscamos un grupo de aventureros?
			if (strpos($npcAllegiance,"{PARTY}") !== false) {
				$npcAllegiance = str_replace("{PARTY}", "", $npcAllegiance);
				$npcAllegiance = sacaDatos(trim($npcAllegiance), "party");
			}
		}
		// ------------------------------------->
		// Origen del NPC
		// ------------------------------------->	
		if ($npcBirthplace != "") {
			if (strpos($npcBirthplace,"{LOC}") !== false) {
				$npcBirthplace = str_replace("{LOC}", "", $npcBirthplace);
				$npcBirthplace = sacaDatos(trim($npcBirthplace), "location");
			}
		}
		// ------------------------------------->
		// Deidad del NPC
		// ------------------------------------->	
		if ($npcDeity != "") {
			if (strpos($npcDeity,"{GOD}") !== false) {
				$npcDeity = str_replace("{GOD}", "", $npcDeity);
				$npcDeity = sacaDatos(trim($npcDeity), "deity");
			}
		}
		// ------------------------------------->
		// Comprobamos si el NPC está en Aventuras.
		// ------------------------------------->
		$instanceTerms 	= "SELECT ".$dydBasicFields.", ".$dydAdventuresFields." FROM ".$dydTableAdventures." WHERE npcs LIKE '%".$npcURL."%' ORDER BY date";
		$instanceIdQuery= mysql_query($instanceTerms, $link);
		$instanceRows 	= mysql_num_rows($instanceIdQuery);
		// ------------------------------------->
		// Primera y última aparición
		// ------------------------------------->
		if ($instanceRows > 0) {
			$instanceRowCheck = 0;
			while($instanceRowCheck<$instanceRows) {
				$instanceFirstLast 	= mysql_fetch_array($instanceIdQuery);
				$instanceFL[$instanceRowCheck]	= array($instanceFirstLast["id"], $instanceFirstLast["name"]);
				$instanceRowCheck++;				
			}
			// Cogemos el primer dato del array [0]
			$firstAdventure = "<a href='".$pathAdve.$instanceFL[0][0]."/' target='_blank'>".$instanceFL[0][1]."</a>";
			// Cogemos el último dato del array [contar cuantos datos hay -1]
			$lastAdventure = "<a href='".$pathAdve.$instanceFL[(count($instanceFL)-1)][0]."/' target='_blank'>".$instanceFL[(count($instanceFL)-1)][1]."</a>";
		}
		// ------------------------------------->
		// Localización para pestañas
		include_once("contents_tabs.php");
		// Sección principal
		$pageTitle2 = "Personaje no jugador";
		$pageTitle3 = $npcName." ".$npcSurname;
		echo "<h2>".$npcName." ".$npcSurname."</h2>"; // Título del NPC
		if ($npcMotto !="") { echo "<p style='font-style:italic;'>".$npcMotto."</p>"; }
		// ------------------------------------------------------------------ //
		// Información del NPC
		// ------------------------------------------------------------------ //
		echo "<div id='sheet' class='tab_content'>"; // <=== Contenido del TAB 1
			echo "<div class='playerBioTop'>";
				include_once("origin_icon.php");
				echo "<img src='".$portraitUrl."' style='width:184px;height:300px;' title='".$npcName."' />";
			 // Cuerpo de los datos del NPC
				echo "<fieldset>";
					echo "<legend>Información de ".$npcName."</legend>";
						echo "<table class='playerBioData'>";
							// Primera Linea
							// RAZA y CLASE
							echo "<tr>";
								echo "<td class='playerBioDataName'>Raza:</td>";
								echo "<td class='playerBioDataInfo'>".$npcRace."</td>";
								if ($npcClass != "") {
									echo "<td class='playerBioDataName'>Ocupación:</td>";
									echo "<td class='playerBioDataInfo'>".$npcClass."</td>";
								}
							echo "</tr>";
							// Segunda Linea
							// ALINEAMIENTO y DEIDAD
							echo "<tr>";
								if ($npcAlignment != "") {
									echo "<td class='playerBioDataName'>Alineamiento:</td>";
									echo "<td class='playerBioDataInfo'>".$npcAlignment."</td>";
								}
								if ($npcDeity != "") {
									echo "<td class='playerBioDataName'>Religión:</td>";
									echo "<td class='playerBioDataInfo'>".$npcDeity."</td>";
								}
							echo "</tr>";
							// Tercera Linea
							// EDAD y SEXO
							echo "<tr>";
								if ($npcAge != "") {
									echo "<td class='playerBioDataName'>Edad:</td>";
									echo "<td class='playerBioDataInfo'>".$npcAge."</td>";
								}
								if ($npcGender != "Desconocido") {
									echo "<td class='playerBioDataName'>Sexo:</td>";
									echo "<td class='playerBioDataInfo'>".$npcGender."</td>";
								}
							echo "</tr>";
							// Cuarta Linea
							// ALTURA y PESO
							echo "<tr>";
								if ($npcHeight != "") {
									echo "<td class='playerBioDataName'>Altura:</td>";
									echo "<td class='playerBioDataInfo'>".$npcHeight."</td>";
								}
								if ($npcWeight != "") {
									echo "<td class='playerBioDataName'>Peso:</td>";
									echo "<td class='playerBioDataInfo'>".$npcWeight."</td>";
								}
							echo "</tr>";
							// Quinta Linea
							// ORIGEN y AFILIACION
							echo "<tr>";
								if ($npcBirthplace != "") {
									echo "<td class='playerBioDataName'>Lugar de nacimiento:</td>";
									echo "<td class='playerBioDataInfo'>".$npcBirthplace."</td>";
								}
								if ($npcAllegiance != "") {
									echo "<td class='playerBioDataName'>Afiliación:</td>";
									echo "<td class='playerBioDataInfo'>".$npcAllegiance."</td>";
								}
							echo "</tr>";							
							// Sexta Linea
							// PRIMERA y ULTIMA APARICION
							echo "<tr>";
								if ($instanceRows > 0) {
									echo "<td class='playerBioDataName'>Primera aparición:</td>";
									echo "<td class='playerBioDataInfo'>".$firstAdventure."</td>";
									//if ($firstAdventure != $lastAdventure) {
										echo "<td class='playerBioDataName'>Última aparición:</td>";
										echo "<td class='playerBioDataInfo'>".$lastAdventure."</td>";
									//}
								}
							echo "</tr>";							
							// Séptima Linea
							// CAUSA DE LA MUERTE
							echo "<tr>";
								if ($npcStatus == 1 && $npcCauseOfDeath != "") {
									echo "<td class='playerBioDataName'>Causa de la muerte:</td>";
									echo "<td class='playerBioDataInfo' style='text-align:left;' colspan='3'>".$npcCauseOfDeath."</td>";
								}
							echo "</tr>";
						echo "</table>";
					echo "</fieldset>";
			if ($npcDetails != "") { echo "<p>".nl2br($npcDetails)."</p>"; }
			echo "</div>";
		echo "</div>"; // <=== Fin del TAB 1
		// ------------------------------------------------------------------ //
		// Tarjeta de Criatura del NPC
		// ------------------------------------------------------------------ //
		echo "<div id='card' class='tab_content'>"; // <=== Contenido del TAB 1
			if (count($npcCheckCreature) > 0) {
				echo "<div id='powerItemLayout'>";
					$enemyId = $npcCreature; // Damos la id del Enemigo.
					include ("enemy_card.php");
				echo "</div>";
			}
		echo "</div>"; // <=== Fin del TAB 2
		// ------------------------------------------------------------------ //
		// Aventuras en las que aparece el NPC
		// ------------------------------------------------------------------ //
		echo "<div id='adventures' class='tab_content'>"; // <=== Contenido del TAB 2
			if ($instanceRows > 0) {
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydAdventuresFields." FROM ".$dydTableAdventures." WHERE npcs LIKE '%".$npcURL."%'";
				$dataSection	 = $dydSectionAdventures[0];
				// ------------------- >
				// Mostrar Aventuras
				// ------------------- >
				echo "<fieldset class='noInfoLink'>";
					echo "<h3 class='powerTitle'>Aventuras</h3>";
					include("contents_list.php");
				echo "</fieldset>";
			}
		echo "</div>"; // <=== Fin del TAB 2
		// ------------------------------------------------------------------ //
		// Música del NPC
		// ------------------------------------------------------------------ //
		echo "<div id='music' class='tab_content' style='text-align:center;'>"; // <=== Contenido del TAB 3
			if ($npcCheckMusic[0] != "") {
				echo "<h3>".$npcCheckMusic[0]."</h3>";
				$musicLink = $npcCheckMusic[1];
				include_once("soundtrack_check_yt.php");
			}
		echo "</div>"; // <=== Fin del TAB 3
		// Fin Hoja
		// ------------------------------------------------------------------ //
	echo "<br/>";
	} else {
		// ------------------------------------------------------------------ //
		// Listado de NPCS; Texto que aparece si no se elige Hoja			  //
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
				case "past":
					$instCampaign  = "Pasado";
				break;
				case "noimage":
					$instCampaign  = "Personajes no jugadores";
				break;
				default:
					$instCampaign  = "Personajes no jugadores";
				break;
			}
		// Finalizamos la configuración del enlace de vuelta y título
		// Localización para pestañas
		if ($instCampaign != "Personajes no jugadores") {
			$dataSearchSQL = "WHERE campaign LIKE '".$instCampaign."'";
			// Si no tenemos nada porque es "others", mostramos un texto.
			switch($instCampaign) {
				case "":
					$instCampaign = "Otras campañas";
					$tabName = $instCampaign;
					// Y ahora lo ponemos en minúsculas.
					$instCampaign = "Personajes no jugadores de ".strtolower($instCampaign);
				break;
				case "Pasado":
					$instCampaign = "Pasado";
					$tabName = $instCampaign;
					// Y ahora lo ponemos en minúsculas.
					$instCampaign = "Personajes no jugadores del ".strtolower($instCampaign);				
				break;
				default:
					// Si tenemos algo, mostramos "Personajes de CAMPAÑA"
					$tabName = $instCampaign;
					$instCampaign = "Personajes no jugadores de ".$instCampaign;
				break;
			}
			$pageTitle2 = $instCampaign;	
			$dataListTitle = $instCampaign;
			$locTab = "FK";
			include_once("contents_tabs.php");
		}
		// Comprobamos si hay que mostrar a todos los pnjs sin foto
			if ($typItem == "noimage") { 
				$dataSearchSQL = "WHERE portrait LIKE 0";
				$instCampaign = "Personajes no jugadores sin foto";
			}
		// ------------------------------------------------------------------ //
		echo "<h3>".$instCampaign."</h3>";
			// Mostramos la lista de acciones 
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydNPCFields." FROM ".$dydTableNPC." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionNPC[0];
			include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>