<div id="mainSectionList">
<?php
	// ------------------------------------------------------------------ //
	$fullList = isset($fullList) ? (int)$fullList : 0;
	$shopCoin = isset($shopCoin) ? (int)$shopCoin : 0;
	$hideAdventureColumn = isset($hideAdventureColumn) ? (bool)$hideAdventureColumn : FALSE;
	$page = $page ?? 0;
    $dataList = $dataSearchTerms;

    // Ejecutamos la consulta
    $dataIdQuery = mysqli_query($link, $dataList);
    if (!$dataIdQuery) {
        die("Error en la consulta: " . mysqli_error($link));
    }

    $dataRows = mysqli_num_rows($dataIdQuery);
	if ($dataRows != 0) {
		// Selección de tabla para Poderes u Dotes
		// Esto se emplea cuando se solapan dos "pagetable", inutilizando las demás después de la primera.
		switch ($dataSection) {
		    case $sectionOST[0]:             $dataTable = "searchtable";  break;
            case $dydSectionUpdates[0]:      $dataTable = "searchtable";  break;
            case $dydSectionBibliography[0]: $dataTable = "biblotable";   break;
            case $dydSectionAdventures[0]:   $dataTable = "adventable";   break;
            case $dydSectionPlayers[0]:      $dataTable = "playertable";  break;
            case $dydSectionNPC[0]:          $dataTable = "vehictable";   break;
            case $dydSectionParties[0]:      $dataTable = "shoptable";    break;
            case $dydSectionShops[0]:        $dataTable = "shoptable";    break;
            case $dydSectionMap[0]:          $dataTable = "locations";    break;
            case $dydSectionTimeline[0]:     $dataTable = "timeline";     break;
            case $dydSectionMiniatures[0]:   $dataTable = "shoptable";    break;
            case $dydSectionArticles[0]:     $dataTable = "articletable"; break;
            case $dydSectionActions[0]:      $dataTable = "actiontable";  break;
            case $dydSectionAilments[0]:     $dataTable = "ailmentable";  break;
            case $dydSectionRaces[0]:        $dataTable = "racetable";    break;
            case $dydSectionClasses[0]:      $dataTable = "classtable";   break;
            case $dydSectionBuilds[0]:       $dataTable = "buildtable";   break;
            case $dydSectionTraits[0]:       $dataTable = "traitstable";  break;
            case $dydSectionBackgrounds[0]:  $dataTable = "bgtable";      break;
            case $dydSectionSkills[0]:       $dataTable = "skilltable";   break;
            case $dydSectionPowers[0]:       $dataTable = "powertable";   break;
            case $dydSectionFeats[0]:        $dataTable = "feattable";    break;
            case $dydSectionItems[0]:        $dataTable = "itemtable";    break;
            case $dydSectionVehicles[0]:     $dataTable = "vehictable";   break;
            case $dydSectionMagicItems[0]:   $dataTable = ($fullList == 1) ? "bgtable" : "magictable"; break;
            case $dydSectionEnchants[0]:     $dataTable = "ritualtable";  break;
            case $dydSectionRituals[0]:      $dataTable = "ritualtable";  break;
            case $dydSectionEncounter[0]:    $dataTable = "bestitable";   break;
            case $dydSectionBestiary[0]:     $dataTable = "bestitable";   break;
            case $dydSectionCreatures[0]:    $dataTable = "creatable";    break;
            default:                         $dataTable = "pagetable";    break;
		}
	// ------------------------------------------------------------------ //
		// Si estamos visualizando la tabla desde el menú de Bibliografía, quitarla 10 px
		$tableFromBiblio = $tableFromBiblio ?? "";
		if ($page != 0) { $tableFromBiblio = TRUE; } // Si estamos en una página, vamos a reducir esas tablas.
		if ($tableFromBiblio == TRUE) { $tableBiblioStyle = "width:958px;"; } else { $tableBiblioStyle = ""; }
		// Mostramos la tabla:
		echo "<table id='".$dataTable."' class='display' style='".$tableBiblioStyle."'>";
			echo "<thead>";
			echo "<th class='name'>Nombre</th>";
			// Preparamos donde mostrar el origen y donde no
			switch ($dataSection) {
				case $dydSectionUpdates[0]:
				case $dydSectionBibliography[0]:
				case $sectionOST[0]:
				case $dydSectionAdventures[0]:
				case $dydSectionPlayers[0]:
				case $dydSectionNPC[0]:
				case $dydSectionMap[0]:
				case $dydSectionTimeline[0]:
				case $dydSectionMiniatures[0]:
					$dontShowOrigin = 1;
				break;
				default:
					$dontShowOrigin = 0;
				break;
			}
			switch ($dataSection) {
			// --------------------->	
			// Sección Inicio
			// --------------------->
			// Actualizaciones
				case $dydSectionUpdates[0]:
					echo "<th style='width:80px;'>Fecha</th>";
					echo "<th style='width:120px;'>Autor</th>";
				break;
			// Bibliografía
				case $dydSectionBibliography[0]:
					echo "<th style='width:80px;'>Fecha</th>";
					echo "<th style='width:50px;'>ISBN</th>";
					echo "<th style='width:120px;'>Editorial</th>";
				break;
			// Banda sonora
				case $sectionOST[0]:
					echo "<th style='width:150px;'>Tipo</th>";
					echo "<th style='width:120px;'>Campaña</th>";
					echo "<th style='width:90px;'>Añadida</th>";
					echo "<th style='width:20px;'></th>";
				break;
			// --------------------->	
			// Sección Partida
			// --------------------->
			// Aventuras
				case $dydSectionAdventures[0]:
					echo "<th style='width:50px;'>#</th>";
					if ($typItem == "") {
						echo "<th style='width:120px;'>Campaña</th>";
					}
					echo "<th style='width:60px;'>Nivel</th>";
					echo "<th>Experiencia</th>";
					echo "<th style='width:80px;'>Fecha</th>";
					echo "<th class='origin'>Máster</th>";
				break;	
			// Jugadores
				case $dydSectionPlayers[0]:
					echo "<th style='width:140px;'>	Raza</th>";
					echo "<th style='width:140px;'>	Clase</th>";
					echo "<th style='width:80px;'>	Nivel</th>";
					echo "<th style='width:120px;'>	Jugador</th>";
				break;		
			// Perosnajes no jugadores
				case $dydSectionNPC[0]:
					echo "<th style='width:140px;'>	Raza</th>";
					echo "<th style='width:140px;'>	Ocupación</th>";
					echo "<th style='width:80px;'>	Estado</th>";
					echo "<th style='width:120px;'>	Creador</th>";
				break;		
			// Grupos de aventureros
				case $dydSectionParties[0]:
					echo "<th style='width:120px;'>Alineamiento</th>";
					echo "<th style='width:60px;'>Miembros</th>";
					echo "<th style='width:60px;'>Nivel</th>";
				break;
			// Bazares
				case $dydSectionShops[0]:
					echo "<th style='style='width:850px;text-align:left;'>Información</th>";
				break;
			// Lugares
				case $dydSectionMap[0]:
					echo "<th style='width:100px;'>Tipo</th>";
					echo "<th style='width:100px;'>Región</th>";
					echo "<th style='width:100px;'>Clase</th>";
					echo "<th style='width:100px;'>Autor</th>";
				break;
			// Línea temporal
				case $dydSectionTimeline[0]:
					if ($hideAdventureColumn == FALSE) { echo "<th style='width:150px;text-align:left;'>Aventura</th>"; }
					echo "<th style='width:100px;'>Tipo</th>";
					echo "<th style='width:120px;'>Fecha</th>";
				break;	
			// Miniaturas
				case $dydSectionMiniatures[0]:
					echo "<th style='width:100px;'>ID</th>";
					echo "<th style='width:60px;'>Precio</th>";
					echo "<th style='width:150px;'>Colección</th>";
					echo "<th style='width:150px;'>Representa</th>";
					echo "<th style='width:60px;'>Imagen</th>";
				break;	
			// --------------------->	
			// Sección Sistema
			// --------------------->
			// Articulos
				case $dydSectionArticles[0]:
					if ($typItem == "deities") { echo "<th>Alineamiento</th>"; }
					if ($typItem == "languages") { echo "<th>Alfabeto</th>"; }
				break;	
			// Acciones
				case $dydSectionActions[0]:
					echo "<th style='text-align:center;'>Tipo</th>";
				break;
			// Aflicciones
				case $dydSectionAilments[0]:
					echo "<th style='width:100px;'>Nivel</th>";
					echo "<th style='width:60px;'>Tipo</th>";
				break;
			// --------------------->
			// Sección Personaje
			// --------------------->				
			// Razas
				case $dydSectionRaces[0]:
					echo "<th style='width:100px;'>Carácterísticas</th>";
					echo "<th style='width:60px;'>Tamaño</th>";
					echo "<th style='width:60px;'>Velocidad</th>";
				break;	
			// Clases
				case $dydSectionClasses[0]:
					// -------------------------------------------->
					// Si es Essentials, hacemos las celdas de Rol y Poder más grandes; si no, las dejamos como están.
					if ($typItem == "essentials") { 
						$essWdth = "width:160px;"; 
					} else { 
						$essWdth = "width:80px;"; 
					}
					// Mostramos los datos y la información
					switch ($typItem) {
						default:
						case "heroic":
							echo "<th style='width:130px;'>Características</th>";
							echo "<th style='".$essWdth."'>Rol</th>";
							echo "<th style='".$essWdth."'>Poder</th>";
						break;
						case "paragon":
						case "epic":
							echo "<th  style='width:356px;'>Requisitos</th>";
						break;
						case "themes":
							echo "<th style='width:216px;'>Clases sugeridas</th>";
						break;							
					}
				break;
			// Diseños de clase
				case $dydSectionBuilds[0]:
					echo "<th style='width:120px;'>Clase</th>";
				break;					
			// Rasgos
				case $dydSectionTraits[0]:
					echo "<th style='width:120px;'>Clase</th>";
					echo "<th style='width:60px;'>Tipo</th>";
				break;
			// Trasfondos de personaje
				case $dydSectionBackgrounds[0]:
					echo "<th style='width:120px;'>Tipo</th>";
					echo "<th style='width:120px;'>Habilidades</th>";
				break;
			// --------------------->
			// Sección Facultades
			// --------------------->
			// Poderes
				case $dydSectionPowers[0]:
					echo "<th style='width:120px;text-align:center;'>Tipo</th>";
					echo "<th style='width:140px;text-align:center;'>Característica</th>";
					echo "<th style='width:40px;text-align:center;'>Nivel</th>";
				break;	
			// Dotes
				case $dydSectionFeats[0]:
					switch ($typItem) {
						case "general":
						case "divine":
							echo "<th style='width:60px;text-align:center;'>Grado</th>";
						break;
						default:
							echo "<th style='width:120px;text-align:center;'>Clase</th>";
							echo "<th style='width:60px;text-align:center;'>Grado</th>";
						break;
					}
				break;
			// --------------------->
			// Sección Equipo
			// --------------------->
			// Objetos mundanos
				case $dydSectionItems[0]:
					$dontShowOrigin = 1;
					switch ($typItem) {
						case "weapons":
							echo "<th>Comp.</th>";
							echo "<th>Daño</th>";
							echo "<th>Alcance</th>";
							echo "<th>Grupo</th>";
							echo "<th>Propiedades</th>";
							echo "<th>Precio</th>";
							echo "<th>Peso</th>";
						break;
						case "armors":
							echo "<th style='text-align:center;' title='Bonificador a la armadura'>CA</th>";
							echo "<th style='text-align:center;' title='Mejora mínima'>Mejora</th>";
							echo "<th style='text-align:center;' title='Penalizador a las pruebas de habilidad'>Pruebas</th>";
							echo "<th style='text-align:center;' title='Penalizador a la velocidad'>Veloc.</th>";
							echo "<th style='text-align:center;'>Grupo</th>";
							echo "<th style='text-align:center;'>Propiedades</th>";
							echo "<th style='text-align:center;'>Precio</th>";
							echo "<th style='text-align:center;'>Peso</th>";
						break;
						default:
							echo "<th>Grupo</th>";
							echo "<th>Propiedades</th>";
							echo "<th>Precio</th>";
							echo "<th>Peso</th>";
						break;
					}
				break;
			// Vehículos
				case $dydSectionVehicles[0]:
					echo "<th style='width:120px;'>Tamaño</th>";
					echo "<th style='width:80px;'>Casillas</th>";
					echo "<th style='width:80px;'>Valor</th>";
				break;
			// Objetos mágicos
				case $dydSectionMagicItems[0]:
					echo "<th style='width:120px;'>Tipo</th>";
					switch ($shopCoin) {
						case 1:
							echo "<th style='width:80px;'>Topacios</th>";
						break;
						default:
							 echo "<th style='width:80px;'>Valor</th>";
						break;
					}
					echo "<th style='width:40px;'>Nivel</th>";
				break;
			// Encantamientos
				case $dydSectionEnchants[0]:
					echo "<th style='width:190px;'>Tipo</th>";
					echo "<th style='width:60px;'>Coste mín.</th>";
					echo "<th style='width:50px;'>Nivel mín.</th>";
				break;
			// Rituales
				case $dydSectionRituals[0]:
					if ($typItem == "") {
						echo "<th>Categoría</th>";
					}
					echo "<th>Habilidad</th>";
					echo "<th>Nivel</th>";
				break;
			// --------------------->
			// Sección PNJ
			// --------------------->
			// Encuentros
				case $dydSectionEncounter[0]:
					echo "<th style='width:40px;'>Nivel</th>";
				break;
			// Bestiario
				case $dydSectionBestiary[0]:
					echo "<th style='width:75px;'>Conocimiento</th>";
				break;	
			// Enemigos
				case $dydSectionCreatures[0]:
					switch($typItem) {
						default:
							echo "<th style='width:22px;'>Tipo</th>";
							normalCreatureHeaders: // Proceso de repetición.
							echo "<th style='width:75px;'>Rol</th>";
							echo "<th style='width:40px;'>Nivel</th>";
							echo "<th style='width:80px;'>PX</th>";
						break;
						case "traps":
						case "mounts":
						case "hirelings":
							goto normalCreatureHeaders;
						break;
						case "allies":
							echo "<th style='width:75px;'>Rol</th>";
							echo "<th style='width:40px;'>Nivel</th>";
						break;
						case "familiars":
						break;
						case "hirelings":
							echo "<th style='width:75px;'>Rol</th>";
							echo "<th style='width:40px;'>Nivel</th>";
							echo "<th style='width:80px;'>Coste</th>";
						break;
					}
				break;	
			}
			// ORIGEN
			if ($dontShowOrigin != 1) { echo "<th class='origin'>Origen</th>"; }
		echo "</thead>";
		// ------------------------------------------------ >
		echo "<tbody>";
			for($dt=0;$dt<$dataRows;$dt++) {
				$dataQueryResult = mysqli_fetch_assoc($dataIdQuery);
				$dataListID 		= $dataQueryResult["id"];
				$dataListURL		= "";//[NUEVAURL] $dataQueryResult["url"];
				$dataListName 		= $dataQueryResult["name"];
				// ¿Apellido?
				switch($dataSection) {
					case $dydSectionPlayers[0]:
					case $dydSectionNPC[0]:
						$dataListSurname = $dataQueryResult["surname"];
					break;
					default:
						$dataListSurname = "";
					break;
				}
				// Si estamos en la sección de bibliografía, no tocamos el origen.
				if ($dataSection != $dydSectionBibliography[0]) {
					$dataListOrigin = $dataQueryResult["origin"] ?? "";
				}
				// ------------------------------------------------ >
				// Preparamos URL amigable
				$dataListNameUrl = strtolower($dataListName);
				$dataListNameUrl = str_replace(" ","_",$dataListNameUrl);
				$dataListNameUrl = str_replace("-","_",$dataListNameUrl);
				$dataListNameUrl = quitar_acentos($dataListNameUrl);
				// ------------------------------------------------ >
				// Iconos para los Poderes
				// ------------------------------------------------ >
				$iconFolder = $pageRoot."media/icon";
				if ($dataSection == $dydSectionPowers[0]) { 
					$dataListType  = $dataQueryResult["type"];
					switch($dataListType) {
						case "A voluntad":
							$iconType = $iconFolder."/power-will.png";
						break;
						case "Encuentro":
							$iconType = $iconFolder."/power-encounter.png";
						break;
						case "Diario":
							$iconType = $iconFolder."/power-daily.png";
						break;
					}
					$iconIMG = "<img class='powerIcon' src='".$iconType."' title='".$dataListType."'/>";
				// ------------------------------------------------ >
				// Iconos del Bestiario
				// ------------------------------------------------ >
				} else if ($dataSection == $dydSectionCreatures[0]) {
					$dataListElite  = $dataQueryResult["elite"];
					$dataListImg  	= $dataQueryResult["picture"];
					$iconHasImg = $iconFolder."/icon_mirror.png";
					$iconNotImg = $iconFolder."/no_icon.png";
					switch ($dataListElite) {
						case 1:
							$iconType = $iconFolder."/icon_lone.png";
							$iconTitle = "Solitario";
						break;
						case 2:
							$iconType = $iconFolder."/icon_elite.png";
							$iconTitle = "Élite";
						break;
						case 3:
							$iconType = $iconFolder."/icon_crown.png";
							$iconTitle = "Jefe";
						break;
						case 7:
							$iconType = $iconFolder."/icon_minion.png";
							$iconTitle = "Esbirro";
						break;
						case 9:
							$iconType = $iconFolder."/icon_boss.png";
							$iconTitle = "Líder";
						break;
						case 4:
							$iconType = $iconFolder."/icon_ally.png";
							$iconTitle = "Aliado";
						break;
						default:
							$iconType = $iconNotImg;
							$iconTitle = "";
						break;
					}
					$iconIMG = "<img class='powerIcon' src='".$iconType."' title='".$iconTitle."' />";
					// Hacemos esta bastardada de momento.
					//icon_mirror
					$iconEnemyType 	= $iconIMG;
					$iconEnemyTitle = $iconTitle;
					if ($dataListImg != "") {
						$iconIMG = "<img class='powerIcon' src='".$iconHasImg."' title='Criatura con imagen' />";
					} else {
						$iconIMG = "<img class='powerIcon' src='".$iconNotImg."' />";
					}
				} else {
				// Sin icono
					$iconIMG = "";
				}
				// ------------------------------------------------ >
				// Conseguimos datos del Origen
				// ------------------------------------------------ >
					$retrieveFrom = "origin";
					include (__DIR__ . "/retrieve_origin.php");
				// ------------------------------------------------ >
				// Preparamos la celda del Nombre
				// ------------------------------------------------ >
				switch ($dataSection) {
					default: 
						$nameStyle = "";
					break;
					case $dydSectionRaces[0]:
						$nameStyle = "width: 270px;";
					break;
					case $dydSectionItems[0]:
						if ($typItem == "weapons") { $nameStyle = "width: 170px;"; }
					break;
				}
				// ------------------------------------------------ >
				// Comprobar si estamos logeados o los datos tienen CANON = 1
				if (isset($mainUserName)) { 
					$showTheData = TRUE;
				} else if ($originCanon == 1) {
					$showTheData = TRUE;
				} else {
					$showTheData = TRUE; // FALSE
				}
			// ------------------------------------------------ >
			if ($showTheData == TRUE) { // <--- INICIO DE COMPROBACION SI MOSTRAMOS POR CANON
				// Comprobamos si los archivos tienen URL definida. Si no, mostramos el ID.
				if ($dataListURL != "") { $pageUrl = $dataListURL; } else { $pageUrl = $dataListID; }
				echo "<tr>";
					echo "<td class='name' style='".$nameStyle."'>".$iconIMG."<a href='".$pageRoot.$dataSection."/".$pageUrl."/'>".$dataListName." ".$dataListSurname."</a></td>";
					switch ($dataSection) {
						// --------------------- >
						// Actualizaciones
						// --------------------- >
						case $dydSectionUpdates[0]:
							// Cogemos el nombre del Autor
							$dataListAuthor = $dataQueryResult["uploader"];
							$retrieveFrom = "author";
							include (__DIR__ . "/retrieve_origin.php");
							echo "<td>".$dataQueryResult["date"]."</td>";
							echo "<td>".$authorName."</td>";
						break;
						// --------------------- >
						// Bibliografía
						// --------------------- >
						case $dydSectionBibliography[0]:
							echo "<td>".$dataQueryResult["date"]."</td>";
							echo "<td>".$dataQueryResult["isbn"]."</td>";
							echo "<td>".$dataQueryResult["publisher"]."</td>";
						break;
						// --------------------- >
						// Banda sonora
						// --------------------- >
						case $sectionOST[0]:
							switch($dataQueryResult["type"]) {
								// Temas de personaje
								case "cha":
									$musicType = "Personaje";
								break;
								// Temas de personaje
								case "npc":
									$musicType = "Personaje no jugador";
								break;
								// Lugares
								case "loc":
									$musicType = "Localizaciones";
								break;
								// Batallas
								case "btl":
									$musicType = "Batallas y enfrentamientos";
								break;
								// Evento
								case "eve":
									$musicType = "Eventos";
								break;
							}
							echo "<td>".$musicType."</td>";
							echo "<td>".$dataQueryResult["playlist"]."</td>";
							echo "<td>".$dataQueryResult["date"]."</td>";
							echo "<td class='iconTypeCreature'><a href='".$dataQueryResult["yt_link"]."' target='_blank'><img class='powerIcon' src='".$muIcon."'></a></td>";
						break;
						// --------------------- >
						// Articulos
						// --------------------- >
						case $dydSectionArticles[0]:
						// Deidades - Se muestra alineamiento
						// Idiomas - Se muestra el alfabeto
						if ($typItem == "deities" OR $typItem == "languages") { echo "<td>".$dataQueryResult["subtype"]."</td>"; }
						break;
						// --------------------- >
						// Aventuras
						// --------------------- >
						case $dydSectionAdventures[0]:
							$seasonN = $dataQueryResult["number"][0];
							// Preparamos el Código del Episodio
							switch ($dataQueryResult["campaign"]) {
								case "Historias personales":
									$seasonN = $dataQueryResult["number"][2];
									$seasonE = substr($dataQueryResult["number"], -2);
									$episodeNumber = "T".$seasonN." H".$seasonE;
								break;
								default:
									$seasonE = substr($dataQueryResult["number"], -2);
									$episodeNumber = $seasonN."x".$seasonE;
								break;
							}
							// Mostramos los datos.
							echo "<td>".$episodeNumber."</td>";
							if ($typItem == "") { echo "<td>".$dataQueryResult["campaign"]."</td>"; }
							echo "<td>".$dataQueryResult["levels"]."</td>";
							echo "<td style='width:110px;'>".$dataQueryResult["xp"]."</td>";
							echo "<td>".$dataQueryResult["date"]."</td>";
							// Preparamos datos del Master
							$dataListAuthor = $dataQueryResult["uploader"];
							$retrieveFrom = "author";
							include (__DIR__ . "/retrieve_origin.php");
							if ($authorName == "Invitado") { $authorName = "-"; }
							// Mostramos el nombre del Master
							echo "<td>".$authorName."</td>";
						break;
						// --------------------- >
						// Jugadores
						// --------------------- >
						case $dydSectionPlayers[0]:
							$dataListRace  = $dataQueryResult["race"];
							$dataListClass = $dataQueryResult["class"];
							// Raza
							$retrieveFrom = "race";
								include (__DIR__ . "/retrieve_origin.php");
								echo "<td>".$raceName."</td>";
							// Clase
							$retrieveFrom = "class";
								include (__DIR__ . "/retrieve_origin.php");
								echo "<td>".$className."</td>";
							// Nivel
							//$dataListExp   = $dataQueryResult["experience"];
							$playerURL   = $dataQueryResult["url"]; // Colocamos la URL del pj para pillar sus datos.
							include("player_get_exp.php");			// Preparamos la experiencia a través de este archivo.
							$levelQuery = "SELECT level FROM $dydTableLevelChart WHERE xp BETWEEN 0 AND $adventTotalXP";
							$levelData  = mysqli_query($link, $levelQuery);

							if ($levelData && mysqli_num_rows($levelData) > 0) {
								$levelRow   = mysqli_fetch_assoc($levelData);
								$levelValue = $levelRow['level'] ?? 0;
							} else {
								$levelValue = 0;
							}
							// Mostramos nivel
							echo "<td>".$levelValue."</td>";
							// Cogemos el nombre del Jugador
							$dataListAuthor = $dataQueryResult["uploader"];
							$retrieveFrom = "author";
							include (__DIR__ . "/retrieve_origin.php");
							if ($authorName == "Invitado") { $authorName = "-"; }
							// Mostramos el nombre del Jugador
							echo "<td>".$authorName."</td>";
						break;
						// --------------------- >
						// Personajes no jugadores
						// --------------------- >
						case $dydSectionNPC[0]:
							$dataListRace  	= explode("|", $dataQueryResult["race"]);
							$dataListClass 	= explode("|", $dataQueryResult["class"]);
							switch($dataQueryResult["status"]) {
								case 1:
									$dataListStatus = "Cadáver";
								break;								
								case 2:
									$dataListStatus = "Desconocido";
								break;								
								default:
									$dataListStatus = "En activo";
								break;
							}
							// Raza
							echo "<td>".$dataListRace[0]."</td>";
							// Clase
							echo "<td>".$dataListClass[0]."</td>";
							// Estados
							echo "<td>".$dataListStatus."</td>";
							// Cogemos el nombre del Jugador
							$dataListAuthor = $dataQueryResult["uploader"];
							$retrieveFrom = "author";
							include (__DIR__ . "/retrieve_origin.php");
							if ($authorName == "Invitado") { $authorName = "-"; }
							// Mostramos el nombre del Jugador
							echo "<td>".$authorName."</td>";
						break;
						// --------------------- >
						// Grupos de aventureros
						// --------------------- >
						case $dydSectionParties[0]:
							$isNpcGroup = FALSE;
							echo "<td>".$dataQueryResult["alignment"]."</td>";
							// Nº de miembros
							switch ($dataQueryResult["npc_members"]) {
								case "":
									$totalMembersOfParty1 = $dataQueryResult["members"];
								break;
								default:
									switch ($dataQueryResult["members"]) {
										case "":
											$isNpcGroup = TRUE;
											$totalMembersOfParty1 = $dataQueryResult["npc_members"];
										break;	
										default:
											$totalMembersOfParty1 = $dataQueryResult["members"].",".$dataQueryResult["npc_members"];
										break;
									}
								break;
							}
							$totalMembersOfParty1 = preg_replace("/\s+/", "", $totalMembersOfParty1);
							$totalMembersOfParty2 = (count(explode(",", $totalMembersOfParty1)));
							echo "<td>".$totalMembersOfParty2."</td>";
							// Media de nivel
							switch ($isNpcGroup) {
								case TRUE:
									$partyAvrgLevl = "N/A";
								break;
								case FALSE:
									$playerParty = $dataQueryResult["members"];
									include("party_get_level.php");
								break;
							}
							echo "<td>".$partyAvrgLevl."</td>";
						break;
						// --------------------- >
						// Lugares
						// --------------------- >
						case $dydSectionMap[0]:
							echo "<td>".$dataQueryResult["type"]."</td>";
							echo "<td>".$dataQueryResult["kingdom"]."</td>";
							switch ($dataQueryResult["class"]) {
								case "marker":
									$locationClass = "Lugar";
								break;
								default: 
									$locationClass = "Desconocido";
								break;
							}
							echo "<td>".$locationClass."</td>";
							// Cogemos el nombre del Jugador
							$dataListAuthor = $dataQueryResult["uploader"];
							$retrieveFrom = "author";
							include (__DIR__ . "/retrieve_origin.php");
							// Mostramos el nombre del Jugador
							echo "<td>".$authorName."</td>";
						break;						
						// --------------------- >
						// Línea temporal
						// --------------------- >
						case $dydSectionTimeline[0]:
							// Aventura en la que sucedió el evento
							if ($hideAdventureColumn == FALSE) {
								$retrieveFrom = "adventure";
								$dataListAdven = $dataQueryResult["adventure_id"];
								include (__DIR__ . "/retrieve_origin.php");
								if ($advenName != "") {
									echo "<td style='text-align:left;'><a href='".$advenLink."' target='_blank'>".$advenName."</a></td>";
								} else {
									echo "<td></td>";
								}
							}
							// Tipo de evento
							echo "<td>".$dataQueryResult["type"]."</td>";
							// Fecha del evento
							$ylatDate 	= $dataQueryResult["year"]."-".$dataQueryResult["month"]."-".$dataQueryResult["day"];
							// Test Date
							$sumDate 	= $dataQueryResult["day"]+$dataQueryResult["month"]+$dataQueryResult["year"];
							$eventTl 	= nuevaFecha($ylatDate);
							echo "<td>".$eventTl."</td>";
						break;
						// --------------------- >
						// Miniaturas
						// --------------------- >
						case $dydSectionMiniatures[0]:
							if ($dataQueryResult["id_mini"] != 0) {
								// Tenemos una ID
								echo "<td>".$dataQueryResult["id_mini"]."</td>";
							} else {
								// No tenemos nada
								echo "<td>-</td>";
							}
								// Formateamos el precio de la miniatura
								$miniPrice = $dataQueryResult["price"];
							if ($miniPrice != 0) {
								$priceCents = substr($miniPrice, -2);
								$priceMains = substr($miniPrice, 0, -2);
								// Lo mostramos
								echo "<td>".$priceMains.",".$priceCents."&euro;</td>";
							} else {
								echo "<td>-</td>";
							}
							echo "<td>".$dataQueryResult["collection"]."</td>";
							echo "<td>".$dataQueryResult["avatar"]."</td>";
							// Imagen?
							if ($dataQueryResult["picture"] != "") { 
								$miniBigImage = $dydMiniatureImgPath.$dataQueryResult["picture"].$dydMiniatureImgExt;
								$miniNewImage = $iconFolder."/icon_mirror.png";
								echo "
									<td style='text-align:center;'>
										<span style='visibility:hidden;position:absolute;'>".$dataQueryResult["picture"]."</span>
										<div class='miniature_thumbnail'>
											<img class='powerIcon' style='padding-left:30px;height:16px;' src='".$miniNewImage."' />
											<img class='miniatureFull' src='".$miniBigImage."' />
										</div>
									</td>
								";
							} else {
								echo "<td></td>";
							}
						break;
						// --------------------- >
						// Encuentros
						// --------------------- >
						case $dydSectionEncounter[0]:
							echo "<td>".$dataQueryResult["level"]."</td>";
						break;						
						// --------------------- >
						// Grimorio
						// --------------------- >
						case $dydSectionBestiary[0]:
							echo "<td>".$dataQueryResult["skill"]."</td>";
						break;
						// --------------------- >
						// Enemigos
						// --------------------- >
						case $dydSectionCreatures[0]:
							switch($typItem) {
								default:
									echo "<td class='iconTypeCreature'><span>".$iconEnemyTitle."</span>".$iconEnemyType."</td>";
									normalCreatureContents: // Proceso de repetición. .
									echo "<td>".$dataQueryResult["role"]."</td>";
									echo "<td>".$dataQueryResult["level"]."</td>";
									echo "<td>".$dataQueryResult["xp"]."</td>";
								break;
								case "traps":
								case "mounts":
								case "hirelings":
									goto normalCreatureContents;
								break;
								case "allies":
									echo "<td>".$dataQueryResult["role"]."</td>";
									echo "<td>".$dataQueryResult["level"]."</td>";
								break;
								case "familiars":
								break;
							}
						break;
						// --------------------- >
						// Razas
						// --------------------- >
						case $dydSectionRaces[0]:
							// Preparamos camino de los Iconos
							$dataAbilitieImg = $pageRoot."media/icon/stat_";
							// Habilidades de característica
							$dataListAbilities  = $dataQueryResult["abilities"];
							// Habilidades fijas
							$dataListAbFixed = explode("/", $dataListAbilities);
							$dataListAbFixed = array_pad($dataListAbFixed, 4, "");
							if ($dataListAbFixed[0] == "1HUMANO" OR $dataListAbFixed[0] == "") { 
								$dataListAbFixed[0] = "Ver raza"; 
								$abImgWidth = "width:59px;"; 
							} else {
								$abImgWidth = "";
							}
							// Fondo de la habilidad fija
							$dataListAbFixImg = "<img src='".$dataAbilitieImg.$dataListAbFixed[0].".png' class='raceAbility' style='".$abImgWidth."' title='".$dataListAbFixed[0]."'  />";
							echo "<td>".$dataListAbFixImg." <span class='raceAbility'>".$dataListAbFixed[0]."</span>";
							// Habilidades a escoger
							$dataListAbSel1Img = "<img src='".$dataAbilitieImg.$dataListAbFixed[1].".png' class='raceAbility' title='".$dataListAbFixed[1]."' />";
							$dataListAbSel2Img = "<img src='".$dataAbilitieImg.$dataListAbFixed[2].".png' class='raceAbility' title='".$dataListAbFixed[2]."' />";
							$dataListAbSel3Img = "<img src='".$dataAbilitieImg.$dataListAbFixed[3].".png' class='raceAbility' title='".$dataListAbFixed[3]."' />";
							$dataListAbSeparator = "<img src='".$dataAbilitieImg."sep.png' class='raceAbility' style='width:10px;'/>";
							if ($dataListAbFixed[3] != "") {
								echo ""; //td
								echo $dataListAbSel1Img.$dataListAbSeparator.$dataListAbSel2Img.$dataListAbSeparator.$dataListAbSel3Img;
								echo " <span class='raceAbility'>".$dataListAbFixed[1]."</span></td>";	
							} else if ($dataListAbFixed[2] != "") {
								echo ""; //td
								echo $dataListAbSel1Img.$dataListAbSeparator.$dataListAbSel2Img." <span class='raceAbility'>".$dataListAbFixed[1]."</span></td>";							
							} else { //td
								echo "".$dataListAbSel1Img." <span class='raceAbility'>".$dataListAbFixed[1]."</span></td>";
							}
							// Tamaño
							$dataListSize  = $dataQueryResult["size"];
							echo "<td>".$dataListSize."</td>";
							// Velocidad
							$dataListSpeed = $dataQueryResult["speed"];
							echo "<td>".$dataListSpeed."</td>";
						break;
						// --------------------- >
						// Clases
						// --------------------- >
						case $dydSectionClasses[0]:
							switch($typItem) {
								default:
									$dataListStats  = $dataQueryResult["stats"];
									// Desglosar las STATS
									$dataListAbilities = explode("/", $dataListStats);
									// Preparamos camino de los Iconos
									$dataAbilitieImg = $pageRoot."media/icon/stat_";
									// Separador de Iconos
									$statSeparator = "<img src='".$dataAbilitieImg."sep.png' class='raceAbility' style='width:10px;'/>";
									echo "<td>";
										$qtyOfStats = count($dataListAbilities);
										for($classtat=0;$classtat<$qtyOfStats;$classtat++) {
											// Configuramos el Icono
											$dataListAbImg = "<img src='".$dataAbilitieImg.$dataListAbilities[$classtat].".png' class='raceAbility' title='".$dataListAbilities[$classtat]."'  />";
											// Mostramos todo el texto
											echo $dataListAbImg."<span class='raceAbility'>".$dataListAbilities[$classtat]."</span>";
											// Separador
											if ($classtat >= 0 AND $classtat < $qtyOfStats-1) {
												echo $statSeparator;
											}
										}
									echo "</td>";
									echo "<td>".$dataQueryResult["role"]."</td>";
									echo "<td>".$dataQueryResult["source"]."</td>";								
								break;
								case "paragon":
								case "epic":
									echo "<td>".$dataQueryResult["required"]."</td>";							
								break;
								case "themes":
									echo "<td>".$dataQueryResult["role"]."</td>";							
								break;
							}
						break;
						// --------------------- >
						// Acciones
						// --------------------- >
						case $dydSectionActions[0]:
							echo "<td>".$dataQueryResult["type"]."</td>";
						break;	
						// --------------------- >
						// Rasgos
						// --------------------- >
						case $dydSectionTraits[0]:
							echo "<td>".$dataQueryResult["class"]."</td>";
							echo "<td>".$dataQueryResult["type"]."</td>";
						break;	
						// --------------------- >
						// Diseños
						// --------------------- >
						case $dydSectionBuilds[0]:
							echo "<td>".$dataQueryResult["class"]."</td>";
						break;
						// --------------------- >
						// Trasfondos
						// --------------------- >
						case $dydSectionBackgrounds[0]:
							echo "<td>".$dataQueryResult["class"]."</td>";
							echo "<td>".$dataQueryResult["skills"]."</td>";
						break;	
						// --------------------- >
						// Poderes
						// --------------------- >
						case $dydSectionPowers[0]:
							echo "<td>".$dataQueryResult["class"]."</td>";
							echo "<td>".$dataQueryResult["attack"]."</td>";
							echo "<td>";
							$dataListLevel = $dataQueryResult["level"];
							// Comprobamos si tiene Nivel o no
							if ($dataListLevel > 0) {
							// Mostramos el nivel
								echo $dataListLevel;
							} else {
							// Si no tiene nivel, no lo mostramos
								echo "-";
							}
							echo "</td>";
						break;
						// --------------------- >
						// Dotes
						// --------------------- >
						case $dydSectionFeats[0]:
							switch ($typItem) {
								case "general":
								case "divine":
									echo "<td>".$dataQueryResult["tier"]."</td>";
								break;
								default:
									echo "<td>".$dataQueryResult["class"]."</td>";
									echo "<td>".$dataQueryResult["tier"]."</td>";
								break;
							}
						break;
						// --------------------- >
						// Encantamientos
						// --------------------- >
						case $dydSectionEnchants[0]:
							echo "<td>".ucfirst($dataQueryResult["type"])."</td>";
							// Comprobamos el nivel mínimo
							$enchantLevels = $dataQueryResult["levels"];
							$arrayLevels = explode("|", $enchantLevels);
							// Contamos y quitamos valores en blanco del array
							$cleanArrayLevels = array_values(array_diff($arrayLevels, array("")));
							if ($cleanArrayLevels[0] != "") {
								$checkArrayLevel = explode("+", $cleanArrayLevels[0]);
								$levelsEnchant = str_replace("Niv. ", "", $checkArrayLevel[0]);
								if (count($cleanArrayLevels) > 1) { $levelSign = "+"; } else { $levelSign = ""; }
							}
							$levelSign = "";
							// Preparamos el coste
							$enchantCost = substr($checkArrayLevel[1], 1); // Quitamos el primer valor del precio
							$enchantCost = str_replace(".", "", $enchantCost); // Quitamos los puntos
							$enchantCost = str_replace("po", "", $enchantCost); // Quitamos las monedas
							$enchantCost = str_replace(" ", "", $enchantCost); // Quitamos los espacios
							// Mostramos el dinero.
							echo "<td>".$enchantCost."".$levelSign."</td>";
							// Escribimos niveles
							echo "<td>".str_replace(" ", "", $levelsEnchant)."".$levelSign."</td>";
						break;
						// --------------------- >
						// Rituales
						// --------------------- >
						case $dydSectionRituals[0]:
							if ($typItem == "") {
								echo "<td>".$dataQueryResult["category"]."</td>";
							}
							echo "<td>".$dataQueryResult["skills"]."</td>";
							echo "<td>".$dataQueryResult["level"]."</td>";
						break;
						// --------------------- >
						// Objetos mundanos
						// --------------------- >
						case $dydSectionItems[0]:
							switch ($typItem) {
								// Equipo aventurero
								default:
									echo "<td style='width:128px;'>".$dataQueryResult["type"]."</td>";
									echo "<td style='width:80px;'>".$dataQueryResult["properties"]."</td>";	
									$dataListHand = $dataQueryResult["hand"]; 
									$dataListPrice = $dataQueryResult["price"];
									switch ($dataListHand) {
										case 3:
											$dataListPrice = $dataListPrice." pp";
										break;
										case 4:
											$dataListPrice = $dataListPrice." pc";
										break;	
										default:
											$dataListPrice = $dataListPrice." po";
										break;	
									}
									if ($dataListPrice == 0) { $dataListPrice = "especial";	}
									echo "<td style='width:60px;'>".$dataListPrice."</td>";
									$dataListWeight  = $dataQueryResult["weight"]." lb.";
									echo "<td style='width:46px;'>".$dataListWeight."</td>";
								break;
								// Armas
								case "weapons":
									$dataListComp = $dataQueryResult["comp"];
									echo "<td style='width:42px;'>+".$dataListComp."</td>";
									$dataListDice = $dataQueryResult["dice"];
									echo "<td style='width:46px;'>".$dataListDice."</td>";	
									$dataListReach = $dataQueryResult["reach"];
									echo "<td style='width:56px;'>".$dataListReach."</td>";
									$dataListGroup = $dataQueryResult["type"];
									echo "<td style='width:128px;'>".$dataListGroup."</td>";
									$dataListProperties = $dataQueryResult["properties"];
									echo "<td style='width:162px;'>".$dataListProperties."</td>";									
									$dataListPrice = $dataQueryResult["price"];
									if ($dataListPrice == 0) { 
										$dataListPrice = "especial"; 
									} else {
										$dataListPrice = $dataListPrice." po";
									}
									echo "<td style='width:60px;'>".$dataListPrice."</td>";
									$dataListWeight = $dataQueryResult["weight"];
									echo "<td style='width:46px;'>".$dataListWeight." lb.</td>";
								break;
								// Armaduras
								case "armors":
									$dataListArmor = $dataQueryResult["armor"];
									echo "<td style='width:46px;'>".$dataListArmor."</td>";
									$dataListMinBonus = $dataQueryResult["minbonus"];
									echo "<td style='width:54px;'>".$dataListMinBonus."</td>";	
									$dataListSkill = $dataQueryResult["skill"];
									if ($dataListSkill == 0) { $dataListSkill = "-"; }
									echo "<td style='width:62px;'>".$dataListSkill."</td>";	
									$dataListSpeed = $dataQueryResult["speed"];
									if ($dataListSpeed == 0) { $dataListSpeed = "-"; }
									echo "<td style='width:54px;'>".$dataListSpeed."</td>";	
									$dataListGroup = $dataQueryResult["type"];
									echo "<td style='width:70px;'>".$dataListGroup."</td>";		
									$dataListProperties = $dataQueryResult["properties"];
									echo "<td style='width:100px;'>".$dataListProperties."</td>";									
									$dataListPrice = $dataQueryResult["price"];
									if ($dataListPrice == 0) { 
										$dataListPrice = "especial"; 
									} else {
										$dataListPrice = $dataListPrice." po";
									}
									echo "<td style='width:60px;'>".$dataListPrice."</td>";
									$dataListWeight = $dataQueryResult["weight"];
									echo "<td style='width:46px;'>".$dataListWeight." lb.</td>";
								break;
							}
						break;
						// --------------------- >
						// Vehículos
						// --------------------- >
						case $dydSectionVehicles[0]:
							echo "<td>".$dataQueryResult["size"]."</td>";
							echo "<td>".$dataQueryResult["squares"]."</td>";
							echo "<td>".$dataQueryResult["price"]."</td>";
						break;
						// --------------------- >
						// Enfermedades y venenos
						// --------------------- >
						case $dydSectionAilments[0]:
							echo "<td>".$dataQueryResult["level"]."</td>";
							echo "<td>".$dataQueryResult["type"]."</td>";
						break;
						// --------------------- >
						// Objetos mágicos
						// --------------------- >
						case $dydSectionMagicItems[0]:
							echo "<td>".$dataQueryResult["type"]."</td>";
							$dataListValue = $dataQueryResult["value"];
							if ($dataListValue <= 0) { $dataListValue = "-"; }
							echo "<td>".$dataListValue."</td>";
							echo "<td>".$dataQueryResult["level"]."</td>";
						break;
						// --------------------- >
						// Bazares
						// --------------------- >
						case $dydSectionShops[0]:
							$dataListInfo  = $dataQueryResult["infotext"];
							$infoSplit  = explode("|", $dataListInfo);
							echo "<td style='text-align:left;'>".$infoSplit[0]."</td>";
						break;
					}
					// ORIGEN
					if ($dontShowOrigin != 1) { echo "<td>".$originName."</td>"; }
				echo "</tr>";
				} // <--- FIN DE COMPROBACION SI MOSTRAMOS POR CANON
			}
		echo "</tbody>";
		// ------------------------------------------------------------------ //	
		echo "</table>";
	} else { ?>
	<table id="pagetable" <?php if ($tableFromBiblio == TRUE) { echo "style='width:958px';"; } ?>>
		<thead>
			<th style="text-align:left;">Nombre</th>
			<th style="text-align:center;">Origen</th>
		</thead>
		<tbody>
			<td colspan="2">No hay ningún dato asociado.</td>
		</tbody>
	</table>
<?php 
	} 
?>
</div>


