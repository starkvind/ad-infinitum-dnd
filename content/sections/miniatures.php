<?php
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableMiniatures." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el articulo en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
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
		$pageTitle3 = $miniName; echo "<h2>".$miniName."</h2>"; // Título del Artículo
		if ($miniImage != "") { 
			$miniNewImage = $dydMiniatureImgPath.$miniImage.$dydMiniatureImgExt;
			echo "<img style='width:184px;height:300px;' src='".$miniNewImage."' />"; 
		}
		// ------------------------------------------------------------------ //
		// Información de la Miniatura
		// ------------------------------------------------------------------ //
		echo "<fieldset>";
			if ($miniID_2 != 0) { echo "<legend>ID #".$miniID_2."</legend>"; }
			echo "<ul>";
			if ($miniPrice != "" AND $miniPrice != 0) { $priceCents = substr($miniPrice, -2); $priceMains = substr($miniPrice, 0, -2);
				echo "<li><b>Precio:</b> ".$priceMains.",".$priceCents."&euro;</li>";
			}
			if ($miniCollection != "") { echo "<li><b>Colección:</b> ".$miniCollection."</li>"; }
			if ($miniAvatar != "") { echo "<li><b>Representa a:</b> ".$miniAvatar."</li>"; }
			echo "</ul>";
			//echo $miniText;
		echo "</fieldset>";
		if ($miniText != "") { echo "<p>".nl2br($miniText)."</p>"; }
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
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydMiniaturesFields." FROM ".$dydTableMiniatures." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionMiniatures[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>