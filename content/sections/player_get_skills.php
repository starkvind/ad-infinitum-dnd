<?php
	// Empezamos a calcular
	$playerSkillArray = array();
	// Penalizadores
	$playerSkillMalus = $armorSkillMalus+$shieldSkillMalus;
	// Habilidades de raza
	$playerRaceSkills = str_replace("+2 a ", "", $raceSkills);
	// Mitad del nivel
	$halfPlayerLevel = floor($playerLevel/2);
	// Habilidades del jugador
	$playerCheckSkills = explode("|", $playerSkills);
	// Habilidades entrenadas
	$playerCheckSkills[0] = str_replace("TRAINED:", "", $playerCheckSkills[0]);
	// Habilidades de trasfondo
	$playerCheckSkills[1] = str_replace("BACKGROUND:", "", $playerCheckSkills[1]);
	// Habilidades de tema de personaje
	$playerCheckSkills[2] = str_replace("THEME:", "", $playerCheckSkills[2]);
	// Habilidades raciales si no lo tiene en $playerRaceSkills
	$playerCheckSkills[3] = str_replace("RACIAL:", "", $playerCheckSkills[3]);
	// Habilidades de objeto
	$playerCheckSkills[4] = str_replace("ITEM:", "", $playerCheckSkills[4]);
	// Preparamos todo el percal para que se sepa lo que hay.
	$skillSearchSql	= "";
	$skillSearchTrm = "SELECT ".$dydBasicFields.", ".$dydSkillsFields." FROM ".$dydTableSkills." ".$skillSearchSql; //
	$skillSearchQry	= mysql_query($skillSearchTrm, $link);
	$skillRows 		= mysql_num_rows($skillSearchQry);
	if ($skillRows != 0) {
		for($dt=0;$dt<$skillRows;$dt++) {
			$skillQueryResult 	= mysql_fetch_array($skillSearchQry);
			$skillId	 		= $skillQueryResult["id"];
			$skillName	 		= $skillQueryResult["name"];
			$skillStat	 		= $skillQueryResult["stat"];
			$skillMalus	 		= $skillQueryResult["malus"];
			// Cogemos el modificador de la habilidad asignada.
			switch($skillStat) {
				case "Fuerza": 		
					$skillStatMod = $playerCharam[0];
				break;				
				case "Constitución": 		
					$skillStatMod = $playerCharam[1];
				break;				
				case "Destreza": 		
					$skillStatMod = $playerCharam[2];
				break;				
				case "Inteligencia": 		
					$skillStatMod = $playerCharam[3];
				break;				
				case "Sabiduría": 		
					$skillStatMod = $playerCharam[4];
				break;				
				case "Carisma": 		
					$skillStatMod = $playerCharam[5];
				break;
			}
			if ($skillStatMod == "") {
				$skillStatMod = 0;
			}
			// Nombramos modificador 
			$skillStatName = substr($skillStat, 0, 3);
			// Comprobamos si la habilidad está entrenada
			if (strpos($playerCheckSkills[0],$skillName) !== FALSE) {
				$skillTrainedMod = 5;
			} else {
				$skillTrainedMod = 0;
			}
			// Comprobamos si la habilidad es de raza
			if (strpos($playerRaceSkills,$skillName) !== FALSE) {
				$skillRaceMod = 2;
			} else {
				$skillRaceMod = 0;
			}			
			// Comprobamos si la habilidad es de trasfondo
			if (strpos($playerCheckSkills[1],$skillName) !== FALSE) {
				$skillBgMod = 2;
			} else {
				$skillBgMod = 0;
			}			
			// Comprobamos si la habilidad es de tema de personaje
			if (strpos($playerCheckSkills[2],$skillName) !== FALSE) {
				$skillThemeMod = 2;
			} else {
				$skillThemeMod = 0;
			}
			// Comprobamos si la habilidad es de raza, pero no sale en la raza en si (caso Cambiantes, Fimir, etc)
			if (strpos($playerCheckSkills[3],$skillName) !== FALSE AND $skillRaceMod == 0) {
				$skillRaceMod = 2;
			}
			// Comprobamos si la habilidad recibe un bonificador de objeto
			if (strpos($playerCheckSkills[4],$skillName) !== FALSE) {
			//	$temaPrueba = explode(",", $playerCheckSkills[4]);
				//echo $temaPrueba[0].$temaPrueba[1];
				$skillItemMod = 0;
			} else {
				$skillItemMod = 0;
			}
			// Penalizadores de habilidad
			if ($skillMalus == 1) {
				$skillMalusMod = $playerSkillMalus;
			} else {
				$skillMalusMod = 0;
			}
			// Calculamos los modificadores
			$totalSkillMod = $halfPlayerLevel+$skillStatMod+$skillTrainedMod+$skillRaceMod+$skillBgMod+$skillThemeMod+$skillItemMod+$skillMalusMod;
			$playerSkillArray[$skillName] = 
				$skillStatName.",".$halfPlayerLevel.",".$skillStatMod.",".$skillTrainedMod.",".$skillRaceMod.",".$skillBgMod.",".$skillThemeMod.",".$skillItemMod.",".$skillMalusMod."";
			$playerSkillMod[$skillName] = $totalSkillMod;
			// Cerramos línea.
		}
	}
?>