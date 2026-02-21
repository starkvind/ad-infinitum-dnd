<?php
// ---------------------------------------------------------->
// Configuración PHP de Ad Infinitum
// ---------------------------------------------------------->
	// Modo de STONE: Cambiar la variable según dónde estemos 
	// subiendo la web.
	// 		0 = Dirección de internet;
	//		1 = Usando IP propia;
	//		2 = Dirección interna de casa;	
	// ------------------------------------------------------>
	$stoneMode = 2;
	// Página web
	$interWeb 	= "naufragio.net/";
	$interIpWeb	= "159.147.28.91/";
	// Direcciones de casa
	//$homeName	= "raspberrypi/";
	$homeName = "192.168.1.80/";
	$houseWeb 	= "192.168.1.80/";
	// Webs antiguas
	$oldWeb 	= "ad-infinitum.es/";
	$oldWeb2 	= "ylat.96.lt/";
	// Página principal
	switch ($stoneMode) {
		default:
			$mainRoot 	= $interWeb;
			$rootSubDomain = true;
		break;
		case 1:
			$mainRoot 	= $interIpWeb;
			$rootSubDomain = false;
		break;
		case 2:
			$mainRoot 	= $homeName;
			$rootSubDomain = false;
		break;
	}
	// Preparamos los enlaces a la raíz principal de cada sección
	if ($rootSubDomain == true) {
		// Tenemos subdominio, como en El Naufragio.
		$pageRoot 	= "http://dnd.".$mainRoot.""; 	// Raíz de la página de D&D.
		$wodRoot	= "http://".$mainRoot."wod/";	// Raíz de la página de Mundo de Tinieblas.
		$pkmnRoot	= "http://pokemon.".$mainRoot."";	// Raíz de la página de Pokémon.
		$mapRoot	= "http://ylat.".$mainRoot."";	// Raíz de la página del Mapa.
	} else {
		// Trabajamos sin subdominio.
		$pageRoot 	= "http://".$mainRoot."dnd/"; 	// Raíz de la página de D&D.
		$wodRoot	= "http://".$mainRoot."wod/";	// Raíz de la página de Mundo de Tinieblas.
		$pkmnRoot	= "http://".$mainRoot."pkmn/";	// Raíz de la página de Pokémon.
		$mapRoot	= "http://".$mainRoot."map/";	// Raíz de la página del Mapa.
	}
	// Preparamos el título principal de la página
	switch ($adZone) { 
		case "pkmn":
			$pageTitle = "Pokénfinitum";
		break;
		default:
			$pageTitle 	= "Ad Infinitum"; // Título de la Página
		break;
	}
	// Enlaces
	$pageURL1	= "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; // URL de la página
	$pageURL	= urlencode($pageURL1); // Preparamos la página para poder utilizarla.
	// Notificaciones por email
	$adminMail 	= "naufragio@naufragio.net";
	$fromMail1 = "From: naufragio@naufragio.net\n";
	$fromMail2 = "-fnaufragio@naufragio.net";
	// Social
	$twitterUser  = "naufragiorolero";
	$linkFacebook = "https://www.facebook.com/sharer.php?u=".$pageURL."";
	// Link del Twitter más abajo, debido a cómo lo tenemos organizado
	$linkGplus	  = "https://plus.google.com/share?url=".$pageURL."";	
	// Textos e imágenes
	$errorMSG		= "<p>Ha ocurrido un error, inténtalo de nuevo.</p>"; // Mensaje de error
	$unknownOrigin 	= "Desconocido"; // Texto que aparece en caso de que el Origen de un dato no esté especificado.
	$phraseNoAuth 	= "<img src='".$pageRoot."media/error.jpg' class='errorImg' />"; // Consulta SQL para la gente que no está conectada.
// ---------------------------------------------------------->
// Configuracion de las tablas de la web Ad Infinitum
// ---------------------------------------------------------->
	// Tablas de usuario
	$tableUsers				= "main_users";		// Usuarios
	$tableTopaz		 		= "main_topaz";		// Transacciones de Topacios
	$tableSearches 			= "main_searches";	// Búsquedas
	$tableVisitors 			= "main_visitors";	// Visitantes
	$tableEvents 			= "main_events";	// Eventos
	$dydTableUserEnch		= "main_user_enchants";		// Encantamientos de los personajes.
	// Tablas de concursos
	$tableCompetition		= "dnd_competition"; // Tabla de concursos
	// ----------------------->
	// Secciones restringidas [array("seccion web", "titulo seccion", "ruta archivo php");]
	$sectionUser 	= array("user","Usuario","user/management.php");
	$sectionFavs	= array("favorites","Favoritos","user/favorites.php");
	$sectionSearch	= array("search","Búsqueda","main/main_search.php");
	// ----------------------->
	// Nivel por defecto. Asignamos nivel 0 si no hay ninguna sesión iniciada.
	$mainUserLevel = 0;
	// Variables definidas comunes. Nombre y password del usuario, nick, etc.
		$mainUserNameRow = "name";			  // Columna de la tabla.
		$mainUserKeyRow	 = "password";		  // Columna de password de la tabla.
		// Secciones de la tabla para consultas SQL.
		$userSections 	 = "id, ".$mainUserNameRow.", ".$mainUserKeyRow.", nick, options, level, hits, lastact, dyd_enchants";
	if (isset($_SESSION['name'])) {
		$mainUserName	 = $_SESSION["name"]; // Nombre de acceso.
		$mainUserNick	 = $_SESSION["nick"]; // Nick mostrado.
		$mainUserLevel	 = $_SESSION['level']; // Nivel de acceso
	}
	// Prepararos sentencia para SQL en secciones con valor de VISIBLE.
	$userLevelCheck = "AND visible <= ".$mainUserLevel."";
// ---------------------------------------------------------->
// Configuracion de las tablas de la web Ad Infinitum - D&D
// ---------------------------------------------------------->
	// Campos básicos para las búsquedas de listados
		$dydBasicFields			= "id, url, name";
		$dydBasicSection		= "main/main_index.php";
	// --------------------->
	// Sección Inicio
	// --------------------->
	// Actualizaciones
		$dydTableUpdates		= "dnd_updates";
		$dydUpdatesFields		= "date, uploader";
		$dydSectionUpdates 		= array("updates","Actualizaciones","sections/news.php");
	// Bibliografía
		$dydTableBibliography	= "dnd_bibliography";
		$dydBibliographyFields	= "date, isbn, publisher";
		$dydSectionBibliography	= array("bibliography","Bibliografía","sections/bibliography.php");
	// Banda sonora
		$tableOST				= "main_soundtrack";
		$fieldsOST				= "type, date, yt_link, playlist";
		$sectionOST				= array("music","Banda sonora","sections/soundtrack.php");
	// Estado y Proyectos
		$dydSectionStatus		= array("status","Estado","main/main_status.php");
		$dydSectionProjects		= array("projects","Proyectos","main/main_projects.php");
	// --------------------->	
	// Sección Partida
	// --------------------->
	// Combates D&D
		$dydTableCombats		= "dnd_combat_scenario";
		$dydTableCombatUnits	= "dnd_combat_units";
		$dydTableCombatTurns	= "dnd_combat_turns";
	// Aventuras
		$dydTableAdventures		= "dnd_adventures";
		$dydAdventuresFields	= "levels, campaign, number, xp, date, uploader";
		$dydSectionAdventures	= array("adventures","Aventuras","sections/adventure.php");
	// Personajes jugadores
		$dydTablePlayers		= "dnd_player_characters"; 	// Fichas de personaje.
		$dydTablePlayerGold		= "dnd_player_wallet";		// Cartera de oro.
		$dydTablePlayerEquip	= "dnd_player_equipment";	// Equipo de los personajes.
		$dydTablePlayerExp		= "dnd_player_bonus_exp";	// Cartera de experiencia.
		$dydPlayersFields		= "surname, race, class, uploader, origin";
		$dydSectionPlayers		= array("players","Personajes","sections/player.php");
	// Personajes no jugadores
		$dydTableNPC			= "dnd_npcs";	// PNJS.
		$dydNPCFields			= "surname, race, class, status, uploader, origin";
		$dydSectionNPC			= array("npcs","Personajes no jugadores","sections/npc.php");
	// Grupos de aventureros
		$dydTableParties		= "dnd_organizations";	// Grupos de aventureros.
		$dydPartiesFields		= "alignment, members, old_members, npc_members, npc_old_members, origin";
		$dydSectionParties		= array("parties","Grupos","sections/parties.php");
	// Tiendas y bazares
		$dydTableShops			= "dnd_shops";
		$dydShopsFields			= "infotext, origin";
		$dydSectionShops		= array("shops","Bazares","sections/shop.php");
	// Lugaress
		$dydTableMap			= "dnd_map_locations";
		$dydMapFields			= "class, kingdom, type, uploader";
		$dydSectionMap			= array("locations","Lugares","sections/location.php");	
	// Miniaturas
		$dydTableMiniatures		= "dnd_miniatures";
		$dydMiniaturesFields	= "id_mini, price, picture, collection, avatar";
		$dydSectionMiniatures	= array("miniatures","Miniaturas","sections/miniatures.php");	
	// Línea temporal
		$dydTableTimeline		= "dnd_timeline";
		$dydTimelineFields		= "day, month, year, type, adventure_id";
		$dydSectionTimeline		= array("timeline","Línea temporal","sections/timeline.php");
	// --------------------->	
	// Sección Sistema
	// --------------------->
	// Artículos
		$dydTableArticles 		= "dnd_articles";
		$dydArticlesFields 		= "subtype, origin";
		$dydSectionArticles		= array("articles","","sections/article.php");
	// Acciones
		$dydTableActions 		= "dnd_actions";
		$dydActionsFields 		= "type, origin";
		$dydSectionActions		= array("actions","Acciones","sections/action.php");
	// Aflicciones
		$dydTableAilments 		= "dnd_ailments";
		$dydAilmentsFields 		= "type, level, origin";
		$dydSectionAilments		= array("ailments","Aflicciones","sections/ailment.php");
	// Tabla de progreso
		$dydTableLevelChart		= "dnd_level_chart";
		$dydLevelChartFields	= "level, xp, feats, powers";
		$dydSectionLevelChart	= array("levelchart","Tabla de progreso","sections/levelchart.php");
	// --------------------->
	// Sección Personaje
	// --------------------->
	// Razas
		$dydTableRaces			= "dnd_races";	
		$dydRacesFields			= "abilities, size, speed, origin";
		$dydSectionRaces		= array("races","Razas","sections/race.php");
	// Clases
		$dydTableClasses		= "dnd_classes";		
		$dydClassesFields		= "stats, role, source, required, origin";
		$dydSectionClasses		= array("classes","Clases","sections/class.php");
	// Diseños de clase 
		$dydTableBuilds			= "dnd_class_builds";	
		$dydBuildsFields		= "class, origin";
		$dydSectionBuilds		= array("builds","Diseños","sections/builds.php");
	// Rasgos raciales o cláseos
		$dydTableTraits			= "dnd_character_traits";
		$dydTraitsFields		= "class, type, origin";
		$dydSectionTraits		= array("traits","Rasgos","sections/trait.php");
	// Trasfondos de personaje	
		$dydTableBackgrounds	= "dnd_character_backgrounds";
		$dydBackgroundsFields 	= "class, skills, origin";
		$dydSectionBackgrounds	= array("backgrounds","Trasfondos","sections/background.php");
	// --------------------->
	// Sección Facultades
	// --------------------->
	// Habilidades
		$dydTableSkills			= "dnd_skills";
		$dydSkillsFields		= "stat, malus";
		$dydSectionSkills		= array("skills","Habilidades","sections/skill.php");
	// Poderes
		$dydTablePowers			= "dnd_powers";
		$dydPowersFields		= "class, level, type, attack, origin";
		$dydSectionPowers		= array("powers","Poderes","sections/power.php");
	// Dotes
		$dydTableFeats			= "dnd_feats";
		$dydFeatsFields			= "class, tier, origin";
		$dydSectionFeats		= array("feats","Dotes","sections/feat.php");
	// --------------------->
	// Sección Equipo
	// --------------------->
	// Objetos
		$dydTableItems			= "dnd_items";
		$dydItemsFields			= "";
		$dydSectionItems		= array("items","Equipo","sections/thing.php");
	// Vehículos
		$dydTableVehicles		= "dnd_vehicles";
		$dydVehiclesFields		= "size, squares, price, origin";
		$dydSectionVehicles		= array("vehicles","Vehículos","sections/vehicle.php");
	// Objetos mágicos
		$dydTableMagicItems		= "dnd_magic_items";
		$dydMagicItemsFields	= "level, type, value, origin";
		$dydSectionMagicItems	= array("magicitems","Objetos mágicos","sections/item.php");
	// Encantamientos
		$dydTableEnchants		= "dnd_magic_enchantments";
		$dydEnchantsFields		= "type, levels, origin";
		$dydSectionEnchants		= array("enchantments","Encantamientos","sections/enchantment.php");
	// Rituales
		$dydTableRituals		= "dnd_rituals";
		$dydRitualsFields		= "category, skills, level, origin";
		$dydSectionRituals		= array("rituals","Rituales","sections/ritual.php");
	// --------------------->
	// Sección PNJ
	// --------------------->
	// Encuentros
		$dydTableEncounter	 = "dnd_battle_encounters";
		$dydEncounterFields	 = "level, origin";
		$dydSectionEncounter = array("encounters","Encuentros","sections/encounter.php");
	// Bestiario
		$dydTableBestiary	= "dnd_bestiary";
		$dydBestiaryFields	= "skill, origin";
		$dydSectionBestiary	= array("bestiary","Bestiario","sections/book.php");
	// Criaturas
		$dydTableCreatures	= "dnd_creatures";
		$dydCreaturesFields	= "role, elite, level, xp, picture, origin";
		$dydSectionCreatures= array("creatures","Criaturas","sections/enemy.php");
// ---------------------------------------------------------->
// Rutas para los menús de D&D
// ---------------------------------------------------------->
	// Sección Inicio
		$pathNews = $pageRoot.$dydSectionUpdates[0]."/";		// Actualizaciones
		$pathBibl = $pageRoot.$dydSectionBibliography[0]."/";	// Bibliografía
		$pathMusi = $pageRoot.$sectionOST[0]."/";				// Banda sonora
		$pathProj = $pageRoot.$dydSectionProjects[0]."/";		// Proyectos
		$pathStat = $pageRoot.$dydSectionStatus[0]."/";			// Estado
	// Sección Partida
		$pathAdve = $pageRoot.$dydSectionAdventures[0]."/";		// Aventuras
		$pathPlay = $pageRoot.$dydSectionPlayers[0]."/";		// Jugadores
		$pathNPCS = $pageRoot.$dydSectionNPC[0]."/";			// Personajes no Jugadores
		$pathPrty = $pageRoot.$dydSectionParties[0]."/";		// Grupos
		$pathShop = $pageRoot.$dydSectionShops[0]."/";			// Bazares
		$pathYMap = $pageRoot.$dydSectionMap[0]."/";			// Localizaciones
		$pathTmLn = $pageRoot.$dydSectionTimeline[0]."/";		// Línea temporal		
		$pathMini = $pageRoot.$dydSectionMiniatures[0]."/";		// Miniaturas
	// Sección Sistema
		$pathArti = $pageRoot.$dydSectionArticles[0]."/";		// Artículos
		$pathActi = $pageRoot.$dydSectionActions[0]."/";		// Acciones
		$pathAilm = $pageRoot.$dydSectionAilments[0]."/";		// Aflicciones
		$pathLvCh = $pageRoot.$dydSectionLevelChart[0]."/";		// Tabla de progreso
	// Sección Personaje
		$pathRace = $pageRoot.$dydSectionRaces[0]."/";			// Razas
		$pathClas = $pageRoot.$dydSectionClasses[0]."/";		// Clases
		$pathTrai = $pageRoot.$dydSectionTraits[0]."/";			// Rasgos
		$pathBuil = $pageRoot.$dydSectionBuilds[0]."/";			// Diseños de clase
		$pathBack = $pageRoot.$dydSectionBackgrounds[0]."/";	// Trasfondos
	// Sección Facultades
		$pathSkil = $pageRoot.$dydSectionSkills[0]."/";			// Habilidades
		$pathPowe = $pageRoot.$dydSectionPowers[0]."/";			// Poderes
		$pathFeat = $pageRoot.$dydSectionFeats[0]."/";			// Dotes
	// Sección Equipo
		$pathItem = $pageRoot.$dydSectionItems[0]."/";			// Objetos mundanos
		$pathVehi = $pageRoot.$dydSectionVehicles[0]."/";		// Vehícuos
		$pathMagi = $pageRoot.$dydSectionMagicItems[0]."/";		// Objetos mágicos
		$pathEnch = $pageRoot.$dydSectionEnchants[0]."/";		// Encantamientos
		$pathRitu = $pageRoot.$dydSectionRituals[0]."/";		// Rituales
	// Sección PNJ
		$pathCrea = $pageRoot.$dydSectionCreatures[0]."/";		// Criaturas
		$pathBest = $pageRoot.$dydSectionBestiary[0]."/";		// Bestiario
		$pathEnco = $pageRoot.$dydSectionEncounter[0]."/";		// Encuentros
// ---------------------------------------------------------->
// Rutas para las imágenes de D&D
// ---------------------------------------------------------->
	// Iconos genéricos
		$dydIconDirectory 		= $pageRoot."media/icon/";
		$dydIconExtension 		= ".png";
	// Iconos del menú lateral (social)
		$bkIcon = $dydIconDirectory."social_back".$dydIconExtension;		// Regresar (flecha azul)
		$prIcon = $dydIconDirectory."social_print".$dydIconExtension;		// Imprimir
		$stIcon = $dydIconDirectory."social_fav".$dydIconExtension;			// Favorito
		$dlIcon = $dydIconDirectory."social_delete".$dydIconExtension;		// Borrar favorito
		$fbIcon = $dydIconDirectory."social_facebook".$dydIconExtension;	// Facebook
		$gpIcon = $dydIconDirectory."social_gplus".$dydIconExtension;		// Google+
		$twIcon = $dydIconDirectory."social_twitter".$dydIconExtension;		// Twitter
		$tbIcon = $dydIconDirectory."bin".$dydIconExtension;				// Papalera de reciclaje		
		$muIcon = $dydIconDirectory."icon_music".$dydIconExtension;			// Banda sonora
	// Bibliografía
		$dydBibliographyImgPath	= $pageRoot."media/covers/";	// Portadas de los libros
		$dydBibliographyImgExt	= ".jpg";						// Extensión del archivo
	// Personajes
		$dydPlayerImgPath		= $pageRoot."media/player/";	// Retratos de los personajes
		$dydPlayerImgExt		= ".jpg";						// Extensión del archivo		
	// Personajes no jugadores
		$dydNpcImgPath			= $pageRoot."media/npc/";		// Retratos de los personajes no jugadores
		$dydNpcImgExt			= $dydPlayerImgExt;				// Extensión del archivo	
	// Miniaturas
		$dydMiniatureImgPath	= $pageRoot."media/figurine/";	// Miniaturas
		$dydMiniatureImgExt		= $dydPlayerImgExt;				// Extensión del archivo
	// Razas
		$dydRaceImgPath			= $pageRoot."media/race/";		// Razas
		$dydRaceImgExt			= $dydIconExtension;			// Extensión del archivo
	// Clases
		$dydClassImgPath		= $pageRoot."media/class/";		// Clase básica
		$dydClassPPImgPath		= $pageRoot."media/paragon/";	// Senda de parangón
		$dydClassEDImgPath		= $pageRoot."media/epic/";		// Destino épico
		$dydClassCTImgPath		= $pageRoot."media/theme/";		// Tema de personaje
		$dydClassESImgPath		= $pageRoot."media/essentials/";// Essentials
		$dydClassImgExt			= $dydIconExtension;			// Extensión del archivo
	// Objetos
		$dydItemImgPath			= $pageRoot."media/item/";		// Objetos
		$dydItemImgExt			= $dydPlayerImgExt;				// Extensión del archivo
// ---------------------------------------------------------->
// Rutas para los sonidos de D&D
// ---------------------------------------------------------->
	// Ruta
		$dydSoundPath 			= "sound/";
// ---------------------------------------------------------->
// Colores para las cartas de D&D
// ---------------------------------------------------------->
	// Objetos
		$dydConsumableCard		= "#D06015"; // Consumibles
		$dydWeaponCard			= "#D06015"; // Armas
// ---------------------------------------------------------->
// =============================================================================================================>
// Configuracion de las tablas de la web Ad Infinitum - World of Darkness
// =============================================================================================================>
		/*$pkmnTableData			= "pkmn_data";		// Listado de los pokémon
		$pkmnTableTypes			= "pkmn_types";		// Listado de los tipos
		$pkmnTableNatures		= "pkmn_natures";	// Listado de naturalezas*/

// =============================================================================================================>
// Configuracion de las tablas de la web Ad Infinitum - Pokémon
// =============================================================================================================>
		$pkmnTableData			= "pkmn_data";		// Listado de los pokémon
		$pkmnTableTypes			= "pkmn_types";		// Listado de los tipos
		$pkmnTableNatures		= "pkmn_natures";	// Listado de naturalezas
		$pkmnTableItems			= "pkmn_items";		// Listado de objetos
		$pkmnTableBalls			= "pkmn_balls";		// Listado de Poké Balls
		$pkmnTableAbilities		= "pkmn_abilities";	// Listado de habilidades
		$pkmnTableMoves			= "pkmn_moves";		// Listado de movimientos pokémon
		$pkmnTableRoles			= "pkmn_roles";		// Listado de roles para pokémons
		$pkmnTableCardTypes		= "pkmn_cardtypes";	// Tipos de Pokemon para las listas
		// Información de la Web
		$pkmnTableBuilds		= "pkmn_builds";	// Listado de BUILDs para pokémons
		$pkmnTableBuilds2		= "pkmn_builds2";	// Listado de BUILDs 2 para pokémons
		$pkmnTableBreed			= "pkmn_breed";		// Listado de Pokémon de la Granja
		$pkmnTableAuthors		= "pkmn_authors";	// Listado de autores de las Builds
		$pkmnTablePals			= "pkmn_secret_pals"; // Listado de amigos secretos de la base
		$pkmnTablePalsSkills	= "pkmn_secret_skills"; // Listado de habilidades de la base secreta
// ---------------------------------------------------------->
// Rutas para los iconos de Pokémon
// ---------------------------------------------------------->
	// Ruta
		$pkmnIconPath 			= $pkmnRoot."media/icon/";
		$pkmnIconExtension 		= ".png";
		$pkmnAnimPath 			= $pkmnRoot."media/sprite/";
		$pkmnPalsPath			= $pkmnRoot."media/trainer/";
		$pkmnTypePath 			= $pkmnRoot."media/type/";
		$pkmnGifExtension 		= ".gif";
	// Iconos del menú superior (tabs)
		$femBreedIcon			= $pkmnIconPath."knot".$pkmnIconExtension;	// Hembras
		$malBreedIcon			= $pkmnIconPath."tm".$pkmnIconExtension;	// Machos
		$showBreedIcon			= $pkmnIconPath."lens".$pkmnIconExtension;	// Colección
		$tradBreedIcon			= $pkmnIconPath."ball".$pkmnIconExtension;	// Intercambios
		$projBreedIcon			= $pkmnIconPath."wp".$pkmnIconExtension;	// Proyectos
	// Iconos de tarjetas PKMN
		$pokeStatUp				= $pkmnIconPath."statUp".$pkmnIconExtension;	// Stat sube
		$pokeStatDown			= $pkmnIconPath."statDown".$pkmnIconExtension;	// Stat Baja
// --------------------->
// Sección Inicio
// --------------------->
	// Campos básicos para las búsquedas de listados
		$pkmnBasicFields	= "*";
		$pkmnBasicSection	= "../pkmn/content/main/main_index.php";
	// Contacto Pokémon
		$pkmnContact		= array("contact","Contacto","../pkmn/content/sections/poke_contact.php");
		$pkmnContactPath	= $pkmnRoot.$pkmnContact[0]."/";	
	// Diseños Pokémon
		$pkmnBuilds			= array("pkbuilds","Diseños","../pkmn/content/sections/poke_builds.php");
		$pkmnBuildsPath		= $pkmnRoot.$pkmnBuilds[0]."/";		
	// Diseños 2 Pokémon
		$pkmnBuilds2		= array("buildsx","Diseños 2","../pkmn/content/sections/poke_builds2.php");
		$pkmnBuilds2Path	= $pkmnRoot.$pkmnBuilds2[0]."/";	
	// Roles Pokémon
		$pkmnRoles			= array("roles","Roles en combate","../pkmn/content/sections/poke_roles.php");
		$pkmnRolesPath		= $pkmnRoot.$pkmnRoles[0]."/";	
	// Granjas Pokémon
		$pkmnBreed			= array("pokemon","Pokémon","../pkmn/content/sections/poke_farm.php");
		$pkmnBreedPath		= $pkmnRoot.$pkmnBreed[0]."/";
	// Movimientos Pokémon
		$pkmnMoves			= array("moves","Movimientos","../pkmn/content/sections/poke_moves.php");
		$pkmnMovesPath		= $pkmnRoot.$pkmnMoves[0]."/";
	// Avatares Base Secreta
		$pkmnPals			= array("pals","Avatares","../pkmn/content/sections/poke_pals.php");
		$pkmnPalsPath		= $pkmnRoot.$pkmnPals[0]."/";
	// Habilidades Base Secreta
		$pkmnPalsSkills			= array("secretskills","Habilidades Base Secreta","../pkmn/content/sections/poke_roles.php");
		$pkmnPalsSkillsPath		= $pkmnRoot.$pkmnPalsSkills[0]."/";
// =============================================================================================================>
?>