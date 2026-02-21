<?php
	$playerQuest = "WHERE uploader LIKE '".$mainUserName."'";
	$orderData ="SELECT name, url FROM ".$dydTablePlayers." ".$playerQuest.""; // Elegimos las transacciones en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	// ------------------------------------------------------------------ //
	// Localización para pestañas
		include_once("content/sections/contents_tabs.php");	
	// Iconos
		$iconDirectory = $pageRoot."media/icon/";
		$iconExtension = ".png";
		// Diamantes astrales
		$asdiImg = $iconDirectory."coin_ad".$iconExtension;
		// Monedas de platino
		$platImg = $iconDirectory."coin_platinum".$iconExtension;
		// Monedas de oro
		$goldImg = $iconDirectory."coin".$iconExtension;
		// Monedas de plata
		$silvImg = $iconDirectory."coin_silver".$iconExtension;
		// Monedas de cobre
		$coppImg = $iconDirectory."coin_copper".$iconExtension;
		// Monedas de cobre
		$resiImg = $iconDirectory."coin_residuum".$iconExtension;
		// Estilo de la mierda de la imagen
		$iconHeaderStyle = "border:0px;border-radius:0;padding:0px;margin:0 19px 4px 0;text-align:center;";
?>

<h3>Cartera de tus personajes</h3>
<!-- TAB 1 - Comprobar los oros que tenemos -->
<div id="mainSectionList">
	<table id="searchtable" class="playerWallet">
		<thead>
			<th style="width:80px;">Personaje</th>
			<th style="width:20px;"><img style="<?=$iconHeaderStyle;?>" title="Diamantes astrales" alt="Diamantes astrales" src="<?=$asdiImg;?>" /></th>
			<th style="width:20px;"><img style="<?=$iconHeaderStyle;?>" title="Monedas de platino" alt="Monedas de platino" src="<?=$platImg;?>" /></th>
			<th style="width:20px;"><img style="<?=$iconHeaderStyle;?>" title="Monedas de oro" alt="Monedas de oro" src="<?=$goldImg;?>" /></th>
			<th style="width:20px;"><img style="<?=$iconHeaderStyle;?>" title="Monedas de plata" alt="Monedas de plata" src="<?=$silvImg;?>" /></th>
			<th style="width:20px;"><img style="<?=$iconHeaderStyle;?>" title="Monedas de cobre" alt="Monedas de cobre" src="<?=$coppImg;?>" /></th>
			<th style="width:20px;"><img style="<?=$iconHeaderStyle;?>" title="Residuum" alt="Residuum" src="<?=$resiImg;?>" /></th>
			<th style="width:200px;">Detalles</th>
			<th style="width:100px;">Fecha</th>
		</thead>
		<tbody>
<?php
	// Listado de oros
	if ($rowsData != 0) { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		for($dt=0;$dt<$rowsData;$dt++) {
			$queryResult = mysql_fetch_array($queryData);
			$playerName	 = $queryResult["name"];
			$playerURL	 = $queryResult["url"];
			// ----------------------------->
				$goldQuest = "WHERE player_url LIKE '".$playerURL."'";
				$goldData ="SELECT * FROM ".$dydTablePlayerGold." ".$goldQuest.""; // Elegimos las transacciones en la Base de Datos
				$goldQuery = mysql_query ($goldData, $link);
				$goldRows = mysql_num_rows($goldQuery);
				if ($goldRows != 0) {
					for($gr=0;$gr<$goldRows;$gr++) {
						$goldResult = mysql_fetch_array($goldQuery);
						$transDiamonds = $goldResult["diamonds"];
						$transPlatinums = $goldResult["platinum"];
						$transGolds = $goldResult["gold"];
						$transSilvers = $goldResult["silver"];
						$transCoppers = $goldResult["copper"];
						$transResiduum = $goldResult["residuum"];
						$transDate = $goldResult["date"];
						$transInfo = $goldResult["infotext"];
					// ----> Mostramos los datos
						echo "<tr>";
							echo "<td style='text-align:left;padding-left:16px;'>".$playerName."</td>";
							echo "<td>".$transDiamonds."</td>";
							echo "<td>".$transPlatinums."</td>";
							echo "<td>".$transGolds."</td>";
							echo "<td>".$transSilvers."</td>";
							echo "<td>".$transCoppers."</td>";
							echo "<td>".$transResiduum."</td>";
							echo "<td>".$transInfo."</td>";
							echo "<td>".$transDate."</td>";
						echo "</tr>";						
					}
				}
		}
	}
?>
		</tbody>
	</table>
<br/>
</div>