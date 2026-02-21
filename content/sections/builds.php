<?php
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableBuilds." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Objeto en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Objeto
			$buildName 	 = $dataResult["name"]; 		// Nombre del Diseño.
			$buildClass	 = $dataResult["class"];		// Clase/raza/etc del Diseño.
			$buildSource = $dataResult["source"];		// Fuente de poder del Diseño.
			$buildInfo	 = $dataResult["infotext"];		// Información del Diseño.
			$buildFeat	 = $dataResult["feat"];			// Dote del Diseño.
			$buildTrait	 = $dataResult["trait"];		// Rasgo del Diseño.
			$buildSkills = $dataResult["skills"];		// Habilidades del Diseño.
			$buildPowers = $dataResult["powers"];		// Poderes del Diseño.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
		// Sección principal
		$pageTitle2 = "Diseño";
		$pageTitle3 = $buildName;
		if ($originCanon != 0) {
		echo "<h2>".$buildName."</h2>"; // Título del Diseño
			echo "<fieldset>";
				echo "<legend>Diseño de ".strtolower($buildClass)."</legend>";
				if ($buildInfo != "") { echo "<p>".$buildInfo."</p>"; }
				echo "<ul>";
					if ($buildTrait != "") { echo "<li><b>Rasgo de clase sugerido:</b> ".$buildTrait.".</li>"; }
					if ($buildFeat != "") { 
						$feats = explode("|", $buildFeat);
						echo "<li><b>Dote sugerida:</b> ".$feats[0].".</li>";
						if ($feats[1] != "") { echo "<li><b>Dote humana:</b> ".$feats[1].".</li>"; } 
					}
					if ($buildSkills != "") { echo "<li><b>Habilidades sugeridas:</b> ".$buildSkills.".</li>"; }
					if ($buildPowers != "") { 
						$powers = explode("|", $buildPowers);
						if ($powers[0] != "") { echo "<li><b>Poderes a voluntad sugeridos:</b> ".$powers[0].".</li>"; }
						if ($powers[1] != "") { echo "<li><b>Poder de encuentro sugerido:</b> ".$powers[1].".</li>"; }
						if ($powers[2] != "") { echo "<li><b>Poder diario sugerido:</b> ".$powers[2].".</li>"; }
					}
				echo "</ul>";
			echo "</fieldset>";
		// Localización para pestañas
		include_once("contents_tabs.php");
		// Configuramos el enlace a la clase
		include_once("content_classlink.php");
			echo "<br/>";
		} else {
			echo $phraseNoAuth;
		}
	} else {
	// ------------------------------------------------------------------ //
	// Listado de fuentes de Poder; Texto que aparece si no se elige Hoja //
		switch($typItem) {
			case "martial":	// Marciales
				$buildTypeTitle = "Marciales";
				$dataSearchSQL = "WHERE source LIKE 'Marcial'";
			break;
			case "arcane":	// Arcanos
				$buildTypeTitle = "Arcanos";
				$dataSearchSQL = "WHERE source LIKE 'Arcano'";
			break;
			case "divine":	// Divinos
				$buildTypeTitle = "Divinos";
				$dataSearchSQL = "WHERE source LIKE 'Divino'";
			break;
			case "primal":	// Primigenios
				$buildTypeTitle = "Primigenios";
				$dataSearchSQL = "WHERE source LIKE 'Primigenio'";
			break;
			case "psionic":	// Psiónicos
				$buildTypeTitle = "Psiónicos";
				$dataSearchSQL = "WHERE source LIKE 'Psiónico'";
			break;
			case "shadow":	// Sombríos
				$buildTypeTitle = "Sombríos";
				$dataSearchSQL = "WHERE source LIKE 'Sombrío'";
			break;
			case "others":	// Otras fuentes de poder
				$buildTypeTitle = "Misceláneos";
				$dataSearchSQL = "WHERE source LIKE ''";
			break;
			default:
				$buildTypeTitle = "";
				$dataSearchSQL = "WHERE name NOT LIKE ''";
			break;
		}
	// ------------------------------------------------------------------ //
	// Localización para pestañas
	if ($buildTypeTitle != "") {
		$locTab = "K"; // Le damos un valor para que no de la murga
		$tabName = $buildTypeTitle;
		include_once("contents_tabs.php");
	}
	// Mostramos listado de contenido
	echo "<h3>Diseños ".strtolower($buildTypeTitle)."</h3>";
		$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydBuildsFields." FROM ".$dydTableBuilds." ".$dataSearchSQL."";
		$dataSection	 = $dydSectionBuilds[0];
	include("contents_list.php");
	// ------------------------------------------------------------------ //
	}
?>
