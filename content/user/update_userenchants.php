<?php
	session_start();
	// Base de datos
	include_once("../rosetta.php"); 	 // Archivo de la base de datos
	mysql_select_db($bdd, $link); 	 // Seleccionamos la base de datos
	if (isset($mainUserName)) { // comprobamos que se hayan enviado los datos del formulario
		// Intentos
		$minIntents = 100;
		$intents = 0;
		// Preparamos variables
		$user 		= $_POST["user"];		// Cogemos nombre de usuario
		$section 	= $_POST["section"];	// Cogemos URL
		$level 		= $_POST["level"];		// Cogemos nivel del pj
		$enchants 	= $_POST["enchants"]; 	// Cogemos las id de los enchants
		$topaz 		= $_POST["topaz"]; 		// Si usamos topacios o no.
		// Comprobamos topacios
		if ($topaz == "") {
			$usedTopaz = 0;
		} else {
			$usedTopaz = 1;
		}
		// Procedemos a los cambios
		if ($enchants != "") { // Si no tenemos encantamientos, añadir.
			$checkRiteQuest = "WHERE id NOT IN (".$enchants.")";
		} else {
			$checkRiteQuest = "";
		}
		startAgain: // Proceso de repetición.
		$riteData = "SELECT id, name, levels FROM ".$dydTableEnchants." ".$checkRiteQuest." ORDER BY RAND() LIMIT 1"; // Elegimos las transacciones en la Base de Datos
		$queryRite = mysql_query ($riteData, $link);
		$rowsRite = mysql_num_rows($queryRite);
		if ($rowsRite != 0) {
			$riteResult = mysql_fetch_array($queryRite);
			$encRiteId = $riteResult["id"];
			$encRiteName = $riteResult["name"];
			$encRiteLvls = $riteResult["levels"];
			// Preparamos el nivel mínimo del ritual.
				$arrayLevels = explode("|", $encRiteLvls);
				// Contamos y quitamos valores en blanco del array
				$cleanArrayLevels = array_values(array_diff($arrayLevels, array("")));
				if ($cleanArrayLevels[0] != "") {
					$checkArrayLevel = explode("+", $cleanArrayLevels[0]);
					$levelsEnchant = str_replace("Niv. ", "", $checkArrayLevel[0]);
					$levelsEnchant = str_replace(" ", "", $levelsEnchant);
				}
			// Ya que hemos comprobado todo, vamos a ver si el nivel nos vale
			if ($levelsEnchant <= $level) {
				if ($enchants == "") {
					$newEnchants = $encRiteId;
				} else {
					$newEnchants = $enchants.",".$encRiteId;
				}
				// Actualizamos usuario.
				mysql_query("UPDATE ".$tableUsers." SET dyd_enchants = '".$newEnchants."' WHERE ".$mainUserNameRow." = '".$user."'",$link);
				// Metemos caña a la tabla de transacciones
				mysql_query("INSERT INTO ".$dydTableUserEnch." (user,enchant_id,date,topaz) VALUES (
				'".$user."', 
				'".$encRiteId."', 
				'".date("Y-m-d H:i:s")."', 
				'".$usedTopaz."'
				)",$link);
				// Si hemos gastado topacios, los gastamos o que.
				if ($usedTopaz == 1) {
					mysql_query("INSERT INTO ".$tableTopaz." (user,amount,infotext,auto,date,idsection,section) VALUES (
					'".$user."', 
					'-10',
					'Aprender el encantamiento ".$encRiteName.".',
					'0',
					'".date("Y-m-d")."', 
					'".$encRiteId."',
					'".$dydSectionEnchants[0]."'
					)",$link);		
				}
				$_SESSION['dyd_enchants'] = $newEnchants;
				// Configuración de correo
				$subjectMail = "Ad Infinitum: ".$user." ha aprendido un nuevo encantamiento.";
				$bodyMail = "El usuario ".$user." ha aprendido en el día ".date("Y-m-d H:i:s")." el encantamiento '".$encRiteName."', de nivel ".$levelsEnchant.".";
				mail($adminMail,$subjectMail,$bodyMail,$fromMail1,$fromMail2);
			} else {
				$intents = $intents+1;
				if ($intents != $minIntents) {
					goto startAgain;
				} else {
					$_SESSION['no_more_enchants'] = TRUE;
					goto endThis;
				}
			}
		}
		endThis:
		//Cerramos
		mysql_close($link);	
		// Volvemos
		header("Location: ".$section."");
	}
?>