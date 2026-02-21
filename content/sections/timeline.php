<?php
	$eventType = $eventType ?? "";
	$dataSearchSQL = $dataSearchSQL ?? "ORDER BY adventure_id";
	$ostName = $ostName ?? "";
	$ostYtLink = $ostYtLink ?? "";
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableTimeline." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Evento en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos de la Acción
			$eventURL	 	 = $dataResult["url"]; 			// URL del Evento.
			$eventName	 	 = $dataResult["name"]; 		// Nombre del Evento.
			$eventDay		 = $dataResult["day"];			// Día del Evento.
			$eventMonth		 = $dataResult["month"];		// Mes del Evento.
			$eventYear	 	 = $dataResult["year"];			// Año del Evento.
			$eventType		 = $dataResult["type"];			// Tipo del Evento.
			$eventAdventure	 = $dataResult["adventure_id"];	// Aventura en la que sucede el Evento.
			$eventLocation	 = $dataResult["location_id"];	// Lugar donde sucede el Evento.
			$eventMusic		 = $dataResult["music"];		// Música del Evento.
			$eventText		 = $dataResult["infotext"];		// Informacion del Evento.
			$eventAuthor	 = $dataResult["uploader"];		// Autor del Evento.
		// ================================================================== //
			// Comprobamos si la localización tiene Banda sonora
			$ostTerms 		= "SELECT ".$dydBasicFields.", ".$fieldsOST." FROM ".$tableOST." WHERE url LIKE '".$eventURL."' OR url LIKE '".$eventMusic."' LIMIT 1";
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
		$pageTitle3 = $eventName;
		echo "<h2>".$eventName."</h2>"; // Título del evento
		// ------------------------------------------------------------------ //
		// Información del Evento
		// ------------------------------------------------------------------ //
		echo "<div id='info' class='tab_content'>"; // <=== Contenido del TAB 1
		echo "<fieldset>"; // Cuerpo del evento
			// Preparamos la fecha
			$ylatDate = $eventYear."-".$eventMonth."-".$eventDay;
			if ($eventType !="") { echo "<legend>".$eventType."</legend>"; }
			echo "<ul>";
				if ($ylatDate !="") { echo "<li><b>Fecha:</b> ".nuevaFecha($ylatDate)."</li>"; }
				if ($eventLocation != "") {
					$retrieveFrom = "location";
					$dataListLoc = $eventLocation;
					include (__DIR__ . "/retrieve_origin.php");
					if ($locName != "") {	echo "<li><b>Lugar:</b> <a href='".$locLink."' target='_blank'>".$locName."</a></li>"; }			
				}
				if ($eventAdventure != "") {
					$retrieveFrom = "adventure";
					$dataListAdven = $eventAdventure;
					include (__DIR__ . "/retrieve_origin.php");
					if ($advenName != "") {	echo "<li><b>Aventura:</b> <a href='".$advenLink."' target='_blank'>".$advenName."</a></li>"; }			
				}
			echo "</ul>";
			if ($eventText != "") { echo "<p>".$eventText."</p>"; }
		echo "</fieldset>";
		echo "</div>"; // <=== Fin del TAB 1
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
		include_once(__DIR__ . "/timeline_type_convert.php");
		// Localización para pestañas
		if ($eventType != "") {
			$dataSearchSQL = "WHERE type LIKE '".$eventType."' ORDER BY adventure_id";
			// Si no tenemos nada porque es "others", mostramos un texto.
			$pageTitle2 = "Línea temporal";
			$dataListTitle = $eventType;
			$locTab = "FK";
			$tabName = $eventType;
			include_once(__DIR__ . "/contents_tabs.php");
			$pageTitle3 = $eventType;
		}
		echo "<h3>".$eventTitle."</h3>";
			// Mostramos la lista de Eventos 
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydTimelineFields." FROM ".$dydTableTimeline." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionTimeline[0];
			include(__DIR__ . "/contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>
