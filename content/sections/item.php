<?php
	if ($page != 0) {
	// ================================================================== //
	echo "<div id='card' class='tab_content'>"; // <=== Contenido del TAB 1
		echo "<div id='powerItemLayout'>";
			$powerId = $page; // Damos la id del dato.
			include ("item_card.php");
			$pageTitle3 = $itemName;
		echo "</div>";
	echo "</div>";
	// ================================================================== //
	// Configuramos el enlace de vuelta
	switch ($itemBdType) {
		case 0: // Consumibles
			$returnBackSection = "consumables/";
			$titleName = "Consumible";
		break;
		case 1: // Armas
			$returnBackSection = "weapons/";
			$titleName = "Arma";
		break;
		case 2: // Armaduras
			$returnBackSection = "armors/";
			$titleName = "Armadura";
		break;
		case 3: // Accesorios
			$returnBackSection = "trinkets/";
			$titleName = "Accesorio";
		break;
		case 4: // Maravillas
			$returnBackSection = "wonders/";
			$titleName = "Maravilla";
		break;
		case 5: // Recompensas alternativas
			$returnBackSection = "alternative/";
			$titleName = "Recompensa alternativa";
		break;
		case 6: // Utensilios
			$returnBackSection = "implements/";
			$titleName = "Utensilio";
		break;
	}
	// Finalizamos la configuración del enlace de vuelta
	echo "<div id='pict' class='tab_content'>"; // <=== Contenido del TAB 2
		echo "<div id='powerItemLayout'>";
			$itemPic = $dydItemImgPath.$itemPicture.$dydItemImgExt;
			echo "<center>";
				echo "<a href='".$itemPic."' target='_blank'>";
					echo "<img src='".$itemPic."' class='enemyPic' alt='".$itemName."' title='".$itemName."' />";
				echo "</a>";
			echo "</center>";
		echo "</div>";
	echo "</div>";
	echo "<br/>";
	// Finalizamos el TAB 2
	if ($titleName != "") { $pageTitle2 = $titleName; }
		// Localización para pestañas
		include_once("contents_tabs.php");
	} else {
		// ------------------------------------------------------------------ //
		$powerBazaar = "";
			switch($typItem) {
				case "consumables":
					$dataSearchSQL = "WHERE bd_type LIKE 0";
					$powerTypeTitle = "Consumibles";
					$changeTitle2 = TRUE;
				break;
				case "weapons":
					$dataSearchSQL = "WHERE bd_type LIKE 1";
					$powerTypeTitle = "Armas";
					$changeTitle2 = TRUE;
				break;
				case "armors":
					$dataSearchSQL = "WHERE bd_type LIKE 2";
					$powerTypeTitle = "Armaduras";
					$changeTitle2 = TRUE;
				break;
				case "implements":
					$dataSearchSQL = "WHERE bd_type LIKE 6";
					$powerTypeTitle = "Utensilios";
					$changeTitle2 = TRUE;
				break;
				case "trinkets":
					$dataSearchSQL = "WHERE bd_type LIKE 3";
					$powerTypeTitle = "Accesorios";
					$changeTitle2 = TRUE;
				break;
				case "wonders":
					$dataSearchSQL = "WHERE bd_type LIKE 4";
					$powerTypeTitle = "Maravillas";
					$changeTitle2 = TRUE;
				break;
				case "alternative":
					$dataSearchSQL = "WHERE bd_type LIKE 5";
					$powerTypeTitle = "Recompensas alternativas";
					$changeTitle2 = TRUE;
				break;
				case "campaign":
					$dataSearchSQL = "WHERE reward LIKE 1";
					$powerTypeTitle = "Tesoro de las aventuras";
					$changeTitle2 = TRUE;
				break;
				default:
					$dataSearchSQL = "WHERE name NOT LIKE ''";
					$powerTypeTitle = "Lista de objetos mágicos";
					$changeTitle2 = FALSE;
				break;
			}
		if ($changeTitle2 != FALSE) { $pageTitle3 = $powerTypeTitle; }
		// Localización para pestañas
		if ($powerTypeTitle != "Lista de objetos mágicos") {
			$locTab = "K"; // Le damos un valor para que no de la murga
			$tabName = $powerTypeTitle;
			include_once("contents_tabs.php");
		}
		// ---------->
		echo "<h3>".$powerTypeTitle."</h3>";
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydMagicItemsFields." FROM ".$dydTableMagicItems." ".$dataSearchSQL." ".$powerBazaar."";
			$dataSection	 = $dydSectionMagicItems[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>