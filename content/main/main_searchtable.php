<?php
	// Enlace a la tabla
	$tableLink = strtolower($fromTable);
	// Definición de la tabla del contenido de Busqueda
	switch($fromTable) {
		// Aventuras
		case $dydTableAdventures:
		case "Instances":
		case "asistir":
			$tableName = $dydSectionAdventures[1];
			$tableLink = $dydSectionAdventures[0];
		break;
		// Jugadores
		case $dydTablePlayers:
		case "Players":
			$tableName = $dydSectionPlayers[1];
			$tableLink = $dydSectionPlayers[0];
		break;
		// Personajes no jugadores
		case $dydTableNPC:
		case "Npcs":
			$tableName = $dydSectionNPC[1];
			$tableLink = $dydSectionNPC[0];
		break;
		// Grupos de aventureros
		case $dydTableParties:
		case "Parties":
			$tableName = $dydSectionParties[1];
			$tableLink = $dydSectionParties[0];
		break;
		// Lugares
		case $dydTableMap:
		case "Locations":
			$tableName = $dydSectionMap[1];
			$tableLink = $dydSectionMap[0];
		break;
		// Eventos
		case $dydTableTimeline:
		case "Events":
			$tableName = $dydSectionTimeline[1];
			$tableLink = $dydSectionTimeline[0];
		break;
		// Bazares
		case $dydTableShops:
		case "Shops":
			$tableName = $dydSectionShops[1];
			$tableLink = $dydSectionShops[0];
		break;
		// Articulos
		case $dydTableArticles:
		case "Articles":
			$tableName = "Artículos";
			$tableLink = $dydSectionArticles[0];
		break;
		// Acciones
		case $dydTableActions:
		case "Actions":
			$tableName = $dydSectionActions[1];
			$tableLink = $dydSectionActions[0];
		break;
		// Aflicciones
		case $dydTableAilments:
		case "Ailments":
			$tableName = $dydSectionAilments[1];
			$tableLink = $dydSectionAilments[0];
		break;
		// Razas
		case $dydTableRaces:
		case "Races":
			$tableName = $dydSectionRaces[1];
			$tableLink = $dydSectionRaces[0];
		break;
		// Clases
		case $dydTableClasses:
		case "Classes":
			$tableName = $dydSectionClasses[1];
			$tableLink = $dydSectionClasses[0];
		break;
		// Rasgos
		case $dydTableTraits:
		case "Traits":
			$tableName = $dydSectionTraits[1];
			$tableLink = $dydSectionTraits[0];
		break;
		// Diseños
		case $dydTableBuilds:
		case "Builds":
			$tableName = $dydSectionBuilds[1];
			$tableLink = $dydSectionBuilds[0];
		break;
		// Trasfondos
		case $dydTableBackgrounds:
		case "Backgrounds":
			$tableName = $dydSectionBackgrounds[1];
			$tableLink = $dydSectionBackgrounds[0];
		break;
		// Poderes
		case $dydTablePowers:
		case "Powers":
			$tableName = $dydSectionPowers[1];
			$tableLink = $dydSectionPowers[0];
		break;
		// Dotes
		case $dydTableFeats:
		case "Feats":
			$tableName = $dydSectionFeats[1];
			$tableLink = $dydSectionFeats[0];
		break;
		// Objetos
		case $dydTableItems:
		case "Things":
			$tableName = $dydSectionItems[1];
			$tableLink = $dydSectionItems[0];
		break;
		// Objetos mágicos
		case $dydTableMagicItems:
		case "Items":
			$tableName = $dydSectionMagicItems[1];
			$tableLink = $dydSectionMagicItems[0];
		break;
		// Encantamientos
		case $dydTableEnchants:
		case "Enchantments":
			$tableName = $dydSectionEnchants[1];
			$tableLink = $dydSectionEnchants[0];
		break;
		//  Rituales
		case $dydTableRituals:
		case "Rituals":
			$tableName = $dydSectionRituals[1];
			$tableLink = $dydSectionRituals[0];
		break;
		// Encuentros
		case $dydTableEncounter:
		case "Encounters":
			$tableName = $dydSectionEncounter[1];
			$tableLink = $dydSectionEncounter[0];
		break;
		// Bestiario
		case $dydTableBestiary:
		case "Book":
			$tableName = $dydSectionBestiary[1];
			$tableLink = $dydSectionBestiary[0];
		break;
		// Criaturas
		case $dydTableCreatures:
		case "Enemies":
			$tableName = $dydSectionCreatures[1];
			$tableLink = $dydSectionCreatures[0];
		break;
	}
?>