<?php
	// Preparamos las variables de dinero.
	$playerDiamonds 	= 0;	// Diamantes astrales.
	$playerPlatinums 	= 0;	// Monedas de platino.
	$playerGolds 		= 0;	// Monedas de oro.
	$playerSilvers 		= 0;	// Monedas de plata.
	$playerCoppers 		= 0;	// Monedas de cobre.
	$playerResiduum		= 0;	// Residuum
	// Realizamos las peticiones a la base de datos.
	$goldData ="SELECT * FROM ".$dydTablePlayerGold." WHERE player_url LIKE '".$playerURL."';"; // Elegimos el Objeto en la Base de Datos
	$queryGold = mysql_query ($goldData, $link);
	$goldRows = mysql_num_rows($queryGold);
	// Si el personaje tiene transacciones, mostrarlas.
	if ($goldRows != "") {
		for ($gr=0;$gr<$goldRows;$gr++) {
			$goldDataResult 	= mysql_fetch_array($queryGold); // Recolectamos datos de transacción.
			// Preparamos las variables.
			$transDiamonds 		= $goldDataResult["diamonds"]; 	 // Diamantes astrales.
			$transPlatinums 	= $goldDataResult["platinum"]; 	 // Monedas de platino.
			$transGolds			= $goldDataResult["gold"]; 	 	 // Monedas de oro.
			$transSilvers		= $goldDataResult["silver"]; 	 // Monedas de plata.
			$transCoppers		= $goldDataResult["copper"]; 	 // Monedas de cobre.
			$transResiduum 		= $goldDataResult["residuum"]; 	 // Residuum.
			// Sumamos las variables de la petición a las variables básicas.
			$playerDiamonds 	= $playerDiamonds+$transDiamonds;
			$playerPlatinums 	= $playerPlatinums+$transPlatinums;
			$playerGolds 		= $playerGolds+$transGolds;
			$playerSilvers 		= $playerSilvers+$transSilvers;
			$playerCoppers 		= $playerCoppers+$transCoppers;
			$playerResiduum 	= $playerResiduum+$transResiduum;
		}
	}
?>