<?php
	// Comprobamos si la sesión está activada
	if (isset($mainUserName)) {
	// ------------------------------------ //
	// Preparación de la tabla de favoritos
	$orderData ="SELECT favorites FROM ".$tableUsers." WHERE ".$mainUserNameRow." LIKE '".$mainUserName."' LIMIT 1;"; // Elegimos el Usuario
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
		if ($rowsData != "") {
			$dataResult = mysql_fetch_array($queryData); // Recolecta de datos.
			$userFav = $dataResult["favorites"];		 // Favoritos.
			// Chequeamos que no esté en favoritos nuestro link
			$favCheck = strpos($userFav,$favoriteCheck);
			if ($favCheck != FALSE) {
				//echo "Cadena encontrada";
				$inFavs = TRUE;
			} else {
				$inFavs = FALSE;
			}
		}
	}
?>