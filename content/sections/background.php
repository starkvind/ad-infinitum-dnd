<?php
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableBackgrounds." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Trasfondo en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Trasfondo
			$bgName 	 	 = $dataResult["name"]; 		// Nombre del Trasfondo.
			$bgClass		 = $dataResult["class"];		// Clase/raza/etc del Trasfondo.
			$bgText		 	 = $dataResult["infotext"];		// Texto del trasfondo.
			$bgSkills		 = $dataResult["skills"];		// Habilidades asociadas con el Trasfondo.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
		if ($originCanon != 0) {
		// Sección principal
		$pageTitle3 = $bgName;
		// Localización para pestañas
			include_once("contents_tabs.php");
		// Configuramos el enlace a la clase
			include_once("content_classlink.php");
		// ================================================================== //
		echo "<h2>".$bgName."</h2>"; // Título del Trasfondo
		echo "<fieldset class='fieldBackground'>"; // Cuerpo del trasfondo
			if ($bgClass != "") { echo "<legend>Trasfondo de ".strtolower($bgClass)."</legend>"; }
			if ($bgText != "") { echo $bgText; }
			if ($bgSkills != "") { echo "<p><i>Habilidades asociadas:</i> ".$bgSkills."</p>"; }
		echo "</fieldset>";
		// Fin Hoja
		// ------------------------------------------------------------------ //
	echo "<br/>";
		} else {
			echo $phraseNoAuth;
		}
	} else {
		// ------------------------------------------------------------------ //
			switch($typItem) {
				case "origins":
					$bgChosen = array('Nacimiento','Geografía','Origen','Regional');	
					$bgTitle = "Orígenes y nacimiento";
				break;
				case "occupation":
					$bgChosen = array('Oficio','Madurez','Aventurero');
					$bgTitle = "Oficios";
				break;
				case "society":
					$bgChosen = array('Sociedad','Psicología');
					$bgTitle = "Sociedad y psicología";
				break;
				case "racial":
					$queryRaces 	= "SELECT name FROM races";
					$idQueryRaces	= mysql_query($queryRaces, $link);
					$rowsRaces		= mysql_num_rows($idQueryRaces);
					if ($rowsRaces != 0) {
						for($i=0;$i<$rowsRaces;$i++) {
							$queryRaceName = mysql_fetch_array($idQueryRaces);
								$bgChosen[$i] = $queryRaceName["name"];
						}
					}
					$bgTitle = "Raciales";
				break;
				case "campaign":
					$bgChosen = array(
						'Legado de Acererak',
						'Casa Cannith',
						'Casa Deneith',
						'Casa Ghallanda',
						'Casa Jorasco',
						'Casa Kundarak',
						'Casa Lyrandar',
						'Casa Medani',
						'Casa Orien',
						'Casa Phiarlan',
						'Casa Sivis',
						'Casa Tharashk',
						'Casa Thuranni',
						'Casa Vadalis'
					);
					$bgTitle = "Campañas";
				break;
			}
			if ($bgChosen != "") { 
				$bgWhere = "WHERE class IN('".implode("', '", $bgChosen)."')"; 
			} else {
				$bgWhere = "WHERE name NOT LIKE ''";
				$bgTitle = "Listado de trasfondos";
			}
		// Localización para pestañas
		if ($bgTitle != "Listado de trasfondos") {
			include_once("contents_tabs.php");
		// Colocar Título
			switch($typItem) {
				case "racial":
					$bgTitle = "Trasfondos ".strtolower($bgTitle);
				break;
				case "campaign":
					$bgTitle = "Trasfondos de ".strtolower($bgTitle);
				break;
			}
		}
		// ---------->
		echo "<h3>".$bgTitle."</h3>";
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydBackgroundsFields." FROM ".$dydTableBackgrounds." ".$bgWhere."";
			$dataSection	 = $dydSectionBackgrounds[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>
