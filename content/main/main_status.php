<?php
	// Localización para pestañas
	include_once("content/sections/contents_tabs.php");	
	$dataCountN = 0;
?>

<h3>Estado de la base de datos</h3>
<table class="statusTable">
	<thead>
		<th>Sección</th>
		<th>Entradas</th>
		<th>Oficiales</th>
		<th>Homebrew</th>
	</thead>
	<!-- ============== -->
	<!-- SECCIÓN BIBLIOGRAFIA -->
	<?php // Bibliografía
		$dataTable = $dydTableBibliography;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot."bibliography"."/"; ?>" target="_blank">Bibliografía</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN BIBLIOGRAFIA -->
	<!-- ============== -->
	<!-- SECCIÓN ARTÍCULOS -->
	<?php	// Artículos
		$dataTable = $dydTableArticles;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot.$dataTable."/"; ?>" target="_blank">Artículos</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN ARTÍCULOS -->
	<!-- ============== -->
	<!-- SECCIÓN AFLICCIONES -->
	<?php // Aflicciones
		$dataTable = $dydTableAilments;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot."ailments"."/"; ?>" target="_blank">Aflicciones</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN AFLICCIONES -->
	<!-- ============== -->
	<!-- SECCIÓN RAZAS -->
	<?php	// Razas
		$dataTable = $dydTableRaces;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot.$dataTable."/"; ?>" target="_blank">Razas</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN RAZAS -->
	<!-- ============== -->
	<!-- SECCIÓN CLASES -->
	<?php	// Clases
		$dataTable = $dydTableClasses;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot.$dataTable."/"; ?>" target="_blank">Opciones de clase</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN CLASES -->
	<!-- ============== -->
	<!-- SECCIÓN TRASFONDOS -->
	<?php	// Trasfondos
		$dataTable = $dydTableBackgrounds;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot.$dataTable."/"; ?>" target="_blank">Trasfondos</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN TRASFONDOS -->
	<!-- ============== -->
	<!-- SECCIÓN PODERES -->
	<?php // Poderes
		$dataTable = $dydTablePowers;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot.$dataTable."/"; ?>" target="_blank">Poderes</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN PODERES -->
	<!-- ============== -->
	<!-- SECCIÓN DOTES -->
	<?php // Dotes
		$dataTable = $dydTableFeats;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot.$dataTable."/"; ?>" target="_blank">Dotes</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN DOTES -->
	<!-- ============== -->
	<!-- SECCIÓN RITUALES -->
	<?php // Rituales
		$dataTable = $dydTableRituals;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot.$dataTable."/"; ?>" target="_blank">Rituales</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN RITUALES -->
	<!-- ============== -->
	<!-- SECCIÓN OBJETOS -->
	<?php // Objetos
		$dataTable = $dydTableItems;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot."items"."/"; ?>" target="_blank">Equipo</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN OBJETOS -->
	<!-- ============== -->
	<!-- SECCIÓN OBJETOS MÁGICOS -->
	<?php // Objetos magicos
		$dataTable = $dydTableMagicItems;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot."magic"."/"; ?>" target="_blank">Objetos mágicos</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN OBJETOS MÁGICOS -->
	<!-- ============== -->
	<!-- SECCIÓN VEHÍCULOS -->
	<?php // Vehículos
		$dataTable = $dydTableVehicles;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot."vehicles"."/"; ?>" target="_blank">Vehículos</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN VEHÍCULOS -->
	<!-- ============== -->
	<!-- SECCIÓN CRIATURAS -->
	<?php // Criaturas
		$dataTable = $dydTableCreatures;
		include("main_status_op.php");
	?> 
	<tr>
		<td><a href="<?php echo $pageRoot."bestiary"."/"; ?>" target="_blank">Criaturas</a></td>
		<td><?php echo $rowsData[0]; ?></td>
		<td><?php echo $rowsData[1]; ?></td>
		<td><?php echo $rowsData[2]; ?></td>
	</tr>
	<!-- SECCIÓN BESTIARIO -->
	<!-- SECCION FINAL -->
	<tr>
		<td>Totales:</td>
		<td><?php echo $dataCountN; ?></td>
		<td></td>
		<td></td>
	</tr>
</table>
