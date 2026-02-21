<?php
	$eventAdventure = $eventAdventure ?? "";
	$ostName = $ostName ?? "";
	$ostYtLink = $ostYtLink ?? "";
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableMap." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Lugar en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	// Preparamos el array de otros reinos
	$otherKingdoms	= array("'Zeq&#39;Riel'","'Vilennea'","'Qelasthavia'");
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Lugar
			$placeID	 	 = $dataResult["id"]; 		// ID del Lugar.
			$placeURL	 	 = $dataResult["url"]; 		// URL del Lugar.
			$placeName	 	 = $dataResult["name"]; 	// Nombre del Lugar.
			$placeClass		 = $dataResult["class"];	// Clase del Lugar.
			$placeKingdom	 = $dataResult["kingdom"];	// Reino del Lugar.
			$placeType	 	 = $dataResult["type"];		// Tipo del Lugar
			$placeLat		 = $dataResult["lat"];		// Latitud del Lugar.
			$placeLng		 = $dataResult["lng"];		// Longitud del Lugar.
			$placeOST		 = $dataResult["music"];	// Música del Lugar.
			$placeText		 = $dataResult["infotext"];	// Informacion del Lugar.
			$placeAuthor	 = $dataResult["uploader"];	// Autor del Lugar.
		// ================================================================== //
			// Comprobamos si la localización está en Encuentros.
			$encTerms 		= "SELECT ".$dydBasicFields.", ".$dydEncounterFields." FROM ".$dydTableEncounter." WHERE location_id LIKE ".$placeID." ORDER BY id";
			$encIdQuery		= mysql_query($encTerms, $link);
			$encRows 		= mysql_num_rows($encIdQuery);
			if ($encRows > 0) {
				for ($encRow=0;$encRow<$encRows;$encRow++) {
					$encQueryResult 		= mysql_fetch_array($encIdQuery);
					$encID4ad[$encRow]		= $encQueryResult["id"];
				}
			}			
			// Preparamos el array de otros reinos
			$kingdomDisplay = $placeKingdom;
			if (in_array("'".$placeKingdom."'", $otherKingdoms)) { 
				$placeKingdom = "Otras zonas";
			}
			// Comprobamos si la localización está en Aventuras.
			$instanceTerms 	= "SELECT ".$dydBasicFields.", ".$dydAdventuresFields." FROM ".$dydTableAdventures." WHERE locations LIKE '%".$placeURL."%' ORDER BY id";
			$instanceIdQuery= mysql_query($instanceTerms, $link);
			$instanceRows 	= mysql_num_rows($instanceIdQuery);			
			// Comprobamos si la localización está en Eventos.
			$eventTerms 	= "SELECT ".$dydBasicFields.", ".$dydTimelineFields." FROM ".$dydTableTimeline." WHERE location_id LIKE ".$placeID." ORDER BY id";
			$eventIdQuery	= mysql_query($eventTerms, $link);
			$eventRows 		= mysql_num_rows($eventIdQuery);				
			// Comprobamos si la localización tiene Banda sonora
			$ostTerms 		= "SELECT ".$dydBasicFields.", ".$fieldsOST." FROM ".$tableOST." WHERE url LIKE '".$placeURL."' OR url LIKE '".$placeOST."' LIMIT 1";
			$ostIdQuery		= mysql_query($ostTerms, $link);
			$ostRows 		= mysql_num_rows($ostIdQuery);
			if ($ostRows > 0) { 
				$ostQueryResult	= mysql_fetch_array($ostIdQuery);
				$ostName		= $ostQueryResult["name"];
				$ostYtLink		= $ostQueryResult["yt_link"];
			}
		// Localización para pestañas
		include_once(__DIR__ . "/contents_tabs.php");
		// Sección principal
		$pageTitle3 = $placeName;
		echo "<h2>".$placeName."</h2>"; // Título del evento
		// ------------------------------------------------------------------ //
		// Información de la Localización
		// ------------------------------------------------------------------ //
		echo "<div id='info' class='tab_content'>"; // <=== Contenido del TAB 1
		echo "<fieldset>"; // Cuerpo del evento
			// Preparamos la fecha
			echo "<legend>&nbsp;".$placeType."&nbsp;</legend>";
			echo "<ul>";
				if ($placeKingdom !="") { echo "<li><b>Nación:</b> ".$kingdomDisplay."</li>"; }
				if ($eventAdventure != "") {
					$retrieveFrom = "adventure";
					$dataListAdven = $eventAdventure;
					include (__DIR__ . "/retrieve_origin.php");
					if ($advenName != "") {	echo "<li><b>Aventura:</b> <a href='".$advenLink."' target='_blank'>".$advenName."</a></li>"; }			
				}
				if ($placeAuthor !="") {
					// Cogemos el nombre del Autor
					$dataListAuthor = $placeAuthor;
					$retrieveFrom = "author";
					include (__DIR__ . "/retrieve_origin.php");
					// Mostramos el nombre del Autor
					echo "<li><b>Autor:</b> ".$authorName."</li>";
				}
				if ($placeLat !="" AND $placeLng != "") { echo "<li><b>Localización:</b> <a href='".$mapRoot."?".$placeLat.",".$placeLng."&zom=7' target='_blank'>ver en el mapamundi</a></li>"; }
			echo "</ul>";
			if ($placeText != "") { echo "<p>".$placeText."</p>"; }
		echo "</fieldset>";
		echo "</div>"; // <=== Fin del TAB 1
		// ------------------------------------------------------------------ //
		// Encuentros en los que aparece la Localización
		// ------------------------------------------------------------------ //
		echo "<div id='encounters' class='tab_content'>"; // <=== Contenido del TAB 2
			//echo $eventRows;
			$dataSearchTerms = $encTerms;
			$dataSection	 = $dydSectionEncounter[0];
			// ------------------- >
			// Mostrar Encuentros
			// ------------------- >
			echo "<fieldset class='noInfoLink'>";
				echo "<h3 class='powerTitle'>Encuentros</h3>";
				include(__DIR__ . "/contents_list.php");
			echo "</fieldset>";
		echo "</div>"; // <=== Fin del TAB 2
		// ------------------------------------------------------------------ //
		// Aventuras en los que aparece la Localización
		// ------------------------------------------------------------------ //
		echo "<div id='adventures' class='tab_content'>"; // <=== Contenido del TAB 3
			if ($encRows <= 0) { $encID4ad[0] = -1; }
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydAdventuresFields." FROM ".$dydTableAdventures." WHERE encounters IN (".implode(",",$encID4ad).") OR locations LIKE '%".$placeURL."%'";
			$dataSection	 = $dydSectionAdventures[0];
			// ------------------- >
			// Mostrar Aventuras
			// ------------------- >
			echo "<fieldset class='noInfoLink'>";
				echo "<h3 class='powerTitle'>Aventuras</h3>";
				include(__DIR__ . "/contents_list.php");
			echo "</fieldset>";
		echo "</div>"; // <=== Fin del TAB 3
		// ------------------------------------------------------------------ //
		// Eventos en los que aparece la Localización
		// ------------------------------------------------------------------ //
		echo "<div id='events' class='tab_content'>"; // <=== Contenido del TAB 4
			$dataSearchTerms = $eventTerms;
			$dataSection	 = $dydSectionTimeline[0];
			// ------------------- >
			// Mostrar Aventuras
			// ------------------- >
			echo "<fieldset class='noInfoLink'>";
				echo "<h3 class='powerTitle'>Eventos</h3>";
				include(__DIR__ . "/contents_list.php");
			echo "</fieldset>";
		echo "</div>"; // <=== Fin del TAB 4
		// ------------------------------------------------------------------ //
		// Música de la Localización
		// ------------------------------------------------------------------ //
		echo "<div id='music' class='tab_content' style='text-align:center;'>"; // <=== Contenido del TAB 5
			// ------------------- >
			// Mostrar Música
			// ------------------- >
			if ($ostYtLink != "") {
				echo "<h3>".$ostName."</h3>";
				$musicLink = $ostYtLink;
				include_once(__DIR__ . "/soundtrack_check_yt.php");
			}
		echo "</div>"; // <=== Fin del TAB 5
		// Fin Hoja
		// ------------------------------------------------------------------ //
	echo "<br/>";
	} else {
		// ------------------------------------------------------------------ //
		// Localización para pestañas
		switch($typItem) {
			case "shadaleen":
				$locationZone 	= "Shadaleen";
				$dataSearchSQL 	= "WHERE kingdom LIKE '".$locationZone."'";
			break;
			case "malasthar":
				$locationZone 	= "Malasthar";
				$dataSearchSQL 	= "WHERE kingdom LIKE '".$locationZone."'";
			break;
			case "nerettea":
				$locationZone 	= "Nerettea";
				$dataSearchSQL 	= "WHERE kingdom LIKE '".$locationZone."'";
			break;
			case "eilerenn":
				$locationZone 	= "Éilerenn";
				$dataSearchSQL 	= "WHERE kingdom LIKE '".$locationZone."'";
			break;
			case "others":
				$locationZone 	= "Otras zonas";
				$dataSearchSQL 	= "WHERE kingdom IN (".implode(",",$otherKingdoms).")";			
			break;
			default:
				$dataSearchSQL = "";
			break;
		}
		if ($dataSearchSQL != "") {
			$tabName = $locationZone;
			include_once(__DIR__ . "/contents_tabs.php");
			$locTab = "FK";
			$locationTitle = "Lugares de ".$locationZone;
			$pageTitle3 = $locationZone;
		} else {
			$locationTitle = "Lugares de Ylat";
		}	
		// Mostramos el titulo
		echo "<h3>".$locationTitle."</h3>";
			// Mostramos la lista de Lugares 
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydMapFields." FROM ".$dydTableMap." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionMap[0];
			include(__DIR__ . "/contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>


