<?php
// =========================
// main_top_menu.php (fix)
// =========================

// Selecciones principales (con valores por defecto seguros)
$section  = $_GET['section'] ?? "";
$type     = $_GET['type']    ?? "";
$subtype  = $_GET['subtype'] ?? "";
$page     = $_GET['page']    ?? 0;

// Variables críticas que pueden no estar inicializadas
$playerID  = $playerID  ?? 0;
$idGetData = $idGetData ?? 0;
$tabTitle  = $tabTitle  ?? "";
$locTab    = $locTab    ?? "";
$tabName   = $tabName   ?? "";
$showBackButton = isset($showBackButton) ? (int)$showBackButton : 1;

// --------- DEFENSAS GLOBALES (evitan notices en cualquier sección) ---------
$pageTitle2 = $pageTitle2 ?? "";
$pageTitle3 = $pageTitle3 ?? "";

// Aventura
$instancePlayers       = $instancePlayers       ?? "";
$newInstanceLoot       = $newInstanceLoot       ?? "";
$newInstanceMobs       = $newInstanceMobs       ?? "";
$instanceLocationArray = (isset($instanceLocationArray) && is_array($instanceLocationArray)) ? $instanceLocationArray : [];
$timelineRows          = is_numeric($timelineRows ?? null) ? (int)$timelineRows : 0;

// NPC / Lugares / Música / Varias secciones
$partyMembers      = $partyMembers      ?? "";
$encRows           = is_numeric($encRows  ?? null) ? (int)$encRows  : 0;
$instanceRows      = is_numeric($instanceRows ?? null) ? (int)$instanceRows : 0;
$eventRows         = is_numeric($eventRows ?? null) ? (int)$eventRows : 0;
$ostYtLink         = $ostYtLink         ?? "";
$npcCheckCreature  = (isset($npcCheckCreature) && is_array($npcCheckCreature)) ? $npcCheckCreature : [];
$npcCheckMusic     = (isset($npcCheckMusic) && is_array($npcCheckMusic)) ? $npcCheckMusic : [""];

// Raza/Clase/Trasfondos/etc
$powerRows   = is_numeric($powerRows ?? null) ? (int)$powerRows : 0;
$featRows    = is_numeric($featRows  ?? null) ? (int)$featRows  : 0;
$bgRows      = is_numeric($bgRows    ?? null) ? (int)$bgRows    : 0;
$classStats  = $classStats ?? "";
$powerLink   = $powerLink  ?? "";

// Tiendas / Objetos
$shopItems     = $shopItems    ?? "";
$shopRandom    = is_numeric($shopRandom ?? null) ? (int)$shopRandom : 0;
$thingPicture  = $thingPicture ?? "";
$itemPicture   = $itemPicture  ?? "";

// Bestiario / Criaturas
$famHasMonsters = (bool)($famHasMonsters ?? false);
$enemyLore      = $enemyLore     ?? "";
$enemyPicture   = $enemyPicture  ?? "";

// Pokémon
$build_ID   = is_numeric($build_ID ?? null) ? (int)$build_ID : 0;
$build_Name = $build_Name ?? "";

// Favoritos / redes (evita notices si faltan)
$mainWork      = $mainWork      ?? true;
$finalTitle    = (string)($finalTitle   ?? "");
$pageURL       = (string)($pageURL      ?? "");
$twitterUser   = (string)($twitterUser  ?? "");
$linkFacebook  = $linkFacebook ?? "#";
$linkGplus     = $linkGplus    ?? "#";
$bkIcon        = $bkIcon       ?? "";
$stIcon        = $stIcon       ?? "";
$dlIcon        = $dlIcon       ?? "";
$tbIcon        = $tbIcon       ?? "";
$fbIcon        = $fbIcon       ?? "";
$twIcon        = $twIcon       ?? "";
$gpIcon        = $gpIcon       ?? "";
$returnBackSection = $returnBackSection ?? "/";

// =============================================================================================== >
// Dungeons & Dragons
// =============================================================================================== >
$iconDir = $dydIconDirectory;
$iconExt = $dydIconExtension;
// -------- >
$iconBack = "<img style='height:20px;' src='".$iconDir."icon_back".$iconExt."' title='Volver' />";
// -------- >
$iconProj = "<img style='height:20px;margin-top:1px;' src='".$iconDir."icon_alchemy".$iconExt."' title='Proyectos' />";
$iconStat = "<img style='margin-top:1px;'src='".$iconDir."icon_condition".$iconExt."' title='Estado' />";
$iconBibl = "<img src='".$iconDir."icon_canon".$iconExt."' title='Bibliografía' />";
$iconLvlc = "<img style='height:20px;margin-top:1px;' src='".$iconDir."icon_general".$iconExt."' title='Tabla de progreso' />";
// -------- > 
$iconRasa = "<img style='height:20px;margin-top:1px;' src='".$iconDir."campaign_erarasa".$iconExt."' title='Era Rasa' />";
$iconBeli = "<img style='height:20px;margin-top:1px;' src='".$iconDir."campaign_casusbelli".$iconExt."' title='Casus Belli' />";
$iconViae = "<img style='height:20px;margin-top:1px;' src='".$iconDir."campaign_3".$iconExt."' title='Parvum Iter' />";
$iconTale = "<img style='margin-top:2px;' src='".$iconDir."campaign_tales".$iconExt."' title='Historias personales' />";
$iconOtPJ = "<img style='width:20px;margin-top:1px;' src='".$iconDir."campaign_tales".$iconExt."' title='Otros personajes' />";
$iconPast = "<img src='".$iconDir."icon_canon".$iconExt."' title='Del pasado' />";
// -------- >
$iconTmFr = "<img style='margin-top:2px;' src='".$iconDir."icon_bank_leather_gloves".$iconExt."' title='Amistad' />";
$iconTmRo = "<img src='".$iconDir."icon_ally".$iconExt."' title='Romance' />";
$iconTmBi = "<img style='margin-top:1px;' src='".$iconDir."icon_condition".$iconExt."' title='Nacimiento' />";
$iconTmTr = "<img style='margin-top:2px;' src='".$iconDir."icon_campaign".$iconExt."' title='Viaje' />";
$iconTmTs = "<img style='height:19px;' src='".$iconDir."icon_item".$iconExt."' title='Tesoro' />";
$iconTmFo = "<img src='".$iconDir."icon_crown_old".$iconExt."' title='Fundación' />";
$iconTmEv = "<img style='width:20px;margin-top:1px;' src='".$iconDir."icon_origins".$iconExt."' title='Evento' />";
$iconTmEn = "<img src='".$iconDir."icon_enmity".$iconExt."' title='Enemistad' />";
$iconTmBa = "<img style='height:18px;margin-top:1px;' src='".$iconDir."icon_battle".$iconExt."' title='Batalla' />";
$iconTmDe = "<img src='".$iconDir."icon_death".$iconExt."' title='Fallecimiento' />";
// -------- >
$iconArti = "<img src='".$iconDir."icon_article".$iconExt."' title='Artículos' />";
$iconAlig = "<img style='width:18px;margin-top:1px;' src='".$iconDir."icon_alignment".$iconExt."' title='Alineamientos' />";
$iconDeit = "<img style='height:18px;margin-top:1px;' src='".$iconDir."icon_deity".$iconExt."' title='Deidades' />";
$iconLang = "<img src='".$iconDir."icon_language".$iconExt."' title='Idiomas' />";
$iconCond = "<img src='".$iconDir."icon_condition".$iconExt."' title='Condiciones' />";
// -------- >
$iconHazr = "<img src='".$iconDir."icon_ailment".$iconExt."' title='Enfermedades y venenos' />";
$iconTrap = "<img src='".$iconDir."icon_trap".$iconExt."' title='Trampas y peligros' />";
$iconFami = "<img src='".$iconDir."icon_familiar".$iconExt."' title='Familiares' />";
$iconAlly = "<img src='".$iconDir."icon_ally".$iconExt."' title='Aliados y mercenarios' />";
$iconEnem = "<img style='margin-top:2px;' src='".$iconDir."icon_foe".$iconExt."' title='Enemigos' />";
// -------- >
$iconCano = "<img src='".$iconDir."icon_canon".$iconExt."' title='Oficiales' />";
$iconHmbw = "<img src='".$iconDir."icon_homebrew".$iconExt."' title='Homebrew' />";
// -------- >
$iconHero = "<img src='".$iconDir."icon_heroic".$iconExt."' title='Clases heroicas' />";
$iconPara = "<img src='".$iconDir."icon_paragon".$iconExt."' title='Sendas de parangón' />";
$iconEpic = "<img src='".$iconDir."icon_destinies".$iconExt."' title='Destinos épicos' />";
$iconEsse = "<img src='".$iconDir."icon_essentials".$iconExt."' title='Essentials' />";
$iconThem = "<img src='".$iconDir."icon_themes".$iconExt."' title='Temas de personaje' />";
// -------- > INDESTRUCTIBLE
$iconMart = "<img src='".$iconDir."icon_article".$iconExt."' title='Marciales' />";
$iconArca = "<img src='".$iconDir."icon_article".$iconExt."' title='Arcanos' />";
$iconDivn = "<img src='".$iconDir."icon_article".$iconExt."' title='Divinos' />";
$iconPrim = "<img src='".$iconDir."icon_article".$iconExt."' title='Primigenios' />";
$iconPsio = "<img src='".$iconDir."icon_article".$iconExt."' title='Psiónicos' />";
$iconSomb = "<img src='".$iconDir."icon_article".$iconExt."' title='Sombríos' />";
$iconOthe = "<img src='".$iconDir."icon_article".$iconExt."' title='Otros diseños' />";
// -------- >
$iconRaci = "<img style='margin-top:1px;' src='".$iconDir."icon_race".$iconExt."' title='Raciales' />";
// -------- >
$iconOrig = "<img style='width:20px;margin-top:1px;' src='".$iconDir."icon_origins".$iconExt."' title='Orígenes' />";
$iconOccu = "<img style='margin-top:1px;' src='".$iconDir."icon_occupation".$iconExt."' title='Ocupación' />";
$iconSoci = "<img style='height:21px;' src='".$iconDir."icon_society".$iconExt."' title='Sociedad' />";
$iconCamp = "<img style='margin-top:2px;' src='".$iconDir."icon_campaign".$iconExt."' title='Campañas' />";
// -------- >
$iconAtwl = "<img style='margin-top:2px;' src='".$iconDir."icon_atwill".$iconExt."' title='A voluntad' />";
$iconEnco = "<img style='margin-top:2px;' src='".$iconDir."icon_encounter".$iconExt."' title='Encuentro' />";
$iconDail = "<img style='margin-top:2px;' src='".$iconDir."icon_daily".$iconExt."' title='Diarios' />";
$iconUtil = "<img style='margin-top:2px;' src='".$iconDir."icon_utility".$iconExt."' title='Utilidad' />";
// -------- >
$iconGefe = "<img style='height:20px;margin-top:1px;' src='".$iconDir."icon_general".$iconExt."' title='Generales' />";
$iconClas = "<img style='height:20px;margin-top:1px;' src='".$iconDir."icon_class".$iconExt."' title='Clases' />";
$iconMcla = "<img style='height:18px;margin-top:1px;' src='".$iconDir."icon_multiclass".$iconExt."' title='Multiclase' />";
$iconDivi = "<img style='height:18px;margin-top:1px;' src='".$iconDir."icon_deity".$iconExt."' title='Divinas' />";
// -------- >
$iconAdiv = "<img style='width:20px;height:19px;' src='".$iconDir."icon_ritual_adi".$iconExt."' title='Adivinación' />";
$iconCret = "<img style='width:20px;height:19px;' src='".$iconDir."icon_ritual_cre".$iconExt."' title='Creación' />";
$iconDece = "<img style='width:20px;height:19px;' src='".$iconDir."icon_ritual_dec".$iconExt."' title='Engaño' />";
$iconScry = "<img style='width:20px;height:19px;' src='".$iconDir."icon_ritual_scr".$iconExt."' title='Escudriñamiento' />";
$iconExpl = "<img style='width:20px;height:19px;' src='".$iconDir."icon_ritual_exp".$iconExt."' title='Exploración' />";
$iconBind = "<img style='width:20px;height:19px;' src='".$iconDir."icon_ritual_bin".$iconExt."' title='Ligadura' />";
$iconWard = "<img style='width:20px;height:19px;' src='".$iconDir."icon_ritual_war".$iconExt."' title='Protección' />";
$iconRest = "<img style='width:20px;height:19px;' src='".$iconDir."icon_ritual_res".$iconExt."' title='Restablecimiento' />";
$iconTrav = "<img style='width:20px;height:19px;' src='".$iconDir."icon_ritual_tra".$iconExt."' title='Viaje' />";
// -------- >
$iconItem = "<img style='height:19px;' src='".$iconDir."icon_item".$iconExt."' title='Objetos' />";
$iconMoun = "<img style='height:22px;' src='".$iconDir."icon_horse".$iconExt."' title='Monturas' />";
$iconShip = "<img style='height:20px;' src='".$iconDir."icon_ship".$iconExt."' title='Vehículos' />";
// -------- >
$iconCons = "<img src='".$iconDir."icon_potion".$iconExt."' title='Consumibles' />";
$iconWeap = "<img src='".$iconDir."icon_sword".$iconExt."' title='Armas' />";
$iconArmr = "<img src='".$iconDir."icon_armor".$iconExt."' title='Armaduras' />";
$iconImpl = "<img src='".$iconDir."icon_bank_wand".$iconExt."' title='Utensilios' />";
$iconTrin = "<img src='".$iconDir."icon_misc".$iconExt."' title='Accesorios' />";
$iconWond = "<img src='".$iconDir."icon_wonder".$iconExt."' title='Objetos maravillosos' />";
$iconBoon = "<img style='width:20px;' src='".$iconDir."icon_boon".$iconExt."' title='Recompensas alternativas' />";
// =============================================================================================== >
// Pokémon
// =============================================================================================== >
$iconPoke["fem"] = "<img style='height:20px;' src='".$femBreedIcon."' title='Hembras' />";
$iconPoke["mal"] = "<img style='height:20px;' src='".$malBreedIcon."' title='Machos' />";
$iconPoke["shw"] = "<img style='height:20px;' src='".$showBreedIcon."' title='Colección' />";
$iconPoke["trd"] = "<img style='height:20px;' src='".$tradBreedIcon."' title='Intercambios' />";
$iconPoke["pro"] = "<img style='height:20px;' src='".$projBreedIcon."' title='Proyectos' />";
// ----------------------------------------------------------------------------------------------- >

//echo "<div style='position:absolute;'>".$className."</div>";
switch($section) {
// =============================================================================================== >
// Dungeons & Dragons
// =============================================================================================== >
	case $dydSectionProjects[0]:
	case $dydSectionStatus[0]:
	case $dydSectionLevelChart[0]:
		$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathBibl; ?>"><li><?php echo $iconBibl; ?></li></a>
		<a href="<?php echo $pathProj; ?>"><li><?php echo $iconProj; ?></li></a>
		<a href="<?php echo $pathStat; ?>"><li><?php echo $iconStat; ?></li></a>
		<a href="<?php echo $pathLvCh; ?>"><li><?php echo $iconLvlc; ?></li></a>
	</ul>
<?php
	break;

	case $dydSectionUpdates[0]:
		switch($page) {
			case 0:  $showBackButton = 1; break;
			default: $showBackButton = 0; break;
		}
	break;

	case $dydSectionBibliography[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathBibl; ?>"><li><?php echo $iconBibl; ?></li></a>
		<a href="<?php echo $pathProj; ?>"><li><?php echo $iconProj; ?></li></a>
		<a href="<?php echo $pathStat; ?>"><li><?php echo $iconStat; ?></li></a>
		<a href="<?php echo $pathLvCh; ?>"><li><?php echo $iconLvlc; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
		<li><a href="#info">Información</a></li>
		<li style="width:114px;"><a href="#cweb">Contenido en la web</a></li>
	</ul>
<?php	
			break;
		}
	break;

	case $sectionUser[0]:
		$showBackButton = 1;
		switch($type) {
			case "topaz":
				if (isset($mainUserName)) {
?>
	<ul class="textNoIcon">
		<li style="width:90px;"><a href="#check">Transacciones</a></li>
		<li><a href="#spend">Tienda</a></li>
	</ul>
<?php			
				}
			break;
		}
	break;

	case "management":
		$showBackButton = 1;
		switch($type) {
			case "powers":
?>
	<ul>
		<a href="<?php echo $pageRoot; ?>management/"><li><?php echo $iconBack; ?></li></a>
	</ul>
<?php
			break;
		}
	break;

//------------------------------------------------->
// BANDA SONORA
//------------------------------------------------->
	case $sectionOST[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathMusi; ?>erarasa"><li><?php echo $iconRasa; ?></li></a>
		<a href="<?php echo $pathMusi; ?>casusbelli/"><li><?php echo $iconBeli; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul>
		<li class="emptyTopCell">&nbsp;</li>
	</ul>
<?php
			break;
		}
	break;

//------------------------------------------------->
// ARTICULOS
//------------------------------------------------->
	case $dydSectionArticles[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathArti; ?>"> 			<li><?php echo $iconArti; ?></li></a>
		<a href="<?php echo $pathArti; ?>conditions/">	<li><?php echo $iconCond; ?></li></a>
		<a href="<?php echo $pathArti; ?>alignments/"> <li><?php echo $iconAlig; ?></li></a>
		<a href="<?php echo $pathArti; ?>deities/">	<li><?php echo $iconDeit; ?></li></a>
		<a href="<?php echo $pathArti; ?>languages/"> 	<li><?php echo $iconLang; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul>
		<li class="emptyTopCell">&nbsp;</li>
	</ul>
<?php
			break;
		}
	break;

//------------------------------------------------->
// AVENTURAS
//------------------------------------------------->
	case $dydSectionAdventures[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathAdve; ?>erarasa/"><li><?php echo $iconRasa; ?></li></a>
		<a href="<?php echo $pathAdve; ?>casusbelli/"><li><?php echo $iconBeli; ?></li></a>
		<a href="<?php echo $pathAdve; ?>parvumiter/"><li><?php echo $iconViae; ?></li></a>
		<a href="<?php echo $pathAdve; ?>tales/"><li><?php echo $iconTale; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">

	<?php if ($instancePlayers !== "" || $newInstanceLoot !== "" || $newInstanceMobs !== "" || count($instanceLocationArray) > 0) { ?>
		<li><a href="#info">Información</a></li>
	<?php } ?>
	<?php if ($instancePlayers !== "") { ?>
		<li><a href="#players">Personajes</a></li>
	<?php } ?>
	<?php if ($newInstanceLoot !== "") { ?>
		<li><a href="#loot">Tesoros</a></li>
	<?php } ?>
	<?php if ($newInstanceMobs !== "") { ?>
		<li><a href="#creatures">Criaturas</a></li>
	<?php } ?>	
	<?php if (count($instanceLocationArray) > 0) { ?>
		<li><a href="#places">Lugares</a></li>
	<?php } ?>
	<?php if ($timelineRows > 0) { ?>
		<li><a href="#events">Eventos</a></li>
	<?php } ?>
	</ul>
<?php
			break;
		}
	break;

//------------------------------------------------->
// GRUPOS DE AVENTUREROS
//------------------------------------------------->
	case $dydSectionParties[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
<!-- -->
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
	<?php if ($partyMembers != "") { ?>
		<li><a href="#info">Información</a></li>
		<li><a href="#table">Estado</a></li>
	<?php } ?>
	</ul>
<?php
			break;
		}
	break;			

//------------------------------------------------->
// LUGARES
//------------------------------------------------->
	case $dydSectionMap[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
<!-- -->
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
	<?php if ($encRows > 0 || $instanceRows > 0 || $eventRows > 0 || $ostYtLink != "") { ?>
		<li><a href="#info">Información</a></li>
	<?php } ?>
	<?php if ($instanceRows > 0 || $encRows > 0) { ?>
		<li><a href="#adventures">Aventuras</a></li>
	<?php } ?>
	<?php if ($encRows > 0) { ?>
		<li><a href="#encounters">Encuentros</a></li>
	<?php } ?>
	<?php if ($eventRows > 0) { ?>
		<li><a href="#events">Eventos</a></li>
	<?php } ?>
	<?php if ($ostYtLink != "") { ?>
		<li style="width:88px;"><a href="#music">Banda sonora</a></li>
	<?php } ?>
	</ul>
<?php
			break;
		}
	break;		

//------------------------------------------------->
// EVENTOS
//------------------------------------------------->
	case $dydSectionTimeline[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathTmLn; ?>friendship/"><li><?php echo $iconTmFr; ?></li></a>		
		<a href="<?php echo $pathTmLn; ?>love/"><li><?php echo $iconTmRo; ?></li></a>
		<a href="<?php echo $pathTmLn; ?>birth/"><li><?php echo $iconTmBi; ?></li></a>		
		<a href="<?php echo $pathTmLn; ?>travel/"><li><?php echo $iconTmTr; ?></li></a>
		<a href="<?php echo $pathTmLn; ?>treasure/"><li><?php echo $iconTmTs; ?></li></a>		
		<a href="<?php echo $pathTmLn; ?>foundation/"><li><?php echo $iconTmFo; ?></li></a>
		<a href="<?php echo $pathTmLn; ?>event/"><li><?php echo $iconTmEv; ?></li></a>		
		<a href="<?php echo $pathTmLn; ?>enmity/"><li><?php echo $iconTmEn; ?></li></a>
		<a href="<?php echo $pathTmLn; ?>battle/"><li><?php echo $iconTmBa; ?></li></a>		
		<a href="<?php echo $pathTmLn; ?>death/"><li><?php echo $iconTmDe; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
	<?php if ($ostYtLink != "") { ?>
		<li><a href="#info">Información</a></li>
		<li style="width:88px;"><a href="#music">Banda sonora</a></li>
	<?php } ?>
	</ul>
<?php
			break;
		}
	break;

//------------------------------------------------->
// ACCIONES Y TIENDAS
//------------------------------------------------->
	case $dydSectionActions[0]:
	case $dydSectionShops[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
	<?php if ($shopItems !== "" && $shopRandom == 1) { ?>
		<li style="width:50px;"><a href="#main">Tienda</a></li>
		<li style="width:100px;"><a href="#list">Lista de objetos</a></li>
	<?php } ?>
	</ul>
<?php
			break;
		}
	break;

//------------------------------------------------->
// PERSONAJES NO JUGADORES
//------------------------------------------------->
	case $dydSectionNPC[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathNPCS; ?>erarasa/"><li><?php echo $iconRasa; ?></li></a>
		<a href="<?php echo $pathNPCS; ?>casusbelli/"><li><?php echo $iconBeli; ?></li></a>
		<a href="<?php echo $pathNPCS; ?>parvumiter/"><li><?php echo $iconViae; ?></li></a>
		<a href="<?php echo $pathNPCS; ?>others/"><li><?php echo $iconOtPJ; ?></li></a>
		<a href="<?php echo $pathNPCS; ?>past/"><li><?php echo $iconPast; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
	<?php if (count($npcCheckCreature) > 0 || $instanceRows > 0 || ($npcCheckMusic[0] ?? "") != "") { ?>
		<li class="active"><a href="#sheet">Estado</a></li>
	<?php } ?>
	<?php if (count($npcCheckCreature) > 0) { ?>
		<li><a href="#card">Tarjeta</a></li>
	<?php } ?>
	<?php if ($instanceRows > 0) { ?> 
		<li style="width:70px;"><a href="#adventures">Aventuras</a></li>
	<?php } ?>
	<?php if (($npcCheckMusic[0] ?? "") != "") { ?>
		<li style="width:88px;"><a href="#music">Banda sonora</a></li>
	<?php } ?>
	</ul>
<?php
			break;
		}
	break;

//------------------------------------------------->
// PERSONAJES JUGADORES
//------------------------------------------------->
	case $dydSectionPlayers[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathPlay; ?>erarasa/"><li><?php echo $iconRasa; ?></li></a>
		<a href="<?php echo $pathPlay; ?>casusbelli/"><li><?php echo $iconBeli; ?></li></a>
		<a href="<?php echo $pathPlay; ?>parvumiter/"><li><?php echo $iconViae; ?></li></a>
		<a href="<?php echo $pathPlay; ?>others/"><li><?php echo $iconOtPJ; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
	<?php if ($playerPowers != "" || $playerFeats != "" || $playerInventory != false || ($playerAdventures ?? 0) != 0 || $ostYtLink != "") { ?>
		<li class="active" style="width:54px;"><a href="#sheet">Estado</a></li>
	<?php } ?>
	<?php if ($playerInventory != false) { ?>
		<li style="width:54px;"><a href="#equipment">Equipo</a></li>
	<?php } ?>
	<?php if ($playerFeats != "") { ?>
		<li style="width:54px;"><a href="#feats">Dotes</a></li>
	<?php } ?>
	<?php if ($playerPowers != "") { ?>
		<li style="width:60px;"><a href="#powers">Poderes</a></li>
	<?php } ?>
	<?php if (($playerAdventures ?? 0) != 0) { ?>
		<li style="width:70px;"><a href="#adventures">Aventuras</a></li>
	<?php } ?>
	<?php if ($ostYtLink != "") { ?>
		<li style="width:88px;"><a href="#music">Banda sonora</a></li>
	<?php } ?>
	</ul>
<?php
			break;
		}
	break;

//------------------------------------------------->
// BESTIARIO
//------------------------------------------------->
	case $dydSectionBestiary[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
	<?php if ($famHasMonsters === true) { ?>
		<li><a href="#info"> Información</a></li>
		<li><a href="#monsters"> Bestiario</a></li>
	<?php } ?>
	</ul>
<?php
			break;
		}
	break;

	case $dydSectionCreatures[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathCrea; ?>enemies/"><li><?php echo $iconEnem; ?></li></a>
		<a href="<?php echo $pathCrea; ?>traps/"><li><?php echo $iconTrap; ?></li></a>
		<a href="<?php echo $pathCrea; ?>allies/"><li><?php echo $iconAlly; ?></li></a>
		<a href="<?php echo $pathCrea; ?>mounts/"><li><?php echo $iconMoun; ?></li></a>
		<a href="<?php echo $pathCrea; ?>familiars/"><li><?php echo $iconFami; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
	<?php if ($enemyLore != "" || $enemyPicture != "") { ?>
		<li><a href="#card"> Tarjeta</a></li>
	<?php } ?>
	<?php if ($enemyLore != "") { ?>
		<li><a href="#info"> Información</a></li>
	<?php } ?>
	<?php if ($enemyPicture != "") { ?>
		<li><a href="#pict"> Imagen</a></li>
	<?php } ?>
	</ul>
<?php
			break;
		}
	break;

	case $dydSectionEncounter[0]:
	case $dydSectionAilments[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
			break;
		}
	break;

	case $dydSectionRaces[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathRace; ?>canon/"><li><?php echo $iconCano; ?></li></a>
		<a href="<?php echo $pathRace; ?>homebrew/"><li><?php echo $iconHmbw; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
		<?php if ($powerRows != 0 || $featRows != 0) { ?>
			<li><a href="#info">Información</a></li>
			<li><a href="#powers">Facultades</a></li>
		<?php } ?>
		<?php if ($bgRows != 0) { ?>
			<li><a href="#backgrounds">Trasfondos</a></li>
		<?php } ?>
	</ul>
<?php
			break;
		}
	break;

	case $dydSectionClasses[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathClas; ?>heroic/"><li><?php echo $iconHero; ?></li></a>
		<a href="<?php echo $pathClas; ?>paragon/"><li><?php echo $iconPara; ?></li></a>
		<a href="<?php echo $pathClas; ?>epic/"><li><?php echo $iconEpic; ?></li></a>
        <a href="<?php echo $pathClas; ?>themes/"><li><?php echo $iconThem; ?></li></a>
		<a href="<?php echo $pathClas; ?>essentials/"><li><?php echo $iconEsse; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
		<?php if ($classStats != "" || $powerRows != 0 || $featRows != 0) { ?>
			<li><a href="#info">Información</a></li>
		<?php } ?>
		<?php if ($powerRows != 0 || $featRows != 0) { ?>
			<li><a href="#powers">Facultades</a></li>
		<?php } ?>
		<?php if ($classStats != "") { ?><li><a href="#races">Razas</a></li><?php } ?>
	</ul>
<?php
			break;
		}
	break;

	// Diseños de personaje
	case $dydSectionBuilds[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathBuil; ?>arcane/"><li><?php echo $iconArca; ?></li></a>
		<a href="<?php echo $pathBuil; ?>martial/"><li><?php echo $iconMart; ?></li></a>
		<a href="<?php echo $pathBuil; ?>divine/"><li><?php echo $iconDivn; ?></li></a>
		<a href="<?php echo $pathBuil; ?>primal/"><li><?php echo $iconPrim; ?></li></a>
		<a href="<?php echo $pathBuil; ?>psionic/"><li><?php echo $iconPsio; ?></li></a>
		<a href="<?php echo $pathBuil; ?>shadow/"><li><?php echo $iconSomb; ?></li></a>
		<a href="<?php echo $pathBuil; ?>others/"><li><?php echo $iconOthe; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
				if ($powerLink != "") {
?>
	<ul class="powerClassLink">
		<li><?php echo $powerLink; ?></li>
	</ul>
<?php
				}
			break;
		}
	break;

	case $dydSectionTraits[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;?>
	<ul>
		<a href="<?php echo $pathTrai; ?>race/"><li><?php echo $iconRaci; ?></li></a>
		<a href="<?php echo $pathTrai; ?>class/"><li><?php echo $iconHero; ?></li></a>
		<a href="<?php echo $pathTrai; ?>paragon/"><li><?php echo $iconPara; ?></li></a>
		<a href="<?php echo $pathTrai; ?>epic/"><li><?php echo $iconEpic; ?></li></a>
		<a href="<?php echo $pathTrai; ?>theme/"><li><?php echo $iconThem; ?></li></a>
		<a href="<?php echo $pathTrai; ?>essentials/"><li><?php echo $iconEsse; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
				if ($powerLink != "") {
?>
	<ul class="powerClassLink">
		<li><?php echo $powerLink; ?></li>
	</ul>
<?php
				}
			break;
		}
	break;

	case $dydSectionBackgrounds[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<li><a href="<?php echo $pathBack; ?>origins/"><?php echo $iconOrig; ?></a></li>
		<li><a href="<?php echo $pathBack; ?>racial/"><?php echo $iconRaci; ?></a></li>
		<li><a href="<?php echo $pathBack; ?>occupation/"><?php echo $iconOccu; ?></a></li>
		<li><a href="<?php echo $pathBack; ?>society/"><?php echo $iconSoci; ?></a></li>
		<li><a href="<?php echo $pathBack; ?>campaign/"><?php echo $iconCamp; ?></a></li>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
				if ($powerLink != "") {
?>
	<ul class="powerClassLink">
		<li><?php echo $powerLink; ?></li>
	</ul>
<?php
				}
			break;
		}
	break;

	case $dydSectionPowers[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<li><a href="<?php echo $pathPowe; ?>atwill/"><?php echo $iconAtwl; ?></a></li>
		<li><a href="<?php echo $pathPowe; ?>encounter/"><?php echo $iconEnco; ?></a></li>
		<li><a href="<?php echo $pathPowe; ?>daily/"><?php echo $iconDail; ?></a></li>
		<li><a href="<?php echo $pathPowe; ?>utility/"><?php echo $iconUtil; ?></a></li>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
				if ($powerLink != "") {
?>
	<ul class="powerClassLink">
		<li><?php echo $powerLink; ?></li>
	</ul>
<?php
				}
			break;
	}
	break;

	case $dydSectionFeats[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathFeat; ?>general/"><li><?php echo $iconGefe; ?></li></a>
		<a href="<?php echo $pathFeat; ?>racial/"><li><?php echo $iconRaci; ?></li></a>
		<a href="<?php echo $pathFeat; ?>class/"><li><?php echo $iconClas; ?></li></a>
		<a href="<?php echo $pathFeat; ?>multiclass/"><li><?php echo $iconMcla; ?></li></a>
		<a href="<?php echo $pathFeat; ?>divine/"><li><?php echo $iconDivi; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
				if ($powerLink != "") {
?>
	<ul class="powerClassLink">
		<li><?php echo $powerLink; ?></li>
	</ul>
<?php
				}
			break;
	}
	break;

// ENCANTAMIENTO
	case $dydSectionEnchants[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathEnch; ?>consumables/"><li><?php echo $iconCons; ?></li></a>
		<a href="<?php echo $pathEnch; ?>weapons/"><li><?php echo $iconWeap; ?></li></a>
		<a href="<?php echo $pathEnch; ?>armors/"><li><?php echo $iconArmr; ?></li></a>
		<a href="<?php echo $pathEnch; ?>implements/"><li><?php echo $iconImpl; ?></li></a>
		<a href="<?php echo $pathEnch; ?>trinkets/"><li><?php echo $iconTrin; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
			break;
		}
	break;

// RITUALES
	case $dydSectionRituals[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathRitu; ?>adivination/"><li><?php echo $iconAdiv; ?></li></a>
		<a href="<?php echo $pathRitu; ?>creation/"><li><?php echo $iconCret; ?></li></a>
		<a href="<?php echo $pathRitu; ?>deception/"><li><?php echo $iconDece; ?></li></a>
		<a href="<?php echo $pathRitu; ?>scrying/"><li><?php echo $iconScry; ?></li></a>
        <a href="<?php echo $pathRitu; ?>exploration/"><li><?php echo $iconExpl; ?></li></a>
		<a href="<?php echo $pathRitu; ?>binding/"><li><?php echo $iconBind; ?></li></a>
		<a href="<?php echo $pathRitu; ?>warding/"><li><?php echo $iconWard; ?></li></a>
		<a href="<?php echo $pathRitu; ?>restoration/"><li><?php echo $iconRest; ?></li></a>
		<a href="<?php echo $pathRitu; ?>travel/"><li><?php echo $iconTrav; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
			break;
		}
	break;

	case $dydSectionItems[0]:
	case $dydSectionVehicles[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathItem; ?>"><li><?php echo $iconItem; ?></li></a>
		<a href="<?php echo $pathItem; ?>weapons/"><li><?php echo $iconWeap; ?></li></a>
		<a href="<?php echo $pathItem; ?>armors/"><li><?php echo $iconArmr; ?></li></a>
		<a href="<?php echo $pathVehi; ?>"><li><?php echo $iconShip; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
	<?php if ($thingPicture != "") { ?>
		<li><a href="#card"> Tarjeta</a></li>
		<li><a href="#pict"> Imagen</a></li>
	<?php } ?>
	</ul>
<?php
			break;
		}
	break;

	case $dydSectionMagicItems[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pathMagi; ?>consumables/"><li><?php echo $iconCons; ?></li></a>
		<a href="<?php echo $pathMagi; ?>weapons/"><li><?php echo $iconWeap; ?></li></a>
		<a href="<?php echo $pathMagi; ?>armors/"><li><?php echo $iconArmr; ?></li></a>
		<a href="<?php echo $pathMagi; ?>implements/"><li><?php echo $iconImpl; ?></li></a>
		<a href="<?php echo $pathMagi; ?>trinkets/"><li><?php echo $iconTrin; ?></li></a>
		<a href="<?php echo $pathMagi; ?>wonders/"><li><?php echo $iconWond; ?></li></a>
		<a href="<?php echo $pathMagi; ?>alternative/"><li><?php echo $iconBoon; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
	<?php if ($itemPicture != "") { ?>
		<li><a href="#card"> Tarjeta</a></li>
		<li><a href="#pict"> Imagen</a></li>
	<?php } ?>
	</ul>
<?php
			break;
		}
	break;

// =============================================================================================== >
// Pokémon
// =============================================================================================== >
	// Granjas de crianza
	case $pkmnBreed[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
?>
	<ul>
		<a href="<?php echo $pkmnBreedPath; ?>females/"><li><?php echo $iconPoke["fem"]; ?></li></a>
		<a href="<?php echo $pkmnBreedPath; ?>males/"><li><?php echo $iconPoke["mal"]; ?></li></a>
		<a href="<?php echo $pkmnBreedPath; ?>show/"><li><?php echo $iconPoke["shw"]; ?></li></a>
		<a href="<?php echo $pkmnBreedPath; ?>trade/"><li><?php echo $iconPoke["trd"]; ?></li></a>
	</ul>
<?php
			break;
			default:
				$showBackButton = 0;
?>
	<ul class="textNoIcon">
	<?php if ($thingPicture != "") { ?>
		<li><a href="#card"> Tarjeta</a></li>
		<li><a href="#pict"> Imagen</a></li>
	<?php } ?>
	</ul>
<?php
			break;
		}
	break;

	// Listas de diseños
	case $pkmnBuilds[0]:
	case $pkmnPals[0]:
		switch($page) {
			case 0:
				$showBackButton = 1;
			break;
			default:
				$showBackButton = 0;
			break;
		}
	break;

	default:
		$showBackButton = 1;
?>
<ul>
	<li class="emptyTopCell">&nbsp;</li>
</ul>
<?php
	break;
}

// =============================================================================================== >
if ($playerID > 0) { 
	$idFav = $playerID;
} else {
	$idFav = $idGetData;
}
$backSection   = $pageRoot.$section."/".$type;
$backPkSection = $pkmnRoot.$section."/".$type;

// Seccion favorito
if ($page != 0 && ($adZone ?? "dnd") == "dnd") {
	$sectionName   = str_replace(":: ", "", (string)$pageTitle2);
	$favoriteName  = str_replace(":: ", "", (string)$pageTitle3);
	$favoriteCheck = $section."-".$idFav."-".$favoriteName;
	include_once("content/user/fav_check.php");
	$inFavs = $inFavs ?? "";
	switch ($inFavs) {
		case FALSE:
			$iconForFav = $stIcon;
			$iconFavTxt = "Añadir a favoritos";
			$favValue   = "add|".$favoriteCheck;
		break;
		default:
			$iconForFav = $dlIcon;
			$iconFavTxt = "Quitar favorito";
			$favValue   = "del|".$favoriteCheck;
		break;
	}
}

// Link de Twitter
$linkTwitter  = "https://twitter.com/intent/tweet?text=".urlencode($finalTitle).":&url=".$pageURL."&via=".$twitterUser;
?>
<!-- Fin de Comprobación de Secciones -->
<?php if ($showBackButton == 0 && $mainWork != false) { ?>
	<div class="returnBack">
		<!-- Dungeons & Dragons -->
		<?php if (($adZone ?? "dnd") == "dnd") { ?>
			<?php if ($tabTitle == "") { ?>
				<!-- Regresar -->
				<a href="<?php echo $backSection.$returnBackSection; ?>"><img src="<?php echo $bkIcon; ?>" alt="Regresar" /></a>
			<?php } ?>
			<!-- Favorito -->
			<?php if (isset($mainUserName)) { ?>
			<?php if (($userLevel ?? 0) >= 0) { ?>
			<form method="post" name="fav-form" action="<?php echo $pageRoot; ?>content/user/add_fav.php">
				<input type="hidden" name="userName" value="<?php echo $mainUserName; ?>" />
				<input type="hidden" name="favLink" value="<?php echo $favValue ?? ''; ?>" />
				<input type="hidden" name="userFavs" value="<?php echo $userFav ?? ''; ?>" />
				<input type="hidden" name="favUrl" value="<?php echo $backSection.$page."/"; ?>" />
				<a href="#" onClick="document.forms['fav-form'].submit();">
					<img src="<?php echo $iconForFav ?? $stIcon; ?>" alt="<?php echo $iconFavTxt ?? 'Favorito'; ?>" />
				</a>
			</form>
			<?php } ?>
			<?php } ?>
		<?php } ?>

		<!-- Pokémon -->
		<?php if(isset($_SESSION['name']) && ($adZone ?? "") == "pkmn") { ?> 
			<?php if (($_SESSION['level'] ?? 0) > 3) { ?>
			<form method="post" name="delpkmn-form" action="<?php echo $pageRoot; ?>content/user/add_pokemon.php">
				<input type="hidden" name="pkmnID" value="<?php echo $build_ID; ?>" />
				<input type="hidden" name="pkmnURL" value="<?php echo $backPkSection; ?>" />
				<a href="#" onClick="document.forms['delpkmn-form'].submit();">
					<img src="<?php echo $tbIcon; ?>" alt="Borrar PKMN" />
				</a> 
			</form>
			<?php } ?>
		<?php } ?>

		<!-- Facebook -->
		<a href="<?php echo $linkFacebook; ?>" target="_blank"><img src="<?php echo $fbIcon; ?>" alt="Facebook" /></a>
		<!-- Twitter -->
		<a href="<?php echo $linkTwitter; ?>" target="_blank"><img src="<?php echo $twIcon; ?>" alt="Twitter" /></a>
		<!-- Google+ -->
		<a href="<?php echo $linkGplus; ?>" target="_blank"><img src="<?php echo $gpIcon; ?>" alt="Google+" /></a>
	</div>
<?php } ?>

<!-- Pestañas de localización -->
<?php 
	include("main_loctabs.php");
?>
