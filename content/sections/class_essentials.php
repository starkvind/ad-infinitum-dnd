<?php
	// Selección de clases para Heroicas (subclases) y Essentials (clases básicas)
	switch($classTier) {
		// HEROICAS
		case 0:
			$essentialsClass ="SELECT id, name FROM ".$dydTableClasses." WHERE required LIKE '".$className."' AND tier LIKE 4;"; // Elegimos la Subclase en la Base de Datos
			$queryEss = mysql_query ($essentialsClass, $link);
			$rowsEss = mysql_num_rows($queryEss);
			if ($rowsEss != "") {
				echo "<li><b>Essentials:</b> ";
				for($sbc=0;$sbc<$rowsEss;$sbc++) {
					$essResult = mysql_fetch_array($queryEss); // Empezamos a recolectar los datos.
					// ---------------------------------------- //
					$essID = $essResult["id"];	// ID de la Clase.
					$essName = $essResult["name"];	// ID de la Clase.
					// ---------------------------------------- //
					echo "<a href='".$pageRoot."classes/".$essID."/'>".$essName."</a>";
					if ($sbc < $rowsEss-1) { echo ", "; } else { echo "."; }
				}
				echo "</li>";
			}
		break;
		// ESSENTIALS
		case 4:
			$essentialsClass ="SELECT id FROM ".$dydTableClasses." WHERE name LIKE '".$classRequired."' LIMIT 1;"; // Elegimos la Clase en la Base de Datos
			$queryEss = mysql_query ($essentialsClass, $link);
			$rowsEss = mysql_num_rows($queryEss);
			if ($rowsEss != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
				$essResult = mysql_fetch_array($queryEss); // Empezamos a recolectar los datos.
				// ---------------------------------------- //
				$essID = $essResult["id"];	// ID de la Clase.
				// ------------------------------------------------------------------ //
				$originClassLink = "<a href='".$pageRoot."classes/".$essID."/'>".$classRequired."</a>";
				// ------------------------------------------------------------------ //
				$subClassText = $originClassLink.". Puedes elegir poderes, dotes, sendas de parangón y destinos épicos que tengan la clase <b>".$classRequired."</b> como prerrequisito.";
			}
		break;
	}
?>