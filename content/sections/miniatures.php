<?php
	// Sin un ID numérico, presentamos el catálogo sin ejecutar una búsqueda vacía.
	// Este campo es un entero en la base de datos; nunca se concatena entrada sin validar.
	$idGetData = (string)($page ?? "");
	$dataResult = false;
	if ($idGetData !== "" && ctype_digit($idGetData) && (int)$idGetData > 0) {
		$orderData = "SELECT * FROM ".$dydTableMiniatures." WHERE id = ".(int)$idGetData." LIMIT 1";
		$queryData = mysql_query($orderData, $link);
		if ($queryData && mysql_num_rows($queryData) > 0) {
			$dataResult = mysql_fetch_array($queryData);
		}
	}
	$miniEscape = static function ($value) {
		return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
	};
	if ($dataResult !== false) {
		// ================================================================== //
		// Datos básicos del Artículo
			$miniID_2	 	 	= $dataResult["id_mini"]; 	// ID de la Miniatura en BONES.
			$miniName	 	 	= $dataResult["name"]; 		// Nombre de la Miniatura.
			$miniPrice			= $dataResult["price"];		// Precio de la Miniatura.
			$miniCollection		= $dataResult["collection"];// Colección de la Miniatura.
			$miniImage			= $dataResult["picture"];	// Imagen de la Miniatura.
			$miniText		 	= $dataResult["infotext"]; 	// Información sobre la Miniatura.
			$miniAvatar			= $dataResult["avatar"];	// Avatar a quien representa la Miniatura.
		// ================================================================== //
			$nameSection = "Miniaturas"; $titleName = "Miniatura"; $returnBackSection = "";	$locTab = $nameSection;	$pageTitle2 = $titleName;
			// Localización para pestañas
			$locTab = ""; include_once("contents_tabs.php");
		// ---------------------->
		$pageTitle3 = $miniName; echo "<h2>".$miniEscape($miniName)."</h2>"; // Título del Artículo
		if ($miniImage !== "" && preg_match('/\\A[A-Za-z0-9_-]+\\z/', (string)$miniImage)) {
			$miniNewImage = $dydMiniatureImgPath.$miniImage.$dydMiniatureImgExt;
			echo "<img style='width:184px;height:300px;' alt='".$miniEscape($miniName)."' src='".$miniEscape($miniNewImage)."' />";
		}
		// ------------------------------------------------------------------ //
		// Información de la Miniatura
		// ------------------------------------------------------------------ //
		echo "<fieldset>";
			if ($miniID_2 != 0) { echo "<legend>ID #".(int)$miniID_2."</legend>"; }
			echo "<ul>";
			if ((int)$miniPrice > 0) {
				echo "<li><b>Precio:</b> ".number_format(((int)$miniPrice) / 100, 2, ",", ".")."&euro;</li>";
			}
			if ($miniCollection != "") { echo "<li><b>Colección:</b> ".$miniEscape($miniCollection)."</li>"; }
			if ($miniAvatar != "") { echo "<li><b>Representa a:</b> ".$miniEscape($miniAvatar)."</li>"; }
			echo "</ul>";
			//echo $miniText;
		echo "</fieldset>";
		if ($miniText != "") { echo "<p>".nl2br($miniEscape($miniText))."</p>"; }
		// ------------------------------------------------------------------ //
		echo "<br/>";
		// Fin Hoja
		// ------------------------------------------------------------------ //
	} else {
		// ------------------------------------------------------------------ //
		// Listado de Miniaturas; Texto que aparece si no se elige Hoja		  //
		// ------------------------------------------------------------------ //
			$dataSearchSQL = "";
			$articleType   = "Miniaturas";
			$dataListOrder = "name";
			$pageTitle2 = $articleType;	
			$dataListTitle = $articleType;		
		// ---------------------->
		echo "<h3>".$dataListTitle."</h3>";
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydMiniaturesFields." FROM ".$dydTableMiniatures." ORDER BY name";
			$dataSection	 = $dydSectionMiniatures[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>