<?php
// ------------------------------>
// Archivo para definir pestañas
// ------------------------------>
// Variables por defecto (evitan Notices)
$tabTitle   = $tabTitle   ?? "";
$locTab     = $locTab     ?? "";
$tabName    = $tabName    ?? "";
$returnBackSection = $returnBackSection ?? "";
$noSection  = $noSection  ?? FALSE;

$newsName   = $newsName   ?? "";
$sourceName = $sourceName ?? "";
$musicName  = $musicName  ?? "";
$instanceName = $instanceName ?? "";
$instanceCampaign = $instanceCampaign ?? "";
$playerName = $playerName ?? "";
$playerCampaign = $playerCampaign ?? "";
$npcName    = $npcName    ?? "";
$npcCampaign = $npcCampaign ?? "";
$partyName  = $partyName  ?? "";
$shopName   = $shopName   ?? "";
$miniName   = $miniName   ?? "";
$placeName  = $placeName  ?? "";
$placeKingdom = $placeKingdom ?? "";
$eventName  = $eventName  ?? "";
$articleName = $articleName ?? "";
$actionName  = $actionName  ?? "";
$ailmentName = $ailmentName ?? "";
$raceName    = $raceName    ?? "";
$className   = $className   ?? "";
$buildName   = $buildName   ?? "";
$traitName   = $traitName   ?? "";
$bgName      = $bgName      ?? "";
$powerName   = $powerName   ?? "";
$featName    = $featName    ?? "";
$thingName   = $thingName   ?? "";
$vehicleName = $vehicleName ?? "";
$itemName    = $itemName    ?? "";
$enchantName = $enchantName ?? "";
$ritualName  = $ritualName  ?? "";
$encounterName = $encounterName ?? "";
$monsterName   = $monsterName   ?? "";
$enemyName     = $enemyName     ?? "";
$enemyElite    = isset($enemyElite) ? (int)$enemyElite : 0;
$classTier = isset($classTier) ? (int)$classTier : 0;
$raceKind = isset($raceKind) ? (int)$raceKind : 0;
$typItem = $typItem ?? "";

switch ($section) {
	// Usuario
	case $sectionUser[0]:
		$tabTitle = "Usuario";
		$locTab = "K";
		$tabName = $pageTitle3;
	break;
	// --------------------->	
	// Sección Inicio
	// --------------------->
	// Noticias
	case $dydSectionUpdates[0]:
		$tabTitle = "Inicio";
		$noSection = TRUE;
		if ($newsName !="") {
			$tabName = $newsName; 
			$locTab = "Actualizaciones";
		} else {
			$locTab = "K";
			$tabName = "Actualizaciones";
		}
	break;
	// Proyectos
	case $dydSectionProjects[0]:
		$tabTitle = "Inicio";
		$locTab = "K";
		$tabName = "Proyectos";
		$noSection = TRUE;
	break;
	// Estado
	case $dydSectionStatus[0]:
		$tabTitle = "Inicio";
		$locTab = "K";
		$tabName = "Estado";
		$noSection = TRUE;
	break;
	// Bibliografía
	case $dydSectionBibliography[0]:
		$tabTitle = "Inicio";
		$noSection = TRUE;
		if ($sourceName !="") {
			$tabName = $sourceName; 
			$locTab = "Bibliografía";
		} else {
			$locTab = "K";
			$tabName = "Bibliografía";
		}
	break;
	// Búsqueda
	case $sectionSearch[0]:
		$tabTitle = "Búsqueda";
		$locTab = "K";
		$tabName = $searchQuery;
	break;
	// Banda Sonora
	case $sectionOST[0]:
		$tabTitle = "Banda sonora";
		if ($musicName !="") { $tabName = $musicName; }
			switch ($musicPlaylist) {
				case "Era Rasa":
					$nameSection = "Era Rasa";
					$returnBackSection = "erarasa/";
				break;
				case "Casus Belli":
					$nameSection = "Casus Belli";
					$returnBackSection = "casusbelli/";
				break;
				default:
					$nameSection = "Otras campañas";
					$returnBackSection = "others/";
				break;
			}
			$locTab = $nameSection;
	break;
	// --------------------->	
	// Sección Partida
	// --------------------->
	// Aventuras
	case $dydSectionAdventures[0]:
		$tabTitle = "Aventuras";
		if ($instanceName !="") { $tabName = $instanceName; }
			switch($instanceCampaign) {
				case "Era Rasa":
					$nameSection = $instanceCampaign;
					$titleName = "Aventura";
					$returnBackSection = "erarasa/";		
				break;
				case "Casus Belli":
					$nameSection = $instanceCampaign;
					$titleName = "Aventura";
					$returnBackSection = "casusbelli/";		
				break;
				case "Historias personales":
					$nameSection = $instanceCampaign;
					$titleName = "Aventura";
					$returnBackSection = "tales/";		
				break;
				default:
					$nameSection = "Sin campaña";
					$titleName = "Aventura";
					$returnBackSection = "nocampaign/";				
				break;
			}
		$locTab = $nameSection;
	break;
	// Personajes
	case $dydSectionPlayers[0]:
		$tabTitle = "Personajes";
		if ($playerName !="") { $tabName = $playerName." ".$playerSurname; }
		//$tabName = $playerName." ".$playerSurname;
			switch($playerCampaign) {
				case "Era Rasa":
					$nameSection = $playerCampaign;
					$returnBackSection = "erarasa/";		
				break;
				case "Casus Belli":
					$nameSection = $playerCampaign;
					$returnBackSection = "casusbelli/";		
				break;
				case "Parvum Iter":
					$nameSection = $playerCampaign;
					$returnBackSection = "parvumiter/";		
				break;
				default:
					$nameSection = "Otras campañas";
					$returnBackSection = "others/";				
				break;
			}
		$locTab = $nameSection;
	break;	
	// Personajes no jugadores
	case $dydSectionNPC[0]:
		$tabTitle = "Personajes no jugadores";
		if ($npcName !="") { $tabName = $npcName." ".$npcSurname; }
		//$tabName = $playerName." ".$playerSurname;
			switch($npcCampaign) {
				case "Era Rasa":
					$nameSection = $npcCampaign;
					$returnBackSection = "erarasa/";		
				break;
				case "Casus Belli":
					$nameSection = $npcCampaign;
					$returnBackSection = "casusbelli/";		
				break;
				case "Parvum Iter":
					$nameSection = $npcCampaign;
					$returnBackSection = "parvumiter/";		
				break;
				case "Pasado":
					$nameSection = $npcCampaign;
					$returnBackSection = "past/";
				break;
				default:
					$nameSection = "Otras campañas";
					$returnBackSection = "others/";				
				break;
			}
		$locTab = $nameSection;
	break;
	// Grupos
	case $dydSectionParties[0]:
		$tabTitle = "Grupos";
		$tabName = $partyName;
	break;
	// Tiendas
	case $dydSectionShops[0]:
		$tabTitle = "Bazares";
		$tabName = $shopName;
	break;	
	// Miniaturas
	case $dydSectionMiniatures[0]:
		$tabTitle = "Miniaturas";
		$tabName = $miniName;
	break;
	// Lugares del mapa
	case $dydSectionMap[0]:
		$tabTitle = "Lugares";
		if ($placeName !="") { $tabName = $placeName; }
			switch($placeKingdom) {
				case "Shadaleen":
					$nameSection = "shadaleen";
					$returnBackSection = $nameSection."/";
				break;
				case "Malasthar":
					$nameSection = "malasthar";
					$returnBackSection = $nameSection."/";
				break;
				case "Éilerenn":
					$nameSection = "eilerenn";
					$returnBackSection = $nameSection."/";
				break;
				case "Nerettea":
					$nameSection = "nerettea";
					$returnBackSection = $nameSection."/";
				break;
				case "Otras zonas":
					$nameSection = "others";
					$returnBackSection = $nameSection."/";
				break;

			}
		$locTab = $placeKingdom;
	break;
	// Línea temporal
	case $dydSectionTimeline[0]:
		$tabTitle = "Línea temporal";
		if ($eventName !="") { $tabName = $eventName; }
			switch($eventType) {
				case "Viaje":
					$nameSection = $eventType;
					$returnBackSection = "travel/";
				break;
				case "Nacimiento":
					$nameSection = $eventType;
					$returnBackSection = "birth/";
				break;
				case "Batalla":
					$nameSection = $eventType;
					$returnBackSection = "battle/";
				break;
				case "Amistad":
					$nameSection = $eventType;
					$returnBackSection = "friendship/";
				break;
				case "Fallecimiento":
					$nameSection = $eventType;
					$returnBackSection = "death/";
				break;
				case "Enemistad":
					$nameSection = $eventType;
					$returnBackSection = "enmity/";
				break;
				case "Secuestro":
					$nameSection = $eventType;
					$returnBackSection = "kidnapping/";
				break;
				case "Tesoro":
					$nameSection = $eventType;
					$returnBackSection = "treasure/";
				break;
				case "Fundación":
					$nameSection = $eventType;
					$returnBackSection = "foundation/";
				break;
				case "Celebración":
					$nameSection = $eventType;
					$returnBackSection = "celebration/";
				break;
				case "Romance":
					$nameSection = $eventType;
					$returnBackSection = "love/";
				break;
				case "Evento":
					$nameSection = $eventType;
					$returnBackSection = "event/";
				break;
			}
		$locTab = $nameSection;
	break;
	// --------------------->	
	// Sección Sistema
	// --------------------->
	// Artículos
	case $dydSectionArticles[0]:
		$tabTitle = "Artículos";
		if ($articleName !="") { $tabName = $articleName; }
	break;
	// Acciones
	case $dydSectionActions[0]:
		$tabTitle = "Acciones";
		$tabName = $actionName;
	break;
	// Aflicciones
	case $dydSectionAilments[0]:
		$tabTitle = "Aflicciones";
		$tabName = $ailmentName;
	break;
	// Tabla de progreso
	case $dydSectionLevelChart[0]:
		$tabTitle = "Inicio";
		$locTab = "K";
		$tabName = "Tabla de progreso";
		$noSection = TRUE;
	break;
	// --------------------->
	// Sección Personaje
	// --------------------->
	// Razas
	case $dydSectionRaces[0]:
		$tabTitle = "Razas";
		if ($raceName !="") { $tabName = $raceName; }
		switch ($raceKind) {
			case 0: // Oficiales
				$locTab = "Oficiales";
				$returnBackSection = "canon/";
			break;
			case 1: // Homebrew
				$locTab = "Homebrew";
				$returnBackSection = "homebrew/";
			break;
		}	
	break;
	// Clases
	case $dydSectionClasses[0]: 
		$tabTitle = "Clases";
		if ($className !="") { $tabName = $className; }
		switch ($classTier) {
			case 0:	// Grado Heroico
				$featureText = "clase";
				$locTab = "Heroicas";
				$returnBackSection = "heroic/";
				$pageTitle2 = "Clase";
			break;
			case 1:	// Grado Parangón
				$featureText = "senda";
				$locTab = "Sendas de parangón";
				$returnBackSection = "paragon/";
				$pageTitle2 = "Senda de parangón";
			break;
			case 2:	// Grado Épico
				$featureText = "destino";
				$locTab = "Destinos épicos";
				$returnBackSection = "epic/";
				$pageTitle2 = "Destino épico";
			break;
			case 3:	// Temas de Personaje
				$featureText = "tema";
				$locTab = "Temas de personaje";
				$returnBackSection = "themes/";
				$pageTitle2 = "Tema de personaje";
			break;
			case 4: // Essentials
				$featureText = "clase";
				$locTab = "Essentials";
				$returnBackSection = "essentials/";	
				$pageTitle2 = $locTab;				
			break;
		}
	break;
	// Diseños
	case $dydSectionBuilds[0]:
		$tabTitle = "Diseños";
		if ($buildName !="") { $tabName = $buildName; }
		switch ($buildSource) {
			// Marciales
			case "Marcial":
				$locTab = "Marciales";
				$returnBackSection = "martial/";	
			break;
			// Arcanos
			case "Arcano":
				$locTab = "Arcanos";
				$returnBackSection = "arcane/";	
			break;
			// Divinos
			case "Divino":
				$locTab = "Divinos";
				$returnBackSection = "divine/";	
			break;
			// Primigenios
			case "Primigenio":
				$locTab = "Primigenios";
				$returnBackSection = "primal/";	
			break;
			// Psiónicos
			case "Psiónico":
				$locTab = "Psiónicos";
				$returnBackSection = "psionic/";	
			break;
			// Sombríos
			case "Sombrío":
				$locTab = "Sombríos";
				$returnBackSection = "shadow/";	
			break;
			// Otros diseños
			default:
				$locTab = "Misceláneos";
				$returnBackSection = "others/";	
			break;
		}
	break;
	// Rasgos
	case $dydSectionTraits[0]:
		$tabTitle = "Rasgos";
		if ($traitName !="") { $tabName = $traitName; } elseif ($traitTitle != "Rasgos") { $tabName = $traitTitle; }
		switch ($traitType) {
			// Raciales
			case "Aura":
			case "Defensa":
			case "Origen":
			case "Pasiva":
			case "Racial":
			case "Salvaciones":
				$locTab = "Raciales";
				$returnBackSection = "race/";	
			break;
			// Cláseos
			case "Clase":
			case "Poder":
			case "Rasgo":
				$locTab = "Cláseos";
				$returnBackSection = "class/";	
			break;
			// Senda de parangón
			case "Parangón":
				$locTab = "Senda de parangón";
				$returnBackSection = "paragon/";	
			break;
			// Destino épico
			case "Épico":
				$locTab = "Destino épico";
				$returnBackSection = "epic/";	
			break;
			// Tema de personaje
			case "Tema":
				$locTab = "Temas de Personaje";
				$returnBackSection = "theme/";	
			break;
		}
	break;
	// Trasfondos
	case $dydSectionBackgrounds[0]: 
		$tabTitle = "Trasfondos";
		if ($bgName !="") { $tabName = $bgName; } elseif ($bgTitle != "Listado de trasfondos") { $tabName = $bgTitle; }
		switch ($bgClass) {
			// Orígenes
			case "Nacimiento":
			case "Geografía":
			case "Origen":
			case "Regional":
				$locTab = "Orígenes y nacimiento";
				$returnBackSection = "origins/";	
			break;
			// Ocupación
			case "Oficio":
			case "Madurez":
			case "Aventurero":
				$locTab = "Oficios";
				$returnBackSection = "occupation/";	
			break;
			// Sociedad y psicología
			case "Sociedad":
			case "Psicología":
				$locTab = "Sociedad y psicología";
				$returnBackSection = "society/";	
			break;
			// Campañas
			case "Legado de Acererak":
			case "Casa Cannith":
			case "Casa Deneith":
			case "Casa Ghallanda":
			case "Casa Jorasco":
			case "Casa Kundarak":			
			case "Casa Lyrandar":
			case "Casa Medani":
			case "Casa Orien":			
			case "Casa Phiarlan":
			case "Casa Sivis":
			case "Casa Tharashk":			
			case "Casa Thuranni":
			case "Casa Vadalis":
				$locTab = "Campañas";
				$returnBackSection = "campaign/";	
			break;
			// Raciales
			default:
				$locTab = "Raciales";
				$returnBackSection = "racial/";
			break;
		}
	break;
	// --------------------->
	// Sección Facultades
	// --------------------->
	// Poderes
	case $dydSectionPowers[0]:
		$tabTitle = "Poderes";
		if ($powerName !="") { $tabName = $powerName; }
	break;
	// Dotes
	case $dydSectionFeats[0]:
		$tabTitle = "Dotes";
		if ($featName !="") { $tabName = $featName; }
	break;
	// --------------------->
	// Sección Equipo
	// --------------------->
	// Objetos mundanos
	case $dydSectionItems[0]:
		$tabTitle = "Equipo";
		if ($thingName !="") { $tabName = $thingName; }
		switch ($thingBdType) {
			case 0: // Objetos
			break;
			case 1: // Armas
				$locTab = "Armas";
			break;
			case 2: // Armaduras
				$locTab = "Armaduras";
			break;
		}	
	break;
	// Vehículos
	case $dydSectionVehicles[0]:
		$tabTitle = "Vehículos";
		if ($vehicleName !="") { $tabName = $vehicleName; }
	break;
	// Objetos mágicos
	case $dydSectionMagicItems[0]:
		$tabTitle = "Objetos mágicos";
		if ($itemName !="") { $tabName = $itemName; }
		switch ($itemBdType) {
			case 0: // Consumibles
				$locTab = "Consumibles";
			break;
			case 1: // Armas
				$locTab = "Armas";
			break;
			case 2: // Armaduras
				$locTab = "Armaduras";
			break;
			case 3: // Accesorios
				$locTab = "Accesorios";
			break;
			case 4: // Maravillas
				$locTab = "Maravillas";
			break;
			case 5: // Recompensas alternativas
				$locTab = "Recompensas alternativas";
			break;
			case 6: // Utensilios
				$locTab = "Utensilios";
			break;
		}	
	break;
	// Encantamientos
	case $dydSectionEnchants[0]:
		$tabTitle = "Encantamientos";
		if ($enchantName !="") { $tabName = $enchantName; }
		switch ($enchantBdType) {
			case "Consumible": // Consumibles
				$locTab = "Consumibles";
			break;
			case "Arma": // Armas
				$locTab = "Armas";
			break;
			case "Armadura": // Armaduras
				$locTab = "Armaduras";
			break;
			case "Accesorio": // Accesorios
				$locTab = "Accesorios";
			break;
			case "Utensilio": // Utensilios
				$locTab = "Utensilios";
			break;
			/*
			case 4: // Maravillas
				$locTab = "Maravillas";
			break;*/
		}	
	break;
	// Rituales
	case $dydSectionRituals[0]:
		$tabTitle = "Rituales";
		if ($ritualName !="") { $tabName = $ritualName; }
	break;
	// --------------------->
	// Sección PNJ
	// --------------------->
	// Encuentros
	case $dydSectionEncounter[0]:
		$tabTitle = "Encuentros";
		$tabName = $encounterName;
	break;
	// Bestiario
	case $dydSectionBestiary[0]:
		$tabTitle = "Bestiario";
		$tabName = $monsterName;
	break;
	// Criaturas
	case $dydSectionCreatures[0]:
		$tabTitle = "Criaturas";
		if ($enemyName !="") { $tabName = $enemyName; }
		switch ($enemyElite) {
			case 0: // Enemigos
			case 1: // 
			case 2: // 
			case 3: // 
			case 7: // 
			case 9: // 
				$locTab = "Enemigos";
			break;
			case 4: // Aliados
				$locTab = "Aliados";
			break;
			case 5: // Familiares
				$locTab = "Familiares";
			break;
			case 6: // Trampas
				$locTab = "Trampas";
			break;
			case 8: // Monturas
				$locTab = "Monturas";
			break;
		}	
	break;
}
// ------------------------------>
// Fin del archivo [EOF]
// ------------------------------>
?>
