<?php
	// Preparamos las variables
	$pokeID = $_POST["pkmnID"];	// Número de ID de la sección
	$pokeURL = $_POST["pkmnURL"];// Dirección loca
	// Seleccionamos la base de datos
	include("../rosetta.php");
	mysql_select_db($bdd, $link); 
	// Modificamos los valores en la BDD
	mysql_query("UPDATE ".$pkmnTableBreed." SET available = 1 WHERE id LIKE '".$pokeID."'",$link);
	// Regresamos a la página
	header("Location: ".$pokeURL."");
?>