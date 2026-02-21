<?php
	// Comprobamos si la sesión está activada
	if (isset($mainUserName) AND $userLevel >= 0) {
	// ------------------------------------ //
	$pageTitle3 = "Favoritos";
	// Localización para pestañas
		include_once("content/sections/contents_tabs.php");	
?>
	<h3><?php echo $pageTitle3." de ".$mainUserNick; ?></h3>
<?php
	// Preparación de la tabla de favoritos
	$orderData ="SELECT favorites FROM ".$tableUsers." WHERE ".$mainUserNameRow." LIKE '".$mainUserName."' LIMIT 1;"; // Elegimos el Usuario
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
?>
<div id="mainSectionList">
<?php
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
?>
	<table id="searchtable">
		<thead>
			<th style="text-align:left;">Nombre</th>
			<th style="text-align:left;">Tipo</th>
			<!--<th style="text-align:center;">Eliminar</th> -->
		</thead>
		<tbody>
<?php 
	$dataResult = mysql_fetch_array($queryData); // Recolecta de datos.
	$favoritesBulk = $dataResult["favorites"];	 // Favoritos.
	// ------------------------------------- //
	$favSections = explode("|", $favoritesBulk);
	$countSects = count($favSections);
	for($fs=0;$fs<$countSects;$fs++) {
		$deleteFavorite = "del|".$favSections[$fs];
		$favoriteSection = explode("-", $favSections[$fs]);
		if ($favoriteSection[0] != "") {
			$checkSection = trim($favoriteSection[0]);
			include("fav_getsect.php");
		echo "<tr>";
			echo "<td class='name'>";
				echo "<a href='".$pageRoot.$favoriteSection[0]."/".$favoriteSection[1]."/'>";
				echo "".$favoriteSection[2]."";
				echo "</a>";
			echo "</td>";
			echo "<td class='name'>";
				echo $favSection;
			echo "</td>";
		/*	echo "<td>";
				echo $deleteFavorite;
			echo "</td>";*/
		echo "</tr>";
		}
	}
//<div class='userFavorite'> </div>
?>
		</tbody>
	</table>
<?php } ?>
</div>
<?php
	// Si no estamos registrados, no dejamos que nadie vea el contenido.
	} else {
		echo $phraseNoAuth;
	}
?>