<?php
	// Preparamos las variables
	$dataFav = $_POST["favLink"];
	$dataUserName = $_POST["userName"];
	$dataUserFav = $_POST["userFavs"];
	$dataReturn = $_POST["favUrl"];
	// Vamos a ver qué queremos hacer
	$whatDoFav = explode("|", $dataFav);
	if ($whatDoFav[1] != "") {
		switch($whatDoFav[0]) {
			// Añadir favorito
			case "add":
				$lastFav = $dataUserFav.$whatDoFav[1]."|";
			break;
			// Borrar favorito
			case "del":
				$lastFav = str_replace($whatDoFav[1]."|", "", $dataUserFav);
			break;
		}
		// Seleccionamos la base de datos
		include("../rosetta.php");
		mysql_select_db($bdd, $link); 
		// Modificamos los valores en la BDD
		mysql_query("UPDATE ".$tableUsers." SET favorites = '".$lastFav."' WHERE ".$mainUserNameRow." LIKE '".$dataUserName."'",$link);
	}
	// Regresamos a la página
	header("Location: ".$dataReturn."");
?>