<?php
	$famID = $monsterID; // Cogemos datos del GET "page"
	$famOrder ="SELECT * FROM ".$dydTableCreatures." WHERE book LIKE '".$famID."';"; // Elegimos la Familia de monstruos en la Base de Datos
	$famQuery = mysql_query ($famOrder, $link);
	$famRows = mysql_num_rows($famQuery);
	// Si hemos encontrado monstruos con este tipo de familia, los mostramos en una bonita tabla.
	if ($famRows > 0) { 
		$famHasMonsters = TRUE;
	}
?>