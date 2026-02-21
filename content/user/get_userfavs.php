<?php
// Preparamos las llamadas a la base de datos.
	$userFavQuest = "WHERE ".$mainUserNameRow." LIKE '".$mainUserName."'";
	$userFavQuery = "SELECT favorites FROM ".$tableUsers." ".$userFavQuest."";
	$userFavIdQue = mysql_query($userFavQuery, $link);
	$favResult = mysql_fetch_array($userFavIdQue);
// $userFavorites tiene los datos que necesitamos.
	$userFavorites = $favResult["favorites"];
// Reventamos el array con | y contamos lo que hay.
	$userFavQty = explode("|", $userFavorites);
	$countFavs = count($userFavQty);
	$count2Fav = 0;
// Contamos cada parte del array a ver qué cojones es.
	for ($fvCnt=0;$fvCnt<$countFavs;$fvCnt++) {
		// Si no está vacío, le sumamos 1.
		if ($userFavQty[$fvCnt] != "") {
			$count2Fav = $count2Fav+1;
		}
	}
// Colocamos ya la cuenta:
	$userFavs = $count2Fav;
?>