<?php
	session_start();
	$backAdress = $_SERVER['HTTP_REFERER'];
 	include_once("../rosetta.php"); 	// Archivo de la base de datos
	mysql_select_db($bdd, $link); 			// Seleccionamos la base de datos
    // comprobamos que se haya iniciado la sesión
    if(isset($mainUserName)) {
        session_destroy();
        //header("Location: ../index.php");
		header("Location: ".$backAdress."");
    } else {
		header("Location: ".$backAdress."");
    }
?> 