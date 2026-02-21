<?php
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableRituals." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Objeto en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);

	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Objeto
			$ritualName  	 = $dataResult["name"]; 		// Nombre del Ritual.
			$ritualFlavor	 = $dataResult["flavortext"];	// Fluff del Ritual.
			$ritualLevel	 = $dataResult["level"];		// Nivel del Ritual.
			$ritualCategory	 = $dataResult["category"];		// Categoría del Ritual.
			$ritualRequired	 = $dataResult["required"];		// Prerrequisito del Ritual
			$ritualTime		 = $dataResult["time"];			// Tiempo de ejecución del Ritual.
			$ritualDuration	 = $dataResult["duration"];		// Duración del Ritual.
			$ritualComponent = $dataResult["componentcost"];// Coste de ejecución del Ritual.
			$ritualPrice	 = $dataResult["price"];		// Precio de mercado del Ritual.
			$ritualFocus	 = $dataResult["focus"];		// Foco del Ritual
			$ritualSkills	 = $dataResult["skills"];		// Habilidad(es) del Ritual.
			$ritualTrained	 = $dataResult["trained"];		// ¿Es necesario tener hab. entrenada?
			$ritualInfotext	 = $dataResult["infotext"];		// Información textual del Ritual.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
		if ($ritualTrained == 0) { $ritualNoTrained = "(sin prueba)"; }
			$goldIconPath	 = $pageRoot."media/icon/coin.png";
			$goldIconSrc	 = "<img src='".$goldIconPath."' title='Piezas de oro' />";
		// Partimos sección Foco para desglosar la info
		if ($ritualFocus != "") {
			$ritualFocus = explode("/", $ritualFocus);
			if ($ritualFocus[1] != "") {
			// Si no hay segunda parte de la sección Foco, es que no hay y no mostramos Moneda
				$ritualFocusIcon = $ritualFocus[1]." <img src='".$goldIconPath."' title='Piezas de oro' />";
			}
		}
		// ================================================================== //
		// Sección principal
		$pageTitle3 = $ritualName;
		// Configuramos el enlace de vuelta
		switch ($ritualCategory) {
			case "Adivinación":
				$returnBackSection = "adivination/";
			break;
			case "Creación":
				$returnBackSection = "creation/";
			break;
			case "Engaño":
				$returnBackSection = "deception/";
			break;
			case "Escudriñamiento":
				$returnBackSection = "scrying/";
			break;
			case "Exploración":
				$returnBackSection = "exploration/";
			break;
			case "Ligadura":
				$returnBackSection = "binding/";
			break;
			case "Protección":
				$returnBackSection = "warding/";
			break;
			case "Restablecimiento":
				$returnBackSection = "restoration/";
			break;
			case "Viaje":
				$returnBackSection = "travel/";
			break;
		}
		// Finalizamos la configuración del enlace de vuelta
	if ($originCanon != 0) {
		echo "<h2>".$ritualName."</h2>";
		// Localización para pestañas
		$locTab = $ritualCategory;
		include_once("contents_tabs.php");
		echo "<fieldset>";
			//echo "<legend></legend>";
			if ($ritualFlavor != "") { echo "<p style='font-style:italic;text-align:left;'>".$ritualFlavor."</p>"; }
			echo "<table id='ritualTable'>";
				echo "<tr>";
					// Nivel del Ritual
					echo "<td><b>Nivel:</b> ".$ritualLevel."</td>";
					// Coste de componentes del Ritual
					if ($ritualComponent != 0) {
						echo "<td><b>Coste de componentes:</b> ".$ritualComponent." ".$goldIconSrc."</td>";
					} else {
						echo "<td><b>Coste de componentes:</b> especial</td>";
					}
				echo "</tr>";
				echo "<tr>";
					// Categoría del Ritual
					echo "<td><b>Categoría:</b> ".$ritualCategory."</td>";
					// Precio de mercado del Ritual
					if ($ritualPrice != 0) {
						echo "<td><b>Precio de mercado:</b> ".$ritualPrice." ".$goldIconSrc."</td>";
					} else {
						echo "<td><b>Precio de mercado:</b> ninguno</td>";
					}
				echo "</tr>";
				echo "<tr>";
					// Tiempo de ejecución del Ritual
					echo "<td><b>Tiempo:</b> ".$ritualTime."</td>";
					// Habilidad clave del Ritual
					echo "<td><b>Habilidad clave:</b> ".$ritualSkills." ".$ritualNoTrained."</td>";
				echo "</tr>";
				echo "<tr>";
					// Duración del Ritual
					echo "<td colspan='2'><b>Duración:</b> ".$ritualDuration."</td>";
				echo "</tr>";
			if ($ritualRequired != "" OR $ritualFocus != "") {
				echo "<tr>";
					// Requisitos
					if ($ritualRequired != "") { echo "<td><b>Prerrequisito:</b> ".$ritualRequired."</td>"; }
					// Foco del Ritual
					if ($ritualFocus != "") { echo "<td><b>Foco:</b> ".$ritualFocus[0]." ".$ritualFocusIcon."</td>"; }
				echo "</tr>";
			}
			echo "</table>";
			if ($ritualInfotext != "") { echo "<p id='ritualText'>".$ritualInfotext."</p>"; }
		echo "</fieldset>";
		// Fin Hoja
		echo "<br/>";
		// ------------------------------------------------------------------ //
		} else {
			echo $phraseNoAuth;
		}
	} else {
		// ------------------------------------------------------------------ //
			switch($typItem) {
				default:
					$ritualWhereTerm = "";
					$ritualTitle = "Lista de rituales";
				break;
				case "adivination":
					$ritualWhereTerm = "Adivinación";
				break;
				case "creation":
					$ritualWhereTerm = "Creación";
				break;
				case "deception":
					$ritualWhereTerm = "Engaño";
				break;
				case "scrying":
					$ritualWhereTerm = "Escudriñamiento";
				break;
				case "exploration":
					$ritualWhereTerm = "Exploración";
				break;
				case "binding":
					$ritualWhereTerm = "Ligadura";
				break;
				case "warding":
					$ritualWhereTerm = "Protección";
				break;
				case "restoration":
					$ritualWhereTerm = "Restablecimiento";
				break;
				case "travel":
					$ritualWhereTerm = "Viaje";
				break;
			}
		// Localización para pestañas
		if ($ritualWhereTerm != "") {
			$locTab = "K"; // Le damos un valor para que no de la murga
			$tabName = $ritualWhereTerm;
			include_once("contents_tabs.php");
		}
			echo "<h3>";
			if ($ritualTitle != "") {
				echo $ritualTitle;
			} else {
				echo "Rituales de ".strtolower($ritualWhereTerm);
			}
			echo "</h3>";
			// Si tenemos datos del GET, hacemos cosas de SQL; si no, no hacemos nada
			if ($typItem !="" OR $ritualWhereTerm !="") { 
				$ritualWhereOption = "WHERE category LIKE '".$ritualWhereTerm."'"; 
			} else {
				$ritualWhereOption = "WHERE name NOT LIKE ''";
			}
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydRitualsFields." FROM ".$dydTableRituals." ".$ritualWhereOption."";
			$dataSection	 = $dydSectionRituals[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>
