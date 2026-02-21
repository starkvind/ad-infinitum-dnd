<?php
	// bibliography.php - mysqli version manteniendo la lógica original

	// Si no hay conexión definida, intentamos incluir la configuración
	if (!isset($link)) {
		@include_once("content/rosetta.php"); // debe definir $link, $bdd, $dyd... etc.
	}

	// Cogemos datos del GET "page"
	$idGetData = $page ?? "";

	// Si tenemos conexión, escapamos $page para evitar inyecciones y problemas con comillas
	if ($idGetData !== "" && isset($link)) {
		$idGetData = mysqli_real_escape_string($link, $idGetData);
	}

	if ($page != "") {
		// Elegimos el Objeto en la Base de Datos
		$orderData = "SELECT * FROM ".$dydTableBibliography." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;";

		$queryData = (isset($link)) ? mysqli_query($link, $orderData) : false;
		$rowsData = ($queryData) ? mysqli_num_rows($queryData) : 0;

		if ($rowsData != 0 && $queryData) { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
			$dataResult = mysqli_fetch_assoc($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
			// ================================================================== //
			// Datos básicos del Objeto
				$sourceID	= $dataResult["id"]; 		// ID del libro.
				$sourceName	= $dataResult["name"]; 		// Nombre del libro.
				$sourceDate	= $dataResult["date"];		// Fecha de publicación.
				$sourceISBN	= $dataResult["isbn"];		// Nº de ISBN del libro.
				$sourcePubl	= $dataResult["publisher"];	// Editorial del libro.
				$sourceIcon	= $dataResult["icon"];		// Icono asignado a las clases y razas del libro.
				$sourceText	= $dataResult["infotext"];	// Información sobre el libro.
				$sourceImg	= $dataResult["image"];		// Imagen de la publicación.
				$sourceCano	= $dataResult["canon"];		// Binario sobre si es oficial el libro o no.
			// ================================================================== //
			// Sección principal
			$pageTitle3 = $sourceName;
			echo "<h2>".$sourceName."</h2>"; // Título de la Dote
			// Localización para pestañas
				include_once("contents_tabs.php");
			// Información básica
			echo "<div id='info' class='tab_content'>"; // <=== Contenido del TAB 1
			if ($sourceImg != "") { echo "<img src='".$dydBibliographyImgPath.$sourceImg."' />"; }
			if ($sourceISBN != 0 OR $sourcePubl != "" OR $sourceDate != "0000-00-00") {
				echo "<fieldset>";
					echo "<legend>Detalles</legend>";
						echo "<ul>";
						if ($sourceISBN != 0) { echo "<li><b>ISBN:</b> ".$sourceISBN."</li>"; } // ISBN del libro
						if ($sourcePubl != "") { echo "<li><b>Editorial:</b> ".$sourcePubl."</li>"; } // Editorial del libro
						if ($sourceDate != "0000-00-00") { echo "<li><b>Fecha de publicación:</b> ".$sourceDate."</li>"; } 	// Fecha de publicación
						echo "</ul>";
				echo "</fieldset>";
			}
			if ($sourceText != "") { echo "<p style='padding-left:8px;'>".$sourceText."</p>"; }
			echo "</div>"; // // <--- Fin contenido TAB 1
			// Contenido de la web
			echo "<div id='cweb' class='tab_content'>"; // <=== Contenido del TAB 2
				$tableFromBiblio = TRUE;
?>
<!-- Menú de secciones -->
<ul class="bibloTabs">
	<a href="#"><li>Artículos</li></a>
	<a href="#"><li>Aflicciones</li></a>
	<a href="#"><li>Razas</li></a>
	<a href="#"><li>Clases</li></a>
	<a href="#"><li>Trasfondos</li></a>
	<a href="#"><li>Poderes</li></a>
	<a href="#"><li>Dotes</li></a>
	<a href="#"><li>Objetos</li></a>
	<a href="#"><li>Vehículos</li></a>
	<a href="#"><li>Rituales</li></a>
	<a href="#"><li>Criaturas</li></a>
</ul>
<!-- Material de las secciones -->
<div class="bibloContent">
<?php
				// ------------------- >
				// Artículos del libro.
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydArticlesFields." FROM ".$dydTableArticles." WHERE origin LIKE '".$sourceID."'";
				$dataSection	 = "articles";
				// ------------------- >
				// Mostrar Articulos
				// ------------------- >
				include("race_class_content.php");
				echo "<div>";
					echo "<fieldset class='noInfoLink'>";
						echo "<h3 class='powerTitle'>Artículos</h3>";
						include("contents_list.php");
					echo "</fieldset>";
				echo "</div>";
				// ------------------- >
				// Aflicciones del libro.
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydAilmentsFields." FROM ".$dydTableAilments." WHERE origin LIKE '".$sourceID."'";
				$dataSection	 = "ailments";
				// ------------------- >
				// Mostrar Aflicciones
				// ------------------- >
				include("race_class_content.php");
				echo "<div>";
					echo "<fieldset class='noInfoLink'>";
						echo "<h3 class='powerTitle'>Aflicciones</h3>";
						include("contents_list.php");
					echo "</fieldset>";
				echo "</div>";
				// ------------------- >
				// Razas del libro.
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydRacesFields." FROM ".$dydTableRaces." WHERE origin LIKE '".$sourceID."'";
				$dataSection	 = "races";
				// ------------------- >
				// Mostrar Razas
				// ------------------- >
				include("race_class_content.php");
				echo "<div>";
					echo "<fieldset class='noInfoLink'>";
						echo "<h3 class='powerTitle'>Razas</h3>";
						include("contents_list.php");
					echo "</fieldset>";
				echo "</div>";
				// ------------------- >
				// Clases del libro.
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydClassesFields." FROM ".$dydTableClasses." WHERE origin LIKE '".$sourceID."'";
				$dataSection	 = "classes";
				// ------------------- >
				// Mostrar Clases
				// ------------------- >
				include("race_class_content.php");
				echo "<div>";
					echo "<fieldset class='noInfoLink'>";
						echo "<h3 class='powerTitle'>Clases</h3>";
						include("contents_list.php");
					echo "</fieldset>";
				echo "</div>";
				// ------------------- >
				// Trasfondos del libro.
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydBackgroundsFields." FROM ".$dydTableBackgrounds." WHERE origin LIKE '".$sourceID."'";
				$dataSection	 = "backgrounds";
				// ------------------- >
				// Mostrar Trasfondos
				// ------------------- >
				include("race_class_content.php");
				echo "<div>";
					echo "<fieldset class='noInfoLink'>";
						echo "<h3 class='powerTitle'>Trasfondos</h3>";
						include("contents_list.php");
					echo "</fieldset>";
				echo "</div>";
				// ------------------- >
				// Poderes del libro.
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydPowersFields." FROM ".$dydTablePowers." WHERE origin LIKE '".$sourceID."'";
				$dataSection	 = "powers";
				// ------------------- >
				// Mostrar Poderes
				// ------------------- >
				include("race_class_content.php");
				echo "<div>";
					echo "<fieldset class='noInfoLink'>";
						echo "<h3 class='powerTitle'>Poderes</h3>";
						include("contents_list.php");
					echo "</fieldset>";
				echo "</div>";
				// ------------------- >
				// Dotes del libro.
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydFeatsFields." FROM ".$dydTableFeats." WHERE origin LIKE '".$sourceID."'";
				$dataSection	 = "feats";
				// ------------------- >
				// Mostrar Dotes
				// ------------------- >
				include("race_class_content.php");
				echo "<div>";
					echo "<fieldset class='noInfoLink'>";
						echo "<h3 class='powerTitle'>Dotes</h3>";
						include("contents_list.php");
					echo "</fieldset>";
				echo "</div>";
				// ------------------- >
				// Objetos mágicos del libro.
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydMagicItemsFields." FROM ".$dydTableMagicItems." WHERE origin LIKE '".$sourceID."'";
				$dataSection	 = "magic";
				// ------------------- >
				// Mostrar Objetos mágicos
				// ------------------- >
				include("race_class_content.php");
				echo "<div>";
					echo "<fieldset class='noInfoLink'>";
						echo "<h3 class='powerTitle'>Objetos mágicos</h3>";
						include("contents_list.php");
					echo "</fieldset>";
				echo "</div>";
				// ------------------- >
				// Vehículos del libro.
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydVehiclesFields." FROM ".$dydTableVehicles." WHERE origin LIKE '".$sourceID."'";
				$dataSection	 = "vehicles";
				// ------------------- >
				// Mostrar Vehículos
				// ------------------- >
				include("race_class_content.php");
				echo "<div>";
					echo "<fieldset class='noInfoLink'>";
						echo "<h3 class='powerTitle'>Vehículos</h3>";
						include("contents_list.php");
					echo "</fieldset>";
				echo "</div>";
				// ------------------- >
				// Rituales del libro.
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydRitualsFields." FROM ".$dydTableRituals." WHERE origin LIKE '".$sourceID."'";
				$dataSection	 = "rituals";
				// ------------------- >
				// Mostrar Rituales
				// ------------------- >
				include("race_class_content.php");
				echo "<div>";
					echo "<fieldset class='noInfoLink'>";
						echo "<h3 class='powerTitle'>Rituales</h3>";
						include("contents_list.php");
					echo "</fieldset>";
				echo "</div>";
				// ------------------- >
				// Criaturas del libro.
				$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydCreaturesFields." FROM ".$dydTableCreatures." WHERE origin LIKE '".$sourceID."'";
				$dataSection	 = $dydSectionCreatures[0];
				// ------------------- >
				// Mostrar Criaturas
				// ------------------- >
				include("race_class_content.php");
				echo "<div>";
					echo "<fieldset class='noInfoLink'>";
						echo "<h3 class='powerTitle'>Criaturas</h3>";
						include("contents_list.php");
					echo "</fieldset>";
				echo "</div>";
				// ------------------- >
?>
</div>
<?php
			echo "</div>"; // <--- Fin contenido TAB 2
			// Fin Hoja
			// ------------------------------------------------------------------ //
		echo "<br/>";
		} 
	} else {
		// ================================================================== //
		// Localización para pestañas
		include_once("contents_tabs.php");
		// Título del listado
		$sourceTitle = "Bibliografía de Ad Infinitum";				
		// Datos de sesión
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydBibliographyFields." FROM ".$dydTableBibliography."";
		// Mostramos la información
		echo "<h3>".$sourceTitle."</h3>";
			$dataSection = $dydSectionBibliography[0];
			include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>
