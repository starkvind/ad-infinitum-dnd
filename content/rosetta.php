<?php
	include_once(__DIR__ . "/mysql_compat.php");
	include_once(__DIR__ . "/stone.php"); // Archivo de configuracion	
	// Crear una funcion para conectar a la BDD de una buena 
	// vez en lugar de tener cada cosa diferente en el percal, por favor.
	switch ($stoneMode) {
		// Direccion de internet
		default:
			//$link = mysql_connect("localhost", "infinityuser", "d4n13lk0b0ld");
			//$link = mysql_connect("localhost", "u951814387_mav", "q27l7I4MQa");
			//$link = mysqli_connect("localhost", "starkvind", "b4nk41");
			$link = mysqli_connect("localhost", "starko_remote", "b4n4n4");
			if(!$link) { die(); }
			//$bdd = "u951814387_dnddb";
			$bdd = "DB2243630";
		break;
		// Direcciones de casa
		case 2:
			$link = mysqli_connect("localhost", "starko_remote", "b4n4n4");
			if(!$link) { die(); }
			$bdd = "DB2243630";
		break;
	}

	if ($link instanceof mysqli) {
		$GLOBALS['__mysql_compat_link'] = $link;
		mysqli_set_charset($link, "utf8mb4");
	}
?>
