<?php
	$orderData ="SELECT * FROM ".$dydTableSkills." ORDER BY name"; // Elegimos la Raza en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	// ------------------------------------------------------------------ //
	if ($rowsData != 0) { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
	// Listado de Artículos; Texto que aparece si no se elige Hoja		  //
?>
<h3>Habilidades</h3>
	<div id="mainSectionList">
		<table id="skilltable">
			<thead>
				<th style="text-align:left;">Nombre</th>
				<th>Característica</th>
				<th>Origen</th>
			</thead>
			<tbody>
	<?php
					for($dt=0;$dt<$rowsData;$dt++) {
						$queryResult = mysql_fetch_array($queryData);
						$bibloName	 = $queryResult["name"];
						$bibloText	 = $queryResult["stat"];
						$dataListOrigin = $queryResult["origin"];
						$retrieveFrom = "origin";
						include ("retrieve_origin.php");
						echo "<tr>";
							echo "<td class='name'>".$bibloName."</td>";
							echo "<td>".$bibloText."</td>";
							echo "<td class='origin'>".$originName."</td>";
						echo "</tr>";
					}
	?>
			</tbody>
		</table>
	<br/>
	</div>
<?php } ?>