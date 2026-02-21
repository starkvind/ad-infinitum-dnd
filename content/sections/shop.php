<?php
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableShops." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos la tienda en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos de la Tienda
			$shopName 		= $dataResult["name"]; 		// Nombre de la tienda.
			$shopRandom		= $dataResult["random"]; 	// Aleatoria de la tienda.
			$shopCoin		= $dataResult["coin"]; 		// Moneda de la tienda.
			$shopInfotext 	= $dataResult["infotext"];	// Texto de la tienda.
			$shopItems	 	= $dataResult["items"]; 	// Objetos de la tienda.
		// ================================================================== //
		// Localización para pestañas
		include_once("contents_tabs.php");
		// ---------------------->
		$pageTitle2 = "Bazar";
		$pageTitle3 = $shopName;
		echo "<h2>".$shopName."</h2>"; // Título de la tienda
		// ------------------------------------------------------------------ //
		// Información de la tienda
		// ------------------------------------------------------------------ //
		echo "<div id='main' class='tab_content'>"; // <=== Contenido del TAB 1
		echo "<fieldset class='articleBody'>";
			// Colocamos la información
			if ($shopInfotext == "") { $shopInfotext = "Esta tienda no dispone de descripción."; }
			$infoSplit  = explode("|", $shopInfotext);
			echo "<p>".$infoSplit[0]."</p>";
			// Si tenemos información ampliada, la mostramos
			if ($infoSplit[1] != "") { echo "<p>".$infoSplit[1]."</p>"; }
		echo "</fieldset>";
		// Tabla de objetos
		if ($shopItems !="") {
		echo "<h3 style='margin-top:24px;'>Objetos en venta</h3>";
			if ($shopRandom == 1) { $randomItems = "ORDER BY RAND() LIMIT 5"; } else { $randomItems = ""; }
			$shopItems = explode(",",$shopItems);
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydMagicItemsFields." FROM ".$dydTableMagicItems." WHERE id IN(".implode(",", $shopItems).") ".$randomItems.""; 
			$dataSection	 = $dydSectionMagicItems[0];
			include("contents_list.php");
		}
		echo "</div>"; // <=== Fin del TAB 1
		// ------------------------------------------------------------------ //
		if ($shopItems !="" AND $shopRandom == 1) {
			echo "<div id='list' class='tab_content'>"; // <=== Contenido del TAB 2
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydMagicItemsFields." FROM ".$dydTableMagicItems." WHERE id IN(".implode(",", $shopItems).")"; 
				$dataSection = $dydSectionMagicItems[0];
				$fullList = 1;
				include("contents_list.php");
			echo "</div>"; // <=== Fin del TAB 2
		}
		// ------------------------------------------------------------------ //
		echo "<br/>";
		// Fin Hoja
		// ------------------------------------------------------------------ //
	} else {
		// ------------------------------------------------------------------ //
		// Listado de Aventuras; Texto que aparece si no se elige Hoja		  //
		// Configuramos el enlace de vuelta y título
			$dataSearchSQL = "WHERE name NOT LIKE ''";
			$shopTitle  = "Bazares";	
			$dataListTitle = $shopTitle;		
		// Finalizamos la configuración del enlace de vuelta y título
		// ---------->
		echo "<h3>".$dataListTitle."</h3>";
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydShopsFields." FROM ".$dydTableShops." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionShops[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>