<?php
	// Ponemos a 0 las variables
	$playerArray2 = array();
	$partyMemberData = array();
	$partyMemberLevel = array();
	// Preparamos la party fish 1
	$playerParty = preg_replace("/[\\r\\n]+/", "", $playerParty); // Quitamos los saltos de línea cojoneros.
	$playerArray = explode(",", $playerParty);
	$playerArrayCount = 0;
	while ($playerArrayCount<count($playerArray)) {
		$playerArray2[$playerArrayCount] = "'".str_replace(" ", "", $playerArray[$playerArrayCount])."'";
		$playerArrayCount++;
	}
	// ------------------------------------------------------------------ //
	// Jugadores
	$orderData ="SELECT ".$dydBasicFields.", ".$dydPlayersFields." FROM ".$dydTablePlayers." WHERE url IN (".implode(",",$playerArray2).") ORDER BY name"; // Preparamos el query
	$queryData = mysql_query ($orderData, $link);
	$playerQuantity = mysql_num_rows($queryData);	
	// ------------------------------------------------------------------ //
	// Personajes no jugadores
	$npcOrderData ="SELECT ".$dydBasicFields.", ".$dydNPCFields." FROM ".$dydTableNPC." WHERE url IN (".implode(",",$playerArray2).") ORDER BY name"; // Preparamos el query
	$npcQueryData = mysql_query ($npcOrderData, $link);
	$npcQuantity = mysql_num_rows($npcQueryData);
	// ------------------------------------------------------------------ //
	// Info de jugadores
	if ($playerQuantity != 0) { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		for($pq=0;$pq<$playerQuantity;$pq++) {
			$queryResult = mysql_fetch_array($queryData);
			// Datos básicos
			$partyMemberData[$pq]['ID'] 		= $queryResult["id"];
			$partyMemberData[$pq]['NAME'] 		= $queryResult["name"];
			$partyMemberData[$pq]['SURNAME'] 	= $queryResult["surname"];
			$partyMemberData[$pq]['URL'] 		= $queryResult["url"];
			// ------------------------------------->
			// Raza
			$retrieveFrom = "race";
			$dataListRace = $queryResult["race"];
			include ("retrieve_origin.php");
			// Clase
			$retrieveFrom = "class";
			$dataListClass = $queryResult["class"];
			include ("retrieve_origin.php");
			// Detalles
			$partyMemberData[$pq]['RACE'] = $raceName;
			$partyMemberData[$pq]['CLASS'] = $className;
			// --------------------------------------------->
			// Sacamos el nivel para que la nena esté contenta
			// --------------------------------------------->
			$playerURL = $queryResult["url"];
			include ("player_get_exp.php");
			// ------------------------------------->
			// Nivel
			// ------------------------------------->
			$levelQuery = "SELECT level FROM ".$dydTableLevelChart." WHERE xp BETWEEN 0 AND ".$adventTotalXP.";"; // Pillamos la info de la XP
			$levelData = mysql_query ($levelQuery, $link);
			$levelRows = mysql_num_rows($levelData);
			if ($levelRows != 0) { $partyMemberLevel[$pq] = $levelRows; $partyMemberData[$pq]['LEVEL'] = $levelRows; }
		}
			$partyLevelSum = array_sum($partyMemberLevel);
			$partyTotalMem = count($partyMemberLevel);
		if ($prepareOldMembers == FALSE) { $partyAvrgLevl = floor($partyLevelSum/$partyTotalMem); }
	}
	// ------------------------------------------------------------------ //
	// Info de npcs
	if ($npcQuantity != 0 AND $prepareNpcs == TRUE) { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		for($npc=0;$npc<$npcQuantity;$npc++) {
			$npcQueryResult = mysql_fetch_array($npcQueryData);
			// Datos básicos
			$partyMemberData[$npc]['ID'] 		= $npcQueryResult["id"];
			$partyMemberData[$npc]['NAME'] 		= $npcQueryResult["name"];
			$partyMemberData[$npc]['SURNAME'] 	= $npcQueryResult["surname"];
			$partyMemberData[$npc]['URL']		= $npcQueryResult["url"];
			// ------------------------------------->
			// Raza
			$npcQueryResult["race"] = explode("|", $npcQueryResult["race"]);
			$partyMemberData[$npc]['RACE'] = $npcQueryResult["race"][0];
			// Clase
			$npcQueryResult["class"] = explode("|", $npcQueryResult["class"]);
			$partyMemberData[$npc]['CLASS'] = $npcQueryResult["class"][0];
			// --------------------------------------------->
		}
		$partyTotalMem = count($partyMemberData);
	}
?>
