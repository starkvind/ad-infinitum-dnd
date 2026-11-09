<?php
	if (filter_var($page ?? null, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) !== false) {
	// ================================================================== //
		echo "<div id='powerItemLayout'>";
			$vehicleId = $page; // Damos la id del Vehiculo.
			include ("vehicle_card.php");
			$pageTitle3 = $vehicleName;
		echo "</div>";
	// ================================================================== //
	echo "<br/>";
		// Localización para pestañas
		include_once("contents_tabs.php");
	} else {
		// ------------------------------------------------------------------ //
		echo "<h3>Listado de vehículos</h3>";
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydVehiclesFields." FROM ".$dydTableVehicles."";
			$dataSection	 = $dydSectionVehicles[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>