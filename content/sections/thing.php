<?php
	if ($page != 0) {
	// ================================================================== //
	echo "<div id='card' class='tab_content'>"; // <=== Contenido del TAB 1
		echo "<div id='powerItemLayout'>";
			$powerId = $page; // Damos la id del dato.
				include ("thing_card.php");
			$pageTitle3 = $thingName;
		echo "</div>";
	echo "</div>";
	// Finalizamos el TAB 1
	// Configuramos el enlace de vuelta
	switch ($thingBdType) {
		case 0: // Objetos
			$returnBackSection = "";
		break;
		case 1: // Armas
			$returnBackSection = "weapons/";
		break;
		case 2: // Armaduras
			$returnBackSection = "armors/";
		break;
	}
	// Finalizamos la configuración del enlace de vuelta
	echo "<div id='pict' class='tab_content'>"; // <=== Contenido del TAB 2
		echo "<div id='powerItemLayout'>";
			$thingPic = $dydItemImgPath.$thingPicture.$dydItemImgExt;
			echo "<center>";
				echo "<a href='".$thingPic."' target='_blank'>";
					echo "<img src='".$thingPic."' class='enemyPic' alt='".$thingName."' title='".$thingName."' />";
				echo "</a>";
			echo "</center>";
		echo "</div>";
	echo "</div>";
	// Finalizamos el TAB 2
		// Localización para pestañas
		include_once("contents_tabs.php");
	// ================================================================== //
	echo "<br/>";
	} else {
		// ------------------------------------------------------------------ //
			switch($typItem) {
				case "weapons":
					$dataSelectSQL = "comp, dice, reach, properties, type, thingtype, hand, price, weight";
					switch($typSubType) { 
						default:
							$dataSearchSQL = "WHERE bd_type LIKE 1";
							$powerTypeTitle = "Armas";
						break;
						// Simples
						case "simple":
							$dataSearchSQL = "WHERE bd_type LIKE 1 AND thingtype LIKE 'Cuerpo a cuerpo sencilla' OR thingtype LIKE 'A distancia sencilla'";
							$powerTypeTitle = "Armas sencillas";
						break;
						// Militares
						case "military":
							$dataSearchSQL = "WHERE bd_type LIKE 1 AND thingtype LIKE 'Cuerpo a cuerpo militar' OR thingtype LIKE 'A distancia militar'";
							$powerTypeTitle = "Armas militares";
						break;
						// Superiores
						case "superior":
							$dataSearchSQL = "WHERE bd_type LIKE 1 AND thingtype LIKE 'Cuerpo a cuerpo superior' OR thingtype LIKE 'A distancia superior'";
							$powerTypeTitle = "Armas superiores";
						break;
						// ----------------------------------------------------------------------------------------- //
						// Cuerpo a cuerpo
						case "simplemelee":
							$dataSearchSQL = "WHERE bd_type LIKE 1 AND thingtype LIKE 'Cuerpo a cuerpo sencilla'";
							$powerTypeTitle = "Armas cuerpo a cuerpo sencillas";
						break;
						case "militarymelee":
							$dataSearchSQL = "WHERE bd_type LIKE 1 AND thingtype LIKE 'Cuerpo a cuerpo militar'";
							$powerTypeTitle = "Armas cuerpo a cuerpo militares";
						break;
						case "superiormelee":
							$dataSearchSQL = "WHERE bd_type LIKE 1 AND thingtype LIKE 'Cuerpo a cuerpo superior'";
							$powerTypeTitle = "Armas cuerpo a cuerpo superiores";
						break;
						// A distancia
						case "simpleranged":
							$dataSearchSQL = "WHERE bd_type LIKE 1 AND thingtype LIKE 'A distancia sencilla'";
							$powerTypeTitle = "Armas a distancia sencillas";
						break;
						case "militaryranged":
							$dataSearchSQL = "WHERE bd_type LIKE 1 AND thingtype LIKE 'A distancia militar'";
							$powerTypeTitle = "Armas a distancia militares";
						break;
						case "superiorranged":
							$dataSearchSQL = "WHERE bd_type LIKE 1 AND thingtype LIKE 'A distancia superior'";
							$powerTypeTitle = "Armas a distancia superiores";
						break;
						// ----------------------------------------------------------------------------------------- //
					}
				break;
				case "armors":
					$dataSelectSQL = "armor, minbonus, skill, speed, type, properties, price, weight";
					switch($typSubType) {
						default:
							$dataSearchSQL = "WHERE bd_type LIKE 2";
							$powerTypeTitle = "Armaduras";
						break;
						// ----------------------------------------------------------------------------------------- //
						// Ligeras
						case "light":
							$dataSearchSQL = "WHERE bd_type LIKE 2 AND thingtype LIKE 'Ligera'";
							$powerTypeTitle = "Armaduras ligeras";
						break;
						// Pesadas
						case "heavy":
							$dataSearchSQL = "WHERE bd_type LIKE 2 AND thingtype LIKE 'Pesada'";
							$powerTypeTitle = "Armaduras pesadas";
						break;
						// ----------------------------------------------------------------------------------------- //
					}
				break;
				case "mounts":
					$dataSelectSQL = "properties, price, weight";
					$dataSearchSQL = "WHERE bd_type LIKE 3";
					$powerTypeTitle = "Monturas";
				break;
				default:
					$dataSelectSQL = "type, properties, hand, price, weight";
					$dataSearchSQL = "WHERE bd_type LIKE 0";
					$powerTypeTitle = "Objetos";
				break;
			}
		// Localización para pestañas
		if ($powerTypeTitle != "Objetos") {
			$locTab = "K"; // Le damos un valor para que no de la murga
			$tabName = $powerTypeTitle;
			include_once("contents_tabs.php");
		}
		// ---------->
		echo "<h3>".$powerTypeTitle."</h3>";
		$pageTitle3 = $powerTypeTitle; 
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dataSelectSQL.", origin FROM ".$dydTableItems." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionItems[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>