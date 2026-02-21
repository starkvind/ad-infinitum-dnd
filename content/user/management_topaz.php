<?php
	$topQuest  = "WHERE user LIKE '".$mainUserName."'";
	$orderData = "SELECT * FROM ".$tableTopaz." ".$topQuest." ORDER BY date"; // Elegimos las transacciones en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData  = mysql_num_rows($queryData);
	// ------------------------------------------------------------------ //
	// Localización para pestañas
		include_once("content/sections/contents_tabs.php");	
?>

<h3><?php echo $mainUserNick; ?>, tienes <?php echo $userPoints; ?> topacios del infinito</h3>
	<!-- TAB 1 - Comprobar los topacios que tenemos -->
	<div id="check" class="tab_content">
	<div id="mainSectionList">
		<table id="searchtable">
			<thead>
				<th>Fecha</th>
				<th>Valor</th>
				<th>Detalles</th>
				<th>Enlace</th>
			</thead>
			<tbody>
	<?php
	// Listado de topacios
	if ($rowsData != 0) { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		for($dt=0;$dt<$rowsData;$dt++) {
			$queryResult = mysql_fetch_array($queryData);
			$transDate	 = $queryResult["date"];
			$transAmount = $queryResult["amount"];
			$transText	 = $queryResult["infotext"];
			$transIDsect = $queryResult["idsection"];
			$transTBsect = $queryResult["section"];
			// ----> Preparamos secciones
			$fromTable = $transTBsect;
			include("content/main/main_searchtable.php");
			// ----> Mostramos los datos
				echo "<tr>";
					echo "<td>".$transDate."</td>";
					echo "<td>";
						if ($transAmount > 0) {
							echo "+";
						}
						echo $transAmount;
					echo "</td>";
					echo "<td>".$transText."</td>";
					// --->
					echo "<td><a href='".$pageRoot.$tableLink."/".$transIDsect."/' target='_blank'>".$tableName."</a></td>";
				echo "</tr>";
		}
	}
	?>
			</tbody>
		</table>
	<br/>
	</div>
	</div>
	<!-- TAB 2 - Gastar topacios en cosas -->
	<div id="spend" class="tab_content">
	<p>Cómo gastar tus topacios del infinito y no morir en el intento. ¡Esta sección aún no está finalizada!</p>
	</div>