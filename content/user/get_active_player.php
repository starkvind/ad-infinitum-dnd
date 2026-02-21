<?php
if (isset($mainUserName)) {	// Si no hemos iniciado sesión, no hacemos el paripé.
	// Cogemos primero el personaje activo.
	$plyr1Quest = "WHERE ".$mainUserNameRow." LIKE '".$mainUserName."'";
	$plyr1Data = "SELECT dyd_active_player FROM ".$tableUsers." ".$plyr1Quest." LIMIT 1"; // Elegimos las transacciones en la Base de Datos
	$plyr1Query = mysql_query ($plyr1Data, $link);
	$plyr1Rows = mysql_num_rows($plyr1Query);
	// Si tenemos algún dato, lo procesamos. Si no, no hacemos nada.
	if ($plyr1Rows != 0) {
		$plyr1Result = mysql_fetch_array($plyr1Query);
		$playerActiveURL = $plyr1Result["dyd_active_player"];
		// ---
		$plyr2Quest = "WHERE url LIKE '".$playerActiveURL."'";
		$plyr2Data = "SELECT name, surname, race, class, inventory FROM ".$dydTablePlayers." ".$plyr2Quest." LIMIT 1"; // Elegimos las transacciones en la Base de Datos
		$plyr2Query = mysql_query ($plyr2Data, $link);
		$plyr2Rows = mysql_num_rows($plyr2Query);
		// Si tenemos todos los datos, vamos a ello.
		if ($plyr2Rows != 0) {
			$plyr2Result = mysql_fetch_array($plyr2Query);
			// Rollo de la EXP
			$playerURL = $playerActiveURL; // Colocamos la URL del pj para pillar sus datos.
			include("../sections/player_get_exp.php"); // Preparamos la experiencia a través de este archivo.
			$playerActiveEXP = $adventTotalXP;
			// Continuamos con los datos
			$playerActiveName = $plyr2Result["name"];
			$playerActiveSurname = $plyr2Result["surname"];
			$playerActiveRace = $plyr2Result["race"];
			$playerActiveClass = $plyr2Result["class"];
			$playerActiveInv = $plyr2Result["inventory"];
			// Comprobamos si conoce el ritual
			$checkPlayerInv = explode("[RITUALS]", $playerActiveInv); // Nos quedamos con lo que hay tras [RITUALS]
			$checkPlayerInv2 = explode("|", $checkPlayerInv[1]);	  // Rompemos los datos trás | para quedanos solo con las IDs.
			if (strpos($checkPlayerInv2[0], "25") !== false) {
				$playerHasEnchantItem = TRUE; 
			} else {
				$playerHasEnchantItem = FALSE;
			}
			// Preparar nivel 
			$levelQuery = "SELECT ".$dydLevelChartFields." FROM ".$dydTableLevelChart." WHERE xp BETWEEN 0 AND ".$playerActiveEXP.";"; // Pillamos la info de la XP
			$levelData = mysql_query ($levelQuery, $link);
			$levelRows = mysql_num_rows($levelData);
			if ($levelRows != 0) {
				// Nivel del PJ
				$playerLevel = $levelRows;
			}
		}
	}
}
?>