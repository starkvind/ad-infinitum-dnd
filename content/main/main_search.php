<div id="mainSectionList">
<h3>Búsqueda</h3>
<?php
	// Limpiamos el asunto de mierda
	array_walk($_POST, 'limpiarCadena');
	$searchQuery = $_POST["query"];	// Detalle de búsqueda
	if ($searchQuery != "") {
	// Localización para pestañas
		include_once("content/sections/contents_tabs.php");	
		// Preparamos la búsqueda
		$selectField = "id, name, origin";
		$query = mysql_real_escape_string($searchQuery);
		// ----------------------------->
		// ¡LA REALIZAMOS!
		$searchSQL = "
		select 'Articles' OriginatingTable, $selectField
		from ".$dydTableArticles."
		where name like '%".$query."%'
		union all
		select 'Actions', $selectField
		from ".$dydTableActions."
		where name like '%".$query."%'
		union all
		select 'Ailments', $selectField
		from ".$dydTableAilments."
		where name like '%".$query."%'
		union all
		select 'Parties', $selectField
		from ".$dydTableParties."
		where name like '%".$query."%'
		union all
		select 'Locations', $selectField
		from ".$dydTableMap."
		where name like '%".$query."%'
		union all		
		select 'Events', $selectField
		from ".$dydTableTimeline."
		where name like '%".$query."%'
		union all
		select 'Races', $selectField
		from ".$dydTableRaces."
		where name like '%".$query."%'
		union all
		select 'Classes', $selectField
		from ".$dydTableClasses."
		where name like '%".$query."%'
		union all
		select 'Traits', $selectField
		from ".$dydTableTraits."
		where name like '%".$query."%'
		union all
		select 'Backgrounds', $selectField
		from ".$dydTableBackgrounds."
		where name like '%".$query."%'
		union all
		select 'Players', $selectField
		from ".$dydTablePlayers."
		where name like '%".$query."%'
		union all
		select 'Npcs', $selectField
		from ".$dydTableNPC."
		where name like '%".$query."%'
		union all
		select 'Powers', $selectField
		from ".$dydTablePowers."
		where name like '%".$query."%'
		union all
		select 'Feats', $selectField
		from ".$dydTableFeats."
		where name like '%".$query."%'
		union all
		select 'Things', $selectField
		from ".$dydTableItems."
		where name like '%".$query."%'
		union all
		select 'Vehicles', $selectField
		from ".$dydTableVehicles."
		where name like '%".$query."%'
		union all
		select 'Instances', $selectField
		from ".$dydTableAdventures."
		where name like '%".$query."%'
		union all
		select 'Items', $selectField
		from ".$dydTableMagicItems."
		where name like '%".$query."%'
		union all
		select 'Enchantments', $selectField
		from ".$dydTableEnchants."
		where name like '%".$query."%'
		union all
		select 'Rituals', $selectField
		from ".$dydTableRituals."
		where name like '%".$query."%'
		union all
		select 'Shops', $selectField
		from ".$dydTableShops."
		where name like '%".$query."%'
		union all
		select 'Encounters', $selectField
		from ".$dydTableEncounter."
		where name like '%".$query."%'
		union all
		select 'Book', $selectField
		from ".$dydTableBestiary."
		where name like '%".$query."%'
		union all
		select 'Enemies', $selectField
		from ".$dydTableCreatures."
		where name like '%".$query."%'
		";
		$query_for_result = mysql_query($searchSQL);
// -----------------------------> 
echo "<table id='searchtable'>";
	echo "<thead>";
		echo "<th style='text-align:left;'>Nombre</th>";
		echo "<th style='width:150px;'>Sección</th>";
		echo "<th>Origen</th>";
	echo "</thead>";
	echo "<tbody>";
	while($data_fetch=mysql_fetch_array($query_for_result)) {
	// Colocamos nombre de la tabla Original y su enlace
	$fromTable = $data_fetch["OriginatingTable"];
	include("main_searchtable.php");
	// Definimos el origen
	$retrieveFrom = "origin";
	$dataListOrigin = $data_fetch["origin"];
	include("content/sections/retrieve_origin.php");
	echo "<tr>";
		// Nombre
		echo "<td class='name'><a href='".$pageRoot.$tableLink."/".$data_fetch["id"]."/' target='_blank'>".substr($data_fetch["name"], 0,160)."</a></td>";
		// Sección
		echo "<td style='width:100px;'>".$tableName."</td>";
		// Origen
		echo "<td class='origin'>".$originName."</td>";
	echo "</tr>";
	}
	echo "</tbody>";
echo "</table>";
mysql_close();
	if ($mainUserName != "maverick") {
		// Añadir la búsqueda a nuestra BDD
		if ($mainUserName != "") {
			$userName	= $mainUserName;
		} else {
			$userName	= $_SERVER["REMOTE_ADDR"];
		}
		$userDate 	= date('y/m/d');
		$userTime 	= date('H:i:s');
		$userText	= $query;
		mysql_select_db($bdd, $link);	// Seleccionamos la base de datos
		mysql_query("INSERT INTO ".$tableSearches." (name,date,time,text) VALUES ('".$userName."', '".$userDate."', '".$userTime."', '".$userText."')",$link);
	}
	} else {
?>
<div class="searchBodyForm">
	<form method="post" action="<?php echo $pageRoot; ?>search/">
		<input type="text" name="query" class="searchInput" />
	</form>
</div>
<?php 
	}
?>
</div>
