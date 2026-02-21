<?php
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableBestiary." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos la Familia de monstruos en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos de la Acción
			$monsterID		= $dataResult["id"]; 		// ID de la familia de Monstruos.
			$monsterName	= $dataResult["name"]; 		// Nombre de la familia de Monstruos.
			$monsterText	= $dataResult["infotext"];	// Informacion de la familia de monstruos.
			$monsterSkill	= $dataResult["skill"];		// Habilidad para conocer información.
			$monsterKnowl	= $dataResult["knowtext"];	// Tipo de la Acción.
		// ================================================================== //
		// Conseguimos datos del Origen
		include_once(__DIR__ . "/content_origin.php");
		// Conseguimos tarjetas de monstruo con la misma Familia
		include_once("book_getmonsters.php");
		// ================================================================== //
		// Localización para pestañas
		include_once("contents_tabs.php");
		// Sección principal
		$pageTitle3 = $monsterName;
		if ($originCanon != 0) {
		echo "<h2>".$monsterName."</h2>"; // Título de la Familia de Monstruos
		echo "<div id='info' class='tab_content'>";
			echo "<fieldset>"; // Cuerpo de la Información
				if ($monsterSkill !="") { echo "<legend>".$monsterSkill."</legend>"; }
				if ($monsterText != "") { echo "<p>".$monsterText."</p>"; }
				if ($monsterKnowl != "") { 
					echo "<h4>Conocimientos sobre ".$monsterName."</h4>";
					echo "<ul>".$monsterKnowl."</ul>"; 
				}
			echo "</fieldset>";
		echo "</div>";
		// Listado de Monstruos de esta Familia
		echo "<div id='monsters' class='tab_content'>";
			echo "<p>El bestiario contiene las siguientes criaturas de tipo <b>".$monsterName."</b>.</p>";
			$dataSearchSQL = "WHERE book LIKE ".$monsterID;
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydCreaturesFields." FROM ".$dydTableCreatures." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionCreatures[0];
			include("contents_list.php");
		echo "</div>"; 
		// Fin Hoja
		// ------------------------------------------------------------------ //
	echo "<br/>";
		} else {
			echo $phraseNoAuth;
		}
	} else {
		// ------------------------------------------------------------------ //
		echo "<h3>Bestiario</h3>";
			// Si tenemos datos del GET, hacemos cosas de SQL; si no, no hacemos nada
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydBestiaryFields." FROM ".$dydTableBestiary."";
				$dataSection	 = $dydSectionBestiary[0];
			include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>
