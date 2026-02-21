<?php
	$typItem = $typItem ?? "";
	$dataSubType = $dataSubType ?? "";
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableArticles." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el articulo en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Artículo
			$articleName 	 	= $dataResult["name"]; 		// Nombre del articulo.
			$articleImage		= $dataResult["image"];		// Imagen del articulo.
			$articleBodytext 	= $dataResult["bodytext"]; 	// Cuerpo del articulo.
			$articleMoreData 	= $dataResult["more_data"];	// Datos adicionales del articulo.
			$articleType	 	= $dataResult["type"]; 		// Tipo del articulo.
			$articleSubType	 	= $dataResult["subtype"]; 	// Subtipo del articulo.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// Comprobación de sesión
		if ($originCanon != 0) {
		// ================================================================== //
			switch ($articleType) {
				case "deity":
					$nameSection = "Deidades";
					$titleName = "Deidad";
					$returnBackSection = "deities/";
				break;
				case "alignment":
					$nameSection = "Alineamientos";
					$titleName = "Alineamiento";
					$returnBackSection = "alignments/";
				break;
				case "language":
					$nameSection = "Idiomas";
					$titleName = "Idioma";
					$returnBackSection = "languages/";
				break;
				case "condition":
					$nameSection = "Condiciones";
					$titleName = "Condición";
					$returnBackSection = "conditions/";
				break;
				default:
					$nameSection = "Artículos";
					$titleName = "Artículo";
					$returnBackSection = "";
				break;
			}
			$locTab = $nameSection;
			$pageTitle2 = $titleName;
		// Localización para pestañas
		if ($nameSection == "Artículos") { $locTab = ""; } // Si es un articulo per se, solo mostramos una cosa para que no quede culo
		include_once(__DIR__ . "/contents_tabs.php");
		// ---------------------->
		$pageTitle3 = $articleName;
		echo "<h2>".$articleName."</h2>"; // Título del Artículo
		if ($articleImage != "") { echo "<img src='".$pageRoot.$articleImage."' />"; }
		// ------------------------------------------------------------------ //
		// Información del Artículo
		// ------------------------------------------------------------------ //
		echo "<fieldset class='articleBody'>";
			if ($articleSubType != "") { echo "<legend>".$articleSubType."</legend>"; }
			if ($titleName == "Idioma") { echo "<p>"; }
			echo $articleBodytext;
			if ($titleName == "Idioma") { echo "</p>"; }
		echo "</fieldset>";
		// ------------------------------------------------------------------ //
		echo "<br/>";
		// Fin Hoja
	} else {
		echo $phraseNoAuth;
	}
		// ------------------------------------------------------------------ //
	} else {
		// ------------------------------------------------------------------ //
		// Listado de Artículos; Texto que aparece si no se elige Hoja		  //
		// Configuramos el enlace de vuelta y título
			switch($typItem) {
				case "deities":
					$dataSearchSQL = "WHERE type LIKE 'deity' ".$dataSubType."";
					$articleType   = "Deidades";
					$dataListOrder = "name";
				break;
				case "alignments":
					$dataSearchSQL = "WHERE type LIKE 'alignment'";
					$articleType   = "Alineamientos";
					$dataListOrder = "id";
				break;
				case "languages":
					$dataSearchSQL = "WHERE type LIKE 'language'";
					$articleType   = "Idiomas";
					$dataListOrder = "name";
				break;
				case "conditions":
					$dataSearchSQL = "WHERE type LIKE 'condition'";
					$articleType   = "Condiciones";
					$dataListOrder = "name";
				break;
				default:
					$dataSearchSQL = "WHERE type LIKE 'article'";
					$articleType   = "Artículos";
					$dataListOrder = "name";
				break;
			}
			$pageTitle2 = $articleType;	
			$dataListTitle = $articleType;		
		// Localización para pestañas
		if ($articleType != "Artículos") {
			$tabName = $articleType;
			$locTab = "K";
			include_once(__DIR__ . "/contents_tabs.php");
		}
		// ---------->
		echo "<h3>".$dataListTitle."</h3>";
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydArticlesFields." FROM ".$dydTableArticles." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionArticles[0];
		include(__DIR__ . "/contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>

