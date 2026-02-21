<?php
//---------------------------------->
$usuariumName = $mainUserName;
$topaciumTables = array(
	$dydTableArticles,
	$dydTableAdventures,
	$dydTableRaces,
	$dydTableClasses,
	$dydTableBuilds,
	$dydTableTraits,
	$dydTablePowers,
	$dydTableFeats,
	$dydTableItems,
	$dydTableVehicles,
	$dydTableMagicItems,
	$dydTableEnchants,
	$dydTableRituals,
	$dydTableEncounter,
	$dydTableBestiary,
	$dydTableCreatures,
	"asistir"
);
for($ttb=0;$ttb<count($topaciumTables);$ttb++) {
	$topTable = $topaciumTables[$ttb];
	//---------------------------------->
	$topValues = "id, name, date";
	// Si la tabla no es "asistir", lo hacemos modo normal.
	if ($topTable != "asistir") {
		$topWhereOpti = "WHERE uploader LIKE '".$usuariumName."'";
		// ---------------------- //
		$topSearchThe = "SELECT ".$topValues." FROM ".$topTable." ".$topWhereOpti."";
		$topList 	= $topSearchThe;
		$topIdQuery	= mysql_query($topList, $link);
		$topRows	= mysql_num_rows($topIdQuery);
	} else {
	// Sin embargo, si es "asistir", estamos dando topacios por haber ido a las partidas. Tenemos que ir por otro lado.
		include_once("get_userplayers.php");
		$topWhereOpti = "WHERE id IN (".$instanceID.")";
		$topSearchThe = "SELECT ".$topValues." FROM ".$dydTableAdventures." ".$topWhereOpti."";
		$topList 	= $topSearchThe;
		$topIdQuery	= mysql_query($topList, $link);
		$topRows	= mysql_num_rows($topIdQuery);
	}
	if ($topRows != 0) {
		for($tpr=0;$tpr<$topRows;$tpr++) {
			$topQueryResult = mysql_fetch_array($topIdQuery);
			$topID	 = $topQueryResult["id"];
			$topName = $topQueryResult["name"];
			$topDate = $topQueryResult["date"];
			// Si la fecha no está ajustada, ponemos la de hoy.
			if ($topDate == "0000-00-00") { $topDate = date("2012/01/01"); }
		//---------------------------------->
		// Tipo de recompensas
			$greatRew 	= 16;
			$niceRew	= 8;
			$okayRew	= 4;
			$mehRew		= 2;
			$whyRew		= 1;
		// Preparar los datos.
		switch($topTable) {
			// Sesiones de juego
			case $dydTableAdventures:
				$topPhrase = "Arbitrar la sesión";
				$topQuanty = $niceRew;
			break;
			// Razas
			case $dydTableRaces:
				$topPhrase = "Añadir la raza";
				$topQuanty = $greatRew;			
			break;
			// Clases
			case $dydTableClasses:
				$topPhrase = "Añadir la clase";
				$topQuanty = $greatRew;	
			break;
			// Poderes
			case $dydTablePowers:
				$topPhrase = "Agregar el poder";
				$topQuanty = $whyRew;	
			break;
			// Dotes
			case $dydTableFeats:
				$topPhrase = "Agregar la dote";
				$topQuanty = $whyRew;	
			break;
			// Rasgos
			case $dydTableTraits:
				$topPhrase = "Subir el rasgo";
				$topQuanty = $whyRew;	
			break;
			// Diseños
			case $dydTableBuilds:
				$topPhrase = "Subir el diseño";
				$topQuanty = $whyRew;	
			break;
			// Rituales
			case $dydTableRituals:
				$topPhrase = "Añadir el ritual";
				$topQuanty = $whyRew;	
			break;
			// Encantamientos
			case $dydTableEnchants:
				$topPhrase = "Subir el encantamiento";
				$topQuanty = $whyRew;	
			break;
			// Objetos
			case $dydTableMagicItems:
			case $dydTableItems:
				$topPhrase = "Añadir el objeto";
				$topQuanty = $whyRew;	
			break;
			// Vehículos
			case $dydTableVehicles:
				$topPhrase = "Montar el vehículo";
				$topQuanty = $mehRew;	
			break;
			// Encuentros
			case $dydTableEncounter:
				$topPhrase = "Preparar el encuentro";
				$topQuanty = $mehRew;	
			break;
			// Bestiario
			case $dydTableBestiary:
				$topPhrase = "Añadir al bestiario el monstruo";
				$topQuanty = $okayRew;	
			break;
			// Criaturas
			case $dydTableCreatures:
				$topPhrase = "Subir la criatura";
				$topQuanty = $mehRew;	
			break;
			// Asistencia a sesiones
			case "asistir":
				$topPhrase = "Asistir a la sesión";
				$topQuanty = $whyRew;	
			break;
			// Por defecto
			default:
				$topPhrase = "Subir el artículo";
				$topQuanty = $whyRew;
			break;
		}
		//---------------------------------->
		// Comprobamos que los datos no estén ya.
		if ($topTable == "asistir") { 
			$newTopTable = $dydTableAdventures; 
		} else {
			$newTopTable = $topTable; 
		}
		$transSearchOptio = "WHERE user LIKE '".$usuariumName."' AND idsection LIKE '".$topID."' AND section LIKE '".$topTable."'";
		$transSearchTerms = "SELECT id FROM ".$tableTopaz." ".$transSearchOptio."";
		$transIDQuery	  = mysql_query($transSearchTerms, $link);
		$transRows		  = mysql_num_rows($transIDQuery);
		//---------------------------------->
		// Si los datos no están, los añadimos a la tabla de transacciones.
			if ($transRows == 0) {
				mysql_query("INSERT INTO ".$tableTopaz." (user,amount,infotext,auto,date,idsection,section) VALUES (
				'".$usuariumName."', 
				'".$topQuanty."', 
				'".$topPhrase." ".$topName.".',
				'0',
				'".$topDate."',
				'".$topID."',
				'".$topTable."'
				)",$link);
			}
		}
	}
}
?>