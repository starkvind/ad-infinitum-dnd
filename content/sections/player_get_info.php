<?php
	// Comprobamos y obtenemos la información del personaje.
			// Motto
				$playerCheckDetail = explode("[MOTTO]", $playerInfo[$pk], 2);
				if (isset($playerCheckDetail[1]) && $playerCheckDetail[1] != "") { $playerMotto = $playerCheckDetail[1]; }
			// Peso
				$playerCheckDetail = explode("[WEIGHT]", $playerInfo[$pk], 2);
				if (isset($playerCheckDetail[1]) && $playerCheckDetail[1] != "") { $playerWeight = $playerCheckDetail[1]; }
			// Altura
				$playerCheckDetail = explode("[HEIGHT]", $playerInfo[$pk], 2);
				if (isset($playerCheckDetail[1]) && $playerCheckDetail[1] != "") { $playerHeight = $playerCheckDetail[1]; }
			// Edad
				$playerCheckDetail = explode("[AGE]", $playerInfo[$pk], 2);
				if (isset($playerCheckDetail[1]) && $playerCheckDetail[1] != "") { $playerAge = $playerCheckDetail[1]; }
			// Descripción
				$playerCheckDetail = explode("[DESCRIPTION]", $playerInfo[$pk], 2);
				if (isset($playerCheckDetail[1]) && $playerCheckDetail[1] != "") { $playerText = $playerCheckDetail[1]; }
			// Alineamiento
				$playerCheckDetail = explode("[ALIGNMENT]", $playerInfo[$pk], 2);
				if (isset($playerCheckDetail[1]) && $playerCheckDetail[1] != "") { $playerAlignment = $playerCheckDetail[1]; }
			// Deidad
				$playerCheckDetail = explode("[DEITY]", $playerInfo[$pk], 2);
				if (isset($playerCheckDetail[1]) && $playerCheckDetail[1] != "") { 
					$retrieveFrom = "deity";
					$dataListDeity = $playerCheckDetail[1];
						include ("retrieve_origin.php");
					$deityLink = $pageRoot."articles/".$playerCheckDetail[1]."/";
				}
			// Idiomas
				$playerCheckDetail = explode("[LANGUAGES]", $playerInfo[$pk], 2);
				if (isset($playerCheckDetail[1]) && $playerCheckDetail[1] != "") { 
					$playerLanguages = $playerCheckDetail[1];			
				}
			// Trasfondo
				$playerCheckDetail = explode("[BACKGROUND]", $playerInfo[$pk], 2);
				if (isset($playerCheckDetail[1]) && $playerCheckDetail[1] != "") { 
					$retrieveFrom = "background";
					$dataListBackground = $playerCheckDetail[1];
						include ("retrieve_origin.php");
					$bgLink = $pageRoot."backgrounds/".$playerCheckDetail[1]."/";
				}
			// Senda de parangón
				$playerCheckDetail = explode("[PARAGON]", $playerInfo[$pk], 2);
				if (isset($playerCheckDetail[1]) && $playerCheckDetail[1] != "") { 
					$retrieveFrom = "paragon";
					$dataListParagon = $playerCheckDetail[1];
						include ("retrieve_origin.php");
					$paragonLink = $pageRoot."classes/".$playerCheckDetail[1]."/";
				}
			// Destino épico
				$playerCheckDetail = explode("[EPIC]", $playerInfo[$pk], 2);
				if (isset($playerCheckDetail[1]) && $playerCheckDetail[1] != "") { 
					$retrieveFrom = "epic";
					$dataListEpic = $playerCheckDetail[1];
						include ("retrieve_origin.php");
					$epicLink = $pageRoot."classes/".$playerCheckDetail[1]."/";
				}
			// Tema de personaje
				$playerCheckDetail = explode("[THEME]", $playerInfo[$pk], 2);
				if (isset($playerCheckDetail[1]) && $playerCheckDetail[1] != "") { 
					$retrieveFrom = "theme";
					$dataListTheme = $playerCheckDetail[1];
						include ("retrieve_origin.php");
					$themeLink = $pageRoot."classes/".$playerCheckDetail[1]."/";
				}
	// -------------------------------------> Fin Descripciones
?>
